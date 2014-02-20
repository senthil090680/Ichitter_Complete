<?php
require_once "includes/dbobj.php";
require_once "includes/configuration.php";
require_once 'includes/class.commonGeneric.php';
require_once 'includes/class.profile.php';

//echo 'registration_services';

$usrprofile_obj = new UProfile;


$action = $_REQUEST[PARAM_ACTION];

$return = array();

require_once 'includes/authentication.php';
if ($valid == 1) {

	switch($action){
		case 'profile':
			$return = $usrprofile_obj->edit_field_profile($_REQUEST);		
		break;
		case 'getgalleryuser_id':
			$return = $usrprofile_obj->getUserGallery($_REQUEST);	
		break;
		case 'profile_img':
			$return = $usrprofile_obj->edit_field_profile($_REQUEST);
		break;
		case 'profile_important':
			$return = $usrprofile_obj->edit_group_field_profile($_REQUEST);
		break;
		case 'getUservideoGallery':
			$return = $usrprofile_obj->getUservideoGallery($_REQUEST);
		break;
	}
	
} else {
	$return = $usrprofile_obj->encode($_REQUEST);
    $return = $usrprofile_obj->encode(array("result" => "unauth", "rec" => array()));
}
print $return;

?>