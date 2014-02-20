<div id="header">
<div class="logo"><a href="index.php"><img src="resource/images/logo.png" alt="" border="0" /></a></div>
<div class="headertop" >
<?php if($session_obj->checkSession() === true) { ?>
<div style="height:29px; display: none;">
<?php } ?>	
<div class="headertopmenu" style="height:29px;">
<div id="smoothmenu1" class="ddsmoothmenu">
	<ul class="flt">
		<li style="border-right:none;" class="menu-left"></li>

		<li><a href="javascript:void(0);"><span>Manage Topics</span></a>
		  <ul>
			<li><a href="addtopics.php"><span>Add Topic</span></a></li>
				<li><a href="order_topics.php"><span>Order Topics</span></a></li>
				<li><a href="addsubtopics.php"><span>Add Sub Topic</span></a></li>
				<li><a href="order_subtopics.php"><span>Order Sub Topics</span></a></li>
		  </ul>
		</li>
		<li><a href="javascript:void(0);"><span>Manage Post</span></a>
		  <ul>
			 <li><a href="viewpostings.php?userid=<?php echo $_SESSION['login']['user_id']; ?>"><span>My Postings</span></a></li>
			<li><a href="add_newpost.php"><span>Add Post</span></a></li>
			 </ul>
		</li>

	</ul>
</div>


</div>
<?php if($session_obj->checkSession() === true) { ?>
</div>
<?php } ?>
</div>

<div class="headertop2">
<div class="homerightpanel">
<!--<div class="homebtn"><a href="index.php"></a></div>-->
<?php 
$lgd = "notlgdhome";
if($session_obj->checkSession() === true) {
	$lgd = "lgdhome";
?>
<div class="container">
	<!-- Login Starts Here -->
	<div class="loginContainer" >
        <a href="#" class="loginButton"><div></div></a>
        <div style="clear:both"></div>
        <div class="loginBox">                
            <form class="loginForm" id="logfrm" name="logfrm" method="post" >
				<div id="loginmsg" style="height:25px;background: #FFFFFF;"></div>
                <fieldset class="body">
                    <fieldset>
                        <label for="username">Email</label>
                        <input type="text" id="username" name="username" class="email" />
                    </fieldset>
                    <fieldset>
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="password" />
                    </fieldset>
                    <input type="hidden" name="login" value="1" />
					<input type="hidden" name="curpage" id="curpage" value="<?php echo $page_info['basename'];?>" />
					<input type="hidden" name="params" id="params" value="<?php echo $_SERVER[QUERY_STRING];?>" />
					<input type="submit" class="login" value="Sign in" />
                    <!-- <label for="checkboxlogin"><input type="checkbox" class="checkboxlogin" />Remember me</label> -->
                </fieldset>
                <span>
					<a href="javascript: void(0);" class="forgotloginButton">Forgot your password?</a>
				</span>
			</form>
        </div>
    </div>
	
	<!-- Login Ends Here -->
<div class="forgotcontainer">
	<!-- Login Starts Here -->
	<div class="forgotloginContainer">
<!--		<a href="#" class="forgotloginButton"><span>Forgot Password</span></a>-->
			
		<div style="clear:both"></div>
		<div class="forgotloginBox">                
			<form class="forgotloginFormarea" id="forgotlogfrmtxt" name="forgotlogfrmtxt" method="post" action="login_process.php">
				<fieldset class="forgotbody">
					<fieldset>
						<label for="forgotusername">Email Address</label>
						<input type="text" id="forgotusername" name="email" class="email required forgot_email" />
					</fieldset>
					<input type="hidden" name="forgot_password" value="1" />
					<div class="msg" style="height:10px; color:#ff0000;"></div>
					<div id="forgot_btn" class="sendbtn reg_btn"><a><img src="resource/images/send.png" alt="" border="0" /></a></div>
				</fieldset>
			</form>
		</div>
	</div>
            <!-- Login Ends Here -->
</div>

</div>
<div class="whyreg"><a href="#"></a></div>
<?php 
} else {
	$lgd = "notlgdhome";
?>
<div class="logoutbtn"><a href="logout.php"></a></div>

<?php
} 
?>

</div>

</div>
<?php if($page_info['basename'] != "index.php" ){ /* ?>
<div class="<?php echo $lgd; ?>"><a href="index.php"><img src="resource/images/homebtn_new.png" alt="" border="" /></a></div>
<?php */ } ?>
</div>
