<?php
require_once 'includes/dbobj.php';
require_once "includes/json.php";
require_once "includes/configuration.php";
require_once "includes/parameters.php";
require_once "includes/class.commonGeneric.php";
require_once 'includes/class.chatting.php';
require_once "includes/Logging.php";

//$log		=	new Logging();
$chatting	=	new chatting();
$ObjJSON	=	new Services_JSON();

$action = (isset($_REQUEST['action']))?$_REQUEST['action']:"";

$return = array();
switch ($action) {
	case "get_user_name":
			$user_id = (isset($_REQUEST['user_id']))?$_REQUEST['user_id']:"";
			$return = $chatting->get_user_name($user_id);
			//print_r($return);
			//exit;
			break;
		
	case "updatechatheartbeat": 
			$username = (isset($_REQUEST['username']))?$_REQUEST['username']:"";
			$chatfrom = (isset($_REQUEST['chatfrom'])?$_REQUEST['chatfrom']:"");
			$return = $chatting->updateChatHeartbeat($username, $chatfrom);
			break;

	case "confirmchat":
			$username = (isset($_REQUEST['username']))?$_REQUEST['username']:"";
			$chatfrom = (isset($_REQUEST['chatfrom'])?$_REQUEST['chatfrom']:"");
			$res = $chatting->confirmChatHeartbeat($username, $chatfrom);
			while($row = mysql_fetch_array($res)){
				$return[] = $row;
			}
			break;
		
	case "chatheartbeat" : 
			$username = (isset($_REQUEST['username']))?$_REQUEST['username']:"";
			$res = $chatting->chatHeartbeat($username);
			while($row = mysql_fetch_array($res)){
				$return[] = $row;
			}
			break;
		
	case "sendchat" :
			$from = (isset($_REQUEST['from']))?$_REQUEST['from']:"";
			$to = (isset($_REQUEST['to']))?$_REQUEST['to']:"";
			$message = (isset($_REQUEST['message']))?$_REQUEST['message']:"";
			$return = $chatting->sendChat($from, $to, $message);
			break;
		
	case "closechat":
			$username = (isset($_REQUEST['username']))?$_REQUEST['username']:"";
			$chatbox = (isset($_REQUEST['chatbox']))?$_REQUEST['chatbox']:"";
			$return = $chatting->closeChat($username, $chatbox);
			break;
		
	case "busychat":
			$senderid = (isset($_REQUEST['senderid']))?$_REQUEST['senderid']:"";
			$username = (isset($_REQUEST['username']))?$_REQUEST['username']:"";
			$chatbox = (isset($_REQUEST['chatbox']))?$_REQUEST['chatbox']:"";
			$return = $chatting->busyChat($senderid, $username, $chatbox);
			break;
		
	case "beforechatopen":
			$chatbox = (isset($_REQUEST['chatbox']))?$_REQUEST['chatbox']:"";
			$username = (isset($_REQUEST['username']))?$_REQUEST['username']:"";
			$return = $chatting->beforeChatOpen($username, $chatbox);
			break;

	default:break;
}
//$log->lwrite($ObjJSON->encode($return));
print $ObjJSON->encode($return);
?>