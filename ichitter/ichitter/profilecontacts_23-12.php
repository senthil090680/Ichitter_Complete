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
			
		   <div id="leftmenulist">	
			<?php include ('common/side_navigation.php');?>
			</div>		
		  <div id="mainupload">	
				<div class="profileHeading">Profile Contacts</div>
				<?php 
			
			$data = array('get_group_contact'=>1,'user_id'=>$_REQUEST['user_id']);	
			
	$init_process_obj = new INIT_PROCESS(SERVICE_NAME.'contact_service.php',$data);
	//echo $init_process_obj->response;
	$user_data = $ObjJSON->objectToArray($ObjJSON->decode($init_process_obj->response));
	/*echo '<pre />';
	print_r($user_data);*/
	
	
	$data = array();
	/*echo '<pre />';
	print_r($user_data['contacts']);*/
	if(!isset($user_data['contacts'])){
		/* contact list person joined groupids */
		foreach($user_data as $k => $v){
			$user_data[$k]->innerids = explode(',',$v->innerids);
		}
		
		/* session_user joined group ids */
		$innercircle_ids = array('get_innercircle_group_ids'=>1,'user_id'=>$session_obj->get_Session('user_id'));	
		$init_process_obj = new INIT_PROCESS(SERVICE_NAME.'contact_service.php',$innercircle_ids);
		$innercircle_ids = $ObjJSON->objectToArray($ObjJSON->decode($init_process_obj->response));
		
		foreach($innercircle_ids as $k => $v){
			$innercircle_ids[$k] = $ObjJSON->objectToArray($v);
		}
		
		foreach($user_data as $val){
			$data[] = $ObjJSON->objectToArray($val);
		}
		
		/*profile image name*/
		foreach($data as $k => $v){
			if(isset($v['image_name']) && trim($v['image_name']) != ''){
				$data[$k]['image_name'] = IMAGE_UPLOAD_SERVER. $v['user_id'] ."/". $v['igallery_name'] ."/thumb/". $v['image_name'];
			}else{
				$data[$k]['image_name'] = "resource/images/male-small.jpg";
			}
		}	
		
		
		/* find innercricle size */
		foreach($data as $k => $v){
			$data[$k]['innerids'] = sizeof(array_diff($innercircle_ids,$v['innerids']));
		}
		
		$contact_details = $data;
		
	}
		/*echo '<pre />';
			print_r($contact_details);*/
			
						if(!empty($contact_details)){
					foreach($contact_details as $v){ 
					?>
				<div class="individual-contact">
				<img width="70" height="70" src="<?php echo $v['image_name']; ?>" class="flt" alt="" border="0" title="" />
				<ul class="contact-details">
					<?php if($v['innerids'] > 0 && $v['priv_name'] == 1){ ?>
					<li>Name:</li>
					<li><?php echo ucfirst($v['first_Name']).' '.ucfirst($v['last_Name']); ?></li>
					<?php } ?>
					<div class="clear"></div>
					<li>Email:</li>
					<li><?php echo $v['email']; ?></li>
					<div class="clear"></div>
					<li>Location:</li>
					<li><?php echo $v['location']; ?></li>
					<div class="clear"></div>
				</ul>
				<div style="float:right;">
					<a href="javascript:void(0);">
					<div class="profile_view_btns" onclick="window.open('profile.php?user_id=<?php echo $v['user_id']; ?>','_blank')">
						<img src="resource/images/view-profile.png" />
					</div>
					</a>
					
					<div class="clear"></div>
					<a href="javascript:void(0);">
					<div class="profile_view_btns" >
						<img src="resource/images/send-msg.png" />
					</div>
					</a>
					
				</div>
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