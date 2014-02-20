<?php
/*
function formspecialchars($var)
    {
        $pattern = '/&(#)?[a-zA-Z0-9]{0,};/';
       
        if (is_array($var)) {    // If variable is an array
            $out = array();      // Set output as an array
            foreach ($var as $key => $v) {     
                $out[$key] = formspecialchars($v);         // Run formspecialchars on every element of the array and return the result. Also maintains the keys.
            }
        } else {
            $out = $var;
            while (preg_match($pattern,$out) > 0) {
                $out = htmlspecialchars_decode($out,ENT_QUOTES);      
            }                            
            $out = htmlspecialchars(stripslashes(trim($out)), ENT_QUOTES,'UTF-8',true);     // Trim the variable, strip all slashes, and encode it
           
        }
       
        return $out;
    } 
function fixtags($text){
	$text = htmlspecialchars($text);
	$text = ereg_replace("[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]", "_", $text);
	echo $text;
	$text = preg_replace("/=/", "=\"\"", $text);
	$text = preg_replace("/&quot;/", "&quot;\"", $text);
	$tags = "/&lt;(\/|)(\w*)(\ |)(\w*)([\\\=]*)(?|(\")\"&quot;\"|)(?|(.*)?&quot;(\")|)([\ ]?)(\/|)&gt;/i";
	$replacement = "<$1$2$3$4$5$6$7$8$9$10>";
	$text = preg_replace($tags, $replacement, $text);
	$text = preg_replace("/=\"\"/", "_", $text);
	return $text;
}
*/
//$string = "@%&'";

//echo formspecialchars($string);

$string_to_be_stripped = "Hi, I am a string and I need to be stripped...";
$new_string = preg_replace("[^A-Za-z0-9]", "", $string_to_be_stripped );


$pattern = "/([^A-Za-z0-9])/i";
//$replace = "<a href=\"mailto:\\1\">\\1</a>";
$text = preg_replace($pattern, '_' ,$string_to_be_stripped);



echo $text;

//echo fixtags($string);

?>