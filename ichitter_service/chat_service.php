<?php
//error_reporting(0);
require_once "includes/dbobj.php";
require_once "includes/json.php";

class chat_service{
    
        private $group_id;
        private $user_id;		
        private $chatText;
        private $json_error_arr = array();   
        private $ObjJSON; 		
        
    function __construct(){
		$this->ObjJSON = new Services_JSON();
    }
	function _insert_chat($user_id,$group_id,$chatText){
	  if(($user_id != "") && ($group_id != "") && (trim($chatText) != "")){
	    $ts = time();
		$query = "INSERT INTO `tbl_chat` (`id`,`group_id`,`user_id`, `message`, `time_stamp`) 
					  VALUES (NULL, '$group_id', '$user_id', '$chatText', now())";	
		$executequery = mysql_query($query);
		if($executequery){
		 $return['response'] = "success";
		}else{
		 $return['response'] = "Query Not executed";
		}
	  }else{
		 $return['response'] = "error";	  
	  }	
	  
		return $this->ObjJSON->encode($return);	  
	}
	function _get_chat($user_id,$group_id){
	  if($user_id != "" && $group_id != ""){
	    $deletePrevious = mysql_query("DELETE FROM tbl_chat WHERE group_id='$group_id' AND time_stamp <= DATE_SUB(NOW(), INTERVAL 60 MINUTE)");	

		//$query = mysql_query("SELECT tgm.group_id AS gp_id,tc.user_id AS us_id,tc.message AS mesg FROM tbl_group_members as tgm LEFT JOIN tbl_chat as tc ON tgm.group_id = tc.group_id WHERE ((tgm.user_id='$user_id' OR tgm.user_id_joined='$user_id') and tgm.group_id in (SELECT tbc.group_id FROM tbl_chat as tbc WHERE tbc.time_stamp >= DATE_SUB(NOW(), INTERVAL 30 MINUTE) ORDER BY tbc.time_stamp ASC)) ORDER BY tgm.group_id ASC");

		$query = mysql_query("SELECT user_id,message FROM tbl_chat WHERE group_id='$group_id' AND time_stamp >= DATE_SUB(NOW(), INTERVAL 30 MINUTE) ORDER BY time_stamp ASC");

		$numrws = mysql_num_rows($query);
		if($numrws > 0){
		$i=0;
		$chatcontent = "";
		while($row=mysql_fetch_array($query)){
		 $usernm = $this->_get_user_name($row['user_id']);
		 $usernms = ucwords($usernm);
		 $Text = $row['message'];
		 $chatcontent .= "<div class='msgln'><b>".$usernms."</b>: ".stripslashes(htmlspecialchars($Text))."<br></div>";		 
		 $i++;
		}
			$return = $chatcontent;			
		 }else{
		  $return = "";	
		}
	  }	
		return $return;	  		
	}

	function _get_updchat($user_id,$group_id){
	  if($user_id != "" && $group_id != ""){
	    $deletePrevious = mysql_query("DELETE FROM tbl_chat WHERE group_id='$group_id' AND time_stamp <= DATE_SUB(NOW(), INTERVAL 60 MINUTE)");	

		//$query = mysql_query("SELECT tgm.group_id AS gp_id,tc.user_id AS us_id,tc.message AS mesg FROM tbl_group_members as tgm LEFT JOIN tbl_chat as tc ON tgm.group_id = tc.group_id WHERE ((tgm.user_id='$user_id' OR tgm.user_id_joined='$user_id') and tgm.group_id in (SELECT tbc.group_id FROM tbl_chat as tbc WHERE tbc.time_stamp >= DATE_SUB(NOW(), INTERVAL 30 MINUTE) ORDER BY tbc.time_stamp ASC)) ORDER BY tgm.group_id ASC");

		$query = mysql_query("SELECT user_id FROM tbl_chat WHERE group_id='$group_id' AND user_id != '$user_id' AND time_stamp >= DATE_SUB(NOW(), INTERVAL 3 SECOND) GROUP BY user_id ORDER BY time_stamp ASC");
		
		$numrws = mysql_num_rows($query);
		if($numrws > 0){
		  $row=mysql_fetch_array($query);
		  $grp_id = $row['user_id'];
          $return = $grp_id;	
		}else{
		  $return = "";	
		}
	  }
		return $return;	  		
	}

	function _get_usrupdchat($user_id,$group_id){
	  if($user_id != "" && $group_id != ""){
	    $deletePrevious = mysql_query("DELETE FROM tbl_chat WHERE group_id='$group_id' AND time_stamp <= DATE_SUB(NOW(), INTERVAL 60 MINUTE)");	

		//$query = mysql_query("SELECT tgm.group_id AS gp_id,tc.user_id AS us_id,tc.message AS mesg FROM tbl_group_members as tgm LEFT JOIN tbl_chat as tc ON tgm.group_id = tc.group_id WHERE ((tgm.user_id='$user_id' OR tgm.user_id_joined='$user_id') and tgm.group_id in (SELECT tbc.group_id FROM tbl_chat as tbc WHERE tbc.time_stamp >= DATE_SUB(NOW(), INTERVAL 30 MINUTE) ORDER BY tbc.time_stamp ASC)) ORDER BY tgm.group_id ASC");

		$query = mysql_query("SELECT user_id FROM tbl_chat WHERE group_id='$group_id' AND user_id != '$user_id' AND time_stamp >= DATE_SUB(NOW(), INTERVAL 7 SECOND) GROUP BY user_id ORDER BY time_stamp ASC");
		
		$numrws = mysql_num_rows($query);
		if($numrws > 0){
		  $row=mysql_fetch_array($query);
		  $grp_id = $row['user_id'];
          $return = $grp_id;	
		}else{
		  $return = "";	
		}
	  }
		return $return;	  		
	}

	function _click_get_chats($user_id,$group_id){
	  if($user_id != "" && $group_id != ""){
	    $deletePrevious = mysql_query("DELETE FROM tbl_chat WHERE group_id='$group_id' AND time_stamp <= DATE_SUB(NOW(), INTERVAL 3 DAY)");	

		$query = mysql_query("SELECT user_id,message FROM tbl_chat WHERE group_id='$group_id' ORDER BY time_stamp ASC");

		$numrws = mysql_num_rows($query);
		if($numrws > 0){
		$i=0;
		$chatcontent = "";
		while($row=mysql_fetch_array($query)){
		 $usernm = $this->_get_user_name($row['user_id']);
		 $usernms = ucwords($usernm);
		 $Text = $row['message'];
		 $chatcontent .= "<div class='msgln'><b>".$usernms."</b>: ".stripslashes(htmlspecialchars($Text))."<br></div>";		 
		 $i++;
		}
			$return = $chatcontent;			
		 }else{
		  $return = "";	
		}
	  }	
		return $return;	  		
	}

	function _open_cookie_chats($user_id,$group_id){
	  if($user_id != "" && $group_id != ""){
	    $deletePrevious = mysql_query("DELETE FROM tbl_chat WHERE group_id='$group_id' AND time_stamp <= DATE_SUB(NOW(), INTERVAL 3 DAY)");	

		$query = mysql_query("SELECT user_id,message FROM tbl_chat WHERE group_id='$group_id' AND time_stamp >= DATE_SUB(NOW(), INTERVAL 60 MINUTE) ORDER BY time_stamp ASC");

		$numrws = mysql_num_rows($query);
		if($numrws > 0){
		$i=0;
		$chatcontent = "";
		while($row=mysql_fetch_array($query)){
		 $usernm = $this->_get_user_name($row['user_id']);
		 $usernms = ucwords($usernm);
		 $Text = $row['message'];
		 $chatcontent .= "<div class='msgln'><b>".$usernms."</b>: ".stripslashes(htmlspecialchars($Text))."<br></div>";		 
		 $i++;
		}
			$return = $chatcontent;			
		 }else{
		  $return = "";	
		}
	  }	
		return $return;	  		
	}
	
	function _get_incomming_chats($user_id){
	  if($user_id != ""){
		//$query = mysql_query("SELECT DISTINCT(COUNT(tgm.group_id)), tgm.group_id AS gp_id,tc.user_id,tc.message FROM tbl_group_members as tgm LEFT JOIN tbl_chat as tc ON tgm.group_id = tc.group_id WHERE ((tgm.user_id='$user_id' OR tgm.user_id_joined='$user_id') and tgm.group_id in (SELECT tbc.group_id FROM tbl_chat as tbc WHERE tbc.time_stamp >= DATE_SUB(NOW(), INTERVAL 300 SECOND) GROUP BY tbc.group_id ORDER BY tbc.time_stamp ASC)) GROUP BY tgm.group_id");

		$query	=	mysql_query("SELECT tgm.group_id AS gp_id,tc.user_id 
				FROM tbl_group_members AS tgm 
				LEFT JOIN tbl_chat AS tc ON tgm.group_id = tc.group_id 
				WHERE
				((tgm.user_id='$user_id' OR tgm.user_id_joined='$user_id') 
				AND tgm.group_id IN (SELECT tbc.group_id 
						FROM tbl_chat AS tbc WHERE
						tbc.time_stamp >= DATE_SUB(NOW(), INTERVAL 3 SECOND)
						GROUP BY tbc.group_id 
						ORDER BY tbc.time_stamp ASC)) 
				GROUP BY tgm.group_id");

		$numrws = mysql_num_rows($query);
		if($numrws > 0){
			while($row=mysql_fetch_array($query)){
			 $grp_id[] = $row['gp_id'];
			}
          $return = $this->ObjJSON->encode($grp_id);	
		}else{
		  $return = "error";	
		}
	  }	
		return $return;	  		
	}
	
	function _get_grpincomming_chats($user_id){
	  if($user_id != ""){
		//$query = mysql_query("SELECT DISTINCT(COUNT(tgm.group_id)), tgm.group_id AS gp_id,tc.user_id,tc.message FROM tbl_group_members as tgm LEFT JOIN tbl_chat as tc ON tgm.group_id = tc.group_id WHERE ((tgm.user_id='$user_id' OR tgm.user_id_joined='$user_id') and tgm.group_id in (SELECT tbc.group_id FROM tbl_chat as tbc WHERE tbc.time_stamp >= DATE_SUB(NOW(), INTERVAL 300 SECOND) GROUP BY tbc.group_id ORDER BY tbc.time_stamp ASC)) GROUP BY tgm.group_id");

		$query	=	mysql_query("SELECT tgm.group_id AS gp_id,tc.user_id 
				FROM tbl_group_members AS tgm 
				LEFT JOIN tbl_chat AS tc ON tgm.group_id = tc.group_id 
				WHERE
				((tgm.user_id='$user_id' OR tgm.user_id_joined='$user_id') 
				AND tgm.group_id IN (SELECT tbc.group_id 
									FROM tbl_chat AS tbc WHERE
									tbc.time_stamp >= DATE_SUB(NOW(), INTERVAL 1 MINUTE)
									GROUP BY tbc.group_id 
									ORDER BY tbc.time_stamp ASC)) 
				GROUP BY tgm.group_id");
			
		$numrws = mysql_num_rows($query);
		$items = '';
		if($numrws > 0){
			while($row=mysql_fetch_array($query)){
				$grp_id[] = $row['gp_id'];
			}
          $return = $this->ObjJSON->encode($grp_id);	
		}else{
		  $return = "error";	
		}
	  }	
		return $return;	  		
	}

	function _get_updincomming_chats($user_id){
	  if($user_id != ""){
		//$query = mysql_query("SELECT DISTINCT(COUNT(tgm.group_id)), tgm.group_id AS gp_id,tc.user_id,tc.message FROM tbl_group_members as tgm LEFT JOIN tbl_chat as tc ON tgm.group_id = tc.group_id WHERE ((tgm.user_id='$user_id' OR tgm.user_id_joined='$user_id') and tgm.group_id in (SELECT tbc.group_id FROM tbl_chat as tbc WHERE tbc.time_stamp >= DATE_SUB(NOW(), INTERVAL 300 SECOND) GROUP BY tbc.group_id ORDER BY tbc.time_stamp ASC)) GROUP BY tgm.group_id");

		$query	=	mysql_query("SELECT tgm.group_id AS gp_id,tc.user_id 
				FROM tbl_group_members AS tgm 
				LEFT JOIN tbl_chat AS tc ON tgm.group_id = tc.group_id 
				WHERE
				((tgm.user_id='$user_id' OR tgm.user_id_joined='$user_id') 
				AND tgm.group_id IN (SELECT tbc.group_id 
									FROM tbl_chat AS tbc WHERE
									tbc.time_stamp >= DATE_SUB(NOW(), INTERVAL 4 SECOND)
									GROUP BY tbc.group_id 
									ORDER BY tbc.time_stamp ASC)) 
				GROUP BY tgm.group_id");
			
		$numrws = mysql_num_rows($query);
		$items = '';
		if($numrws > 0){
			while($row=mysql_fetch_array($query)){
				$grp_id[] = $row['gp_id'];
			}
          $return = $this->ObjJSON->encode($grp_id);	
		}else{
		  $return = "error";	
		}
	  }	
		return $return;	  		
	}

	function _get_user_name($user_id){
	    $query = mysql_query("SELECT first_Name,last_Name FROM tbl_user_profile WHERE user_id='$user_id'");	
		$row=mysql_fetch_array($query);
		$username = $row['first_Name']." ".$row['last_Name'];
		return $username;
	}
	function sanitize($text) {
		$text = htmlspecialchars($text, ENT_QUOTES);
		$text = str_replace("\n\r","\n",$text);
		$text = str_replace("\r\n","\n",$text);
		$text = str_replace("\n","<br>",$text);
		return $text;
	}
	function get_group_name($group_id){
		$groupquery = mysql_query("SELECT group_name FROM tbl_groups WHERE group_id='$group_id'");	
		$grouprow=mysql_fetch_array($groupquery);
		$groupname = ucfirst($grouprow['group_name']);
		header('Content-type: application/json');
		?>
		{
				"groupname": "<?php echo $groupname; ?>"
				
		}
		<?php
					exit(0);
	}
	function _get_user_group_status($user_id,$group_id){
		$userstatquery = mysql_query("SELECT is_active FROM tbl_group_members WHERE group_id='$group_id' AND (user_id_joined='$user_id' OR user_id_joined='$user_id')");	
		$userstatrow=mysql_fetch_array($userstatquery);
		$userstatus  = $userstatrow['is_active'];
		header('Content-type: application/json');
		?>
		{
				"userstatus": "<?php echo $userstatus; ?>"
				
		}
		<?php
					exit(0);
	}
}	
$user_id = $_REQUEST['user_id'];
$group_id = $_REQUEST['group_id'];
$chatText = $_POST['chatText'];		
$insertchat = $_POST['insertchat'];
$get_chats = $_REQUEST['get_chats'];
$get_updchat = $_REQUEST['get_updchat'];
$get_usrupdchat = $_REQUEST['get_usrupdchat'];
$get_grpincomming_chats = $_REQUEST['get_grpincomming_chats'];
$get_incomming_chats = $_REQUEST['get_incomming_chats'];
$get_updincomming_chats = $_REQUEST['get_updincomming_chats'];
$click_get_chats = $_POST['click_get_chats'];
$get_group_name = $_GET['get_group_name'];
$open_cookie_chats = $_POST['open_cookie_chats'];
$get_user_group_status = $_GET['get_user_group_status'];

$chat_obj = new chat_service();
if(isset($insertchat)){
echo $addchat = $chat_obj->_insert_chat($user_id,$group_id,$chatText);
}
if(isset($get_chats)){
echo $getchat = $chat_obj->_get_chat($user_id,$group_id);
}
if(isset($get_updchat)){
echo $getchat = $chat_obj->_get_updchat($user_id,$group_id);
}
if(isset($get_usrupdchat)){
echo $getchat = $chat_obj->_get_usrupdchat($user_id,$group_id);
}
if(isset($get_incomming_chats)){
echo $getchat = $chat_obj->_get_incomming_chats($user_id);
}
if(isset($get_grpincomming_chats)){
echo $getchat = $chat_obj->_get_grpincomming_chats($user_id);
}
if(isset($get_updincomming_chats)){
echo $getchat = $chat_obj->_get_updincomming_chats($user_id);
}
if(isset($click_get_chats)){
echo $getchat = $chat_obj->_click_get_chats($user_id,$group_id);
}
if(isset($get_group_name)){
	$chat_obj->get_group_name($group_id);
}
if(isset($open_cookie_chats)){
echo $getchat = $chat_obj->_open_cookie_chats($user_id,$group_id);
}

if(isset($get_user_group_status)){
	$chat_obj->_get_user_group_status($user_id,$group_id);
}

?>