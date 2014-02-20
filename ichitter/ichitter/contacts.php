<?php
	require_once 'lib/include_files.php';
	require_once('lib/profile_photo_include.php');

	if(isset($_REQUEST['logout']) && $_REQUEST['logout'] == 'OK'){
		$session_obj->unset_Session('login');	
		echo "<script>window.location = 'index.php'</script>";
	}
	
	if(trim($_SESSION['login']['user_id']) == ''){
		echo "<script>window.location = 'index.php'</script>";
	}

	
	
	/*echo '<pre />';
	print_r($data);*/
	
	
	
	
	require_once 'common/header1.php';
?>
<script>
	$(document).ready(function(){
		$('.send_msg').click(function(){
			$('#send_msg_box').remove();
			var h = '<div id="send_msg_box"><div id="send_msg_title"><?php echo SEND_MSG_TXT; ?></div><div style="float:right;color:#fff;font-weight:bold;cursor:pointer" onclick="close_msg()">X</div><div class="clear"></div><div class="msgInput_bg"><div style="float: left;margin-top:2px;"><textarea onkeypress="extend_size(this,event)" name="sendInput" class="reply_txt"></textarea></div><div class="send_btn" onclick="send_msg(this,\'send\',\''+$(this).attr('id')+'\')"><img style="" src="resource/images/send_small.png" /></div><div class="clear"></div></div><div class="clear"></div></div>';
			
			$(this).parents('.individual-contact').append(h);
			$('#send_msg_box').slideDown();
		});
	});
</script>

<style>
	.contact-details li:nth-child(odd){
		width:100px;
		float:left
	}
	.contact-details li:nth-child(even){
		width:100px;
		float:left
	}
</style>
	
		
		<div id="contentLeft">
			<div id="profPhoto"><img width="86" height="106" src="<?php echo $profile_img; ?>" /><br /><?php echo $user_name; ?></div>		
			<?php   require_once('lib/group_header_include.php'); ?>
			<div class="line"></div>
		   <div id="leftmenulist">	
			<?php include ('common/side_navigation.php');?>
			</div>		
		  <div id="mainupload">	
				<div class="posting">Contacts</div>
				<?php 
				
					/*echo '<pre />';
					print_r($data);*/
				
						if(!empty($data)){
					foreach($data as $v){ 
						
					?>
				<div class="individual-contact">
				<img width="70" height="70" src="<?php echo $v['image_name']; ?>" class="flt" alt="" border="0" title="" />
				<ul class="contact-details">
					<?php if($v['priv_name'] == 1){ ?>
					<li class="bldtxt">Name:</li>
					<li><?php echo ucfirst($v['first_Name']).' '.ucfirst($v['last_Name']); ?></li>
					<?php } ?>
					<div class="clear"></div>
					<li class="bldtxt">Email:</li>
					<li><?php echo $v['email']; ?></li>
					<div class="clear"></div>
					<?php if($v['priv_place'] == 1){ ?>
					<li class="bldtxt">Location:</li>
					<li><?php echo $v['state_name']; ?></li>
					<div class="clear"></div>
					<?php } ?>
				</ul>
				<div style="float:right;">
					<!--<div id="signup" class="input reg_btn">
						<a onclick="window.open('profile.php?user_id=<?php echo $v['user_id']; ?>','_blank')"><span>View profile</span></a>
					</div>-->
					<a href="javascript:void(0);">
					<div class="profile_view_btns" onclick="window.location = 'profile.php?user_id=<?php echo $v['user_id']; ?>'">
						<img src="resource/images/view-profile.png" />
					</div>
					</a>
					<div class="clear"></div>
					<a href="javascript:void(0);">
					<div class="profile_view_btns send_msg" id="<?php echo $v['user_id']; ?>">
						<img src="resource/images/send-msg.png" />
					</div>
					</a>
					
				</div>
				<div class="clear"></div>
				</div> 
				<?php 
					}
					}else{
  ?>
		<div class="norecords  individual-contact">No Available contacts!</div>
  <?php 
	}
  ?>
				
		</div>
		</div>

		
		<div id="contentRight">
		
		<?php include ('common/right_side_navigation.php');?>
		
		</div>
		

			<?php require_once 'common/footer1.php'; ?>	