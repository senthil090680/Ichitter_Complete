<?php
	require_once 'lib/include_files.php';
	if(isset($_REQUEST['logout']) && $_REQUEST['logout'] == 'OK'){
		$session_obj->unset_Session('login');	
		header('location:index.php');	
	}
	if(!$session_obj->get_Session('login')){
		header('location:index.php');
	}
	$data = array('get_user_record'=>1,'user_id'=>$session_obj->get_Session('user_id'));	
	$init_process_obj = new INIT_PROCESS(SERVICE_NAME.'registration_service.php',$data);
	
	$user_data = $ObjJSON->objectToArray($ObjJSON->decode($init_process_obj->response));
	/*echo '<pre />';
	print_r($user_data);*/
	require_once 'common/header1.php';
?>

<script>
	$(document).ready(function(){
	
		var txt_loc = $.trim($('#txt_location').text());
		$('[name=location]').val(txt_loc);
		
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
				var data = [];
				//data.push('profile:1','test:2');
				var field_name = $.trim($(this).attr('id'));				
				data = "profile=save&"+field_name+"="+txt;
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
				
				if(txt_first_Name == ''){
					alert('Please enter First Name');
					return false;
				}
				
				if(txt_last_Name == ''){
					alert('Please enter Last Name');
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
						$(this).parent().prev().text($(this).val());
					});
				 	$('.profiletdtxt2').show();
					$('.selectprofile').hide();
					$('#issues_close_at_heart').parent().removeClass('profileinfo_highlight');
					$('#issues_close_at_heart').hide();
					
				 }
				 
				 $(this).removeClass('save_btn').addClass('edit_btn');

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
</script>
<style>
	.profileimg:hover #profilephotoedit{
		display:block;
		margin-top:70px;
		margin-left:15px;
	}
	
	
</style>

		<div id="contentLeft">
			<div id="profile">
				<h3>My iChitter Profile</h3>
				<div id="profileContent">
					<div class="profileContentLeft">
						<div class="profileimg" id="imgGal">
							<div id="profilephotoedit">
								Change Photo
							</div>
							<img src="resource/images/profile-img1.jpg" alt="" />
							
						</div>
						<!--<a href="#"><img class="updatebtn" src="resource/images/btn-update.png" alt="" border="0" /></a> -->
						<a id="important_details" class="edit_btn"><!--Edit--></a>
					</div>
					<div class="profileContentRight">
<form id="profile_important" method="post" name="profile_important">
<table width="271" border="0" cellspacing="1" cellpadding="1">

<tr class="profiletr"><td>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="texthg"><tr>
<td width="55%" class="profiletdtxt">First Name :</td>
<td class="profiletdtxt3">
	<div class="profiletdtxt2"><?php echo $user_data['first_Name']; ?></div>
	<div class="selectprofile">
	<input type="text" class="searchInputprof" name="first_Name" id="pro_firstname" value="<?php echo $user_data['first_Name']; ?>" size="20">
	</div>
</table>
</td></tr>

<tr class="profiletr"><td>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="texthg"><tr>
<td width="55%" class="profiletdtxt">Last Name :</td>
<td class="profiletdtxt3">
	<div class="profiletdtxt2"><?php echo $user_data['last_Name']; ?></div>
	<div class="selectprofile">
	<input type="text" class="searchInputprof" name="last_name" id="pro_lastname" value="<?php echo $user_data['last_Name']; ?>" size="20">
	</div>
</table></td></tr>


<tr class="profiletr"><td>
<table width="100%" border="0" cellspacing="0" cellpadding="0"class="texthg">
<tr><td width="55%" class="profiletdtxt">Place :</td>
<td class="profiletdtxt3">
	<div id="txt_location" class="profiletdtxt2"><?php echo $user_data['location']; ?></div>
	<div class="selectprofile">
	<!--	<select class="profileselectarea" name="location">
		  <option>Arizona</option>
		  <option>Arizona</option>
		</select>-->
		<select class="profileselectarea" name="location">
						<option>Alabama</option> 
<option >Alaska</option> 
<option >Arizona</option> 
<option >Arkansas</option> 
<option >California</option> 
<option >Colorado</option> 
<option >Connecticut</option> 
<option >Delaware</option> 
<option >District Of Columbia</option> 
<option >Florida</option> 
<option >Georgia</option> 
<option >Hawaii</option> 
<option >Idaho</option> 
<option >Illinois</option> 
<option >Indiana</option> 
<option >Iowa</option> 
<option >Kansas</option> 
<option >Kentucky</option> 
<option >Louisiana</option> 
<option >Maine</option> 
<option >Maryland</option> 
<option >Massachusetts</option> 
<option >Michigan</option> 
<option >Minnesota</option> 
<option >Mississippi</option> 
<option >Missouri</option> 
<option >Montana</option> 
<option >Nebraska</option> 
<option >Nevada</option> 
<option >New Hampshire</option> 
<option >New Jersey</option> 
<option >New Mexico</option> 
<option >New York</option> 
<option >North Carolina</option> 
<option >North Dakota</option> 
<option >Ohio</option> 
<option >Oklahoma</option> 
<option >Oregon</option> 
<option >Pennsylvania</option> 
<option >Rhode Island</option> 
<option >South Carolina</option> 
<option >South Dakota</option> 
<option >Tennessee</option> 
<option >Texas</option> 
<option >Utah</option> 
<option >Vermont</option> 
<option >Virginia</option> 
<option >Washington</option> 
<option >West Virginia</option> 
<option >Wisconsin</option> 
<option >Wyoming</option> 
						</select>
	</div>
</table></td></tr>



<tr class="profiletr"><td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="texthg">
<tr><td width="55%" class="profiletdtxt">Status :</td>
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
<td width="55%" class="profiletdtxt">Education :</td>
<td class="profiletdtxt3">
<div class="profiletdtxt2"><?php echo $user_data['college']; ?></div>
<div class="selectprofile">	
<input type="text" class="searchInputprof" name="college" id="" value="<?php echo $user_data['college']; ?>" size="20">
</div>
</table></td></tr>
<tr class="profiletr">
<td style="padding-bottom:3px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="texthg"> <tr>
<td width="55%" class="profiletdtxt">Profession :</td>
<td class="profiletdtxt3">
	<div class="profiletdtxt2"><?php echo $user_data['profession']; ?></div>
<div class="selectprofile">

  <input type="text" class="searchInputprof" name="profession" id="txttitle" value="<?php echo $user_data['profession']; ?>" size="20" />
</div>
</table></td></tr>
</table>


<table width="270" border="0" cellspacing="1" cellpadding="1" class="texthg">

<tr class="profiletr">
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="55%" class="profiletdtxt">Career :</td>
        <td class="profiletdtxt3">
			<div class="profiletdtxt2"><?php echo $user_data['career']; ?></div>
		<div class="selectprofile">

		<input type="text" class="searchInputprof" name="career" id="" value="<?php echo $user_data['career']; ?>" size="20">
		
		</div>
		
    </table></td>
  </tr>
  
  <tr class="profiletr">
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="55%" class="profiletdtxt">Political Affiliation :</td>
        <td class="profiletdtxt3">
		<div class="profiletdtxt2"><?php echo $user_data['political_affiliation']; ?></div>
		<div class="selectprofile">

		<input type="text" class="searchInputprof" name="political_affiliation" id="" value="<?php echo $user_data['political_affiliation']; ?>" size="20">
		
		</div>
		
    </table></td>
  </tr>




 
  <tr class="profiletr">
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="texthg">
      <tr>
        <td width="55%" class="profiletdtxt">Active involment :</td>
        <td class="profiletdtxt3">
		<div class="profiletdtxt2"><?php echo $user_data['active_involment']; ?></div>
		<div class="selectprofile">

		<input type="text" class="searchInputprof" name="active_involment" id="" value="<?php echo $user_data['active_involment']; ?>" size="20">
		
		</div>
		
    </table></td>
  </tr>
 <tr class="profiletr">
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="texthg">
      <tr>
        <td width="55%" class="profiletdtxt">Hobbies :</td>
        <td class="profiletdtxt3">
		<div class="profiletdtxt2"><?php echo $user_data['hobbies']; ?></div>
		<div class="selectprofile">

		<input type="text" class="searchInputprof" name="hobbies" id="" value="<?php echo $user_data['hobbies']; ?>" size="20">
		</div>
		
    </table></td>
  </tr>

	
  <tr class="profiletr">
   <td style="padding-bottom:3px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="55%" class="profiletdtxt">Family :</td>
        <td class="profiletdtxt3">
		<div class="profiletdtxt2"><?php echo $user_data['family']; ?></div>
		<div class="selectprofile">

		<input type="text" class="searchInputprof" name="family" id="" value="<?php echo $user_data['family']; ?>" size="20">
		</div>
		
    </table></td>
  </tr>
  <tr class="profiletr">
    <td>&nbsp;</td>
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
						</form>
					</div>
				</div>
			</div>		
			<div id="leftmenulist">	
				<div class="menu">
					<?php include ('common/side_navigation.php');?>
				</div>			 
				<div id="contacts">
					<h1>Contacts </h1>					  
					  <div class="contactscont"> 
						<div class="contactsimg"><img src="resource/images/contact-img1.jpg" alt=""  /></div>
						<div class="contactstext"> <h5>First Name</h5><p>Place</p></div>
					  </div>  
						
					  <div class="contactscont"> 
						<div class="contactsimg"><img src="resource/images/contact-img2.jpg" alt=""  /></div>
						<div class="contactstext"> <h5>First Name</h5><p>Place</p></div>
					  </div>   
						
					  <div class="contactscont"> 
						<div class="contactsimg"><img src="resource/images/contact-img3.jpg" alt=""  /></div>
						<div class="contactstext"> <h5>First Name</h5><p>Place</p></div>
					  </div>   
						
						<div class="contactscont"> 
						<div class="contactsimg"><img src="resource/images/contact-img4.jpg" alt=""  /></div>
						<div class="contactstext"> <h5>First Name</h5><p>Place</p></div>
					  </div>   
					  
					  <div class="contactscont"> 
						<div class="contactsimg"><img src="resource/images/contact-img5.jpg" alt=""  /></div>
						<div class="contactstext"> <h5>First Name</h5><p>Place</p></div>
					  </div>
				</div>
			</div>		
		  <div id="mainupload">	
			<div class="profileHeading">Profile</div>
			<div id="profileGroupsContain">
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
			</div>
			<div class="profileinfo">
				<p>Basic Information</p>
				<a class="edit_btn" id="basic_info"><!--Edit--></a>
				<div class="profileinfoTextbox">
					<div>
					<?php echo stripcslashes($user_data['basic_info']); ?>
					</div>
				</div>
			</div>	
			
			<div class="profileinfo">
				<p>Personal Data</p>
				<a id="personal_data" class="edit_btn"><!--Edit--></a>
				<div class="profileinfoTextbox">
					<div>
					<?php echo stripcslashes($user_data['personal_data']); ?>
					</div>
				</div>
			</div>
			
			<div class="profileinfo">
				<p>Interests</p>
				<a id="interests" class="edit_btn"><!--Edit--></a>
				<div class="profileinfoTextbox">
					<div>
					<?php echo stripcslashes($user_data['interests']); ?>
					</div>
				</div>
			</div>
			
			<div class="profileinfo">
				<p>Professional background</p>
				<a id="professional_background" class="edit_btn"><!--Edit--></a>
				<div class="profileinfoTextbox">
					<div>
					<?php echo stripcslashes($user_data['professional_background']); ?>
					</div>
				</div>
			</div>			
			<div class="profileinfo">
				<p>Favorites</p>
				<a id="favorites" class="edit_btn"><!--Edit--></a>
				<div class="profileinfoTextbox">
					<div>
					<?php echo stripcslashes($user_data['favorites']); ?>				
					</div>
				</div>
			</div>
			
			<a href="#"><img src="resource/images/btn-cancel.png" alt="" border="0" class="cancelbtn"/></a>
			<a href="#"><img src="resource/images/btn-save.png" alt="" border="0" class="savebtn" /></a>
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

define('IMAGE_UPLOAD_SERVER','http://tsg.emantras.com/ichitter_service/upload/photos/25');
?>
<div class="gallerybg">
 <a class="galleryClose"><img src="resource/images/closebt.png" alt="" /></a>
 <div class="gallerytitle">Select an Image</div>
 <div class="gallerybox">
  <div class="galleryboxscroll">
   <?php 
      $rs_GalImg = $init_process_obj->getGalleryUserID('25');
      $igalid = "";
      while($gal = mysql_fetch_assoc($rs_GalImg)) {
       if($gal['igallery_id'] != $igalid) {
        $igalid = $gal['igallery_id'];
        $gname = $gal['igallery_name'];
        $gname_ar = explode('_', $gname); 
        echo "<div class='galleryinnertitle'>" . $gname_ar[0] . "</div>";
       }
       $img_rs = $init_process_obj->getImagesByGallery($user_id, $gal['igallery_id']);
       
       $recCnt = mysql_num_rows($img_rs);
       if($recCnt > 0) {
        $igallery_name = $gal['igallery_name'];
        while($img = mysql_fetch_assoc($img_rs)) {
         
         $imgPath = IMAGE_UPLOAD_SERVER . $user_id . '/' . $igallery_name . '/';
         
         
        ?>
         <div class="imgbox"><a href='javascript: setID("<?php echo $img['image_id'];?>", "<?php echo urldecode($imgPath . $img['image_name']);?>");' ><img src="<?php echo $imgPath . $img['image_name'];?>" alt="" border="0" /><p><?php //echo $img['image_name'];?></p></a></div>
        <?php 
        }
       }
       else {
        //$imgPath = IMAGE_UPLOAD_SERVER . "images.jpeg";
        $imgPath = "resource/images/videotemp.jpg";
        ?>
         <div class="imgbox"><a href='javascript: setID("<?php echo $img['image_id'];?>", "<?php echo urldecode($imgPath . $img['image_name']);?>");' ><img src="<?php echo $imgPath . $img['image_name'];?>" alt="" border="0" /><p><?php //echo $img['image_name'];?></p></a></div>
        <?php
       }
      }
      ?> 
  </div>
 </div>
</div>		
<div id="backgroundPopup"></div>
<?php require_once 'common/footer1.php'; ?>