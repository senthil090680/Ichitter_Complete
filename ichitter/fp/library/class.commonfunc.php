<?php
class CommonFunc {
    public function br2nl($string) {
	/* return preg_replace('#<br\s*?/?>#i', "\n", $string); */
	return str_replace("<br />", '', $string);
    }
	
	function setUploadedFileName($fname) {
		$datetime = date("mdYHis");
		$filecheck = $fname;
		$farr = explode('.', $filecheck);
		$ext = strtolower(substr($filecheck, strrpos($filecheck, '.') + 1));
		$fname = $this->replaceSplChars($farr[0]) . "_" . $datetime . "." . $ext;

		return $fname;
	}

	function replaceSplChars($text) {
		$pattern = "/([^A-Za-z0-9])/i";
		$retText = preg_replace($pattern, '_', $text);
		return $retText;
	}
}