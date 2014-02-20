<?php

// Contains images and videos related functions
class Gallery {

    var $LOG;

    function __construct() {
	//$this->LOG = new Logging();
    }

    function getImagesByUser($user_id, $image_id = null) {
	$imgtCond = "";
	if ($user_id != null || $user_id != "") {
	    $imgtCond .= " AND user_id = " . $user_id;
	}
	if ($image_id != null || $image_id != "") {
	    $imgtCond .= " AND image_id = " . $image_id;
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

    function getImagesByGallery($user_id, $gallery_id = null) {

	$imgtCond = "";

	if ($user_id != null || $user_id != "") {
	    $imgtCond .= " AND user_id = " . $user_id;
	}

	if ($gallery_id != null || $gallery_id != "") {
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

    function getVideosByGallery($user_id, $gallery_id = null) {

	$imgtCond = "";
	if ($user_id != null || $user_id != "") {
	    $imgtCond .= " AND user_id = " . $user_id;
	}

	if ($gallery_id != null || $gallery_id != "") {
	    $imgtCond .= " AND vgallery_id = " . $gallery_id;
	}

	$query = " SELECT  
					video_id, 
					user_id, 
					vgallery_id, 
					video_name, 
					date_uploaded, 
					date_last_updated, 
					video_description, 
					is_active, 
					is_archieved
				FROM
					tbl_videos 
				WHERE 1=1 $imgtCond ";
	//$this->LOG->lwrite($query);
	$result = mysql_query($query);
	return $result;
    }

    function getVideosByUser($user_id, $video_id = null) {

	$vdoCond = "";

	if ($video_id != null || $video_id != "") {
	    $vdoCond = " AND video_id = " . $video_id;
	}

	$query = " SELECT 	
						video_id, 
						user_id, 
						video_name, 
						date_uploaded, 
						date_last_updated, 
						video_description, 
						is_active, 
						is_archieved
					FROM 
						tbl_videos  
					WHERE user_id = $user_id  $vdoCond ";

	//$this->LOG->lwrite($query);
	$result = mysql_query($query);
	return $result;
    }

    function displayGalleryPupupByUser($user_id, $image_id = null, $gal_id=null) {
	$imgtCond = "";
	if ($image_id != null || $image_id != "") {
	    $imgtCond .= " AND im.image_id = " . $image_id;
	}

	if ($gal_id != null || $gal_id != "") {
	    $imgtCond .= " AND im.igallery_id = " . $gal_id;
	}

	$query = " SELECT ig.igallery_id,
			im.image_id,
			im.igallery_id AS igalid,
			im.user_id,
			im.image_name,
			im.image_description,
			ig.igallery_name,
			ig.igallery_description,
			CASE WHEN im.igallery_id=0 THEN 'Individual Images' ELSE ig.igallery_name END AS galleryname 
		FROM tbl_igallery AS ig, tbl_images AS im 
		WHERE ig.user_id = $user_id $imgtCond ORDER BY igalid ASC ";
	$result = mysql_query($query);
	return $result;
    }

    function getVideoDetails($user_id = null, $video_id = null, $gal_id=null) {
	$Cond = "";
	if ($user_id != null || $user_id != "") {
	    $Cond .= " AND vg.user_id = " . $user_id;
	}

	if ($video_id != null || $video_id != "") {
	    $Cond .= " AND vdo.video_id = " . $video_id;
	}

	if ($gal_id != null || $gal_id != "") {
	    $Cond .= " AND vg.vgallery_id = " . $gal_id;
	}

	$query = " SELECT vg.vgallery_id, vg.vgallery_name, vdo.video_id, vdo.video_name, vdo.user_id  
		FROM tbl_vgallery vg LEFT JOIN tbl_videos vdo ON (vg.vgallery_id = vdo.vgallery_id) 
		WHERE 1=1 $Cond ORDER BY vg.vgallery_id ASC ";
	$result = mysql_query($query);
	return $result;
    }

    function getImageDetails($user_id = null, $image_id = null, $gal_id=null) {
	$Cond = "";
	if ($user_id != null || $user_id != "") {
	    $Cond .= " AND ig.user_id = " . $user_id;
	}

	if ($image_id != null || $image_id != "") {
	    $Cond .= " AND im.image_id = " . $image_id;
	}

	if ($gal_id != null || $gal_id != "") {
	    $Cond .= " AND ig.igallery_id = " . $gal_id;
	}

	$query = " SELECT ig.igallery_id, ig.igallery_name, im.image_id, im.image_name, im.user_id  
		FROM tbl_igallery ig LEFT JOIN tbl_images im ON (ig.igallery_id = im.igallery_id) 
		WHERE 1=1  $Cond ORDER BY ig.igallery_id ASC ";
	//$this->LOG->lwrite($query);
	//return $query;
	$result = mysql_query($query);
	return $result;
    }

    function getGalleryName($gallery_id) {
	$query = " SELECT igallery_id, igallery_name 
		FROM tbl_igallery  WHERE igallery_id = " . $igallery_id;
	$result = mysql_query($query);
	return $result;
    }

    function getGalleryUserID($user_id) {
	$query = " SELECT igallery_id, igallery_name 
		FROM  tbl_igallery  WHERE user_id = " . $user_id;
	$result = mysql_query($query);
	return $result;
    }

    function getVideoGalleryUserID($user_id) {
	$query = " SELECT vgallery_id, vgallery_name 
		FROM tbl_vgallery  WHERE user_id = " . $user_id;
	$result = mysql_query($query);
	return $result;
    }

    function __destruct() {
	
    }

}

?>