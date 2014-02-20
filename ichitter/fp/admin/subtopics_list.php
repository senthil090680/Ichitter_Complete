<?php
require_once 'includes/includes.inc';

$message = urldecode($_REQUEST['msg']);

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
							<h1>List - Sub Topics </h1>
							<div class="form">

								<table width="95%" border="0" align="center" cellpadding="0"  cellspacing="0">
									<tr>
										<td align="right">
											<input type="button" id="btnOrder" name="btnOrder" onclick="RedirectTosubTopicsPriorityPage()" value="" class="lstprist" />
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
										<td height="110">
											<?php
											$topics = new subtopics;
											$result = $topics->get_alltopics();

											echo "<table border='0'  cellspacing='1' cellpadding='5' width='100%' bgcolor='#e4e4e4'>";
											echo "<tr>
													<td bgcolor='#793318' class='admintitle' style='color:#ffffff;'>Topic</td>
													<td bgcolor='#793318' class='admintitle' style='color:#ffffff;'>Title</td>
													<td bgcolor='#793318' class='admintitle' style='color:#ffffff;'>Description</td>
													<td bgcolor='#793318' class='admintitle' style='color:#ffffff;'>Image Name</td>
													<td bgcolor='#793318' class='admintitle' style='color:#ffffff;' align='center'>Edit</td>
													<td bgcolor='#793318' class='admintitle' style='color:#ffffff;' align='center'>Delete</td>
												</tr>";

											while ($row = mysql_fetch_array($result)) {
												echo "<tr><td width='35%' style='padding:10px; background-color:#f4f4f4;' class='content'>" . $row['topictitle'] . "</td>";
												echo "<td width='25%' style='padding:10px; background-color:#f4f4f4;' class='content'>" . $row['title'] . "</td>";
												echo "<td width='25%' style='padding:10px; background-color:#f4f4f4;' class='content'>" . $row['description'] . "</td>";
												echo "<td width='25%' style='padding:10px; background-color:#f4f4f4;' class='content'>" . $row['image'] . "</td>";
												echo "<td width='8%' style='padding-left:5px; background-color:#f4f4f4;' class='content' align='center'><a href='editsubtopics.php?editaction=edit&id=" . $row['sub_topic_id'] . "'><img src='images/but-Edit.png' border='0'></a></td>";
												echo "<td width='8%' style='padding-left:5px; background-color:#f4f4f4;' class='content' align='center'><a href='#' onclick='return deletesubtopics(" . $row['sub_topic_id'] . ");'><img src='images/but-Delete.png' border='0'></a></td></tr>\n";
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
