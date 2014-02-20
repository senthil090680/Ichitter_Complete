<?php
class SESSION extends Encryption {
	private $KEY = "";

	function __construct() {
		$this->KEY = ENC_KEY;
	}

	public function set_Session($data, $session_Name) {
		$_SESSION[$session_Name] = $data;
		$_SESSION[$session_Name]['EID'] = $this->encrypt($this->KEY, $data['email_id']);
		$_SESSION[$session_Name]['PSD'] = $this->encrypt($this->KEY, $data['psd']);
		return true;
	}

	public function get_Session($data) {
		switch ($data) {
			case 'login':
				return (isset($_SESSION["$data"]['user_id'])) ? 'true' : 'false';
				break;
			case 'user_id':
				return (isset($_SESSION['login']["$data"])) ? $_SESSION['login']["$data"] : false;
				break;
			case 'EID':
				return (isset($_SESSION['login']["$data"])) ? $_SESSION['login']["$data"] : false;
				break;
			case 'PSD':
				return (isset($_SESSION['login']["$data"])) ? $_SESSION['login']["$data"] : false;
				break;
		}
	}

	public function checkSession() {
		if ($_SESSION['login']['email_id'] == "") {
			return true;
		} else {
			return false;
		}
	}

	public function unset_Session($data) {
		global $ObjJSON, $REQ_SEND;;
		$user_id = $_SESSION['login']['user_id'];
		session_destroy();
		header('cache-control: no-cache,no-store,must-revalidate'); // HTTP 1.1.
		header('pragma: no-cache'); // HTTP 1.0.
		header('expires: 0'); // Proxies.

		$curl_data = array('user_id' => $user_id, 'bflogout' => 'bf_logout');
		$curl_data+=$REQ_SEND;
		$curl_call = new INIT_PROCESS(BEFORELOGOUT_SERVICE, $curl_data);
		$response = Object2Array($ObjJSON->decode($curl_call->response));
	}

//	function setSession() {
//		$_SESSION['login']['user_id'] = $_SESSION['login']['user_id'];
//		$_SESSION['login']['email_id'] = $_SESSION['login']['email_id'];
//		$_SESSION['login']['username'] = $_SESSION['login']['username'];
//		$_SESSION['login']['last_loggedin'] = $_SESSION['login']['last_loggedin'];
//	}

	function getSessionUserID() {
		return $_SESSION['login']['user_id'];
	}

}
?>