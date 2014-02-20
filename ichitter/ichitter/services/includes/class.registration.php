<?php
include_once 'lib/common.php';
error_reporting(0);
class URegistration extends Common {
	
	public function validate_existing_user($data){
		$result = $this->json_Decode($data);		
		$sql = 'select count(email) as total from tbl_user_profile where email = "'.$result['email'].'"';
		$result = $this->fetch_row($this->query_Exe($sql));	
		return $this->json_Encode($result);
	}
	
	public function insert_Data($data){	
		$result = $this->json_Decode($data);	
		
		//$sql = 'Insert into tbl_user_profile set first_name = "'.$result['firstname'].'", last_name = "'.$result['lastname'].'", date_of_birth = "'.$result['dob'].'", email = "'.$result['email'].'", state = "'.$result['state'].'", passw = "'.$result['password'].'"';
		$sql = "Insert into tbl_user_profile set first_name = '" . $result['firstname'] . "', last_name = '".$result['lastname'] . "', email = '" . $result['email'] . "' , state = '" . $result['state'] . "', passw = '" . $result['password']. "'";
		
		$result = $this->query_Exe($sql);
		if($result == 1){
			return $this->json_Encode(array('success'=>$result));
		}else{
			return $this->json_Encode(array('error'=>'false'));
		}
	}	
}

$usrreg_obj = new URegistration;
?>