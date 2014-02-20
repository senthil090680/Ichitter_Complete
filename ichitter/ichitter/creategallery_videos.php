<?php
require_once('lib/include_files.php');
require_once('lib/profile_photo_include.php');
//error_reporting(0);
	$session_obj = new SESSION();
	if(isset($_REQUEST['logout']) && $_REQUEST['logout'] == 'OK'){
		$session_obj->unset_Session('login');	
		header('location:index.php');		
	}	
	if(trim($_SESSION['login']['user_id']) == ''){		
		header('location:index.php');
	} 
?>

		<?php

		 require_once 'common/header1.php';
		?>
<script>		
function checkgalleryname(){
var checkString = $('#galerry').val();
	if (checkString == "") {
			alert("Gallery name should not be empty!");
			$('#galerry').focus();
			return false;
	}
	if (checkString != "") {
		if ( /[^A-Za-z\d] /.test(checkString)) {
			alert("Please enter only letter and numeric characters");
			$('#galerry').focus();			
			return false;
		}
	}
return true;
}
</script>		
		<div id="contentLeft">
		
			<div id="profPhoto"><img width="86" height="106" src="<?php echo $profile_img; ?>" /><br /><?php echo $user_name; ?></div>		
		    <?php	require_once('lib/group_header_include.php'); ?>
<div class="line"></div>
		  <div id="leftmenulist">
			<?php include ('common/side_navigation.php');?>		  
		  </div>

				<div id="mainupload">	
							<div class="posting" style="margin-bottom:10px;">Videos</div>				
							<div class="ucipublishedhd"><h1>Create Album/Gallery:</h1> 
							</div>
					
					<div class="ucipublishedtxt">
							 <div id="searchupload">
							 <form action="create_gallery_video.php" name="galleryform" method="POST" onsubmit="return checkgalleryname();">						
									<input type="text" name="galerry" id="galerry" class="searchInput" size="35">
									<input type="hidden" name="user_id" value="<?php echo $_SESSION['login']['user_id']; ?>">
									<input type="submit" name="submit" value="Create Gallery" id="createAlbum">
							</form>		
							</div>					
					</div> 
					

					
		        </div>		
		</div>

		<div id="contentRight">
		<?php include ('common/right_side_navigation.php');?>		  
		</div>
		

<?php require_once 'common/footer1.php'; ?>
