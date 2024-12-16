<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
	<title>Creation Palette</title>
		<style type="text/css">
		* {margin: 0; padding: 0}
		body {text-align: center;}
		form, div#wrap {margin: 10px auto; text-align: left; position: relative; width: 500px;}
		fieldset {padding: 20px; border: solid #999 2px;}
		img {width: 200px;}
		table {border: solid #000 1px; border-collapse: collapse;}
		td {border: solid #000 1px; padding: 50px 50px; white-space: nowrap;}
		br {width: 100%; height: 1px; clear: both; }
	</style>
</head>
<body>
<table>

<?php

$dominante=array();

$con = mysqli_connect("localhost","root","","patchwork");

// creation de la palette
$im = imagecreatetruecolor(100, 200);

// Rechcher les diff�rentes dominantes par image (idImage)
$sql = "SELECT hex, pourcentage,rrouge, gvert, bbleu, hteinte, ssaturation, lluminance, c.nomImage as nomImage FROM couleur i INNER JOIN image c ON i.extIdImage = c.idImage where c.idImage=49 order by i.pourcentage DESC";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr><td style=\"background-color:#".$row["hex"].";\"></td></tr>";
		$nompalette=$row["nomImage"];
		$dominante[] = imagecolorallocate($im, $row["rrouge"], $row["gvert"], $row["bbleu"]);
	}
}

$largeurMax=1280;
$hauteurMax=800;
//$tailleCarre=50;
$posx=0;
$posy=0;


// Dessine les carres avec les couleurs dominantes (8)
//imagefilledrectangle($im, $posx, $posy, $posx + $tailleCarre, $posy + $tailleCarre, $dominante[0]);
imagefilledrectangle($im, 00, 00, 50, 50, $dominante[0]);
imagefilledrectangle($im, 50, 00, 100, 50, $dominante[1]);

imagefilledrectangle($im, 00, 50, 50, 100, $dominante[2]);
imagefilledrectangle($im, 50, 50, 100, 100, $dominante[3]);

imagefilledrectangle($im, 0, 100, 50, 150, $dominante[4]);
imagefilledrectangle($im, 50, 100, 100, 150, $dominante[5]);

imagefilledrectangle($im, 00, 150, 50, 200, $dominante[6]);
imagefilledrectangle($im, 50, 150, 100, 200, $dominante[7]);

// Sauvegarde l'image
//imagejpeg($im, $row["hex"] . ".jpg");

imagejpeg($im, "palette_" . $nompalette);
imagedestroy($im);
?>

</table>
</body>
</html>