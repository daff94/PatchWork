<?php

// $q = intval($_GET['q']);

/* Connexion sur la base de travail */
$con = mysqli_connect("localhost","root","","patchwork");

// Check connection
if (mysqli_connect_errno())
  {   echo "Failed to connect to MySQL: " . mysqli_connect_error();  }

$sqlListeVersion = "SELECT * FROM refversion WHERE refencours != 'X';";
$sqlversionActive = "SELECT * FROM refversion WHERE refencours='X';";

$ListeVersion = $con->query($sqlListeVersion);
$versionActive = $con->query($sqlversionActive);

$row = mysqli_fetch_array($versionActive);
echo "Version utilisée est : " . $row['refversion'] . " du " . $row['refdate'];

echo "<table>
<tr>
<th>Version en Cours</th>
<th>Version</th>
<th>Date</th>
<th>Action</th>
</tr>";
while($row = mysqli_fetch_array($ListeVersion)) {
  echo "<tr>";
  echo "<td>" . $row['refencours'] . "</td>";
  echo "<td>" . $row['refversion'] . "</td>";
  echo "<td>" . $row['refdate'] . "</td>";
  echo "<td>" . "<button class='button' type='button' value=" . $row['idVersion'] . " onclick='activerVersion(this.value)'>Activer</button>" . "<button class='button' type='button' value=" . $row['idVersion'] . " onclick='supprimerVersion(this.value)'>Supprimer</button>" . "</td>";
  echo "</tr>";
}
echo "</table>";


$con->close();

?>