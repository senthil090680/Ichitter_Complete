<div class="discusswrap">
    <span style="float:left; height:25px; padding-left: 16px;"><h2>DISCUSSION AREA</h2></span>
    <span style="float:right; height:25px; margin-right:14px;">
		<p>Show: 
			<select name="srtod" id="srtod">
				<option value="0">Newest First</option>
				<option value="1">Oldest First</option>
				<!--			
					<option value="2">Highest Rated</option>
					<option value="3">Most Replied</option>
					<option value="4">I Responded</option>
					<option value="5">I was Responded to</option>
					<option value="6">Unread Responses</option>
				-->
			</select>
		</p>
    </span> 
    <div class="line"></div>
	<?php
	if (count($discussions) > 0) {
		$tree = new DiscussionTree($discussions);
		echo "<!-- TREE --><div class='mainbox'><div class='inbox0'>";
		echo $tree->createTree();
		echo "</div></div><!-- TREE -->";
	} else {
	
		echo "<!-- TREE --><div class='mainbox'><div class='inbox0'>";
		echo "<div style='float: left;font-size: 12px; color:red; width:100%; text-align: center;'>Discussions are not found</div>";
		echo "</div></div><!-- TREE -->";
	}
	?>
	<div class='lines'></div>
	<span style="float:left; height:25px; padding-left: 16px;"><h2>POST DISCUSSION</h2></span>
	<div class="line"></div>
	<div class="commentContainer">
		<div class='lines'></div>
		<textarea style="margin: 0 0 0 15px; resize: none;" cols="86" rows="7" name='<?php echo PARAM_CONTENT; ?>' id='<?php echo PARAM_CONTENT; ?>'></textarea>
		<div class='lines'></div>
	</div>
	<span>
		<div class="addcomment">
			<?php if (!$session_obj->checkSession()) { ?>
				<a href="javascript: void(0);" id="newcomment"></a>
			<?php } else { ?>
				<a href="javascript: checks(this);" id="newcomment1"></a>
			<?php } ?>
		</div>
		<div class="divdisc">You must Login to participate in Discussion</div>
    </span>
	<form>
		<input type="hidden" name="<?php echo PARAM_TOPICID; ?>" id="<?php echo PARAM_TOPICID; ?>" value="<?php echo $topicsid; ?>" />
		<input type="hidden" name="<?php echo PARAM_SUBTOPICID; ?>" id="<?php echo PARAM_SUBTOPICID; ?>" value="<?php echo $subtopicid; ?>" />
		<input type="hidden" name="<?php echo PARAM_POSTID; ?>" id="<?php echo PARAM_POSTID; ?>" value="<?php echo $postid; ?>" />
		<input type="hidden" name="<?php echo PARAM_FOR_DISCUSSION; ?>" id="<?php echo PARAM_FOR_DISCUSSION; ?>" value="0" />
	</form>
</div>