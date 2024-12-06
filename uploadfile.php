<?php


/* Pour le chargement de plusieurs fichiers contenus dans un répertoire
/* s'inspirer de l'aide : 
/* https://stackoverflow.com/questions/2704314/multiple-file-upload-in-php
*/
echo "<h1>Téléchargement des fichiers</h1>";
if(isset($_POST["submit"])) {
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
        // Mettre à jour la table "image" avec ce nouveau fichire

        } else {
        echo "<br>" . "Désolé, une erreur s'est produite au chargement des fichiers.";
        $erreurchargement = true;
        }
      }
    }
  // Maintenant que tout est dans upload nous pouvons charger les fichiers dans la table IMAGE
  chargementImage();
  afficheimageschargees();
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

  $tout = $result->fetch_array();

  echo "<h1>Liste des images en base</h1>";
    $numligne = 1;
    while($row = $result->fetch_assoc()) {
        $numligne = $numligne + 1;
            echo "<img style='border-radius: 10px; width:25%' src='" . "data:image/jpeg;base64," . base64_encode($row['imgphoto']) . "'/>";
            if ($numligne > $nombreColonnes) {
              echo "<br>";
              $numligne = 1;
            }
      }
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