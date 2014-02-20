<?php
if (!$session_obj->checkSession()) {
	if (($page_info['basename'] != "alltopics.php") && ($page_info['basename'] != "markedlist.php")) {
		if ($topicTitle != "") {
			if ($page_info['basename'] == "federal-history.php") {
				echo "<h1 class=\"dischdr\">$topicTitle - $subTopicTitle<div class=\"gotopost\"><a href=\"subtopics.php?" . PARAM_TOPICID . "=$topicsid\">" . LINKTO_GO_TO_POSTING . "</a> | <a href=\"markedlist.php?" . PARAM_TOPICID . "=$topicsid\">" . LINKTO_MY_MARKED_LIST . "</a></div></h1>";
			} else {
				echo "<h1 class=\"dischdr\">$topicTitle<div class=\"gotopost\"><a href=\"subtopics.php?" . PARAM_TOPICID . "=$topicsid\">" . LINKTO_GO_TO_POSTING . "</a> | <a href=\"markedlist.php?" . PARAM_TOPICID . "=$topicsid\">" . LINKTO_MY_MARKED_LIST . "</a></div></h1>";
			}
		} else {
			echo "<h1 class=\"dischdr\">$subTopicTitle<div class=\"gotopost\"><a href=\"subtopics.php?" . PARAM_TOPICID . "=$topicsid\">" . LINKTO_GO_TO_POSTING . "</a> | <a href=\"markedlist.php?" . PARAM_TOPICID . "=$topicsid\">" . LINKTO_MY_MARKED_LIST . "</a></div></h1>";
		}
	}
	if ($page_info['basename'] == "markedlist.php") {
		echo "<h1 class=\"dischdr\">My Marked List<div class=\"gotopost\"><a href=\"alltopics.php\">" . LINKTO_GO_TO_POSTING . "</a></div></h1>";
	}
	if ($page_info['basename'] == "alltopics.php") {
		echo "<h1 class=\"dischdr\">All Topics<div class=\"gotopost\"><a href=\"markedlist.php\">" . LINKTO_MY_MARKED_LIST . "</a></div></h1>";
	}
} else {
	if (($page_info['basename'] != "alltopics.php") && ($page_info['basename'] != "markedlist.php")) {
		if ($topicTitle != "") {
			if ($page_info['basename'] == "federal-history.php") {
				echo "<h1 class=\"dischdr\">$topicTitle - $subTopicTitle <div class=\"gotopost\"><a href=\"subtopics.php?" . PARAM_TOPICID . "=$topicsid\">" . LINKTO_GO_TO_POSTING . "</a></div></h1>";
			} else {
				echo "<h1 class=\"dischdr\">$topicTitle<div class=\"gotopost\"><a href=\"subtopics.php?" . PARAM_TOPICID . "=$topicsid\">" . LINKTO_GO_TO_POSTING . "</a></div></h1>";
			}
		} else {
			echo "<h1 class=\"dischdr\">$subTopicTitle <div class=\"gotopost\"><a href=\"subtopics.php?" . PARAM_TOPICID . "=$topicsid\">" . LINKTO_GO_TO_POSTING . "</a></div></h1>";
		}
	}
}
?>
<div style="float:left;padding: 10px 0px 0px 0px; width: 730px;">
	<?php
	if (!$session_obj->checkSession()) {
		if ($num_rows > 0) {
			?>
			<div class="marking" ><img id="markit" src="resource/images/mark-all.png" alt="" /></div>
		<?php } ?>
		<div style="text-align: center; float:left; padding:3px 0px 0px 0px; width: 540px; font-size:13px; color: green;"><?php echo $$msg; ?></div>
		<?php if (($page_info['basename'] != "viewpostings.php") && ($page_info['basename'] != "alltopics.php") && ($page_info['basename'] != "markedlist.php")) { ?>
			<div class="newpost"><img id="addPost" src="resource/images/newpost.png" alt="" /></div>
			<?php
		} //addnewposts
		if (($page_info['basename'] == "viewpostings.php")) {
			echo '<div class="newpost"><img id="addnewposts" src="resource/images/newpost.png" alt="" /></div>';
		}
	}
	?>
</div>
<?php
if ($num_rows > 0) {
	?>
	<div class="alltopicwrap">
		<ul>
			<?php
			$i = 1;
			$posting_id = "0";
			foreach ($result as $akey => $row) {
				//$log->lwritearray($row); 
				$uid = "";
				$uid = $row['user_id'];
				$gype = $row['graphic_type'];
				$imgSource = "resource/images/no-img.jpg";
				$vdoSource = "resource/images/videotemp.jpg";
				if ($row['image_name'] != "") {
					$src = IMAGE_UPLOAD_SERVER . $uid . '/' . $row['igallery_name'] . '/' . $row['image_name'];
					$imgSource = $src;
				}
				$video_name = $row['video_name'];
				$video_thumb_name = substr($video_name, 0, strlen($video_name) - 3) . "jpg";
				$src = VIDEO_UPLOAD_SERVER . $uid . '/' . $row['vgallery_name'] . '/thumb/' . $video_thumb_name;
				if ($video_name != "") {
					$vdoSource = $src;
				}
				$checked = null;
				if ($row['mark_id'] != "") {
					if ($row['mrkuser'] == $_SESSION['login']['user_id']) {
						$checked = " checked=checked";
					} else {
						$checked = "";
					}
				}
				?>
				<li>
					<div style="float:left; width:25px; padding:40px 3px; ">
						<?php if ($session_obj->checkSession()) { ?>
							<input type="checkbox" name="cb_mark[]" style="display: none;" value="<?php echo $row['posting_id']; ?>" <?php echo $checked; ?> /></div>
					<?php } else { ?>
						<input type="checkbox" name="cb_mark[]" class="styled" value="<?php echo $row['posting_id'] . '_' . $row['sub_topic_id'] . '_' . $row['topic_id']; ?>" <?php echo $checked; ?> />
						<input type="hidden" name="tsp[]" id="tsp" value="<?php echo $row['topic_id'] . '_' . $row['posting_id'] . '_' . $row['sub_topic_id']; ?>" />
						<input type="checkbox" name="cb_mark1[]" style="display:none;" value="<?php echo $row['posting_id'] . '_' . $row['sub_topic_id'] . '_' . $row['topic_id']; ?>" checked="checked" /></div>
					<?php } ?>	
					<?php if ($row['graphic_type'] == 'I') { ?>
						<div class="videosmall"><a href="discussion.php?<?php echo PARAM_TOPICID . "=" . $row['topic_id'] . "&" . PARAM_SUBTOPICID . "=" . $row['sub_topic_id'] . "&" . PARAM_POSTID . "=" . $row['posting_id']; ?>"><img src="<?php echo $imgSource; ?>" alt="" border="0" style="width:132px; height:84px;" /></a></div>
					<?php } else { ?>
						<div class="videosmall"><a href="discussion.php?<?php echo PARAM_TOPICID . "=" . $row['topic_id'] . "&" . PARAM_SUBTOPICID . "=" . $row['sub_topic_id'] . "&" . PARAM_POSTID . "=" . $row['posting_id']; ?>"><img src="<?php echo $vdoSource; ?>" alt="" border="0" style="width:132px; height:84px;" /></a></div>
					<?php } ?>
					<div style="width:540px; float:right;">
						<h2><a href="discussion.php?<?php echo PARAM_TOPICID . "=" . $row['topic_id'] . "&" . PARAM_SUBTOPICID . "=" . $row['sub_topic_id'] . "&" . PARAM_POSTID . "=" . $row['posting_id']; ?>"><?php echo $row['title']; ?></a></h2>
						<div  id="history<?php echo $i; ?>" >
							<?php echo htmlspecialchars_decode($row['post_content']); ?>
						</div>
						<div class="morebtn">
							<a href="javascript: void(0);" id="more<?php echo $i; ?>"><img src="" alt="" border="0" /></a>
							<?php
							if (!$session_obj->checkSession()) {
								if ($_SESSION['login']['user_id'] == $row['user_id']) {
									?>
									<a href="update_post.php?<?php echo PARAM_TOPICID . "=" . $row['topic_id'] . "&" . PARAM_SUBTOPICID . "=" . $row['sub_topic_id'] . "&" . PARAM_POSTID . "=" . $row['posting_id'] . "&" . PARAM_CURRENT_PAGE . "=" . $val; ?>" id="edit<?php echo $i; ?>"><img src="" alt="" border="0" /></a>
									<a href="javascript: removePosting('<?php print $row['posting_id']; ?>',<?php print $rs = ($row['counts'] > 0) ? 1 : 0; ?>, false);" id="del<?php echo $i; ?>"><img src="" alt="" border="0" /></a>
										<?php
									}
								}
								?>
						</div>
						<h4><?php echo $row['counts']; ?> Comments</h4>
					</div>
				</li>
				<?php
				$i++;
			}
			?>
		</ul>
	</div>
	<?php
} else {
	if ($page_info['basename'] == "markedlist.php") {
		echo "<div class='post-msg'>" . MARKED_POSTINGS_NOT_FOUND . "</div>";
	} else {
		echo "<div class='post-msg'>" . POSTINGS_NOT_FOUND . "</div>";
	}
}
?>