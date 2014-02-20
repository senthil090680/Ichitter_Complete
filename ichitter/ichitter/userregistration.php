<?php require_once 'common/header.php';?>
<script type="text/javascript">
<!--
$(document).ready(function(){
	$('.email').blur(function(){		
		exist_email_validation($(this));
	});
});

function validation(){
	$('.error').remove();
	var error = 0;
	$('#registration_frm input').each(function(i){
		if($(this).hasClass('required') && !$.trim($(this).val()) ){
			$(this).after('<span class="error">This field is important</span>');
			error += 1; 
		}else if($(this).hasClass('email') && !IsEmail($(this).val())){
			$(this).after('<span class="error">Invalid Email id</span>');
			error += 1;
		}
	});
	
	//if($(this).hasClass('password') && !IsEmail($(this).val())){
		if($('[name=password]').val() != $('[name=confirmpassword]').val()){
			$('[name=confirmpassword]').after('<span class="error">Invalid Password</span>');
			error += 1;
		}
	//}
	
	if(!error && exist_email_validation($('[name=email]'))){
		return true;
	}else{
		return false;
	}		


}

function exist_email_validation(whr){
		
		var val = $.trim(whr.val());
		var error = false;
		whr.next().remove();
		if(val && IsEmail(val)){
			$.ajax({
				url:'userregistration_process.php',
				dataType:'json',
				data:{'email':whr.val(),'email_validation':'true'},
				success:function(data){
					
					if(data.total == 0){
						error = true;
						whr.after('<span class="success">User Name is Available!</span>');
					}else{
						whr.after('<span class="error">User Name already exist!</span>');
					}
				},
				/*error:function(){
					alert('error');
				}*/
			});
		}else{
			whr.after('<span class="error">Invalid Email id</span>');
		}
		
		if(error){
			return true;
		}else{
			return false;
		}
}

 


//-->
</script>
<div id="main">
<div id="maincontent">
<?php echo isset($_REQUEST['success']) ? '<span class="success"><b>Your account successfully created!</b></span>' : ''; ?>
 <form action="userregistration_process.php" method="post" id="registration_frm" onsubmit="return validation()">
 	<ul style="width: 300px;">
 		<li><span class="important">*</span>First Name</li>
 		<li><input type="text" value="" name="firstname" class="required" /> </li>
 		<li><span class="important">*</span>Last Name</li>
 		<li><input type="text" value="" name="lastname" class="required" /> </li>
 		<li><span class="important">*</span>Date of Birth</li>
 		<li><input type="text" value="" name="dob" class="required" /> </li>
 		<li><span class="important">*</span>Email</li>
 		<li><input type="text" value="" name="email" class="required email" /> </li>
		<li><span class="important">*</span>Password</li>
 		<li><input type="password" value="" name="password" class="required password" /> </li>
		<li><span class="important">*</span>Confirm Password</li>
 		<li><input type="password" value="" name="confirmpassword" class="required password" /> </li>
 		<li style="width: 100%;text-align: center;"><input type="submit" id="reg_submit_btn" value="Submit" name="submit" /> </li>
 	</ul>
 </form>
</div>
<div id="mainright">
<div class="freetrial"><img src="resource/images/free-trial.jpg" align="free trial" /></div>
<div class="coke"><img src="resource/images/coke.jpg" align="free trial" /></div>
</div>

</div>
<?php require_once 'common/footer.php';?>
