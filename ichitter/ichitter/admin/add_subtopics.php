<?php
require_once 'includes/includes.inc';

$message = urldecode($_REQUEST['msg']);

include("includes/header_includes.php");
?>
	<body>
		<form name="frmaddtopics" action="subtopicsupdate.php?action=addsubtopics" method="post" onsubmit="return ValidateAddSubTopicsFields()" enctype="multipart/form-data">
			<div id="container">
				<div id="wrapper">
					<?php include("includes/header.php"); ?>
					<div class="middle-section">
						<div class="width">
							<span class="curve-top-left"></span>
							<span class="curve-top-mid"></span>
							<span class="curve-top-right"></span>
						</div>
						<div class="curve-mid">
							<h1>Add - Sub Topic </h1>
							<div class="form">
								<ul class="form-area">
									<li class="form-name">&nbsp;</li>
									<li class="form-mid">&nbsp;</li>
									<li class="form-field">
										<?php
										if (isset($message)) {
											if (($$message == $addsubtopics_success) || ($$message == $updatesubtopics_success) || ($$message == $deletesubtopics_success)) {
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
										<select id="TopicTitle" name="TopicTitle" class="txt-field">
											<option value="0">--Select--</option>
											<?php
											$topics = new topics;
											$result = $topics->get_allthetopics();
											while ($row = mysql_fetch_row($result)) {
												echo "<option value='" . $row[0] . "'>" . $row[1] . "</option>";
											}
											?>
										</select>
									</li>
								</ul>
								<ul class="form-area">
									<li class="form-name">Sub Topic Title *</li>
									<li class="form-mid">:</li>
									<li class="form-field"><input type="text" name="subtopicTitle" id="subtopicTitle"  class="txt-field"/></li>
								</ul>
								<ul class="form-area">
									<li class="form-name">Sub Topic Description</li>
									<li class="form-mid">:</li>
									<li class="form-field"><textarea name="subtopicDesc" id="subtopicDesc" class="txt-area" rows="10" cols="20"></textarea></li>
								</ul>
								<ul class="form-area">
									<li class="form-name">Sub Topic Image *</li>
									<li class="form-mid">:</li>
									<li class="form-field">
										<input id="fileupload" name="fileupload" type="file" value="" class="txt-field"></input>
										<br/><br/>[The optimum image size is 213px * 75px.]
									</li>

								</ul>
								<ul class="form-area">
									<li class="form-name"></li>
									<li class="form-mid"></li>
									<li class="form-field"></li>
								</ul>
								<ul class="form-area">
									<li class="form-field1"><input type="image" onclick="javascript:void(0)" src="images/but-add.png" /></li>
								</ul>
							</div>
						</div>
						<div class="width">
							<span class="curve-bot-left"></span>
							<span class="curve-bot-mid"></span>
							<span class="curve-bot-right"></span>
						</div>
					</div>
					<div id="footer">
						<div class="footernavi">
							<div class="copyright">© 2011</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</body>
</html>