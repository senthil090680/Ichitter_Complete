<?php
	require_once 'lib/include_files.php';
	if(isset($_REQUEST['logout']) && $_REQUEST['logout'] == 'OK'){
		$session_obj->unset_Session('login');	
		
		echo "<script>window.location = 'index.php'</script>";
	}

	if($session_obj->get_Session('login') == 'false'){

		echo "<script>window.location = 'index.php'</script>";
	}
	$data = array('get_user_record'=>1,'user_id'=>$_REQUEST['user_id']);	
	$init_process_obj = new INIT_PROCESS(SERVICE_NAME.'registration_service.php',$data);
	$user_data = $ObjJSON->objectToArray($ObjJSON->decode($init_process_obj->response));
	/*echo '<pre />';
	print_r($user_data);*/
	if(isset($user_data['image_name']) && trim($user_data['image_name']) != ''){
		$profile_img = IMAGE_UPLOAD_SERVER. $user_data['user_id'] ."/". $user_data['igallery_name'] ."/". $user_data['image_name'];
	}else{
		$profile_img = "resource/images/profile-img1.jpg";
	}
	
	/* getting security datas*/
	$data = array('get_security_settings'=>1,'user_id'=>$_REQUEST['user_id']);	
	$init_process_obj = new INIT_PROCESS(SERVICE_NAME.'security_service.php',$data);
	$security = $ObjJSON->objectToArray($ObjJSON->decode($init_process_obj->response));
	
	/* session_user joined group ids */
	$innercircle_ids = array('get_innercircle_group_ids'=>1,'user_id'=>$session_obj->get_Session('user_id'));	
	$init_process_obj = new INIT_PROCESS(SERVICE_NAME.'contact_service.php',$innercircle_ids);
	$innercircle_ids = $ObjJSON->objectToArray($ObjJSON->decode($init_process_obj->response));
	
	foreach($innercircle_ids as $k => $v){
		$innercircle_ids[$k] = $ObjJSON->objectToArray($v);
	}
	
	/*foreach($data as $k => $v){
		$data[$k]['innerids'] = sizeof(array_diff($innercircle_ids,$v['innerids']));
	}*/
	
	require_once 'common/header1.php';
?>

		<div id="contentLeft">
			<div id="profile">
				<h3>My iChitter Profile</h3>
				<div id="profileContent">
					<div class="profileContentLeft">
						<div class="profileimg" id="imgGal">
							<img width="139" height="169" src="<?php echo $profile_img; ?>" />
						</div>
					</div>
					<div class="profileContentRight">

<table width="271" border="0" cellspacing="1" cellpadding="1">
	<tr class="profiletr">
		<td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="texthg">
				<tr>
					<td width="55%" class="profiletdtxt">First Name :</td>
					<td class="profiletdtxt3">
						<div class="profiletdtxt2"><?php echo $user_data['first_Name']; ?></div>
					</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr class="profiletr">
		<td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="texthg">
				<tr>
					<td width="55%" class="profiletdtxt">Last Name :</td>
					<td class="profiletdtxt3">
						<div class="profiletdtxt2"><?php echo $user_data['last_Name']; ?></div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr class="profiletr">
		<td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0"class="texthg">
				<tr>
					<td width="55%" class="profiletdtxt">Place :</td>
					<td class="profiletdtxt3">
						<div id="txt_location" class="profiletdtxt2"><?php echo $user_data['location']; ?></div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr class="profiletr">
		<td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="texthg">
				<tr>
					<td width="55%" class="profiletdtxt">Status :</td>
					<td class="profiletdtxt3">
						<div id="txt_status" class="profiletdtxt2"><?php echo $user_data['status']; ?></div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr class="profiletr">
		<td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="texthg">
				<tr>
					<td width="55%" class="profiletdtxt">Education :</td>
					<td class="profiletdtxt3">
						<div class="profiletdtxt2"><?php echo $user_data['college']; ?></div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr class="profiletr">
		<td style="padding-bottom:3px;">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="texthg">
				<tr>
					<td width="55%" class="profiletdtxt">Profession :</td>
					<td class="profiletdtxt3">
						<div class="profiletdtxt2"><?php echo $user_data['profession']; ?></div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>


<table width="270" border="0" cellspacing="1" cellpadding="1" class="texthg">

	<tr class="profiletr">
    	<td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
        			<td width="55%" class="profiletdtxt">Career :</td>
        			<td class="profiletdtxt3">
						<div class="profiletdtxt2"><?php echo $user_data['career']; ?></div>
					</td>
				</tr>
			</table>
		</td>
  </tr>
  
  <tr class="profiletr">
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="55%" class="profiletdtxt">Political Affiliation :</td>
        <td class="profiletdtxt3">
		<div class="profiletdtxt2"><?php echo $user_data['political_affiliation']; ?></div>
		
		
    </table></td>
  </tr>




 
  <tr class="profiletr">
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="texthg">
      <tr>
        <td width="55%" class="profiletdtxt">Active involment :</td>
        <td class="profiletdtxt3">
		<div class="profiletdtxt2"><?php echo $user_data['active_involment']; ?></div>
		
		
    </table></td>
  </tr>
 <tr class="profiletr">
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="texthg">
      <tr>
        <td width="55%" class="profiletdtxt">Hobbies :</td>
        <td class="profiletdtxt3">
		<div class="profiletdtxt2"><?php echo $user_data['hobbies']; ?></div>
		
		
    </table></td>
  </tr>

	
  <tr class="profiletr">
   <td style="padding-bottom:3px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="55%" class="profiletdtxt">Family :</td>
        <td class="profiletdtxt3">
		<div class="profiletdtxt2"><?php echo $user_data['family']; ?></div>
		
		
    </table></td>
  </tr>
  <tr class="profiletr">
    <td>&nbsp;</td>
  </tr>
  
  
</table>



						
						
						<div class="Issueshearts">
						<p>Issues close at heart</p>
						
						<div class="profileinfoTextbox">
						<div class="profiletdtxt2"><?php echo $user_data['issues_close_at_heart']; ?></div>
						
				
						
						
						</div>
						</div>
						
					</div>
				</div>
			</div>		
			<div id="leftmenulist">	
				
					<?php include ('common/side_navigation.php');?>
					 
				
			</div>		
		  <div id="mainupload">	
			<div class="profileHeading">Profile</div>
			
			<?php   require_once('lib/group_header_include.php'); ?>
			<div class="profileinfo">
				<p>Basic Information</p>
				
				<div class="profileinfoTextbox">
					<div>
					<?php echo stripcslashes($user_data['basic_info']); ?>
					</div>
				</div>
			</div>	
			
			<div class="profileinfo">
				<p>Personal Data</p>
				
				<div class="profileinfoTextbox">
					<div>
					<?php echo stripcslashes($user_data['personal_data']); ?>
					</div>
				</div>
			</div>
			
			<div class="profileinfo">
				<p>Interests</p>
				
				<div class="profileinfoTextbox">
					<div>
					<?php echo stripcslashes($user_data['interests']); ?>
					</div>
				</div>
			</div>
			
			<div class="profileinfo">
				<p>Professional background</p>
				
				<div class="profileinfoTextbox">
					<div>
					<?php echo stripcslashes($user_data['professional_background']); ?>
					</div>
				</div>
			</div>			
			<div class="profileinfo">
				<p>Favorites</p>
				
				<div class="profileinfoTextbox">
					<div>
					<?php echo stripcslashes($user_data['favorites']); ?>				
					</div>
				</div>
			</div>
			
			
		</div>
				
				
				
		</div>

		<div id="contentRight">
		
		 <div class="rigimg"><img src="resource/images/img-netflix.jpg"  alt="" /></div>
		  <div class="rigimg"><img src="resource/images/img-cola.jpg"  alt="" /></div>
		   
		   <div id="author">
		    <h1>I Author</h1>
			 <h2><a href="../frontedpage/discussion.html">Pellentesque habitant mo...</a></h2>
			 <p>Ehicu fusce auctor, metus eu ul. L... </p>
			 <h2><a href="../frontedpage/discussion.html">Nulla mauris odio</a></h2>
			 <p>Nullam porta ipsum dolor duis dolor..</p>
			  <h2><a href="../frontedpage/discussion.html">Nunc tempus felis</a></h2>
			 <p>Mauris vel lacus vitae felis vestibul....</p>
			 <h2><a href="../frontedpage/discussion.html">Maecenas aliquet velit</a></h2>
			 <p>Vestibulum ligula augue, bibendum...</p>
	      </div>
			
			<div id="recentread">
		    <h1>Recently Read</h1>
			 <h4>01</h4><h2><a href="../frontedpage/discussion.html">Pellentesque habitant morb...</a></h2>
			  <h4>02</h4><h2><a href="../frontedpage/discussion.html">Cras a ante vitae enim iacul...</a></h2>
			  <h4>03</h4><h2><a href="../frontedpage/discussion.html">Mauris vel lacus vitae felis v...</a></h2>
			  <h4>04</h4><h2><a href="../frontedpage/discussion.html">Lorem ipsum dolor sit amet,...</a></h2>
			   <h4>05</h4><h2><a href="../frontedpage/discussion.html">Phasellus felis dolor, scelerisq...</a></h2>
		    </div>
			
			<div id="marked">
		    <h1>Marked</h1>
			 <h2><a href="../frontedpage/discussion.html">Pellentesque habitant mo...</a></h2>
			 <p>Ehicu fusce auctor, metus eu ul. L...</p>
			 <h2><a href="../frontedpage/discussion.html">Nulla mauris odio</a></h2>
			 <p>Nullam porta ipsum dolor duis dolor..</p>
			  <h2><a href="../frontedpage/discussion.html">Nunc tempus felis</a></h2>
			 <p>Mauris vel lacus vitae felis vestibul....</p>
			 <h2><a href="../frontedpage/discussion.html">Maecenas aliquet velit</a></h2>
			 <p>Vestibulum ligula augue, bibendum...</p>
		    </div>
			
		
		</div>
		<?php 
	$user_id = $session_obj->get_Session('user_id');
	
?>
<div class="gallerybg">
 <a class="galleryClose"><img src="resource/images/closebt.png" alt="" /></a>
 <div class="gallerytitle">Select an Image</div>
 <div class="gallerybox">
  <div class="galleryboxscroll">
    <?php 
   	  $url = SERVICE_NAME.'editprofile_service.php';	  
	  $data['user_id'] = $user_id;
	  $data['getgalleryuser_id'] = 1;
      $init_process_obj->getUserGallery($url,$data);	  
	  if($init_process_obj->response != 1){
	  	
		$gallery_arr = 	$ObjJSON->decode($init_process_obj->response);
		foreach($gallery_arr as $k => $v){
			$gallery_arr[$k] = $ObjJSON->objectToArray($ObjJSON->decode($v));
		}

		$html = '';
		$grp_name = '';
		$basePath = IMAGE_UPLOAD_SERVER . $user_id;
		$g = 0;
		foreach($gallery_arr as $k => $arr1 ){
			$g = $g + 1;
			$group_name = explode('_',$arr1['igallery_name']);
			
			if(!$k){
				$html .= "<div class='galleryinnertitle'><div>" . $group_name[0] . "</div><div class='arrow_up'></div></div><div class='clear'></div><div class='img_holder active_accordian active_accrodion'>";
			}elseif($grp_name == '' || $group_name[0] != $grp_name){
				$g = 0;
				$html .= "<div class='clear'></div></div><div class='galleryinnertitle'><div>" . $group_name[0] . "</div><div class='arrow_down'></div></div><div class='clear'></div><div class='img_holder'>";
			}
			
			if(isset($arr1['image_name'])){
				$imgPath = $basePath . '/' . $arr1['igallery_name'] . '/thumb/'.$arr1['image_name'];
			}else{
				$imgPath = 'resource/images/profile-img1.jpg';
			}
			
			$html .= "<div class='imgbox'><a href=\"javascript: setID('".$arr1['image_id']."', '".urldecode($imgPath)."')\" ><img src='".$imgPath."' alt='' border='0' /></a></div>";
			
			$grp_name = $group_name[0];
		}
		echo $html."<div class='clear'></div></div>";
	  }
      ?> 
  </div>
 </div>
</div>		
<div id="backgroundPopup"></div>
<?php require_once 'common/footer1.php'; ?>