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
      <h1>Ensemble des photos</h1>
    </div>

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

// $sqlcountVariante = "SELECT count(idImage) from color";


if ($resultToutesPhotoID->num_rows > 0) {
    while($rowImage = $resultToutesPhotoID->fetch_assoc()) {
		//Affichage sous forme de tableau avec la couleur (couleur d'une cellule du tableau), code couleur en Hex et Pourcentage de la couleur parmis les autres
		echo '<table class="center"><tr><th>Référence</th><th>Couleur</th><th>#RGB</th><th>Quantité</th><th>Rouge</th><th>Vert</th><th>Bleu</th><th>Teinte</th><th>Saturation</th><th>Luminance</th></tr>';

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
		echo "<td style=\"background-color:#".$row["hex"].";\"></td><td>#".$row["hex"]."</td><td>".$row["pourcentage"]."%</td>"."</td><td>".$row["rrouge"]."</td>"."</td><td>".$row["gvert"]."</td>"."</td><td>".$row["bbleu"]."</td>"."</td><td>".$row["hteinte"]."</td>"."</td><td>".$row["ssaturation"]."</td>"."</td><td>".$row["lluminance"]."</td></tr>";
		}
		echo '</table><br>';
    }
} else {
    echo "Aucun résultat";
}

$con->close();

?>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

</body>
</html>