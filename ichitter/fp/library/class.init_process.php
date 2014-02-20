<?php
class INIT_PROCESS {	
	public $response;
	public function  __construct($url,$data){
		$this->response = $this->call_curl_function($url, $data);
	}
	
	public function getUserGallery($url,$data) {		
		$this->response = $this->call_curl_function($url, $data);
 	}
 
	 public function call_curl_function($url, $data){	
		$ch = curl_init();
		/*
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_VERBOSE, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_URL, $url );
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
		*/
		
		//curl_setopt($ch, CURLOPT_POST, 1);
		//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
		/*
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_VERBOSE, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_URL, $url );
		//curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data); */
		$result = curl_exec($ch);	
		//echo $result;
		return $result;
	}
 
}
?>