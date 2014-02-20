<?php
require_once 'includes/includes.inc';

$message = urldecode($_REQUEST['msg']);

$topicsid = "0";
if (isset($_GET['id']) != "") {
	$topicsid = $_GET['id'];
}

include("includes/header_includes.php");
?>
<body>
	<form name="frmedittopics" action="topicsupdate.php?action=edittopics" method="post" enctype="multipart/form-data">
		<div id="container">
			<div id="wrapper">
				<?php include("includes/header.php"); ?>
				<div class="middle-section">
					<div class="width">
						<span class="curve-top-left"></span>
						<span class="curve-top-mid"></span>
						<span class="curve-top-right"></span>
					</div>
					<div class="curve-mid">
						<h1>Set Sub Topic Order</h1>
						<div class="form">
							<ul class="form-area">
								<li class="form-name">
									&nbsp;
									<?php
									if (isset($message)) {
										echo $$message;
									}
									?>
								</li>
							</ul>
							<div  style="font-size: 12px;width:900px;  text-align:left; float: left; height: 50px; color:#FF00FF; font-style:italic;">
								* Drag the Topic item by clicking and hold the pointer <img src="images/arrow.png" /> to rearrange. <br/></div>
							<ul id="info"></ul>
							<table width="95%" border="0" align="center" cellpadding="0"  cellspacing="0">
								<tr>
									<td style=" width: 130px;height: 30px; overflow:hidden; font-size:12px;">
										<span style="padding-left:30px;">Select Topic :</span></td>
									<td align="left">
										<select id="TopicTitle" name="TopicTitle" class="txt-fieldst" onchange="populateSubTopics(this)" onload="populateSubTopics(this)">
											<option value="0">--Select--</option>
											<?php
											$topics = new topics;
											$result = $topics->get_allthetopics();
											while ($row = mysql_fetch_row($result)) {
												$selectedTopicId = "";
												if ($row[0] == $topicsid)
													$selectedTopicId = "selected";
												echo "<option value='" . $row[0] . "' " . $selectedTopicId . ">" . $row[1] . "</option>";
											}
											?>
										</select>
									</td>
								</tr>
							</table>
							<table  class="wid" border="0" align="center" cellpadding="0"  cellspacing="0">

								<tr id="trSubTopics">
									<td id="tdRowId">
										<?php
										$topics = new subtopics;
										$result = $topics->get_topicsByPriority($topicsid);

										$rowId = 0;
										$rowId = mysql_num_rows($result);

										echo "<ul id='listtbl3'>";
										for ($i = 1; $i <= $rowId; $i++) {
											echo "<li>" . $i . "</li>";
										}
										echo "</ul>";
										?>
									</td>
									<td>
										<?php
										echo "<br/><ul id='listtbl' bgcolor='#e4e4e4'>";
										while ($row = mysql_fetch_row($result)) {
											echo "<li id='listItem_$row[0]'>";
											echo "<img src='images/arrow.png' alt='move' width='16' height='16' class='handle' /> ";
											echo "<strong class='handle'>$row[2]</strong></li>";
										}
										echo "</ul><br/>";
										?>
									</td>
								</tr>
								<?php
								if ($topicsid != "0" && $rowId > 0) {
									?>
									<tr id="trUpdate">
										<td>&nbsp;</td>
										<td align="left">
											<input type="button" id="btnSubmit1" class="updpri"  value="" />
										</td>
									</tr>
									<?php
								} else {
									if ($topicsid != "0") {
										?>
										<tr id="trUpdate">
											<td style="width: 75px;">&nbsp;</td>
											<td align="left" style="font-size: 12px; color: red; font-style: italic;" >
												<span class="alg7">No Sub Topics Found.</span>
												<br/>
												<br/>
											</td>
										</tr>
										<?php
									}
								}
								?>
							</table>
						</div>
					</div>
					<div class="width">
						<span class="curve-bot-left"></span>
						<span class="curve-bot-mid"></span>
						<span class="curve-bot-right"></span>
					</div>
				</div>
				<div id="footer">
					<div class="footernavi">
						<div class="copyright">© 2011</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</body>
</html>