<?php

include("../config.php");
include("../lib/labbrokerRPi.php");

include("../lib/php-serial/php_serial.class.php");

if(file_exists('/var/run/labbrokerRPi-digitalArduino.pid')){
	$opid = file_get_contents('/var/run/labbrokerRPi-digitalArduino.pid');
	if(file_exists("/proc/$opid")){
		die("allready running\n");
	}
}
file_put_contents('/var/run/labbrokerRPi-digitalArduino.pid',getmypid());

$pi = new labbrokerRPi($config);

if(!isset($pi->config['arduino'])){
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
		foreach($read as $rd){
		$line = explode(":",$rd);
			if(!isset($pi->config['arduino']['digital'][(int)$line[0]])){
				continue;
			}
			$sens = $pi->config['arduino']['digital'][(int)$line[0]];
			if(isset($sens['topic']) && isset($pi->config['mqtt']))
				$mqtt->publish($sens['topic'], (int)$line[1],0);
			if(isset($sens['brdata'])  && isset($pi->config['brdata'])){
				$data = array();
				$data['set'] = $sens['brdata'][0];
				$data['time'] = time();
				$data["channels"] = array(array("channel"=>$sens['brdata'][1],"value"=>(int)$line[1]));
				$brdata->publish($data);
			}
		}
			
	}	
	usleep(500);
}


