<div class="frm-subtopics">
	<form id="frmaddsubtopics" name="frmaddsubtopics" action="subtopic_process.php" method="post" onsubmit="return ValidateAddSubTopicsFields(); return false;" enctype="multipart/form-data">
		<a class="btn-close"><img src="resource/images/close-new.png" alt="" /></a>
		<div class="frm-title">Add Sub Topic </div>
		<div class="frm-box">
			<div class="form">
			<ul class="form-area">
					<li class="form-name"></li>
					<li class="form-mid">&nbsp;</li>
					<li class="form-field" >
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
					<li class="form-field">
						<span id="selarea">
							<select id="st_topics" name="st_topics" class="txt-field">
								<option value="0">--Select--</option>
								<?php
								if(count($Topicslist) > 0) {
									foreach ($Topicslist as $idx => $rec) {
										$selected = "";
										if ($topicsid == $rec['topics_id']) {
											$selected = " selected=selected";
										}
										 echo "<option value='". $rec['topics_id'] ."' $selected>". $rec['title'] ."</option>";
									}
								}
								?>
							</select>
						</span>
					</li>
				</ul>

				<ul class="form-area">
					<li class="form-name">Sub Topic Title *</li>
					<li class="form-mid">:</li>
					<li class="form-field"><input type="text" name="st_title" id="st_title"  class="txt-field"/></li>
				</ul>
				<ul class="form-area">
					<li class="form-name">Sub Topic Description</li>
					<li class="form-mid">:</li>
					<li class="form-field"><textarea name="st_desc" id="st_desc" class="txt-area" rows="10" cols="20"></textarea></li>
				</ul>
				<ul class="form-area">
					<li class="form-name">Sub Topic Image *</li>
					<li class="form-mid">:</li>
					<li class="form-field">
						<input id="st_fileupload" name="st_fileupload" type="file" value="" class="txt-field" size="52" />
						<br/><span style="float: left; width: 300px;">[The optimum image size is 213px * 75px.]</span>
					</li>
				</ul>
				<ul class="form-area">
					<li class="form-field1">
						<input type="image" onclick="javascript:void(0)" src="resource/images/add-sub-topic.png" />
						<input type="hidden" id="<?php echo PARAM_ACTION; ?>" name="<?php echo PARAM_ACTION; ?>" value="addnewsubtopic" />
						<input type="hidden" id="<?php echo PARAM_USERID; ?>" name="<?php echo PARAM_USERID; ?>" value="<?php $_SESSION['login']['user_id']; ?>" />
						<input type="hidden" id="pgurl" name="pgurl" value="<?php echo $_SERVER['QUERY_STRING']; ?>" />
					</li>
				</ul>
			</div>
		</div>
	</form>
</div>
