<?php
require_once 'includes/includes.inc';

$message = (isset($_REQUEST['msg']))? urldecode($_REQUEST['msg']) : "";
$tid = (isset($_REQUEST['tid']))? urldecode($_REQUEST['tid']) : "";
$stid = (isset($_REQUEST['stid']))? urldecode($_REQUEST['stid']) : "";
$appr = (isset($_REQUEST['appr']))? urldecode($_REQUEST['appr']) : "";

include("includes/header_includes.php");

$sel1 = "";
$sel2 = "";
if ($appr == '0') {
	$sel1 = " checked";
	$sel2 = "";
} elseif($appr == '1') {
	$sel1 = "";
	$sel2 = " checked";
}
?>
	<body>
		<div id="container">
			<div class="gallerybg">
				<a class="galleryClose"><img src="images/closebt.png" alt="" /></a>
				<div class="gallerytitle">Post Content</div>
				<div class="adminpoptxt" id="post-content">
				</div>
			</div>		
			<div id="backgroundPopup"></div>

			<div id="wrapper">
				<?php include("includes/header.php"); ?>
				<div class="middle-section">
					<div class="width">
						<span class="curve-top-left"></span>
						<span class="curve-top-mid"></span>
						<span class="curve-top-right"></span>
					</div>
					<div class="curve-mid">
						<h1>List - Postings </h1>
						<div class="form">
							<table width="95%" border="0" align="center" cellpadding="0"  cellspacing="0">
								<tr>
									<td align="right">
										<div style="height: 30px;">
										<?php
										if (isset($message)) {
											echo '<ul class="form-area"><li class="form-name">';
											echo $$message;
											echo "</li></ul>";
										}
										?>
										</div>
									</td>
								</tr>
								<tr>
									<td align="right" style="vertical-align: top;">
										<div class="sec-filter">
											<form name="frmlistpostings" action="listpostings.php" method="post" >
											<div class="lst-topic">
												<span class="lp-title">Topic :</span>
												<?php
													$objTopics = new topics();
													$rs = $objTopics->get_alltopics();
												?>
												<select name="tid" id="lst_topic" onchange="javascript: getsubtopics(this);">
													<option value="0">--- SELECT ---</option>
													<?php
													while($Topic = mysql_fetch_array($rs)){
														$selected = ($tid == $Topic['topics_id'])? " selected=selected " : "";
														echo "<option value='" . $Topic['topics_id'] . "' $selected>" . $Topic['title'] . "</option>";
													}
													?>
												</select>
												
											</div>
											<div class="lst-subtopic">
												<span class="lp-title">Sub Topic :</span>
												<?php
													$objSubTopics = new subtopics();
													$rs = $objSubTopics->get_allSubtopics(0, $tid);
												?>
												<select name="stid" id="lst_subtopic">
													<option value="0">--- SELECT ---</option>
													<?php
													while($SubTopic = mysql_fetch_array($rs)){
														$selected = ($stid == $SubTopic['sub_topic_id'])? " selected=selected " : "";
														echo "<option value='" . $SubTopic['sub_topic_id'] . "' $selected>" . $SubTopic['title'] . "</option>";
													}
													?>
												</select>
											</div>
											<div class="sec-approve">
												<label for="appr1">Approved: <input type="radio" name="appr" id="appr1" value="1" <?php echo $sel2; ?> /></label>
												<label for="appr2">Not Approved: <input type="radio" name="appr" id="appr2" value="0" <?php echo $sel1; ?> /></label>
											</div>
											<div class="btn-list">
												<input type="image" src="images/list-postings.png" onclick="javascript:;" />
											</div>
											</form>
											
										</div>
									</td>
								</tr>
								<tr>
									<td height="400" style="vertical-align: top; padding: 15px 0 0 0;">
										<?php
										$posts = new postings();
										$result = $posts->listPostings($tid, $stid, $appr);
										$rec_cnt = mysql_num_rows($result);
										if ($rec_cnt > 0){
											echo "<table border='0' cellspacing='1' cellpadding='5' width='100%' bgcolor='#e4e4e4'>";
											echo "<tr>
													<td class='admintitle'>S.No</td>
													<td class='admintitle'>Topic</td>
													<td class='admintitle'>Sub Topic</td>
													<td class='admintitle'>Post Title</td>
													<td class='admintitle'>Content</td>
													<td class='admintitle'>Status</td>
													<td class='admintitle'>Action</td>
												</tr>";
											$i = 1;
											while ($row = mysql_fetch_array($result)) {
												echo "<tr><td style='background-color:#f4f4f4; text-align: right;'>$i</td>
													<td width='25%' style='padding:10px; background-color:#f4f4f4;' class='content'>" . $row['topic'] . "</td>";
												echo "<td width='25%' style='padding:10px; background-color:#f4f4f4;' class='content'>" . $row['subtopic'] . "</td>";
												echo "<td width='35%' style='padding:10px; background-color:#f4f4f4;' class='content'>" . $row['posttitle'] . "</td>";
												echo "<td width='15%' style='padding:10px; background-color:#f4f4f4;text-align: center;' class='content'>
													<a href='javascript:;' class='imgGal' onclick='return viewpostcontent(" . $row['posting_id'] . ");'>View</a>
												</td>";

												$approve = "Approved";
												$cls = 'inacts';
												$dos = '0';
												$active = "Remove";
												if($row['is_approved'] == '0') {
													$approve = "<span style='color: red;'>Waiting</span>";
													$cls = 'acts';
													$dos = '1';
													$active = "Approve";
												}
												echo "<td width='25%' style='padding:10px; background-color:#f4f4f4;' class='content'>$approve</td>";
												
												if($active == "Approve") {
													echo "<td width='8%' style='padding-left:5px; background-color:#f4f4f4; text-align: center;' class='content'>
														<a class='$cls' href='javascript:;' onclick='return approvepost(" . $row['posting_id'] . ");'>$active</a>
														</td></tr>";
												} else {
													echo "<td width='8%' style='padding-left:5px; background-color:#f4f4f4; text-align: center;' class='content'>
														<a class='$cls' href='javascript:;' onclick='return deletepost(" . $row['posting_id'] . ", " . $row['discnt'] . ");'>$active</a>
														</td>";
												} 
												$i++;
											}
											echo "</tr></table><br />";
										} else {
											echo "<div style='font-size: 12px; color:red; text-align: center; width:100%;'>Postings are not found.</div>";
										}
										?>
									</td>
								</tr>
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
	</body>
</html>