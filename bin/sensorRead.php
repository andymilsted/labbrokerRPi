<?php

include("../config.php");
include("../lib/labbrokerRPi.php");
include("../lib/phpMQTT/phpMQTT.php");

$pi = new labbrokerRPi($config);

$mqtt = new phpMQTT($pi->config['mqtt']['server'], $pi->config['mqtt']['port'], "{$pi->config['labbroker']['pi_name']}_sR");

if (!$mqtt->connect()) {
	die("Can not connect to broker\n");
}


if(isset($pi->config['labbroker']['1-wire']) && is_array($pi->config['labbroker']['1-wire'])) {
	foreach($pi->config['labbroker']['1-wire'] as $id=>$sens){
		$temp = $pi->read1Wire($id,$sens);
		if($temp !== false){
			$mqtt->publish($sens['topic'], $temp,0);
		}
	}
}

if(isset($pi->config['labbroker']['DHT']) && is_array($pi->config['labbroker']['DHT'])) {
	foreach($pi->config['labbroker']['DHT'] as $id=>$sens){
		$ret = $pi->readDHT($id,$sens);
		foreach($sens['topics'] as $k=>$top){
			$mqtt->publish($top, $ret[$k],0);
		}
	}
}


$mqtt->close();