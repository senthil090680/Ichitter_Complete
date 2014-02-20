<?php
ob_start();
//error_reporting(0);

/*define ('DBPATH','192.168.100.200:3306');
define ('DBUSER','ichitter');
define ('DBPASS','Y34Gae39');
define ('DBNAME','ichitter');*/

define ('DBPATH','localhost');
define ('DBUSER','root');
define ('DBPASS','');
define ('DBNAME','ichitter');

session_start();


global $dbh;
$dbh = mysql_connect(DBPATH,DBUSER,DBPASS);
mysql_selectdb(DBNAME,$dbh);

if ($_GET['action'] == "chatheartbeat") { chatHeartbeat(); } 
if ($_GET['action'] == "sendchat") { sendChat(); } 
if ($_GET['action'] == "closechat") { closeChat(); }
if ($_GET['action'] == "busychat") { busyChat($_GET['senderid']); }
if ($_GET['action'] == "startchatsession") { startChatSession(); } 
if ($_GET['action'] == "get_user_name") { get_user_name(); }
if ($_GET['action'] == "confirmchat") { confirmChatHeartbeat($_GET['chatfrom']); } 
if ($_GET['action'] == "updatechatheartbeat") { updateChatHeartbeat($_GET['chatfromperson']); } 
if ($_GET['action'] == "beforechatopen") { beforeChatOpen(); } 

if (!isset($_SESSION['chatHistory'])) {
	$_SESSION['chatHistory'] = array();	
}

if (!isset($_SESSION['openChatBoxes'])) {
	$_SESSION['openChatBoxes'] = array();	
}

function get_user_name(){
	$userquery = mysql_query("SELECT first_Name,last_Name FROM tbl_user_profile WHERE user_id='$_GET[user_id]'");	
	$userrow=mysql_fetch_array($userquery);
	$recusername = ucfirst($userrow['first_Name'])." ".ucfirst($userrow['last_Name']);
	header('Content-type: application/json');
	?>
	{
			"recusername": "<?php echo $recusername; ?>"
			
	}
	<?php
				exit(0);

}

function updateChatHeartbeat($chatfrom) {
	$sql = "update chat set recd = 2 where chat.to = '".mysql_real_escape_string($_SESSION['username'])."' AND chat.from = '".mysql_real_escape_string($chatfrom)."' and recd = 0";
	$query = mysql_query($sql) or die(mysql_error);
	
	if($query) {
		echo "1";
	}
	else { 
		echo "5";
	}
	exit(0);
}

function confirmChatHeartbeat($chatfrom) {
	$deletePrevious = mysql_query("DELETE FROM chat WHERE sent <= DATE_SUB(NOW(), INTERVAL 60 MINUTE)");		
	$sql = "select * from chat where (chat.to = '".mysql_real_escape_string($_SESSION['username'])."' AND chat.from = '".mysql_real_escape_string($chatfrom)."' AND recd = 7) order by id ASC";
	$query = mysql_query($sql);
	$items = '';

	$chatBoxes = array();

	$_SESSION['openChatBoxes'][$chatfrom] = date('Y-m-d H:i:s', time());

	while ($chat = mysql_fetch_array($query)) {
		
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

	}

	$sql = "update chat set recd = 2 where chat.to = '".mysql_real_escape_string($_SESSION['username'])."' AND chat.from = '".mysql_real_escape_string($chatfrom)."' and recd = 7";
	$query = mysql_query($sql);

	if ($items != '') {
		$items = substr($items, 0, -1);
	}
header('Content-type: application/json');
?>
{
		"items": [
			<?php echo $items;?>
        ]
}

<?php
			exit(0);
}

function chatHeartbeat() {
	$deletePrevious = mysql_query("DELETE FROM chat WHERE sent <= DATE_SUB(NOW(), INTERVAL 60 MINUTE)");		
	$sql = "select * from chat where (chat.to = '".mysql_real_escape_string($_SESSION['username'])."' AND recd = 0) order by id ASC";
	$query = mysql_query($sql);
	$items = '';

	$chatBoxes = array();

	while ($chat = mysql_fetch_array($query)) {

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
			$now = time()-strtotime($time);
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

	$sql = "update chat set recd = 2 where chat.to = '".mysql_real_escape_string($_SESSION['username'])."' and recd = 0";
	//$query = mysql_query($sql);

	if ($items != '') {
		$items = substr($items, 0, -1);
	}
header('Content-type: application/json');
?>
{
		"items": [
			<?php echo $items; ?>
        ]
}

<?php
			exit(0);
}

function chatBoxSession($chatbox) {
	
	$items = '';
	
	if (isset($_SESSION['chatHistory'][$chatbox])) {
		$items = $_SESSION['chatHistory'][$chatbox];
	}

	return $items;
}

function startChatSession() { ?>


<?php
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
		"username": "<?php echo $_SESSION['username'];?>",
		"items": [
			<?php echo $items;?>
        ]
}

<?php


	exit(0);
}

function sendChat() {
	$from = $_SESSION['username'];
	$to = $_POST['to'];
	$message = $_POST['message'];

	$_SESSION['openChatBoxes'][$_POST['to']] = date('Y-m-d H:i:s', time());
	
	$messagesan = sanitize($message);

	if (!isset($_SESSION['chatHistory'][$_POST['to']])) {
		$_SESSION['chatHistory'][$_POST['to']] = '';
	}

	$_SESSION['chatHistory'][$_POST['to']] .= <<<EOD
					   {
			"s": "1",
			"f": "{$to}",
			"m": "{$messagesan}"
	   },
EOD;


	unset($_SESSION['tsChatBoxes'][$_POST['to']]);

	$sql = "insert into chat (chat.from,chat.to,message,sent,recd) values ('".mysql_real_escape_string($from)."', '".mysql_real_escape_string($to)."','".mysql_real_escape_string($message)."',NOW(),'0')";
	$query = mysql_query($sql);
	echo "1";
	exit(0);
}

function closeChat() {

	unset($_SESSION['openChatBoxes'][$_POST['chatbox']]);

	$sql = "update chat set recd = 3 WHERE chat.to = '".mysql_real_escape_string($_SESSION['username'])."' AND chat.from = '".mysql_real_escape_string($_POST['chatbox'])."' AND recd = 0";
	$query = mysql_query($sql);
	
	echo "1";
	exit(0);
}

function beforeChatOpen() {
	
	unset($_SESSION['openChatBoxes'][$_POST['chatbox']]);

	$sql = "UPDATE chat SET recd = 7 WHERE chat.to = '".mysql_real_escape_string($_SESSION['username'])."' AND chat.from = '".mysql_real_escape_string($_POST['chatbox'])."' AND recd = 0";
	$query = mysql_query($sql);
	
	echo "1";
	exit(0);
}

function busyChat($senderid) {

	unset($_SESSION['openChatBoxes'][$_POST['chatbox']]);

	$sql = "update chat set recd = 5 WHERE chat.to = '".mysql_real_escape_string($_SESSION['username'])."' AND chat.from = '".mysql_real_escape_string($_POST['chatbox'])."' AND recd = 0";
	$query = mysql_query($sql);

	$message = "I am busy";

	$sql_insert = "INSERT INTO chat (chat.from,chat.to,message,sent) values ('".mysql_real_escape_string($_SESSION['username'])."', '".mysql_real_escape_string($senderid)."','".mysql_real_escape_string($message)."',NOW())";
	$query_insert = mysql_query($sql_insert);

	echo "1";
	exit(0);
}

function sanitize($text) {
	$text = htmlspecialchars($text, ENT_QUOTES);
	$text = str_replace("\n\r","\n",$text);
	$text = str_replace("\r\n","\n",$text);
	$text = str_replace("\n","<br>",$text);
	return $text;
}
