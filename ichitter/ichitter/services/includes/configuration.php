<?php
#########################################################
#	Configaration file
# Define the necessary constats for reuse.
#########################################################

#########################################################
#		constants for Table names
#########################################################
define('TOPICS',"tbl_topics");
define('SUB_TOPICS',"tbl_sub_topics");
define('LOGIN',"tbl_login");
define('USERPROFILE', "tbl_user_profile");
define('POSTINGS', "tbl_posting");
define('MARKED_POSTS', "tbl_marked");


#########################################################
# 		Email configuration
#########################################################
	/*define('HOST',"smtp.gmail.com");
	define('PORT',465);
	define('EMAILUSERNAME',"demo@emantras.com");
	define('EMAILPASSWORD',"Welcome123");
	define('FROMEMAIL',"demo@emantras.com");
	define('FROMEMAILNAME',"Pravasvani Administrator");
	define('TOEMAIL',"demo@emantras.com"); */
	
	define('HOST',"smtp.gmail.com");
	define('PORT',465);
	define('EMAILUSERNAME',"demo@emantras.com");
	define('EMAILPASSWORD',"Welcome123");
	define('FROMEMAIL',"demo@emantras.com");
	define('FROMEMAILNAME',"SMT RAIL");
	define('TOEMAIL',"mahar@emantras.com");


#########################################################
#  Log (Debug mode) details
#########################################################

	$LOGFILE	= "http://localhost:8080/mysql.log"; // full path to debug LOGFILE. Use only in debug mode!
	$LOGGING	= false; // debug on or off
	$SHOW_ERRORS= true; // output errors. true/false
	$con = false;
#########################################################

#########################################################
# User type declarations
#########################################################
$normalUser	=	1;
#########################################################

$limit_config 	= 	15;
$displayLimit_config 	= 	10;

/* define variables */
define('SERVICE_NAME',"http://localhost/ichitter/services/");


?>