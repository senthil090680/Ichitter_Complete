<?php
session_start();
error_reporting(0);
include("includes/session_check.php");
include("includes/messages.php");
$message    =    urldecode($_REQUEST['msg']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>FrontedPage - Admin</title>
	<link href="admin/css/style.css" rel="stylesheet" type="text/css" />
	<script language="JavaScript" src="admin/js/jquery.js"></script>
	<link rel="stylesheet" type="text/css" href="admin/css/ddsmoothmenu.css" />
	<script language="JavaScript" src="admin/js/ddsmoothmenu.js"></script>
	<script language="JavaScript" src="admin/js/validations.js"></script>
	<script type="text/javascript">
	ddsmoothmenu.init({
	    mainmenuid: "smoothmenu1", //menu DIV id
	    orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	    classname: 'ddsmoothmenu', //class added to menu's outer DIV
	    contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
	})
	</script>
</head>

<body>
<form name="frmaddtopics" action="topicsupdate.php?action=addtopics" method="post" onsubmit="return ValidateAddTopicsFields()" enctype="multipart/form-data">
<div id="container">
	<div id="wrapper">
		<?php include("admin/header.php"); ?>

		<div class="middle-section">
			<div class="width">
				<span class="curve-top-left"></span>
				<span class="curve-top-mid"></span>
				<span class="curve-top-right"></span>
			</div>
			<div class="curve-mid">
				<h1>Add - Topic </h1>
				<div class="form">
					<ul class="form-area">
						<li class="form-name">&nbsp;</li>
						<li class="form-mid">&nbsp;</li>
						<li class="form-field" >
						<?php
							if(isset($message)) {
								if(($$message == $addtopics_success) || ($$message == $deletetopics_success) || ($$message == $updatetopics_success)) {
									echo  "<span style='font-size: 12px;color: green;'>" . $$message . "</span>";
								}
								else {
									echo  "<span style='font-size: 12px;color: red;'>" . $$message . "</span>";
								}
							}
						?>
						</li>
					</ul>
					<ul class="form-area">
						<li class="form-name">Topic Title *</li>
						<li class="form-mid">:</li>
						<li class="form-field"><input type="text" name="topicTitle" id="topicTitle" class="txt-field"/></li>
					</ul>
					<ul class="form-area">
						<li class="form-name">Topic Description</li>
						<li class="form-mid">:</li>
						<li class="form-field"><textarea name="topicDesc" id="topicDesc" class="txt-area" rows="10" cols="20"></textarea></li>
					</ul>
					<ul class="form-area">
						<li class="form-name">Topic Image *</li>
						<li class="form-mid">:</li>
						<li class="form-field"><input id="fileupload" name="fileupload" type="file" value="" class="txt-field"></input>
						<br/><br/>[The optimum image size is 213px * 75px.]</li>
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
