<html>
<head>
	<title>Palette de couleurs</title>
</head>
<body>
<script>
	var rouge=0;
	var vert=0;
	var bleu=0;
	function compo(r){
		var coul=new Array('0','1','2','3','4','5','6','7','8','9','a','b','c','d','e','f');
		return coul[(r-r%16)/16]+coul[r%16];
	}
	function couleur(r,v,b){
		return compo(r)+compo(v)+compo(b);
	}
	function eloigne(r,v,b){
		//return compo(255-r)+compo(255-v)+compo(255-b);
		re=(127>r)?255:0;
		ve=(127>v)?255:0;
		be=(127>b)?255:0;
		return compo(re)+compo(ve)+compo(be);
	}
	function select_rouge(i){
		rouge=i;
		for (i=0;i<8;i++){
			for (j=0;j<8;j++){
				document.getElementById('bleu_'+i+'_'+j).style.backgroundColor=couleur(rouge, vert, i*32+j*2);
				document.getElementById('vert_'+i+'_'+j).style.backgroundColor=couleur(rouge, i*32+j*2, bleu);
			}
		}
		select_color();
	}
	function select_vert(i){
		vert=i;
		for (i=0;i<8;i++){
			for (j=0;j<8;j++){
				document.getElementById('bleu_'+i+'_'+j).style.backgroundColor=couleur(rouge, vert, i*32+j*2);
				document.getElementById('rouge_'+i+'_'+j).style.backgroundColor=couleur(i*32+j*2, vert, bleu);
			}
		}
		select_color();
	}
	function select_bleu(i){
		bleu=i;
		for (i=0;i<8;i++){
			for (j=0;j<8;j++){
				document.getElementById('rouge_'+i+'_'+j).style.backgroundColor=couleur(i*32+j*2, vert, bleu);
				document.getElementById('vert_'+i+'_'+j).style.backgroundColor=couleur(rouge, i*32+j*2, bleu);
			}
		}
		select_color();
	}
	function select_color(){
		var coul=couleur(rouge, vert, bleu);
		document.getElementById('couleur').style.backgroundColor=coul;
		document.getElementById('couleur').style.color=eloigne(rouge, vert, bleu);
		document.getElementById('couleur').innerHTML="couleur séléctionnée : #"+coul+" ou rgb("+rouge+", "+vert+", "+bleu+")";
	}
</script>
<table>
<tr>
	<th style="background-color:#FAA;">Rouge</th>
	<th style="background-color:#AFA;">Vert</th>
	<th style="background-color:#AAF;">Bleu</th>
</tr>
<tr><td>
<table>
<?php
$coul=array('0','1','2','3','4','5','6','7','8','9','a','b','c','d','e','f');
for ($i=0;$i<8;$i++){
	echo '<tr>';
	for ($j=0;$j<8;$j++){
		echo '<td><input type="button" onclick="select_rouge('.($i*32+$j*2).
		');" id="rouge_'.$i.'_'.$j.'" style="background-color:'.$coul[$i*2].$coul[$j*2].'0000;"></td>
		';
	}
	echo '</tr>';
}
echo '</table>
</td>
<td>
<table>';
for ($i=0;$i<8;$i++){
	echo '<tr>';
	for ($j=0;$j<8;$j++){
		echo '<td><input type="button" onclick="select_vert('.($i*32+$j*2).
		')" id="vert_'.$i.'_'.$j.'" style="background-color:00'.$coul[$i*2].$coul[$j*2].'00;"></td>
		';
	}
	echo '</tr>';
}
echo '</table>
</td>
<td>
<table>';
for ($i=0;$i<8;$i++){
	echo '<tr>';
	for ($j=0;$j<8;$j++){
		echo '<td><input type="button" onclick="select_bleu('.($i*32+$j*2).
		')" id="bleu_'.$i.'_'.$j.'" style="background-color:0000'.$coul[$i*2].$coul[$j*2].';"></td>
		';
	}
	echo '</tr>';
}
?>
</table>
</td>
</tr>
<tr>
	<td colspan="3" id="couleur" style="background-color:#000;color:#FFF;">
	couleur séléctionnée
	</td>
</tr>
</table>
</body>
</html>