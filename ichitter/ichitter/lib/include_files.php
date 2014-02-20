<?php
require_once('configuration.php');
require_once('encryption.php');
require_once('class.session.php');
require_once('class.init_process.php');
require_once('define.php');	
require_once('parameters.php');
require_once('json.php');
require_once 'Logging.php';

$session_obj = new SESSION();
$ObjJSON = new Services_JSON();
	
$REQ_SEND = array();
$REQ_SEND[PARAM_KEY] = "";
$REQ_SEND[PARAM_SRC] = "";
$REQ_SEND[PARAM_MODE] = "";
$REQ_SEND[PARAM_VER] = "";
$REQ_SEND[PARAM_SRCID] = "";
$REQ_SEND[PARAM_SSAID] = session_id();
$REQ_SEND[PARAM_USD] = $session_obj->get_Session('user_id');
$REQ_SEND[PARAM_EID] = $session_obj->get_Session('EID');
$REQ_SEND[PARAM_PSD] = $session_obj->get_Session('PSD');
$REQ_SEND[PARAM_LGD] = ($session_obj->checkSession())? 0 : 1;
$REQ_SEND[PARAM_R_ADDR] = $_SERVER['REMOTE_ADDR'];
$REQ_SEND[PARAM_HU_AGENT] = $_SERVER['HTTP_USER_AGENT'];

$page_info = array();
$page_info = pathinfo($_SERVER['PHP_SELF']);

function Object2Array($obj) {
	if (is_object($obj)) {
		// with get_object_vars function
		// Gets the properties of the given object
		$obj = get_object_vars($obj);
	}

	if (is_array($obj)) {
		/*
		 * Return array converted to object
		 * Using __FUNCTION__ (Magic constant)
		 * for recursive call
		 */
		return array_map(__FUNCTION__, $obj);
	} else {
		// Return array
		return $obj;
	}
}
?>