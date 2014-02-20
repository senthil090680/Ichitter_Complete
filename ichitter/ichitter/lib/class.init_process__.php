<?php
class INIT_PROCESS{	
	public $response;
	public function  __construct($url,$data){	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_VERBOSE, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_URL, $url );
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
		$this->response = curl_exec($ch);						
	}
}
?>