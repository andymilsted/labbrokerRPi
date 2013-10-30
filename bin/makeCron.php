<?php

include("../config.php");
include("../lib/labbrokerRPi.php");

$cronfile[] = "# /etc/cron.d/labbrokerRPi: crontab fragment for labbrokerRPi\n";

$cronfile[] = "# Read Sensors every 1 min";
$cronfile[] = "* *	* * *	root	cd {$config['pwd']}/bin; php sensorRead.php";

file_put_contents("/etc/cron.d/labbrokerRPi", join("\n",$cronfile));
