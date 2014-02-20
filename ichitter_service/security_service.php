<?php
require_once "includes/dbobj.php";
require_once "includes/configuration.php";
require_once 'includes/class.commonGeneric.php';
require_once 'includes/class.security.php';
//echo 'registration_services';
//print_r($_REQUEST);
//exit;
$sec_obj = new Security();

$action = $_REQUEST[PARAM_ACTION];
require_once 'includes/authentication.php';
$return = array();
if($valid == 1) {
switch($action){
	case 'get_security_settings':
		$return = $sec_obj->get_security($_REQUEST);
	break;
	case 'security_setting':		
		$return = $sec_obj->security_setting($_REQUEST);
	break;
}
 }else {
	 $return = $usr_obj->encode($unauth);
 }
print $return;


?>