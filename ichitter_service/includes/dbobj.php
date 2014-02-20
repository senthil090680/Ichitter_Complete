<?php
ini_set('zlib.output_compression', 'On');
ini_set('zlib.output_compression_level', 6); 

//session_start();
include("encryption.php");
include("configuration.php");
include("DBClass.php");
include("messages.php");

$db = new DBHandler;

#########################################################
#  DB Details
# #######################################################
$DATABASE	= 'ichitter';
$USERNAME	= 'ichitter';
$PASSWORD	= 'Y34Gae39';
$SERVER		= '192.168.100.200:3306';

/*$DATABASE	= 'ichitter';
$USERNAME	= 'root';
$PASSWORD	= '';
$SERVER		= 'localhost';*/

#########################################################
#  Log (Debug mode) details
#########################################################

$LOGFILE	= "http://tsg.emantras.com/IChitter/mysql.log"; // full path to debug LOGFILE. Use only in debug mode!
$LOGGING	= false; // debug on or off
$SHOW_ERRORS= true; // output errors. true/false
$con = false;

define ("ENC_KEY", "EmAnTrAs");

//Initialise
//$db -> SetDBvalues($DATABASE,$USERNAME,$PASSWORD,$SERVER);
//$db -> SetLogvalues($LOGFILE,$LOGGING,$SHOW_ERRORS);
//$db -> SetConnection($con);
$db->_construct($DATABASE,$USERNAME,$PASSWORD,$SERVER,$LOGFILE,$LOGGING,$SHOW_ERRORS,$con);
$db -> init();
$db -> OpenConnection();
$db -> logfile_init();

$enc = new Encryption();
?>