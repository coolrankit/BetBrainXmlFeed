<?php
	$http_headers = array(
		'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:6.0.2) Gecko/20100101 Firefox/6.0.2',
		'Accept: */*',
		'Accept-Language: en-us,en;q=0.5',
		'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7',
		//'Content-Type: application/json',
		//'Content-Length: ' . strlen($data_string),
		'Connection: keep-alive'
	);
	//$url = 'http://sept.betbrain.com:8081/xmlfeed?requestType=SubscribeRequest&subscriptionSpecificationName=Chandana';
	$url = 'http://sept.betbrain.com:8081/xmlfeed?requestType=GetNextUpdateDataRequest&subscriptionId=13886750';

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 80);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $http_headers);
	$html = curl_exec($ch);
	curl_close($ch);

$xml = gzinflate(substr($html,10,-8));
echo ((strstr($xml, 'dumpComplete="false"'))? 'no':'yes');
$fp = fopen('xml/'.time().'.xml', "w");
fwrite($fp, $xml);
fclose($fp);

?>