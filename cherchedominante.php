<?php
$ecartApprox = (! empty($_POST['ecartApprox'])) ? $_POST['ecartApprox'] : 10;
$couleurteinte = (! empty($_POST['couleurteinte'])) ? $_POST['couleurteinte'] : 180;
$quantitedominante = (! empty($_POST['quantitedominante'])) ? $_POST['quantitedominante'] : 30;
$pourcentageluminance = (! empty($_POST['pourcentageluminance'])) ? $_POST['pourcentageluminance'] : 30;
$couleurluminance = (! empty($_POST['couleurluminance'])) ? $_POST['couleurluminance'] : 30;
$pourcentagesaturation = (! empty($_POST['pourcentagesaturation'])) ? $_POST['pourcentagesaturation'] : 30;
$couleursaturation = (! empty($_POST['couleursaturation'])) ? $_POST['couleursaturation'] : 30;
$ztorientation = (! empty($_POST['ztorientation'])) ? $_POST['ztorientation'] : 0;
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

	<title>Recherche Dominante</title>
		<style type="text/css">
		* {margin: 0; padding: 0}
		body {text-align: center;}
		form, div#wrap {margin: 10px auto; text-align: left; position: relative; width: 800px;}
		fieldset {padding: 20px; border: solid #999 2px;}
		img {width: 200px;}
		table {border: solid #000 1px; border-collapse: collapse;}
		td {border: solid #000 1px; padding: 50px 50px; white-space: nowrap;}
		br {width: 100%; height: 1px; clear: both; }
	</style>
	
	<style>
.slidecontainer {
    width: 100%;
}

.slider {
    -webkit-appearance: none;
    width: 100%;
    height: 25px;
    background: #d3d3d3;
    outline: none;
    opacity: 0.3;
    -webkit-transition: .2s;
    transition: opacity .2s;
}

.slider:hover {
    opacity: 1;
}

.slider::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    width: 25px;
    height: 25px;
    background: #4CAF50;
    cursor: pointer;
}

.slider::-moz-range-thumb {
    width: 25px;
    height: 25px;
    background: #4CAF50;
    cursor: pointer;
}
</style>
</head>

<body>


<div id="wrap">
<form action="#" method="post" enctype="multipart/form-data">
<fieldset>
<legend>Recherche Dominante</legend>

<div>
  <p>% Dominante: <span id="quantitedominante"></span></p>
  <input type="range" min="1" max="100" value="<?=$quantitedominante?>" name="quantitedominante" class="slider" id="qDominante">
</div>

<div>
	<p>Couleur de la Teinte: <span id="couleurteinte"></span></p>
	<input type="range" min="1" max="360" value="<?=$couleurteinte?>" name="couleurteinte" class="slider" id="qcouleurteinte">
</div>

<div>
	<p>% Ecart de Teinte: <span id="ecartApprox"></span></p>
 	<input type="range" min="1" max="100" value="<?=$ecartApprox?>" name="ecartApprox" class="slider" id="qecartApprox">
</div>

<div>
	<p>Valeur de la saturation: <span id="couleursaturation"></span></p>
 	<input type="range" min="1" max="100" value="<?=$couleursaturation?>" name="couleursaturation" class="slider" id="qcouleursaturation">
</div>

<div>
	<p>% Ecart de saturation: <span id="pourcentagesaturation"></span></p>
 	<input type="range" min="1" max="100" value="<?=$pourcentagesaturation?>" name="pourcentagesaturation" class="slider" id="qpourcentagesaturation">
</div>


<div>
	<p>Valeur de la luminance: <span id="couleurluminance"></span></p>
    <input type="range" min="1" max="100" value="<?=$couleurluminance?>" name="couleurluminance" class="slider" id="qcouleurluminance">
</div>

<div>
	<p>% Ecart de Luminance: <span id="pourcentageluminance"></span></p>
    <input type="range" min="1" max="100" value="<?=$pourcentageluminance?>" name="pourcentageluminance" class="slider" id="qpourcentageluminance">
</div>

<div>
    <label>
	<input type="radio" name="ztorientation" value="0"> Paysage<br>
	<input type="radio" name="ztorientation" value="1"> Portrait<br>
	<input type="radio" name="ztorientation" value="2"> Toutes
	</label>
</div>

<div>
    <input type="submit" name="action" value="Rechercher..." />
</div>

</fieldset>
</form>

<script>

// QUANTITE DE LA DOMINANTE
var eqDominante = document.getElementById("qDominante");
var output_quantitedominante = document.getElementById("quantitedominante");
output_quantitedominante.innerHTML = eqDominante.value;

eqDominante.oninput = function() {
  output_quantitedominante.innerHTML = this.value;
}

// TEINTE
var eqcouleurteinte = document.getElementById("qcouleurteinte");
var output_couleurteinte = document.getElementById("couleurteinte");
output_couleurteinte.innerHTML = eqcouleurteinte.value;

eqcouleurteinte.oninput = function() {
  output_couleurteinte.innerHTML = this.value;
}

// POURCENTAGE TEINTE
var eqecartApprox = document.getElementById("qecartApprox");
var output_ecartApprox = document.getElementById("ecartApprox");
output_ecartApprox.innerHTML = eqecartApprox.value;

eqecartApprox.oninput = function() {
  output_ecartApprox.innerHTML = this.value;
}

// SATURATION
var eqsaturation = document.getElementById("qcouleursaturation");
var output_esaturation = document.getElementById("couleursaturation");
output_esaturation.innerHTML = eqsaturation.value;

eqsaturation.oninput = function() {
output_esaturation.innerHTML = this.value;
}

// POURCENTAGE SATURATION
var eqpourcentagesaturation = document.getElementById("qpourcentagesaturation");
var output_epourcentagesaturation = document.getElementById("pourcentagesaturation");
output_epourcentagesaturation.innerHTML = eqpourcentagesaturation.value;

eqpourcentagesaturation.oninput = function() {
output_epourcentagesaturation.innerHTML = this.value;
}

// LUMIANCE
var eqcouleurluminance = document.getElementById("qcouleurluminance");
var output_ecouleurluminance = document.getElementById("couleurluminance");
output_ecouleurluminance.innerHTML = eqcouleurluminance.value;

eqcouleurluminance.oninput = function() {
output_ecouleurluminance.innerHTML = this.value;
}

// POURCENTAGE LUMIANCE
var eqpourcentageluminance = document.getElementById("qpourcentageluminance");
var output_epourcentageluminance = document.getElementById("pourcentageluminance");
output_epourcentageluminance.innerHTML = eqpourcentageluminance.value;

eqpourcentageluminance.oninput = function() {
output_epourcentageluminance.innerHTML = this.value;
}

</script>


<?php
$con = mysqli_connect("localhost","root","","patchwork");

//Rechercher la valeur HAUTE en fonction de couleurteinte
$hteintemax=$couleurteinte + (($couleurteinte * $ecartApprox) / 100);
//Rechercher la valeur BASSE en fonction de couleurteinte
$hteintemin=$couleurteinte - (($couleurteinte * $ecartApprox) / 100);

//Recherche le MIN et MAX de la saturation par rapport a la r�f�rence du formulaire "$couleursaturation"
$hsaturationmin=$couleursaturation - (($couleursaturation * $pourcentagesaturation)/100);
$hsaturationmax=$couleursaturation + (($couleursaturation * $pourcentagesaturation)/100);
//Recherche le MIN et MAX de la luminance par rapport a la r�f�rence du formulaire "$couleurluminance"
$hluminancemin=$couleurluminance - (($couleurluminance * $pourcentageluminance)/100);
$hluminancemax=$couleurluminance + (($couleurluminance * $pourcentageluminance)/100);

// Assignation de la valeur la plus haute r�elle
// Luminante jamais plus que 100%
if ($hluminancemax > 100) {
	$hluminancemax=100;
}
// Saturation jamais plus que 100%
if ($hsaturationmax > 100) {
	$hsaturationmax=100;
}

// La Teinte s'arrete � un tour de roue chromatique
if ($hteintemax > 360) {
	$hteintemax=360;
}

echo "Valeurs utilis�es pour la recherche ...";
echo "<br>Teinte Basse : " . $hteintemin;
echo " Teinte Haute : " . $hteintemax;

echo "<br>Luminance Basse : " . $hluminancemin;
echo " Luminance Haute : " . $hluminancemax;

echo "<br>Saturation Basse : " . $hsaturationmin;
echo " Saturation Haute : " . $hsaturationmax;
echo "<br>";

$sql = "SELECT distinct extidImage from couleur where hteinte > $hteintemin and hteinte < $hteintemax and pourcentage > $quantitedominante and ssaturation > $hsaturationmin and ssaturation < $hsaturationmax and lluminance > $hluminancemin and lluminance < $hluminancemax";

// DEBUG
// $sql = "SELECT  extidImage from couleur where hteinte > 0 and hteinte < 200 and pourcentage > 0 and ssaturation > 0 and ssaturation < 99 and lluminance > 0 and lluminance < 99";
// echo $sql;
/*
echo "Nombre de résultat : $result->num_rows";
echo "Cadrage : $ztorientation";
*/

echo $sql;


$result = $con->query($sql);



if ($result->num_rows > 0) {
// pour chaque correspondance trouv�e dans "couleur"
    while($row = $result->fetch_assoc()) {
		// On recherche la photo correspond � extidImage dans la table "image"
		// En fonction de l'orientation de l'image souhait�e, la clause "orientation" est ajout�e
		if ($ztorientation == 2) {
			$sqlimage="SELECT cheminImage,nomImage,imgphoto FROM image where idImage=".$row["extidImage"];
		}
		else {
			$sqlimage="SELECT cheminImage,nomImage,imgphoto FROM image where orientation = " . $ztorientation  . " and idImage=".$row["extidImage"];
		}
		$resultimage = $con->query($sqlimage);
		if ($resultimage->num_rows > 0) {
			while($rowimage = $resultimage->fetch_assoc()) {
				echo "<img src='" . "data:image/jpeg;base64," . base64_encode($rowimage['imgphoto']) . "'/>";
			}
		}
	}
}

?>

</body>
</html>