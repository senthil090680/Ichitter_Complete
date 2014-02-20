<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>User Login</title>
	<link rel="stylesheet" href="admin/css/general.css" type="text/css" media="screen" />
	<script src="admin/js/jquery-1.3.2.min.js" type="text/javascript"></script>
	<script src="admin/js/popup.js" type="text/javascript"></script>
	<link href="admin/css/style.css" rel="stylesheet" type="text/css" />
	<!--[if IE 7]>
	<link rel="stylesheet" type="text/css" href="admin/css/style-ie7.css" />
	<![endif]-->
	<!--[if IE 9]>
	<link href="admin/css/styles-ie9.css" rel="stylesheet" type="text/css" />
	<![EndIf]-->
</head>
<body>
	<center>
		<div id="button"><input type="button" value="login" /></div>
	</center>
	<div  id="popupContact" class="loginbg" style="margin: 0px 0px 0px -25px;">
		<a id="popupContactClose">X</a>
		<!--<h1>LOGIN </h1>-->
		<div class="loginbg" style="margin: 0px;"> 
			<div class="loginmsg">
			<?php
				if(isset($message) && $message != '') {
					echo $message;
				}
			?>
			</div>
			<div class="titlogin">LOGIN</div>
			<div class="formbox">
				<div class="formbox1"> User Name :</div>
				<div class="formbox2"><input type="text" id="username" name="username"/></div>
			</div>
			<div class="formboxbot">
				<div class="formbox1"> Password :</div>
				<div class="formbox2"><input type="password" id="password" name="password" /></div>
			</div>
			<div class="formboxbt">
				<input type="submit" class="formboxbt1" value="" />
			</div>
		</div>
	</div>
	<div id="backgroundPopup"></div>
</body>
</html>