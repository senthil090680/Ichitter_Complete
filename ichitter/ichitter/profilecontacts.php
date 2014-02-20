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
	$session_userid = SESS_USER_ID;
	
	require_once 'common/header1.php';
?>

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
	
		
		<div id="contentLeft">
		<div id="profPhoto"><img width="86" height="106" src="<?php echo $profile_img; ?>" /><br /><?php echo $user_name; ?></div>
    <?php require_once('lib/group_header_include.php'); ?>
    <div class="line"></div>
		
		   <div id="leftmenulist">	
			<?php include ('common/side_navigation.php');?>
			</div>		
		  <div id="mainupload">					
				<?php 
				if(isset($_REQUEST['search'])){
			
					$search = $_REQUEST['search'];
					$btn = '<img src="resource/images/add-friend.png" />';
					
					$search = strtolower($search).":".SESS_USER_ID;
					
					$REQ_SEND['action'] = 'get_search_contact';
					$REQ_SEND['search'] = $search;
				}elseif(isset($_REQUEST['user_id'])){
					//echo 'user_id';
					$user_id = $_REQUEST['user_id'];
					$btn = '<img src="resource/images/send-msg.png" />';
					//$data = array('action'=>'get_group_contact','user_id'=>$user_id);.
					$REQ_SEND['action'] = 'get_group_contact';
					$REQ_SEND['user_id'] = $user_id;
				}
			
	$init_process_obj = new INIT_PROCESS(CONTACT_SERVICE,$REQ_SEND);
	
	$user_data = (array)($ObjJSON->decode($init_process_obj->response));
	
	
	
	$data = array();
	
	if(!isset($user_data['contacts'])){
		
		
		foreach($user_data as $val){
			$data[] = $ObjJSON->objectToArray($val);
		}
		
		/*profile image name*/
		foreach($data as $k => $v){
			if(isset($v['image_name']) && trim($v['image_name']) != ''){
				$data[$k]['image_name'] = IMAGE_UPLOAD_SERVER. $v['user_id'] ."/". $v['igallery_name'] ."/thumb/". $v['image_name'];
			}elseif($v['gender'] == 'm'){
				$data[$k]['image_name'] = "resource/images/male-small.jpg";
			}elseif($v['gender'] == 'f'){
				$data[$k]['image_name'] = "resource/images/female-small.jpg";
			}
		}	
		
		
		
		
		$contact_details = $data;
		
	}
		/*echo '<pre />';
			print_r($contact_details);*/
			?>
	<div class="profileHeading">
		<?php 
			if(isset($_REQUEST['search'])){ 
				if(sizeof($contact_details) <= 1){
					echo sizeof($contact_details).' '.SINGLE_SRC_RESULT.' <label style="font-size:12px;">for "<strong>'.$_REQUEST['search'].'</strong>" keyword</label>';
				}elseif(sizeof($contact_details) > 1){
					echo sizeof($contact_details).' '.SRC_RESULTS.' <label style="font-size:12px;">for "<strong>'.$_REQUEST['search'].'</strong>" keyword</label>';
				}
			}else{
				echo CONTACTS_TITLE;
			}
		?>					
	</div>
	<?php 
			
	$in_circleids = array();	
	foreach($innercircle_ids as $v){
		$in_circleids[] = $v['group_id'];
	}
	/*echo '<pre />';
	print_r($contact_details);*/
						//echo sizeof($contact_details);
				if(!empty($contact_details)){
					foreach($contact_details as $v){ 						
						if(isset($_REQUEST['search']) && !in_array($v['group_id'],$in_circleids)){
					?>
				<div id="<?php echo $v['user_id']; ?>" class="individual-contact">
				<img width="70" height="70" src="<?php echo $v['image_name']; ?>" class="flt" alt="" border="0" title="" />
				<ul class="contact-details">
					<?php if($v['pub_name'] == 1){ ?>
					<li>Name:</li>
					<li><?php echo ucfirst($v['first_Name']).' '.ucfirst($v['last_Name']); ?></li>
					<?php } ?>
					<div class="clear"></div>
					<li>Email:</li>
					<li><?php echo $v['email']; ?></li>
					<div class="clear"></div>
					<li>Location:</li>
					<li><?php echo $v['state_name']; ?></li>
					<div class="clear"></div>
				</ul>
				<div style="float:right;">
					<a href="javascript:void(0);">
					<div class="profile_view_btns" onclick="window.location = 'profile.php?flag=<?php echo $v['addfrnd_flag']; ?>&user_id=<?php echo $v['user_id']; ?>'">
						<img src="resource/images/view-profile.png" />
					</div>
					</a>
					
					<div class="clear"></div>
					<?php if(isset($v['addfrnd_flag'])){?>
						<div style="width:111px;text-align:center;font-size:12px;"><?php echo ALREADY_SENT; ?></div>
					<?php
							}/*elseif(isset($v['already_sent']) && $v['already_sent'] != 'null' && !isset($v['is_innercircle'])){?>
						<div style="width:111px;text-align:center;font-size:12px;"><?php echo ALREADY_SENT; ?></div>
					<?php
							}*/elseif(isset($v['is_innercircle'])){ ?>
						<div style="width:111px;text-align:center;font-size:12px;"><?php echo ADDED_INNERCIRCLE; ?></div>
					<?php
							}else{
					?>
					<a href="javascript:void(0);" class="addfrnd">
					<div class="profile_view_btns" onclick="addfriend(this,'<?php echo $session_userid.":".$v['user_id']; ?>')" >
						
							<?php echo $btn; ?>
					</div>
					</a>
					<?php 
						}
					?>
					<a href="javascript:void(0);">
					<div class="profile_view_btns send_msg" id="<?php echo $v['user_id']; ?>">
						<img src="resource/images/send-msg.png" />
					</div>
					</a>
				</div>
				<div style="clear:both"></div>
				</div> 
				<?php 
					}elseif(isset($_REQUEST['user_id'])){
					?>
				<div class="individual-contact">
				<img width="70" height="70" src="<?php echo $v['image_name']; ?>" class="flt" alt="" border="0" title="" />
				<ul class="contact-details">
					<?php if($v['priv_name'] == 1){ ?>
					<li>Name:</li>
					<li><?php echo ucfirst($v['first_Name']).' '.ucfirst($v['last_Name']); ?></li>
					<?php } ?>
					<div class="clear"></div>
					<li>Email:</li>
					<li><?php echo $v['email']; ?></li>
					<div class="clear"></div>
					<li>Location:</li>
					<li><?php echo $v['state_name']; ?></li>
					<div class="clear"></div>
				</ul>
				<div style="float:right;">
					<a href="javascript:void(0);">
					<div class="profile_view_btns" onclick="window.location = 'profile.php?user_id=<?php echo $v['user_id']; ?>'">
						<img src="resource/images/view-profile.png" />
					</div>
					</a>
					
					<div class="clear"></div>
					<a href="javascript:void(0);">
					<div class="profile_view_btns" >
						<?php echo $btn; ?>
					</div>
					</a>
					
				</div>
				</div> 
				<?php 
					}
					}
				}else{
				
  ?>
		<div class="norecords  individual-contact">
			<?php 
				if(isset($_REQUEST['search'])){
					echo SRC_ERROR; 
				}else{
					echo CONTACT_ERROR; 
				}
			?>
		</div>
  <?php 
	}
  ?>
				
		</div>
		</div>

		
		<div id="contentRight">
		
		<?php include ('common/right_side_navigation.php');?>
		
		</div>
		

			<?php require_once 'common/footer1.php'; ?>	