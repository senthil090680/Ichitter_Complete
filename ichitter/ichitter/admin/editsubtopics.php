<?php
require_once 'includes/includes.inc';

$message = urldecode($_REQUEST['msg']);

if (isset($_GET['editaction']) == "edit") {
	$subtopicsid = $_GET['id'];
	$subtopics = new subtopics;
	$result = $subtopics->get_topicsById($subtopicsid);
	while ($row = mysql_fetch_array($result)) {
		$subtopicsid = $row["sub_topic_id"];
		$topic_id = $row["topic_id"];
		$title = $row["title"];
		$description = $row["description"];
		$image = $row["image"];
		$isActive = $row["is_active"];
		$priority = $row["priority"];
	}
}

include("includes/header_includes.php");
?>
<body>
	<form name="frmaddtopics" action="subtopicsupdate.php?action=editsubtopics" onsubmit="return ValidateEditSubTopicsFields()" method="post" enctype="multipart/form-data">
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
						<h1>Update - Sub Topic </h1>
						<div class="form">
							<ul class="form-area">
								<li class="form-name">&nbsp;</li>
								<li class="form-mid">&nbsp;</li>
								<li class="form-field">
									<?php
									if (isset($message)) {
										echo $$message;
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
											$selectedTopicId = "";
											if ($row[0] == $topic_id)
												$selectedTopicId = "selected";
											echo "<option value='" . $row[0] . "'" . $selectedTopicId . ">" . $row[1] . "</option>";
										}
										?>
									</select>
								</li>
							</ul>
							<ul class="form-area">
								<li class="form-name">Sub Topic Title *</li>
								<li class="form-mid">:</li>
								<li class="form-field"><input type="text" name="subtopicTitle" id="subtopicTitle" class="txt-field" value="<?php echo $title; ?>"/></li>
							</ul>
							<ul class="form-area">
								<li class="form-name">Sub Topic Description</li>
								<li class="form-mid">:</li>
								<li class="form-field"><textarea name="subtopicDesc" id="subtopicDesc" class="txt-area" rows="10" cols="20"><?php echo $description; ?></textarea></li>
							</ul>
							<ul class="form-area">
								<li class="form-name">Sub Topic Image</li>
								<li class="form-mid">:</li>
								<li class="form-field">
									<input id="fileupload" name="fileupload" type="file" value="" class="txt-field"></input>
									<br/><br/>[The optimum image size is 213px * 75px.]
								</li>

							</ul>
							<ul class="form-area">
								<li class="form-name">Uploaded Image</li>
								<li class="form-mid">:</li>
								<li class="form-field">
									<?php echo $image; ?>
									<input id="hidimage" name="hidimage" type="hidden" value="<?php echo $image; ?>" />
									<input id="hidsubtopicsid" name="hidsubtopicsid" type="hidden" value="<?php echo $subtopicsid; ?>" />
									<input id="hidtopicsid" name="hidtopicsid" type="hidden" value="<?php echo $topic_id; ?>" />
									<input id="hidtopicspriority" name="hidtopicspriority" type="hidden" value="<?php echo $priority; ?>" />
								</li>
							</ul>
							<ul class="form-area">
								<li class="form-name">&nbsp;</li>
								<li class="form-mid">&nbsp;</li>
								<li class="form-field">
									<img src="<?php echo "../upload_image/" . $image; ?>" alt="" style="height: 75px; width: 213px;" />
								</li>
							</ul>
							<ul class="form-area">
								<li class="form-field1"><input type="image" onclick="javascript:void(0)" src="images/but-update.png" /></li>
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