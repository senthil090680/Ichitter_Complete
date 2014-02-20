<?php
class Security extends commonGeneric {	
	public function get_security($data){
		$sql = "SELECT * FROM tbl_security_private tspriv LEFT JOIN tbl_security_public tspub ON (tspriv.user_id = tspub.user_id) WHERE tspriv.user_id = ".$data['user_id'];
		$result = $this->fetch_row($this->query_Exe($sql));	
		return $this->encode($result);
		
	}
	
	public function security_setting($data){
		if($data['change'] == 'public'){
            $data['tbl_name'] = 'tbl_security_public';
			$this->news['tbl_id'] = 'Public';
			
			$s[] = "UPDATE ".$data['tbl_name']." SET ".$data['field_name']." = '".$data['val']."' WHERE user_id = ".$data['user_id'];
			$s[] = "UPDATE tbl_security_private SET ".str_replace('pub','priv',$data['field_name'])." = '".$data['val']."' WHERE user_id = ".$data['user_id'];               
		$this->news['user_id'] = $data['user_id'];
		

			foreach($s as $sql){
                   $this->news['user_id'] = $data['user_id'];
                   $r[] = $this->transaction($sql,$this->news);
               }
               
               if($r[0] == $r[1]){
                   return $this->encode(array('success'=>1));
               }
			
        }elseif($data['change'] == 'private'){    
			$this->news['tbl_id'] = 'Private';		
            $data['tbl_name'] = 'tbl_security_private';
			
			$sql = "UPDATE ".$data['tbl_name']." SET ".$data['field_name']." = '".$data['val']."' WHERE user_id = ".$data['user_id'];
		$this->news['user_id'] = $data['user_id'];
		return $this->transaction($sql,$this->news);
        }
		
		
		
	}
}
?>