<?php

include("../config.php");
include("../lib/labbrokerRPi.php");

include("../lib/php-serial/php_serial.class.php");

$pi = new labbrokerRPi($config);

if(isset($pi->config['arduino'])){
	exit();
}


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



// Let's start the class
$serial = new phpSerial;

// First we must specify the device. This works on both linux and windows (if
// your linux serial device is /dev/ttyS0 for COM1, etc)
$serial->deviceSet($pi->config['arduino']['tty']);

// We can change the baud rate, parity, length, stop bits, flow control
$serial->confBaudRate(9600);
$serial->confParity("none");
$serial->confCharacterLength(8);
$serial->confStopBits(1);
$serial->confFlowControl("none");

$serial->deviceOpen();


// Or to read from
while(1){
	// Or to read from
	$read = trim($serial->readPort());
	if(strlen($read)){
		$read = explode("\n\n",$read);
		print_r($read);
	}	
	usleep(500);
}


