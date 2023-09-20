<?php
global $db;
include('rdb.php');
include('functions.php');

$xml = "";
$sub = get_sub_now(array('id'=>1));

if($sub && $sub->isDumpComplete && $sub->isActive){
	$type='GetNextUpdateDataRequest'; $var=$sub->subscriptionId;
} elseif($sub && !$sub->isDumpComplete && $sub->isActive){
	$type='GetNextInitialDataRequest'; $var=$sub->subscriptionId;
} else {
	$type='SubscribeRequest'; $var='Chandana';
}
$xml = get_xml_feed($type, $var);

$sml = str_replace(array('="true"', '="false"'), array('="1"','="0"'), $xml);
$ob = simplexml_load_string($xml);


$sml = str_replace(array('="true"', '="false"'), array('="1"','="0"'), $xml);
$ob = simplexml_load_string($xml);

if($ob->SubscribeResponse){
	if($ob->SubscribeResponse['subscriptionId']){
		$table = $db->prefix.'subscriptions';
		$data = array('id'=>1, 'subscriptionId'=>$ob->SubscribeResponse['subscriptionId'], 'isActive'=>1, 'isLocked'=>0, 'isDumpComplete'=>(($sub)? $sub->isDumpComplete:0));
		$db->replace($table, $data);
	}
}

if($ob->GetNextInitialDataResponse){
	$json = json_encode($ob->GetNextInitialDataResponse->InitialData->entities);
	$json = json_decode($json, true);
	foreach($json as $k=>$v){
		foreach($v as $a=>$b){
			if($b["@attributes"]){
			$db->replace($db->prefix.$k, $b["@attributes"]);
			} elseif($b){
			$db->replace($db->prefix.$k, $b);
			}
		}
	}
	if($ob->GetNextInitialDataResponse->InitialData[dumpComplete]==1){
		$table = $db->prefix.'subscriptions';
		$data = array('isDumpComplete'=>1);
		$where =  array('id'=>1);
		$db->update($table, $data, $where);
	}
}

if($ob->GetNextUpdateDataResponse){
	$json = json_encode($ob->GetNextUpdateDataResponse);
	$json = json_decode($json, true);
	foreach($json as $k=>$v){
		foreach($v as $a=>$b){
			foreach($b as $c=>$d){
				if($c!='@attributes'){
					foreach($d as $e=>$f){
						$data = $f["@attributes"];
						if($data["type"]=="update"){
						unset($data["type"]);
						$db->update($db->prefix.$c, $data);
						} elseif($data["type"]=="insert"){
						unset($data["type"]);
						$db->insert($db->prefix.$c, $data);
						}
						unset($data);
					}
				}
			}
		}
	}
}

if($ob->error){
	$json = json_encode($ob->error);
	$json = json_decode($json, true);
	$db->insert($db->prefix.'errors', $json["@attributes"]);
	/*if($data["@attributes"]['code']==100){
		$table = $db->prefix.'subscriptions';
		$data = array('isActive'=>0);
		$where =  array('id'=>1); 
		$db->update($table, $data, $where);
	}*/
}
?>