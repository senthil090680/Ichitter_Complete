<?php
class UProfile extends commonGeneric {
	protected $news = array('tbl_id'=>TBL_USER_PROFILE);
	public function edit_field_profile($data){
		$fields = array_keys($data);
		$sql = "UPDATE tbl_user_profile SET ".$fields[1]." = '".$data[$fields[1]]."' WHERE user_id = ".$data['user_id'];
		$this->news['user_id'] = $data['user_id'];
		return $this->transaction($sql,$this->news);
	}
	
	public function edit_group_field_profile($data){
		$this->transaction_start();
		$sql = "UPDATE tbl_user_profile SET first_Name = '".$data['first_Name']."',
                                        last_name = '".$data['last_Name']."',
                                        gender = '".$data['gender']."',
                                        state = '".$data['state']."',
                                        status = '".$data['status']."',
                                        college = '".$data['college']."',
                                        profession = '".$data['profession']."',
                                        career = '".$data['career']."',
                                        political_affiliation = '".$data['political_affiliation']."',
                                        active_involment = '".$data['active_involment']."',
                                        hobbies = '".$data['hobbies']."',
                                        family = '".$data['family']."',
                                        issues_close_at_heart = '".$data['issues_close_at_heart']."'";
		$sql .= ' WHERE user_id = ' . $data['user_id'];
		$r1 = $this->query_Exe($sql);
		
		//$r2 = $this->news_update($data['user_id']);
		
		$this->news['user_id'] = $data['user_id'];
		$r2 = $this->news_update($this->news);
		
		if($r1 == $r2){
             $this->query_Exe('COMMIT');
             return $this->encode(array('success'=>1));
		}else{
			$this->query_Exe('ROLLBACK');
			return $this->encode(array('error'=>'test'));
		} 
	}
	
	public function getUserGallery($data){		
		//$sql = "SELECT tig.igallery_name,timg.image_id,timg.image_name FROM tbl_igallery tig LEFT JOIN tbl_images timg ON (tig.igallery_id = timg.igallery_id) WHERE tig.user_id = ".$data['user_id'];
	$sql = "SELECT tig.igallery_name,timg.image_id,timg.image_name FROM tbl_igallery tig LEFT JOIN tbl_images timg ON (tig.igallery_id = timg.igallery_id) WHERE tig.user_id = ".$data['user_id']." union SELECT user_id,image_id,image_name FROM tbl_images WHERE igallery_id = 0 and  user_id = ".$data['user_id'];
		$result = $this->query_Exe($sql);
		$arr = array();
		while($data =  $this->fetch_row($result)){
			$arr[] = $this->encode($data);
		}
		return $this->encode($arr);
	}
	
	/*public function getGalleryUserID($data){	
	//return $this->encode($data);		
$user_id = $data['user_id'];
	    $sql = " SELECT igallery_id,igallery_name FROM tbl_igallery  WHERE user_id = " . $user_id;	  
	    $result =  $this->query_Exe($sql);
		
		$igalid = "";
		$html = '';
      while($gal = mysql_fetch_assoc($result)) {
	  	
       if($gal['igallery_id'] != $igalid) {
        $igalid = $gal['igallery_id'];
        $gname = $gal['igallery_name'];
        $gname_ar = explode('_', $gname); 
        $html .= "<div class='galleryinnertitle'>" . $gname_ar[0] . "</div>";
       }
       $img_rs = $this->getImagesByGallery($user_id, $gal['igallery_id']);
       
       $recCnt = mysql_num_rows($img_rs);
       if($recCnt > 0) {
        $igallery_name = $gal['igallery_name'];
        while($img = mysql_fetch_assoc($img_rs)) {
		
		
		
        $imgPath = IMAGE_UPLOAD_SERVER . $user_id . '/' . $igallery_name . '/thumb/'.$img['image_name'];
        
        $html .= "<div class='imgbox'><a href=\"javascript: setID('".$img['image_id']."', '".urldecode($imgPath)."')\" ><img src='".$imgPath."' alt='' border='0' /></a></div>";
        
        }
       }
       else {
         $imgPath = "resource/images/videotemp.jpg";
        
          $html .= "<div class='imgbox'><a href=\"javascript: setID('".$img['image_id']."', '".urldecode($imgPath)."')\" ><img src='".$imgPath."' alt='' border='0' /></a></div>";
       }
      }
	  //echo htmlspecialchars($html);
	 return $html;
	 // return $this->encode($html);
		
	

	}*/
	
	public function getImagesByGallery($user_id, $gallery_id = null) {	 
	  $imgtCond = "";
	  
	  if($user_id != null || $user_id != "") {
	   $imgtCond .= " AND user_id = " . $user_id;
	  }
	  
	  if($gallery_id != null || $gallery_id != "") {
	   $imgtCond .= " AND igallery_id = " . $gallery_id;
	  }
	  
	  $query = " SELECT  
		 image_id, 
		 igallery_id, 
		 user_id, 
		 image_name, 
		 date_uploaded, 
		 date_last_updated, 
		 image_description, 
		 is_active, 
		 is_archieved
		FROM
		 tbl_images 
		WHERE 1=1 $imgtCond ";
	  //$this->LOG->lwrite($query);
	  $result = mysql_query($query);
	  return $result;
	 }
	 
	 public function getUservideoGallery($data){
		$sql = "SELECT tvg.vgallery_name, tv.video_id, tv.video_name FROM tbl_vgallery tvg LEFT JOIN tbl_videos tv ON ( tvg.vgallery_id = tv.vgallery_id ) WHERE tvg.user_id = ".$data['user_id']." UNION SELECT user_id, video_id, video_name FROM tbl_videos WHERE vgallery_id =0 AND user_id =".$data['user_id'];
		//return $sql;
		$result = $this->query_Exe($sql);
		$arr = array();
		while($data =  $this->fetch_row($result)){
			$arr[] = $this->encode($data);
		}
		return $this->encode($arr);
		
	}
	
	
}

?>