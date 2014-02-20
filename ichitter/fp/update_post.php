<?php
include_once 'library/include_files.php';

include_once 'common/redirectto.php';

$topicsid = $_REQUEST[PARAM_TOPICID];
$subtopicid = $_REQUEST[PARAM_SUBTOPICID];
$postid = $_REQUEST[PARAM_POSTID];
$currentPage = $_REQUEST[PARAM_CURRENT_PAGE];

$user_id = "";
if ($_SESSION['login']['user_id'] != "") {
	$user_id = $_SESSION['login']['user_id'];
}

$REQ_SEND[PARAM_ACTION] = "gettitles";
$REQ_SEND[PARAM_USERID] = "$user_id";
$REQ_SEND[PARAM_TOPICID] = "$topicsid";
$REQ_SEND[PARAM_SUBTOPICID] = "";
$REQ_SEND[PARAM_POSTID] = "";
$REQ_SEND[PARAM_ORDER] = "DESC";
$REQ_SEND[PARAM_LIMIT] = "ALL";
$REQ_SEND[PARAM_IS_ARCHIVED] = "0";

$ObjCURL = new INIT_PROCESS(SUBTOPIC_SERVICE_PAGE, $REQ_SEND);
$SubTopicDetails = Object2Array($ObjJSON->decode($ObjCURL->response));

$REQ_SEND[PARAM_ACTION] = "listpost";
$REQ_SEND[PARAM_POSTID] = "$postid";
$REQ_SEND[PARAM_TOPICID] = "$topicsid";
$REQ_SEND[PARAM_SUBTOPICID] = "$subtopicid";
$REQ_SEND[PARAM_USERID] = "$user_id";
$REQ_SEND[PARAM_ORDER] = "DESC";
$REQ_SEND[PARAM_LIMIT] = "1";
$REQ_SEND[PARAM_IS_ARCHIVED] = "0";
$REQ_SEND[PARAM_IS_MARKED] = false;

$ObjCURL = new INIT_PROCESS(POSTING_SERVICE_PAGE, $REQ_SEND);
$result = array();
$result = Object2Array($ObjJSON->decode($ObjCURL->response));

$PostDtl = $result[0];
$topicTitle = $PostDtl['topic'];

$imgPath = "resource/images/no-img.jpg";
$vdoPath = "resource/images/videotemp.jpg";

$gtype = $PostDtl['graphic_type'];
$db_userid = $PostDtl['user_id'];
$db_imageid = $PostDtl['image_id'];
$db_igalname = $PostDtl['igallery_name'];
$db_iname = $PostDtl['image_name'];
$db_videoid = $PostDtl['video_id'];
$db_vgalname = $PostDtl['vgallery_name'];
$db_vname = $PostDtl['video_name'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title><?php echo ALL_PAGE_TITLE; ?></title>
		<link rel="stylesheet" href="admin/css/general.css" type="text/css" media="screen" />
		<link rel="stylesheet" type="text/css" href="resource/css/styles.css"/>
		<link rel="stylesheet" href="resource/css/nivo-slider.css" type="text/css" media="screen" />
		<script type="text/javascript" src="resource/js/custom-form-elements.js"></script>
		<link rel="stylesheet" href="resource/css/ddsmoothmenu.css" type="text/css" media="screen" />
		<script type="text/javascript" src="resource/js/ddsmoothmenu.js"></script>
		<script type="text/javascript" src="resource/js/jquery-1.6.1.min.js"></script>
		<script type="text/javascript">
			var iCnt = 0;
			var txtDesc = "<?php echo PARAM_POST_CONTENT; ?>";
			var txtTitle = "<?php echo PARAM_POST_TITLE; ?>";
			var cbSubTopic = "<?php echo PARAM_LIST_SUBTOPIC; ?>";
		</script>
		<script type="text/javascript" src="resource/js/validations.js"></script>
		<link rel="stylesheet" href='resource/css/gallery.css' type="text/css" />
		<script src="resource/js/popup-gallery.js" type="text/javascript"></script>
		<link rel="stylesheet" type="text/css" href="resource/css/login-style.css"/>
		<script src="resource/js/common.js" type="text/javascript"></script>
		<!--[if lte IE 7]>
		<link rel="stylesheet" href="resource/css/gallery-ie7.css" type="text/css" />
		<![endif]-->
	</head>

    <body>
		<div id="container">
			<div id="wrapper">
				<?php include_once ('common/header.php'); ?>  
				<div id="main">
					<div id="maincontent">
						<h1 class="dischdr">Modify Post
							<div class="gotopost" >
								<a href="subtopics.php?<?php echo PARAM_TOPICID . "=" . $topicsid; ?>"><?php echo LINKTO_GO_TO_POSTING; ?></a>
								 | <a href="markedlist.php?<?php echo PARAM_TOPICID . "=" . $topicsid; ?>"><?php echo LINKTO_MY_MARKED_LIST; ?></a>
							</div>
						</h1>
						<div class="alltopicwrap">
							<?php /* 
							<div class="secadd">
<!--								<a href="javascript: void(0);">Add Topic</a>-->
								<a href="javascript: void(0);"  id="frm-topics">Add Topic</a>
								 | <a href="javascript: void(0);" id="frm-subtopics">Add SubTopic</a>
							</div>
							  */ ?>
							<form name="frmaddpost" id="frmaddpost" method="post" onsubmit="javascript: return val_post();">
								<table align="center" cellpadding="0" cellspacing="0" class="tblpost">
									<tr>
										<td colspan="2">&nbsp;</td>
									</tr>
									<tr class="hig">
										<td class="addposttbl">Topic Title :</td>
										<td><div class="topictitle"><?php echo $topicTitle; ?></div></td>
									</tr>
									<tr class="hig">
										<td class="addposttbl">Select Sub Topic :</td>
										<td>
											<div class="blogselect">
												<select id="<?php echo PARAM_LIST_SUBTOPIC; ?>" name="<?php echo PARAM_LIST_SUBTOPIC; ?>" class="selectInput">
													<option value="0">----------Select-----------</option>
													<?php
													if (count($SubTopicDetails) > 0) {
														foreach ($SubTopicDetails as $key => $subtopic) {
															$selected = "";
															if ($subtopicid == $subtopic["sub_topic_id"]) {
																$selected = " selected=selected";
															}
															echo "<option value='" . $subtopic["sub_topic_id"] . "' $selected >" . $subtopic["subtopic"] . "</option>";
														}
													}
													?>
												</select>
											</div>
										</td>
									</tr>
									<tr class="hig">
										<td class="addposttbl">Title :</td>
										<td><div class="blogtitle"><input type="text" class="searchInput" name="<?php echo PARAM_POST_TITLE; ?>" id="<?php echo PARAM_POST_TITLE; ?>" value="<?php echo $PostDtl['title']; ?>" size="20" /></div></td>
									</tr>
									<tr class="hig">
										<td class="addposttbl">Content :</td>
										<td><div class="blogtextarea"><textarea name="<?php echo PARAM_POST_CONTENT; ?>" id="<?php echo PARAM_POST_CONTENT; ?>" class="searchInputbig"  cols="55" rows="10" ><?php echo $commonFunc->br2nl(htmlspecialchars_decode($PostDtl['post_content'])); ?></textarea></div></td>
									</tr>
									<tr>
										<td class="addposttbl">Input Graphic :</td>
										<td>
											<?php
											$ichecked = "";
											$vchecked = "";
											if ($gtype == 'I') {
												$ichecked = " checked='checked' ";
												$vchecked = "";
											} else {
												$ichecked = "";
												$vchecked = " checked='checked' ";
											}
											?>
											<label id="imgGal1"><div style="float:left; margin:5px 0px 0px 5px; padding:0px;"><input type="radio" id="imgGal" name="<?php echo PARAM_GRAPHIC_TYPE; ?>" value="I" class="styled" onclick="toggleSelections('I');" <?php echo $ichecked; ?>/></div><div style="float:left; cursor:hand;"> Image</div></label>
											&nbsp;&nbsp;
											<label id="vdoGal1"><div style="float:left; margin:5px 0px 0px 5px; padding:0px;"><input type="radio" name="<?php echo PARAM_GRAPHIC_TYPE; ?>" id="vdoGal"  value="V" class="styled" onclick="toggleSelections('V');" <?php echo $vchecked; ?> /></div><div style="float:left; cursor:hand;">Video </div></label>
										</td>
									</tr>
									<tr class="slcimg1">
										<td class="addposttbl">
											<div id="selGrap">Selected Graphic :</div>
										</td>
										<td>
											<?php
											if ($gtype == 'I') {
												if ($db_imageid != "0") {
													$imgPath = IMAGE_UPLOAD_SERVER . $db_userid . '/' . $db_igalname . '/' . $db_iname;
												}
												?>
												<div id="imgSrc"><img src='<?php echo urldecode($imgPath); ?>' border='0' alt='' title='' style='width: 200px; border: 2px solid #d4989a;' /></div>
											<?php
											}
											else {
												if ($db_videoid != "0") {
													$video_name = $db_vname;
													$video_thumb_name = substr($video_name, 0, strlen($video_name) - 3) . "jpg";
													$vdoPath = VIDEO_UPLOAD_SERVER . $db_userid . '/' . $db_vgalname . '/thumb/' . $video_thumb_name;
												}
											?>
												<div id="imgSrc"><img src='<?php echo urldecode($vdoPath); ?>' border='0' alt='' title='' style='width: 200px; border: 2px solid #d4989a;' /></div>
											<?php
											}
											?>
										</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td colspan="2" align="center">
											<?php if ($gtype == 'I') { ?>
											<input type="hidden" name="rdimg" id="rdimg" value="<?php echo $db_imageid; ?>" />
											<?php } else { ?>
											<input type="hidden" name="rdimg" id="rdimg" value="<?php echo $db_videoid; ?>" />
											<?php } ?>
											<input type="hidden" name="<?php echo PARAM_POSTID; ?>" id="<?php echo PARAM_POSTID; ?>" value="<?php echo $postid; ?>" />
											<input type="hidden" name="<?php echo PARAM_TOPICID; ?>" id="<?php echo PARAM_TOPICID; ?>" value="<?php echo $topicsid; ?>" />
											<input type="hidden" name="<?php echo PARAM_SUBTOPICID; ?>" id="<?php echo PARAM_SUBTOPICID; ?>" value="<?php echo $subtopicid; ?>" />
											<input type="hidden" name="<?php echo PARAM_CURRENT_PAGE; ?>" id="<?php echo PARAM_CURRENT_PAGE; ?>" value="<?php echo $currentPage; ?>" />
											<input type="hidden" name="<?php echo PARAM_ACTION; ?>" id="<?php echo PARAM_ACTION; ?>" value="Update" />
											<div class="updatepost">
												<input type="image" name="psubmit" id="psubmit" src="resource/images/updatepost.png" value="Update" />
											</div>
										</td>
									</tr>
								</table>
							</form>

						</div>
					</div>
					<?php include_once 'common/right_side.php'; ?>
				</div>
				<?php include_once 'common/footer.php'; ?>
			</div>
		</div>
		<?php
		$imgSource = "resource/images/no-img.jpg";
		$vdoSource = "resource/images/videotemp.jpg";

		include_once 'common/image_gallery.php';
		include_once 'common/video_gallery.php';
		?>
		<div id="backgroundPopup"></div>
    </body>
</html>