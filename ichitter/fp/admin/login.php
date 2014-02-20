<?php
require_once 'includes/includes.inc';

$message = urldecode($_REQUEST['msg']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title><?php echo ADMIN_TITLE; ?></title>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<!--[if IE 7]>
		<link rel="stylesheet" type="text/css" href="css/style-ie7.css" />
		<![endif]-->
		<!--[if IE 9]>
		<link href="css/styles-ie9.css" rel="stylesheet" type="text/css" />
		<![EndIf]--> 
		<script type="text/javascript" src="js/jquery.js"></script>
		<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
		<script type="text/javascript" src="js/ddsmoothmenu.js"></script>
		<script type="text/javascript" src="js/validations.js"></script>
	</head>
	<body>
		<form name="login" id= "login" method="post" onsubmit="return CheckFields()">
			<div id="container">
				<div id="wrapper">
					<div id="header">
						<span class="logo"><span></span></span>
						<div id="headerRight">
							<div class="headerNav">
								<div class="welcome"></div>
							</div>
						</div>
					</div>
					<div class="middle-section">
						<div class="width">
							<span class="curve-top-left"></span>
							<span class="curve-top-mid"></span>
							<span class="curve-top-right"></span>
						</div>
						<div class="curve-mid-login">
							<h1>LOGIN </h1>
							<div class="width margintop100" align="center">

								<div class="loginbg"> 
									<div class="loginmsg">
										<?php
										if (isset($message) && $message != '') {
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