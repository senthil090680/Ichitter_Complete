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
	$profile_user = $ObjJSON->objectToArray($ObjJSON->decode($init_process_obj->response));
	/*echo '<pre />';
	print_r($profile_user);*/
	
	
	/* getting security datas*/
	$data = array('get_security_settings'=>1,'user_id'=>$_REQUEST['user_id']);	
	$init_process_obj = new INIT_PROCESS(SERVICE_NAME.'security_service.php',$data);
	$security = $ObjJSON->objectToArray($ObjJSON->decode($init_process_obj->response));
	
	$data = array('get_user_record'=>1,'user_id'=>$_REQUEST['user_id']); 	
	$init_process_obj = new INIT_PROCESS(SERVICE_NAME.'registration_service.php',$data);
	 $user_data = $ObjJSON->objectToArray($ObjJSON->decode($init_process_obj->response));
	 /*echo '<pre />';
	 print_r($user_data);*/
	 if(isset($user_data['image_name']) && trim($user_data['image_name']) != ''){
	  $profile_img = IMAGE_UPLOAD_SERVER. $user_data['user_id'] ."/". $user_data['igallery_name'] ."/thumb/". $user_data['image_name'];
	 }else{
	  $profile_img = "resource/images/paula-jones.jpg";
	 }
	 $user_name = $user_data['first_Name']." ".$user_data['last_Name'];
	
	require_once 'common/header1.php';
?>

<style>
	.imgGal{
		cursor:pointer
	}

	.profile_user{
		font-size:12px;
	}
	
	.profile_user ul li{
		padding-top:10px;
		
	}
	
	.profile_user ul li:nth-child(odd){
		clear:both;
		float:left;
		width:200px;
	}
	
	.profile_user ul li:nth-child(even){
		float:left;
		width:330px;
		text-align:justify;
		
	}
	
	.arrow_down{
		width:15px;
		height:16px;
		background:url(resource/images/arrow-down.png);
		float:right;
		margin-right:5px;
	}
	
	.arrow_up{
		width:15px;
		height:16px;
		background:url(resource/images/arrow-up.png);
		float:right;
		margin-right:5px;
	}
	.profileimg:hover #profilephotoedit{
		display:block;
		margin-top:70px;
		margin-left:15px;
	}
	
	.img_holder{
		display:none;
	}
	
	.active_accordian{
		display:block;
	}
	
	.galleryinnertitle div:first-child{
		float:left;
	}
	
	.short_name{
		cursor:pointer;
	}
	
</style>
<link rel="stylesheet" href='resource/css/gallery.css' type="text/css" />
<script src="resource/js/jquery-1.7.min.js" type="text/javascript"></script>
<script src="resource/js/popup-gallery.js" type="text/javascript"></script>
<script>
	$(document).ready(function(){
		$('.galleryinnertitle').click(function(){
			if(!$(this).next().next().hasClass('active_accrodion')){
				
				$('.active_accrodion').slideUp();
				$('.galleryinnertitle div:last-child').removeClass('arrow_up').addClass('arrow_down');
				$('.galleryboxscroll div').removeClass('active_accrodion');
				$(this).next().next().addClass('active_accrodion');
				$(this).next().next().slideDown();
				$(this).find('div:last-child').addClass('arrow_up');
			}
		});
	});
</script>
		<div id="contentLeft">
			<div id="leftmenulist">	
					<?php include ('common/side_navigation.php');?>
			</div>	
			<div id="mainupload">	
			<div class="profileHeading profileHeading_bg">Profile</div>
						
			<table  border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td colspan="3" style="background-color:#E4F3FC">
					<table cellpadding="3" cellspacing="3" border="0" style="padding-bottom:4px;">
						<tr>
							<td>
								<img src="<?php echo $profile_img; ?>" />
							</td>
							<td width="300">
							<table cellpadding="0" cellspacing="0" border="0">
								<?php if($security['priv_name']){ ?>
							  <tr class="colone" >
								<td width="86"  class="proname">Name </td>
								<td width="10" >:</td>
								<td width="172"  class="proname"><strong><?php echo $profile_user['first_Name'].' '.$profile_user['last_Name']; ?></strong></td>
							  </tr>
							  <?php } ?>
							  <?php if($security['priv_status']){ ?>
							  <tr bgcolor="#e4f3fc"  class="coltwo">
								 <td width="86" class="proname">Status </td>
								<td>:</td>
								  <td width="172"  class="proname"><?php echo $profile_user['status']; ?></td>
							  </tr>
							  <?php } ?>
							  <tr bgcolor="#e4f3fc"  class="proht">
							   <td width="86" class="proname">Email </td>
							   <td>:</td>
								 <td width="172" class="proname"><?php echo $profile_user['email']; ?></td>
							 </tr>
							 </table>
							</td>
							<td id="profile_views">
								<?php if($security['priv_photographs']){ ?>
								<div class="imgGal img_gallery" >
									<img src="resource/images/view-photos.png" />
								</div>
								 <?php } ?>	
								  <?php if($security['priv_movies']){ ?>
								 <div class="imgGal video_gallery" >
								 <img src="resource/images/view-videos.png" />
								 </div>
								 <?php } ?>	
								 
								 <?php if($security['priv_contacts']){ ?>
									<div class="contact_gallery" onclick="window.open('profilecontacts.php?user_id=<?php echo $_REQUEST['user_id']; ?>')" >
									<img src="resource/images/view-contacts.png" />
									</div>
								 <?php } ?>	
								 
								
								
								<?php if($security['priv_news_stream']){ ?>	
								<div>							  
									<img src="resource/images/newstream.png" />
								</div>
								<?php } ?>
								<?php if(isset($_REQUEST['preview_from'])){ ?>
								<div class="right_side_btn">
								<a href="javascript:void(0);">
									<img border="0" src="resource/images/bt-confirm.png" onclick="req_confirm(this,<?php echo $_SESSION['login']['user_id'].','.$_REQUEST['user_id']; ?>,'confirm')">
								</a>
								
								<a href="javascript:void(0);">
									<img border="0" src="resource/images/bt-notconfirm.png" onclick="req_confirm(this,<?php echo $_SESSION['login']['user_id'].','.$_REQUEST['user_id'];; ?>,'deny')">
								</a>
								</div>
								<?php } ?>
							
								
							</td>
						</tr>
					</table>
				</td>
			</tr>
  <!--<?php if($security['priv_name']){ ?>
  <tr class="colone" >
    <td width="196" class="proname">Name </td>
    <td width="10">:</td>
    <td width="316" class="proname"><?php echo $profile_user['first_Name'].' '.$profile_user['last_Name']; ?></td>
  </tr>
  <?php } ?>
  <?php if($security['priv_status']){ ?>
  <tr bgcolor="#e4f3fc"  class="coltwo">
     <td class="proname">Status </td>
    <td>:</td>
      <td width="316" class="proname"><?php echo $profile_user['status']; ?></td>
  </tr>
  <?php } ?>
  <tr bgcolor="#e4f3fc"  class="proht">
   <td class="proname">Email </td>
   <td>:</td>
     <td width="316" class="proname"><?php echo $profile_user['email']; ?></td>
 </tr>-->
 <?php if($security['priv_profession']){ ?>
  <tr bgcolor="#e4f3fc"  class="coltwo">
  <td class="procent" width="196">Profession </td>
   <td width="10">:</td>
      <td width="316" class="proname"><?php echo $profile_user['profession']; ?></td>
  </tr>
  <?php } ?>
  <tr bgcolor="#e4f3fc"  class="proht">
     <td class="procent">Personal Data </td>
   <td>:</td>
   <td width="316" class="proname"><?php echo $profile_user['personal_data']; ?></td>
 </tr>
 <?php if($security['priv_interest']){ ?>
  <tr bgcolor="#e4f3fc"  class="coltwo">
   <td class="procent">Interests</td>
   <td>:</td>
   <td width="316" class="proname"><?php echo $profile_user['interests']; ?></td>
  </tr>
  <?php } ?>
  <tr bgcolor="#e4f3fc"  class="proht">
     <td class="procent">Favorites </td>
   <td>:</td>
   <td width="316" class="proname"><?php echo $profile_user['favorites']; ?></td>
 </tr>
  <tr bgcolor="#e4f3fc"  class="coltwo">
   <td class="procent">Professional Background </td>
   <td>:</td>
   <td width="316" class="proname"><?php echo $profile_user['professional_background']; ?></td>
 </tr>
 <?php if($security['priv_education']){ ?>
  <tr bgcolor="#e4f3fc"  class="proht">
   <td class="proname">Education </td>
   <td>:</td>
   <td width="316" class="proname"><?php echo $profile_user['college']; ?></td>
 </tr>
 <?php } ?>
 <?php if($security['priv_career']){ ?>				
  <tr bgcolor="#e4f3fc"  class="coltwo">
   <td class="procent">Career </td>
   <td>:</td>
   <td width="316" class="proname"><?php echo $profile_user['career']; ?></td>
 </tr>
 <?php } ?>
 <?php if($security['priv_poltifical_affiliation']){ ?>	
 <tr bgcolor="#e4f3fc"  class="proht">
   <td class="procent">Political Affiliation </td>
   <td>:</td>
   <td width="316" class="proname"><?php echo $profile_user['political_affiliation']; ?></td>
 </tr>
<?php } ?>
<?php if($security['priv_active_involment']){ ?>
  <tr bgcolor="#e4f3fc"  class="coltwo">
   <td class="procent">Active Involment</td>
   <td>:</td>
   <td width="316" class="proname"><?php echo $profile_user['active_involment']; ?></td>
 </tr>
 <?php } ?>
 
 <?php if($security['priv_hobbies']){ ?>
 <tr bgcolor="#e4f3fc"  class="proht">
   <td class="procent">Hobbies</td>
   <td>:</td>
   <td width="316" class="proname"><?php echo $profile_user['hobbies']; ?></td>
 </tr>
 <?php } ?>
 <?php if($security['priv_family']){ ?>
  <tr bgcolor="#e4f3fc"  class="coltwo">
   <td class="procent">Family</td>
   <td>:</td>
   <td width="316" class="proname"><?php echo $profile_user['family']; ?></td>
 </tr>
 <?php } ?>
 <?php if($security['priv_issues_close_to_heart']){ ?>
 <tr bgcolor="#e4f3fc"  class="proht">
   <td class="procent">Issues close at heart</td>
   <td>:</td>
   <td width="316" class="proname"><?php echo $profile_user['issues_close_at_heart']; ?></td>
 </tr>
 <?php } ?>

 
 
 
  <?php if($security['priv_i_Author']){ ?>
  <tr bgcolor="#e4f3fc"  class="coltwo">
   <td class="procent">I, Author</td>
   <td>:</td>
   <td width="316" class="proname">I, Author</td>
 </tr>
 <?php } ?>	
  <?php /*if($security['priv_recommend']){ ?>
 <tr bgcolor="#e4f3fc"  class="proht">
   <td class="procent">Recommend</td>
   <td>:</td>
   <td width="316" class="proname">Recommend</td>
 </tr>
 <?php }*/ ?>
</table>

			
		</div>	
		  <!--<div id="mainupload">	
			<div class="profileHeading profileHeading_bg">Profile</div>
			<?php //echo '<pre />'; print_r($profile_user); ?>
			<div class="profile_user">
				<ul>
					<?php if($security['priv_name']){ ?>
						<li>Name :</li>
						<li><?php echo $profile_user['first_Name'].' '.$profile_user['last_Name']; ?></li>
					<?php } ?>
					<?php if($security['priv_status']){ ?>
					<li>Status :</li>
					<li><?php echo $profile_user['status']; ?></li>
					<?php } ?>
					<li>Email :</li>
					<li><?php echo $profile_user['email']; ?></li>
					<?php if($security['priv_profession']){ ?>
					<li>Profession :</li>
					<li><?php echo $profile_user['profession']; ?></li>
					<?php } ?>
					<li>Personal Data :</li>
					<li><?php echo $profile_user['personal_data']; ?></li>
					<?php if($security['priv_interest']){ ?>
					<li>Interests :</li>
					<li><?php echo $profile_user['interests']; ?></li>
					<?php } ?>
					<li>Favorites :</li>
					<li><?php echo $profile_user['favorites']; ?></li>
					<li>Professional Background :</li>
					<li><?php echo $profile_user['professional_background']; ?></li>
					<?php if($security['priv_education']){ ?>
					<li>Education :</li>
					<li><?php echo $profile_user['college']; ?></li>	
					<?php } ?>
					<?php if($security['priv_career']){ ?>				
					<li>Career :</li>
					<li><?php echo $profile_user['career']; ?></li>
					<?php } ?>
					<?php if($security['priv_poltifical_affiliation']){ ?>				
					<li>Political Affiliation :</li>
					<li><?php echo $profile_user['political_affiliation']; ?></li>
					<?php } ?>
					<?php if($security['priv_active_involment']){ ?>			
					<li>Active Involment :</li>
					<li><?php echo $profile_user['active_involment']; ?></li>
					<?php } ?>
					
					<?php if($security['priv_hobbies']){ ?>
					<li>Hobbies :</li>
					<li><?php echo $profile_user['hobbies']; ?></li>
					<?php } ?>
					<?php if($security['priv_family']){ ?>
					<li>Family :</li>
					<li><?php echo $profile_user['family']; ?></li>
					<?php } ?>
					<?php if($security['priv_issues_close_to_heart']){ ?>
					<li>Issues close at heart :</li>
					<li><?php echo $profile_user['issues_close_at_heart']; ?></li>
					<?php } ?>
					<?php if($security['priv_news_stream']){ ?>
					<li>News Stream :</li>
					<li>News Stream</li>
					<?php } ?>
					<?php if($security['priv_photographs']){ ?>
					<li>Photographs :</li>
					<li class="imgGal img_gallery">Photographs</li>
					<?php } ?>
					<?php if($security['priv_movies']){ ?>
					<li>Videos :</li>
					<li class="imgGal video_gallery">Videos</li>
					<?php } ?>
					<?php if($security['priv_contacts']){ ?>
					<li>Contacts :</li>
					<li>Contacts</li>
					<?php } ?>
					<?php if($security['priv_i_Author']){ ?>
					<li>I, Author :</li>
					<li>I, Author</li>
					<?php } ?>
					<?php if($security['priv_recommend']){ ?>
					<li>Recommend :</li>
					<li>Recommend</li>
					<?php } ?>
				</ul>
			</div>
			
			
			
			
			
			
			
		</div>-->
				
				
				
		</div>

		<div id="contentRight">
		
		 <?php require_once 'common/right_side_navigation.php'; ?>
		
		</div>
	<div class="gallerybg">
 <a class="galleryClose"><img src="resource/images/closebt.png" alt="" /></a>
 <div class="gallerytitle">Select an Image</div>
     
 <div class="gallerybox">
  <div class="galleryboxscroll">
  	<div id="img_gallery">
    <?php 
	$user_id = $_REQUEST['user_id'];
   	  $url = SERVICE_NAME.'editprofile_service.php';	  
	  $data['user_id'] = $_REQUEST['user_id'];
	  $data['getgalleryuser_id'] = 1;
      $init_process_obj->getUserGallery($url,$data);	  
	  if($init_process_obj->response != 1){
	  	
		$gallery_arr = 	$ObjJSON->decode($init_process_obj->response);
		
		foreach($gallery_arr as $k => $v){
			$gallery_arr[$k] = $ObjJSON->objectToArray($ObjJSON->decode($v));
		}
		/*echo '<pre />';
		print_r($gallery_arr);*/
		$html = '';
		$grp_name = '';
		$basePath = IMAGE_UPLOAD_SERVER . $user_id;
		$g = 0;
		sort($gallery_arr);
		foreach($gallery_arr as $k => $arr1 ){
			$g = $g + 1;
			$group_name = explode('_',$arr1['igallery_name']);
			
			if(sizeof($group_name) == 1){
				$temp = 'Individual Photos';
			}else{
				$temp = $group_name[0];
			}
			
			if(!$k){
				$html .= "<div class='galleryinnertitle'><div>" . $temp . "</div><div class='arrow_up'></div></div><div class='clear'></div><div class='img_holder active_accordian active_accrodion'>";
			}elseif($grp_name == '' || $group_name[0] != $grp_name){
				$g = 0;
				$html .= "<div class='clear'></div></div><div class='galleryinnertitle'><div>" . $temp . "</div><div class='arrow_down'></div></div><div class='clear'></div><div class='img_holder'>";
			}
			if(is_numeric($group_name[0])){
				$imgPath = $basePath . '/' . '/thumb/'.$arr1['image_name'];
				$original_img_path = $basePath . '/' . '/'.$arr1['image_name'];
			}elseif(isset($arr1['image_name'])){
				$imgPath = $basePath . '/' . $arr1['igallery_name'] . '/thumb/'.$arr1['image_name'];
				$original_img_path = $basePath . '/' . $arr1['igallery_name'] . '/'.$arr1['image_name'];
			}else{
				$imgPath = 'resource/images/profile-img1.jpg';
			}
			
			//$html .= "<div class='imgbox'><a href=\"javascript: setID('".$arr1['image_id']."', '".urldecode($imgPath)."')\" ><img src='".$imgPath."' alt='' border='0' /></a></div>";
			
			$html .= "<div class='imgbox'><a onclick=\"window.open('".urldecode($original_img_path)."')\" ><img src='".$imgPath."' alt='' border='0' /></a></div>";
			
			$grp_name = $group_name[0];
		}
		echo $html."<div class='clear'></div></div>";
	  }
      ?>
	  </div> 
	  <div id="video_gallery" class="galleryboxscroll">
		<?php
			  $data = array();
			  $user_id = $_REQUEST['user_id'];
			  $url = SERVICE_NAME.'editprofile_service.php';	  
			  $data['user_id'] = $_REQUEST['user_id'];
			  $data['getUservideoGallery'] = 1;
			  $init_process_obj->getUserGallery($url,$data);	  
			  if($init_process_obj->response != 1){
				$gallery_arr = 	$ObjJSON->decode($init_process_obj->response);
				foreach($gallery_arr as $k => $v){
					$gallery_arr[$k] = $ObjJSON->objectToArray($ObjJSON->decode($v));
				}
				/*echo '<pre />';
				print_r($gallery_arr);*/
				
				$html = '';
				$grp_name = '';
				$basePath = VIDEO_UPLOAD_SERVER . $user_id;
				//echo $basePath;
				$g = 0;
				sort($gallery_arr);
				foreach($gallery_arr as $k => $arr1 ){
					$g = $g + 1;
					$group_name = explode('_',$arr1['vgallery_name']);
					//print_r($group_name);
					if(sizeof($group_name) == 1){
						$temp = 'Individual Videos';
					}else{
						$temp = $group_name[0];
					}
					
					if(!$k){
						$html .= "<div class='galleryinnertitle'><div>" . $temp . "</div><div class='arrow_up'></div></div><div class='clear'></div><div class='img_holder active_accordian active_accrodion'>";
					}elseif($grp_name == '' || $group_name[0] != $grp_name){
						$g = 0;
						$html .= "<div class='clear'></div></div><div class='galleryinnertitle'><div>" . $temp . "</div><div class='arrow_down'></div></div><div class='clear'></div><div class='img_holder'>";
					}
					if(is_numeric($group_name[0])){
						$videoPath = $basePath . '/' . '/thumb/'.str_replace('.flv','.jpg',$arr1['video_name']);
						$flvPath = $basePath . '/' . '/'.$arr1['video_name'];//.":".$_REQUEST['user_id'];
					}elseif(isset($arr1['video_name'])){
						$videoPath = $basePath . '/' . $arr1['vgallery_name'] . '/thumb/'.str_replace('.flv','.jpg',$arr1['video_name']);
						$flvPath = $basePath . '/' . $arr1['vgallery_name'] . '/'.$arr1['video_name'];//.":".$_REQUEST['user_id'];
					}else{
						$videoPath = 'resource/images/profile-img1.jpg';
					}
					/*echo str_replace('.flv','.jpg','test.flv');
					echo $videoPath;*/
					
					$html .= "<div class='imgbox'><a target=\"_blank\" href=\"video_player.php?file=".$flvPath."\" ><img src='".$videoPath."' alt='' border='0' /></a></div>";
					
					$grp_name = $group_name[0];
				}
				echo $html."<div class='clear'></div></div>";
				
			  }
		?>	  
	</div>
		
  </div>
 </div>
</div>		
<div id="backgroundPopup"></div>
	
<?php 
	
	require_once 'common/footer1.php'; 
?>