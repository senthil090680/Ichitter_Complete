<?php
	require_once 'lib/include_files.php';
	
	if(isset($_REQUEST['logout']) && $_REQUEST['logout'] == 'OK'){
		$session_obj->unset_Session('login');	
		
		echo "<script>window.location = 'index.php'</script>";
	}

	if($session_obj->get_Session('login') == 'false'){

		echo "<script>window.location = 'index.php'</script>";
	}
	$data = array('action'=>'get_user_record','user_id'=>$_REQUEST['user_id'],'session_user_id'=>SESS_USER_ID);	
	$data += $REQ_SEND;
	$init_process_obj = new INIT_PROCESS(REGISTRATION_SERVICE,$data);
	$profile_user = (array)($ObjJSON->decode($init_process_obj->response));
	
	/*echo '<pre />';
	print_r($profile_user);*/
	
	 if(isset($profile_user['image_name']) && trim($profile_user['image_name']) != ''){
	  $profile_img = IMAGE_UPLOAD_SERVER. $profile_user['user_id'] ."/". $profile_user['igallery_name'] ."/thumb/". $profile_user['image_name'];
	 }elseif($profile_user['gender'] == 'm'){
	  $profile_img = "resource/images/male-small.jpg";
	 }elseif($profile_user['gender'] == 'f'){
	  $profile_img = "resource/images/female-small.jpg";
	 }else{
	  $profile_img = "resource/images/paula-jones.jpg";
	 }
	 $user_name = $profile_user['first_Name']." ".$profile_user['last_Name'];
	 
	//get already requested or not
	$data = array('action'=>'get_req_status','user_id'=>$_REQUEST['user_id'],'session_user_id'=>SESS_USER_ID);	
	$init_process_obj = new INIT_PROCESS(REQ_SERVICE,$data);
	$req_flag = (array)($ObjJSON->decode($init_process_obj->response));	
	$req_flag = $req_flag['total'];
	
	//echo $req_flag;
	
	$data = array('action'=>'get_deny_status','user_id'=>SESS_USER_ID);	
	$init_process_obj = new INIT_PROCESS(REQ_SERVICE,$data);
	$deny_flag = $ObjJSON->objectToArray($ObjJSON->decode($init_process_obj->response));	
	$deny_flag = $deny_flag['deny_flag'];
	
	require_once 'common/header1.php';
	
	$user_id = SESS_USER_ID;
	if($count_unread_news['total'] > 0 && isset($_GET['user_id'])){
		$data = array('action'=>'update_read','read_user_id'=>$user_id,'news_user_id'=>$_GET['user_id']);
		$init_process_obj = new INIT_PROCESS(NEWS_SERVICE,$data);
		//echo $init_process_obj->response;
	}
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
		
		$('#profile_list tr:nth-child(even)').addClass('coltwo');
	});
</script>
		<div id="contentLeft">
			<div id="leftmenulist">	
					<?php include ('common/side_navigation.php');?>
			</div>	
			<div id="mainupload">	
			<div class="profileHeading profileHeading_bg">
				<div style="float:left">
				<?php 
					/*echo '<pre />';
					print_r($profile_user);*/
					if($profile_user['pub_name'] && $profile_user['innercircle'] == 0){ 
						echo ucfirst($profile_user['name']);  
					}elseif($profile_user['priv_name'] && $profile_user['innercircle'] != 0){ 
						echo ucfirst($profile_user['name']);  
					}
				?>
				Profile</div>
				<?php if(isset($_REQUEST['preview_from'])){ ?>
					<div class="right_side_btn">
						<a href="javascript:void(0);">
							<img border="0" src="resource/images/confirm_small.png" onclick="req_confirm(this,<?php echo $_SESSION['login']['user_id'].','.$_REQUEST['user_id']; ?>,'confirm')">
						</a>	
						<?php if(!$deny_flag){ ?>											
						<a href="javascript:void(0);">
							<img border="0" src="resource/images/notnow_small.png" onclick="req_confirm(this,<?php echo $_SESSION['login']['user_id'].','.$_REQUEST['user_id']; ?>,'deny')">
						</a>
						<?php }else{ ?>
						<div style="float:left;margin-top:3px;color:#285F74" class="after_success"><?php echo DENIED; ?></div>
						<?php } ?>
					</div>
				<?php 
					}elseif(!isset($profile_user['innercircle']) || ($profile_user['innercircle'] == 0 && $req_flag)){ ?>					
						<div class="right_side_btn" style="width:170px;text-align:center;font-size:12px;color:#285F74;margin-top:3px;"><?php echo SENT_REQUEST; ?></div>
				<?php		}elseif(isset($_REQUEST['user_id'])){ 
						
						if(!$_REQUEST['flag']  && !$req_flag && $profile_user['innercircle'] == 0 && SESS_USER_ID != $_REQUEST['user_id']){
				?>
					<div class="right_side_btn">
						<a style="height:22px;" href="javascript:void(0);">
					<div class="profile_view_btns" onclick="addfriend(this,'<?php echo SESS_USER_ID.":".$_REQUEST['user_id']; ?>')" >						
							<img src="resource/images/add-friend.png" />
					</div>
					</a>
					</div>
				<?php }elseif($_REQUEST['flag'] == 1){ ?>
					<div style="width:250px;text-align:center;font-size:12px;float:right;"><?php echo ALREADY_SENT; ?></div>
				<?php	}
					}
				?>
			</div>
			<?php if($profile_user['innercircle'] == 0){ ?>			
			<table  border="0" cellpadding="0" cellspacing="0" id="profile_list" style="width:537px;">
			<tr>
				<td colspan="3" style="background-color:#E4F3FC">
					<table cellpadding="3" cellspacing="3" border="0" style="padding-bottom:4px;">
						<tr>
							<td>
								<img src="<?php echo $profile_img; ?>" />
							</td>
							<td width="300">
							<table cellpadding="0" cellspacing="0" border="0">
							<?php if($profile_user['pub_name']){ ?>
							  <tr class="" >
								<td width="86"  class="proname">Name </td>
								<td width="10" >:</td>
								<td width="172"  class="proname"><strong><?php echo ucfirst($profile_user['first_Name']).' '.ucfirst($profile_user['last_Name']); ?></strong></td>
							  </tr>
							  <?php } ?>
							  <?php if($profile_user['pub_place']){ ?>
							  <tr class="" >
								<td width="86"  class="proname">Place </td>
								<td width="10" >:</td>
								<td width="172"  class="proname"><?php echo $profile_user['state_name']; ?></td>
							  </tr>
							  <?php } ?>
							  
							  <?php if($profile_user['pub_status']){ ?>
							  <tr bgcolor="#e4f3fc"  class="">
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
								<?php if($profile_user['pub_photographs']){ ?>
								<div class="imgGal img_gallery" >
									<img src="resource/images/view-photos.png" />
								</div>
								 <?php } ?>	
								  <?php if($profile_user['pub_movies']){ ?>
								 <div class="imgGal video_gallery" >
								 <img src="resource/images/view-videos.png" />
								 </div>
								 <?php } ?>	
								 
								 <?php if($profile_user['pub_contacts']){ ?>
									<a href="javascript:void(0)">
									<div class="contact_gallery" onclick="window.location = 'profilecontacts.php?user_id=<?php echo $_REQUEST['user_id']; ?>'" >
									<img src="resource/images/view-contacts.png" />
									</div>
									</a>
								 <?php } ?>	
								 
								
								
								<?php if($profile_user['pub_news_stream']){ ?>	
								<div>							  
									<img src="resource/images/newstream.png" />
								</div>
								<?php } ?>
								<?php /*if(isset($_REQUEST['preview_from'])){ ?>
								<div class="right_side_btn">
								<a href="javascript:void(0);">
									<img border="0" src="resource/images/bt-confirm.png" onclick="req_confirm(this,<?php echo $_SESSION['login']['user_id'].','.$_REQUEST['user_id']; ?>,'confirm')">
								</a>
								
								<a href="javascript:void(0);">
									<img border="0" src="resource/images/bt-notconfirm.png" onclick="req_confirm(this,<?php echo $_SESSION['login']['user_id'].','.$_REQUEST['user_id'];; ?>,'deny')">
								</a>
								</div>
								<?php }*/ ?>
							
								
							</td>
						</tr>
					</table>
				</td>
			</tr>
  
 <?php if($profile_user['pub_profession']){ ?>
  <tr bgcolor="#e4f3fc"  class="">
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
 <?php if($profile_user['pub_interest']){ ?>
  <tr bgcolor="#e4f3fc"  class="">
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
  <tr bgcolor="#e4f3fc"  class="">
   <td class="procent">Professional Background </td>
   <td>:</td>
   <td width="316" class="proname"><?php echo $profile_user['professional_background']; ?></td>
 </tr>
 <?php if($profile_user['pub_education']){ ?>
  <tr bgcolor="#e4f3fc"  class="proht">
   <td class="proname">Education </td>
   <td>:</td>
   <td width="316" class="proname"><?php echo $profile_user['college']; ?></td>
 </tr>
 <?php } ?>
 <?php if($profile_user['pub_career']){ ?>				
  <tr bgcolor="#e4f3fc"  class="">
   <td class="procent">Career </td>
   <td>:</td>
   <td width="316" class="proname"><?php echo $profile_user['career']; ?></td>
 </tr>
 <?php } ?>
 <?php if($profile_user['pub_poltifical_affiliation']){ ?>	
 <tr bgcolor="#e4f3fc"  class="proht">
   <td class="procent">Political Affiliation </td>
   <td>:</td>
   <td width="316" class="proname"><?php echo $profile_user['political_affiliation']; ?></td>
 </tr>
<?php } ?>
<?php if($profile_user['pub_active_involment']){ ?>
  <tr bgcolor="#e4f3fc"  class="">
   <td class="procent">Active Involment</td>
   <td>:</td>
   <td width="316" class="proname"><?php echo $profile_user['active_involment']; ?></td>
 </tr>
 <?php } ?>
 
 <?php if($profile_user['pub_hobbies']){ ?>
 <tr bgcolor="#e4f3fc"  class="proht">
   <td class="procent">Hobbies</td>
   <td>:</td>
   <td width="316" class="proname"><?php echo $profile_user['hobbies']; ?></td>
 </tr>
 <?php } ?>
 <?php if($profile_user['pub_family']){ ?>
  <tr bgcolor="#e4f3fc"  class="">
   <td class="procent">Family</td>
   <td>:</td>
   <td width="316" class="proname"><?php echo $profile_user['family']; ?></td>
 </tr>
 <?php } ?>
 <?php if($profile_user['pub_issues_close_to_heart']){ ?>
 <tr bgcolor="#e4f3fc"  class="proht">
   <td class="procent">Issues close at heart</td>
   <td>:</td>
   <td width="316" class="proname"><?php echo $profile_user['issues_close_at_heart']; ?></td>
 </tr>
 <?php } ?>

 
 
 
  <?php if($profile_user['pub_i_Author']){ ?>
  <tr bgcolor="#e4f3fc"  class="">
   <td class="procent">I, Author</td>
   <td>:</td>
   <td width="316" class="proname">I, Author</td>
 </tr>
 <?php } ?>	
  <?php /*if($profile_user['pub_recommend']){ ?>
 <tr bgcolor="#e4f3fc"  class="proht">
   <td class="procent">Recommend</td>
   <td>:</td>
   <td width="316" class="proname">Recommend</td>
 </tr>
 <?php }*/ ?>
</table>

			<?php }else{ ?>
			<table  border="0" cellpadding="0" cellspacing="0" id="profile_list" style="width:544px;">
			<tr>
				<td colspan="3" style="background-color:#E4F3FC">
					<table cellpadding="3" cellspacing="3" border="0" style="padding-bottom:4px;">
						<tr>
							<td>
								<img src="<?php echo $profile_img; ?>" />
							</td>
							<td width="300">
							<table cellpadding="0" cellspacing="0" border="0">
								<?php if($profile_user['priv_name']){ ?>
							  <tr class="" >
								<td width="86" class="pronamebld">Name </td>
								<td width="10" >:</td>
								<td width="187 "  class="proname"><?php echo ucfirst($profile_user['first_Name']).' '.ucfirst($profile_user['last_Name']); ?></td>
							  </tr>
							  <?php } ?>
							  <?php if($profile_user['priv_place']){ ?>
							  <tr class="" >
								<td width="86"  class="pronamebld">Place </td>
								<td width="10" >:</td>
								<td width="187"  class="proname"><?php echo $profile_user['state_name']; ?></td>
							  </tr>
							  <?php } ?>
							  <?php if($profile_user['priv_status']){ ?>
							  <tr bgcolor="#e4f3fc"  class="">
								 <td width="86" class="pronamebld">Status </td>
								<td>:</td>
								  <td width="187"  class="proname"><?php echo $profile_user['status']; ?></td>
							  </tr>
							  <?php } ?>
							  <tr bgcolor="#e4f3fc"  class="proht">
							   <td width="86" class="pronamebld">Email </td>
							   <td>:</td>
								 <td width="187" class="proname"><?php echo $profile_user['email']; ?></td>
							 </tr>
							 </table>
							</td>
							<td id="profile_views">
								<?php if($profile_user['priv_photographs']){ ?>
								<div class="imgGal img_gallery" >
									<img src="resource/images/view-photos.png" />
								</div>
								 <?php } ?>	
								  <?php if($profile_user['priv_movies']){ ?>
								 <div class="imgGal video_gallery" >
								 <img src="resource/images/view-videos.png" />
								 </div>
								 <?php } ?>	
								 
								 <?php if($profile_user['priv_contacts']){ ?>
									<div class="contact_gallery" onclick="window.location = 'profilecontacts.php?user_id=<?php echo $_REQUEST['user_id']; ?>'" >
									<img src="resource/images/view-contacts.png" />
									</div>
								 <?php } ?>	
								 
								
								
								<?php if($profile_user['priv_news_stream']){ ?>	
								<div onclick="window.location = 'news.php?user_id=<?php echo $_REQUEST['user_id']; ?>'">							  
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
  
 <?php if($profile_user['priv_profession']){ ?>
  <tr bgcolor="#e4f3fc"  class="">
  <td class="procentbld" width="182">Profession </td>
   <td width="10">:</td>
      <td width="316" class="proname"><?php echo $profile_user['profession']; ?></td>
  </tr>
  <?php } ?>
  <tr bgcolor="#e4f3fc"  class="proht">
     <td class="procentbld">Personal Data </td>
   <td>:</td>
   <td width="316" class="proname"><?php echo $profile_user['personal_data']; ?></td>
 </tr>
 <?php if($profile_user['priv_interest']){ ?>
  <tr bgcolor="#e4f3fc"  class="">
   <td class="procentbld">Interests</td>
   <td>:</td>
   <td width="316" class="proname"><?php echo $profile_user['interests']; ?></td>
  </tr>
  <?php } ?>
  <tr bgcolor="#e4f3fc"  class="proht">
     <td class="procentbld">Favorites </td>
   <td>:</td>
   <td width="316" class="proname"><?php echo $profile_user['favorites']; ?></td>
 </tr>
  <tr bgcolor="#e4f3fc"  class="">
   <td class="procentbld">Professional Background </td>
   <td>:</td>
   <td width="316" class="proname"><?php echo $profile_user['professional_background']; ?></td>
 </tr>
 <?php if($profile_user['priv_education']){ ?>
  <tr bgcolor="#e4f3fc"  class="proht">
   <td class="procentbld">Education </td>
   <td>:</td>
   <td width="316" class="proname"><?php echo $profile_user['college']; ?></td>
 </tr>
 <?php } ?>
 <?php if($profile_user['priv_career']){ ?>				
  <tr bgcolor="#e4f3fc"  class="">
   <td class="procentbld">Career </td>
   <td>:</td>
   <td width="316" class="proname"><?php echo $profile_user['career']; ?></td>
 </tr>
 <?php } ?>
 <?php if($profile_user['priv_poltifical_affiliation']){ ?>	
 <tr bgcolor="#e4f3fc"  class="proht">
   <td class="procentbld">Political Affiliation </td>
   <td>:</td>
   <td width="316" class="proname"><?php echo $profile_user['political_affiliation']; ?></td>
 </tr>
<?php } ?>
<?php if($profile_user['priv_active_involment']){ ?>
  <tr bgcolor="#e4f3fc"  class="">
   <td class="procentbld">Active Involment</td>
   <td>:</td>
   <td width="316" class="proname"><?php echo $profile_user['active_involment']; ?></td>
 </tr>
 <?php } ?>
 
 <?php if($profile_user['priv_hobbies']){ ?>
 <tr bgcolor="#e4f3fc"  class="proht">
   <td class="procentbld">Hobbies</td>
   <td>:</td>
   <td width="316" class="proname"><?php echo $profile_user['hobbies']; ?></td>
 </tr>
 <?php } ?>
 <?php if($profile_user['priv_family']){ ?>
  <tr bgcolor="#e4f3fc"  class="">
   <td class="procentbld">Family</td>
   <td>:</td>
   <td width="316" class="proname"><?php echo $profile_user['family']; ?></td>
 </tr>
 <?php } ?>
 <?php if($profile_user['priv_issues_close_to_heart']){ ?>
 <tr bgcolor="#e4f3fc"  class="proht">
   <td class="procentbld">Issues close at heart</td>
   <td>:</td>
   <td width="316" class="proname"><?php echo $profile_user['issues_close_at_heart']; ?></td>
 </tr>
 <?php } ?>

 
 
 
  <?php if($profile_user['priv_i_Author']){ ?>
  <tr bgcolor="#e4f3fc"  class="">
   <td class="procentbld">I, Author</td>
   <td>:</td>
   <td width="316" class="proname">I, Author</td>
 </tr>
 <?php } ?>	
  <?php /*if($profile_user['priv_recommend']){ ?>
 <tr bgcolor="#e4f3fc"  class="proht">
   <td class="procent">Recommend</td>
   <td>:</td>
   <td width="316" class="proname">Recommend</td>
 </tr>
 <?php }*/ ?>
</table>
			<?php } ?>
		</div>	
		 
				
				
				
		</div>

		<div id="contentRight">
		
		 <?php require_once 'common/right_side_navigation.php'; ?>
		
		</div>
	<div class="gallerybg">
 <a class="galleryClose"><img src="resource/images/closebt.png" alt="" /></a>
 <div class="gallerytitle">View an Image</div>
     
 <div class="gallerybox">
  <div class="galleryboxscroll">
  	<div id="img_gallery">
    <?php 
	$user_id = $_REQUEST['user_id'];
   	  $url = EDITPROFILE_SERVICE;	  
	  $REQ_SEND['user_id'] = $_REQUEST['user_id'];
	  $REQ_SEND['action'] = 'getgalleryuser_id';
      $init_process_obj->getUserGallery($url,$REQ_SEND);	  
	  if($init_process_obj->response != 1){
	  	
		$gallery_arr = 	$ObjJSON->decode($init_process_obj->response);
		if(sizeof($gallery_arr)){
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
		}else{
			echo $html."<div style='text-align:center;'>".NO_PHOTO."</div><div class='clear'></div></div>";
		}
	  }
      ?>
	  </div> 
	  <div id="video_gallery" class="galleryboxscroll">
		<?php
			
			  $data = array();
			  $user_id = $_REQUEST['user_id'];
			  $url = EDITPROFILE_SERVICE;	  
			  $REQ_SEND['user_id'] = $_REQUEST['user_id'];
			  $REQ_SEND['action'] = 'getUservideoGallery';
			 
			  $init_process_obj = new INIT_PROCESS($url,$REQ_SEND);	
				//echo $init_process_obj->response;
			  if($init_process_obj->response != 1){
				
				$gallery_arr = 	$ObjJSON->decode($init_process_obj->response);
				
				$html = '';
				if(sizeof($gallery_arr)){
				foreach($gallery_arr as $k => $v){
					$gallery_arr[$k] = (array)($ObjJSON->decode($v));
				}
				/*echo '<pre />';
				print_r($gallery_arr);*/
				
				
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
				}else{
			echo $html."<div style='text-align:center;'>".NO_VIDEO."</div><div class='clear'></div></div>";
		}
				
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