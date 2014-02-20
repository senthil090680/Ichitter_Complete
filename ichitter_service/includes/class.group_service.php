<?php
class group_service extends commonGeneric{
    
        private $group_name;
        private $description;		
        private $user_id;
        private $json_error_arr = array();   
        private $ObjJSON; 		
        
    function __construct(){
		$this->ObjJSON = new Services_JSON();
    }
	function _checkGroup($group_name,$WhoWeAre,$Isay,$user_id){
	    $select = "SELECT group_name FROM `tbl_groups` WHERE group_name = '".mysql_real_escape_string($group_name)."' AND whoweare = '".mysql_real_escape_string($WhoWeAre)."' AND isay = '".mysql_real_escape_string($Isay)."' AND user_id = '$user_id'";
		$exec = mysql_query($select);
		$cnt = mysql_num_rows($exec);
		return $cnt;
	}
	function _get_group($user_id){
	  	$select = "SELECT group_id,group_name FROM `tbl_groups` WHERE user_id = '$user_id' ORDER BY group_name ASC";
		$exec = mysql_query($select);
		$inc = 0;
		while($row=mysql_fetch_array($exec)){
		  $selusercount = mysql_query("SELECT user_id_joined FROM `tbl_group_members` WHERE group_id='".$row['group_id']."'");
		  $user_joined_count = mysql_num_rows($selusercount);
		  $gal['gname'][] = $row['group_name'];
		  $gal['gid'][] = $row['group_id'];	
		  $gal['user_joined_count'][] = $user_joined_count;			  
		  $inc++;		
		}
		if($inc == 0){
		 $return['success'] = "error";
		}else{
		 $return['success'] = $gal;		
		}
		return $this->ObjJSON->encode($return);
	}
	function _get_full_group($user_id){
	  	$select = "SELECT group_id,group_name FROM `tbl_groups` ORDER BY group_name ASC";
		$exec = mysql_query($select);
		$inc = 0;
		while($row=mysql_fetch_array($exec)){
		  $gal['gname'][] = $row['group_name'];
		  $gal['gid'][] = $row['group_id'];	
		  $inc++;		
		}
		if($inc == 0){
		 $return['success'] = "error";
		}else{
		 $return['success'] = $gal;		
		}
		return $this->ObjJSON->encode($return);
	}	
	function _get_groups_detail($user_id,$group_id){
	  	$select = "SELECT user_id,group_id,group_name,whoweare,isay FROM `tbl_groups` WHERE group_id='$group_id'";
		$exec = mysql_query($select);
		$cnt = mysql_num_rows($exec);
		$fetch = mysql_fetch_array($exec);
		if($cnt != "0"){
			$selquery = "SELECT user_id_joined FROM `tbl_group_members` WHERE user_id_joined='$user_id' AND group_id='$group_id'";
			$ex = mysql_query($selquery);
			$count = mysql_num_rows($ex);
			if($count > 0){
				$arr['error'] = "already joined"; 				
			}
				$arr['group_name'] = $fetch['group_name'];
				$arr['whoweare'] = $fetch['whoweare'];
				$arr['isay'] = $fetch['isay'];	
				$arr['user_id'] = $fetch['user_id'];		
		}else{
		$arr['error'] = "error"; 
		}
		return $this->ObjJSON->encode($arr);		
	}

	function _join_group($user_id,$user_id_join,$group_id){
	    $selquery = "SELECT user_id FROM `tbl_group_members` WHERE user_id = '$user_id' AND user_id_joined='$user_id_join' AND group_id='$group_id'";
		$ex = mysql_query($selquery);
		$count = mysql_num_rows($ex);
		if($count == 0){
		$query = "INSERT INTO `tbl_group_members` (`user_id`, `group_id`, `user_id_joined`, `user_id_joined_date`) 
					  VALUES ('$user_id', '$group_id', '$user_id_join', now())";	
		$executequery = mysql_query($query);
		if($executequery){
		 $return['success'] = "success";
		}
		}else{
		 $return['success'] = "error";
		}
		return $this->ObjJSON->encode($return);
	}
	function _create_group($group_name,$WhoWeAre,$Isay,$user_id){
	  if($this->_checkGroup($group_name,$WhoWeAre,$Isay,$user_id) == 0){
		$query = "INSERT INTO `tbl_groups` (`group_id`, `user_id`, `group_name`, `whoweare`, `isay`, `created_date`) 
					  VALUES (NULL, '$user_id', '".mysql_real_escape_string($group_name)."', '".mysql_real_escape_string($WhoWeAre)."', '".mysql_real_escape_string($Isay)."', now())";			
		$execute = mysql_query($query);			
		if($execute){
		 $return['success'] = "success";
		}	
		}else{
		 $return['success'] = "error";
		}
		return $this->ObjJSON->encode($return);
	}
	
	public function get_innercircle_group_ids($user_id){
		$sql = "SELECT group_id FROM tbl_groups WHERE user_id = ".$user_id." UNION SELECT group_id FROM tbl_group_members WHERE user_id_joined = ".$user_id;
		$result = $this->query_Exe($sql);
		$group_id = array();
		while($data = $this->fetch_row($result)){
			$group_id[] = $data;
		}
		
		return $this->encode($group_id);
	}
	
	public function get_group_contact($data){
		$user_id = $data['user_id'];	
			$sql = "select distinct tup.user_id, tup.first_Name, tup.last_Name, tup.gender, tup.email, tup.profile_image, ti.image_name, tig.igallery_name, tspriv.priv_name, tspriv.priv_place, ts.state_name from tbl_user_profile tup LEFT JOIN tbl_group_members tgm ON (tup.user_id = tgm.user_id_joined) LEFT JOIN tbl_images ti ON (tup.profile_image = ti.image_id) LEFT JOIN tbl_igallery tig ON (ti.igallery_id = tig.igallery_id) LEFT JOIN tbl_security_private tspriv ON (tup.user_id = tspriv.user_id) LEFT JOIN tbl_state ts ON (tup.state = ts.state_abbreviation) LEFT JOIN tbl_addfriend taf on (tup.user_id = taf.response_user_id and taf.request_user_id = ".$user_id.") where tup.user_id IN( SELECT cont_user_joined_id FROM tbl_contacts WHERE cont_user_id = ".$user_id." )";
			$qry_result = $this->query_Exe($sql);
			$result = array();
			while($data = $this->fetch_row($qry_result)){
				$result[] = $data;
			}
			
			
		return $this->encode($result);
		
	}
	
	public function get_search_contact($data){
		$split = explode(':',$data['search']);
		
		$search = $split[0];
		$user_id = $split[1];
		
		//$sql = "select distinct tup.user_id, tup.first_Name, tup.last_Name, tup.gender, tup.email, tup.profile_image, ti.image_name, tig.igallery_name, tspub.pub_name, ts.state_name, taf.addfrnd_flag  from tbl_user_profile tup LEFT JOIN tbl_group_members tgm ON (tup.user_id = tgm.user_id_joined) LEFT JOIN tbl_images ti ON (tup.profile_image = ti.image_id) LEFT JOIN tbl_igallery tig ON (ti.igallery_id = tig.igallery_id) LEFT JOIN tbl_security_public tspub ON (tup.user_id = tspub.user_id) LEFT JOIN tbl_state  ts ON (tup.state = ts.state_abbreviation) LEFT JOIN tbl_addfriend taf on (tup.user_id = taf.response_user_id and taf.request_user_id = ".$user_id.")  where (tup.first_Name like '%".$search."%' or tup.last_Name like '%".$search."%' or tup.email like '%".$search."%') and tup.user_id not in( select cont_user_joined_id from tbl_contacts where cont_user_joined_id != ".$user_id." and cont_user_id in( SELECT cont_user_joined_id FROM tbl_contacts WHERE cont_user_id =".$user_id." )) and tup.user_id != ".$user_id;
		//$sql = "select distinct tup.user_id, tup.first_Name, tup.last_Name, tup.gender, tup.email, tup.profile_image, ti.image_name, tig.igallery_name, tspub.pub_name, ts.state_name, taf.addfrnd_flag, (SELECT COUNT(request_user_id) FROM tbl_addfriend WHERE (response_user_id = tup.user_id OR request_user_id = tup.user_id)) AS already_sent  from tbl_user_profile tup LEFT JOIN tbl_group_members tgm ON (tup.user_id = tgm.user_id_joined) LEFT JOIN tbl_images ti ON (tup.profile_image = ti.image_id) LEFT JOIN tbl_igallery tig ON (ti.igallery_id = tig.igallery_id) LEFT JOIN tbl_security_public tspub ON (tup.user_id = tspub.user_id) LEFT JOIN tbl_state  ts ON (tup.state = ts.state_abbreviation) LEFT JOIN tbl_addfriend taf on (tup.user_id = taf.response_user_id and taf.request_user_id = ".$user_id.")  where (tup.first_Name like '%".$search."%' or tup.last_Name like '%".$search."%' or tup.email like '%".$search."%') and tup.user_id not in( SELECT cont_user_joined_id FROM tbl_contacts WHERE cont_user_id =".$user_id." ) and tup.user_id != ".$user_id;
		$sql = "select distinct tup.user_id, tup.first_Name, tup.last_Name, tup.gender, tup.email, tup.profile_image, ti.image_name, tig.igallery_name, tspub.pub_name, ts.state_name, taf.addfrnd_flag, (SELECT COUNT(request_user_id) FROM tbl_addfriend WHERE response_user_id = ".$user_id.") AS already_sent, ( SELECT cont_user_joined_id FROM tbl_contacts WHERE cont_user_id =".$user_id." and cont_user_joined_id = tup.user_id) AS is_innercircle  from tbl_user_profile tup LEFT JOIN tbl_group_members tgm ON (tup.user_id = tgm.user_id_joined) LEFT JOIN tbl_images ti ON (tup.profile_image = ti.image_id) LEFT JOIN tbl_igallery tig ON (ti.igallery_id = tig.igallery_id) LEFT JOIN tbl_security_public tspub ON (tup.user_id = tspub.user_id) LEFT JOIN tbl_state  ts ON (tup.state = ts.state_abbreviation) LEFT JOIN tbl_addfriend taf on (tup.user_id = taf.response_user_id and taf.request_user_id = ".$user_id.")  where (tup.first_Name like '%".$search."%' or tup.last_Name like '%".$search."%' or tup.email like '%".$search."%')  and tup.user_id != ".$user_id;
		//return $sql;
		
		$qry_result = $this->query_Exe($sql);
		$result = array();
		while($data = $this->fetch_row($qry_result)){
			$result[] = $data;
		}
		
		if(sizeof($result) == 0){
			$result = array('contacts'=>'false');
		}
		return $this->encode($result);
	}
	
	public function add_friend_request($data){
		
		$split = explode(':',$data['ids']);
		$this->transaction_start();
		$sql = "INSERT INTO tbl_addfriend set request_user_id = ".$split[0].", response_user_id = ".$split[1].", addfrnd_flag = 1, requested_date = now(), deny_flag=0";
		$r1 = $this->query_Exe($sql);
		//$result = mysql_query($sql) or die(mysql_error());
		
		
		$data = array('user_id' => $split[0], 'tbl_id' => TBL_REQ_FRND, 'rel_id' => $split[1]);
        $r2 = $this->news_update($data);
		
		if($r1 == $r2){
              $this->transaction_commit();
		
			/* mail */
		$sql = 'select first_Name,last_Name,email from tbl_user_profile where user_id = "'.$split[0].'"';				
		$result = $this->fetch_row($this->query_Exe($sql));	
			
			$email = $result['email'];
			//$email = 'vj@emantras.com';
			$mail_format = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style>
.bgwrapper{width:1000px;background-color: #d2efff; min-height:400px; margin:0px auto; padding:80px 0 0 0;}
.page-wrapper{background-color:#FFFFFF;width:600px;border:solid 2px #3d86c3; min-height:200px; margin:0px auto; padding:0px 0 0 0;}
.header{background:url(http://tsg.emantras.com/dev_ichitter/ichitter/resource/images/mail-header-bg.png) top left;float:left;width:100%;height:30px; border:solid 0px #3d86c3; border-top:none;border-left:none;border-right:none;}
.content{margin-top:10px;float:left;height:auto;width:99%;border:solid 0px #3D86C3; font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px; padding-left:5px;}
.content h1{font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;font-weight:normal; }
.content h2{font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px; margin-top:15px; }
.spacer{height:10px;}
.headerlogo{ float:left; padding:0px 0 0 5px ; margin:0px;}
</style>
</head>
<div class="bgwrapper">
<div class="page-wrapper">
<div class="header"><div class="headerlogo"><img src="http://tsg.emantras.com/dev_ichitter/ichitter/resource/images/headerlogo.jpg" alt="" /></div></div>
<div class="content">
<h1>Hi '.$result['first_Name'].' '.$result['last_Name'].' wants to be friend with you on iChitter. <br /> Please login into iChitter and accept or deny.</h1>
<div class="spacer"></div>
<h1>Welcome to iChitter!</h1>
<div class="spacer"></div>
<h1>The iChitter Team</h1>
</div>

</div>
</div>
<body>
</body>
</html>';
define('FROMEMAILNAME',"from iChitter");
		$this->mail_send($email,'Friend request from iChitter',$mail_format);
		
		/* end */
		
			$result = array('success'=>'true');
		}else{
		$this->transaction_rollback();
			$result = array('error'=>'ok');
		}
		
		return $this->encode($result);
		
	}
	
	public function confirmfriend($data){
		if($data['status'] == 'confirm'){
		$this->query_Exe("SET AUTOCOMMIT=0");
		$this->query_Exe("START TRANSACTION");
		$sql = "INSERT INTO tbl_contacts (cont_user_id,cont_user_joined_id)  VALUES (".$data['response_user_id'].",".$data['request_user_id']."),(".$data['request_user_id'].",".$data['response_user_id'].")";
		//return $sql;
		$r1 = $this->query_Exe($sql);
		
		$sql = "UPDATE tbl_addfriend SET accepted_date = now(), addfrnd_flag = '0' WHERE response_user_id = ".$data['response_user_id']." AND request_user_id = ".$data['request_user_id'];
		//return $sql;
		$r2 = $this->query_Exe($sql);
		
		 $data = array('user_id' => $data['response_user_id'], 'tbl_id' => TBL_ADD_FRND, 'rel_id' => $data['request_user_id']);
         $r3 = $this->news_update($data);
		
			if(($r1 == 1) && ($r2 == 1) && ($r3 == 1)){
				$this->query_Exe('COMMIT');
				$result = array('success'=>'OK');
			}else{
				$this->query_Exe('ROLLBACK');
				$result = array('failure'=>'OK');		
			}
		}elseif($data['status'] == 'deny'){
			$sql = "UPDATE tbl_addfriend SET accepted_date = now(), deny_flag = '1' WHERE response_user_id = ".$data['response_user_id']." AND request_user_id = ".$data['request_user_id'];
			$result = $this->query_Exe($sql);
		
			if($result == 1){
				
				$result = array('success'=>'OK');
			}else{
				
				$result = array('failure'=>'OK');		
			}
		}
		
		return $this->encode($result);
	}
	
	public function get_innercircle_ids($data){
         $sql = "SELECT cont_user_joined_id FROM tbl_contacts WHERE cont_user_id = ".$data['user_id']." ORDER BY cont_user_joined_id ASC";
         $result = $this->query_Exe($sql);
         $result_arr = array();
         while ($data = $this->fetch_row($result)){
             $result_arr[] = $data;
         }
         
         return $this->encode($result_arr);
     }
	
}	
$group_name = $_POST['group_name'];
$user_id = $_POST['user_id'];
$WhoWeAre = $_POST['WhoWeAre'];
$Isay = $_POST['Isay'];
$create = $_POST['create'];
$get_groups = $_POST['get_groups'];
$get_groups_user = $_POST['get_groups_user'];
$get_groups_detail = $_POST['get_groups_detail'];
$join_group = $_POST['join_group'];
$group_obj = new group_service();
if(isset($create)){
echo $add_group = $group_obj->_create_group($group_name,$WhoWeAre,$Isay,$user_id);
}
if(isset($get_groups)){
echo $get_group = $group_obj->_get_full_group($user_id);
}
if(isset($get_groups_user)){
echo $get_group = $group_obj->_get_group($user_id);
}
if(isset($get_groups_detail)){
$group_id = $_POST['group_id'];
echo $get_groups_detail = $group_obj->_get_groups_detail($user_id,$group_id);
}
if(isset($join_group)){
$group_id = $_POST['group_id'];
$user_id_join = $_POST['user_id_join'];
echo $join_group = $group_obj->_join_group($user_id,$user_id_join,$group_id);
}
?>