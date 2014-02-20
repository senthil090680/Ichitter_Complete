<?php

#####################################################
# Topics Insertion, Updateion and Deletion
#####################################################
require_once 'includes/includes.inc';


if (@$_REQUEST['action'] == "addtopics") {
	$title = $_POST['topicTitle'];
	$description = $_POST['topicDesc'];
	$image = $_FILES["fileupload"]["name"];

	if ((($_FILES["fileupload"]["type"] == "image/gif") || ($_FILES["fileupload"]["type"] == "image/jpeg") || ($_FILES["fileupload"]["type"] == "image/pjpeg") || ($_FILES["fileupload"]["type"] == "image/x-png"))) {
		if ($_FILES["fileupload"]["error"] > 0) {
			$usr_msg = "invalid_file";
			$msg = urlencode($usr_msg);
		} else {
			$topics = new topics;
			if ($image != "") {
				$fname = $topics->setUploadedFileName(basename($_FILES['fileupload']['name']));
			} else {
				$fname = "";
			}

			$topics->get_topics($title, $description, $fname);
			$result = $topics->insert_topics();
			//echo $result;
			//$result = true;
			$usr_msg = "topics_fail";
			if ($result) {
				move_uploaded_file($_FILES["fileupload"]["tmp_name"], "../upload_image/" . $fname);
				$usr_msg = "addtopics_success";
			} else {
				$usr_msg = "topics_fail";
			}
			$msg = urlencode($usr_msg);
			print"<script>window.location='add_topics.php?msg=$msg'</script>";
		}
	} else {
		$usr_msg = "invalid_file";
		$msg = urlencode($usr_msg);
	}
}
if (@$_REQUEST['action'] == "edittopics") {
	$title = $_POST['topicTitle'];
	$description = $_POST['topicDesc'];
	$image = $_FILES["fileupload"]["name"];
	$eximage = $_POST['hidimage'];
	$topicsid = $_POST['hidtopicsid'];
	$priority = $_POST['hidtopicspriority'];
	$isactive = 1; //$_POST['isActive'];

	if ($_FILES["fileupload"]["name"] != "") {
		if ((($_FILES["fileupload"]["type"] == "image/gif") || ($_FILES["fileupload"]["type"] == "image/jpeg") || ($_FILES["fileupload"]["type"] == "image/pjpeg") || ($_FILES["fileupload"]["type"] == "image/x-png"))) {
			if ($_FILES["fileupload"]["error"] > 0) {
				$usr_msg = "invalid_file";
				$msg = urlencode($usr_msg);
			} else {
				$topics = new topics;
				if ($image != "") {
					$fname = $topics->setUploadedFileName(basename($_FILES['fileupload']['name']));
				} else {
					$fname = "";
				}
				$topics->get_topics($title, $description, $fname);
				$result = $topics->update_topics($topicsid, $isactive, $priority);

				$usr_msg = "topics_fail";
				if ($result) {
					//$fname = $topics->setUploadedFileName(basename($_FILES['fileupload']['name']));

					move_uploaded_file($_FILES["fileupload"]["tmp_name"], "../upload_image/" . $fname);
					$usr_msg = "$updatetopics_success";
				} else {
					$usr_msg = "topics_fail";
				}
				$msg = urlencode($usr_msg);
				print "<script>window.location='topics_list.php'</script>";
			}
		} else {
			$usr_msg = "invalid_file";
			$msg = urlencode($usr_msg);
		}
	}
	if ($_FILES["fileupload"]["name"] == "") {
		$topics = new topics;
		$topics->get_topics($title, $description, $eximage);
		if ($isactive == "") {
			$isactive = 0;
		}
		$result = $topics->update_topics($topicsid, $isactive, $priority);
		//echo $result;

		$usr_msg = "topics_fail";
		if ($result) {
			$fname = $topics->setUploadedFileName(basename($_FILES['fileupload']['name']));
			move_uploaded_file($_FILES["fileupload"]["tmp_name"], "../upload_image/" . $fname);
			$usr_msg = "$updatetopics_success";
		} else {
			$usr_msg = "topics_fail";
		}
		$msg = urlencode($usr_msg);
		print"<script>window.location='topics_list.php'</script>";
	}
}
if (@$_REQUEST['action'] == "delete") {
	$topicsid = $_GET['topicsid'];
	$topics = new topics;
	$result = $topics->delete_topics($topicsid);
	$usr_msg = "topicsdelete_fail";
	if ($result) {
		$usr_msg = "deletetopics_success";
	} else {
		$usr_msg = "topicsdelete_fail";
	}
	$msg = urlencode($usr_msg);
	print "<script>window.location='topics_list.php'</script>";
}
?>

