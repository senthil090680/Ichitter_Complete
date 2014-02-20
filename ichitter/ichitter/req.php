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
	
	
	require_once 'common/header1.php';
	/* $newsstreams array comes from header1.php*/ 
	if($newsstreams['total'] > 0){	
	
		$user_id = $_SESSION['login']['user_id'];
		$data = array('action'=>'get_all_requestdetails','user_id'=>$user_id);
		$data += $REQ_SEND;
		$init_process_obj = new INIT_PROCESS(REQ_SERVICE,$data);
		//echo $init_process_obj->response;
		$requested_friends = $ObjJSON->objectToArray($ObjJSON->decode($init_process_obj->response));
		
		foreach($requested_friends as $k => $v){
			$requested_friends[$k] = $ObjJSON->objectToArray($v);
		}
	
		
	}
	
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
		<div id="contentLeft">
			<div id="profPhoto"><img width="86" height="106" src="<?php echo $profile_img; ?>" /><br /><?php echo $user_name; ?></div>		
			<?php   require_once('lib/group_header_include.php'); ?>
			<div class="line"></div>
		   <div id="leftmenulist">	
			<?php include ('common/side_navigation.php');?>
			</div>		
			
		  <div id="mainupload">	
			<div class="posting"><?php echo REQUEST_TITLE; ?></div>
			<?php if($newsstreams['total'] > 0){	?>
				
				
				<?php 
					/*echo '<pre />';
					print_r($requested_friends);*/
					foreach($requested_friends as $v){ 
						if(isset($v['image_name']) && trim($v['image_name']) != ''){
							if(isset($v['igallery_name'])){
								$requested_frnd_img = IMAGE_UPLOAD_SERVER. $v['user_id'] ."/". $v['igallery_name'] ."/thumb/". $v['image_name'];
							}else{
								$requested_frnd_img = IMAGE_UPLOAD_SERVER. $v['user_id'] ."/thumb/". $v['image_name'];
							}
						}else{
							if($v['gender'] == 'm'){
								$requested_frnd_img = "resource/images/male-small.jpg";
							}elseif($v['gender'] == 'f'){
								$requested_frnd_img = "resource/images/female-small.jpg";
							}		
						}
				
				?>
				<div id="<?php echo $v['user_id']; ?>" class="friendschat">
					 <div class="friendsimg"><img src="<?php echo $requested_frnd_img; ?>">	</div>
					 <div class="friendconts contact-details">
					 	<?php if($v['pub_name']){ ?>					 	
						 <h5><?php echo $v['name']; ?></h5>
						<?php } ?>
						<?php if($v['pub_place']){ ?>	
						 <h6><?php echo $v['state_name']; ?></h6>
						<?php } ?>
						<?php echo $v['email']; ?>
						 <!--<p>Ferrari florist and 72 other mutual friends.</p>-->
					 </div>
					
					<div class="right_side_btn">					 
					 
					 <div class="btconfirm">
						<a href="javascript:void(0);">
					<div class="profile_view_btns" onclick="window.location = 'profile.php?preview_from=news&user_id=<?php echo $v['user_id']; ?>'">
						<img src="resource/images/view-profile.png" />
					</div>
					
					</a>
					 	<a href="javascript:void(0);" >
							<img onclick="req_confirm(this,<?php echo $user_id.','.$v['user_id']; ?>,'confirm')" border="0" src="resource/images/bt-confirm.png">
						</a>
					 </div>
					  <?php if(!$v['deny_flag']){ ?>
					 <div class="clear"></div>
					 <div class="btconfirm">
					 	<a href="javascript:void(0);">
							<img onclick="req_confirm(this,<?php echo $user_id.','.$v['user_id']; ?>,'deny')" border="0" src="resource/images/bt-notconfirm.png">
						</a>
					 </div>
					  <?php }else{ ?>
					 	<div class="after_success"><?php echo DENIED; ?></div>
					 <?php } ?>
					 </div>
					 
				</div>
				<?php 
					}
				}else{
				?>
					<div class="norecords  individual-contact"><?php echo NO_REQ; ?></div>
				<?php
				}
				?>
				
		</div>
		</div>

		
		<div id="contentRight">
		
		<?php include ('common/right_side_navigation.php');?>
		
		</div>
		

			<?php require_once 'common/footer1.php'; ?>	