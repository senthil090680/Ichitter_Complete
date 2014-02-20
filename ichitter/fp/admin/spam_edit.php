<?php
require_once 'includes/includes.inc';

$message = (isset($_REQUEST['msg']))? urldecode($_REQUEST['msg']) : "";
$spid = (isset($_REQUEST['sid']))? urldecode($_REQUEST['sid']) : "";

$spam = new spamFilter();
$recSet = $spam->getSpamWords($spid);
$row = mysql_fetch_array($recSet);

include("includes/header_includes.php");
?>
	<body>
		<div id="container">
			<div id="wrapper">
				<?php include("includes/header.php"); ?>
				<div class="middle-section">
					<div class="width">
						<span class="curve-top-left"></span>
						<span class="curve-top-mid"></span>
						<span class="curve-top-right"></span>
					</div>
					<div class="curve-mid" style="min-height: 525px;">
						<h1>Modify - Spam Word </h1>
						<div class="form">
							<form name="frmaddspam" action="spamprocess.php" method="post" onsubmit="return valSpamFields();">
								<ul class="form-area">
									<li class="form-name">&nbsp;</li>
									<li class="form-mid">&nbsp;</li>
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
								<ul class="form-area">
									<li class="form-name">Spam Word *</li>
									<li class="form-mid">:</li>
									<li class="form-field"><input type="text" name="spamword" id="spamword" value="<?php echo $row['bw_word']; ?>" class="txt-field" maxlength="50" /></li>
								</ul>
								<ul class="form-area">
									<li class="form-name"></li>
									<li class="form-mid"></li>
									<li class="form-field"></li>
								</ul>
								<ul class="form-area">
									<li class="form-field1">
										<input type="image" onclick="javascript:void(0);" src="images/but-update.png" />
										<input type="hidden" name="spamid" id="spamid" value="<?php echo $spid; ?>" />
										<input type="hidden" name="act" value="updatespam" />
									</li>
								</ul>
							</form>
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