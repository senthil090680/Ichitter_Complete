<?php
$db = new DBHandler;

$DATABASE = 'ichitter';
$USERNAME = 'ichitter';
$PASSWORD = 'Y34Gae39';
$SERVER = '192.168.100.200:3306';

/* $DATABASE	= 'ichitter';
  $USERNAME	= 'root';
  $PASSWORD	= 'password';
  $SERVER		= 'localhost'; */

#########################################################
#  DB Details
# #######################################################
/* $DATABASE	= 'pravasvani';
  $USERNAME	= 'root';
  $PASSWORD	= '';
  $SERVER		= '192.168.100.200:3306'; */

#########################################################
#  Log (Debug mode) details
#########################################################

$LOGFILE = "http://tsg.emantras.com/IChitter/mysql.log"; // full path to debug LOGFILE. Use only in debug mode!
$LOGGING = false; // debug on or off
$SHOW_ERRORS = true; // output errors. true/false
$con = false;
//Initialise
//$db -> SetDBvalues($DATABASE,$USERNAME,$PASSWORD,$SERVER);
//$db -> SetLogvalues($LOGFILE,$LOGGING,$SHOW_ERRORS);
//$db -> SetConnection($con);
$db->_construct($DATABASE, $USERNAME, $PASSWORD, $SERVER, $LOGFILE, $LOGGING, $SHOW_ERRORS, $con);
$db->init();
$db->OpenConnection();
$db->logfile_init();
?>