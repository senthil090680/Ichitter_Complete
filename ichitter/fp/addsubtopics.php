<?php
include_once 'library/include_files.php';
//include_once 'common/redirectto.php';

$topicsid = $_REQUEST[PARAM_TOPICID];
$currentPage = $_REQUEST[PARAM_CURRENT_PAGE];
$subtopicid = $_REQUEST[PARAM_SUBTOPICID];

$user_id = "";
if ($_SESSION['login']['user_id'] != "") {
	$user_id = $_SESSION['login']['user_id'];
}

$REQ_SEND[PARAM_ACTION] = "getsubtopicslist";
$REQ_SEND[PARAM_TOPICID] = "$topicsid";
$REQ_SEND[PARAM_SUBTOPICID] = "$subtopicid";

$ObjCURL = new INIT_PROCESS(SUBTOPIC_SERVICE_PAGE, $REQ_SEND);
$SubTopicList = Object2Array($ObjJSON->decode($ObjCURL->response));

$REQ_SEND[PARAM_ACTION] = "gettopicslist";
$ObjCURL = new INIT_PROCESS(TOPIC_SERVICE_PAGE, $REQ_SEND);
$Topicslist = Object2Array($ObjJSON->decode($ObjCURL->response));
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title><?php echo ALL_PAGE_TITLE; ?></title>
		<link rel="stylesheet" href="admin/css/general.css" type="text/css" media="screen" />
		<link rel="stylesheet" type="text/css" href="resource/css/styles.css"/>
		<script type="text/javascript" src="resource/js/custom-form-elements.js"></script>
		<script type="text/javascript" src="resource/js/jquery-1.6.1.min.js"></script>
		<script type="text/javascript">
			var iCnt = 0;
			var gid = "<?php echo PARAM_GRAPHIC_ID; ?>";
		</script>
		<link rel="stylesheet" href="resource/css/ddsmoothmenu.css" type="text/css" media="screen" />
		<script type="text/javascript" src="resource/js/ddsmoothmenu.js"></script>
		<script type="text/javascript" src="resource/js/validations.js"></script>
		<link rel="stylesheet" href='resource/css/gallery.css' type="text/css" />
		<script src="resource/js/popup-gallery.js" type="text/javascript"></script>
		<link rel="stylesheet" type="text/css" href="resource/css/login-style.css"/>
		<script src="resource/js/common.js" type="text/javascript"></script>
		<!--[if lte IE 7]>
		<link rel="stylesheet" href='resource/css/gallery-ie7.css' type="text/css" />
		<![endif]-->
    </head>
    <body>
		<div id="container">
			<div id="wrapper">
				<?php include_once ('common/header.php'); ?>  
				<div id="main">
					<div id="maincontent">
						<h1 class="dischdr">
							Add Topic
							<div class="gotopost" >
								<a href="subtopics.php?<?php echo PARAM_TOPICID . "=" . $topicsid; ?>"><?php echo LINKTO_GO_TO_POSTING; ?></a>
								| <a href="markedlist.php?<?php echo PARAM_TOPICID . "=" . $topicsid; ?>"><?php echo LINKTO_MY_MARKED_LIST; ?></a>
							</div>
						</h1>
						<div class="alltopicwrap">
							<div class="secadd">
								<a href="addtopics.php">Add Topic</a>
							</div>
							<form name="frmaddsubtopics" action="subtopic_process.php" method="post" onsubmit="return val_AddNewSubTopics();">
								<div class="all-container">
									<div class="msg-container">
										<?php
										if (isset($_REQUEST['msg'])) {
											$er = $_REQUEST['msg'];
											print "<div class='emsg'>" . $$er . "</div>";
										}
										?>
									</div>
									<div class="mtspace"></div>
									<div class="flds-container">
										<div class="ttl-container">
											<span class='fld-titles'> Topic Title* : </span>
										</div>
										<div class="ip-container">
											<span class='fld-inputs'>
												<select id="st_topics" name="st_topics" class="txt-field">
													<option value="0">--Select--</option>
													<?php
													if (count($Topicslist) > 0) {
														foreach ($Topicslist as $idx => $rec) {
															$selected = "";
															if ($topicsid == $rec['topics_id']) {
																$selected = " selected=selected";
															}
															echo "<option value='" . $rec['topics_id'] . "' $selected>" . $rec['title'] . "</option>";
														}
													}
													?>
												</select>
											</span>
										</div>
									</div>
									<div class="mtspace"></div>
									<div class="flds-container">
										<div class="ttl-container">
											<span class='fld-titles'>Sub Topic Title* :</span>
										</div>
										<div class="ip-container">
											<span class='fld-inputs'><input type="text" name="st_title" id="st_title"  class="txt-field"/></span>
										</div>
									</div>
									<div class="mtspace"></div>
									<div class="flds-container">
										<div class="ttl-container">
											<span class='fld-titles'>Sub Topic Description :</span>
										</div>
										<div class="ip-container">
											<span class='fld-inputs'><textarea name="st_desc" id="st_desc" class="txt-area" rows="10" cols="20"></textarea></span>
										</div>
									</div>
									<div class="mtspace"></div>
									<div class="flds-container">
										<div class="ttl-container">
											<span class='fld-titles'>Sub Topic Image* :</span>
										</div>
										<div class="ip-container">
											<span class='fld-inputs'><input type="button" id="imgGal1" value="Select" onclick="toggleSelections('I');" /></span>
										</div>
									</div>
									<div class="slcimg">
										<div class="mtspace"></div>
										<div class="flds-container">
											<div class="ttl-container">
												<span class='fld-titles'>Selected Image :</span>
											</div>
											<div class="ip-container">
												<div id="imgSrc"></div>
											</div>
										</div>
									</div>
									<div class="mtspace"></div>
									<div class="flds-container">
										<div class="submitbtn">
											<input type="image" name="psubmit" id="psubmit" src="resource/images/add-sub-topic.png" value="addsubtopic" onclick="javascript: return val_AddNewSubTopics();" />
											<input type="hidden" id="<?php echo PARAM_ACTION; ?>" name="<?php echo PARAM_ACTION; ?>" value="addsubtopic" />
											<input type="hidden" name="<?php echo PARAM_GRAPHIC_ID; ?>" id="<?php echo PARAM_GRAPHIC_ID; ?>" value="" />
										</div>
									</div>
								</div>
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
		include_once 'common/image_gallery.php';
		?>
		<div id="backgroundPopup"></div>
    </body>
</html>
