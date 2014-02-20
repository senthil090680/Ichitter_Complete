<?PHP
if (!isset($_SESSION['user_id'])) {
	$user_msg = "$session_expire";
	print"<script>window.location='login.php?msg=$user_msg'</script>";
}
?>