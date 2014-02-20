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
  <script language="JavaScript" type="text/javascript">
 
 function multiple_filecheck(){
 	    var cnt = 0;
		var cntvalue = "";
	var node_list = document.getElementsByName('multiplefile[]');
	for (var i = 0; i < node_list.length; i++) {
	var node = node_list[i].value;
		if(node == ""){
		 cnt++;
		}else{
		 if(cntvalue != ""){
		  cntvalue = cntvalue+"/"+i;
		 }
		}
	}
	var gallery = $('#gallery').val();
	if (gallery==null || gallery==""){
	   alert("No gallery selected! Please create or select a gallery to upload images");
	   return false;
	}	
	if(cnt == 5){
	   alert("Please select images the upload");
	   return false;
	}else{
		for (var j = 0; j < node_list.length; j++) {
		var nodes = node_list[j].value;
		var extn = nodes.substring(nodes.lastIndexOf('.') + 1);
         if(nodes != ""){
			if(extn == "gif" || extn == "GIF" || extn == "JPEG" || extn == "jpeg" || extn == "jpg" || extn == "JPG"){
			 document.frmUploadmultiple.submit();
			}else{
			 alert("Upload Gif or Jpg images only! Instead of "+nodes);
			 return false;
			}		 
		 }
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
							<div class="posting" style="margin-bottom:10px;">Photos</div>
							<div class="ucipublishedhd"><h1>Select Gallery:</h1> 
							</div>
				<form enctype="multipart/form-data" action="upload_process.php" name="frmUploadmultiple" method="POST">							
					<div class="ucipublishedtxt" id="regd-form">
					   <ul class="">
					   <?php $user_id = $_SESSION['login']['user_id'];
					   ?>
							 <div class="reg-bg" style="padding:0;">
								<SELECT class="sec-box" name="gallery" id="gallery" style="margin: 3px 0 0 2px;width: 190px;">
								<?php					
								/*$ch = curl_init();
								curl_setopt($ch, CURLOPT_HEADER, 0);
								curl_setopt($ch, CURLOPT_VERBOSE, 0);
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
								curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");
								curl_setopt($ch, CURLOPT_POST, true);
								//curl_setopt($ch, CURLOPT_URL, 'http://tsg.emantras.com/ichitter_service/get_photo_gallery_list.php' );
								curl_setopt($ch, CURLOPT_URL, SERVICE_NAME . 'get_photo_gallery_service.php' );
								//most importent curl assues @filed as file field
								$post_array = array(
									"user_id"=>$user_id,					
									"upload"=>"Upload"
								);
								curl_setopt($ch, CURLOPT_POSTFIELDS, $post_array); 
								$response = curl_exec($ch);
								echo $response;*/

								$curl_data = array(
									"user_id"=>$user_id,					
									"upload"=>"Upload" );

								$curl_data+=$REQ_SEND;
								$curl_call = new INIT_PROCESS(GET_PHOTO_GALLERY_SERVICE, $curl_data);
								$response = $curl_call->response;
								echo $response;

								//$response_decode = json_decode($response);
								$response_decode = $ObjJSON->decode($response);
								$arr = $response_decode->{"success"};
								for($i=0;$i<count($arr);$i=$i+2){
								$key = $i+1;
								$arr_key = explode("_",$arr[$i]);
								$gal_nam = $arr_key[0];
								echo "<OPTION VALUE=\"".$arr[$key]."\" align='center'>".$gal_nam."</OPTION>";
								}		
								
								?>
								<OPTION VALUE="0">Individual Photos</OPTION>
								</SELECT>		
								<input type="hidden" name="user_id" value="<?php echo $user_id;?>">
							</div>						
					   </ul>				
					</div> 
					
					<div class="ucipublishedhd margintop10">
					  <h1>Upload Photos</h1> 
					</div>
					
					<div class="ucipublishedtxt">
					   <ul class="flt">
							 <div id="searchuploadGallery">
									<!-- Fake field to fool the user -->
									<input type="file" name="multiplefile[]" id="multiplefile[]" class="file" size="29">
									<input type="file" name="multiplefile[]" id="multiplefile[]" class="file" size="29">
									<input type="file" name="multiplefile[]" id="multiplefile[]" class="file" size="29">
									<input type="file" name="multiplefile[]" id="multiplefile[]" class="file" size="29">
									<input type="file" name="multiplefile[]" id="multiplefile[]" class="file" size="29">
									<!-- Button to invoke the click of the File Input -->
									<a href="javascript:;" style="float:right" ><img src="resource/images/upload-bt.png" onclick="return multiple_filecheck();" /></a>
							</div>							
					   </ul>				
					</div> 
				</form>					

					        </div>		
		</div>
		<div id="contentRight">
		<?php include ('common/right_side_navigation.php');?>		  
		</div>
		
<?php require_once 'common/footer1.php'; ?>
