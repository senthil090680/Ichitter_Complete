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
	if($gallery_id == 0){
	 $SQL = "SELECT * FROM tbl_igallery WHERE user_id='$user_id' AND igallery_id='0' ORDER BY igallery_id DESC limit 0,1";
	}else{
     $SQL = "SELECT * FROM tbl_igallery WHERE user_id='$user_id' AND igallery_id='$gallery_id' ORDER BY date_last_updated DESC limit 0,1";
	} 
	 $rs = mysql_query($SQL);
	 $fetch = mysql_fetch_array($rs);
	 $galleryid_first = $fetch['igallery_id'];
	 $gallery_name = $fetch['igallery_name'];
	if($gallery_id == 0){
	 $gallery_id = $galleryid_first;
	}	 
		   $explode_gal = explode("_",$gallery_name);
		   $gal_name = $explode_gal[0];	 
	 $SQLQuery = "SELECT * FROM tbl_images WHERE user_id='$user_id' AND igallery_id='$gallery_id' ORDER BY date_uploaded";
	 $res = mysql_query($SQLQuery);		
     $cnt = mysql_num_rows($res);					
	 while($fetch_img = mysql_fetch_array($res)){			
		$img = $fetch_img['image_name'];		
		if($img == ""){
			$img_urls[] = "upload/photos/images.jpeg";
			$img_ids[] = "";
		}else{							
		    $img_urls[] = "upload/photos/".$user_id."/".$gallery_name."/thumb/".$img;	
			$img_ids[] = $fetch_img['image_id'];
		}
     }
     if($cnt == 0){
	  $return['error'] = "No Photos Available";
	  $return['gal_name'] = $gal_name;	  
	 }else{		 
	  $return['success'] = $img_urls;
	  $return['imgeids'] = $img_ids;
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
				$gallery_nam[] = $gallery_name;
            }else{							
                $img_url[] = "upload/photos/".$user_id."/".$gallery_name."/thumb/".$img;		
				$galid[] = $gallery_id;	
				$gallery_nam[] = $gallery_name;				
			}	
			$incre++;
		}
		$query = mysql_query("SELECT image_name from tbl_images WHERE igallery_id='0' AND user_id='$user_id' ORDER BY date_uploaded");
		$fetchindImg = mysql_fetch_array($query);
		$imgnm = $fetchindImg['image_name'];
		if($imgnm == ""){
		  $indphoto = "upload/photos/images.jpeg";
		}else{
		  $indphoto = "upload/photos/".$user_id."/thumb/".$imgnm;
		}
        if($cntt == 0){
		  $return["error"] = "";
		}else{
		  $return['imgurls'] = $img_url;	
		  $return['galeryids'] = $galid;		  
		  $return['galname'] = $gallery_nam;
		}			
		  $return['individualPh'] = $indphoto;		
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
