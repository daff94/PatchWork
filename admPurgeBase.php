<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - Purge des Références</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/modale.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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

// Sélection du choix des versions sauf celle en cours
$sqlSelectionTableHistorique = "select * from refversion where refencours <> 'X'";
$sqlVersionactuelle = "select * from refversion where refencours = 'X'";
$resultVersionactuelle = $con->query($sqlVersionactuelle);
$resultSelectionTableHistorique = $con->query($sqlSelectionTableHistorique);

$Versionactuelle = $resultVersionactuelle->fetch_assoc();

echo "<div class='container'>";
echo "<div>";
echo "Version Actuelle : " . $Versionactuelle['refversion'] . " en date du " . $Versionactuelle['refdate'] ;
echo "</div>";

    echo "<div>";
    if ($resultSelectionTableHistorique->num_rows > 0) {
        echo "<select class='form-select' name='choixVersion' id='choixVersion-select'>";
        while($rowVersion = $resultSelectionTableHistorique->fetch_assoc()) {
            // Affichage d'un liste de choix unique de la version à purger
            echo "<option value=" . $rowVersion['refversion'] . ">" . "Version : " . $rowVersion['refversion'] . " en date du " . $rowVersion['refdate'] . "</option>";
        }
        echo "</select>";
        } else {
            echo "Aucun résultat";
    }
    echo "</div>";

    echo "<div style='text-align: center;'>";
    echo "<button class='btn btn-danger' type='button'>Supprimer!</button>";
    echo "</div>";

echo "</div>";
$con->close();

?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

</body>
</html>