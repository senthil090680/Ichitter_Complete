<?php	
	require_once('lib/include_files.php');
if(trim($_SESSION['login']['user_id']) != ''){
	echo "<script>window.location = 'editprofile.php'</script>";	
}

	$REQ_SEND[PARAM_ACTION] = "get_form_dropdown";
	
	$init_process_obj = new INIT_PROCESS(REGISTRATION_SERVICE,$REQ_SEND);
	$dropdown = (array)$ObjJSON->decode($init_process_obj->response);
	
     extract($dropdown);
	
	
	include_once 'common/header.php';
?>
<script type="text/javascript">
<!--
var email_count;

$(document).ready(function(){
	$('.email').blur(function(){
	var whr = $('#signup').prev();
	
		if($.trim($(this).val()) && !IsEmail($(this).val())){
			write_error_msg(whr,'Invalid Email Id','before');
		}else if($.trim($(this).val())){
			var obj = exist_email_validation($('.email'));			
			var json = $.parseJSON(obj);
			email_count = json.total;
			elem_remove();
			if(email_count > 0){
				write_error_msg(whr,'Your Email id is already exists..','before');
			}
		}
	});

	$('#signup').click(function(){
		//alert(validation());
		if(validation()){
			$('#registration_frm').submit();
		}
	});


	$('.forgot_email').blur(function(){

			var whr = $('#forgot_btn').prev();
			if($.trim($(this).val()) && !IsEmail($(this).val())){
				write_error_msg(whr,'Invalid Email id');
			}else{
				var obj = exist_email_validation($('.forgot_email'));

				var json = $.parseJSON(obj);

				email_count = json.total;
			}
		});

		$('#forgot_btn').click(function(){
			var whr = $('#forgot_btn').prev();
			if($.trim($('.forgot_email').val())){
				if(email_count == 0){
					write_error_msg(whr,'Invalid Email id');
					return false;
				}else{
					$('#forgotpass_frm').submit();
					return true;
				}
			}else{
				write_error_msg(whr,'Please enter Email');
				//whr.find('a').parent().append('<div style="text-align:left;float:left;margin-top:5px" class="error">Invalid Email id</div>');
				return false;
			}
		});


});

function validation(){
	var whr = $('#signup').prev();
	elem_remove();
	var error = 0;
	var email = 0;
	$('#registration_frm input,#registration_frm select').each(function(i){
		/*if($(this).hasClass('required') && !$.trim($(this).val()) ){
			var txt = $(this).parent().prev().text();
			write_error_msg(whr,'Please enter '+txt,'before');
			error += 1;
			return false;
		}else if($(this)[0].tagName == "SELECT"){
			var v = $.trim($(this).val());
			if($(this).hasClass('required') &&  v == '*'){
				var txt = $(this).parent().prev().text();
				write_error_msg(whr,'Please enter '+txt,'before');
				error += 1;
				return false;
			}
		}else if($(this).hasClass('email') && !IsEmail($(this).val())){
			var txt = $(this).parent().prev().text();
			write_error_msg(whr,'Invalid Email Id','before');
			error += 1;
			return false;
		}*/
		
		if($(this).hasClass('required') && !$.trim($(this).val()) ){
			var txt = $(this).parent().prev().text();
			write_error_msg(whr,'Please enter '+txt,'before');
			error += 1;
			return false;
		}else if($(this)[0].tagName == "SELECT"){
			var v = $.trim($(this).val());
			if($(this).hasClass('required') &&  v == '*'){
				var txt = $(this).parent().prev().text();
				write_error_msg(whr,'Please enter '+txt,'before');
				error += 1;
				return false;
			}
		}else if($(this).hasClass('email') && !IsEmail($(this).val())){
			var txt = $(this).parent().prev().text();
			write_error_msg(whr,'Invalid Email Id','before');
			error += 1;
			return false;
		}

	});

	var pass = $.trim($('.password').val());
	var cpass = $.trim($('.confirmpassword').val());
	if(pass != '' && cpass != '' && pass != cpass){
		write_error_msg(whr,'Password and Confirm Password must be the same','before');
		error += 1;
	}

	if(email_count > 0){
		write_error_msg(whr,'Your Email id is already exists..','before');
		return false;
	}else if(error > 0){
		return false;
	}else{
		return true;
	}
}

//-->
</script>

	<div class="wel-title"><img src="resource/images/welcome-title.png" /></div>

			<div id="wel-middlebg">
				<div class="left-content">
					<img src="resource/images/wel-headtext.png" />
					<p>As a member of the iChitter community your arguments, cases you make and facts that you present will change how other people view things. You will be able to evaluate pools of information related to various subjects, allowing you to obtain an unprecedented comprehension and complex view of complex topics that move the world around.<br /><br />You can also publish your analysis of the topics of your interest and see what others have to say to you. The possibilities are endless so, please, log in and have your say!</p>
					<?php echo (isset($_REQUEST['success']) && $_REQUEST['success'] == 'true') ? '<div class="youaccount"><h4>You have Registered Successfully, Thank you!</h4><p>The Registration information is already being sent to your email. Follow your email to access iChitter member portal .Thank you</p></div>' : ''; ?>
					<?php echo (isset($_REQUEST['success']) && $_REQUEST['success'] == 'forgot_success') ? '<div class="youaccount"><p>Your Forgot Password request is succeeded. Please check and follow your email to reset your password.</p></div>' : ''; ?>
					<?php echo (isset($_REQUEST['login_confirm']) && $_REQUEST['login_confirm'] == 'true') ? '<div class="youaccount"><p>Your account is Activated successfully. You can log in to iChitter portal by providing your Email and Password. Thank you!</p></div>' : ''; ?>
					<?php echo (isset($_REQUEST['success']) && $_REQUEST['success'] == 'PASS_RE_SET') ? '<div class="youaccount"><p>Your password has been reset successfully. Thank you</p></div>' : ''; ?>
		
				</div>

				<div class="left-form">
					<div id="regd-form">
						<img class="form-head" src="resource/images/registering-text.png" />
						<div class="clear"></div>
						<div class="mantatory" id="reg_required" >All Fields are required</div>
						<div class="clear"></div>
						<form action="userregistration_process.php" method="post" id="registration_frm" onsubmit="return validation()">

						<label>First Name</label><div class="reg-bg"><input type="text" value="" name="firstname" class="required" size="26" /> </div>
						<label>Last Name</label><div class="reg-bg"><input type="text" value="" name="lastname" class="required" size="26" /></div>
						<label>Gender</label>
						<div class="reg-bg">
							<select class="required" name="gender">
								<option value="*">Select</option>
								<?php foreach($gender as $v){ ?>
			<option <?php echo ($user_data['gender'] == $v->gender_abbreviation) ? 'selected' : '' ?> value="<?php echo $v->gender_abbreviation ?>"><?php echo $v->gender_name; ?></option>		
								<?php } ?>
							</select>
						</div>
						<label>Your Email</label><div class="reg-bg"><input type="text" value="" name="email" class="required email" /></div>
						<label>Password</label><div class="reg-bg"><input type="password" value="" name="password" class="required password" size="26" /></div>
						<label>Confirm Password</label><div class="reg-bg"><input type="password" value="" name="cpassword" class="required confirmpassword" size="26" /></div>
						<label style="clear:both">State</label>
						<div class="reg-bg">


<select style="width:190px;margin:3px 0 0 2px;" class="sec-box required" name="state">
						<option value="*">Select</option>
						<?php foreach($states as $v){ ?>
							
							<option value="<?php echo $v->state_abbreviation; ?>" ><?php echo $v->state_name; ?></option>
							<?php } ?>
						</select>
</div>
						<!--<div class="msg" style="width:290px;height:10px;float:right"></div>-->
						<!--<div><a href="#" class="sign-btn"><span></span></a></div>-->
						<!--<input type="image" class="sign-btn" value="" name="submit" />	-->
						<div class="msgpass"></div>
						<div id="signup" class="input reg_btn" style="margin-left:180px;">
							<a><span>Sign Up</span></a>
						</div>
						<input type="hidden" name="action" value="user_register" />
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	<div id="backgroundPopup"></div>

</body>
</html>
