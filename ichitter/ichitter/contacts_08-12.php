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

	$data = array('get_group_contact'=>1,'user_id'=>$session_obj->get_Session('user_id'));	
	$init_process_obj = new INIT_PROCESS(SERVICE_NAME.'contact_service.php',$data);
	$user_data = $ObjJSON->objectToArray($ObjJSON->decode($init_process_obj->response));
	$data = array();
	foreach($user_data as $val){
		$data[] = $ObjJSON->objectToArray($val);
	}
	
	
	
	foreach($data as $k => $v){
		if(isset($v['image_name']) && trim($v['image_name']) != ''){
			$data[$k]['image_name'] = IMAGE_UPLOAD_SERVER. $v['user_id'] ."/". $v['igallery_name'] ."/thumb/". $v['image_name'];
		}else{
			$data[$k]['image_name'] = "resource/images/male-small.jpg";
		}
	}	
	
	/*echo '<pre />';
	print_r($data);*/
	
	
	
	
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
			<div id="profPhoto"><img width="86" height="106" src="<?php echo $profile_img; ?>" /><br /><?php echo $user_name; ?></div>		
			<?php   require_once('lib/group_header_include.php'); ?>
			<div class="line"></div>
		   <div id="leftmenulist">	
			<?php include ('common/side_navigation.php');?>
			</div>		
		  <div id="mainupload">	
				<div class="posting">Contacts</div>
				<?php foreach($data as $v){ ?>
				<div class="individual-contact">
				<img width="70" height="70" src="<?php echo $v['image_name']; ?>" class="flt" alt="" border="0" title="" />
				<ul class="contact-details">
					<li>Name:</li>
					<li><?php echo $v['first_Name'].' '.$v['last_Name']; ?></li>
					<div class="clear"></div>
					<li>Email:</li>
					<li><?php echo $v['email']; ?></li>
					<div class="clear"></div>
					<li>Location:</li>
					<li><?php echo $v['location']; ?></li>
					<div class="clear"></div>
				</ul>
				</div> 
				<?php } ?>
		</div>
		</div>

		
		<div id="contentRight">
		
		<?php include ('common/right_side_navigation.php');?>
		
		</div>
		

			<?php require_once 'common/footer1.php'; ?>	