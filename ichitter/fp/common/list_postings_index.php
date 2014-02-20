<?php
$REQ_SEND[PARAM_ACTION] = "listpost";
$REQ_SEND[PARAM_POSTID] = "$postid";
$REQ_SEND[PARAM_TOPICID] = "$topicid";
$REQ_SEND[PARAM_SUBTOPICID] = "$subtopicid";
$REQ_SEND[PARAM_USERID] = "$user_id";
$REQ_SEND[PARAM_ORDER] = "DESC";
$REQ_SEND[PARAM_LIMIT] = "3";
$REQ_SEND[PARAM_IS_ARCHIVED] = "0";
$REQ_SEND[PARAM_IS_MARKED] = false;

$ObjCURL = new INIT_PROCESS(POSTING_SERVICE_PAGE, $REQ_SEND);

$result = Object2Array($ObjJSON->decode($ObjCURL->response));

$msg = "";
if(isset ($_REQUEST['msg'])) {
	$msg = $_REQUEST['msg'];
}
?>
<div class="alltopicwrap">
    <div class="alltopichead"><p><a href="alltopics.php">All Topics</a></p></div>
	<div style="text-align: center; float:left; padding:3px 0px 0px 0px; width: 100%; font-size:13px; color: green;"><?php echo $$msg; ?></div>
    <ul>
		<?php
		if (count($result) > 0) {
			$i = 1;
			foreach ($result as $akey => $rec) {
				$uid = "";
				$uid = $rec['user_id'];
				$gype = $rec['graphic_type'];
				$imgSource = "resource/images/no-img.jpg";
				$vdoSource = "resource/images/videotemp.jpg";
				if ($rec['image_name'] != "") {
					$src = IMAGE_UPLOAD_SERVER . $uid . '/' . $rec['igallery_name'] . '/' . $rec['image_name'];
					$imgSource = $src;
				}
				$video_name = $rec['video_name'];
				$video_thumb_name = substr($video_name, 0, strlen($video_name) - 3) . "jpg";
				$src = VIDEO_UPLOAD_SERVER . $uid . '/' . $rec['vgallery_name'] . '/thumb/' . $video_thumb_name;
				if ($video_name != "") {
					$vdoSource = $src;
				}
				?>
				<li>
					<div style="float:left; width:25px; padding:40px 3px; ">
						<?php if ($session_obj->checkSession()) { ?>
							<input type="checkbox" name="cb_mark[]" style="display: none;" value="<?php echo $rec['posting_id']; ?>" <?php echo $checked; ?> />
						<?php } else { ?>
							<input type="checkbox" name="cb_mark[]" class="styled" style="display: none;" value="<?php echo $rec['posting_id']; ?>" <?php echo $checked; ?> />
							<input type="checkbox" name="cb_mark1[]" style="display:none;" value="<?php echo $rec['posting_id'] . '_' . $rec['sub_topic_id']; ?>" checked="checked" />
						<?php } ?>
					</div>    
					<?php if ($rec['graphic_type'] == 'I') { ?>
						<div class="videosmall"><a href="discussion.php?<?php echo PARAM_TOPICID . "=" . $rec['topic_id'] . "&" . PARAM_SUBTOPICID . "=" . $rec['sub_topic_id'] . "&" . PARAM_POSTID . "=" . $rec['posting_id']; ?>"><img src="<?php echo $imgSource; ?>" alt="" border="0" style="width:132px; height:84px;" /></a></div>
					<?php } else { ?>
						<div class="videosmall"><a href="discussion.php?<?php echo PARAM_TOPICID . "=" . $rec['topic_id'] . "&" . PARAM_SUBTOPICID . "=" . $rec['sub_topic_id'] . "&" . PARAM_POSTID . "=" . $rec['posting_id']; ?>"><img src="<?php echo $vdoSource; ?>" alt="" border="0" style="width:132px; height:84px;" /></a></div>
					<?php } ?>
					<div style="width:540px; float:right;" >
						<h2><a href="discussion.php?<?php echo PARAM_TOPICID . "=" . $rec['topic_id'] . "&" . PARAM_SUBTOPICID . "=" . $rec['sub_topic_id'] . "&" . PARAM_POSTID . "=" . $rec['posting_id']; ?>"><?php echo $rec['title']; ?></a></h2>
						<div  id="history<?php echo $i; ?>" >
							<?php echo htmlspecialchars_decode($rec['post_content']); ?>
						</div>
						<div class="morebtn">
							<a href="javascript: void(0);" id="more<?php echo $i; ?>" ><img src="" alt="" border="0" /></a>
							<?php
							if (!$session_obj->checkSession()) {
								if ($_SESSION['login']['user_id'] == $rec['user_id']) {
									?>
									<a href="update_post.php?<?php echo PARAM_TOPICID . "=" . $rec['topic_id'] . "&" . PARAM_SUBTOPICID . "=" . $rec['sub_topic_id'] . "&" . PARAM_POSTID . "=" . $rec['posting_id']; ?>" id="edit<?php echo $i; ?>"><img src="" alt="" border="0" /></a>
									<a href="javascript: removePosting('<?php print $rec['posting_id']; ?>',<?php print $rs = ($rec['counts'] > 0) ? 1 : 0; ?>, false);" id="del<?php echo $i; ?>"><img src="" alt="" border="0" /></a>
									<?php }
								} ?>
						</div>

						<h4><?php echo $rec['counts']; ?> Comments</h4>
					</div>
				</li>
				<?php
				$i++;
			}
		} else {
			echo "<div class='post-msg'>" . POSTINGS_NOT_FOUND . "</div>";
		}
		?>
    </ul>
</div>