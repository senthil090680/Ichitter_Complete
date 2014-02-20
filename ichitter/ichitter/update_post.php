<?php

session_start();
error_reporting(0);

include("admin/includes/dbobj.php");
include("admin/includes/class.topics.php");
include("admin/includes/class.subtopics.php");
include("services/includes/errMessages.php");
include("services/includes/Logging.php");
include("services/includes/class.gallery.php");

$topicsid = $_REQUEST['topic_id'];

$subtopicid = $_REQUEST['subtopicid'];
$postid = $_REQUEST['postid'];

if($_SESSION['user_id'] != "" ) {
	$user_id = $_SESSION['user_id']; 
}

$gallery = new Gallery();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Frontedpage</title>
	<link rel="stylesheet" type="text/css" href="resource/css/styles.css"/>
	<link rel="stylesheet" href="resource/css/nivo-slider.css" type="text/css" media="screen" />
    <script type="text/javascript" src="resource/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="resource/js/validations.js"></script>
    <link rel="stylesheet" href='resource/css/gallery.css' type="text/css" />
	<!--[if lte IE 7]>
	<link rel="stylesheet" href='resource/css/gallery-ie7.css' type="text/css" />
	<![endif]-->
    <style type=text/css>
		.expandText     {height:auto;}
		.collapseText     {height:30px;overflow:hidden}
	</style>

<script type=text/javascript>
var iCnt =10;

function collapseText(group){
for(var _i=1;_i<=iCnt;_i++)
{
    $("#history" + _i).addClass("collapseText");
    $('#more' + _i + ' img').attr("src","resource/images/more-btn.jpg");
}
//$("#history").slideUp("slow");
$('.morebtn a').click(function(event){

    var id = this.id.replace("more","");

    var checkExpand = $('#more' + id + ' img').attr("src").indexOf("more-btn.jpg");

        if(checkExpand == -1){
            $("#history"+ id).removeClass("expandText");
            $("#history"+ id).addClass("collapseText");
            $('#more' + id + ' img').attr("src","resource/images/more-btn.jpg");
            end;
         } else {

            $("#history"+ id).removeClass("collapseText");
            $("#history"+ id).addClass("expandText");
            $('#more' + id + ' img').attr('src','resource/images/less-btn.png');
         }
    });
}
$(function() {
    collapseText();
    //$('#addPost').click(function(event){});
});

/*
$(document).ready(function(){  
	$("#frmpost").submit(function(){
		
		return false;
    });  
});

*/

</script>
</head>

<body>
<div id="container">
<div id="wrapper">

<div id="header">
<div class="logo"><a href="index.php"><img src="resource/images/logo.png" alt="" border="0" /></a></div>
<div class="homerightpanel">
<?php 
if($_SESSION['user_id'] == "" ) {
?>
<div class="whyreg"><a href="#"></a></div>
<div class="login"><a href="../ichitter/editprofile.html"></a></div>
<?php 
}
?>
</div>
</div>
<div id="main">
<div id="maincontent">
<h1>Update Post</h1>
<!--<div style="border: 0px solid red; text-align: right;padding: 10px 15px 10px 0px;">
<input type="button" name="addPost" id="addPost" value="New Post" />
<div style="border: 0px solid blue; float: left; width: 70px; ">
<input type="button" name="markit" id="markit" value="Mark" />
</div>
</div>
-->

<div class="alltopicwrap">

<form name="frmaddpost" id="frmaddpost" method="post" onsubmit="javascript: return val_post();">
<table align="center" cellpadding="0" cellspacing="0" style="margin:10px; width: 700px; line-height: 30px;">
<tr>
	<td colspan="2" style="width: 175px; text-align: top; height: 40px; text-align: center;"></td>
</tr>
<tr>
	<td>Select Sub Topic :</td>
	<td>
		<select id="lst_subtopic" name="lst_subtopic" class="txt-field">
			<option value="0">--Select--</option>
			<?php
				$subtopics = new subtopics();
				$result = $subtopics->get_allSubtopics(0, $topicsid);
				while($row = mysql_fetch_assoc($result)) {
					$selected = "";
					if($subtopicid == $row["sub_topic_id"]) {
						$selected = " selected=selected";
					}
					
					echo "<option value='" . $row["sub_topic_id"] . "' $selected >" . $row["title"] . "</option>";
				}
			?>
		</select>
	</td>
</tr>
<tr>
	<td style="width: 175px; vertical-align: top;"><div style="float: left; margin: 0px;">Title :</div></td>
	<td><input type="text" name="txttitle" id="txttitle" value="" size="80" /></td>
</tr>
<tr>
	<td style="width: 175px; vertical-align: top;"><div style="float: left; margin: 0px;">Content :</div></td>
	<td><textarea name="txtDesc" id="txtDesc" cols="55" rows="10" style="height: 150px; width:500px;" ></textarea></td>
</tr>
<tr>
	<td>Graphic Type :</td>
	<td>
		<label>Image :<input type="radio" name="gtype" value="I" onclick="toggleSelections('I');" /></label>
		<label>Video :<input type="radio" name="gtype" value="V" onclick="toggleSelections('V');" /></label>
	</td>
</tr>

<tr>
	<td style="width: 175px; vertical-align: top;">Select Image :</td>
	<td style="height: 200px;" >
		<div id="divimg" class="ucipublishedtxt" style="overflow: auto;">
			<ul class="">
		   	<?php 
		   	$rs_GalImg = $gallery->getImagesByUser($user_id);
		   	while($img = mysql_fetch_assoc($rs_GalImg)) {
		   	?>
		   	<li class="photos-individual"><input type="radio" name="rdimg" value="<?php echo $img['image_id'];?>" /><a href="javascript:void(0);"><img src="resource/img/<?php echo $img['image_name'];?>" alt="" border="0" title=""/></a></li>
		   	<?php	
		   	}
		   	/*
		   	?>
		   	
		     <li class="photos-individual"><input type="radio" name="rdimg" value="<?php echo $i++;?>" /><a href="javascript:void(0);"><img src="resource/img/photo02.jpg" alt="" border="0" title=""/></a></li>	     
			 <li class="photos-individual"><input type="radio" name="rdimg" value="<?php echo $i++;?>" /><a href="javascript:void(0);"><img src="resource/img/photo03.jpg" alt="" border="0" title=""/></a></li>	     
			 <li class="photos-individual"><input type="radio" name="rdimg" value="<?php echo $i++;?>" /><a href="javascript:void(0);"><img src="resource/img/photo04.jpg" alt="" border="0" title=""/></a></li>	   
			 <li class="photos-individual"><input type="radio" name="rdimg" value="<?php echo $i++;?>" /><a href="javascript:void(0);"><img src="resource/img/photo05.jpg" alt="" border="0" title=""/></a></li>	   
			 <li class="photos-individual"><input type="radio" name="rdimg" value="<?php echo $i++;?>" /><a href="javascript:void(0);"><img src="resource/img/photo06.jpg" alt="" border="0" title=""/></a></li>	   
			 <li class="photos-individual"><input type="radio" name="rdimg" value="<?php echo $i++;?>" /><a href="javascript:void(0);"><img src="resource/img/photo07.jpg" alt="" border="0" title=""/></a></li>
			 <li class="photos-individual"><input type="radio" name="rdimg" value="<?php echo $i++;?>" /><a href="javascript:void(0);"><img src="resource/img/photo08.jpg" alt="" border="0" title=""/></a></li>
			 <li class="photos-individual"><input type="radio" name="rdimg" value="<?php echo $i++;?>" /><a href="javascript:void(0);"><img src="resource/img/photo09.jpg" alt="" border="0" title=""/></a></li>
			 <li class="photos-individual"><input type="radio" name="rdimg" value="<?php echo $i++;?>" /><a href="javascript:void(0);"><img src="resource/img/photo10.jpg" alt="" border="0" title=""/></a></li>
		   <?php 
		   */
		   ?>
		   </ul>				
		</div>
	</td>
</tr>

<tr>
	<td style="width: 175px; vertical-align: top;">Select Video :</td>
	<td style="height: 200px;">
		<div id="divvdo" class="ucipublishedtxt" style="overflow: auto;">
			<ul class="">
			<?php 
		   	$rs_GalVid = $gallery->getVideosByUser($user_id);
		   	while($vid = mysql_fetch_assoc($rs_GalVid)) {
		   	?>
		   	<li class="photos-individual"><input type="radio" name="rdimg" value="<?php echo $vid['video_id'];?>" /><a href="javascript:void(0);"><img src="resource/img/<?php echo $vid['video_name'];?>" alt="" border="0" title=""/></a></li>
		   	<?php	
		   	}
		   	/*
		   	?>
		     <li class="photos-individual"><input type="radio" name="rdvdo" value="<?php echo $v++;?>" /><a href="javascript:void(0);"><img src="resource/img/photo11.jpg" alt="" border="0" title=""/></a></li>	     
			 
			 <li class="photos-individual"><input type="radio" name="rdvdo" value="<?php echo $v++;?>" /><a href="javascript:void(0);"><img src="resource/img/photo12.jpg" alt="" border="0" title=""/></a></li>	     
			 <li class="photos-individual"><input type="radio" name="rdvdo" value="<?php echo $v++;?>" /><a href="javascript:void(0);"><img src="resource/img/photo13.jpg" alt="" border="0" title=""/></a></li>	     
			 <li class="photos-individual"><input type="radio" name="rdvdo" value="<?php echo $v++;?>" /><a href="javascript:void(0);"><img src="resource/img/photo14.jpg" alt="" border="0" title=""/></a></li>	   
			 <li class="photos-individual"><input type="radio" name="rdvdo" value="<?php echo $v++;?>" /><a href="javascript:void(0);"><img src="resource/img/photo15.jpg" alt="" border="0" title=""/></a></li>	   
			 <li class="photos-individual"><input type="radio" name="rdvdo" value="<?php echo $v++;?>" /><a href="javascript:void(0);"><img src="resource/img/photo16.jpg" alt="" border="0" title=""/></a></li>	   
			 <li class="photos-individual"><input type="radio" name="rdvdo" value="<?php echo $v++;?>" /><a href="javascript:void(0);"><img src="resource/img/photo17.jpg" alt="" border="0" title=""/></a></li>
			 <li class="photos-individual"><input type="radio" name="rdvdo" value="<?php echo $v++;?>" /><a href="javascript:void(0);"><img src="resource/img/photo18.jpg" alt="" border="0" title=""/></a></li>
			 <li class="photos-individual"><input type="radio" name="rdvdo" value="<?php echo $v++;?>" /><a href="javascript:void(0);"><img src="resource/img/photo19.jpg" alt="" border="0" title=""/></a></li>
			 <li class="photos-individual"><input type="radio" name="rdvdo" value="<?php echo $v++;?>" /><a href="javascript:void(0);"><img src="resource/img/photo20.jpg" alt="" border="0" title=""/></a></li>
			 <?php 
		   */
		   ?>
	   	   
		   </ul>				
		</div>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td colspan="2" align="center">
		<input type="hidden" name="topicid" id="topicid" value="<?php echo $topicsid; ?>" />	
		<input type="submit" name="psubmit" id="psubmit" value="AddPost" /> 
	</td>
</tr>
</table>
</form>

</div>
<div class="homeboxwrap">
<?php
/*
      $topics    =    new subtopics;
      $result = $topics->get_topicsByPriorityOrder(6,$topicsid);
      //echo $result;
      while($row = mysql_fetch_row($result))
      {
        echo '<div class="homebox">';
        echo '<div class="homeboxtop"><img src="resource/images/homebox1.jpg" alt="" /></div>';
        echo '<div class="homeboxmid">';
        echo '<div class="homeboxmidhead"><a href="federal-history.html">'. $row[2]  .'</a></div>';
        echo '<img src="upload_image/'.$row[4] .'" alt="" style="height: 75px; width: 213px;" />';
        echo '<p><b>6,321</b> articles | <b>20,000</b> views | <b>8 6,425</b> opinions</p>';
        echo '</div>';
        echo '<div class="homeboxbot"><img src="resource/images/homebox3.jpg" alt="" /></div></div>';
      }
*/
?>

</div>

</div>
<div id="mainright">
<div class="freetrial"><img src="resource/images/free-trial.jpg" align="free trial" /></div>
<div class="coke"><img src="resource/images/coke.jpg" align="free trial" /></div>


<div class="rbox">
<div class="rboxlft"><img src="resource/images/rbox1.jpg" /></div>
<div class="rboxmidgate">
<img src="resource/images/relatedhead.png" alt="" />
<ul style="width:213px; margin-left:-3px;">
<li style="background:url(resource/images/c1.jpg) top left no-repeat; height:38px; width:213px; border:none;"><p><a href="#">Category Name 01</a></p>
</li>
<li style="background:url(resource/images/c2.jpg) top left no-repeat; height:38px; width:213px; border:none;"><p><a href="#">Category Name 02</a></p>
</li>
<li style="background:url(resource/images/c3.jpg) top left no-repeat; height:38px; width:213px; border:none;"><p><a href="#">Category Name 03</a></p>
</li>
<li style="background:url(resource/images/c4.jpg) top left no-repeat; height:38px; width:213px; border:none;"><p><a href="#">Category Name 04</a></p>
</li>
</ul>
</div>
<div class="rboxrgt"><img src="resource/images/rbox3.jpg" /></div>
</div>
 

</div>

</div>
<div id="footer">
<div class="social">
<ul>
<p>Join Us</p>
<li><a href="#"><img src="resource/images/facebook.jpg" alt="facebook" border="0" /></a></li>
<li><a href="#"><img src="resource/images/twitter.jpg" alt="twitter" border="0" /></a></li>
<li><a href="#"><img src="resource/images/myspace.jpg" alt="myspace" border="0" /></a></li>
<li><a href="#"><img src="resource/images/digg.jpg" alt="digg" border="0" /></a></li>
<li><a href="#"><img src="resource/images/orkut.jpg" alt="orkut" border="0" /></a></li>
</ul>

</div>

<div class="footernavi">
      <ul>
        <li ><a href="#">Privacy Policy</a></li>
        <li ><a href="#">Site Map</a></li>
        <li style="border-right:none;"><a href="#">Contact Us</a></li>
       </ul>
       <div class="copyright"><p>© 2011</p><img src="resource/images/footer-logo.jpg" alt="" /></div>
           </div>
</div>
</div>
</div>
</body>
</html>
