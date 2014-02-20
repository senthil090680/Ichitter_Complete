<?php
#####################################################
# RESET LOGIN
#####################################################
session_start();
session_destroy();
print"<script>window.location='login.php?msg=Logged out successfully'</script>";
?>

