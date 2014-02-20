<?php
include_once 'library/include_files.php';

$user_id = "";
if ($_SESSION['login']['user_id'] != "") {
    $user_id = $_SESSION['login']['user_id'];
}
$postid = "";
$topicid = "";
$subtopicid = "";
$userid = $user_id;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title><?php echo ALL_PAGE_TITLE; ?></title>
		<link rel="stylesheet" type="text/css" href="resource/css/styles.css"/>
		<link rel="stylesheet" type="text/css" href="resource/css/login-style.css"/>
		<!--[if IE 7]>
		<link rel="stylesheet" type="text/css" href="resource/css/style-ie7.css"/>
		<![EndIf]-->
		<link rel="stylesheet" href="resource/css/ddsmoothmenu.css" type="text/css" media="screen" />
		<script type="text/javascript" src="resource/js/ddsmoothmenu.js"></script>
		
		<link rel="stylesheet" href="resource/css/nivo-slider.css" type="text/css" media="screen" />
		<script type="text/javascript" src="resource/js/jquery-1.6.1.min.js"></script>
		<script type="text/javascript" src="resource/js/jquery.nivo.slider.js"></script>
		<script type="text/javascript" src="resource/js/popup-gallery.js"></script>
		<script type="text/javascript">
			var iCnt = 3;
			$(function() {
				$('#slider').nivoSlider();
				collapseText();
			});
			
			
		</script>
		<script type="text/javascript" src="resource/js/common.js"></script>
    </head>
    <body>
	<div id="container">
	    <div id="wrapper">
		<?php include_once 'common/header.php'; ?>
		<div id="main">
		    <div id="maincontent">
			<?php echo (isset($_REQUEST['success']) && $_REQUEST['success'] == 'forgot_success') ? '<div class="youaccount"><p>Your Forgot Password request is succeeded. Please check and follow your email to reset your password.</p></div>' : ''; ?>
			<h1>Welcome To The Discussion Forum</h1>
			<div class="bannerwrap">
			    <div class="slider-wrapper theme-default">
				<div id="slider" class="nivoSlider">
				    <img src="resource/images/banner1.jpg" alt=""  />
				    <img src="resource/images/banner2.jpg" alt="" />
				    <img src="resource/images/banner3.jpg" alt="" />
				</div>
			    </div>
			</div>
			<?php
			include_once 'common/list_topics.php';
			include_once 'common/list_postings_index.php';
			?>
		    </div>
		    <?php include_once 'common/right_side.php'; ?>
		</div>
		<?php include_once 'common/footer.php'; ?>
	    </div>
	</div>
    </body>
</html>