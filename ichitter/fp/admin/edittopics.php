<?php
require_once 'includes/includes.inc';
$message = urldecode($_REQUEST['msg']);

if (isset($_GET['editaction']) == "edit") {
	$topicsid = $_GET['id'];
	$topics = new topics;
	$result = $topics->get_topicsById($topicsid);
	while ($row = mysql_fetch_row($result)) {
		$title = $row[1];
		$description = $row[2];
		$image = $row[3];
		$isActive = $row[4];
		$priority = $row[5];
	}
}

include("includes/header_includes.php");
?>
	<body>
		<form name="frmaddtopics" action="topicsupdate.php?action=edittopics" onsubmit="return ValidateEditTopicsFields()" method="post" enctype="multipart/form-data">
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
							<h1>Update - Topic </h1>
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
									<li class="form-field"><input type="text" name="topicTitle" id="topicTitle" class="txt-field" value="<?php echo $title; ?>"/></li>
								</ul>
								<ul class="form-area">
									<li class="form-name">Topic Description</li>
									<li class="form-mid">:</li>
									<li class="form-field"><textarea name="topicDesc" id="topicDesc" class="txt-area" rows="10" cols="20"><?php echo $description; ?></textarea></li>
								</ul>
								<ul class="form-area">
									<li class="form-name">Topic Image</li>
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
										<input id="hidtopicsid" name="hidtopicsid" type="hidden" value="<?php echo $topicsid; ?>" />
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