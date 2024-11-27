<?php


/* Pour le chargement de plusieurs fichiers contenus dans un répertoire
/* s'inspirer de l'aide : 
/* https://stackoverflow.com/questions/2704314/multiple-file-upload-in-php
*/

if(isset($_POST["submit"])) {
// var_dump($_FILES);

  foreach ($_FILES['fileToUpload']['tmp_name'] as $key => $tmp_name)
    {
    $nameDestination = $_FILES['fileToUpload']['name'][$key];
    $nameTemp = $_FILES["fileToUpload"]["tmp_name"][$key];
    $target_dir = "uploads/";
    $target_file = $target_dir . $nameDestination;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    if (checkImageType($nameTemp) == true AND checkFichierExistant($target_file) == false)
      {
      if (move_uploaded_file($nameTemp, $target_file)) 
        {
        echo "<br>" . "L'image ". $nameDestination . " a été chargé.";
        } else {
        echo "<br>" . "Désolé, une erreur s'est produite au chargement du fichier.";
        }
      }
    }
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