<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr" xml:lang="fr">
<head>
	<title>Image Color Extraction</title>
	<style type="text/css">
		* {margin: 0; padding: 0}
		body {text-align: center;}
		form, div#wrap {margin: 10px auto; text-align: left; position: relative; width: 500px;}
		fieldset {padding: 20px; border: solid #999 2px;}
		img {width: 400px;}
		table {border: solid #000 1px; border-collapse: collapse;}
		td {border: solid #000 1px; padding: 2px 5px; white-space: nowrap;}
		br {width: 100%; height: 1px; clear: both; }
	</style>
</head>
<body>
<div id="wrap">

<?php
$con = mysqli_connect("localhost","root","","patchwork");
// Check connection
if (mysqli_connect_errno())
  {   echo "Failed to connect to MySQL: " . mysqli_connect_error();  }

//selection de la photo par son ID
//$sql = "SELECT hex, pourcentage,rrouge, gvert, bbleu, hteinte, ssaturation, lluminance, c.nomImage as nomImage FROM couleur i INNER JOIN image c ON i.extIdImage = c.idImage where c.idImage=4 order by i.pourcentage DESC";


// Liste une seule photo en fonction de son ID : idImage
//$sqlUnePhotoID ="SELECT idImage, imgphoto from image where idImage=45";

// liste de toutes les images présentes en base.
$sqlToutesPhotoID = "SELECT idImage, imgphoto from image";
$resultToutesPhotoID = $con->query($sqlToutesPhotoID);

$sqlcountVariante = "SELECT count(idImage) from color";


if ($resultToutesPhotoID->num_rows > 0) {
    while($rowImage = $resultToutesPhotoID->fetch_assoc()) {
		//Affichage sous forme de tableau avec la couleur (couleur d'une cellule du tableau), code couleur en Hex et Pourcentage de la couleur parmis les autres
		echo '<table><tr><td>Référence</td><td>Color</td><td>Color Code</td><td>Percentage</td><td>Rouge</td><td>Vert</td><td>Bleu</td><td>Teinte</td><td>Saturation</td><td>Luminance</td></tr>';

		// Nombre de dominante pour l'image - Permet de faire une célule fusionnée pour aspect esthétique de l'affichage
		$sqlcountdominante = "SELECT count(extIdImage) as NbrDominante from couleur where extIdImage = " . $rowImage['idImage'];
		$resultatNbrDominante = $con->query($sqlcountdominante);
		$rowresultatNbrDominante = $resultatNbrDominante->fetch_assoc();
		// Affichage de l'image référence
        echo '<tr><td rowspan="' . $rowresultatNbrDominante['NbrDominante'] . '"><img src="data:image/jpeg;base64,'.base64_encode( $rowImage['imgphoto'] ).'"/></td>';
		// Affichage des informations de colorométrie
		$sql = "SELECT hex, pourcentage,rrouge, gvert, bbleu, hteinte, ssaturation, lluminance, c.nomImage as nomImage, c.imgphoto as contenuphoto FROM couleur i INNER JOIN image c ON i.extIdImage = c.idImage where c.idImage=" . $rowImage['idImage'] . " order by i.pourcentage DESC";
		$result = $con->query($sql);
		while($row = $result->fetch_assoc()) {
		echo "<td style=\"background-color:#".$row["hex"].";\"></td><td>".$row["hex"]."</td><td>".$row["pourcentage"]."</td>"."</td><td>".$row["rrouge"]."</td>"."</td><td>".$row["gvert"]."</td>"."</td><td>".$row["bbleu"]."</td>"."</td><td>".$row["hteinte"]."</td>"."</td><td>".$row["ssaturation"]."</td>"."</td><td>".$row["lluminance"]."</td></tr>";
		}
		echo '</table>';
    }
} else {
    echo "0 results";
}

$con->close();

echo "</div></body></html>";
?>