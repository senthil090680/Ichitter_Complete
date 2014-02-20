<?php
require_once "includes/dbobj.php";
require_once "includes/json.php";
require_once "includes/parameters.php";
require_once "includes/configuration.php";
require_once "includes/class.commonGeneric.php";
require_once "includes/class.uautheticate.php";
require_once "includes/Logging.php";

if(isset($_REQUEST['email']) && trim($_REQUEST['email']) != ''){
	$username	=	$_REQUEST['email'];
}elseif(isset($_REQUEST['username']) && trim($_REQUEST['username']) != ''){
	$username	=	$_REQUEST['username'];
}
$password	=	$_REQUEST['password'];

$uauth = new UAuthenticate();

$uauth->setRemoteInfo($_REQUEST[PARAM_R_ADDR], $_REQUEST[PARAM_SSAID], $_REQUEST[PARAM_HU_AGENT]);

$result	= $uauth->validate_user($username, $password);

if(trim($result) == 'login_false'){
	print $uauth->encode(array('login_flag' => 'fail'));
}elseif($result) {
    print $uauth->encode(array('success' => 'OK','user_id' => $uauth->USER_ID,'email_id'=>$uauth->EMAIL_ID,'username' => $uauth->FNAME . " " . $uauth->LNAME,'last_loggedin' => $uauth->LAST_LOGGEDIN, 'psd' => $uauth->PASSWORD ));
}
else {
	print $uauth->encode(array('failure' => 'OK'));
}
?>