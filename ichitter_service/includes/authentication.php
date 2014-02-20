<?php
$LGD = $_REQUEST[PARAM_LGD];
$valid = 0;
if($LGD == 1) {
	$email = $enc->decrypt(ENC_KEY, $_REQUEST[PARAM_EID]);
	$password = $enc->decrypt(ENC_KEY, $_REQUEST[PARAM_PSD]);
	$usd = $_REQUEST[PARAM_USD];
	$ip = $_REQUEST[PARAM_R_ADDR];
	$ssid = $_REQUEST[PARAM_SSAID];
	$ua = $_REQUEST[PARAM_HU_AGENT];
	$valid = $cg->userAuth($email, $password, $usd, $ip, $ssid, $ua);
}
?>
