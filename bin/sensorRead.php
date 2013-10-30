<?php

include("../config.php");
include("../lib/labbrokerRPi.php");

$pi = new labbrokerRPi($config);

if(isset($pi->config['mqtt'])){
	
	include("../lib/phpMQTT/phpMQTT.php");
	$mqtt = new phpMQTT($pi->config['mqtt']['server'], $pi->config['mqtt']['port'], "{$pi->config['labbroker']['pi_name']}_sR");

	if (!$mqtt->connect()) {
		die("Can not connect to broker\n");
	}
}
if(isset($pi->config['brdata'])){
	
	include("../lib/brData.php");
	$brdata = new brData($pi->config['brdata']['url'], $pi->config['brdata']['key'],$pi->config['brdata']['secret']);
	
}

if(isset($pi->config['labbroker']['1-wire']) && is_array($pi->config['labbroker']['1-wire'])) {
	foreach($pi->config['labbroker']['1-wire'] as $id=>$sens){
		$temp = $pi->read1Wire($id,$sens);
		if($temp !== false){
			if(isset($sens['topic']))
				$mqtt->publish($sens['topic'], $temp,0);
			if(isset($sens['brdata']))
				$brdata->queueAdd($sens['brdata'][0], $sens['brdata'][1], $temp);
			
		}
	}
}

if(isset($pi->config['labbroker']['DHT']) && is_array($pi->config['labbroker']['DHT'])) {
	foreach($pi->config['labbroker']['DHT'] as $id=>$sens){
		$ret = $pi->readDHT($id,$sens);
		
		if(isset($sens['topic']))
			foreach($sens['topics'] as $k=>$top){
				$mqtt->publish($top, $ret[$k],0);
			}
		if(isset($sens['brdata']))
			foreach($sens['brdata'] as $k=>$top){
				$brdata->queueAdd($top[0], $top[1], $ret[$k]);
			}
		
	}
}

if(count($brdata->queue))
	$brdata->queuePublish();


if(isset($pi->config['mqtt'])){
	$mqtt->close();
}