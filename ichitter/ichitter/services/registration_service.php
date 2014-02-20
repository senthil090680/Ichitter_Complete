<?php

session_start();
error_reporting(0);

include("includes/dbobj.php");
include("includes/configuration.php");
include_once 'includes/class.commonGeneric.php';
include_once 'includes/class.uautheticate.php';

echo "test";
/*print_r($_REQUEST);
exit;

$usr_obj = new UAuthenticate;

if(isset($_REQUEST['get_user_record'])){	
	$result = $usr_obj->get_user_record($_REQUEST);
	print $result;
}elseif(isset($_REQUEST['email_validation'])){
	print 'services';
	/*$result = $usr_obj->validate_existing_user($ObjJSON->encode($_REQUEST));
	print $result;
}elseif(isset($_REQUEST['forgot_password'])){
	print $usr_obj->forgot_password($ObjJSON->encode($_REQUEST));
	echo '<a href="changepassword.php?email='.$_REQUEST['email'].'">click here</a>';
}elseif(isset($_REQUEST['change_password'])){
	
	if(isset($_REQUEST['oldpass'])){
		$old_pass = $_REQUEST['oldpass'];
	}else{
		$old_pass = '';
	}
	
	if($usr_obj->update_password('',$_REQUEST['pass'],$_REQUEST['email'],$old_pass)){		
		print $ObjJSON->encode(array('success'=>'true'));
	}else{
		print $ObjJSON->encode(array('failure'=>'true'));
	}
	
	
}elseif(!empty($_REQUEST)){	
	
	$result = $usr_obj->insert_Data($ObjJSON->encode($_REQUEST));
	print $result;
}
*/
?>