<?php
require_once 'mysql.php';
class Common extends MYsql{
	public function json_Encode($data){
		return json_encode($data);
	}
	
	public function json_Decode($data){
		$json = json_decode($data);
		$arr = array();
		foreach($json as $key => $val){
			$arr[$key] = $val;
		}		
		return $arr;
		
	}
}
?>