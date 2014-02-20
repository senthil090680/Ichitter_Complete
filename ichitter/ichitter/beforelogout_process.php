<?php
require_once('lib/include_files.php');
error_reporting(0);

        $user_id = $_POST['user_id'];
		$curl_data = array('user_id' => $user_id, 'bflogout' => 'bf_logout');
		$curl_data+=$REQ_SEND;
		$curl_call = new INIT_PROCESS(BEFORELOGOUT_SERVICE, $curl_data);
		echo $res = Object2Array($ObjJSON->decode($curl_call->response));
?>