<?php
require_once 'includes/includes.inc';

$action = (isset($_REQUEST['act'])) ? $_REQUEST['act'] : "";
$postings = new postings();
$subtopics = new subtopics();

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
	
	case 'getsubtopicslist' : 
			$topicid = (isset($_REQUEST['tid'])) ? $_REQUEST['tid'] : "0";
			$ST_rs = $subtopics->get_allSubtopics(0, $topicid);
			$i = 0;
			while($subtopic = mysql_fetch_array($ST_rs)) {
				$return[$i] = $subtopic;
				$i++;
			}
		break;
		
	case 'approve':
			$postingid = (isset($_REQUEST['pid'])) ? $_REQUEST['pid'] : "0";
			$ret = $postings->approvePost($postingid);
			$return['err'] = '';
			if(!$ret) {
				$return = array('err' => 'err');
			}
			break;

	case 'remove':
			$postingid = (isset($_REQUEST['pid'])) ? $_REQUEST['pid'] : "0";
			$ret = $postings->removePosting($postingid);
			$return['err'] = '';
			if(!$ret) {
				$return = array('err' => 'err');
			}
		break;
	 
	 
	default: break;
}
print $json->encode($return);
?>