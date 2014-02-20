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
							<h1>List - Users </h1>
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
											$uprofile = new userProfile();
											$result = $uprofile->getAllUserDetails();
											echo "<table border='0' cellspacing='1' cellpadding='5' width='100%' bgcolor='#e4e4e4'>";
											echo "<tr>
													<td class='admintitle'>S.No</td>
													<td class='admintitle'>User Name</td>
													<td class='admintitle'>Email</td>
													<td class='admintitle'>Registered On</td>
													<td class='admintitle'>Logged In</td>
													<td class='admintitle'>Duration<br/><span style='font-size:11px;'>hours</span></td>
													<td class='admintitle'>Status</td>
													<td class='admintitle'>Action</td>
												</tr>";
											$i = 1;
											while ($row = mysql_fetch_array($result)) {
												echo "<tr><td style='background-color:#f4f4f4; text-align: right;'>$i</td>
													<td width='25%' style='padding:10px; background-color:#f4f4f4;' class='content'>" . $row['username'] . "</td>";
												echo "<td width='25%' style='padding:10px; background-color:#f4f4f4;' class='content'>" . $row['email'] . "</td>";
												echo "<td width='25%' style='padding:10px; background-color:#f4f4f4;' class='content'>" . date("m-d-Y H:i:s", strtotime($row['registered_on'])) . "</td>";
												echo "<td width='25%' style='padding:10px; background-color:#f4f4f4;' class='content'>" . date("m-d-Y H:i:s", strtotime($row['logintime'])) . "</td>";
												echo "<td width='25%' style='padding:10px; background-color:#f4f4f4;text-align: right;' class='content'>" . $row['log_duration'] . "</td>";
												$active = 'Activate';
												$dos = '0';
												$cls = 'acts';
												$icon = "inactive.png";
												if($row['status'] == 'Active') {
													$active = 'Deactivate';
													$dos = '1';
													$cls = 'inacts';
													$icon = "active.png";
												}
												echo "<td width='25%' style='padding:10px; background-color:#f4f4f4;' class='content'><img src='images/$icon' border='0'></td>";
												echo "<td width='8%' style='padding-left:5px; background-color:#f4f4f4; text-align: center;' class='content'>
													<a class='$cls' href='javascript:;' onclick='return activateUser(" . $row['user_id'] . ", $dos, this);'>$active</a>
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