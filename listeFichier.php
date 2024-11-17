<?php 

$con = mysqli_connect("localhost","root","","patchwork");

if (!$con) {
    echo "Erreur : Impossible de se connecter à MySQL." . PHP_EOL;
    echo "Errno de débogage : " . mysqli_connect_errno() . PHP_EOL;
    echo "Erreur de débogage : " . mysqli_connect_error() . PHP_EOL;
    exit;
}

$dir = "./images/";
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
				
				
				$sql="INSERT INTO image(cheminImage,nomImage,photo,orientation) VALUES ('$dir','$file', " . "'" . addslashes($phototrouve) . "'" . ",$orientation)";
				if ($con->query($sql) === FALSE) {
					echo "Error: " . $sql . "<br>" . $con->error; }
				echo "Import de la photo" . $dir . $file . " terminée." . "<br> ";
				
			}
		}
       // on ferme la connection
       closedir($dh);
   }
}

// Lecture dans la base des images, directement stokées en base et non pas des chemins.

$sql="SELECT cheminImage,nomImage,photo FROM image";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		echo "<img src='" . "data:image/jpeg;base64," . base64_encode($row['photo']) . "'/>";
    }
} else {
    echo "0 results";
}
		 
$con->close();

?>
