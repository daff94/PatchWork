
<?php

// $q = intval($_GET['q']);

/* Connexion sur la base de travail */
$con = mysqli_connect("localhost","root","","patchwork");

// Check connection
if (mysqli_connect_errno())
  {   echo "Failed to connect to MySQL: " . mysqli_connect_error();  }

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
  
$con->close();

?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

</body>
</html>