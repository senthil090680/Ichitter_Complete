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
							<h1>Set Topic Order</h1>
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
								<div style="font-size: 12px; width:900px; text-align:left; float: left; height: 50px; color:#FF00FF; font-style:italic;">
									* Drag the Topic item by clicking and hold the pointer <img src="images/arrow.png" /> to rearrange. <br/></div>
								<ul id="info"></ul>

								<table border="0" align="center" cellpadding="0"  cellspacing="0" class="wid">
									<tr>
										<td id="tdRowId">
										<?php
										$topics = new topics;
										$result = $topics->get_topicsByPriority();

										$rowId = 0;
										$rowId = mysql_num_rows($result);

										echo "<br/><ul id='listtbl2'>";
										for ($i = 1; $i <= $rowId; $i++) {
											echo "<li>" . $i . "</li>";
										}
										echo "</ul><br>";
										?>
										</td>
										<td>
											<?php
											echo "<ul id='listtbl' bgcolor='#e4e4e4'>";
											while ($row = mysql_fetch_row($result)) {
												echo "<li id='listItem_$row[0]'>";
												echo "<img src='images/arrow.png' alt='move' width='16' height='16' class='handle' /> ";
												echo "<strong class='handle'>$row[1]</strong></li>";
											}
											echo "</ul><br>";
											?>
										</td>
									</tr>
									<tr>
										<td>
										</td>
										<td align="left">
											<input type="button" id="btnSubmit" class="updpri"  value="" />
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