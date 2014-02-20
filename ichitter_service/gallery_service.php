<?php
require_once "includes/dbobj.php";
require_once "includes/json.php";
require_once "includes/configuration.php";
require_once "includes/class.commonGeneric.php";
require_once "includes/Logging.php";
require_once "includes/parameters.php";
require_once "includes/class.gallery.php";

$ObjJSON = new Services_JSON();

$action = $_REQUEST[PARAM_ACTION];
$userid = $_REQUEST[PARAM_USERID];

$gallery = new Gallery();

$return = array();

switch ($action) {
    case "imagebyuser": 
	    $result = $gallery->getImageDetails($userid);
	    $i=0;
	    while ($row = mysql_fetch_assoc($result)) {
		$return[$i] = $row;
		$i++;
	    }
	    
	break;
    
    case "videobyuser":
	    $result = $gallery->getVideoDetails($userid);
	    $i=0;
	    while ($row = mysql_fetch_assoc($result)) {
		$return[$i] = $row;
		$i++;
	    }
	break;

    default: break;
}

print $ObjJSON->encode($return);
?>
