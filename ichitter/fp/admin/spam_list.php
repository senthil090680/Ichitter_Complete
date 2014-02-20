<?php
require_once 'includes/includes.inc';

$message = (isset($_REQUEST['msg']))? urldecode($_REQUEST['msg']) : "";

include("includes/header_includes.php");
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
							<h1>List - Spam Words </h1>
							<div class="form">
								<table width="95%" border="0" align="center" cellpadding="0"  cellspacing="0">
								<tr>
									<td style="text-align: center;">
										<ul class="form-area">
											<li class="form-name">&nbsp;</li>
											<li class="form-field" >
												<?php
												if (isset($message)) {
													if (($$message == $addspam_success) || ($$message == $deletespam_success) || ($$message == $updatespam_success)) {
														echo "<span style='font-size: 12px;color: green;'>" . $$message . "</span>";
													} else {
														echo "<span style='font-size: 12px;color: red;'>" . $$message . "</span>";
													}
												}
												?>
											</li>
										</ul>
										<br /><br />
									</td>
								</tr>
								<tr>
									<td height="400">
										<?php
										$spams = new spamFilter();
										$result = $spams->getSpamWords();
										echo "<table align='center' border='0' cellspacing='1' cellpadding='5' width='65%' bgcolor='#e4e4e4'>";
										echo "<tr>
												<td class='admintitle'>S.No</td>
												<td class='admintitle'>Spam Word</td>
												<td class='admintitle'>Created On</td>
												<td class='admintitle' colspan='2'>Action</td>
											</tr>";
										$i = 1;
										while ($row = mysql_fetch_array($result)) {
											echo "<tr><td width='5%' style='background-color:#f4f4f4; text-align: right;' class='content'>$i</td>
												<td width='25%' style='padding:10px; background-color:#f4f4f4;' class='content'>" . $row['bw_word'] . "</td>";
											echo "<td width='25%' style='padding:10px; background-color:#f4f4f4;' class='content'>" .  date("m-d-Y H:i:s", strtotime($row['created_on'])) . "</td>";
											echo "<td width='15%' style='padding:10px; background-color:#f4f4f4; text-align:center;' class='content'><a href='spam_edit.php?sid=" . $row['bw_id'] . "'>Edit</a></td>";
											echo "<td width='15%' style='padding-left:5px; background-color:#f4f4f4;text-align:center;' class='content'><a href='javascript:;' onclick='javascript: return delSpamWord(" . $row['bw_id'] . ")'>Delete</a></td></tr>\n";
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
		
	</body>
</html>