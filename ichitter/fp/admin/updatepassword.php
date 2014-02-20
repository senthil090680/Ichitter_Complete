<?php

#####################################################
# VALIDATE LOGIN 
#####################################################
require_once 'includes/includes.inc';

$username = $_SESSION['user_name']; //$_POST['username'];
$oldpassword = $_POST['oldpassword'];
$newpassword = $_POST['newpassword'];
//echo $username . ' ' . $oldpassword . ' ' . $newpassword;

$log = new authenticate;
$result = $log->check_old_password($username, $oldpassword);
//echo "result ". $result . " oldpassword: ". $oldpassword;
if ($result != "") {
	if ($oldpassword == $result) {
		//echo "\nresult i ". $result . "oldpassword: ". $oldpassword;
		$result1 = $log->update_password($username, $newpassword);
		//echo "result1 O:". $result1;
		if ($result1) {
			//echo "result1 ". $result1;
			print "<script>window.location='changepassword.php?msg=Password Changed Successfully'</script>";
		} else {
			print "<script>window.location='changepassword.php?msg=Password not changed. Try again.'</script>";
		}
	} else {
		print "<script>window.location='changepassword.php?msg=Password not found'</script>";
	}
} else {
	print "<script>window.location='changepassword.php?msg=Invalid Username'</script>";
}
?>