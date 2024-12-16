<?php

// Récupération des parametres passés en AJAX depuis le HTML
// Interval TEINTE
$reqhuemin = $_REQUEST["reqhuemin"];
$reqhuemax = $_REQUEST["reqhuemax"];
// Saturation MIN et MAX
$reqsatmin = $_REQUEST["reqsatmin"];
$reqsatmax = $_REQUEST["reqsatmax"];
// Luminance MIN ET MAX
$reqlummin = $_REQUEST["reqlummin"];
$reqlummax = $_REQUEST["reqlummax"];

// http://localhost/patchwork/ajax/ajxaffichephoto.php?reqhuemin=200&reqhuemax=240&reqsatmin=0&reqsatmax=100&reqlummin=0&reqlummax=100

/* Connexion sur la base de travail */
$con = mysqli_connect("localhost","root","","patchwork");

// Check connection
if (mysqli_connect_errno())
  {   echo "Failed to connect to MySQL: " . mysqli_connect_error();  }

$sqltrouvequivalence = $sql = "SELECT distinct extidImage from couleur 
where hteinte >= $reqhuemin and hteinte <= $reqhuemax 
and ssaturation >= $reqsatmin and ssaturation <= $reqsatmax 
and lluminance >= $reqlummin and lluminance <= $reqlummax";

$trouvequivalence = $con->query($sqltrouvequivalence);

if ($trouvequivalence->num_rows > 0) {
    // pour chaque correspondance trouv�e dans "couleur"
    while($row = $trouvequivalence->fetch_assoc()) {
        // On recherche la photo correspond � extidImage dans la table "image"
        $sqlimage = "SELECT cheminImage,nomImage,imgphoto FROM image where idImage=".$row["extIdImage"];
        $resultimage = $con->query($sqlimage);
        if ($resultimage->num_rows > 0) {
            while($rowimage = $resultimage->fetch_assoc()) {
                echo "<img class='tinyimg' src='" . "data:image/jpeg;base64," . base64_encode($rowimage['imgphoto']) . "'/>";
            }
        }
    }
}
else {
    echo "<p>Aucun correpsondance trouvée.</p>";
}

/* 
echo "<table>
<tr>
<th>Activée</th>
<th>Version</th>
<th>Date</th>
<th>Action</th>
</tr>";
while($row = mysqli_fetch_array($SelectImage)) {
  echo "<tr>";
  echo "<td>";
  if ($row['refencours'] == 'X') { echo "<img class='imgvignette' src='/patchwork/img/check_small_transp.png' alt='check'>"; } 
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
*/


$con->close();

?>
