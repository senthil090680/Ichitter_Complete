<?php
require_once 'includes/includes.inc';

$action = (isset($_REQUEST['act'])) ? $_REQUEST['act'] : "";
$postings = new postings();

$return = array();
switch ($action) {
	case 'getcont' : 
			$postingid = (isset($_REQUEST['pid'])) ? $_REQUEST['pid'] : "0";
			$return = $postings->getPostingsByPostId($postingid);
			$return['err'] = '';
			if(count($return) <= 0) {
				$return = array('err' => 'err');
			}			
		break;

	default: break;
}
print $json->encode($return);
?>