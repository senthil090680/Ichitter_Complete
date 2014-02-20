<?php
include_once("configuration.php");
include_once("class.smtp.php");
include_once("class.pop3.php");
include_once("class.phpmailer.php");
require_once "json.php";

class commonGeneric extends Services_JSON {

	private $Query;
	private $badwords;

	function __construct() {
		$this->Query = "";
		$this->badwords = array();
	}

	function array2json($arr) {
		if (function_exists('$ObjJSON->encode'))
			return $ObjJSON->encode($arr); //Lastest versions of PHP already has this functionality.
		$parts = array();
		$is_list = false;

		//Find out if the given array is a numerical array 
		$keys = array_keys($arr);
		$max_length = count($arr) - 1;
		if (($keys[0] == 0) and ($keys[$max_length] == $max_length)) {//See if the first key is 0 and last key is length - 1
			$is_list = true;
			for ($i = 0; $i < count($keys); $i++) { //See if each key correspondes to its position 
				if ($i != $keys[$i]) { //A key fails at position check. 
					$is_list = false; //It is an associative array. 
					break;
				}
			}
		}

		foreach ($arr as $key => $value) {
			if (is_array($value)) { //Custom handling for arrays 
				if ($is_list)
					$parts[] = array2json($value); /* :RECURSION: */
				else
					$parts[] = '"' . $key . '":' . array2json($value); /* :RECURSION: */
			} else {
				$str = '';
				if (!$is_list)
					$str = '"' . $key . '":';

				//Custom handling for multiple data types 
				if (is_numeric($value))
					$str .= $value; //Numbers 
				elseif ($value === false)
					$str .= 'false'; //The booleans 
				elseif ($value === true)
					$str .= 'true';
				else
					$str .= '"' . addslashes($value) . '"'; //All other things 

					
// :TODO: Is there any more datatype we should be in the lookout for? (Object?) 

				$parts[] = $str;
			}
		}
		$json = implode(',', $parts);

		if ($is_list)
			return '[' . $json . ']'; //Return numerical JSON 
		return '{' . $json . '}'; //Return associative JSON 
	}

	function toUSDate($date) {
		return date("m-d-Y H:i:s", strtotime($date));
	}

	public function query_Exe($sql) {
		return mysql_query($sql);
	}

	public function get_lastinsert_id() {
		return mysql_insert_id();
	}

	public function fetch_row($data) {
		return mysql_fetch_assoc($data);
	}
	
	public function mail_Send($to,$mail_subject,$mailformat){
		
	
		//$to	  =   TOEMAIL;
		$mail = new PHPMailer();					
		$mail->IsSMTP();
		$mail->SMTPDebug  = 2;
		$mail->SMTPSecure = "ssl";
		$mail->Host = HOST;
		$mail->Port = PORT;
		$mail->SMTPAuth = true;
		$mail->Username = EMAILUSERNAME;	
		$mail->Password = EMAILPASSWORD; 
		$mail->SetFrom(FROMEMAIL, FROMEMAILNAME);
		$mail->AddReplyTo(FROMEMAIL, FROMEMAILNAME);
		$mail->Subject    = $mail_subject;
		$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
		$mail->MsgHTML($mailformat);
		$mail->AddAddress($to,""); 
		$mail->IsHTML(true); 
		if(!$mail->Send()) {
			$msg = "Mailer Error: " . $mail->ErrorInfo;
		} else {
			$msg = "<p style='color:red;'>Thank you for your interest with smtrail.com.<br>We will contact you shortly.</p>";
		}
	}
	
	public function edit_field($table_name,$data){
		$sql = "UPDATE ".$table_name." SET ".$data['field_name']." = '".$data['val']."' WHERE ".stripslashes($data['condition']);
		
		$result = $this->query_Exe($sql);
		if($result == 1){
			return $this->encode(array('success'=>$result));
		}else{
			return $this->encode(array('error'=>'false'));
		}
	}
	
	function setUploadedFileName($fname){
		$datetime = date("mdYHis");
		$filecheck = $fname;
        $farr = explode('.', $filecheck);
        $ext = strtolower(substr($filecheck, strrpos($filecheck, '.') + 1));
		$fname = $this->replaceSplChars($farr[0]) . "_" . $datetime . "." . $ext;
		
		return $fname;
	}
	
	function replaceSplChars($text) {
		$pattern = "/([^A-Za-z0-9])/i";
		$retText = preg_replace($pattern, '_' ,$text);
		return $retText;
	}

public function get_states(){
		//$result = $this->query_Exe("CALL get_states()");
		$sql = "SELECT * FROM tbl_state";
		$result = $this->query_Exe($sql);
		
		//$result = mysql_query($sql);
		
		
		 $arr = array();
		while($data = $this->fetch_row($result)){
		//while($data = mysql_fetch_assoc($result)){
			$arr[] = $data; 
		}
		return $arr;
	}

public function get_gender(){
		//store procedure
		//$result = $this->query_Exe("CALL get_gender()");
		
		$sql = "SELECT * FROM tbl_gender";
		//$result = $this->query_Exe($sql);
		
		$result = mysql_query($sql);
		
		
		$arr = array();
		while($data = $this->fetch_row($result)){
		//while($data = mysql_fetch_assoc($result)){
			$arr[] = $data; 
		}
		return $arr;
	}

	private function getBadWords() {
		$this->Query = " SELECT	bw_word FROM " . BAD_WORDS;
		$res = mysql_query($this->Query);
		while ($row = mysql_fetch_assoc($res)) {
			$this->badwords[] = $row['bw_word'];
		}
	}
	/*
	function badword_filter($content) {
		$this->getBadWords();
		$count = count($this->badwords);
		$original = $content;
		$content = strtolower($content);
		// Loop through the badwords array
		for ($n = 0; $n < $count; ++$n, next($this->badwords)) {
			//Search for badwords in content
			$search = trim(strtolower($this->badwords[$n]));
			$content = preg_replace("'$search'i", "<i>$search</i>", $content);
		}

		if (mb_strlen($original) == mb_strlen($content)) {
			return 1;
		}
		return 0;
	} */
	
	function badword_filter($content) {
		$this->getBadWords();
		$count = count($this->badwords);
		$content = $this->cleanText(strtolower($content));
		$content_arr = $this->split_words($content);
		$bw_count = 0;
		// Loop through the badwords array
		for ($n = 0; $n < $count; ++$n, next($this->badwords)) {
			//Search for badwords in content
			$search = trim(strtolower($this->badwords[$n]));
			if(in_array($search, $content_arr)) {
				$bw_count++;
			}
		}
		if($bw_count == 0) {
			return 1;
		}
		return 0;
	}
	
	function cleanText($str) {
		$str = str_replace("Ñ", "", $str);
		$str = str_replace("ñ", "", $str);
		$str = str_replace("ñ", "", $str);
		$str = str_replace("Á", "", $str);
		$str = str_replace("á", "", $str);
		$str = str_replace("É", "", $str);
		$str = str_replace("é", "", $str);
		$str = str_replace("ú", "", $str);
		$str = str_replace("ù", "", $str);
		$str = str_replace("Í", "", $str);
		$str = str_replace("í", "", $str);
		$str = str_replace("Ó", "", $str);
		$str = str_replace("ó", "", $str);
		$str = str_replace(".", "", $str);
		$str = str_replace("_", "", $str);
		$str = str_replace("?", "", $str);
		$str = str_replace("ü", "", $str);
		$str = str_replace("Ü", "", $str);
		$str = str_replace("Ê", "", $str);
		$str = str_replace("ê", "", $str);
		$str = str_replace("Ç", "", $str);
		$str = str_replace("ç", "", $str);
		$str = str_replace("È", "", $str);
		$str = str_replace("è", "", $str);
		$str = str_replace("?", "", $str);
		$str = str_replace(">", "", $str);
		$str = str_replace("<", "", $str);
		$str = str_replace("{", "", $str);
		$str = str_replace("}", "", $str);
		$str = str_replace("|", "", $str);
		$str = str_replace("(", "", $str);
		$str = str_replace(")", "", $str);
		$str = str_replace("*", "", $str);
		$str = str_replace("#", "", $str);
		$str = str_replace("$", "", $str);
		$str = str_replace("!", "", $str);
		$str = str_replace("^", "", $str);
		$str = str_replace("%", "", $str);
		$str = str_replace("-", "", $str);
		$str = str_replace("/", "", $str);
		$str = str_replace("+", "", $str);
		$str = str_replace("@", "", $str);
		$str = str_replace("~", "", $str);
		
		return $str;
	}
	
	function filter_malicious($content) {
		$this->getBadWords();
		$count = count($this->badwords);
		$content = $this->cleanText(strtolower($content));
		$content_arr = $this->split_words($content);
		$bw_count = 0;
		// Loop through the badwords array
		for ($n = 0; $n < $count; ++$n, next($this->badwords)) {
			//Search for badwords in content
			$search = trim(strtolower($this->badwords[$n]));
			if(in_array($search, $content_arr)) {
				$bw_count++;
			}
		}
		if($bw_count == 0) {
			return 1;
		}
		return 0;
	}

	function split_words($string, $max = 1) {
		$words = preg_split('/\s/', $string);
		$lines = array();
		$line = '';

		foreach ($words as $k => $word) {
			$length = strlen($line . ' ' . $word);
			if ($length <= $max) {
				$line .= ' ' . $word;
			} else if ($length > $max) {
				if (!empty($line))
					$lines[] = trim($line);
				$line = $word;
			} else {
				$lines[] = trim($line) . ' ' . $word;
				$line = '';
			}
		}
		$lines[] = ($line = trim($line)) ? $line : $word;

		return $lines;
	}

	function userAuth($email, $password, $cuid=0, $ip, $ssid, $ua) {
		$sql = "SELECT * FROM " . USERPROFILE . " 
				WHERE 
					email = '" . $email . "' 
					AND passw = '" . $password . "'";
					//AND ip = '" . $ip . "'
					//AND session = '" . md5($ssid) . "'
					//AND user_agent = '" . sha1($ua) . "'";
		$res_sql = mysql_query($sql);
		$row = mysql_fetch_array($res_sql);
		$ret = 0;
		if (mysql_num_rows($res_sql) == 1) {
			$ret = ($row['user_id'] == $cuid)?1:0;
		}
		return $ret;
	}

	public function secondsToTime($seconds){
        // extract hours
        $hours = floor($seconds / (60 * 60));
     
        // extract minutes
        $divisor_for_minutes = $seconds % (60 * 60);
        $minutes = floor($divisor_for_minutes / 60);
     
        // extract the remaining seconds
        $divisor_for_seconds = $divisor_for_minutes % 60;
        $seconds = ceil($divisor_for_seconds);
     
        // return the final array
        $obj = array(
            "h" => (int) $hours,
            "m" => (int) $minutes,
            "s" => (int) $seconds,
        );
        return $obj;
    }
	
	public function news_update($data){        
//         $sql = "SELECT news_id from tbl_news WHERE news_user_id = ".$data['user_id']." AND news = '". $data['tbl_id']."'";
//         
//         $result = $this->query_Exe($sql);
//         $news_id = $this->fetch_row($result);
        if(isset($data['rel_id'])){
			$sql = "INSERT INTO tbl_news SET news_user_id = ".$data['user_id'].", news = '". $data['tbl_id'] . "', 	news_flag = 0, news_added_time = now(), news_rel_id = ".$data['rel_id'];
		}else{	      
        	$sql = "INSERT INTO tbl_news SET news_user_id = ".$data['user_id'].", news = '". $data['tbl_id'] . "', 	news_flag = 0, news_added_time = now(), news_rel_id = 0";
		}
        // return $sql;
         $result = $this->query_Exe($sql);
         if($result == 1){
		 	return 1;
		 }else{
		 	return 0;
		 }
     }
	
	 public function transaction($sql1,$sql2){
	 	$this->query_Exe('SET AUTOCOMMIT=0');
		$this->query_Exe('START TRANSACTION');	
		$r1 = $this->query_Exe($sql1);
		$r2 = $this->news_update($sql2);		
		
		if($r1 == $r2){
             $this->query_Exe('COMMIT');
             return $this->encode(array('success'=>1));
		}else{
			$this->query_Exe('ROLLBACK');
			return $this->encode(array('error'=>'false'));
		}
	 
	 }
	 
	  public function transaction_start(){
	 	$this->query_Exe('SET AUTOCOMMIT=0');
		$this->query_Exe('START TRANSACTION');
	 }
	 
	 public function transaction_commit(){
	 	 $this->query_Exe('COMMIT');
	 }
	 
	 public function transaction_rollback(){
	 	$this->query_Exe('ROLLBACK');
	 }
	 
	 public function get_mutual_friend($data){
          $user_id = $data['user_id'];
          $sql = "SELECT DISTINCT tup.user_id, 
                                    CONCAT(tup.first_Name,' ',tup.last_Name) AS uname, 
                                    tup.gender, 
                                    tup.email, 
                                    tup.profile_image, 
                                    ti.image_name, 
                                    tig.igallery_name, 
                                    tspub.pub_name, 
                                    ts.state_name
                                        FROM tbl_user_profile tup 
                                        LEFT JOIN tbl_group_members tgm ON (tup.user_id = tgm.user_id_joined) 
                                        LEFT JOIN tbl_images ti ON (tup.profile_image = ti.image_id) 
                                        LEFT JOIN tbl_igallery tig ON (ti.igallery_id = tig.igallery_id) 
                                        LEFT JOIN tbl_security_public tspub ON (tup.user_id = tspub.user_id) 
                                        LEFT JOIN tbl_state  ts ON (tup.state = ts.state_abbreviation)                                        
                                            WHERE tup.user_id NOT IN (SELECT cont_user_joined_id FROM tbl_contacts WHERE cont_user_id = ".$user_id.") AND 
                                                  (select count(*) as total from tbl_addfriend where request_user_id = ".$user_id." && response_user_id = tup.user_id) = 0 and
                                                  tup.profession = (SELECT profession FROM tbl_user_profile WHERE user_id = ".$user_id.") AND tup.user_id != ".$user_id;
          
          //return $sql;
          $qry_result = $this->query_Exe($sql);
		$result = array();
		while($data = $this->fetch_row($qry_result)){
			$result[] = $data;
		}
          return $result;
      }

}

$cg = new commonGeneric();
?>
