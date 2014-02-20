<?php
#########################################################
#	Configaration file
# Define the necessary constats for reuse.
#########################################################

#########################################################
#		constants for Table names
#########################################################
define('TOPICS',"tbl_topics");
define("SUB_TOPICS","tbl_sub_topics");
define("LOGIN","tbl_login");
define("USERPROFILE", "tbl_user_profile");
define("POSTINGS", "tbl_posting");
define("MARKED_POSTS", "tbl_marked");
define("GROUP_MEMBERS", "tbl_group_members");
define("USER_GROUPS", "tbl_groups");
define("IMAGES", "tbl_images");
define("VIDEOS", "tbl_videos");
define("IGALLERY", "tbl_igallery");
define("VGALLERY", "tbl_vgallery");
define("DISCUSSION", "tbl_discussion");
define("BAD_WORDS", "tbl_badwords");
define("DISCUSSION_READ", "tbl_discussion_read");
define("ADDFRIEND", "tbl_addfriend");
define("CHAT", "tbl_chat");
define("CONTACTS", "tbl_contacts");
define("GENDER", "tbl_gender");
define("MESSAGE", "tbl_msg");
define("NEWS", "tbl_news");
define("NEWS_READ", "tbl_news_read");
define("MSG_REPLY", "tbl_reply");
define("PRIVATE_SECURITY", "tbl_security_private");
define("PUBLIC_SECURITY", "tbl_security_public");
define("STATES", "tbl_state");
define("THEMES", "tbl_themes");
define("TOPIC_ORDER", "tbl_topic_order");
define("SUBTOPIC_ORDER", "tbl_subtopic_order");

#########################################################
# 		Email configuration
#########################################################
define('HOST',"smtp.gmail.com");
define('PORT',465);
define('EMAILUSERNAME',"demo@emantras.com");
define('EMAILPASSWORD',"Welcome123");
define('FROMEMAIL',"demo@emantras.com");
define('FROMEMAILNAME',"Pravasvani Administrator");
define('TOEMAIL',"demo@emantras.com");

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

#############################################
#            DEFAULT DECLARATION            #
#############################################
define("ADMIN_TITLE", "FrontedPage - Admin");
?>