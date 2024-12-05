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
$sqldeleteversion = "DELETE * FROM refversion WHERE idVersion=" . $reqidVersion . ";";

echo $sqldeleteversion;
// Exécution de la requete pour avoir des informations sur la version qui sera supprimée
$selectversion = $con->query($sqlselectversion);

// Exécution de la requete de suppression de la version séelectionnée
// $deleteVersion = $con->query($sqldeleteversion);


// Refresh du tableau avec toutes les versions actualitées
echo "<table>
<tr>
<th>Version en Cours</th>
<th>Version</th>
<th>Date</th>
<th>Action</th>
</tr>";
while($row = mysqli_fetch_array($selectversion)) {
  echo "<tr>";
  echo "<td>" . $row['refencours'] . "</td>";
  echo "<td>" . $row['refversion'] . "</td>";
  echo "<td>" . $row['refdate'] . "</td>";
  echo "<td>" . "<button class='button' type='button' value=" . $row['idVersion'] . " onclick='activerVersion(this.value)'>Activer</button>" . "<button class='button' type='button' value=" . $row['idVersion'] . " onclick='supprimerVersion(this.value)'>Supprimer</button>" . "</td>";
  echo "</tr>";
}
echo "</table>";

?>