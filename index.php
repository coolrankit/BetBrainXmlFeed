<?php
global $db;
include('rdb.php');

$path = 'xml/';
$files = scandir($path);
$file = 'xml/'.$files[2];
$xml = gzinflate(substr($html,10,-8));
$fp = fopen($file, "r");
$xml = fread($fp, filesize($file));
fclose($fp);

$xml = str_replace(array('="true"', '="false"'), array('="1"','="0"'), $xml);
$ob = simplexml_load_string($xml);
//echo serialize($ob);
if($ob->SubscribeResponse){
	if($ob->SubscribeResponse['subscriptionId']){
		$table = $db->prefix.'SubscribeResponse';
		$data = array('subscriptionId'=>$ob->SubscribeResponse['subscriptionId']);
		$db->replace($table, $data);
	}
}
if($ob->GetNextInitialDataResponse){
	$data = json_encode($ob->GetNextInitialDataResponse->InitialData->entities);
	$data = json_decode($data, true);
	echo $ob->GetNextInitialDataResponse->InitialData[dumpComplete]==0;
	foreach($data as $k=>$v){
		foreach($v as $a=>$b){
			if($b["@attributes"]){
			echo '<br>'.$k.' => '.serialize($b["@attributes"]);
			$db->replace($db->prefix.$k, $b["@attributes"]);
			} elseif($b){
			echo '<br>'.$k.' => '.serialize($b);
			$db->replace($db->prefix.$k, $b);
			}
		}
	}
}
if($ob->GetNextUpdateDataResponse){
	$data = json_encode($ob->GetNextUpdateDataResponse);
	$data = json_decode($data, true);
	foreach($data as $k=>$v){
		foreach($v as $a=>$b){
			foreach($b as $c=>$d){
				if($c!='@attributes'){
				foreach($d as $e=>$f){
					echo '<br><br>'.$k.' => '.$c.' => '.serialize($f["@attributes"]);
				}
				}
			}
		}
	}
}

if($ob->error){
	$data = json_encode($ob->error);
	$data = json_decode($data, true);
	echo serialize($data["@attributes"]);
}
?>