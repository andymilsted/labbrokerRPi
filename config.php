<?php

$config['pwd'] = __DIR__;

$config['mqtt'] = array("server"=>"labbroker.soton.ac.uk","port"=>1883);

$config['1w_path'] = '/mnt/hgfs/Tech/labbrokerRPi/testing';

$config['dht_path'] = "{$config['pwd']}/lib/bin/Adafruit_DHT_Test";

$config['labbroker']['pi_name'] = 'PiTest';

$config['labbroker']['1-wire']['28-000000000001'] = array(
	"type"=>"temp",
	"topic"=>"\$fabric/labbroker/\$feeds/\$onramp/Testing/TEMPERATURE:ROOM/TEMPERATURE",
	"sensor"=>"DS18B20"
);

$config['labbroker']['1-wire']['28-000000000002'] = array(
	"type"=>"temp",
	"topic"=>"\$fabric/labbroker/\$feeds/\$onramp/Testing/TEMPERATURE:ROOM/TEMPERATURE",
	"sensor"=>"DS18B20"
);

$config['labbroker']['DHT'][2] = array(
	"type"=>"dht",
	"topics"=> array(
		"\$fabric/labbroker/\$feeds/\$onramp/Testing/TEMPERATURE:ROOM/TEMPERATURE",
		"\$fabric/labbroker/\$feeds/\$onramp/Testing/TEMPERATURE:ROOM/TEMPERATURE"
	),
	"sensor"=>"dht22"
);


$config['ddns'] =  "http://ipv4.cloudns.net/api/dynamicURL/?q=MTA4MDExOjMyMTc2MTU6MjMzNzYyYTllY2E2YjYxNTJiYmIxODRjZmFlZGVkYzI5ZGYwYTg4OGE3YTM3ZTU3N2RjOWFlOGExZGIwZmNmMw";


