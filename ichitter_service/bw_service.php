<?php
require_once "includes/dbobj.php";
require_once "includes/json.php";
require_once "includes/configuration.php";
require_once "includes/parameters.php";
require_once "includes/class.commonGeneric.php";
require_once "includes/Logging.php";

$ObjJSON = new Services_JSON();
$action = $_REQUEST[PARAM_ACTION];

$return = array();

switch ($action) {
	case "checkbw" : 
		$content = $_REQUEST['txt'];
		$retval = $cg->filter_malicious($content);
		$return = array("msg" => "$retval");
		break;
	
	default : break;
}
print $ObjJSON->encode($return);
?>
