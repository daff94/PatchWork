<?php

// $q = intval($_GET['q']);

/* Connexion sur la base de travail */
$con = mysqli_connect("localhost","root","","patchwork");

// Check connection
if (mysqli_connect_errno())
  {   echo "Failed to connect to MySQL: " . mysqli_connect_error();  }

$sqlListeVersion = "SELECT * FROM refversion;";

$result = $con->query($sqlListeVersion);

echo "<table>
<tr>
<th>Version en Cours</th>
<th>Version</th>
<th>Date</th>
</tr>";
while($row = mysqli_fetch_array($result)) {
  echo "<tr>";
  echo "<td>" . $row['refencours'] . "</td>";
  echo "<td>" . $row['refversion'] . "</td>";
  echo "<td>" . $row['refdate'] . "</td>";
  echo "</tr>";
}
echo "</table>";





$con->close();

?>