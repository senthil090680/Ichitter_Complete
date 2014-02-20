<?php
require_once 'includes/includes.inc';

$action = (isset($_REQUEST['act'])) ? $_REQUEST['act'] : "";
$uprofile = new userProfile();

$return = array();
switch ($action) {
	case 'cngact' : 
			$userid = (isset($_REQUEST['uid'])) ? $_REQUEST['uid'] : "0";
			$status = (isset($_REQUEST['vals'])) ? $_REQUEST['vals'] : "0";
			$return = $uprofile->changeUserStatus($userid, $status);
			$return['err'] = '';
			if(count($return) <= 0) {
				$return = array('err' => 'err');
			}			

		break;

	default:
		break;
}
print $json->encode($return);
?>
