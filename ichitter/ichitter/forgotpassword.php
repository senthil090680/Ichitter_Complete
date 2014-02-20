<?php 
	require_once('lib/include_files.php');
	if($session_obj->get_Session('login')){
		header('location:editprofile.php');
	}
	include_once 'common/header.php';
?>
<script>
	var email_count = 0;
	
	$(document).ready(function(){
		
		$('.email').blur(function(){			
			var whr = $('#forgot_btn').prev();			
			if($.trim($(this).val()) && !IsEmail($(this).val())){				
				write_error_msg(whr,'Invalid Email id');
				//whr.after('<div class="error">Invalid Email id</div>');
			}else{				
				var obj = exist_email_validation($('.email'));				
				var json = $.parseJSON(obj);
				email_count = json.total;
			}
		});	
		
		$('#forgot_btn').click(function(){
			var whr = $('#forgot_btn').prev();
			if($.trim($('.email').val())){
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
	
	
	
	
</script>

	<div class="wel-title"><h1>Forgot Password</h1></div>
			<div id="wel-middle_smallbg">
				
				<div class="left-form" style="float:none;margin:150px auto">
					<div id="regd-form">						
						<form action="userregistration_process.php" method="post" id="forgotpass_frm" name="forgotpass_frm" >
							<label>Your Email</label>
							<div class="reg-bg">
							<input type="text" value="" name="email" class="required email" />

							</div>
							<input type="hidden" name="forgot_password" value="1" />
							<div class="msg" style="width:250px;height:10px;float:right;margin-right:6px;"><!--fvgb--></div>			
							<div id="forgot_btn" class="input reg_btn" style="margin-left:180px;float:left">
								<a><span>Send</span></a>
							</div>
							
							
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


</body>
</html>
 