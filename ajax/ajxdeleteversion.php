<?php

// Récupération des parametres passés en AJAX depuis le HTML
$reqidVersion = $_REQUEST["reqidVersion"];

/* Connexion sur la base de travail */
$con = mysqli_connect("localhost","root","","patchwork");

// Check connection
if (mysqli_connect_errno())
  {   echo "Failed to connect to MySQL: " . mysqli_connect_error();  }

// SELECT d'information sur la version qui sera supprimée
$sqldeleteinfo = "SELECT * FROM refversion WHERE idVersion=" . $reqidVersion . ";";

// SELECT sur toutes les versions existantes
$sqlselectversion = "SELECT * FROM refversion WHERE refencours != 'X';";

// DELETE de la version selon id passé
$sqldeleteversion = "DELETE FROM refversion WHERE idVersion=" . $reqidVersion . ";";

// Exécution de la requete pour avoir des informations sur la version qui sera supprimée
try {
  $selectversion = $con->query($sqlselectversion);  
} catch (mysqli_sql_exception $e) { echo "probleme !!"; return false; }

$row = mysqli_fetch_array($selectversion);
$nomtableCouleur = $row['refcouleurv'];
$nomtableImage = $row['refimagev'];

// Instruction SQL pour supprimer les tables Image et Couleur correspondantes à la version choisie.
$sqltruncateImage = "DROP TABLE " . $nomtableImage;
$sqltruncateCouleur = "DROP TABLE " . $nomtableCouleur;

// Suppresion des tables correspondantes à la version choisie
$truncateImage = $con->query($sqltruncateImage);
$truncateCouleur = $con->query($sqltruncateCouleur);

// Exécution de la requete de suppression de la version séelectionnée
$deleteVersion = $con->query($sqldeleteversion);


// Refresh du tableau avec toutes les versions actualitées
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