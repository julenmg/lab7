<?php
include_once ("konexioa.php");
include_once ("sesioa.php");

$email=$_SESSION['login_email'];

ekintza("txertatu",$dblink);

$sql="INSERT INTO GALDERA () VALUES('','{$galdera}','{$erantzuna}','{$zailtasuna}','{$email}')";

$result = $dblink->query($sql);
if($result) {
	$file = 'xml/galderak.xml';
	$xml = simplexml_load_file($file); 
	
	$assessmentItem = $xml->addChild('assessmentItem');
	$assessmentItem-> addAttribute('complexity',$zailtasuna);	
	$assessmentItem-> addAttribute('subject','Mikologia');
	$itemBody= $assessmentItem-> addChild('itemBody');
	$correctResponse= $assessmentItem-> addChild('correctResponse');
	$itemBody-> addChild('p',$galdera);
	$correctResponse-> addChild('value',$erantzuna);
	//$assessmentItem->$itemBody;
	//$assessmentItem->$correctResponse;
	//$xml->$assessmentItem;
	
	$ondoTxertatuDa = file_put_contents($file, $xml->asXML());
	if($ondoTxertatuDa)
		echo '<h2>XML-n ondo txertatu da</h2>';
	else
		echo 'Arazo bat egonda txertaketan';
	echo '<h2>Zure galdera gehitu da</h2>';
}else{
	echo '<h2>Errore bat egon da zure galdera gehitzerakoan</h2>'
               . "<pre>{$dblink->error}</pre>";
}
require ("php/deskonexioa.php");
?>
,