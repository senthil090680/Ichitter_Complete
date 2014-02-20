<?php
require_once 'lib/include_files.php';

if ($_GET['action'] == "get_user_name") {
	get_user_name();
}

if ($_GET['action'] == "updatechatheartbeat") {
	updateChatHeartbeat($_GET['chatfromperson']);
}

if ($_GET['action'] == "confirmchat") {
	confirmChatHeartbeat($_GET['chatfrom']);
}

if ($_GET['action'] == "chatheartbeat") {
	chatHeartbeat();
}
if ($_GET['action'] == "sendchat") {
	sendChat();
}
if ($_GET['action'] == "closechat") {
	closeChat();
}
if ($_GET['action'] == "busychat") {
	busyChat($_GET['senderid']);
}
if ($_GET['action'] == "startchatsession"){
	startChatSession();
}

if ($_GET['action'] == "beforechatopen") {
	beforeChatOpen();
}

if (!isset($_SESSION['chatHistory'])) {
	$_SESSION['chatHistory'] = array();
}

if (!isset($_SESSION['openChatBoxes'])) {
	$_SESSION['openChatBoxes'] = array();
}

function get_user_name() {
	global $ObjJSON, $REQ_SEND;
	//$log = new Logging();
	$userid = (isset($_REQUEST['user_id']))?$_REQUEST['user_id']:"";
	$curl_data = array('action' => 'get_user_name', 'user_id' => $userid);
	$curl_data+=$REQ_SEND;
	$curl_call = new INIT_PROCESS(CHATTING_SERVICE, $curl_data);
	//$log->lwrite("qq" . $curl_call->response);
	session_start();
	$userrow = Object2Array($ObjJSON->decode($curl_call->response));
	//$log->lwritearray($userrow);
	$recusername = ucfirst($userrow['first_Name']) . " " . ucfirst($userrow['last_Name']);
	//$log->lwrite($recusername);
	header('Content-type: application/json');
	?>
	{ "recusername": "<?php echo $recusername; ?>" }
	<?php
	exit(0);
}

function updateChatHeartbeat($chatfrom) {
	global $ObjJSON, $REQ_SEND;
	$username = (isset($_SESSION['username']))?$_SESSION['username']:"";
	$curl_data = array('action' => 'updatechatheartbeat', 'username' => $username, 'chatfrom' => $chatfrom);
	$curl_data+=$REQ_SEND;
	$curl_call = new INIT_PROCESS(CHATTING_SERVICE, $curl_data);
	session_start();
	$result = Object2Array($ObjJSON->decode($curl_call->response));
	if ($result['result'] == '1') {
		echo "1";
	} else {
		echo "5";
	}
	exit(0);
}

function confirmChatHeartbeat($chatfrom) {
	global $ObjJSON, $REQ_SEND;
	$username = (isset($_SESSION['username']))?$_SESSION['username']:"";
	$curl_data = array('action' => 'confirmchat', 'username' => $username, 'chatfrom' => $chatfrom);
	$curl_data+=$REQ_SEND;
	$curl_call = new INIT_PROCESS(CHATTING_SERVICE, $curl_data);
	session_start();
	$chats = Object2Array($ObjJSON->decode($curl_call->response));

	$items = '';
	$chatBoxes = array();
	$_SESSION['openChatBoxes'][$chatfrom] = date('Y-m-d H:i:s', time());
	foreach ($chats as $idx => $chat) {
		if (!isset($_SESSION['openChatBoxes'][$chat['from']]) && isset($_SESSION['chatHistory'][$chat['from']])) {
			$items = $_SESSION['chatHistory'][$chat['from']];
		}
		$chat['message'] = sanitize($chat['message']);
		$items .= <<<EOD
			{"s": "0", "f": "{$chat['from']}", "m": "{$chat['message']}" },
EOD;
	}
	
	if ($items != '') {
		$items = substr($items, 0, -1);
	}
	header('Content-type: application/json');
	?>
	{ "items": [ <?php echo $items; ?> ]}
	<?php
	exit(0);
}

function chatHeartbeat() {
	global $ObjJSON, $REQ_SEND;
	$username = (isset($_SESSION['username']))?$_SESSION['username']:"";
	$curl_data = array('action' => 'chatheartbeat', 'username' => $username);
	$curl_data+=$REQ_SEND;
	$curl_call = new INIT_PROCESS(CHATTING_SERVICE, $curl_data);
	session_start();
	$chats = Object2Array($ObjJSON->decode($curl_call->response));
	
	$items = '';
	foreach ($chats as $idx => $chat){
		if (!isset($_SESSION['openChatBoxes'][$chat['from']]) && isset($_SESSION['chatHistory'][$chat['from']])) {
			$items = $_SESSION['chatHistory'][$chat['from']];
		}
		$chat['message'] = sanitize($chat['message']);
		$items .= <<<EOD
					   { 
			"s": "0",
			"f": "{$chat['from']}",
			"m": "{$chat['message']}"
	   },
EOD;

		if (!isset($_SESSION['chatHistory'][$chat['from']])) {
			$_SESSION['chatHistory'][$chat['from']] = '';
		}

		$_SESSION['chatHistory'][$chat['from']] .= <<<EOD
							   {
				"s": "0",
				"f": "{$chat['from']}",
				"m": "{$chat['message']}"
	   },
EOD;

		unset($_SESSION['tsChatBoxes'][$chat['from']]);
		$_SESSION['openChatBoxes'][$chat['from']] = $chat['sent'];
	}

	if (!empty($_SESSION['openChatBoxes'])) {
		foreach ($_SESSION['openChatBoxes'] as $chatbox => $time) {
			if (!isset($_SESSION['tsChatBoxes'][$chatbox])) {
				$now = time() - strtotime($time);
				$time = date('g:iA M dS', strtotime($time));
				$message = "Sent at $time";
				if ($now > 180) {
					$items .= <<<EOD
{
"s": "2",
"f": "$chatbox",
"m": "{$message}"
},
EOD;

					if (!isset($_SESSION['chatHistory'][$chatbox])) {
						$_SESSION['chatHistory'][$chatbox] = '';
					}

					$_SESSION['chatHistory'][$chatbox] .= <<<EOD
		{
"s": "2",
"f": "$chatbox",
"m": "{$message}"
},
EOD;
					$_SESSION['tsChatBoxes'][$chatbox] = 1;
				}
			}
		}
	}
	if ($items != '') {
		$items = substr($items, 0, -1);
	}
	header('Content-type: application/json');
	?>
	{ "items": [<?php echo $items; ?>]}
	<?php
	exit(0);
}

function chatBoxSession($chatbox) {
	global $ObjJSON;
	$items = '';
	if (isset($_SESSION['chatHistory'][$chatbox])) {
		$items = $_SESSION['chatHistory'][$chatbox];
	}
	return $items;
}

function startChatSession() {
	global $ObjJSON;
	$items = '';
	if (!empty($_SESSION['openChatBoxes'])) {
		foreach ($_SESSION['openChatBoxes'] as $chatbox => $void) {
			$items .= chatBoxSession($chatbox);
		}
	}

	if ($items != '') {
		$items = substr($items, 0, -1);
	}

	header('Content-type: application/json');
	?>
	{
		"username": "<?php echo $_SESSION['username']; ?>",
		"items": [<?php echo $items; ?>]
	}
	<?php
	exit(0);
}

function sendChat() {
	global $ObjJSON, $REQ_SEND;
	$from = $_SESSION['username'];
	$to = $_POST['to'];
	$message = $_POST['message'];
	$_SESSION['openChatBoxes'][$_POST['to']] = date('Y-m-d H:i:s', time());
	$messagesan = sanitize($message);
	if (!isset($_SESSION['chatHistory'][$_POST['to']])) {
		$_SESSION['chatHistory'][$_POST['to']] = '';
	}
	$_SESSION['chatHistory'][$_POST['to']] .= <<<EOD
	 {"s": "1", "f": "{$to}", "m": "{$messagesan}"},
EOD;
	unset($_SESSION['tsChatBoxes'][$_POST['to']]);
	$curl_data = array('action' => 'sendchat', 'from' => $from, 'to' => $to, 'message' => $message);
	$curl_data+=$REQ_SEND;
	$curl_call = new INIT_PROCESS(CHATTING_SERVICE, $curl_data);
	session_start();
	$res = Object2Array($ObjJSON->decode($curl_call->response));
	echo "1";
	exit(0);
}

function closeChat() {
	global $ObjJSON, $REQ_SEND;
	unsetSession();
	$username	=	$_SESSION['username'];
	$chatbox	=	$_POST['chatbox'];
	$curl_data = array('action' => 'closechat', 'username' => $username, 'chatbox' => $chatbox);
	$curl_data+=$REQ_SEND;
	$curl_call = new INIT_PROCESS(CHATTING_SERVICE, $curl_data);
	session_start();
	echo "1";
	exit(0);
}

function beforeChatOpen() {
	global $ObjJSON, $REQ_SEND;
	unsetSession();
	$username	=	$_SESSION['username'];
	$chatbox	=	$_POST['chatbox'];
	$curl_data = array('action' => 'beforechatopen', 'username' => $username, 'chatbox' => $chatbox);
	$curl_data+=$REQ_SEND;
	$curl_call = new INIT_PROCESS(CHATTING_SERVICE, $curl_data);
	session_start();
	echo "1";
	exit(0);
}

function busyChat($senderid) {
	global $ObjJSON, $REQ_SEND;
	unsetSession();
	$username	=	$_SESSION['username'];
	$chatbox	=	$_POST['chatbox'];
	$curl_data = array('action' => 'busychat', 'senderid' => $senderid, 'username' => $username, 'chatbox' => $chatbox);
	$curl_data+=$REQ_SEND;
	$curl_call = new INIT_PROCESS(CHATTING_SERVICE, $curl_data);
	session_start();
	$res = Object2Array($ObjJSON->decode($curl_call->response));
	
	echo "1";
	exit(0);
}

function sanitize($text) {
	$text = htmlspecialchars($text, ENT_QUOTES);
	$text = str_replace("\n\r", "\n", $text);
	$text = str_replace("\r\n", "\n", $text);
	$text = str_replace("\n", "<br>", $text);
	return $text;
}

function unsetSession() {
	unset($_SESSION['openChatBoxes'][$_POST['chatbox']]);
}
?>