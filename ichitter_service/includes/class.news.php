<?php
//error_reporting(E_ALL);
class News extends commonGeneric {
    public $ObjJSON;
    public function __construct(){
		$this->ObjJSON = new Services_JSON();
    }
	
	public function get_unread_news_count($data,$innercircle_ids){
		//return $data;
		$result = $this->ObjJSON->decode($innercircle_ids);
		//return sizeof($result);
		if(sizeof($result)){
		$arr_ids = array();
		foreach($result as $k => $v){
		  $arr_ids[] = $v->cont_user_joined_id;
		}
		
		//$sql = "SELECT COUNT(*) AS total FROM tbl_news WHERE news_user_id IN (".implode(',', $arr_ids).") AND news_added_time > (SELECT IF(COUNT(read_time)>0,read_time,0) FROM tbl_news_read WHERE read_user_id = ".$data['user_id']." ORDER BY read_id DESC LIMIT 1)";
		
		$sql = "SELECT COUNT(*) as total FROM tbl_news_read WHERE read_user_id = ".$data['user_id'];
		
		$result = $this->query_Exe($sql);
		
		$row = $this->fetch_row($result);
		
		
		if($row['total'] > 0){
			$sql = "SELECT COUNT(*) AS total FROM tbl_news WHERE news_user_id IN (".implode(',', $arr_ids).") AND news_added_time > (SELECT read_time FROM tbl_news_read WHERE read_user_id = ".$data['user_id']." ORDER BY read_time DESC LIMIT 1)";
		}else{
			$sql = "SELECT COUNT(*) AS total FROM tbl_news WHERE news_user_id IN (".implode(',', $arr_ids).") AND news_added_time > 0";
		}
		//return $sql; 
		$result = $this->query_Exe($sql);
		$arr = $this->fetch_row($result);
		
		}else{
			$arr = array('total'=>0);
		}
		return $this->ObjJSON->encode($arr);
	}
    
    public function get_all_newsstreams($data,$user_id){    
	   if(trim($data)){
		   $result = $this->ObjJSON->decode($data);
		   $arr_ids = array();
		   foreach($result as $k => $v){
			   $arr_ids[] = $v->cont_user_joined_id;
		   }
       }
       $sql = "SELECT tup.user_id,
					  CONCAT(tup.first_Name,' ',tup.last_Name) AS  name,
					  tup.email,
					  tpriv.priv_name,
					  tn.news,
					  tn.news_rel_id,
					  tn.news_added_time,
					  (SELECT read_time FROM 
										tbl_news_read WHERE read_user_id = ".$user_id." 
										ORDER BY 
										read_id DESC LIMIT 1) as read_time 
					  FROM tbl_user_profile tup 
					  LEFT JOIN tbl_news tn ON ( tup.user_id = tn.news_user_id ) 
					  LEFT JOIN tbl_security_private tpriv ON (tpriv.user_id = tup.user_id) 
					  WHERE ";
					if(trim($data)){
					  $sql .= " tn.news_user_id IN (".implode(',', $arr_ids).") ";
					}else{
						$sql .= " tn.news_user_id = ".$user_id;
					}
					  $sql .= " ORDER BY tn.news_added_time DESC";
       //return $sql;
	   $result = $this->query_Exe($sql);
       $arr = array();
       while($data = $this->fetch_row($result)){
	   		if($data['news_rel_id'] > 0){
			
				switch($data['news']){
					case 'Groups':
						$sql = "SELECT group_name from ".USER_GROUPS." WHERE group_id = ".$data['news_rel_id'];
					break;					
					case 'Group Members':
						//$sql = "SELECT group_name from ".GROUP_MEMBERS." WHERE group_id = ".$data['news_rel_id'];
						//$sql ="SELECT group_name FROM ".USER_GROUPS." tg LEFT JOIN ".GROUP_MEMBERS." tgm ON (tg.group_id = tgm.group_id) WHERE tgm.gm_id = ".$data['news_rel_id'];

						$sql ="SELECT tg.group_id,tg.group_name,tup.first_name,tup.email,tpriv.priv_name FROM tbl_groups tg LEFT JOIN tbl_group_members tgm ON (tg.group_id = tgm.group_id) 
								LEFT JOIN tbl_user_profile tup ON (tgm.user_id_joined = tup.user_id) 
								LEFT JOIN tbl_security_private tpriv ON (tpriv.user_id = tup.user_id) 
								WHERE tgm.gm_id =".$data['news_rel_id'];


					break;
					case 'Added Friend':
						$sql = "SELECT user_id,CONCAT(first_Name,' ',last_Name) AS  name FROM tbl_user_profile WHERE user_id = ".$data['news_rel_id'];
					break;
					case 'Requested Friend':
						$sql = "SELECT user_id,CONCAT(first_Name,' ',last_Name) AS  name FROM tbl_user_profile WHERE user_id = ".$data['news_rel_id'];
					break;
				}
				
				$result1 = $this->query_Exe($sql);
				$data['news_rel_details'] = $this->fetch_row($result1);
			}
           $arr[] = $data;
       }
       return $this->ObjJSON->encode($arr);
    }
	
	public function update_read($data){
		
		$sql = "INSERT INTO tbl_news_read SET read_user_id = ".$data['read_user_id'].", read_time = NOW()";
		//return $sql;
		$result = $this->query_Exe($sql);		
		return $result;
	}
	
	
}

?>