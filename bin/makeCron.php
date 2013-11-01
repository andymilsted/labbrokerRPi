#!/usr/bin/php
<?php

include("../config.php");
include("../lib/labbrokerRPi.php");

$cronfile[] = "# /etc/cron.d/labbrokerRPi: crontab fragment for labbrokerRPi\n";

$cronfile[] = "# Read Sensors every 1 min";
$cronfile[] = "* *	* * *	root	cd {$config['pwd']}/bin; php sensorRead.php";

$rand = rand(1,14);
$mins = $rand.",".($rand+15).",".($rand+30).",".($rand+45);

$cronfile[] = "# Run run10Mins every 15 mina";
$cronfile[] = "{$mins} *	* * *	root	cd {$config['pwd']}/bin; php run10Mins.php";

file_put_contents("/etc/cron.d/labbrokerRPi", join("\n",$cronfile)."\n");
