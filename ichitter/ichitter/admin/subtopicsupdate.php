<?php
#####################################################
# Banner Request Insertion
#####################################################
require_once 'includes/includes.inc';

if (@$_REQUEST['action'] == "addsubtopics") {
	$topicsid = $_POST['TopicTitle'];
	$title = $_POST['subtopicTitle'];
	$description = $_POST['subtopicDesc'];
	$image = $_FILES["fileupload"]["name"];


	if ((($_FILES["fileupload"]["type"] == "image/gif") || ($_FILES["fileupload"]["type"] == "image/jpeg") || ($_FILES["fileupload"]["type"] == "image/pjpeg") || ($_FILES["fileupload"]["type"] == "image/x-png"))) {
		if ($_FILES["fileupload"]["error"] > 0) {
			$usr_msg = "invalid_file";
			$msg = urlencode($usr_msg);
		} else {
			$subtopics = new subtopics;
			if ($image != "") {
				$fname = $subtopics->setUploadedFileName(basename($_FILES['fileupload']['name']));
			} else {
				$fname = "";
			}

			$subtopics->get_topics($title, $description, $fname, $topicsid);
			$result = $subtopics->insert_topics();
			$usr_msg = "subtopics_fail";
			if ($result) {
				move_uploaded_file($_FILES["fileupload"]["tmp_name"], "../upload_image/" . $fname);
				//move_uploaded_file($_FILES["fileupload"]["tmp_name"], "../upload_image/" . $_FILES["fileupload"]["name"]);
				$usr_msg = "addsubtopics_success";
			} else {
				$usr_msg = "subtopics_fail";
			}
			$msg = urlencode($usr_msg);
			print"<script>window.location='add_subtopics.php?msg=$msg'</script>";
		}
	} else {
		$usr_msg = "invalid_file";
		$msg = urlencode($usr_msg);
	}
}
if (@$_REQUEST['action'] == "editsubtopics") {
	$subtopicsid = $_POST['hidsubtopicsid'];
	$topicsid = $_POST['TopicTitle'];
	$title = $_POST['subtopicTitle'];
	$description = $_POST['subtopicDesc'];
	$image = $_FILES["fileupload"]["name"];
	$eximage = $_POST['hidimage'];
	$priority = $_POST['hidtopicspriority'];
	$isactive = 1; //$_POST['isActive'];

	if ($_FILES["fileupload"]["name"] != "") {
		if ((($_FILES["fileupload"]["type"] == "image/gif") || ($_FILES["fileupload"]["type"] == "image/jpeg") || ($_FILES["fileupload"]["type"] == "image/pjpeg") || ($_FILES["fileupload"]["type"] == "image/x-png"))) {
			if ($_FILES["fileupload"]["error"] > 0) {
				$usr_msg = "invalid_file";
				$msg = urlencode($usr_msg);
			} else {
				$topics = new subtopics;
				if ($image != "") {
					$fname = $topics->setUploadedFileName(basename($_FILES['fileupload']['name']));
				} else {
					$fname = "";
				}
				$topics->get_topics($title, $description, $fname, $topicsid);
				$result = $topics->update_topics($subtopicsid, $isactive, $priority);

				$usr_msg = "subtopics_fail";
				if ($result) {
					$fname = $topics->setUploadedFileName(basename($_FILES['fileupload']['name']));
					move_uploaded_file($_FILES["fileupload"]["tmp_name"], "../upload_image/" . $fname);
					//move_uploaded_file($_FILES["fileupload"]["tmp_name"], "../upload_image/" . $_FILES["fileupload"]["name"]);
					$usr_msg = "$updatesubtopics_success";
				} else {
					$usr_msg = "subtopics_fail";
				}
				$msg = urlencode($usr_msg);
				print"<script>window.location='subtopics_list.php'</script>";
			}
		} else {
			$usr_msg = "invalid_file";
			$msg = urlencode($usr_msg);
		}
	}
	if ($_FILES["fileupload"]["name"] == "") {
		$topics = new subtopics;
		$topics->get_topics($title, $description, $eximage, $topicsid);
		if ($isactive == "") {
			$isactive = 0;
		}
		$result = $topics->update_topics($subtopicsid, $isactive, $priority);
		//echo $result;
		$usr_msg = "subtopics_fail";
		if ($result) {
			$fname = $topics->setUploadedFileName(basename($_FILES['fileupload']['name']));
			move_uploaded_file($_FILES["fileupload"]["tmp_name"], "../upload_image/" . $fname);
			//move_uploaded_file($_FILES["fileupload"]["tmp_name"], "../upload_image/" . $_FILES["fileupload"]["name"]);
			$usr_msg = "$updatesubtopics_success";
		} else {
			$usr_msg = "subtopics_fail";
		}
		$msg = urlencode($usr_msg);
		print"<script>window.location='subtopics_list.php'</script>";
	}
}
if (@$_REQUEST['action'] == "delete") {
	$topicsid = $_GET['subtopicsid'];
	$topics = new subtopics;
	$result = $topics->delete_topics($topicsid);
	$usr_msg = "subtopicsdelete_fail";
	if ($result) {
		$usr_msg = "deletesubtopics_success";
	} else {
		$usr_msg = "subtopicsdelete_fail";
	}
	$msg = urlencode($usr_msg);
	print"<script>window.location='subtopics_list.php'</script>";
}
?>