<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr" xml:lang="fr">
<head>
	<title>Liste toutes les photos en base</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="css/tables.css" rel="stylesheet">
	<link href="css/main.css" rel="stylesheet">
</head>
<body>

<!-- Chargement du menu principal du site -->
<?php include 'menu_principal.html' ?>

<div class="container-fluid" >

    <div>
      <h1>Chargement des photos</h1>
    </div>

<?php


/* Pour le chargement de plusieurs fichiers contenus dans un répertoire
/* s'inspirer de l'aide : 
/* https://stackoverflow.com/questions/2704314/multiple-file-upload-in-php
*/
$con = mysqli_connect("localhost","root","","patchwork");

  if (!$con) {
      echo "Erreur : Impossible de se connecter à MySQL." . PHP_EOL;
      echo "Errno de débogage : " . mysqli_connect_errno() . PHP_EOL;
      echo "Erreur de débogage : " . mysqli_connect_error() . PHP_EOL;
      exit;
  }

if(isset($_POST["submit"])) {

  // On supprime tous les fichiers du répertoire uploads (ancien chargement)
  foreach (glob('uploads/*') as $file) {
    unlink($file);
  }

  echo "<h3>On supprime l'existant et on remplace</h3>";
  $sqlSuppImage = "DELETE FROM image";
  $sqlSuppCouleur = "DELETE FROM couleur";
  $sqlresultImage = $con->query($sqlSuppImage);
  $sqlresultCouleur = $con->query($sqlSuppCouleur);

  // On compte le nombre de fichiers sélectionnés à téléverser
  $nbrateleverser=count($_FILES['fileToUpload']['tmp_name']);

  foreach ($_FILES['fileToUpload']['tmp_name'] as $key => $tmp_name)
    {
    $nameDestination = $_FILES['fileToUpload']['name'][$key];
    $nameTemp = $_FILES["fileToUpload"]["tmp_name"][$key];
    $target_dir = "uploads/";
    $target_file = $target_dir . $nameDestination;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    if (checkImageType($nameTemp) == true AND checkFichierExistant($target_file) == false AND checkExtensionImage($imageFileType) == true)
      {
      if (move_uploaded_file($nameTemp, $target_file)) 
        {
        echo "<br>" . "L'image ". $nameDestination . " a été chargé.";
        } else {
        echo "<br>" . "Désolé, une erreur s'est produite au chargement des fichiers.";
        $erreurchargement = true;
        }
      }
    }
  // Maintenant que tout est dans upload nous pouvons charger les fichiers dans la table IMAGE
  chargementImage();
  // Afficher toutes les photos chargeés
  afficheimageschargees();
  // Calcul de la dominante pour chacune des photos chargées
  dominanteImage();
}

function hex2rgb($color) {
	$r = hexdec(substr($color,0,2));
    $g = hexdec(substr($color,2,2));
    $b = hexdec(substr($color,4,2));							 
							 
	$rgb = array($r, $g, $b);
   //return implode(",", $rgb); // returns the rgb values separated by commas
   return $rgb; // returns an array with the rgb values
    $r = hexdec($r); $g = hexdec($g); $b = hexdec($b);
    return array($r, $g, $b);
}

function RGB_to_HSV($r, $g, $b) {
  $r = max(0, min((int)$r, 255));
  $g = max(0, min((int)$g, 255));
  $b = max(0, min((int)$b, 255));
  $result = [];
  $min = min($r, $g, $b);
  $max = max($r, $g, $b);
  $delta_min_max = $max - $min;
  $result_h = 0;
  if     ($delta_min_max !== 0 && $max === $r && $g >= $b) $result_h = 60 * (($g - $b) / $delta_min_max) +   0;
  elseif ($delta_min_max !== 0 && $max === $r && $g <  $b) $result_h = 60 * (($g - $b) / $delta_min_max) + 360;
  elseif ($delta_min_max !== 0 && $max === $g            ) $result_h = 60 * (($b - $r) / $delta_min_max) + 120;
  elseif ($delta_min_max !== 0 && $max === $b            ) $result_h = 60 * (($r - $g) / $delta_min_max) + 240;
  $result_s = $max === 0 ? 0 : (1 - ($min / $max));
  $result_v = $max;
  $result[0] = (int)(round($result_h));
  $result[1] = (int)($result_s * 100);
  $result[2] = (int)($result_v / 2.55);
  return $result;
}

function dominanteImage() {
  include_once("colors.inc.php");
  $ex=new GetMostCommonColors();
  
  $con = mysqli_connect("localhost","root","","patchwork");
  
  // Check connection
  if (mysqli_connect_errno())
    {   echo "Failed to connect to MySQL: " . mysqli_connect_error();  }
  
  // parametres de recherche de dominates
  $num_results=6;
  $delta=24;
  $reduce_brightness=1;
  $reduce_gradients=1;
  
  echo "Debut calcul - Nombre max de dominante : " . $num_results;

  // Choix de la photo par son ID et r�cup�ration de son chemin et nom de la photo : nomImageTest
  $sql="Select idImage, nomImage, cheminImage from image";
  $result = $con->query($sql);

  while($row = $result->fetch_assoc()) {
    $nomImageTest=$row["cheminImage"]. "/" . $row["nomImage"];
		$idImageTest=$row["idImage"];

	// recherche des dominantes selon les parametres d�finits plus haut	
  echo "<br>";
  echo $nomImageTest, $num_results, $reduce_brightness, $reduce_gradients, $delta;
	$colors=$ex->Get_Color($nomImageTest, $num_results, $reduce_brightness, $reduce_gradients, $delta);
		
    foreach ( $colors as $hex => $count )
    {
      if ( $count > 0 )
      {
      //transformation en pourcentage plutot que des 0.11223 et r�duction a 2 chiffres apr�s la virgule
      $pourcentage=number_format($count*100,2,'.','');
      
      // Convertion du modele HEX en RGB D�cimal
      $colorRGB = hex2rgb($hex);
      // Convertion du modele RGB en HSL
      // $colorHSL = rgb_to_hsl($colorRGB[0],$colorRGB[1],$colorRGB[2]);

      // Converion du modele RGB en HSV
      $colorHSV = RGB_to_HSV($colorRGB[0],$colorRGB[1],$colorRGB[2]);

      //insertion en base des valeurs HEX (num_results) pour l'image choisi
      //$sql = "INSERT INTO couleur(extIdImage,hex, pourcentage, rrouge, gvert, bbleu, hteinte, ssaturation, lluminance) VALUES ($idImageTest,'$hex', $pourcentage, $colorRGB[0], $colorRGB[1],$colorRGB[2],$colorHSL[0],$colorHSL[1],$colorHSL[2])";

      $sql = "INSERT INTO couleur(extIdImage,hex, pourcentage, rrouge, gvert, bbleu, hteinte, ssaturation, lluminance) VALUES ($idImageTest,'$hex', $pourcentage, $colorRGB[0], $colorRGB[1],$colorRGB[2],$colorHSV[0],$colorHSV[1],$colorHSV[2])";
      
        if ($con->query($sql) === FALSE) {
        echo "Error: " . $sql . "<br>" . $con->error; }
      
      }
    }
  }

  $con->close();
  echo "Calcul termin� !!!";
}


function afficheimageschargees() {
  // Lecture dans la base des images, directement stokées en base et non pas des chemins.
  $con = mysqli_connect("localhost","root","","patchwork");

  if (!$con) {
      echo "Erreur : Impossible de se connecter à MySQL." . PHP_EOL;
      echo "Errno de débogage : " . mysqli_connect_errno() . PHP_EOL;
      echo "Erreur de débogage : " . mysqli_connect_error() . PHP_EOL;
      exit;
  }
  $sql="SELECT cheminImage,nomImage,imgphoto FROM image";
  $result = $con->query($sql);
  $nombreImages = $result->num_rows;
  $nombreColonnes = 4;

  echo "<h1>Liste des images en base</h1>";
  echo "<h2>Nombre d'images dans la base : " . $nombreImages . " </h2>";
  echo "<div>";
    $numligne = 0;
    while($row = $result->fetch_assoc()) {
        $numligne = $numligne + 1;
            echo "<img style='border-radius: 10px; width:25%' src='" . "data:image/jpeg;base64," . base64_encode($row['imgphoto']) . "'/>";
            if ($numligne > $nombreColonnes) {
              echo "<br>";
              $numligne = 0;
            }
      }
    echo "</div>";
  $con->close();
}

// Chargement des fichiers depuis le répertoire dans la table IMAGE
function chargementImage() {
  $con = mysqli_connect("localhost","root","","patchwork");

  if (!$con) {
      echo "Erreur : Impossible de se connecter à MySQL." . PHP_EOL;
      echo "Errno de débogage : " . mysqli_connect_errno() . PHP_EOL;
      echo "Erreur de débogage : " . mysqli_connect_error() . PHP_EOL;
      exit;
  }
  $dir = "./uploads/";

  echo "<h1>Chargement des fichiers en base</h1>";

  //  si le dossier pointe existe
  if (is_dir($dir)) {
    // si il contient quelque chose
    if ($dh = opendir($dir)) {

        // boucler tant que quelque chose est trouve
      while (($file = readdir($dh)) !== false) {
        // affiche le nom et le type si ce n'est pas un element du systeme
        if( $file != '.' && $file != '..' && preg_match('#\.(jpe?g|gif|png)$#i', $file)) {
          echo "Photo trouvée : " . $dir . $file . "<br>";
          $phototrouve = file_get_contents($dir . $file);
          $nomPhototrouve = $dir . $file;
          
          list($width, $height) = getimagesize($nomPhototrouve);
          if ($height > $width) {
            // Portrait
            $orientation = 1;
          }
          else {
            // Paysage
            $orientation = 0;
          }

          $sql="INSERT INTO image(cheminImage,nomImage,imgphoto,orientation) VALUES ('$dir','$file', " . "'" . addslashes($phototrouve) . "'" . ",$orientation)";
          if ($con->query($sql) === FALSE) {
            echo "Error: " . $sql . "<br>" . $con->error; }
          echo "Import de la photo" . $dir . $file . " terminée.<br> ";
          
        }
      }
        // on ferme la connection
        closedir($dh);
    }
  }
  $con->close();
}

// fonction pour déterminer si le fichier est une image
function checkImageType($nameTemp) {
  $check = getimagesize($nameTemp);
  if($check !== false) {
    echo "<br>" . "Le fichier est de type - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "<br>" . "Le fichier n'est pas une image.";
    $uploadOk = 0;
  }
  return $uploadOk;
}

// fonction qui valide que le fichier n'est pas déjà télécharger (meme nom dans le répertoire de dépot)
function checkFichierExistant($target_file) {
  $filexiste = false;
  if (file_exists($target_file)) {
    echo "<br>" . $target_file;
    echo "<br>" . "Désolé, le fichier image existe déjà sur le serveur.";
    $filexiste = true;
  }
  return $filexiste;
}

// fonction qui permet de ne télécharger que les fichiers images du type JPEG/JPG/GIF/PNG
function checkExtensionImage($imageFileType) {
  $ExtensionImage = true;
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
    echo "<br>" . "Désolé, seulement les images de type : JPG, JPEG, PNG & GIF sont autorisés.";
    $ExtensionImage = false;
  }
  return $ExtensionImage;
}

?>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

</body>
</html>