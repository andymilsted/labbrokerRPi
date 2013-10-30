<?php

include("../config.php");
include("../lib/labbrokerRPi.php");

if(isset($config['ddns'])){
	file_get_contents($config['ddns']);
}
