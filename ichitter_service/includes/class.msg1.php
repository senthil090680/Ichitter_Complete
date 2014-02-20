<?php
//error_reporting(E_ALL);
class Msg extends commonGeneric {

	public function getcount_unread_msg($data){
		$sql = 'SELECT COUNT(msg_flag) AS total FROM tbl_msg WHERE msg_flag = 0 && receiver_user_id = '.$data['user_id'];
		
		$result = $this->fetch_row($this->query_Exe($sql));	
		return $this->encode($result);
	}
	
	public function get_indivitual_msg($data){
	
		$sql = 'select distinct tup.user_id, concat(concat(UCASE(SUBSTRING(tup.first_Name, 1, 1)),LCASE(SUBSTRING(tup.first_Name, 2)))," ", concat(UCASE(SUBSTRING(tup.last_Name, 1, 1)),LCASE(SUBSTRING(tup.last_Name, 2)))) as name, tup.gender, tup.email, tup.profile_image, ti.image_name, tig.igallery_name, tspriv.priv_name from tbl_user_profile tup LEFT JOIN tbl_images ti ON (tup.profile_image = ti.image_id) LEFT JOIN tbl_igallery tig ON (ti.igallery_id = tig.igallery_id) LEFT JOIN tbl_security_private tspriv ON (tup.user_id = tspriv.user_id) WHERE tup.user_id = '.$data['receiver_user_id'];
		
		$result = $this->query_Exe($sql);
		
		$indivitual_data = $this->fetch_row($result);
		
		
		$sql = "SELECT *,(SELECT DATE_FORMAT(msg_sent_time, '%M %d')) as msg_sent_time,TIME_TO_SEC((SELECT TIMEDIFF(NOW(),msg_sent_time))) as msgsenttime,(SELECT reply_msg_id from tbl_reply where tbl_msg.msg_id = msg_id) as reply FROM tbl_msg where 
								(sender_user_id = ".$data['sender_user_id']." && 
								receiver_user_id = ".$data['receiver_user_id'] .") OR 
								(sender_user_id = ".$data['receiver_user_id']." && 
								receiver_user_id = ".$data['sender_user_id'] .") ORDER BY msg_id DESC";
								
		$result = $this->query_Exe($sql);
		$result_arr = array();	
		while($data = $this->fetch_row($result)){
		
			$data['msgsenttime'] = $this->secondsToTime($data['msgsenttime']);
			
			
			if(date('F d') == $data['msg_sent_time']){
				if($data['msgsenttime']['h'] > 0){
					$data['msg_sent_time'] = $data['msgsenttime']['h'] . " Hours ago";
				}elseif($data['msgsenttime']['m'] > 0){
					$data['msg_sent_time'] = $data['msgsenttime']['m'] . " Minites ago";
				}elseif($data['msgsenttime']['s'] > 0){
					$data['msg_sent_time'] = $data['msgsenttime']['s'] . " Seconds ago";
				}
			}
			
			$result_arr[] = $data;
			
		}
		
		$indivitual_data['msg'] = $result_arr;
		
		return $this->encode($indivitual_data);
		
		
	}
	
	public function getall_msg($data){
		$sql = 'select distinct tup.user_id, concat(concat(UCASE(SUBSTRING(tup.first_Name, 1, 1)),LCASE(SUBSTRING(tup.first_Name, 2)))," ", concat(UCASE(SUBSTRING(tup.last_Name, 1, 1)),LCASE(SUBSTRING(tup.last_Name, 2)))) as name, tup.gender, tup.email, tup.profile_image, ti.image_name, tig.igallery_name, tspriv.priv_name, tms.msg_id, tms.msg,(SELECT DATE_FORMAT(tms.msg_sent_time, "%M %d")) as msg_sent_time,TIME_TO_SEC((SELECT TIMEDIFF(NOW(),tms.msg_sent_time))) as msgsenttime, tms.msg_flag from tbl_user_profile tup LEFT JOIN tbl_msg tms ON(tup.user_id = tms.sender_user_id) LEFT JOIN tbl_reply trp ON(tms.msg_id = trp.msg_id)  LEFT JOIN tbl_images ti ON (tup.profile_image = ti.image_id) LEFT JOIN tbl_igallery tig ON (ti.igallery_id = tig.igallery_id) LEFT JOIN tbl_security_private tspriv ON (tup.user_id = tspriv.user_id) WHERE tms.receiver_user_id = '.$data['user_id'].' ORDER BY tms.msg_id DESC';
		
		$result = $this->query_Exe($sql);
		$result_arr = array();	
		while($data = $this->fetch_row($result)){
			$result_arr[] = $data;
		}
		rsort($result_arr);
		$new_arr = array();
		foreach($result_arr as $k => $v){
			if(!$k || $u_id != $v['user_id']){
				//$v['msg'] = end(explode('<br />',$v['msg']));				
				$v['msgsenttime'] = $this->secondsToTime($v['msgsenttime']);
				if(date('F d') == $v['msg_sent_time']){
					if($v['msgsenttime']['h'] > 0){
						$v['msg_sent_time'] = $v['msgsenttime']['h'] . " Hours ago";
					}elseif($v['msgsenttime']['m'] > 0){
						$v['msg_sent_time'] = $v['msgsenttime']['m'] . " Minites ago";
					}elseif($v['msgsenttime']['s'] > 0){
						$v['msg_sent_time'] = $v['msgsenttime']['s'] . " Seconds ago";
					}
				}
				$new_arr[] = $v;
				$u_id = $v['user_id'];
				
			}
		}
		
		return $this->encode($new_arr);
	}

	public function sendmsg($data){
        return print_r($data);
		if($this->badword_filter($data['val'])){			
			$msg = mysql_escape_string($data['val']);	
			$action = $data['action'];
			switch($action){
                    case 'replymsg':
				case 'sendmsg':
                        $sql = "SELECT msg_id,msg FROM tbl_msg 
         WHERE  (SELECT DATE_FORMAT(msg_sent_time ,'%M %d')) = (SELECT DATE_FORMAT(NOW() ,'%M %d')) AND sender_user_id = ".$data['sender_user_id']." AND receiver_user_id = ".$data['receiver_user_id']." ORDER BY msg_id DESC LIMIT 1";
                        return $sql;
                        $result = $this->query_Exe($sql);
                        $old_val =  $this->fetch_row($result);
                        
                        $r = 0;
                        if(isset($old_val['msg_id'])){
                            
                            $sql ="SELECT COUNT(*) AS total from tbl_msg WHERE msg_id > ".$old_val['msg_id']." && sender_user_id = ". $data['receiver_user_id'] ." && receiver_user_id = ". $data['sender_user_id'] ." ORDER BY msg_id DESC LIMIT 1";
                            return $sql;
                            $result = $this->query_Exe($sql);
                            $c =  $this->fetch_row($result);
                            
                            if($c['total']){
                                $r = 1;
                            }
                            
                        
                            
                        }

                        if(isset($old_val['msg']) && !$r){
                              $old_val['msg'] .= '<br />'.$msg;
                             $sql = "UPDATE tbl_msg SET msg  = '".$old_val['msg']."', msg_flag = 0, msg_sent_time = now()  WHERE msg_id = ".$old_val['msg_id'];
                        }else{
                             $sql = "INSERT INTO tbl_msg SET sender_user_id = ".$data['sender_user_id'].", receiver_user_id = ".$data['receiver_user_id'].", msg = '".$msg."', msg_sent_time = now(),msg_flag = 0";
                        }
                        
				break;
//				case 'replymsg':
//                        
//                        $sql = "SELECT COUNT(*) as total from tbl_msg WHERE msg_id > (SELECT COUNT(*) as total from tbl_msg WHERE sender_user_id = ".$data['sender_user_id']." && receiver_user_id = ".$data['receiver_user_id']." ORDER BY msg_id DESC limit 1) && sender_user_id = ".$data['receiver_user_id']." && receiver_user_id = ".$data['sender_user_id'];
//                        
//                        $result = $this->query_Exe($sql);
//                        
//                        $sql = "SELECT msg_id,msg FROM tbl_msg WHERE msg_id = (SELECT reply_msg_id FROM tbl_reply WHERE msg_id = ".$data['msg_id'].")";
//
//                        $result = $this->query_Exe($sql);
//                        $old_val =  $this->fetch_row($result);
//
//                        if(isset($old_val['msg']) || $result['total']){
//                              $old_val['msg'] .= '<br />'.$msg;
//                             $sql = "UPDATE tbl_msg SET msg  = '".$old_val['msg']."', msg_flag = 0, msg_sent_time = now()  WHERE msg_id = ".$old_val['msg_id'];
//                        }else{
//                             $sql = "INSERT INTO tbl_msg SET sender_user_id = ".$data['sender_user_id'].", receiver_user_id = ".$data['receiver_user_id'].", msg = '".$msg."', msg_sent_time = now(),msg_flag = 0";
//                        }
//				break;
			}
               
//               Array
//(
//    [action] => replymsg
//    [val] => third
//    [sender_user_id] => 52
//    [receiver_user_id] => 18
//    [msg_id] => 2
//)
               
			//return $sql;
			$result = $this->query_Exe($sql);
			$last_id = mysql_insert_id();
			if($result == 1){
				if(isset($data['msg_id']) && !isset($old_val['msg'])){
					$sql = "INSERT INTO tbl_reply SET msg_id = ".$data['msg_id'].", reply_msg_id = ".$last_id.", reply_time = (SELECT msg_sent_time FROM tbl_msg WHERE msg_id = ".$last_id.")";
					$result = $this->query_Exe($sql);
					if($result == 1){
							$result = $this->encode(array('success'=>'OK'));
					}else{
						$result = $this->encode(array('failure'=>'OK'));
					}
				}
				$result = $this->encode(array('success'=>'OK'));
			}else{
				$result = $this->encode(array('failure'=>'OK'));
			}
				
			return $result;
		}else{
			return $this->encode(array('badword'=>'OK'));
		}
		/**/
	}
	
	public function readmsg($data){
		if(isset($data['user_id'])){
			$ids = explode(':',$data['user_id']);
			$sql = "UPDATE tbl_msg SET msg_flag = 1 WHERE receiver_user_id = ".$ids[0]." AND sender_user_id = ".$ids[1];
		}else{
			$sql = "UPDATE tbl_msg SET msg_flag = 1 WHERE msg_id = ".$data['val'];
		}
		$result = $this->query_Exe($sql);
		if($result == 1){
				$result = $this->encode(array('success'=>'OK'));
			}else{
				$result = $this->encode(array('failure'=>'OK'));
			}
				
			return $result;
	}
	
	
}

?>