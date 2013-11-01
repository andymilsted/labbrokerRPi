#!/usr/bin/php
<?php

chdir(__DIR__);


include("../config.php");
include("../lib/labbrokerRPi.php");

#Init.d

$init = file_get_contents("../lib/install/initd-labbrokerRPi");

$init = str_replace("__DIR__", $config['pwd']."/bin", $init);

file_put_contents("/etc/init.d/labbrokerRPi", $init);

chmod("/etc/init.d/labbrokerRPi", 0755);