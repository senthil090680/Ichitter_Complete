<?php
class UAuthenticate extends commonGeneric {
	
	var $USER_ID;
	var $FNAME;
	var $LNAME;
	var $EMAIL_ID;
	var $PASSWORD;
    var $LAST_LOGGEDIN;

	function validate_user($email,$password) {
		
		$allow	=	false;
		$sql= "SELECT user_id, first_Name, last_Name, email, last_loggedin FROM " . USERPROFILE . " WHERE email = '". $email ."' AND passw = '". $password ."'";
		
		$res_sql =	mysql_query($sql) or die ("INVALID QUERY" . mysql_error());
		
		$row = mysql_fetch_array($res_sql);
	
		if(mysql_num_rows($res_sql)==1) {
			$this->USER_ID = $row['user_id'];
			$this->EMAIL_ID 	= $row['email'];
			$this->FNAME = $row['first_name'];
			$this->LNAME = $row['last_name'];
			$this->PASSWORD = $row['passw'];
			$this->LAST_LOGGEDIN	= $row['last_loggedin'];
			
            $sql1    =   "UPDATE ". USERPROFILE ." SET last_loggedin = '" . date("Y-m-d H:i:s") . "' WHERE user_id = '" . $row["user_id"] . "'" ;

			die($sql1);
            $res_sql1	=	mysql_query($sql1) or die ("INVALID QUERY".mysql_error());
			$allow	=	true;
		}
		else {
			$allow	=	false;
		}
		return $allow;
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
		
		$sql    =   "UPDATE " . USERPROFILE . " SET passw='". $password ."' WHERE";
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
		
		//echo $sql;
		
		if($res_sql == 1){
			$allow	=	true;
		}else{
			$allow = false;
		}
		
		return $allow;
	}
	/* forget password */
	public function forgot_password($data){
		
		$data = json_decode($data,true);
		$sql = 'select count(email) as total from tbl_user_profile where email = "'.$data['email'].'"';				
		$result = $this->fetch_row($this->query_Exe($sql));	
		if($result['total']){
			
			$message = '
			<html>
			<head>
			  <title>Change password in ichitter</title>
			</head>
			<body>
			 <p>Using this url change your password <a href="http://localhost/FrontedPage/changepassword.php?email='.$data['email'].'">Click Here!</a></p>
			</body>
			</html>
			';
			//echo $this->mail_Send('vijayaraju@emantras.com','test',$message);
		}
		return json_encode($result);
	}
	
	public function get_user_record($data){
		return $data;
	}
	
	
	
}

?>