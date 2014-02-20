<?php
include_once 'library/include_files.php';

$topicsid = $_REQUEST[PARAM_TOPICID];
$topicid = $topicsid;

$msg = "";
$msg = $_REQUEST[PARAM_MESSAGE];

$user_id = "";
if ($_SESSION['login']['user_id'] != "") {
    $user_id = $_SESSION['login']['user_id'];
}
$usid = $user_id;
include_once 'common/getposting.php';

$currentPage = $page_info['basename'];
$val = "st";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title><?php echo ALL_PAGE_TITLE; ?></title>
	<!--[if IE 7]>
	<link href="resource/css/style-ie7.css" rel="stylesheet" type="text/css" />
	<![EndIf]-->
	<link rel="stylesheet" href="admin/css/general.css" type="text/css" media="screen" />
	<link rel="stylesheet" type="text/css" href="resource/css/styles.css"/>
	<link rel="stylesheet" type="text/css" href="resource/css/login-style.css"/>
	<link rel="stylesheet" href="resource/css/ddsmoothmenu.css" type="text/css" media="screen" />
	<script type="text/javascript" src="resource/js/ddsmoothmenu.js"></script>
	<link rel="stylesheet" href="resource/css/nivo-slider.css" type="text/css" media="screen" />
	<script type="text/javascript" src="resource/js/custom-form-elements.js"></script>
	<script type="text/javascript" src="resource/js/jquery-1.6.1.min.js"></script>
	<script type="text/javascript" src="resource/js/jquery.nivo.slider.js"></script>
	<script type="text/javascript" src="resource/js/popup-gallery.js"></script>
	<script type="text/javascript">
	    var iCnt = <?php echo $num_rows ?>;
		//var topic_id = <?php echo $topicsid; ?>;
	    var QSTRING = "<?php echo $_SERVER["QUERY_STRING"] ?>";
		$(function() {
			collapseText();
		});
		
	</script>
	<script type="text/javascript" src="resource/js/common.js"></script>
    </head>
    <body>
	<div id="container">
	    <div id="wrapper">
		<?php include_once 'common/header.php'; ?>
		<form name="frmMarks" id="frmMarks" action="posting_process.php">
		    <div id="main">
				<div id="maincontent">
					<?php
					include_once 'common/list_postings.php';
					include_once 'common/list_subtopics.php';
					?>
				</div>
				<?php include_once 'common/right_side.php'; ?>
		    </div>
		    <input type="hidden" name="<?php echo PARAM_TOPICID; ?>" id="<?php echo PARAM_TOPICID; ?>" value="<?php echo $topicsid; ?>" />
		    <input type="hidden" name="<?php echo PARAM_CURRENT_PAGE; ?>" id="<?php echo PARAM_CURRENT_PAGE; ?>" value="st" />
			<input type="hidden" name="<?php echo PARAM_ACTION; ?>" id="<?php echo PARAM_ACTION; ?>" value="markall" />
		</form>
		<?php include_once 'common/footer.php'; ?>
	    </div>
	</div>
    </body>
</html>