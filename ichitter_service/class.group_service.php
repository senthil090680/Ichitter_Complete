<?php
error_reporting(0);
require_once "includes/dbobj.php";
require_once "includes/json.php";
require_once "includes/class.commonGeneric.php";
require_once "includes/define.php";

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
		  $grpidgg = $row['group_id'];
		  $selusercount = mysql_query("SELECT user_id_joined FROM `tbl_group_members` WHERE group_id='".$row['group_id']."' AND is_active='1'");
		  $user_joined_count = mysql_num_rows($selusercount);
          $usr_jnd = "";	
          if($user_joined_count > 0){		  
		  while($fetch_posting = mysql_fetch_array($selusercount)){
		     $usr_jnd = $fetch_posting['user_id_joined'];
		     $posting_id = array();
		     $topic_id = array();
		     $sub_topic_id = array();
		     $user_id = array();
		     $title = array();
		     $post_content = array();
		     $posted_on = array();			   
		   $selec_posting = mysql_query("SELECT posting_id,topic_id,sub_topic_id,user_id,title,post_content,posted_on FROM tbl_posting WHERE user_id = '$usr_jnd'");		   
		   while($fet_posting = mysql_fetch_array($selec_posting)){
		     $posting_id[] = $fet_posting['posting_id'];
		     $topic_id[] = $fet_posting['topic_id'];
		     $sub_topic_id[] = $fet_posting['sub_topic_id'];
			 $uname_text =$this->_get_user_name($fet_posting['user_id']);
		     $user_id[] = $uname_text;
		     $title[] = $fet_posting['title'];
		     $post_content[] = $fet_posting['post_content'];
		     $posted_on[] = $fet_posting['posted_on'];			 
		   }
			  $gal['posting_id'][$grpidgg][] = $posting_id;		
			  $gal['topic_id'][$grpidgg][] = $topic_id;		
			  $gal['sub_topic_id'][$grpidgg][] = $sub_topic_id;		
			  $gal['user_id'][$grpidgg][] = $user_id;		
			  $gal['title'][$grpidgg][] = $title;		
			  $gal['post_content'][$grpidgg][] = $post_content;		
			  $gal['posted_on'][$grpidgg][] = $posted_on;				   
		  }
		  }
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

		function _get_group_or_joined($user_id){	  			
		
			$select = "SELECT grp.group_id AS group_id,grp.group_name AS group_name FROM `tbl_groups` AS grp LEFT JOIN `tbl_group_members` AS grpmem ON grp.group_id = grpmem.group_id WHERE (grp.user_id = '$user_id' OR grpmem.user_id_joined = '$user_id') GROUP BY grp.group_id ORDER BY grp.group_name ASC";

			$exec = mysql_query($select);
			$inc = 0;

			while($row=mysql_fetch_array($exec)){
			  $grpidgg = $row['group_id'];
			  $selusercount = mysql_query("SELECT user_id_joined FROM `tbl_group_members` WHERE group_id='".$row['group_id']."' AND is_active='1'");
			  $user_joined_count = mysql_num_rows($selusercount);
			  $usr_jnd = "";	
			  if($user_joined_count > 0){		  
			  while($fetch_posting = mysql_fetch_array($selusercount)){
				 $usr_jnd = $fetch_posting['user_id_joined'];
				 $posting_id = array();
				 $topic_id = array();
				 $sub_topic_id = array();
				 $user_id = array();
				 $title = array();
				 $post_content = array();
				 $posted_on = array();			   
			   $selec_posting = mysql_query("SELECT posting_id,topic_id,sub_topic_id,user_id,title,post_content,posted_on FROM tbl_posting WHERE user_id = '$usr_jnd'");		   
			   while($fet_posting = mysql_fetch_array($selec_posting)){
				 $posting_id[] = $fet_posting['posting_id'];
				 $topic_id[] = $fet_posting['topic_id'];
				 $sub_topic_id[] = $fet_posting['sub_topic_id'];
				 $uname_text =$this->_get_user_name($fet_posting['user_id']);
				 $user_id[] = $uname_text;
				 $title[] = $fet_posting['title'];
				 $post_content[] = $fet_posting['post_content'];
				 $posted_on[] = $fet_posting['posted_on'];			 
			   }
				  $gal['posting_id'][$grpidgg][] = $posting_id;		
				  $gal['topic_id'][$grpidgg][] = $topic_id;		
				  $gal['sub_topic_id'][$grpidgg][] = $sub_topic_id;		
				  $gal['user_id'][$grpidgg][] = $user_id;		
				  $gal['title'][$grpidgg][] = $title;		
				  $gal['post_content'][$grpidgg][] = $post_content;		
				  $gal['posted_on'][$grpidgg][] = $posted_on;				   
			  }
			  }
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

	function _get_groups_user_created_or_joined($user_id){
	  	//$select = "SELECT group_id FROM `tbl_group_members` WHERE user_id_joined = '$user_id' ORDER BY group_id ASC";

		$select = "SELECT grp.group_id AS group_id FROM `tbl_groups` AS grp LEFT JOIN `tbl_group_members` AS grpmem ON grp.group_id = grpmem.group_id WHERE (grp.user_id = '$user_id' OR grpmem.user_id_joined = '$user_id') GROUP BY grp.group_id ORDER BY grp.group_name ASC";

		$exec = mysql_query($select);
		$inc = 0;
		while($row=mysql_fetch_array($exec)){
		  $grp_id = $row['group_id'];
		  $selusercount = mysql_query("SELECT group_name FROM `tbl_groups` WHERE group_id='".$grp_id."'");
		  $user_joined = mysql_fetch_array($selusercount);
		  
		  $gal['gname'][] = $user_joined['group_name'];
		  $gal['gid'][] = $grp_id;		  
		  $inc++;		
		}
		if($inc == 0){
		 $return['success'] = "error";
		}else{
		 $return['success'] = $gal;		
		}
		return $this->ObjJSON->encode($return);
	}


	function _get_group_joined($user_id){
	  	$select = "SELECT group_id FROM `tbl_group_members` WHERE user_id_joined = '$user_id' ORDER BY group_id ASC";
		$exec = mysql_query($select);
		$inc = 0;
		while($row=mysql_fetch_array($exec)){
		  $grp_id = $row['group_id'];
		  $selusercount = mysql_query("SELECT group_name FROM `tbl_groups` WHERE group_id='".$grp_id."'");
		  $user_joined = mysql_fetch_array($selusercount);
		  
		  $gal['gname'][] = $user_joined['group_name'];
		  $gal['gid'][] = $grp_id;		  
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
	  	$arr = array();
        $fetch = array();
		$select = "SELECT user_id,group_id,group_name,whoweare,isay FROM `tbl_groups` WHERE group_id='$group_id'";
		$exec = mysql_query($select);
		$cnt = mysql_num_rows($exec);
		$fetch = mysql_fetch_array($exec);
		//$query = "SELECT te.event_id, te.event_user_id, te.event_title, te.event_date, te.event_description FROM tbl_events te LEFT JOIN tbl_group_members tgm ON (tgm.group_id = te.event_group_id) WHERE tgm.user_id_joined = te.event_user_id && tgm.is_active = 1 && te.event_group_id = ".$group_id;
             $query = "SELECT te.event_id,te.event_user_id,te.event_title,te.event_date,te.event_description,te.event_created_on,te.event_flag,te.event_group_id,CONCAT(tup.first_Name,' ',tup.last_Name) AS  name,
					  tup.email,
					  tpriv.priv_name FROM tbl_events te LEFT JOIN tbl_user_profile tup ON (te.event_user_id = tup.user_id) LEFT JOIN tbl_security_private tpriv ON (tpriv.user_id = tup.user_id) WHERE te.event_group_id = ".$group_id;
		$result = mysql_query($query);
		$fetch['events'] = array();
        while($data = mysql_fetch_assoc($result)){
            $fetch['events'][] = $data;
        }
		
		$arr = $fetch;
		
		if($cnt){
			$selquery = "SELECT user_id_joined FROM `tbl_group_members` WHERE user_id_joined='$user_id' AND group_id='$group_id'";
			$ex = mysql_query($selquery);
			$count = mysql_num_rows($ex);
			if($count > 0){
				$arr['error'] = "already joined"; 				
			}
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
		$this->transaction_start();
		$query = "INSERT INTO `tbl_group_members` (`user_id`, `group_id`, `user_id_joined`, `user_id_joined_date`) 
					  VALUES ('$user_id', '$group_id', '$user_id_join', now())";	
		//$executequery = mysql_query($query);
		
		$execute1 = $this->query_Exe($query);

		$last_id = mysql_insert_id();
		//echo $last_id;
		$data = array('user_id'=>$user_id,'tbl_id'=>TBL_GROUPS_MEMB,'rel_id'=>$last_id);
		$execute2 = $this->news_update($data);		
		
		if($execute1 == $execute2){
		
		$this->transaction_commit();
			$sql = "SELECT COUNT(cont_user_id) AS total FROM tbl_contacts WHERE cont_user_id = ".$user_id." AND cont_user_joined_id = " .$user_id_join;
			
$qry_result = mysql_query($sql);
			$count_contact = mysql_fetch_assoc($qry_result);
			if($count_contact['total'] == 0){
			$query = "INSERT INTO tbl_contacts (cont_user_id,cont_user_joined_id) values ( ".$user_id.", " .$user_id_join ."),( ".$user_id_join.", " .$user_id .")";
			$executequery = mysql_query($query);
			}
		 $return['success'] = "success";
		}
		}else{
		$this->transaction_rollback();
		 $return['success'] = "error";
		}
		return $this->ObjJSON->encode($return);
	}
	function _delete_member($user_id,$group_id){
	    $selquery = "UPDATE `tbl_group_members` SET `is_active` = '0' WHERE user_id_joined = '$user_id' AND group_id='$group_id'";
		$ex = mysql_query($selquery);
		if($ex){
		 $return['success'] = "success";
		}else{
		 $return['success'] = "error";
		}
		return $this->ObjJSON->encode($return);
	}	
	function _activate_member($user_id,$group_id){
	    $selquery = "UPDATE `tbl_group_members` SET `is_active` = '1' WHERE user_id_joined = '$user_id' AND group_id='$group_id'";
		$ex = mysql_query($selquery);
		if($ex){
		 $return['success'] = "success";
		}else{
		 $return['success'] = "error";
		}
		return $this->ObjJSON->encode($return);
	}		
	function _create_group($group_name,$WhoWeAre,$Isay,$user_id){
		
	  if($this->_checkGroup($group_name,$WhoWeAre,$Isay,$user_id) == 0){
	  
		$this->transaction_start();
		$query = "INSERT INTO `tbl_groups` (`group_id`, `user_id`, `group_name`, `whoweare`, `isay`, `created_date`) 
					  VALUES (NULL, '$user_id', '".mysql_real_escape_string($group_name)."', '".mysql_real_escape_string($WhoWeAre)."', '".mysql_real_escape_string($Isay)."', now())";			
		/*$execute = mysql_query($query);			
		if($execute){
		 $return['success'] = "success";
		}	
		}else{
		 $return['success'] = "error";
		}*/
		$execute1 = $this->query_Exe($query);
		$last_id = mysql_insert_id();

		$grpmem_query = "INSERT INTO tbl_group_members (user_id, group_id, user_id_joined, user_id_joined_date, is_active) VALUES ('$user_id', '$last_id', '$user_id', now(), '1' )";
					  
		$grpmemexecute = $this->query_Exe($grpmem_query);

		//echo $last_id;
		$data = array('user_id'=>$user_id,'tbl_id'=>TBL_GROUPS,'rel_id'=>$last_id);
		$execute2 = $this->news_update($data);		
		//return $this->ObjJSON->encode($execute1 .'=='. $execute2);	
		if($execute1 == $execute2){
			$this->transaction_commit();
			$return['success'] = "success";
		}	
		}else{
			$this->transaction_rollback();
	 		$return['success'] = "error";
		}
		return $this->ObjJSON->encode($return);
	}
	function _get_chat_members($user_id,$group_id){
	  	$select = "SELECT user_id,group_id,user_id_joined,is_active FROM `tbl_group_members` WHERE group_id='$group_id' ORDER BY user_id_joined ASC";
		$exec = mysql_query($select);
		$inc = 0;
		while($row=mysql_fetch_array($exec)){
		  $joined_uid = $row['user_id_joined'];
		  $owner_id = $row['user_id'];		  
		  $selectQry = mysql_query("SELECT first_Name,last_Name,status FROM `tbl_user_profile` WHERE user_id='$joined_uid'");
		  $get_user_details = mysql_fetch_array($selectQry);
		  $selectQryOwner = mysql_query("SELECT first_Name,last_Name,status FROM `tbl_user_profile` WHERE user_id='$owner_id'");
		  $get_owner_details = mysql_fetch_array($selectQryOwner);		  
		  $user_name = $get_user_details['first_Name']." ".$get_user_details['last_Name'];
		  $owner_name = $get_owner_details['first_Name']." ".$get_owner_details['last_Name'];		  
		  $gal['uid'][] = $joined_uid; 
		  $gal['is_active'][] = $row['is_active']; 		  
		  $gal['uname'][] = $user_name; 
		  $gal['sts'][] = $get_user_details['status'];			  
		  $gal['gid'][] = $row['group_id'];	
		  $inc++;		
		}
		if($inc == 0){
		 $return['success'] = "error";
		}else{
		 $return['success'] = $gal;	
		 $return['owner_id'] = $owner_id;	
		 $return['owner_name'] = $owner_name;			 
		}
		return $this->ObjJSON->encode($return);		
	}
	function _get_postings_published($user_id,$group_id){
	  	$select = "SELECT user_id,group_id,user_id_joined,is_active FROM `tbl_group_members` WHERE group_id='$group_id' ORDER BY user_id_joined ASC";
		$exec = mysql_query($select);
		$inc = 0;
		while($row=mysql_fetch_array($exec)){
		  $joined_uid[] = $row['user_id_joined'];
		  $inc++;
		}
		$user_ids  = implode(",",$joined_uid);
		$sel_query = mysql_query("SELECT * FROM `tbl_posting` WHERE user_id IN ('$user_ids') ORDER BY posted_on DESC LIMIT 0,4");
		while($fet_posting = mysql_fetch_array($sel_query)){
		     $posting_id[] = $fet_posting['posting_id'];
		     $topic_id[] = $fet_posting['topic_id'];
		     $sub_topic_id[] = $fet_posting['sub_topic_id'];
		     $title[] = $fet_posting['title'];
		     $posted_on[] = $fet_posting['posted_on'];			 
		}
			  $gal['posting_id'] = $posting_id;		
			  $gal['topic_id'] = $topic_id;		
			  $gal['sub_topic_id'] = $sub_topic_id;			
			  $gal['title'] = $title;		
			  $gal['posted_on'] = $posted_on;	
		if($inc == 0){
		 $return['success'] = "error";
		}else{
		 $return['success'] = $gal;		 
		}
		return $this->ObjJSON->encode($return);		
	}	
	function _get_user_name($user_id){
	    $query = mysql_query("SELECT first_Name,last_Name FROM tbl_user_profile WHERE user_id='$user_id'");	
		$row=mysql_fetch_array($query);
		$username = $row['first_Name']." ".$row['last_Name'];
		return $username;
	}	
}	
$group_name = $_POST['group_name'];
$user_id = $_POST['user_id'];
$WhoWeAre = $_POST['WhoWeAre'];
$Isay = $_POST['Isay'];
$create = $_POST['create'];
$get_groups = $_POST['get_groups'];
$get_groups_user = $_POST['get_groups_user'];
$get_groups_user_or_joined = $_POST['get_groups_user_or_joined'];
$get_groups_user_joined = $_POST['get_groups_user_joined'];
$get_groups_user_created_or_joined = $_POST['get_groups_user_created_or_joined'];
$get_groups_detail = $_POST['get_groups_detail'];
$get_chat = $_POST['get_chat'];
$join_group = $_POST['join_group'];
$delete_member = $_POST['delete_member'];
$activate_member = $_POST['activate_member'];
$get_postings_published = $_POST['get_postings_published'];
$group_obj = new group_service();
//echo $add_group = $group_obj->_join_group($_GET['user_id'],$_GET['user_id_join'],$_GET['group_id']);
if(isset($create)){
echo $add_group = $group_obj->_create_group($group_name,$WhoWeAre,$Isay,$user_id);
}
if(isset($get_groups)){
echo $get_group = $group_obj->_get_full_group($user_id);
}
if(isset($get_groups_user)){
echo $get_group = $group_obj->_get_group($user_id);
}
if(isset($get_groups_user_or_joined)){
echo $get_group = $group_obj->_get_group_or_joined($user_id);
}
if(isset($get_groups_user_joined)){
echo $get_group_joined = $group_obj->_get_group_joined($user_id);
}
if(isset($get_groups_user_created_or_joined)){
echo $get_group_joined = $group_obj->_get_groups_user_created_or_joined($user_id);
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
if(isset($delete_member)){
$group_id = $_POST['group_id'];
echo $delete_member = $group_obj->_delete_member($user_id,$group_id);
}
if(isset($activate_member)){
$group_id = $_POST['group_id'];
echo $activate_member = $group_obj->_activate_member($user_id,$group_id);
}
if(isset($get_chat)){
$group_id = $_POST['group_id'];
echo $join_group = $group_obj->_get_chat_members($user_id,$group_id);
}
if(isset($get_postings_published)){
$group_id = $_POST['group_id'];
echo $get_postings_published = $group_obj->_get_postings_published($user_id,$group_id);
}
?>