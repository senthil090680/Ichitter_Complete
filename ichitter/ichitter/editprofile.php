<?php
	require_once 'lib/include_files.php';
	/*echo "<pre>";
	print_r($_SESSION);
	echo "</pre>";*/
	if(isset($_REQUEST['logout']) && $_REQUEST['logout'] == 'OK'){
		$session_obj->unset_Session('login');			
		echo "<script>window.location = 'index.php'</script>";
	}
	
	if($session_obj->get_Session('login') == 'false'){	
		echo "<script>window.location = 'index.php'</script>";
	}
	$data = array('action'=>'get_user_record','user_id'=>SESS_USER_ID);	
	$data = $REQ_SEND + $data;
	$init_process_obj = new INIT_PROCESS(SERVICE_NAME.'registration_service.php',$data);
	$user_data = (array)($ObjJSON->decode($init_process_obj->response));
	$basic_details = $user_data;
	/*echo '<pre />';
	print_r($user_data);*/
	if(isset($user_data['image_name']) && trim($user_data['image_name']) != ''){
		
		if(isset($user_data['igallery_name'])){
			$profile_img = IMAGE_UPLOAD_SERVER. $user_data['user_id'] ."/". $user_data['igallery_name'] ."/". $user_data['image_name'];
		}else{
			$profile_img = IMAGE_UPLOAD_SERVER. $user_data['user_id'] ."/". $user_data['image_name'];
		}
	}else{
		if($user_data['gender'] == 'm'){
			$profile_img = "resource/images/male-small.jpg";
		}elseif($user_data['gender'] == 'f'){
			$profile_img = "resource/images/female-small.jpg";
		}
	}
	
	/*$data = array('get_states'=>1);	
	$init_process_obj = new INIT_PROCESS(SERVICE_NAME.'registration_service.php',$data);
	$states = $ObjJSON->objectToArray($ObjJSON->decode($init_process_obj->response));
	
	$data = array('get_gender'=>1);	
	$init_process_obj = new INIT_PROCESS(SERVICE_NAME.'registration_service.php',$data);
	$gender = $ObjJSON->objectToArray($ObjJSON->decode($init_process_obj->response));*/
	
	$data = array('action'=>'get_form_dropdown');	
	$data = $REQ_SEND + $data;
	$init_process_obj = new INIT_PROCESS(REGISTRATION_SERVICE,$data);
	$dropdown = (array)$ObjJSON->decode($init_process_obj->response);
     extract($dropdown);
	
	require_once 'common/header1.php';
?>
<link rel="stylesheet" href='resource/css/gallery.css' type="text/css" />
<!--<script src="resource/js/jquery-1.7.min.js" type="text/javascript"></script>-->
<script src="resource/js/popup-gallery.js" type="text/javascript"></script>
<script type="text/javascript" src="resource/js/ajaxfileupload.js"></script>
<script>
	$(document).ready(function(){
		/*var txt_loc = $.trim($('#txt_location').text());
		$('[name=location]').val(txt_loc);*/
		
		$('.profiletdtxt2 span').hover(function(){
			var txt = $(this).attr('for');
			$('#tool_tip').text(txt);
			
			var t = $(this).offset().top - $('#tool_tip').height() - 15 +'px';
			var l = $(this).offset().left+'px';
			$('#tool_tip').css({top : t,left : l}).show();
		},function(){
			$('#tool_tip').hide();
		});
		
		var txt_status = $.trim($('#txt_status').text());
		$('[name=status]').val(txt_status);
	
		$('.profileinfo a').click(function(e){	
			if($(this).hasClass('edit_btn')){
				$(this).removeClass('edit_btn').addClass('save_btn');
				var txt = $.trim($(this).next().text());
				$(this).next().addClass('profileinfo_highlight').html('<textarea id="cont_edit"></textarea>');
				$(this).next().find('textarea').focus().text(txt);				
			}else{				
				
				var txt = $.trim($('#cont_edit').val());	
				var url = 'editprofile_process.php';
				//var data = [];
				
				var field_name = $.trim($(this).attr('id'));				
				var data = "action=profile&"+field_name+"="+txt;
				$result = ajax_function(url,data);
				$result = $.parseJSON($result);
				 if($result.success){
				 	alert('Your '+$(this).prev().text()+' saved successfully');
				 }else{
				 	alert('else');
				 }
				$('#cont_edit').remove();
				$(this).next().removeClass('profileinfo_highlight').html('<div>'+txt+'</div>');
				$(this).removeClass('save_btn').addClass('edit_btn');
			}
			
		});
		
		$('#important_details').click(function(){
			if($(this).hasClass('edit_btn')){
				$('.profiletdtxt2').hide();
				$('.selectprofile').show();
				$('#issues_close_at_heart').parent().addClass('profileinfo_highlight');
				$('#issues_close_at_heart').show();
				$(this).removeClass('edit_btn').addClass('save_btn');
			}else{
				var txt_first_Name = $.trim($('#pro_firstname').val());
				var txt_last_Name = $.trim($('#pro_lastname').val());	
				var gender = 	$.trim($('[name=gender]').val());
				var place = $.trim($('[name=location]').val());
				
				if(txt_first_Name == ''){
					alert('Please enter First Name');
					return false;
				}else if(txt_last_Name == ''){
					alert('Please enter Last Name');
					return false;
				}else if(gender == '*'){
					alert('Please change the gender');
					return false;
				}else if(place == '*'){
					alert('Please change the place');
					return false;
				}
				
				  var url = 'editprofile_process.php';
				  var test = $.ajax({		 
					   url: url,
					   data: $('#profile_important').serialize(),
					   async: false,
					   dataType: "json"
				  }).responseText;
				  
				 var result = $.parseJSON(test);
				 
				 if(result.success){
				 	$('.selectprofile :input').each(function(){						
						if($(this)[0].tagName == "SELECT"){
							$(this).parent().prev().text($(this).find('option:selected').text());
						}else{						
							$(this).parent().prev().text($(this).val());
						}
					});
					
					$('#issues_close_at_heart').prev().text($('#issues_close_at_heart').val());
				 	$('.profiletdtxt2').show();
					$('.selectprofile').hide();
					$('#issues_close_at_heart').parent().removeClass('profileinfo_highlight');
					$('#issues_close_at_heart').hide();
					
				 }
				 
				 $(this).removeClass('save_btn').addClass('edit_btn');

			}
		});
		
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
	function toggleSelections(ipt) {
	if(ipt == 'I') {
		$('#divvdo :input').attr('disabled', true);
        $('#divimg :input').removeAttr('disabled');	        
	}
	if(ipt == 'V') {
		$('#divimg :input').attr('disabled', true);
        $('#divvdo :input').removeAttr('disabled');
	}
}

function ajaxFileUpload(){
		$("#loading")
		.ajaxStart(function(){
			$(this).show();
		})
		.ajaxComplete(function(){
			$(this).hide();
		});
         var fl_name = $('#fileToUpload').val();		 
		 var extn = fl_name.substring(fl_name.lastIndexOf('.') + 1);
		 
		if(extn == "gif" || extn == "GIF" || extn == "JPEG" || extn == "jpeg" || extn == "jpg" || extn == "JPG"){
          <?php $user_id = $session_obj->get_Session('user_id'); ?>                 
                $.ajaxFileUpload({
					url:'upload_process.php',
					secureuri:false,
					fileElementId:'fileToUpload',
					dataType: 'post',
					data:{"whr":"editprofile","gallery":"0","user_id":"<?php echo $user_id; ?>"},
					async: false,
					success: function (data){
						var json = $.parseJSON(data);
						if($.isNumeric(json.success.id)){
							var obj = $('.galleryinnertitle > div:contains("Individual Photos")');
							var txt = $.trim(obj.text());
							var img_path = '<?php echo IMAGE_UPLOAD_SERVER.$user_id ?>/'+json.success.img_name;
							var thumb_path = '<?php echo IMAGE_UPLOAD_SERVER.$user_id ?>/thumb/'+json.success.img_name;
							var id = json.success.id;
							
							var html = "<div class='imgbox'><a href=\"javascript: setID('"+id+"', '"+img_path+"')\" ><img src='"+thumb_path+"' alt='' border='0' /></a></div>";
							
							if(txt == ""){
								//alert($('.galleryboxscroll div').text());
								var temp = '<div class="galleryinnertitle"><div>Individual Photos</div><div class="arrow_up"></div></div><div class="clear"></div><div class="img_holder active_accordian active_accrodion">'+html+'</div>';
								$('.galleryboxscroll').append(temp);
								
							}else{							
								
								obj.parent().next().next().find('.clear').before(html);
							}
							if($('.galleryboxscroll div:first-child').next().next().css('display') != 'block'){
								$('.active_accrodion').slideUp();
								$('.galleryinnertitle div:last-child').removeClass('arrow_up').addClass('arrow_down');
								$('.galleryboxscroll div').removeClass('active_accrodion');
								$('.galleryboxscroll div:first-child').next().next().addClass('active_accrodion');
								$('.galleryboxscroll div:first-child').next().next().slideDown();
								$('.galleryboxscroll div:first-child').find('div:last-child').addClass('arrow_up');
							}
						}
						
					}	
				});
		}else{
		 alert("Upload Gif or Jpg images only! Instead of "+fl_name);
		}
		return false;
	}

</script>
<style>
	.short_name{
		cursor:pointer;
	}

	#tool_tip{
			padding:5px;
			background-color:#3D86C3;
			color:#fff;
			border:2px solid #A5D9FF;
			position:absolute;	
			display:none;
			font-size:12px;
			/*	-moz-border-radius: 11px;
			-webkit-border-radius: 11px;
			border-radius: 11px;
			z-index:0;
			behavior:url(resource/css/ie-css3.htc);	*/
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
	
	
</style>
<div id="tool_tip"></div>	
	<div id="contentLeft">
			<div id="profile">
				<h3>My iChitter Profile</h3>
				<div id="profileContent">
					<div class="profileContentLeft">
						<div class="profileimg" id="imgGal">
							<div id="profilephotoedit">
								Change Photo
							</div>
							<img width="139" height="169" src="<?php echo $profile_img; ?>" />
							<!--<img src="resource/images/profile-img1.jpg" alt="" />-->
							
						</div>
						<!--<a href="#"><img class="updatebtn" src="resource/images/btn-update.png" alt="" border="0" /></a> -->
						<a id="important_details" class="edit_btn"><!--Edit--></a>
					</div>
					<div class="profileContentRight">
<form id="profile_important" method="post" name="profile_important">
<table width="271" border="0" cellspacing="1" cellpadding="1">

<tr class="profiletr"><td>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="texthg"><tr>
<td class="profiletdtxt">First Name :</td>
<td class="profiletdtxt3">
	<div class="profiletdtxt2">
		<?php if(strlen($user_data['first_Name']) > SHORT_WORD){ ?>
			<span class="short_name" for="<?php echo $user_data['first_Name'];  ?>"><?php echo $init_process_obj->limit_words($user_data['first_Name'],0,SHORT_WORD); ?></span>
		<?php }else{
				echo $user_data['first_Name']; 
			}
		?>
	</div>
	<div class="selectprofile">
	<input type="text" class="searchInputprof" name="first_Name" id="pro_firstname" value="<?php echo $user_data['first_Name']; ?>" size="20">
	</div>
</table>
</td></tr>

<tr class="profiletr"><td>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="texthg"><tr>
<td class="profiletdtxt">Last Name :</td>
<td class="profiletdtxt3">
	<div class="profiletdtxt2">
		<?php 
			if(strlen($user_data['last_Name']) > SHORT_WORD){
				
					?>
					
					
					<span class="short_name" for="<?php echo $user_data['last_Name'];  ?>"><?php echo $init_process_obj->limit_words($user_data['last_Name'],0,SHORT_WORD); ?></span>
					
			<?php
			}else{
				echo $user_data['last_Name']; 
			}
		?>
	</div>
	<div class="selectprofile">
	<input type="text" class="searchInputprof" name="last_Name" id="pro_lastname" value="<?php echo $user_data['last_Name']; ?>" size="20">
	</div>
</table></td></tr>

<tr class="profiletr">
<td style="padding-bottom:3px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="texthg"> <tr>
<td class="profiletdtxt">Gender :</td>
<td class="profiletdtxt3">
	<div class="profiletdtxt2">
		<?php 
			if($user_data['gender'] == 'm'){
				echo 'Male';
			}elseif($user_data['gender'] == 'f'){
				echo 'Female';
			}
		?>
	</div>
<div class="selectprofile">
	<select class="profileselectarea" name="gender">
		<option value="*">Select</option>
		
		<?php foreach($gender as $v){ ?>
			<option <?php echo ($user_data['gender'] == $v->gender_abbreviation) ? 'selected' : '' ?> value="<?php echo $v->gender_abbreviation ?>"><?php echo $v->gender_name; ?></option>		
		 <?php } ?>
		
		
		
	</select>
</div>
</table></td></tr>

<tr class="profiletr"><td>
<table width="100%" border="0" cellspacing="0" cellpadding="0"class="texthg">
<tr><td  class="profiletdtxt">Place :</td>
<td class="profiletdtxt3">
	<div id="txt_location" class="profiletdtxt2">
		<?php 
			foreach($states as $v){  
				if(trim($user_data['state']) == trim($v->state_abbreviation)){
					echo $v->state_name;
				}
			}
		?>
	</div>
	<div class="selectprofile">
	<select class="profileselectarea" name="state">
			<option value="*">Select</option>
			<?php 
				foreach($states as $v){  
					if(trim($user_data['state']) == trim($v->state_abbreviation)){
			?>
			<option selected="selected" value="<?php echo $v->state_abbreviation; ?>" >
				<?php echo $v->state_name; ?>
			</option>
			<?php }else{ ?>
			<option  value="<?php echo $v->state_abbreviation; ?>" >
				<?php echo $v->state_name; ?>
			</option>
			<?php } } ?>
		</select>
	</div>
</table></td></tr>



<tr class="profiletr"><td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="texthg">
<tr><td  class="profiletdtxt">Status :</td>
<td class="profiletdtxt3">
	<div id="txt_status" class="profiletdtxt2"><?php echo $user_data['status']; ?></div>
<div class="selectprofile">
<select class="profileselectarea" name="status">
		  <option>Online</option>
		  <option>Offline</option>
		</select>
</div>
</table></td></tr>

<tr class="profiletr"><td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="texthg"> <tr>
<td  class="profiletdtxt">Education :</td>
<td class="profiletdtxt3">
<div class="profiletdtxt2">
	<?php 
		//echo $user_data['college']; 
		if(strlen($user_data['college']) > SHORT_WORD){
			
				?>
					
					
					<span class="short_name" for="<?php echo $user_data['college'];  ?>"><?php echo $init_process_obj->limit_words($user_data['college'],0,SHORT_WORD); ?></span>
					
			<?php
		}else{
			echo $user_data['college']; 
		}
	?>
</div>
<div class="selectprofile">	
<input type="text" class="searchInputprof" name="college" id="" value="<?php echo $user_data['college']; ?>" size="20">
</div>
</table></td></tr>

</table>


<table width="270" border="0" cellspacing="1" cellpadding="1" class="texthg">
<tr class="profiletr">
	<td style="padding-bottom:3px;">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="texthg">
			<tr>
				<td  class="profiletdtxt">Profession :</td>
				<td class="profiletdtxt3">
					<div class="profiletdtxt2">
						<?php 
					if(strlen($user_data['profession']) > SHORT_WORD){
						
						
						?>
					
					
					<span class="short_name" for="<?php echo $user_data['profession'];  ?>"><?php echo $init_process_obj->limit_words($user_data['profession'],0,SHORT_WORD); ?></span>
					
			<?php
					}else{
						echo $user_data['profession']; 
					}
				?>
					</div>
					<div class="selectprofile">
						<input type="text" class="searchInputprof" name="profession" id="txttitle" value="<?php echo $user_data['profession']; ?>" size="20" />
					</div>
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr class="profiletr">
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td  class="profiletdtxt">Career :</td>
        <td class="profiletdtxt3">
			<div class="profiletdtxt2">
				<?php 					
					if(strlen($user_data['career']) > SHORT_WORD){
						
						?>
					
					
					<span class="short_name" for="<?php echo $user_data['career'];  ?>"><?php echo $init_process_obj->limit_words($user_data['career'],0,SHORT_WORD); ?></span>
					
			<?php
					}else{
						echo $user_data['career']; 
					}
				?>
			</div>
		<div class="selectprofile">

		<input type="text" class="searchInputprof" name="career" id="" value="<?php echo $user_data['career']; ?>" size="20">
		
		</div>
		
    </table></td>
  </tr>
  
  <tr class="profiletr">
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td  class="profiletdtxt">Political Affiliation :</td>
        <td class="profiletdtxt3">
		<div class="profiletdtxt2">
			<?php 
				if(strlen($user_data['political_affiliation']) > SHORT_WORD){
					
					
					?>
					
					
					<span class="short_name" for="<?php echo $user_data['political_affiliation'];  ?>"><?php echo $init_process_obj->limit_words($user_data['political_affiliation'],0,SHORT_WORD); ?></span>
					
			<?php
				}else{
					echo $user_data['political_affiliation']; 
				}
			?>
		</div>
		<div class="selectprofile">

		<input type="text" class="searchInputprof" name="political_affiliation" id="" value="<?php echo $user_data['political_affiliation']; ?>" size="20">
		
		</div>
		
    </table></td>
  </tr>




 
  <tr class="profiletr">
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="texthg">
      <tr>
        <td  class="profiletdtxt">Active involment :</td>
        <td class="profiletdtxt3">
		<div class="profiletdtxt2">
			<?php 
				if(strlen($user_data['active_involment']) > SHORT_WORD){ ?>
					
					
					<span class="short_name" for="<?php echo $user_data['active_involment'];  ?>"><?php echo $init_process_obj->limit_words($user_data['active_involment'],0,SHORT_WORD); ?></span>
					
			<?php }else{
					echo $user_data['active_involment']; 
				}
			?>
		</div>
		<div class="selectprofile">

		<input type="text" class="searchInputprof" name="active_involment" id="" value="<?php echo $user_data['active_involment']; ?>" size="20">
		
		</div>
		
    </table></td>
  </tr>
 <tr class="profiletr">
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="texthg">
      <tr>
        <td  class="profiletdtxt">Hobbies :</td>
        <td class="profiletdtxt3">
		<div class="profiletdtxt2">
			<?php //echo $user_data['hobbies']; ?>
			<?php if(strlen($user_data['hobbies']) > SHORT_WORD){ ?>			
				
				<span class="short_name" for="<?php echo $user_data['hobbies'];  ?>"><?php echo $init_process_obj->limit_words($user_data['hobbies'],0,SHORT_WORD); ?></span>
			<?php
				}else{
					echo $user_data['hobbies']; 
				}
			?>
		</div>
		<div class="selectprofile">

		<input type="text" class="searchInputprof" name="hobbies" id="" value="<?php echo $user_data['hobbies']; ?>" size="20">
		</div>
		
    </table></td>
  </tr>

	
  <tr class="profiletr">
   <td style="padding-bottom:3px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td  class="profiletdtxt">Family :</td>
        <td class="profiletdtxt3">
		<div class="profiletdtxt2"><?php echo $user_data['family']; ?></div>
		<div class="selectprofile">

		<input type="text" class="searchInputprof" name="family" id="" value="<?php echo $user_data['family']; ?>" size="20">
		</div>
		
    </table></td>
  </tr>
  
  
  
</table>



						
						<!--<div class="issues"><p>Issues close at heart</p></div>-->
						<div class="Issueshearts">
						<p>Issues close at heart</p>
						
						<div class="profileinfoTextbox">
						<div class="profiletdtxt2"><?php echo $user_data['issues_close_at_heart']; ?></div>
						
				
						<textarea id="issues_close_at_heart" name="issues_close_at_heart"><?php echo $user_data['issues_close_at_heart']; ?></textarea>
						
						
						</div>
						</div>
						<input type="hidden" name="action" value="profile_important" />
						</form>
					</div>
				</div>
			</div>		
			<div id="leftmenulist">	
				
					<?php require_once 'common/side_navigation.php'; ?>
					 
				
			</div>		
		  <div id="mainupload">	
			<div class="profileHeading">Profile</div>
			<!--<div id="profileGroupsContain">
			<div class="box"> 
			 <div class="grouptext">Groups</div>
			 <div class="boxformone">
				<select name=""  class="forminside1" style="border:0px;" multiple>
				  <option>UCI Rep.</option>
				  <option>OC T-Party</option>
				  <option>California coast</option>
				</select>
			  </div>
			 </div>
			 
			<div class="box"> 
				 <div class="discussionstext">Discussions</div>
					 <div class="boxformtwo">
					 <textarea name="text" class="forminside2" cols="" rows=""></textarea>
					 </div>
				 </div>
			</div>-->
			<?php   require_once('lib/group_header_include.php'); ?>
			<div class="profileinfo">
				<p>Basic Information</p>
				<a class="edit_btn" id="basic_info"><!--Edit--></a>
				<div class="profileinfoTextbox">
					<div>
					<?php echo stripcslashes($basic_details['basic_info']); ?>
					</div>
				</div>
			</div>	
			
			<div class="profileinfo">
				<p>Personal Data</p>
				<a id="personal_data" class="edit_btn"><!--Edit--></a>
				<div class="profileinfoTextbox">
					<div>
					<?php echo stripcslashes($basic_details['personal_data']); ?>
					</div>
				</div>
			</div>
			
			<div class="profileinfo">
				<p>Interests</p>
				<a id="interests" class="edit_btn"><!--Edit--></a>
				<div class="profileinfoTextbox">
					<div>
					<?php echo stripcslashes($basic_details['interests']); ?>
					</div>
				</div>
			</div>
			
			<div class="profileinfo">
				<p>Professional background</p>
				<a id="professional_background" class="edit_btn"><!--Edit--></a>
				<div class="profileinfoTextbox">
					<div>
					<?php echo stripcslashes($basic_details['professional_background']); ?>
					</div>
				</div>
			</div>			
			<div class="profileinfo">
				<p>Favorites</p>
				<a id="favorites" class="edit_btn"><!--Edit--></a>
				<div class="profileinfoTextbox">
					<div>
					<?php echo stripcslashes($basic_details['favorites']); ?>				
					</div>
				</div>
			</div>
			
			<!--<a href="#"><img src="resource/images/btn-cancel.png" alt="" border="0" class="cancelbtn"/></a>
			<a href="#"><img src="resource/images/btn-save.png" alt="" border="0" class="savebtn" /></a>-->
		</div>
				
				
				
		</div>

		<div id="contentRight">
		
		 <?php require_once 'common/right_side_navigation.php'; ?>
			
		
		</div>
		<?php 
	$user_id = $session_obj->get_Session('user_id');
	
?>
<div class="gallerybg">
 <a class="galleryClose"><img src="resource/images/closebt.png" alt="" /></a>
 <div class="gallerytitle">Select an Image</div>
   <div style="clear: both;padding:5px;text-align:center;margin-bottom:5px;">
	 	<label style="font-weight:bold;float:left;margin-bottom:5px;">Upload Photos:</label>		
	 	<div style="clear:both;float:left;background-color:#A5D9FF;padding:10px;width:452px">
         <form name="form" action="" method="POST" enctype="multipart/form-data">
           <div style="float:left;">
            	<input id="fileToUpload" type="file" size="45" name="multiplefile[]" class="input" />
			</div>
			<div id="buttonUpload" onClick="return ajaxFileUpload();" class="input" style="float:left;margin-top:5px;">
				<a><span>Upload</span></a>
			</div>
          </form> 
		  </div>
		  <div id="loading" style="margin-top:10px;margin-left:2px; float:left;display:none"><img src="resource/images/loading.gif"  /></div>
		  <div class="clear"></div>
     </div>
 <div class="gallerybox">
  <div class="galleryboxscroll">
    <?php 
   	 /* $url = EDITPROFILE_SERVICE;	  
	  $data['user_id'] = $user_id;
	  $data['getgalleryuser_id'] = 1;
      $init_process_obj->getUserGallery($url,$data);	*/

$REQ_SEND[PARAM_ACTION] = 'getgalleryuser_id';
$REQ_SEND[PARAM_USER_ID] = $user_id;
$init_process_obj = new INIT_PROCESS(EDITPROFILE_SERVICE, $REQ_SEND);
	  
	  if($init_process_obj->response != 1){
	  	
		$gallery_arr = 	$ObjJSON->decode($init_process_obj->response);
		foreach($gallery_arr as $k => $v){
			$gallery_arr[$k] = $ObjJSON->objectToArray($ObjJSON->decode($v));
		}

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
			}elseif(isset($arr1['image_name'])){
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