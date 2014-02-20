<?php
include_once 'library/include_files.php';
//include_once 'common/redirectto.php';

$action = $_REQUEST[PARAM_ACTION];

$strpos = strpos($_SERVER['HTTP_REFERER'], '&msg');
$rd = $_SERVER['HTTP_REFERER'];
if ($strpos !== false) {
	$rd = substr($_SERVER['HTTP_REFERER'], 0, $strpos);
}
//$log = new Logging();

switch ($action) {
	case "addnewtopic":
		if (trim($_REQUEST[PARAM_TOPIC_TITLE]) == "") {
			header("Location: " . $rd . "&msg=topic_add_fail");
		}
		if (($_FILES[PARAM_FILE_UPLOAD]['name'] != "") && ($_FILES[PARAM_FILE_UPLOAD]['error'] == "0")) {
			$save_to = "upload_image/";
			$fname = $commonFunc->setUploadedFileName(basename($_FILES[PARAM_FILE_UPLOAD]['name']));
			$save_to = $save_to . $fname;
			if (copy($_FILES[PARAM_FILE_UPLOAD]['tmp_name'], $save_to)) {
				$handle = fopen($save_to, "rb");
				$imgbinary = fread($handle, filesize($save_to));
				$REQ_SEND[PARAM_ACTION] = $action;
				$REQ_SEND[PARAM_TOPIC_TITLE] = $_REQUEST[PARAM_TOPIC_TITLE];
				$REQ_SEND[PARAM_TOPIC_DESCRIPTION] = $_REQUEST[PARAM_TOPIC_DESCRIPTION];
				$REQ_SEND[PARAM_FILE_NAME] = $fname;
				$REQ_SEND[PARAM_FILE_CONTENT] = base64_encode($imgbinary);
				$REQ_SEND[PARAM_USERID] = $_SESSION['login']['user_id'];
				$ObjCURL = new INIT_PROCESS(TOPIC_SERVICE_PAGE, $REQ_SEND);
				$restopic = Object2Array($ObjJSON->decode($ObjCURL->response));

				if ($restopic['msg'] == "OK") {
					header("Location: " . $rd . "&msg=topic_add_success");
				} else {
					header("Location: " . $rd . "&msg=topic_add_fail");
				}
			} else {
				header("Location: " . $rd . "&msg=topic_add_fail");
			}
		} else {
			header("Location: " . $rd . "&msg=topic_add_fail");
		}

	case "addtopic":
		$REQ_SEND[PARAM_ACTION] = $action;
		$REQ_SEND[PARAM_TOPIC_TITLE] = $_REQUEST[PARAM_TOPIC_TITLE];
		$REQ_SEND[PARAM_TOPIC_DESCRIPTION] = $_REQUEST[PARAM_TOPIC_DESCRIPTION];
		$REQ_SEND[PARAM_GRAPHIC_ID] = $_REQUEST[PARAM_GRAPHIC_ID];
		$REQ_SEND[PARAM_USERID] = $_SESSION['login']['user_id'];

		$ObjCURL = new INIT_PROCESS(TOPIC_SERVICE_PAGE, $REQ_SEND);
		$restopic = Object2Array($ObjJSON->decode($ObjCURL->response));

		if ($restopic['msg'] == "OK") {
			header("Location: addtopics.php?msg=topic_add_success");
		} else {
			header("Location: addtopics.php?msg=topic_add_fail");
		}

		break;
		
	case "topicreorder" : 
		$REQ_SEND = $REQ_SEND + $_REQUEST;
		$REQ_SEND[PARAM_USERID] = $_SESSION['login']['user_id'];
		$REQ_SEND['listItem'] = implode(',', $_REQUEST['listItem']);
		$ObjCURL = new INIT_PROCESS(TOPIC_SERVICE_PAGE, $REQ_SEND);
		//$restopic = Object2Array($ObjJSON->decode($ObjCURL->response));
		print $ObjCURL->response;
		break;

	default: break;
}
?>
