<?php
// print_r ( $_REQUEST );
if (( $_REQUEST["UserName"]=="" )|| ($_REQUEST["Password"]=="")) {
echo "user name and pwasswor is empty";
print  "<script>
window.location='login.php';
  </script>;";
}
$connection = mysql_connect("localhost","FrontedPage","IChitter") or die ("couldnot connect to server");
$dbname 	= "FrontedPage";
mysql_select_db($dbname);
$query = "select user_name,password from tbl_login where user_name like '$_REQUEST[UserName]' and password like '$_REQUEST[Password]';";
$result = mysql_query($query);
if($row = mysql_fetch_row($result))
{
print "<script> alert('Loggedin successfully'); 
  window.location='add_topics.php';
  </script>;";
//echo " Loggedin successfully";
// For valid users, redirect the pa
}
else{
   print_r ( $row );
print " <script> alert('Invalid loing name / password' ); 
  	window.location='login.php';
  </script>;";
 //echo "  Invalid loing name / password";
}
// print_r ( $result );
?>