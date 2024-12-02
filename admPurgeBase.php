<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - Purge des Références</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/modale.css" rel="stylesheet">
</head>
<body>

<!-- Chargement du menu principal du site -->
<?php include 'menu_principal.html' ?>

<div class="container-fluid">
      <h1>Purge des Références</h1>
</div>

<!-- Code pour la fenetre modale - A propos-->
<?php include 'modale.html' ?>


<!-- La gestion d'historique des tables se fait de la facon suivante : imageA+couleurA / imageB+couleurB ... -->
<!-- Donc pour lister les tables d'historique il faut afficher les tables A, B, etc... -->

<?php

$con = mysqli_connect("localhost","root","","patchwork");
// Check connection
if (mysqli_connect_errno())
  {   echo "Failed to connect to MySQL: " . mysqli_connect_error();  }

$sqlSelectionTableHistorique = "select * from refversion;";
$sqlVersionactuelle = "select * from refversion where refencours = 'X'";
$resultVersionactuelle = $con->query($sqlVersionactuelle);
$resultSelectionTableHistorique = $con->query($sqlSelectionTableHistorique);

$Versionactuelle = $resultVersionactuelle->fetch_assoc();
echo "Version Actuelle : " . $Versionactuelle['refversion'] . " en date du " . $Versionactuelle['refdate'] . "<br>";

if ($resultSelectionTableHistorique->num_rows > 0) {
    echo "<select name='choixVersion' id='choixVersion-select'>";
    while($rowVersion = $resultSelectionTableHistorique->fetch_assoc()) {
		// Affichage d'un liste de choix unique de la version à purger
		echo "<option value=" . $rowVersion['refversion'] . ">" . "Version : " . $rowVersion['refversion'] . " en date du " . $rowVersion['refdate'] . "</option>";
    }
    echo "</select>";
    } else {
        echo "Aucun résultat";
}

$con->close();

?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

</body>
</html>