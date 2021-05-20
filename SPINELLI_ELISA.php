<!DOCTYPE html>
<html>
<head>
</head>
<body>
<?php
setlocale(LC_MONETARY, 'it_IT');
if(isset($_POST['submit'])) 
{ 
    $anno = $_POST['anno'];
	$pr = $_POST['pr'];
	$nom = $_POST['nom'];
	$mese = $_POST['mese'];
	$mesee = $_POST['mesee'];
	$num = $_POST['num'];
	$int = $_POST['per'];
	$comm = $_POST['com'];
	$valore=$num*$nom;
	$imp_comm = ($comm/100)*$valore;
	$durata_me = $anno*12;
	$compe=count($mese);
	# $compe quante volte pago interessi all'anno
	$rateo_me = 12 - max($mese)+1;
	# $rateo_me mesi rateo
	$emi=max($mesee);
	if ($emi==0) {
		$emi = min($mese);
	    }
	$conta=0;
	for ($i=0;$i<$compe;$i=$i+1)
	{
		if ($mese[$i]>$emi) {
      $conta=$conta+1;
		}
	}
	$inte_i = $conta/$compe;
	$inte_f = ($compe - $conta)/$compe;
	for ($i=0;$i<=$anno;$i=$i+1)
	{
	 $comp[$i]=12;
	 $interessi[$i]=$nom*$num*$int/100;
	 $ratei[$i]= ($nom*$num*$int/100)/12*$rateo_me;
	}
	$comp[0]=12-$emi+1;
	$interessi[0]=$nom*$num*$inte_i*$int/100;
	$interessi[$anno]=$nom*$num*$inte_f*$int/100;
	$comp[$anno]=$emi-1;
	$ratei[$anno]=0;
	$conta=0;
	for ($i=0;$i<$compe;$i=$i+1)
	{
	if ($mese[$i]>$emi) {
      $conta=$conta+1;
	}
	}
	$durata_me = $anno*12;
	$diffe=($pr-$nom)*$num;
	if ($pr-$nom>0)
	{
		$sopra=true;
		$diffe = $diffe-$imp_comm;
	}
	else
    {
		$sopra=false;
		$diffe = $diffe-$imp_comm;
		$diffe=$diffe*(-1);
	}
	$plu[0]=$diffe;
	$plu_compe[0]=($diffe/$durata_me)*$comp[0];
	$plu_rin[0]=$plu[0]-$plu_compe[0];
	for ($i=1;$i<=$anno;$i=$i+1)
	{
	 $plu[$i]=$plu_rin[$i-1];
	 $plu_compe[$i]=($diffe/$durata_me)*$comp[$i];
	 $plu_rin[$i]=$plu[$i]-$plu_compe[$i];
	} 
	echo '<table style="width:50%">';
	echo '<th>anno</th>';
	if ($sopra) 
	{
		echo '<th>AGGIO iniziale</th><th>AGGIO di competenza</th><th>AGGIO da rinviare</th>';
	}
	else
	{
		echo '<th>DISAGGIO iniziale</th><th>DISAGGIO di competenza</th><th>DISAGGIO da rinviare</th>';
	}	
	echo '<th>importo rateo</th><th>importo interessi</th>';
	$i=0;
	while ($i<=$anno)
	{
	 $inizio=2021+$i;
	 echo '<tr>';
	 echo '<td style="text-align:center;">'.$inizio.'</td>';
	 echo '<td style="text-align:center;">'.number_format($plu[$i],2,",",".").'</td>';
	 echo '<td style="text-align:center;">'.number_format($plu_compe[$i],2,",",".").'</td>';
	 echo '<td style="text-align:center;">'.number_format($plu_rin[$i],2,",",".").'</td>';
	 echo '<td style="text-align:center;">'.number_format($ratei[$i],2,",",".").'</td>';
	 echo '<td style="text-align:center;">'.number_format($interessi[$i],2,",",".").'</td><tr>';
	 $i=$i+1;
	}
	echo '</table>';
}
else
{
	$des_mese = array ("gennaio","febbraio","marzo","aprile","maggio","giugno","luglio","agosto","settembre","ottobre","novembre","dicembre");
	echo '<form method="post" action="'.$_SERVER['PHP_SELF'].'">';
    echo '<table style="width:50%">';
    echo '<tr><th>durata</th>';
	echo '<th><input type="number" name="anno"></th></tr>';
    echo '<tr><th>valore nominale</th>';
	echo '<th><input type="text" name="nom"></th></tr>';
    echo '<tr><th>prezzo emissione</th>';	
	echo '<th><input type="text" name="pr"></th></tr>';
	echo '<tr><th>numero</th>';
	echo '<th><input type="text" name="num"></th></tr>';
	echo '<tr><th>percentuale interessi</th>';	
	echo '<th><input type="text" name="per"></th></tr>';
	echo '<tr><th>percentuale commissioni banca</th>';	
	echo '<th><input type="text" name="com"></th></tr>';
	echo '<tr><th></th><th>pagamento interessi</th>';
    echo '<th>data emissione</th><tr>';	
	for ($i=0;$i<12;$i=$i+1)
	{	
		$mese_val =$i+1;
		echo '<tr><th>'.$des_mese[$i].'</th>';
		echo '<th><input type="checkbox" id="m'.$mese_val.'" name ="mese[]" value="'.$mese_val.'" onclick="myFunction'.$mese_val.'()"></th>';
		echo '<th><input type="radio" id="me'.$mese_val.'" style="display:none" name ="mesee[]" value="'.$mese_val.'"></th></tr>';
	}
	echo '<script>';
	for ($i=0;$i<12;$i=$i+1)
	{
	$mese_val =$i+1;
    echo 'function myFunction'.$mese_val.'(){';
    echo  'var checkBox = document.getElementById("m'.$mese_val.'");';
    echo '  var text = document.getElementById("me'.$mese_val.'");';
    echo '  if (checkBox.checked == true){';
    echo '    text.style.display = "inline";';
	echo '    text.checked=true;';
    echo '  } else {';
    echo '     text.style.display = "none";';
    echo '  }';
    echo '}';
	}
    echo '</script>';
	echo '<br>';
    echo '<th></th><th><input type="submit" name="submit" value="CONFERMA DATI"></th></table>';
    echo  '</form>';
}	
?>
</body>
