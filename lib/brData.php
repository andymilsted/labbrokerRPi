<?php

class brData {

	public $url;
	public $key;
	public $sec;
	public $queue = array();
	
	
	function __construct($url,$key,$sec){
		$this->url = $url;
		$this->key = $key;
		$this->sec = $sec;
	}
	
	function queueAdd($set, $channel, $value){
		$this->queue[$set][] = array("channel"=>$channel,"value"=>$value);
	}
	
	function queuePublish(){
		foreach($this->queue as $set=>$chans){
			$data['set'] = $set;
			$data['time'] = time();
			$data["channels"] = $chans;
			$this->publish($data);
		}
	}
	
	
	function publish($data){
	
		$params['time'] = time();
		$params['id'] = $this->key;
		$params['hash'] = hash('sha256',$this->key.$params['time'].$this->sec);
		$params['data'] = json_encode($data);

		$ch = curl_init();		
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
			$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
	
	
	
	
}