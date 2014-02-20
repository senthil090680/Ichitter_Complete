<?php 
include_once("configuration.php");
include_once("class.smtp.php");
include_once("class.pop3.php");
include_once("class.phpmailer.php");
class commonGeneric {
	
	function array2json($arr) { 
	    if(function_exists('json_encode')) return json_encode($arr); //Lastest versions of PHP already has this functionality.
	    $parts = array(); 
	    $is_list = false; 
	
	    //Find out if the given array is a numerical array 
	    $keys = array_keys($arr); 
	    $max_length = count($arr)-1; 
	    if(($keys[0] == 0) and ($keys[$max_length] == $max_length)) {//See if the first key is 0 and last key is length - 1
	        $is_list = true; 
	        for($i=0; $i<count($keys); $i++) { //See if each key correspondes to its position 
	            if($i != $keys[$i]) { //A key fails at position check. 
	                $is_list = false; //It is an associative array. 
	                break; 
	            } 
	        } 
	    } 
	
	    foreach($arr as $key=>$value) { 
	        if(is_array($value)) { //Custom handling for arrays 
	            if($is_list) $parts[] = array2json($value); /* :RECURSION: */ 
	            else $parts[] = '"' . $key . '":' . array2json($value); /* :RECURSION: */ 
	        } else { 
	            $str = ''; 
	            if(!$is_list) $str = '"' . $key . '":'; 
	
	            //Custom handling for multiple data types 
	            if(is_numeric($value)) $str .= $value; //Numbers 
	            elseif($value === false) $str .= 'false'; //The booleans 
	            elseif($value === true) $str .= 'true'; 
	            else $str .= '"' . addslashes($value) . '"'; //All other things 
	            // :TODO: Is there any more datatype we should be in the lookout for? (Object?) 
	
	            $parts[] = $str; 
	        } 
	    } 
	    $json = implode(',',$parts); 
	     
	    if($is_list) return '[' . $json . ']';//Return numerical JSON 
	    return '{' . $json . '}';//Return associative JSON 
	} 
	
	function toUSDate($date) {
		return date("m-d-Y H:i:s" , strtotime($date));
	}
	
	public function query_Exe($sql){
		return mysql_query($sql);
	}
	
	public function fetch_row($data){		
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
}

?>
