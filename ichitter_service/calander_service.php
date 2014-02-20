<?php
require_once "includes/dbobj.php";
require_once "includes/configuration.php";
require_once 'includes/class.commonGeneric.php';
require_once 'includes/class.calander.php';

$cal_obj = new CalEvents();
$action = $_REQUEST[PARAM_ACTION];
require_once 'includes/authentication.php';
$return = array();
if($valid == 1) {
switch ($action) {
	case 'create_event':
		$return = $cal_obj->create_event($_REQUEST);
         
		break;
      case 'event_delete':
         $return = $cal_obj->delete_event($_REQUEST);          
         //$return = print_r($_REQUEST);
          break;
      case 'event_edit':
          
          $return = $cal_obj->event_edit($_REQUEST);
          break;
}
} else {
	 $return = $usr_obj->encode($unauth);
 }
print $return;
?>