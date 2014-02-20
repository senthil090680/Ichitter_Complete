<?php
include_once 'library/include_files.php';
include_once 'common/redirectto.php';
//error_reporting(E_ALL);

$user_id = "";
if ($_SESSION['login']['user_id'] != "") {
	$user_id = $_SESSION['login']['user_id'];
}
$message = "";
if (isset($_REQUEST['msg'])) {
	$message = urldecode($_REQUEST['msg']);
}

$REQ_SEND[PARAM_ACTION] = "list2order";
$REQ_SEND[PARAM_USERID] = "$user_id";

$ObjCURL = new INIT_PROCESS(TOPIC_SERVICE_PAGE, $REQ_SEND);
//echo $ObjCURL->response;
$result = Object2Array($ObjJSON->decode($ObjCURL->response));
//print_r($result);
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
					orderUserTopics(order);
					//alert($("#info").html());
					//$("#info").load("topic_process.php?action=topicreorder" + order);
					//alert("Topics Order Updated Successfully");
					//alert($("#info").html());
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
							Order Topics
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
							<form name="frmedittopics" action="orderupdate.php?action=topicorder" method="post" enctype="multipart/form-data">
								<br />
								<div style="font-size: 12px; width:900px; text-align:left; float: left; height: 50px; color:#FF00FF; font-style:italic;">
									* Drag the Topic item by clicking and hold the pointer <img src="resource/images/arrow.png" /> to rearrange. <br/></div>
								<ul id="info"></ul>
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
													print "<li id='listItem_" . $row['topics_id'] . "'>";
													print "<img src='resource/images/arrow.png' alt='move' width='16' height='16' class='handle' /> ";
													print "<strong class='handle'>" . $row['title'] . "</strong></li>";
												}
												print "</ul>";
											}
											?>
										</td>
									</tr>
									<?php if ($rowId > 0) { ?>
										<tr>
											<td>&nbsp; </td>
											<td align="left">
												<input type="button" id="btnSubmit" class="updpri"  value="" />
											</td>
										</tr>
									<?php } else { ?>
										<tr id="trUpdate">
											<td style="width: 75px;">&nbsp;</td>
											<td align="left" style="font-size: 12px; color: red; font-style: italic;" >
												<span class="alg7">Topics are not found.</span>
												<br/>
												<br/>
											</td>
										</tr>
									<?php } ?>
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