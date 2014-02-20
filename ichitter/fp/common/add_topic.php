<div class="frm-topics">
	<form name="frmaddtopics" action="topic_process.php" method="post" onsubmit="return ValidateAddTopicsFields()" enctype="multipart/form-data">
		<a class="btn-close"><img src="resource/images/close-new.png" alt="" /></a>
		<div class="frm-title">Add Topic </div>
		<div class="frm-box">
			<div class="form">
				<ul class="form-area">
					<li class="form-name">&nbsp;</li>
					<li class="form-mid">&nbsp;</li>
					<li class="form-msg" >
						<?php
						if (isset($message)) {
							if (($$message == $addtopics_success) || ($$message == $deletetopics_success) || ($$message == $updatetopics_success)) {
								echo "<span style='font-size: 12px;color: green;'>" . $$message . "</span>";
							} else {
								echo "<span style='font-size: 12px;color: red;'>" . $$message . "</span>";
							}
						}
						?>
					</li>
				</ul>
				<ul class="form-area">
					<li class="form-name">Topic Title *</li>
					<li class="form-mid">:</li>
					<li class="form-field"><input type="text" name="<?php echo PARAM_TOPIC_TITLE; ?>" id="<?php echo PARAM_TOPIC_TITLE; ?>" class="txt-field"/></li>
				</ul>
				<ul class="form-area">
					<li class="form-name">Topic Description</li>
					<li class="form-mid">:</li>
					<li class="form-field"><textarea name="<?php echo PARAM_TOPIC_DESCRIPTION; ?>" id="<?php echo PARAM_TOPIC_DESCRIPTION; ?>" class="txt-area" rows="10" cols="20"></textarea></li>
				</ul>
				<ul class="form-area">
					<li class="form-name">Topic Image *</li>
					<li class="form-mid">:</li>
					<li class="form-field">
						<input id="<?php echo PARAM_FILE_UPLOAD; ?>" name="<?php echo PARAM_FILE_UPLOAD; ?>" type="file" class="txt-field" size="52" />
						<br/><span style="float: left; width: 300px;">[The optimum image size is 213px * 75px.]</span>
					</li>

				</ul>
				<ul class="form-area">
					<li class="form-field1">
						<input type="image" name="add-topic" onclick="javascript:void(0)" src="resource/images/add-topic.png" />
						<input type="hidden" id="<?php echo PARAM_ACTION; ?>" name="<?php echo PARAM_ACTION; ?>" value="addnewtopic" />
						<input type="hidden" id="<?php echo PARAM_USERID; ?>" name="<?php echo PARAM_USERID; ?>" value="<?php $_SESSION['login']['user_id']; ?>" />
						<input type="hidden" id="<?php echo PARAM_TOPICID; ?>" name="<?php echo PARAM_TOPICID; ?>" value="<?php echo $topicsid; ?>" />
						<input type="hidden" id="pgurl" name="pgurl" value="<?php echo $_SERVER['QUERY_STRING']; ?>" />
					</li>
				</ul>
			</div>
		</div>
	</form>
</div>
