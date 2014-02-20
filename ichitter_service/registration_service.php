<?php
require_once "includes/dbobj.php";
require_once "includes/configuration.php";
require_once 'includes/class.commonGeneric.php';
require_once 'includes/class.uautheticate.php';

$usr_obj = new UAuthenticate;
$action = $_REQUEST[PARAM_ACTION];


require_once 'includes/authentication.php';
$return = array();

if($valid == 1) {

switch ($action) {
	case 'get_user_record':
		if (isset($_REQUEST['user_id'])) {
			$result = $usr_obj->get_user_record($_REQUEST);
		} elseif (isset($_REQUEST['email'])) {
			$result = $usr_obj->check_flag_value($_REQUEST['email']);
			if ($result == 0) {
					$result = array('success' => 'OK');
			} else {
				$result = array('failure' => 'OK');
			}
		}
		$return = $usr_obj->encode($result);
		break;

	case 'get_form_dropdown':
		
		$return['gender'] = $usr_obj->get_gender();
          $return['states'] = $usr_obj->get_states();		
          $return = $usr_obj->encode($return);
		break;
	
	case 'email_validation':		
		$return = $usr_obj->validate_existing_user($usr_obj->encode($_REQUEST));		
		break;

	case 'forgot_password':
		$return = $usr_obj->forgot_password($usr_obj->encode($_REQUEST));
		break;
	
	case 'change_password':
		$old_pass = (isset($_REQUEST['oldpass']))? $_REQUEST['oldpass'] : '';
		$result = $usr_obj->update_password('', $_REQUEST['pass'], $_REQUEST['email'], $old_pass);
		if ($usr_obj->update_password('', $_REQUEST['pass'], $_REQUEST['email'], $old_pass)) {
			$return = $usr_obj->encode(array('success' => 'true'));
		} else {
			$return = $usr_obj->encode(array('failure' => 'true'));
		}
		break;
	
	case 'confirm':
		$table_name = $_REQUEST['table_name'];
		$return = $usr_obj->edit_field($table_name, $_REQUEST);
		break;
	
	case 'user_register':
		$return = $usr_obj->insert_Data($usr_obj->encode($_REQUEST));
		break;
}
 }elseif(!isset($_REQUEST[PARAM_LGD]) || $_REQUEST[PARAM_LGD] == 0){

	switch($action){
		case 'email_validation':		
		$return = $usr_obj->validate_existing_user($usr_obj->encode($_REQUEST));				
		break;
		case 'get_form_dropdown':
		$return['gender'] = $usr_obj->get_gender();
          $return['states'] = $usr_obj->get_states();		
          $return = $usr_obj->encode($return);
		break;
		case 'user_register':
		$return = $usr_obj->insert_Data($usr_obj->encode($_REQUEST));
		break;
		case 'forgot_password':
		$return = $usr_obj->forgot_password($usr_obj->encode($_REQUEST));
		break;
		case 'confirm':
		$table_name = $_REQUEST['table_name'];
		$return = $usr_obj->edit_field($table_name, $_REQUEST);
		break;
		case 'change_password':
		$old_pass = (isset($_REQUEST['oldpass']))? $_REQUEST['oldpass'] : '';
		$result = $usr_obj->update_password('', $_REQUEST['pass'], $_REQUEST['email'], $old_pass);
		if ($usr_obj->update_password('', $_REQUEST['pass'], $_REQUEST['email'], $old_pass)) {
			$return = $usr_obj->encode(array('success' => 'true'));
		} else {
			$return = $usr_obj->encode(array('failure' => 'true'));
		}
		break;
	}
} else {
             $return = $usr_obj->encode($unauth);
         }
		
print $return;

?>