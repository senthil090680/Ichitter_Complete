<?php
session_start();
error_reporting(0);

include("../admin/includes/dbobj.php");
include("../admin/includes/configuration.php");
include_once 'includes/class.commonGeneric.php';
include ('./includes/class.uautheticate.php');
include("./includes/Logging.php");
//print_r($_REQUEST);
$username	=	$_REQUEST['username'];
$password	=	$_REQUEST['password'];

$log = new Logging();
$uauth = new UAuthenticate();

//$log->lwrite("CALLING");
$result	= $uauth->validate_user($username,$password);


if($result)
{
	$_SESSION['user_id'] = $uauth->USER_ID;
	$_SESSION['email'] = $uauth->EMAIL_ID;
	$_SESSION['username'] = $uauth->FNAME . " " . $uauth->LNAME;
    $_SESSION['last_loggedin'] = $uauth->LAST_LOGGEDIN;	
    print json_encode(array('success' => 'OK','user_id' => $uauth->USER_ID,'email_id'=>$uauth->EMAIL_ID,'username' => $uauth->FNAME . " " . $uauth->LNAME,'last_loggedin' => $uauth->LAST_LOGGEDIN));
}
else
{
	print json_encode(array('failure' => 'OK'));
}

//foreach ($_REQUEST as $k => $v) {
//	$log->lwrite(" $k => $v ");
//}

//print json_encode(array('success' => $_REQUEST['username'], 'msg_confirm_email' =>  $_REQUEST['password']));
//$log->lwrite(" $k => " . hash('md5',$v));
?>