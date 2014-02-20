<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>iChitter</title>
<link href="resource/css/style.css" rel="stylesheet" type="text/css">
<link href="resource/css/style1.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="resource/css/login-style.css" />
<!--[if IE 7]>
<link rel="stylesheet" type="text/css" href="css/style-ie7.css">
<![endif]-->
<script type="text/javascript" src="resource/js/jquery-1.6.1.min.js"></script>
<script type="text/javascript" src="resource/js/common.js"></script>

<script src="resource/js/login.js"></script>
<script>
	$(document).ready(function(){	
		<?php if(isset($_REQUEST['failure'])){?>
		var whr = $('.container');		
		whr.before('<div style="text-align:left;float:left;margin-top:5px;width:190px;" class="error">Invalid User Name and Password </div>');
		<?php }elseif(isset($_REQUEST['confirm'])){ ?>
		var whr = $('.container');		
		whr.before('<div style="text-align:left;float:left;margin-top:5px;width:190px;" class="error">Invalid User Name or Password </div>');
		<?php } ?>
		
		
		
		$('.login-btn').click(function(){			
			login_validation();
		});
		
		$('[name=username],[name=password]').keyup(function(e){
			if(e.which == 13){
				login_validation();
			}
			
		});
	});
	
function login_validation(){
	$('#login .error').remove();
	$('#login .success').remove();
			var error = 0;
			var whr = $('.container');
			
			var usrname = $.trim($('[name=username]').val());
			var pass = $.trim($('[name=password]').val());
			if(usrname == '' || usrname == 'User Email'){
				whr.before('<div style="text-align:left;float:left;margin-top:5px" class="error">Please enter Email</div>');
				return false;
			}else if(!IsEmail(usrname)){
				whr.before('<div style="text-align:left;float:left;margin-top:5px" class="error">Invalid Email id</div>');
				return false;
			}
			
			if(pass == 'Password'){
				whr.before('<div style="text-align:left;float:left;margin-top:5px" class="error">Please enter Password</div>');
				return false;
			}
			
			if(error > 0)	{
				return false;
			}else{
				$('#login_frm').submit();
			}
}
</script>
</head>

<body>
<div id="container">
	<div id="wel-wrapper">
		<div id="login">
			<form name="login" method="post" id="login_frm" action="userregistration_process.php">
			<ul class="login-box">
				<li><input class="loginInput required" name="username" type="text" onclick="onclick_clear_data(this,'User Email')" onblur="on_blur_check_value(this,'User Email')" value="User Email" size="18" /></li>
				<li><input class="loginInput required" name="password" type="password" onclick="this.value = ''" onclick="onclick_clear_data(this,'Password')" onblur="on_blur_check_value(this,'Password')" value="Password" size="18" /></li>
			</ul>
			<div class="login-btn"></div>
			<input type="hidden" name="action" value="login" />	
			</form>
			
		<!--	<div id="button">			
				<a class="login-text" style="cursor:pointer;text-decoration:underline">Forgot Password</a>				
			</div>-->
			
			<div class="clear"></div>
			<div class="container">
			<!-- Login Starts Here -->
			<div class="loginContainer">
				<a href="#" class="loginButton">
					<!--<img src="resource/images/forgetpass.png" />-->
<span>Forgot Password?</span>
				</a>
					
				<div style="clear:both"></div>
				<div class="loginBox">                
					<!--<form class="loginForm" id="forgotpass_frm" name="logfrm" method="post">-->
					<form action="userregistration_process.php" method="post" id="forgotpass_frm" class="loginForm" name="forgotpass_frm" >
						<fieldset class="body">
							<fieldset>
								<label for="username">Your Email</label>
								<input type="text" value="" name="email" class="required forgot_email" />
							</fieldset>
							<input type="hidden" name="action" value="forgot_password" />
							<div class="msg" style="height:10px;margin-right:6px;"></div>	
							<div id="forgot_btn" class="input reg_btn" style="margin-left:110px;">
								<a><span>Send</span></a>
							</div>
							
						</fieldset>
						
					</form>
				</div>
			</div>
					<!-- Login Ends Here -->
					<div class="clear"></div>
		</div>
			
			<!--<div><a class="login-text" href="forgotpassword.php">Forgot Password</a></div>-->
			<div class="clear"></div>
		</div>
	
	<div id="center-box">