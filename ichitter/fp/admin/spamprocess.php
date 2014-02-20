<?php
require_once 'includes/includes.inc';

$act = (isset($_REQUEST['act']))?$_REQUEST['act']:"";
$spamid = (isset($_REQUEST['spamid']))?$_REQUEST['spamid']:"";
$spamword = (isset($_REQUEST['spamword']))?$_REQUEST['spamword']:"";

$spam = new spamFilter();
$result = array();
switch ($act) {
	case "addspam" :
			$spam->SpamWord = stripcslashes($spamword);
			$result = $spam->addSpamWord();
			if($result) {
				header("Location: spam_list.php?msg=addspam_success");
			} else {
				header("Location: spam_add.php?msg=addspam_fail");
			}
			break;

	case "updatespam" :
			$spam->SpamID = $spamid;
			$spam->SpamWord = stripcslashes($spamword);
			$result = $spam->updateSpamWord();
			if($result) {
				header("Location: spam_list.php?msg=updatespam_success");
			} else {
				header("Location: spam_edit.php?sid=$spamid&msg=updatespam_fail");
			}
			break;
		
	case "delspam" :
			$spam->SpamID = $spamid;
			$result = $spam->delSpamWord();
			if($result) {
				$result['err'] = '';
			} else {
				$result['err'] = 'err';
			}
			
			break;
			
	case 'isexists' :
		$spam->SpamWord = stripcslashes($spamword);
		$res = $spam->findSpamWord();
		if($res == 0) {
			$result['err'] = '';
		} else {
			$result['err'] = 'err';
		}
		break;

	default: break;
}
print $json->encode($result);
?>