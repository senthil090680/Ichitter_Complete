<?php
error_reporting(0);
require_once "includes/dbobj.php";
require_once "includes/class.commonGeneric.php";
require_once "includes/json.php";
class upload_gallery{
    
        private $filename;
        private $type;
        private $tmp_name;
        private $error;
        private $size;
        private $json_error_arr = array();     
        
    function __construct(){
		
    }
	function _convertVideo($filename,$outfile){
		$v_cmd="ffmpeg -i \"$filename\" -acodec copy -vcodec copy \"$outfile\"";
		exec($v_cmd,$v_output,$v_status);
		if($v_status == 0)
		{
		$return = "success";
		}
		else 
		{
		$return = "error";
		}	
		return $return;
	}	
	function _createThumbs($filename,$imgname){
		$v_cmd="ffmpeg -itsoffset -1 -i \"$filename\" -vcodec mjpeg -vframes 1 -an -f rawvideo -s 142x84 \"$imgname\" 2>&1";
		exec($v_cmd,$v_output,$v_status);
		if($v_status == 0)
		{
		$return = "success";
		}
		else 
		{
		$return = "error";
		}	
		return $return;
	}
	function _get_galleryname($user_id,$gallery){
		$strSQL = "SELECT vgallery_name,user_id FROM tbl_vgallery WHERE vgallery_id = '$gallery' AND  user_id='$user_id'";
		$rs = mysql_query($strSQL);
        $fetch = mysql_fetch_array($rs);
        $igallery_name = $fetch['vgallery_name'];		
        $user_id = $fetch['user_id'];		
        return $galname = $igallery_name;		
	}
    function _upload_video($file,$file_name,$user_id,$gallery,$galleryid){
		$thmbimga = explode('.',$file_name);
		$thmbimg = $thmbimga[0].".jpg";	
		$thmbfil = $thmbimga[0].".flv";	

         $thisdir = getcwd();
		if(!is_dir($thisdir ."/upload/videos/".$user_id)){ 
			mkdir($thisdir ."/upload/videos/".$user_id , 0777, true);
    		mkdir($thisdir ."/upload/videos/".$user_id."/thumb" , 0777, true);
		}
				
        if($galleryid == 0){
        $target_path = "upload/videos/".$user_id."/".basename($file_name);
		$image_path = "upload/videos/".$user_id;
		$thumb_path = "upload/videos/".$user_id."/thumb/".$thmbimg;		
		$convert_file = "upload/videos/".$user_id."/".$thmbfil;			
		}else{
        $target_path = "upload/videos/".$user_id."/".$gallery."/".basename($file_name);
		$image_path = "upload/videos/".$user_id."/".$gallery;
		$thumb_path = "upload/videos/".$user_id."/".$gallery."/thumb/".$thmbimg;
		$convert_file = "upload/videos/".$user_id."/".$gallery."/".$thmbfil;			
		}	
        $handle = fopen($target_path, "wb");
        $img_contents = fwrite($handle, base64_decode( $file ));
        fclose($handle);   

		$tmb = $this->_createThumbs( $target_path, $thumb_path );
		if($tmb = 'success'){
			$query = "INSERT INTO `tbl_videos` (`video_id`, `user_id`, `vgallery_id`, `video_name`, `date_uploaded`, `date_last_updated`, `is_active`) 
					  VALUES (NULL, '$user_id', '$galleryid', '".mysql_real_escape_string(basename($thmbfil))."', now(), now(), 1)";		
				$execute = mysql_query($query);		
		$convert = $this->_convertVideo( $target_path, $convert_file );
			//if($convert == 'success'){

				if($execute){	
				$msg = "Video uploaded successfully";
				unlink($target_path);				
				}		
			//}else{
			//	$msg = "Video Not uploaded successfully";
			//}
		}
        return $msg;		
    }
	function setUploadedFileName($fname){
		$datetime = date("mdYHis");
		$filecheck = $fname;
        $farr = explode('.', $filecheck);
        $ext = strtolower(substr($filecheck, strrpos($filecheck, '.') + 1));
		$fname = $this->replaceSplChars($farr[0]) . "_" . $datetime . "." . $ext;
		
		return $fname;
	}
	
	function replaceSplChars($text) {
		$pattern = "/([^A-Za-z0-9])/i";
		$retText = preg_replace($pattern, '_' ,$text);
		return $retText;
	}		
   
}
$file = $_POST['my_file_binary'];
$post_upload = $_POST['upload'];
$file_name = $_POST['my_file_name'];
$user_id = $_POST['user_id'];
$gallery = $_POST['gallery'];
$upload_obj = new upload_gallery();
$file_name = $upload_obj->setUploadedFileName($file_name);
$ObjJSON = new Services_JSON();
if(isset($post_upload)){

  $gallery_name = $upload_obj->_get_galleryname($user_id,$gallery);
  $arr_success['success'] = $upload_obj->_upload_video($file,$file_name,$user_id,$gallery_name,$gallery);
  //echo $responseVar = json_encode($arr_success);
  echo $responseVar = $ObjJSON->encode($arr_success); 
}

?>