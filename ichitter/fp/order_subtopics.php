<?php
include_once 'library/include_files.php';
include_once 'common/redirectto.php';

$user_id = "";
if ($_SESSION['login']['user_id'] != "") {
	$user_id = $_SESSION['login']['user_id'];
}
$message = "";
if (isset($_REQUEST['msg'])) {
	$message = urldecode($_REQUEST['msg']);
}

$topicsid = "0";
if (isset($_REQUEST['id']) != "") {
	$topicsid = $_REQUEST['id'];
}


$REQ_SEND[PARAM_ACTION] = "gettopicslist";
$ObjCURL = new INIT_PROCESS(TOPIC_SERVICE_PAGE, $REQ_SEND);
$Topicslist = Object2Array($ObjJSON->decode($ObjCURL->response));

$REQ_SEND[PARAM_ACTION] = "list2order";
$REQ_SEND[PARAM_USERID] = "$user_id";
$REQ_SEND[PARAM_TOPICID] = "$topicsid";
$REQ_SEND[PARAM_LIMIT] = "";

$ObjCURL = new INIT_PROCESS(SUBTOPIC_SERVICE_PAGE, $REQ_SEND);
$result = Object2Array($ObjJSON->decode($ObjCURL->response));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title><?php echo ALL_PAGE_TITLE; ?></title>
		<link rel="stylesheet" type="text/css" href="resource/css/styles.css"/>
		<script type="text/javascript" src="resource/js/jquery-1.3.2.min.js"></script>
		<script type="text/javascript" src="resource/js/jquery-ui-1.7.1.custom.min.js"></script>
		<link rel="stylesheet" href="resource/css/ddsmoothmenu.css" type="text/css" media="screen" />
		<script type="text/javascript" src="resource/js/ddsmoothmenu.js"></script>
		<script type="text/javascript" src="resource/js/common.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				var order;
				$("#listtbl").sortable({
					handle : '.handle',
					update : function () {
						order = $("#listtbl").sortable('serialize');
					}
				});

				$("#btnSubmit").click(function() {
					orderUserSubTopics(order);
				});
			});
		</script>
    </head>
    <body>
		<div id="container">
			<div id="wrapper">
				<?php include_once ('common/header.php'); ?>  
				<div id="main">
					<div id="maincontent">
						<h1 class="dischdr">
							Order  Sub Topics
							<?php /*
							  <div class="gotopost" >
							  <a href="subtopics.php?<?php echo PARAM_TOPICID . "=" . $topicsid; ?>"><?php echo LINKTO_GO_TO_POSTING; ?></a>
							  | <a href="markedlist.php?<?php echo PARAM_TOPICID . "=" . $topicsid; ?>"><?php echo LINKTO_MY_MARKED_LIST; ?></a>
							  </div>

							 */
							?>
						</h1>
						<div class="alltopicwrapord">
							<?php /*
							  <div class="secadd">
							  <a href="javascript: void(0);"  id="frm-topics">Add Topic</a>
							  | <a href="javascript: void(0);" id="frm-subtopics">Add SubTopic</a>
							  </div>

							 */
							?>
							<form name="frmedittopics" action="orderupdate.php?action=ordersubtopics" method="post" enctype="multipart/form-data">
								<br />
								<div style="font-size: 12px; width:900px; text-align:left; float: left; height: 50px; color:#FF00FF; font-style:italic;">
									* Drag the Sub Topic item by clicking and hold the pointer <img src="resource/images/arrow.png" /> to rearrange. <br/></div>
								<ul id="info"></ul>
								<table width="95%" border="0" align="center" cellpadding="0"  cellspacing="0">
									<tr>
										<td style=" width: 130px;height: 30px; overflow:hidden; font-size:12px;">
											<span style="padding-left:30px;">Select Topic :</span></td>
										<td align="left">
											<select id="TopicTitle" name="TopicTitle" class="txt-fieldst" onchange="dd_subtopics(this)" onload="dd_subtopics(this)">
												<option value="0">--Select--</option>
												<?php
												foreach ($Topicslist as $key => $row) {
													$selectedTopicId = "";
													if ($row['topics_id'] == $topicsid)
														$selectedTopicId = "selected";
													echo "<option value='" . $row['topics_id'] . "' " . $selectedTopicId . ">" . $row['title'] . "</option>";
												}
												?>
											</select>
										</td>
									</tr>
								</table>
								<table border="0" align="center" cellpadding="0"  cellspacing="0" class="wid" >
									<tr>
										<td id="tdRowId">
											<?php
											$rowId = 0;
											$rowId = count($result);
											echo "<ul id='listtbl2'>";
											for ($i = 1; $i <= $rowId; $i++) {
												echo "<li>" . $i . "</li>";
											}
											echo "</ul>";
											?>	
										</td>
										<td>
											<?php
											if ($rowId > 0) {
												print "<ul id='listtbl' bgcolor='#e4e4e4'>";
												foreach ($result as $key => $row) {
													print "<li id='listItem_" . $row['sub_topic_id'] . "'>";
													print "<img src='resource/images/arrow.png' alt='move' width='16' height='16' class='handle' /> ";
													print "<strong class='handle'>" . $row['title'] . "</strong></li>";
												}
												print "</ul>";
											}
											?>
										</td>
									</tr>
									<?php
									if ($topicsid != "0" && $rowId > 0) {
										?>
										<tr>
											<td colspan="2" align="left">
												<input type="button" id="btnSubmit" class="updpri1"  value="" />
											</td>
										</tr>
										<?php
									} else {
										if ($topicsid != "0") {
											?>
											<tr id="trUpdate">
												<td style="width: 75px;">&nbsp;</td>
												<td align="left" style="font-size: 12px; color: red; font-style: italic;" >
													<span class="alg7">Sub Topics Not Found.</span>
													<br/>
													<br/>
												</td>
											</tr>
											<?php
										}
									}
									?>
								</table>
							</form>
						</div>
					</div>
					<?php include_once 'common/right_side.php'; ?>
				</div>
				<?php include_once 'common/footer.php'; ?>
			</div>
		</div>
    </body>
</html>