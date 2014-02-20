<?php
$REQ_SEND[PARAM_ACTION] = "bypriority";
$REQ_SEND[PARAM_POSTID] = "$postid";
$REQ_SEND[PARAM_TOPICID] = "$topicid";
$REQ_SEND[PARAM_SUBTOPICID] = "$subtopicid";
$REQ_SEND[PARAM_USERID] = "$userid";
$REQ_SEND[PARAM_ORDER] = "DESC";
$REQ_SEND[PARAM_LIMIT] = "";
$REQ_SEND[PARAM_IS_ARCHIVED] = "0";

$ObjCURL = new INIT_PROCESS(TOPIC_SERVICE_PAGE, $REQ_SEND);
$result = Object2Array($ObjJSON->decode($ObjCURL->response));

$imgSource = "resource/images/no-img.jpg";
?>
<div class="homeboxwrap">
<?php
	if(count($result)>0) {
		foreach ($result as $key => $row) {
			echo '<div class="homebox">';
			echo '<div class="homeboxtop"><img src="resource/images/homebox1.jpg" alt="" /></div>';
			echo '<div class="homeboxmid">';
			echo '<div class="homeboxmidhead"><a href="subtopics.php?' . PARAM_TOPICID . '=' . $row['topics_id'] . '">' . $row['title'] . '</a></div>';
			if($row['user_id'] == 0) {
				echo '<img src="upload_image/' . $row['image'] . '" alt="us currency" style="height: 75px; width: 213px;"  />';
			} else {
				$imgPath = IMAGE_UPLOAD_SERVER . $row['user_id'] . '/' . $row['igallery_name'] . '/';
				echo '<img src="' . $imgPath . $row['image_name'] . '" alt="us currency" style="height: 75px; width: 213px;"  />';
			}

			echo '<p><b>6,321</b> articles | <b>20,000</b> views | <b>86,425</b> opinions</p>';
			echo '</div>';
			echo '<div class="homeboxbot"><img src="resource/images/homebox3.jpg" alt="" /></div></div>';
		}
	}
?>
</div>