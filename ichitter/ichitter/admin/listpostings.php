<?php
require_once 'includes/includes.inc';

$message = urldecode($_REQUEST['msg']);

include("includes/header_includes.php");
?>
	<body>
		<form name="frmedittopics" action="topicsupdate.php?action=edittopics" method="post" enctype="multipart/form-data">
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
<!--											<input type="button" id="btnOrder" name="btnOrder" onclick="RedirectToPriorityPage()" value="" class="lstprit" />-->
												<?php
												if (isset($message)) {
													echo '<ul class="form-area"><li class="form-name">';
													echo $$message;
													echo "</li></ul>";
												}
												?>
										</td>
									</tr>
									<tr>
										<td height="400">
											<?php
											$posts = new postings();
											$result = $posts->listPostings();
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
												$cls = 'acts';
												$dos = '0';
												$active = "Remove";
												if($row['is_active'] == '1') {
													$approve = "Waiting";
													$cls = 'inacts';
													$dos = '1';
													$active = "Approve";
												}
												echo "<td width='25%' style='padding:10px; background-color:#f4f4f4;' class='content'>$approve</td>";
												echo "<td width='8%' style='padding-left:5px; background-color:#f4f4f4; text-align: center;' class='content'>
													<a class='$cls' href='javascript:;' onclick='return activateUser(" . $row['user_id'] . ");'>$active</a>
													</td></tr>\n";
												$i++;
											}
											echo "</table><br />";
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
		</form>
	</body>
</html>