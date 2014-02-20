<div class="discusswrap">
    <span style="float:left; height:25px;"><h2>DISCUSSION AREA</h2></span>
    <span style="float:right; margin-right:14px;height:25px; ">
		<p>Show: 
			<select>
				<option>Newest First</option>
			</select>
		</p>
    </span>
	
    <div class="line"></div>
	<?php
	if(count($discussions) > 0) {
		foreach ($discussions as $key => $discussion) {
			$dtime = strtotime($discussion['posted_on']);
			$post_date = date("F j, Y", $dtime) . " at " . date("g:i a", $dtime);
			echo '<div class="lines"></div>';
			echo '<h2 class="trigger"><a href="#">' . $discussion['first_Name'] . $discussion['last_Name'] . ', </a><span> ' . $post_date . '</span>';
			echo '<div class="reply"><p class="discuss"><a href="javascript: void(0);">REPLY</a></p></div></h2>';
			echo '<div class="toggle_container" style="border: 0px solid #603314;">
				<div class="block" style="border: 0px solid #326c9d;"><p>' .
					$discussion['discussion_content']
					. '</p><!--Content-->
				</div>
			</div>';
		}
	}
	?>
	
	<?
	/*
    <h2 class="trigger">
		<a href="#">username, </a>
		<span> November 11, 2010 at 4:05 pm</span>
		<div class="reply">
			<p>
				<a href="javascript: void(0);">REPLY</a>
			</p>
		</div>
    </h2>
    <div class="toggle_container" style="border: 1px solid #603314;">
		<div class="block" style="border: 1px solid #326c9d;">
			<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. In posuere felis nec tortor. Pellentesque faucibus. Ut accumsan ultricies elit. </p>
			<!--Content-->
		</div>
    </div>
	<div class="lines"></div>
    <h2 class="trigger">
		<a href="#">username, </a>
		<span> October 28, 2010 at 1:13 pm</span>
    </h2>
    <div class="toggle_container">
		<div class="block">
			<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. In posuere felis nec tortor. Pellentesque faucibus. Ut accumsan ultricies elit. </p>
			<!--Content-->
		</div>
    </div>
	<div class="newcomment">
		<div class="lines"></div>
		<textarea name="txtcommnt" id="txtcommnt" cols="85" rows="10"></textarea>
		<div class="lines"></div>
		<input type="button" name="addcomment" id="addcomment" value="Add Comment" style="float: right; margin: 0px 25px 0px 0px;" />
		<input type="button" name="cancel" id="cancel" value="Cancel" style="float: right; margin: 0px 5px 0px 0px;" />
	</div>
	 * 		*/
	?>
	<div class="commentContainer">
		<div class='lines'></div>
		<textarea name='<? echo PARAM_CONTENT;?>' id='<? echo PARAM_CONTENT;?>' cols='85' rows='10'></textarea>
		<div class='lines'></div>
<!--		<input type='button' name='addcomment' id='addcomment' value='Add Comment' style='float: right; margin: 0px 25px 0px 0px;' />-->
<!--		<input type='button' name='cancel' id='cancel' value='Cancel' style='float: right; margin: 0px 5px 0px 0px;' />-->
	</div>
	<span>
		<div class="addcomment">
			<a href="javascript: void(0);" id="newcomment"></a>
		</div>
    </span>
	<form>
		<input type="hidden" name="<?php echo PARAM_TOPICID; ?>" id="<?php echo PARAM_TOPICID; ?>" value="<?php echo $topicsid; ?>" />
		<input type="hidden" name="<?php echo PARAM_SUBTOPICID; ?>" id="<?php echo PARAM_SUBTOPICID; ?>" value="<?php echo $subtopicid; ?>" />
		<input type="hidden" name="<?php echo PARAM_POSTID; ?>" id="<?php echo PARAM_POSTID; ?>" value="<?php echo $postid; ?>" />
		<input type="hidden" name="<?php echo PARAM_FOR_DISCUSSION; ?>" id="<?php echo PARAM_FOR_DISCUSSION; ?>" value="0" />
	</form>
</div>