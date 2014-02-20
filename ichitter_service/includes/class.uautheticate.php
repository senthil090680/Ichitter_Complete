<?php
class UAuthenticate extends commonGeneric {	
	var $USER_ID;
	var $FNAME;
	var $LNAME;
	var $EMAIL_ID;
	var $PASSWORD;
    var $LAST_LOGGEDIN;
	var $SESSION;
	var $IP;
	var $USER_AGENT;
	var $LOGINSTATUS;
	var $ACTIVESTATUS;
	
	function __construct() {
		
	}
	
	function setRemoteInfo($ip, $ssid, $ua) {
		$this->IP = $ip;
		$this->SESSION = $ssid;
		$this->USER_AGENT = $ua;
	}
	
	function validate_user($email, $password) {
		if(!$this->check_flag_value($email)){
			$result = 'login_false';
			return $result;
		}
		$allow	=	false;
		$sql= "SELECT user_id, first_Name, last_Name, email, last_loggedin, passw FROM " . USERPROFILE . " WHERE email = '". $email ."' AND passw = '". $password ."'";
		
		$res_sql =	mysql_query($sql) or die ("INVALID QUERY" . mysql_error());
		
		$row = mysql_fetch_array($res_sql);
	
		if(mysql_num_rows($res_sql)==1) {
			$this->USER_ID = $row['user_id'];
			$this->EMAIL_ID 	= $row['email'];
			$this->FNAME = $row['first_Name'];
			$this->LNAME = $row['last_Name'];
			$this->PASSWORD = $row['passw'];
			$this->LAST_LOGGEDIN = $row['last_loggedin'];
			$this->LOGINSTATUS = "Online";
			$this->ACTIVESTATUS = 1;
			
            $sql1    =  " UPDATE ". USERPROFILE ." 
	    		SET last_loggedin = '" . date("Y-m-d H:i:s") . "' ,
			 ip = '" . $this->IP . "' , 
			 session = '" . md5($this->SESSION) . "' , 
			 user_agent = '" . sha1($this->USER_AGENT) . "', 
			 status = '". $this->LOGINSTATUS . "' 
			 WHERE user_id = '" . $row["user_id"] . "' ";

            $res_sql1	=	mysql_query($sql1) or die ("INVALID QUERY".mysql_error());
			$allow	=	true;
		}
		else {
			$allow	=	false;
		}
		return $allow;
	}
	
//	function userAuth($email, $password, $cuid=0, $ip, $ssid, $ua) {
//		$sql = "SELECT * FROM " . USERPROFILE . " 
//				WHERE 
//					email = '". $email ."' 
//					AND passw = '". $password ."'
//					AND ip = '". $ip ."'
//					AND session = '". md5($ssid) ."'
//					AND user_agent = '". sha1($ua) ."'
//					";
//		$res_sql =	mysql_query($sql);
//		$row = mysql_fetch_array($res_sql);
//		$ret = 0;
//		if(mysql_num_rows($res_sql) == 1) {
//			$ret = ($row['user_id'] == $cuid)? 1 : 0;
//		}
//		return $ret;
//	}
	
	function getUserDetails($email, $password) {
		$sql= "SELECT user_id, first_Name, last_Name, email, last_loggedin, passw FROM " . USERPROFILE . " WHERE email = '". $email ."' AND passw = '". $password ."'";
		$res_sql =	mysql_query($sql) or die ("INVALID QUERY" . mysql_error());
		$row = mysql_fetch_array($res_sql);
		if(mysql_num_rows($res_sql)==1) {
			return $row;
		}
		return false;
	}
	
	public function check_flag_value($email){
		$sql = "SELECT count(login_flag) as total from ". USERPROFILE ." WHERE email = '".$email."' AND login_flag = 0";
		
		$result = $this->fetch_row($this->query_Exe($sql));
		return $result['total'];
	}
	
	function check_old_password($user_id, $password) {
		$retpassword="";
		$sql= "select passw from " . USERPROFILE . " where user_id like '". $user_id ."'";
		$res_sql	=	mysql_query($sql) or die ("INVALID QUERY".mysql_error());

		$row = mysql_fetch_array($res_sql);

		if(mysql_num_rows($res_sql) == 1) {
			$retpassword = $row["password"];
			$allow	=	true;
		}
		else {
			$allow	=	false;
		}
		return $retpassword;
	}
	
	function update_password($user_id = '', $password, $email = '', $old_pass = '') {
		
		$sql    =   "UPDATE " . USERPROFILE . " SET login_flag = 0, passw='". $password ."' WHERE";
		if(trim($user_id)){
			$sql  .= " user_id = '".$user_id ."' and ";
		}
		
		if(trim($email)){
			$sql  .=   " email = '".$email ."'";
		}
		
		if(trim($old_pass)){
			
			$query = "select count(email) as total from tbl_user_profile where email = '".$email."' and passw = '".$old_pass."'";				
			$result = $this->fetch_row($this->query_Exe($query));	
			
			$sql  .=   " and passw = '".$old_pass."'";
			
			if($result['total'] > 0){			
				$res_sql    =    mysql_query($sql);
			}
		}else{
			$res_sql    =    mysql_query($sql);
		}
		
		//return $sql;
		
		if($res_sql == 1){
			$allow	=	true;
		}else{
			$allow = false;
		}
		
		return $allow;
	}
	/* forget password */
	public function forgot_password($data){
		
		$data =(array)($this->decode($data));
		$sql = 'select first_Name,last_Name from tbl_user_profile where email = "'.$data['email'].'"';				
		
		$result = $this->fetch_row($this->query_Exe($sql));	
		$firstname = $resutl['first_Name'];
		$lastname =  $resutl['last_Name'];
		if(isset($result['first_Name']) && isset($result['last_Name'])){
		
			$sql = "UPDATE tbl_user_profile SET login_flag = 1 where email = '".$data['email']."'";
			if($this->query_Exe($sql) == 1){
			$email = $data['email'];
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
<h1>Hi '.$result['first_Name'].' '.$result['last_Name'].',</h1>
<h2>You have requested for the Forgot Password update. Please follow this link to reset your Password: </h2>
<a href="http://tsg.emantras.com/dev_ichitter/ichitter/changepassword.php?email='.base64_encode($email).'">http://tsg.emantras.com/dev_ichitter/ichitter/changepassword.php?email='.base64_encode($email).'</a>
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
define('FROMEMAILNAME',"From iChitter");
		$this->mail_send($email,'Forgot Password request from iChitter',$mail_format);
			}
		}
		//return $sql;
		return $this->encode(array('success'=>'OK'));
	}
	
	/*public function get_user_record($data){
		if(isset($data['user_id'])){
			//$sql = "SELECT * FROM " . USERPROFILE . " WHERE user_id = " . $data['user_id'];
			
			
			//$sql ="SELECT * FROM " . USERPROFILE . " tup left join tbl_images ti on (tup.user_id = ti.user_id) left join tbl_igallery tig on (ti.igallery_id = tig.igallery_id) WHERE tup.user_id = " . $data['user_id']." and ti.image_id = tup.profile_image";
			$sql ="SELECT * FROM " . USERPROFILE . " tup left join tbl_images ti on (tup.user_id = ti.user_id) WHERE tup.user_id = " . $data['user_id']." and ti.image_id = tup.profile_image";
		}
		
		$result = $this->fetch_row($this->query_Exe($sql));	
		
		if(empty($result)){
			$sql ="SELECT * FROM " . USERPROFILE . " WHERE user_id = " . $data['user_id'];
						
			$result = $this->fetch_row($this->query_Exe($sql));	
		}
		
		if(isset($result['igallery_id']) && $result['igallery_id'] != 0){
			$sql = "SELECT igallery_name FROM tbl_igallery where igallery_id = ".$result['igallery_id'];
			$result1 = $this->fetch_row($this->query_Exe($sql));	
			$result = array_merge($result,$result1);
		}
		
		return $result;
	}*/
	
	public function get_user_record($data){
		
		if(isset($data['user_id']) && isset($data['session_user_id'])){			
			$sql = "SELECT *,concat(tup.first_Name,' ', tup.last_Name) as name,(SELECT COUNT(cont_id) FROM tbl_contacts WHERE (cont_user_id = ".$data['user_id']." AND cont_user_joined_id = ".$data['session_user_id'].") OR (cont_user_id = ".$data['session_user_id']." AND cont_user_joined_id =".$data['user_id']."))  AS innercircle FROM " . USERPROFILE . " tup LEFT JOIN tbl_images ti ON (tup.profile_image = ti.image_id) LEFT JOIN tbl_igallery tig ON (ti.igallery_id = tig.igallery_id) LEFT JOIN tbl_security_public tspub ON (tup.user_id = tspub.user_id) LEFT JOIN tbl_security_private tspriv ON (tup.user_id = tspriv.user_id) LEFT JOIN tbl_state  ts ON (tup.state = ts.state_abbreviation) WHERE tup.user_id =" . $data['user_id'];
			//return $sql;
		}elseif(isset($data['user_id'])){			
			$sql = "SELECT *,concat(tup.first_Name,' ', tup.last_Name) as name,(SELECT COUNT(cont_id) FROM tbl_contacts WHERE (cont_user_id = ".$data['user_id'].") OR (cont_user_joined_id =".$data['user_id']."))  AS innercircle FROM " . USERPROFILE . " tup LEFT JOIN tbl_images ti ON (tup.profile_image = ti.image_id) LEFT JOIN tbl_igallery tig ON (ti.igallery_id = tig.igallery_id) LEFT JOIN tbl_security_public tspub ON (tup.user_id = tspub.user_id) LEFT JOIN tbl_security_private tspriv ON (tup.user_id = tspriv.user_id) LEFT JOIN tbl_state  ts ON (tup.state = ts.state_abbreviation) WHERE tup.user_id =" . $data['user_id'];
			//return $sql;
		}
		
		$result = $this->fetch_row($this->query_Exe($sql));	
			
		return $result;
	}
	
	public function validate_existing_user($data){
		$result = $this->objectToArray($this->decode($data));		
		$sql = "select count(email) as total from tbl_user_profile where email = '".$result['email']."'";
		$result = $this->fetch_row($this->query_Exe($sql));	
		return $this->encode($result);
	}
	
	public function insert_Data($data){
		$result = (array)($this->decode($data));
		
		/*$this->query_Exe('SET AUTOCOMMIT=0');
		$this->query_Exe('START TRANSACTION');*/
		$this->transaction_start();
		
		$sql = "Insert into tbl_user_profile set first_name = '" . $result['firstname'] . "', last_name = '".$result['lastname'] . "', email = '" . $result['email'] . "' , state = '" . $result['state'] . "', passw = '" . $result['password']. "', gender = '" . $result['gender']. "', login_flag = 1";
		$r1 = $this->query_Exe($sql);
		$user_id = mysql_insert_id();
		//return $user_id;
		$sql = "Insert into tbl_security_private set user_id = '" . $user_id . "', priv_name = 1, priv_place = 1, priv_status = 1, priv_poltifical_affiliation = 1, priv_active_involment = 1, priv_issues_close_to_heart = 1, priv_education = 1, priv_profession = 1, priv_career = 1, priv_hobbies = 1, priv_interest = 1, priv_family = 1, priv_news_stream = 1, priv_photographs = 1, priv_movies = 1, priv_contacts = 1, priv_i_Author = 1, priv_recommend = 1, priv_my_premise = 1";
		//return $sql;
		$r2 = $this->query_Exe($sql);
		
		$sql = "Insert into tbl_security_public set user_id = '" . $user_id . "', pub_name = 1, pub_place = 1, pub_status = 1, pub_poltifical_affiliation = 1, pub_active_involment = 1, pub_issues_close_to_heart = 1, pub_education = 1, pub_profession = 1, pub_career = 1, pub_hobbies = 1, pub_interest = 1, pub_family = 1, pub_news_stream = 1, pub_photographs = 1, pub_movies = 1, pub_contacts = 1, pub_i_Author = 1, pub_recommend = 1, pub_my_premise = 1";
		$r3 = $this->query_Exe($sql);
		
		//return $this->encode($sql1.' '.$sql2.' '.$sql3);
		
		//return $this->encode($r1.' '.$r2.' '.$r3);
		
		$firstname = $result['firstname'];
		$lastname = $result['lastname'];
		$email = $result['email'];
		//$result = $this->query_Exe($sql);
		if($r1 == 1 && $r2 == 1 && $r3 == 1){
			$this->transaction_commit();
			
		
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
<h1>Hi '.$firstname.' '.$lastname.',</h1>
<h2>To Complete the sign-up process, please follow this link:</h2>
<a href="http://tsg.emantras.com/dev_ichitter/ichitter/confirm.php?email='.base64_encode($email).'">http://tsg.emantras.com/dev_ichitter/ichitter/confirm.php?email='.base64_encode($email).'</a>
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
			define('FROMEMAILNAME',"Registration information from iChitter");
			$this->mail_send($email,'Registration information from iChitter',$mail_format);
			return $this->encode(array('success'=>$result));
		}else{
			$this->transaction_rollback();
			return $this->encode(array('error'=>'false'));
		}
	}	
}

?>