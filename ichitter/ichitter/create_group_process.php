<?php
require_once('lib/include_files.php');
$group_name = $_POST['name'];
$WhoWeAre = $_POST['WhoWeAre'];
$Isay = $_POST['Isay'];
$user_id = $_POST['user_id'];

		$curl_data = array('group_name' => $group_name, 'WhoWeAre' => $WhoWeAre, 'Isay' => $Isay, 'user_id' => $user_id, 'create' => 'Create');
		$curl_data+=$REQ_SEND;
		$curl_call = new INIT_PROCESS(CLASS_GROUP_SERVICE, $curl_data);
		echo $response = Object2Array($ObjJSON->decode($curl_call->response));
?>