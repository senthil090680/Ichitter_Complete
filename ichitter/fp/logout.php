<?php
include_once 'library/include_files.php';

$user_id = $_SESSION["login"]["user_id"];

$post_array = array(
	"user_id"=>$user_id,
	"bflogout"=>"bf_logout"
);

$result = array();
$ObjCURL = new INIT_PROCESS(LOGOUT_SERVICE_PAGE, $post_array);
$result = Object2Array($ObjJSON->decode($ObjCURL->response));
session_destroy();
print "<script>window.location='index.php'</script>";
?>