<?php


/* Pour le chargement de plusieurs fichiers contenus dans un répertoire
/* s'insspirer de l'aide : 
/* https://stackoverflow.com/questions/2704314/multiple-file-upload-in-php
*/

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "Le fichier est de type - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "Le fichier n'est pas une image.";
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  echo "Désolé, le fichier image existe déjà sur le serveur.";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 5120000) {
  echo "Désolé, la taille du fichier est trop importante (<5Mo)";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
  echo "Désolé, seulement les images de type : JPG, JPEG, PNG & GIF sont autorisés.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Erreur de chargement.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "L'image ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " a été chargé.";
  } else {
    echo "Désolé, une erreur s'est produite au chargement du fichier.";
  }
}
?>