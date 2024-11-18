<?php

function hex2rgb($color)
{
	$r = hexdec(substr($color,0,2));
    $g = hexdec(substr($color,2,2));
    $b = hexdec(substr($color,4,2));							 
							 
	$rgb = array($r, $g, $b);
   //return implode(",", $rgb); // returns the rgb values separated by commas
   return $rgb; // returns an array with the rgb values
    $r = hexdec($r); $g = hexdec($g); $b = hexdec($b);
    return array($r, $g, $b);
}

function rgb_to_hsl($r, $g, $b) {
 
  $oldR = $r;
  $oldG = $g;
  $oldB = $b;
 
  $r /= 255;
  $g /= 255;
  $b /= 255;
 
  $max = max( $r, $g, $b );
  $min = min( $r, $g, $b );
 
  $l = ( $max + $min ) / 2;
  $d = $max - $min;
 
    if( $d == 0 ) {
      $h = $s = 0;
 
      } else {
 
      $s = $d / ( 1 - abs( 2 * $l - 1 ) );
 
      switch( $max ) {
        case $r:
         $h = 60 * fmod( ( ( $g - $b ) / $d ), 6 ); 
          if ($b > $g) {
           $h += 360;
          }
         break;
 
        case $g: 
         $h = 60 * ( ( $b - $r ) / $d + 2 ); 
         break;
 
        case $b: 
         $h = 60 * ( ( $r - $g ) / $d + 4 ); 
         break;
        }			        	        
     }
  return array(round($h, 2), round($s, 2)*100, round($l, 2)*100);
}

include_once("colors.inc.php");
$ex=new GetMostCommonColors();

$con = mysqli_connect("localhost","root","","patchwork");

// Check connection
if (mysqli_connect_errno())
  {   echo "Failed to connect to MySQL: " . mysqli_connect_error();  }

// parametres de recherche de dominates
$num_results=6;
$delta=24;
$reduce_brightness=1;
$reduce_gradients=1;

echo "Debut calcul - Nombre max de dominante : " . $num_results;

// Choix de la photo par son ID et r�cup�ration de son chemin et nom de la photo : nomImageTest
$sql="Select idImage, nomImage, cheminImage from image";
$result = $con->query($sql);
while($row = $result->fetch_assoc()) {
        $nomImageTest=$row["cheminImage"]. "/" . $row["nomImage"];
		$idImageTest=$row["idImage"];

	// recherche des dominantes selon les parametres d�finits plus haut	
	$colors=$ex->Get_Color($nomImageTest, $num_results, $reduce_brightness, $reduce_gradients, $delta);
		
	foreach ( $colors as $hex => $count )
	{
		if ( $count > 0 )
		{
		//transformation en pourcentage plutot que des 0.11223 et r�duction a 2 chiffres apr�s la virgule
		$pourcentage=number_format($count*100,2,'.','');
		
		// Convertion du modele HEX en RGB D�cimal
		$colorRGB = hex2rgb($hex);

		// Convertion du modele RGB en HSL
		$colorHSL = rgb_to_hsl($colorRGB[0],$colorRGB[1],$colorRGB[2]);

		//insertion en base des valeurs HEX (num_results) pour l'image choisi
		$sql = "INSERT INTO couleur(extIdImage,hex, pourcentage, rrouge, gvert, bbleu, hteinte, ssaturation, lluminance) VALUES ($idImageTest,'$hex', $pourcentage, $colorRGB[0], $colorRGB[1],$colorRGB[2],$colorHSL[0],$colorHSL[1],$colorHSL[2])";
		
		if ($con->query($sql) === FALSE) {
		echo "Error: " . $sql . "<br>" . $con->error; }
		}
	}
}

$con->close();
echo "Calcul termin� !!!";
?>