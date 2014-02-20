<?php
require_once 'class.commonGeneric.php';
class Request extends commonGeneric {	
	public function get_all_request($data){
		$sql = 'SELECT COUNT(response_user_id) AS total from tbl_addfriend WHERE addfrnd_flag = 1 and  response_user_id = '.$data['user_id'];
		
		$result = $this->fetch_row($this->query_Exe($sql));	
		return $this->encode($result);
	}
		
	public function get_all_requestdetails($data){
		$sql = 'select distinct tup.user_id, concat(tup.first_Name," ", tup.last_Name) as name, tup.gender, tup.email, tup.profile_image, ti.image_name, tig.igallery_name, tspub.pub_name, ts.state_name, taf.addfrnd_flag, taf.deny_flag  from tbl_user_profile tup LEFT JOIN tbl_group_members tgm ON (tup.user_id = tgm.user_id_joined) LEFT JOIN tbl_images ti ON (tup.profile_image = ti.image_id) LEFT JOIN tbl_igallery tig ON (ti.igallery_id = tig.igallery_id) LEFT JOIN tbl_security_public tspub ON (tup.user_id = tspub.user_id) LEFT JOIN tbl_state  ts ON (tup.state = ts.state_abbreviation) LEFT JOIN tbl_addfriend taf on (tup.user_id = taf.request_user_id) where taf.addfrnd_flag = 1 and taf.response_user_id = '.$data['user_id'].' ORDER BY addfrnd_id DESC';
		$result = $this->query_Exe($sql);	
		$result_arr = array();
		while($data = $this->fetch_row($result)){
			$result_arr[] = $data;
		}
		return $this->encode($result_arr);
	}
	
	public function get_req_status($data){
		$sql = "SELECT COUNT(response_user_id) AS total from tbl_addfriend WHERE request_user_id = ". $data['session_user_id'] ." response_user_id = ".$data['user_id'];
		//return $sql;
		$result = $this->fetch_row($this->query_Exe($sql));	
		return $this->encode($result);
	}
	
	public function get_deny_status($data){
		$sql = "SELECT deny_flag from tbl_addfriend WHERE response_user_id = ".$data['user_id'];
		//return $sql;
		$result = $this->fetch_row($this->query_Exe($sql));	
		return $this->encode($result);
	}
}


?>