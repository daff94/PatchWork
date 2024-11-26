
<?php

function RGB_to_HSV($r, $g, $b) {
    $r = max(0, min((int)$r, 255));
    $g = max(0, min((int)$g, 255));
    $b = max(0, min((int)$b, 255));
    $result = [];
    $min = min($r, $g, $b);
    $max = max($r, $g, $b);
    $delta_min_max = $max - $min;
    $result_h = 0;
    if     ($delta_min_max !== 0 && $max === $r && $g >= $b) $result_h = 60 * (($g - $b) / $delta_min_max) +   0;
    elseif ($delta_min_max !== 0 && $max === $r && $g <  $b) $result_h = 60 * (($g - $b) / $delta_min_max) + 360;
    elseif ($delta_min_max !== 0 && $max === $g            ) $result_h = 60 * (($b - $r) / $delta_min_max) + 120;
    elseif ($delta_min_max !== 0 && $max === $b            ) $result_h = 60 * (($r - $g) / $delta_min_max) + 240;
    $result_s = $max === 0 ? 0 : (1 - ($min / $max));
    $result_v = $max;
    $result['h'] = (int)(round($result_h));
    $result['s'] = (int)($result_s * 100);
    $result['v'] = (int)($result_v / 2.55);
    return $result;
}

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

$hex="7890c0";
$colorRGB = hex2rgb($hex);
var_dump($colorRGB);
// https://www.rapidtables.com/convert/color/rgb-to-hsv.html
var_dump(RGB_to_HSV($colorRGB[0],$colorRGB[1],$colorRGB[2]))

?>