<?php
error_reporting(0);
require_once "includes/dbobj.php";
class upload_gallery{
    
        private $filename;
        private $type;
        private $tmp_name;
        private $error;
        private $size;
        private $json_error_arr = array();     
        
    function __construct(){

    }
    function _validate_image($img_binary,$file_name){
	   // $target_path = "upload/".basename($file_name);
		//$im = imagecreatefromstring(base64_decode($img_binary));
	    //$handle = fopen($target_path, "wb");
		//echo $size = getimagesize($im);
        //echo $img_contents = fwrite($handle, base64_decode( $img_binary ));
        //fclose($handle);  
                               
    }
	function _createThumbs( $pathToImages, $pathToThumbs )
	{
		$thumb_directory =  $pathToThumbs;    //Thumbnail folder
		$orig_directory = $pathToImages;    //Full image folder
		 
		/* Opening the thumbnail directory and looping through all the thumbs: */
		$dir_handle = @opendir($orig_directory); //Open Full image dirrectory
		if ($dir_handle > 1){ //Check to make sure the folder opened
		 
		$allowed_types=array('jpg','jpeg','gif','png');
		$file_parts=array();
		$ext='';
		$title='';
		$i=0;
		 
		while ($file = @readdir($dir_handle))
		{
			/* Skipping the system files: */
			if($file=='.' || $file == '..') continue;
		 
			$file_parts = explode('.',$file);    //This gets the file name of the images
			$ext = strtolower(array_pop($file_parts));
		 
			/* Using the file name (withouth the extension) as a image title: */
			$title = implode('.',$file_parts);
			$title = htmlspecialchars($title);
		 
			/* If the file extension is allowed: */
			if(in_array($ext,$allowed_types))
			{
		 
				/* If you would like to inpute images into a database, do your mysql query here */
		 
				/* The code past here is the code at the start of the tutorial */
				/* Outputting each image: */
				$nw = 86;
				$nh = 105;
				$source = $orig_directory."/".$file;
				$stype = explode(".", $source);
				$stype = $stype[count($stype)-1];
				$dest = $thumb_directory."/".$file;
		 
				$size = getimagesize($source);
				$w = $size[0];
				$h = $size[1];
		 
				switch($stype) {
					case 'gif':
						$simg = imagecreatefromgif($source);
						break;
					case 'jpg':
						$simg = imagecreatefromjpeg($source);
						break;
					case 'png':
						$simg = imagecreatefrompng($source);
						break;
				}
		 
				$dimg = imagecreatetruecolor($nw, $nh);
				$wm = $w/$nw;
				$hm = $h/$nh;
				$h_height = $nh/2;
				$w_height = $nw/2;
		 
				if($w> $h) {
					$adjusted_width = $w / $hm;
					$half_width = $adjusted_width / 2;
					$int_width = $half_width - $w_height;
					imagecopyresampled($dimg,$simg,-$int_width,0,0,0,$adjusted_width,$nh,$w,$h);
				} elseif(($w <$h) || ($w == $h)) {
					$adjusted_height = $h / $wm;
					$half_height = $adjusted_height / 2;
					$int_height = $half_height - $h_height;
		 
					imagecopyresampled($dimg,$simg,0,-$int_height,0,0,$nw,$adjusted_height,$w,$h);
				} else {
					imagecopyresampled($dimg,$simg,0,0,0,0,$nw,$nh,$w,$h);
				}
					imagejpeg($dimg,$dest,100);
				}
		}
		 
		/* Closing the directory */
		@closedir($dir_handle);
		 
		}
	}	
	function _get_galleryname($user_id,$gallery){
		$strSQL = "SELECT igallery_name,user_id FROM tbl_igallery WHERE igallery_id = '$gallery' AND  user_id='$user_id'";
		$rs = mysql_query($strSQL);
        $fetch = mysql_fetch_array($rs);
        $igallery_name = $fetch['igallery_name'];		
        $user_id = $fetch['user_id'];		
        return $galname = $igallery_name;		
	}
    function _upload_image($file,$file_name,$user_id,$gallery,$galleryid){
        if($galleryid == 0){
        $target_path = "upload/photos/".$user_id."/".basename($file_name);
		$image_path = "upload/photos/".$user_id;
		$thumb_path = "upload/photos/".$user_id."/thumb";		
		}else{
        $target_path = "upload/photos/".$user_id."/".$gallery."/".basename($file_name);
		$image_path = "upload/photos/".$user_id."/".$gallery;
		$thumb_path = "upload/photos/".$user_id."/".$gallery."/thumb";
		}	
        $handle = fopen($target_path, "wb");
        $img_contents = fwrite($handle, base64_decode( $file ));
        fclose($handle);   

		
		$this->_createThumbs( $image_path, $thumb_path );
		
        $query = "INSERT INTO `ichitter`.`tbl_images` (`image_id`, `user_id`, `igallery_id`, `image_name`, `date_uploaded`, `date_last_updated`, `is_active`) 
		          VALUES (NULL, '$user_id', '$galleryid', '".mysql_real_escape_string(basename($file_name))."', now(), now(), 1)";		
			$execute = mysql_query($query);
		if($execute){	
        $msg = "Image uploaded successfully";
		}
        return $msg;		
    }
   
}
$file = $_POST['my_file_binary'];
$post_upload = $_POST['upload'];
$file_name = $_POST['my_file_name'];
$user_id = $_POST['user_id'];
$gallery = $_POST['gallery'];
$upload_obj = new upload_gallery();
if(isset($post_upload)){
  $gallery_name = $upload_obj->_get_galleryname($user_id,$gallery);
  $arr_success['success'] = $upload_obj->_upload_image($file,$file_name,$user_id,$gallery_name,$gallery);
  echo $responseVar = json_encode($arr_success); 
}
//if($validate_image == "success"){
//  $arr_success['success'] = $upload_obj->_upload_image($post_upload,$file);
//echo $responseVar = json_encode($arr_success); 
//}else{
//echo $validate_image;  
//}
?>