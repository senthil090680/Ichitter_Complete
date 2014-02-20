<?php
   require_once('lib/include_files.php');
  
  	if(isset($_REQUEST['logout']) && $_REQUEST['logout'] == 'OK'){
		$session_obj->unset_Session('login');		
	}
	
	if(!isset($_REQUEST['email']) && !$session_obj->get_Session('login')){
		header('location:index.php');
	}
  
   if(isset($_REQUEST['email'])){
	    include_once 'common/header.php';
   		$email = $_REQUEST['email'];
   }elseif(isset($_SESSION)){
   		 include_once 'common/header1.php';
		 $session_email = $session_obj->get_Session('email_id');
		
   		//$email = $_SESSION['login']['email_id'];
   }
?>
<script>
	$(document).ready(function(){
		$('#changepass_btn').click(function(){
			change_password();
		});
		$('[name=oldpass],[name=pass],[name=confirm_pass]').keyup(function(e){
			if(e.which == 13){	
				change_password();
			}
		});
		
	});

function change_password(){
	
				elem_remove();
				var oldpass = $.trim($('[name=oldpass]').val());
				var pass = $.trim($('[name=pass]').val());
				var confir_pass = $.trim($('[name=confirm_pass]').val());
				whr = $('#changepass_btn').prev();
				if($('[name=oldpass]').length > 0 && oldpass == ''){
					write_error_msg(whr,'Please enter Old Password');
					return false;
				}else if(pass == ''){
					write_error_msg(whr,'Please enter New Password');
					return false;
				}else if(confir_pass == ''){
					write_error_msg(whr,'Please enter Confirm Password');
					return false;
				}else if(pass != confir_pass){		
					write_error_msg(whr,'Password and Confirm Password must be the same');
					return false;
				}
				$('#changepass_frm').submit();
}
</script>
	
	<div id="center-box">
	<div class="wel-title"><h1>Change Password</h1></div>
			<div id="wel-middle_smallbg">
				
				<div class="left-form" style="float:none;margin:120px auto">
					<div id="regd-form">						
						<form action="userregistration_process.php" method="post" id="changepass_frm" >
							<?php if(isset($session_email)){ ?>
							<label>Old Password</label><div class="reg-bg"><input type="password" value="" name="oldpass" class="required" /></div>
							<?php } ?>
							<label>New Password</label><div class="reg-bg"><input type="password" value="" name="pass" class="required" /></div>
							<div style="clear:both"></div>
							<label>Confirm Password</label><div class="reg-bg"><input type="password" value="" name="confirm_pass" class="required" /><input type="hidden" name="change_password" value="true" /></div>
							<input type="hidden" name="email" value="<?php echo isset($session_email) ? $session_email:$email; ?>" />
							<div class="msg <?php echo (isset($_REQUEST['failure']) && $_REQUEST['failure'] == 'PASS_RE_SET_FAIL') ? 'error' : '' ?>" style="width:290px;height:10px;float:right;margin-right:6px;">
								<?php if(isset($_REQUEST['failure']) && $_REQUEST['failure'] == 'PASS_RE_SET_FAIL'){ echo 'Your password reset was failed!. Try again';} ?>
							</div>							
							<div id="changepass_btn" class="input reg_btn" style="margin-left:150px;">
								<a><span>Change Password</span></a>
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
 