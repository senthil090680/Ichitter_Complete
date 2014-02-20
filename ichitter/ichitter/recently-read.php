<?php
require_once 'lib/include_files.php';
require_once('lib/profile_photo_include.php');
//error_reporting(E_ALL);
if (isset($_REQUEST['logout']) && $_REQUEST['logout'] == 'OK') {
	$session_obj->unset_Session('login');
	echo "<script>window.location = 'index.php'</script>";
}

if (trim($_SESSION['login']['user_id']) == '') {
	echo "<script>window.location = 'index.php'</script>";
}

$data = array('get_user_record' => 1, 'user_id' => $session_obj->get_Session('user_id'));
$init_process_obj = new INIT_PROCESS(REGISTRATION_SERVICE, $data);
$user_data = $ObjJSON->objectToArray($ObjJSON->decode($init_process_obj->response));

$REQ_SEND[PARAM_ACTION] = "geticposts";
$REQ_SEND[PARAM_POSTID] = "";
$REQ_SEND[PARAM_TOPICID] = "";
$REQ_SEND[PARAM_SUBTOPICID] = "";
$REQ_SEND[PARAM_USERID] = $session_obj->get_Session('user_id');
$REQ_SEND[PARAM_ORDER] = "ASC";
$REQ_SEND[PARAM_LIMIT] = "";
$REQ_SEND[PARAM_IS_ARCHIVED] = "";
$REQ_SEND[PARAM_IS_MARKED] = false;
$REQ_SEND["MY_RECENTS"] = "IREAD";

$sort = '0';
if(isset($_REQUEST['lbsort'])) {
	$REQ_SEND[PARAM_SORT_ORDER] = $_REQUEST['lbsort'];
	$sort = $_REQUEST['lbsort'];
} 
if($sort == 0) {
	$REQ_SEND[PARAM_SORT_ORDER] = 'r';
}

$srv_post = new INIT_PROCESS(POSTING_SERVICE, $REQ_SEND);
$posts = Object2Array($ObjJSON->decode($srv_post->response));
$total_posts = count($posts);
$REQ_SEND["MY_RECENTS"] = "";
require_once 'common/header1.php';
?>
<script type="text/javascript">
	var iCnt = <?php echo $total_posts; ?>;
	$(function() { collapseText(); });
</script>

<div id="contentLeft">
	<div id="profPhoto"><img width="86" height="106" src="<?php echo $profile_img; ?>" /><br /><?php echo $user_name; ?></div>		
	<?php require_once('lib/group_header_include.php'); ?>
	<div class="line"></div>
	<div id="leftmenulist">	
		<?php include_once ('common/side_navigation.php'); ?>
	</div>
	<div id="mainupload">	
		<div class="posting" style="margin-bottom:10px;">Recently Read</div>
		<?php include_once 'common/postings_list.php'; ?>
	</div>
</div>
<div id="contentRight">
	<?php include_once ('common/right_side_navigation.php'); ?>
</div>
<?php require_once 'common/footer1.php'; ?>	