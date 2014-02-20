<?php
include_once 'library/include_files.php';
//include_once 'common/redirectto.php';

$action = $_REQUEST[PARAM_ACTION];
$strpos = strpos($_SERVER['HTTP_REFERER'], '&msg');
$rd = $_SERVER['HTTP_REFERER'];
if($strpos !== false) {
	$rd = substr($_SERVER['HTTP_REFERER'], 0, $strpos);
}
$l = new Logging();



switch(trim($action)) {
	case "addnewsubtopic":
		$file = $_FILES['st_fileupload'];
		
		if(trim($_REQUEST['st_topics']) == "" || trim($_REQUEST['st_title']) == ""){
			header("Location: " . $rd . "&msg=subtopic_add_fail");
		}
		if(($file['name'] != "") && ($file['error'] == "0")){
			$save_to = "upload_image/";  
			$fname = $commonFunc->setUploadedFileName(basename($file['name']));
			$save_to .= $fname;
			if(copy($file['tmp_name'], $save_to)) {
				$handle = fopen($save_to, "rb");
				$imgbinary = fread($handle, filesize($save_to));
				$REQ_SEND[PARAM_ACTION] = $action;
				$REQ_SEND[PARAM_TOPICID] = $_REQUEST['st_topics'];
				$REQ_SEND[PARAM_TOPIC_TITLE] = $_REQUEST['st_title'];
				$REQ_SEND[PARAM_TOPIC_DESCRIPTION] = $_REQUEST['st_desc'];
				$REQ_SEND[PARAM_FILE_NAME] = $fname;
				$REQ_SEND[PARAM_FILE_CONTENT] = base64_encode($imgbinary);
				$REQ_SEND[PARAM_USERID] = $_SESSION['login']['user_id'];
				
				$ObjCURL = new INIT_PROCESS(SUBTOPIC_SERVICE_PAGE, $REQ_SEND);
				$restopic = Object2Array($ObjJSON->decode($ObjCURL->response));
								
				if($restopic['msg'] == "OK") {
					header("Location: " . $rd . "&msg=subtopic_add_success");
				} else {
					header("Location: " . $rd . "&msg=subtopic_add_fail");
				}
			}
			else{
				header("Location: " . $rd . "&msg=subtopic_add_fail");
			}
		}else{
			header("Location: " . $rd . "&msg=subtopic_add_fail");
		}
		break;
		
	case "addsubtopic":
		//Array ( [st_topics] => 7 [st_title] => fgh [st_desc] => fgh [psubmit_x] => 93 [psubmit_y] => 10 [action] => addsubtopic [rdimg] => 20 ) 
		$REQ_SEND[PARAM_ACTION] = $action;
		$REQ_SEND[PARAM_TOPICID] = $_REQUEST['st_topics'];
		$REQ_SEND[PARAM_TOPIC_TITLE] = $_REQUEST['st_title'];
		$REQ_SEND[PARAM_TOPIC_DESCRIPTION] = $_REQUEST['st_desc'];
		$REQ_SEND[PARAM_GRAPHIC_ID] = $_REQUEST[PARAM_GRAPHIC_ID];
		$REQ_SEND[PARAM_USERID] = $_SESSION['login']['user_id'];
		
		$ObjCURL = new INIT_PROCESS(SUBTOPIC_SERVICE_PAGE, $REQ_SEND);
		$restopic = Object2Array($ObjJSON->decode($ObjCURL->response));
		
		if($restopic['msg'] == "OK") {
			header("Location: addsubtopics.php?msg=subtopic_add_success");
		} else {
			header("Location: addsubtopics.php?msg=subtopic_add_fail");
		}
		//print_r($_REQUEST);
		//die ();
		
		break;
		
	case "getmax" : 
		$REQ_SEND[PARAM_ACTION] = $_REQUEST[PARAM_ACTION];
		$REQ_SEND[PARAM_TOPICID] = $_REQUEST['tid'];
		$ObjCURL = new INIT_PROCESS(SUBTOPIC_SERVICE_PAGE, $REQ_SEND);
		//$maxtopic = Object2Array($ObjCURL->response);
		print $ObjCURL->response;
		
		break;
	
	case "gettopicslist" : 
		$REQ_SEND[PARAM_ACTION] = $_REQUEST[PARAM_ACTION];
		$tid = $_REQUEST['tid'];
		$ObjCURL = new INIT_PROCESS(TOPIC_SERVICE_PAGE, $REQ_SEND);
		$Topicslist = Object2Array($ObjJSON->decode($ObjCURL->response));
		//print $ObjCURL->response;
		$select = '<select id="st_topics" name="st_topics" class="txt-field">';
		$select .= '<option value="0">--Select--</option>';
			if(count($Topicslist) > 0) {
				foreach ($Topicslist as $idx => $rec) {
					$selected = "";
					if ($tid == $rec['topics_id']) {
						$selected = " selected=selected";
					}
					$select .= '<option value="' . $rec['topics_id'] . '" ' . $selected . '>' . $rec['title'] . '</option>';
				}
			}
			
		$select .= '</select>';
		print $select;
		break;
		
	case "subtopicreorder" : 
		$REQ_SEND = $REQ_SEND + $_REQUEST;
		$REQ_SEND[PARAM_USERID] = $_SESSION['login']['user_id'];
		$REQ_SEND[PARAM_TOPICID] = $_REQUEST['tid'];
		$REQ_SEND['listItem'] = implode(',', $_REQUEST['listItem']);
		
		$ObjCURL = new INIT_PROCESS(SUBTOPIC_SERVICE_PAGE, $REQ_SEND);
		print $ObjCURL->response;
		
		break;
	
	default: break;
}
?>
