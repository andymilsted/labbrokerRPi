<?php

class labbrokerRPi {
	
	public $config;
	
	function __construct($config){
		$this->config = $config;
	}
	
	function read1Wire($id,$sens){
		$file = "{$this->config['1w_path']}/$id/w1_slave";
		if(!file_exists($file)){
			return false;
		}
		
		$file_cont = file_get_contents($file);
		$file_lines = explode("\n",$file_cont);
	
		if(substr($file_lines[0],-3)!='YES') return false; //Check crc;
		switch($sens['sensor']){
			case "DS18B20":
				if(!($pos = strpos($file_lines[1],'t='))) return false; //find t=20209;
				$read = round((int)substr($file_lines[1],($pos+2))/1000,1); // round to 1dp;
			break;
		}
		
		return $read;
	}
	
	function readDHT($id,$sens){
		$cmd = "{$this->config['dht_path']} {$sens['sensor']} {$id}";
		$ret = `$cmd`;
		$file_lines = explode("\n",$ret);
		if(substr($file_lines[2],0,5)!="temp:") return false;
		if(substr($file_lines[3],0,6)!="humid:") return false;
		
		return array(substr($file_lines[2],5),substr($file_lines[3],6));

	}
	
	
	
}