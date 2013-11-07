#!/usr/bin/php
<?php

chdir(__DIR__);

include("../config.php");
include("../lib/labbrokerRPi.php");

if(isset($config['ddns'])){
	file_get_contents($config['ddns']);
}

if(isset($config['labbroker']['DHT']) && count($config['labbroker']['DHT'])){
	`modprobe w1-gpio`;	
	`modprobe w1-therm`;
}

if(isset($config['arduino'])){
	
		exec("screen -d -m php digitalArduino.php > /dev/null 2>&1 &");
		
}
