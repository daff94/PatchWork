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

try {
    $resetrefversion = $con->query($sqlresetrefversion);  
  } catch (mysqli_sql_exception $e) { echo "probleme !!" . $e; return false; }

  try {
    $updateversion = $con->query($sqlupdateversion);  
  } catch (mysqli_sql_exception $e) { echo "probleme !!" . $e; return false; }


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
    if ($row['refencours'] == 'X') { echo "<img src='../img/check_small.jpg'>"; } 
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
  
