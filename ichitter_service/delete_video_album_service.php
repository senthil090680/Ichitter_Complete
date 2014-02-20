<?php
error_reporting(0);
require_once "includes/dbobj.php";
require_once "includes/json.php";
class delete_album{
    
        private $album_ids;
        private $user_id;
        private $json_error_arr = array();  
        private $ObjJSON;   
        
    function __construct(){
		$this->ObjJSON = new Services_JSON();
    }
	function _delete_album($album_ids,$user_id){
	  $img = explode(",",$album_ids);
      foreach($img as $imgid){
	   if($imgid == '0'){
		$rmpath = "upload/videos/".$user_id."/";
		$rmpathump = "upload/videos/".$user_id."/thumb/";		
		$strSQL = "SELECT video_name FROM tbl_videos WHERE user_id='$user_id' AND vgallery_id='0'";
		$rs = mysql_query($strSQL);
        while($fetch = mysql_fetch_array($rs)){
		  $vidnam = $fetch['video_name']; 
		  $thmbimga = explode('.',$vidnam);
		  $thmbimg = $thmbimga[0].".jpg";			  
		  @unlink($rmpath.$vidnam);
		  @unlink($rmpathump.$thmbimg);		  
		}		
	    $sql = "DELETE FROM tbl_videos WHERE vgallery_id = $imgid";
		$rs = mysql_query($sql);		 
		$delAlb = "DELETE FROM tbl_vgallery WHERE vgallery_id = $imgid";
		$rss = mysql_query($delAlb);	   
	   }else{	  
		$gal_name = $this->_get_galleryname($user_id,$imgid);
		$rmpath = "upload/videos/".$user_id."/".$gal_name."/";
		$this->_delete_directory($rmpath);
	    $sql = "DELETE FROM tbl_videos WHERE vgallery_id = $imgid";
		$rs = mysql_query($sql);		 
		$delAlb = "DELETE FROM tbl_vgallery WHERE vgallery_id = $imgid";
		$rss = mysql_query($delAlb);	
	   } 		
	  }
	    if(($rs) && ($delAlb)){
		  $return["success"] = "Album deleted successfully";
		}		
	    //return json_encode($return);
	    return $this->ObjJSON->encode($return);	 
	}
	
	function _delete_directory($dir)
	{
		if ($handle = opendir($dir))
		{
			$array = array();
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != "..") {
					if(is_dir($dir.$file))
					{
						if(!@rmdir($dir.$file)) // Empty directory? Remove it
						{
							$this->_delete_directory($dir.$file.'/'); // Not empty? Delete the files inside it
						}
					}
					else
					{
					 @unlink($dir.$file);
					}
				}
			}
			closedir($handle);
			@rmdir($dir);
		}
	}	
	function _get_galleryname($user_id,$gallery){
		$strSQL = "SELECT vgallery_name,user_id FROM tbl_vgallery WHERE vgallery_id = '$gallery' AND  user_id='$user_id'";
		$rs = mysql_query($strSQL);
        $fetch = mysql_fetch_array($rs);
        $igallery_name = $fetch['vgallery_name'];		
        $user_id = $fetch['user_id'];		
        return $galname = $igallery_name;		
	}	

}	
$album_ids = $_POST['album_ids'];
$user_id = $_POST['user_id'];
$post_upload = $_POST['upload'];
$delete_obj = new delete_album();
if(isset($post_upload)){
if($_POST["delete_album"] != ""){
echo $fetch_photos = $delete_obj->_delete_album($album_ids,$user_id);
}
//if($_POST["get_gallery"] != ""){
//echo $fetch_gallery = $gallery_obj->_fetch_galaries($user_id);
//}
}
?>
