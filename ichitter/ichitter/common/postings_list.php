<div id="disc-container">
	<div class="select-box">
		<form method="post" name="fsort" id="fsort">
		<label>Sort By</label>
		<select style="border:1px solid #278db8;" name="lbsort" id="lbsort" onchange="javascript: document.fsort.submit();">
			<option value="0" <?php echo ($sort==0)?"selected=selected":"";?> >-- Select --</option>
			<option value="1" <?php echo ($sort==1)?"selected=selected":"";?>>Article</option>
			<option value="2" <?php echo ($sort==2)?"selected=selected":"";?>>User</option>
			<option value="3" <?php echo ($sort==3)?"selected=selected":"";?>>Most responded to</option>
			<option value="4" <?php echo ($sort==4)?"selected=selected":"";?>>Most recent</option>
			<option value="5" <?php echo ($sort==5)?"selected=selected":"";?>>My responses</option>
			<option value="6" <?php echo ($sort==6)?"selected=selected":"";?>>New responses</option>
			<option value="7" <?php echo ($sort==7)?"selected=selected":"";?>>I was responded to</option>
		</select>	
		</form>
	</div>
	<?php
	$topic = "";
	$subtopic = "";
	$mine = "<span>Mine</span>";
	$other = "<span>Others</span>";
	$new = "<span>New</span>";
	$i = 1;
	$bg = "";
	$topic_bool = false;
	$posturl = "";
	if(count($posts) > 0) {
	foreach($posts as $idx => $post) {
		$bg = ($bg == "discontent")? "discontent2" : "discontent";
		$posturl = "../fp/discussion.php?" . PARAM_TOPICID . "=" . $post['topic_id'] . "&" . PARAM_SUBTOPICID . "=" . $post['sub_topic_id'] . "&" . PARAM_POSTID . "=" . $post['posting_id'];
		if($idx != '0') {
			$mine = "&nbsp;";
			$other = "&nbsp;";
			$new = "&nbsp;";
		}
		$topic_bool = ($topic != $post['topic'])? true : false; 
		if($topic_bool) {
			$topic = $post['topic'];
	?>
	<div class="discussion-cont">
		<div class="dischdtitle">
			<p><?php echo $topic; ?></p>
			<div class="mine-btn"><?php echo $mine; ?>
				<div class="other-btn"><?php echo $other; ?>
					<div class="new-btn"><?php echo $new; ?></div>
				</div>
			</div>
		</div>
		<?php 
		}
		if($subtopic != $post['subtopic']) {
			$subtopic = $post['subtopic'];
		?>
		<div class="dischdsubtitle"><?php echo $subtopic; ?></div>
		<?php
		}
		?>
		<div class="<?php echo $bg; ?> trigger">
			<div class="discontentleft">
				<div class="morebtn">
					<a href="javascript: void(0);" id="more<?php echo $i; ?>">
						<img src="resource/images/bot-arrow.png" alt="" />
						<?php echo $post['posted_date']; ?>
					</a>
				</div>
				<div  id="history<?php echo $i; ?>" class="history" >
					<p><?php echo $post['post_content']; ?></p>
					<p>&nbsp;</p>
				</div>
			</div>
			<div class="discontentright">
				<div class="tem"><a href="<?php print $posturl; ?>"  target='_blank'><?php echo $post['mine']; ?></a></div>
				<div class="tem2"><a href="<?php print $posturl; ?>"  target='_blank'><?php echo $post['others']; ?></a></div>
				<div class="tem"><a href="<?php print $posturl; ?>"  target='_blank'><?php echo $post['newpost']; ?></a></div>
			</div> 
		</div>
		<?php
		if($topic_bool) {
		?>
	</div>
		<?php
		}
		$i++;
	}
	}
	else {
		echo "<div style='text-align: center; font-size: 12px; color: red;'>Postings are not found.</div> <br/>";
	}
	?>
</div>