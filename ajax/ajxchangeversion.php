<?php

// Récupération des parametres passés en AJAX depuis le HTML
$reqidVersion = $_REQUEST["reqidVersion"];

/* Connexion sur la base de travail */
$con = mysqli_connect("localhost","root","","patchwork");

// Check connection
if (mysqli_connect_errno())
  {   echo "Failed to connect to MySQL: " . mysqli_connect_error();  }

$sqlresetrefversion = "UPDATE refversion set refencours = ''";
$sqlupdateversion = "UPDATE refversion set refencours = 'X' where idversion = " . $reqidVersion;
$sqlselectinfoversion = "SELECT * from refversion where idversion = " . $reqidVersion;

try {
    $resetrefversion = $con->query($sqlresetrefversion);  
  } catch (mysqli_sql_exception $e) { echo "probleme !! Suppression indicateur version en cours" . $e; return false; }

try {
    $updateversion = $con->query($sqlupdateversion);  
  } catch (mysqli_sql_exception $e) { echo "probleme !! Création indicateur version activée" . $e; return false; }

try {
$selectinfoversion = $con->query($sqlselectinfoversion);  
} catch (mysqli_sql_exception $e) { echo "probleme !! Select information nom des tables couleur_x et image_x" . $e; return false; }


// Tournus des deux vues pour qu'elles pointent sur la nouvelle version choisie
// Suppression des vues existantes
$sqldropviewCouleur = "DROP VIEW couleur";
$sqldropviewImage = "DROP VIEW image";
if ($con->query($sqldropviewCouleur) === FALSE) {
    echo "Error: Suppression de la view COULEUR" . $con->error; }
if ($con->query($sqldropviewImage) === FALSE) {
    echo "Error: Suppression de la view IMAGE" . $con->error; }

// Récupération des informations des tables concernées ou il faut faire pointer les vues
$rowinfotableversion = mysqli_fetch_array($selectinfoversion);
$tablesourcecouleur = $rowinfotableversion['refcouleurv'];
$tablesourceimage = $rowinfotableversion['refimagev'];

// Création des vues avec la nouvelle version choisie : couleur_vXX et imange_vXX
$sqlcreateviewCouleur = "CREATE OR REPLACE VIEW couleur as select * from ". $tablesourcecouleur;
$sqlcreateviewImage = "CREATE OR REPLACE VIEW image as select * from " . $tablesourceimage;
if ($con->query($sqlcreateviewCouleur) === FALSE) {
    echo "Error: Création de la view COULEUR" . $con->error; }
if ($con->query($sqlcreateviewImage) === FALSE) {
    echo "Error: Création de la view IMAGE" . $con->error; }


// Refresh de la page appelante avec la liste des tables
$sqlListeVersion = "SELECT * FROM refversion";
$ListeVersion = $con->query($sqlListeVersion);

echo "<table>
<tr>
<th>Activée</th>
<th>Version</th>
<th>Date</th>
<th>Action</th>
</tr>";
while($row = mysqli_fetch_array($ListeVersion)) {
    echo "<tr>";
    echo "<td>";
    if ($row['refencours'] == 'X') { echo "<img class='imgvignette' src='/patchwork/img/check_small_transp.png'>"; } 
    echo "</td>";
    echo "<td>" . $row['refversion'] . "</td>";
    echo "<td>" . $row['refdate'] . "</td>";
    if ($row['refencours'] == 'X') {
      echo "<td>" . "<button class='button-disable' type='button' disabled value=" . $row['idVersion'] . " onclick='activerVersion(this.value)'>Activer</button>" . "<button class='button-disable' type='button' disabled value=" . $row['idVersion'] . " onclick='supprimerVersion(this.value)'>Supprimer</button>" . "</td>";
    } else {
      echo "<td>" . "<button class='button' type='button' value=" . $row['idVersion'] . " onclick='activerVersion(this.value)'>Activer</button>" . "<button class='button' type='button' value=" . $row['idVersion'] . " onclick='supprimerVersion(this.value)'>Supprimer</button>" . "</td>";
    }
    echo "</tr>";
}
echo "</table>";

$con->close();

?>
  
