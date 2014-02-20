<?php
require_once 'includes/includes.inc';

$message = urldecode($_REQUEST['msg']);

if ($message != "") {
	$username = "";
	$oldpassword = "";
	$newpassword = "";
	$confirmpassword = "";
	if ($message == "Password Changed Successfully") {
		session_destroy();
		header("Location: login.php");
	}
}
include("includes/header_includes.php");

?>
	<body onload="resetBackground()">
		<form name="login" id= "login" method="post" onsubmit="return validateChangePasswordFields();">
			<div id="container">
				<div id="wrapper">
					<?php include("includes/header.php"); ?>
					<div class="middle-section">
						<div class="width">
							<span class="curve-top-left"></span>
							<span class="curve-top-mid"></span>
							<span class="curve-top-right"></span>
						</div>
						<div class="curve-mid-login">
							<h1>CHANGE PASSWORDS </h1>
							<div class="width margintop100" align="center">
								<div class="cpbg"> 
									<div class="cpmsg">
										<?php
										if (isset($message) && $message != '') {
											if ($message == "Password Changed Successfully") {
												echo "<span style='color:green;'>" . $message . "</span>";
											} else {
												echo "<span style='color:red;'>" . $message . "</span>";
											}
										}
										?>
									</div>
									<div class="cpbox">
										<div class="cpbox1"> Old Password *</div>
										<div class="cpbox2"><input type="password" id="oldpassword" name="oldpassword"  value="<?php echo $oldpassword; ?>"/></div>

										<div class="cpbox1"> New Password *</div>
										<div class="cpbox2"><input type="password" id="newpassword" name="newpassword"  value="<?php echo $newpassword; ?>"/></div>

										<div class="cpbox1"> Confirm Password *</div>
										<div class="cpbox2"><input type="password" id="confirmpassword" name="confirmpassword"  value="<?php echo $confirmpassword; ?>"/></div>
									</div>


									<div class="cpboxbt">
										<input type="submit" class="cpboxbt1" value="" />
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