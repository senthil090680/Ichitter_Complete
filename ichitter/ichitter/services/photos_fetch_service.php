<?php
require_once "includes/dbobj.php";
require_once "includes/json.php";
class fetch_photos{
    
        private $gallery_id;
        private $user_id;
        private $json_error_arr = array();  
        private $ObjJSON;   
        
    function __construct(){
		$this->ObjJSON = new Services_JSON();
    }
	function _fetch_photos($gallery_id,$user_id){
     $SQL = "SELECT * FROM tbl_igallery WHERE user_id='$user_id' AND igallery_id='$gallery_id' ORDER BY date_last_updated DESC limit 0,1";
	 $rs = mysql_query($SQL);
	 $fetch = mysql_fetch_array($rs);
	 $galleryid_first = $fetch['igallery_id'];
	 $gallery_name = $fetch['igallery_name'];
		   $explode_gal = explode("_",$gallery_name);
		   $gal_name = $explode_gal[0];	 
	 $SQLQuery = "SELECT * FROM tbl_images WHERE user_id='$user_id' AND igallery_id='$gallery_id' ORDER BY date_uploaded";
	 $res = mysql_query($SQLQuery);		
     $cnt = mysql_num_rows($res);					
	 while($fetch_img = mysql_fetch_array($res)){			
		$img = $fetch_img['image_name'];		
		if($img == ""){
			$img_urls[] = "upload/photos/images.jpeg";
		}else{							
		    $img_urls[] = "upload/photos/".$user_id."/".$gallery_name."/thumb/".$img;							
		}
     }
     if($cnt == 0){
	  $return['error'] = "No Photos Available";
	  $return['gal_name'] = $gal_name;	  
	 }else{		 
	  $return['success'] = $img_urls;
	  $return['gal_name'] = $gal_name;
	 } 
    //return json_encode($return);
    return $this->ObjJSON->encode($return);	 
	}
	function _fetch_galaries($user_id){
		$SQL = "SELECT * FROM tbl_igallery WHERE user_id='$user_id' ORDER BY date_last_updated DESC";
		$rs = mysql_query($SQL);
        $cntt = mysql_num_rows($rs);	
       $incre = 1;		
		while($row=mysql_fetch_array($rs)){
		   $gallery_name = $row['igallery_name'];
		   $gallery_id = $row['igallery_id'];
		   $explode_gal = explode("_",$gallery_name);
		   $gal_name = $explode_gal[0];
			$SQLQuery = "SELECT * FROM tbl_images WHERE user_id='$user_id' AND igallery_id='$gallery_id' ORDER BY date_uploaded";
			$res = mysql_query($SQLQuery);						   
			$fetch_img = mysql_fetch_array($res);			
            $img = $fetch_img['image_name'];		
            if($img == ""){
				$img_url[] = "upload/photos/images.jpeg";
				$galid[] = $gallery_id;
            }else{							
                $img_url[] = "upload/photos/".$user_id."/".$gallery_name."/thumb/".$img;		
				$galid[] = $gallery_id;	
			}	
			$incre++;
		}
        if($cntt == 0){
		  $return["error"] = "No Album Available";
		}else{
		  $return['imgurls'] = $img_url;	
		  $return['galeryids'] = $galid;		  
		}			
	    //return json_encode($return);
	    return $this->ObjJSON->encode($return);
	}
}	
$gallery_id = $_POST['gallery_id'];
$user_id = $_POST['user_id'];
$post_upload = $_POST['upload'];
$gallery_obj = new fetch_photos();
//$check_dir = $gallery_obj->_check_directory($gallery_name,$user_id);
if(isset($post_upload)){
if($_POST["get_photos"] != ""){
echo $fetch_photos = $gallery_obj->_fetch_photos($gallery_id,$user_id);
}
if($_POST["get_gallery"] != ""){
echo $fetch_gallery = $gallery_obj->_fetch_galaries($user_id);
}
}
?>
