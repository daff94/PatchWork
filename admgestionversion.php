

<?php

/* ******************************************* */ 
/* LISTER toutes les versions de IMAGE/COULEUR */
/* ******************************************* */
function ListeVersion() {
/* Connexion sur la base de travail */
$con = mysqli_connect("localhost","root","","patchwork");

// Check connection
if (mysqli_connect_errno())
  {   echo "Failed to connect to MySQL: " . mysqli_connect_error();  }

$sqlListeVersion = "SELECT * FROM INFORMATION_SCHEMA.TABLES where TABLE_NAME like 'image%';";

$result = $con->query($sqlListeVersion);
echo "<select name=table>";
while ($row = mysqli_fetch_array($result)) {
    echo "<option value='".$row[2]."'>".$row[2]."</option>";
}
echo "</select>";
/*
if ($con->query($sqlListeVersion) === FALSE) {
    echo "Error: Pas de table versionnée" . $con->error; }
else {
    $result = $con->query($sqlListeVersion);
}

echo "<p><label>Selectionnez la table : </label>";
echo "<select name=table>";
while ($ligne = $con->fetch($result))
{
    echo "<option value='".$ligne[0]."'>".$ligne[0]."</option>";
}
echo "</select>";
*/


$con->close();
}



/* *********************************************** */ 
/* CREATION d'une version des tables IMAGE/COULEUR */
/* *********************************************** */
function DuplicataVersion($version) {
// format du numero de vX, pas de point dans le nom de la table

/* Connexion sur la base de travail */
$con = mysqli_connect("localhost","root","","patchwork");

// Check connection
if (mysqli_connect_errno())
  {   echo "Failed to connect to MySQL: " . mysqli_connect_error();  }

/* Création d'une nouvelle version pour la table IMAGE */
$sqlCreationImage = "CREATE TABLE image_" . $version . " LIKE image;";
$sqlInsertionImage = "INSERT INTO image_" . $version . " SELECT * FROM image;";

/* Création d'une nouvelle version pour la table COULEUR */
$sqlCreationCouleur = "CREATE TABLE couleur_" . $version . "  LIKE couleur;";
$sqlInsertionCouleur = "INSERT INTO couleur_" . $version . "  SELECT * FROM couleur;";


if ($con->query($sqlCreationImage) === FALSE) {
    echo "Error: Duplication de la table IMAGE" . $con->error; }
if ($con->query($sqlCreationCouleur) === FALSE) {
    echo "Error: Duplication de la table COULEUR" . $con->error; }

if ($con->query($sqlInsertionImage) === FALSE) {
    echo "Error: Copie des éléments dans la nouvelle table IMAGE" . $con->error; }
if ($con->query($sqlInsertionCouleur) === FALSE) {
    echo "Error: Copie des éléments dans la nouvelle table COULEUR" . $con->error; }

$con->close();
}

/* ************************************************** */ 
/* SUPPRESSION d'une version des tables IMAGE/COULEUR */
/* ************************************************** */
function SuppressionTableVersion($version) {
/* Connexion sur la base de travail */
$con = mysqli_connect("localhost","root","","patchwork");

// Check connection
if (mysqli_connect_errno())
  {   echo "Failed to connect to MySQL: " . mysqli_connect_error();  }

/* Suppression des tables versionnées */
$sqlDropTableIMAGE = "DROP TABLE image_" . $version . ";";
$sqlDropTableCOULEUR = "DROP TABLE couleur_" . $version . ";";
if ($con->query($sqlDropTableIMAGE) === FALSE) {
    echo "Error: Suppression de la table IMAGE " . $con->error; }
if ($con->query($sqlDropTableCOULEUR) === FALSE) {
    echo "Error: Suppression de la table COULEUR" . $con->error; }
}

/************************************ */
/* FIN DE LA DEFINITION DES FONCTIONS */

/* commande URL pour lancer une action de suppression ou de copie d'une table
http://localhost/patchwork/admgestionversion.php?version=2&action=copy
*/

if (isset($_GET['action']) AND isset($_GET['version']))
{
    $action = $_GET['action'];
    $version = $_GET['version'];
}
else // Il manque des paramètres, on avertit le visiteur
{
       echo 'Error : Il faut les deux parametres ACTION et VERSION dans URL';
}

switch ($action) {
    case "delete":
        echo "suppression demandée d'une table";
        SuppressionTableVersion($version);
        break;
    case "copy":
        echo "copie demandée d'une table avec la version v" . $version;
        DuplicataVersion($version);
        break;
    case "listeversion":
            echo "Voici les versions trouvées : ";
            ListeVersion();
            break;
}

?>