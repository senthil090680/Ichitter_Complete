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
							<h1>List - Topics </h1>
							<div class="form">

								<table width="95%" border="0" align="center" cellpadding="0"  cellspacing="0">
									<tr>
										<td align="right">
											<input type="button" id="btnOrder" name="btnOrder" onclick="RedirectToPriorityPage()" value="" class="lstprit">

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
$topics = new topics;
$result = $topics->get_alltopics(250);
echo "<table border='0'  cellspacing='1' cellpadding='5' width='100%' bgcolor='#e4e4e4'>";
echo "<tr><td class='admintitle' >Title</td><td class='admintitle'>Description</td><td class='admintitle' >Image Name</td><td class='admintitle'  >Edit</td><td class='admintitle' >Delete</td></tr>";

while ($row = mysql_fetch_row($result)) {
	echo "<tr><td width='25%' style='padding:10px; background-color:#f4f4f4;' class='content'>$row[1]</td>";
	echo "<td width='25%' style='padding:10px; background-color:#f4f4f4;' class='content'>$row[2]</td>";
	echo "<td width='25%' style='padding:10px; background-color:#f4f4f4;' class='content'>$row[3]</td>";

	echo "<td width='8%' style='padding-left:5px; background-color:#f4f4f4;' class='content' align='center'><a href='edittopics.php?editaction=edit&id=$row[0]'><img src='images/but-Edit.png' border='0'></a></td>";
	echo "<td width='8%' style='padding-left:5px; background-color:#f4f4f4;' class='content' align='center'><a href='#' onclick='return deletetopics($row[0]);'><img src='images/but-Delete.png' border='0'></a></td></tr>\n";
}
echo "</table><br>";
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
