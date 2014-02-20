<?php
ini_set('zlib.output_compression', 'On');
ini_set('zlib.output_compression_level', 6); 
require_once('configuration.php');
require_once('encryption.php');
require_once('class.session.php');
require_once('class.init_process.php');
require_once ('parameters.php');
require_once ('class.commonfunc.php');
require_once ('Logging.php');
require_once('json.php');
require_once('errMessages.php');

$session_obj = new SESSION();
$ObjJSON = new Services_JSON();

$commonFunc = new CommonFunc();

function Object2Array($obj) {
	if (is_object($obj)) {
		$obj = get_object_vars($obj);
	}
	if (is_array($obj)) {
		return array_map(__FUNCTION__, $obj);
	} else {
		return $obj;
	}
}

define('SESS_USER_ID', $_SESSION['login']['user_id']);

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
//print_r($page_info);
//Array ( [dirname] => /fpage [basename] => posting_process.php [extension] => php [filename] => posting_process ) 
//print_r($_SESSION);
$usid = "";

?>