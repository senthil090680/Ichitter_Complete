<?php
require_once 'includes/includes.inc';

#####################################################
#                VALIDATE LOGIN                     #
#####################################################

$username = $_POST['username'];
$password = $_POST['password'];

$auth = new authenticate();
$result = $auth->validate_user($username, $password);

if ($result) {
	$_SESSION['user_id'] = $auth->LOGIN_ID;
	$_SESSION['role_id'] = $auth->ROLE_ID;
	$_SESSION['user_name'] = $auth->USERNAME;
	$_SESSION['last_logged'] = $auth->LAST_LOGGEDIN;
	print "<script>window.location='add_topics.php'</script>";
} else {
	print "<script>window.location='login.php?msg=Invalid Username or password'</script>";
}
?>

