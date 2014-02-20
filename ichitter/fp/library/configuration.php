<?php
session_start();
error_reporting(0);
/* default settings */

/* define variables */
define("ALL_PAGE_TITLE", "FrontedPage");
define("LINKTO_GO_TO_POSTING", "Go to Postings");
define("LINKTO_MY_MARKED_LIST", "My Marked List");
define ("ENC_KEY", "EmAnTrAs");

define("POSTINGS_NOT_FOUND", 'Postings are not found'); 
define("MARKED_POSTINGS_NOT_FOUND", 'Marked items are not found');
define("MY_MARKED_NOT_FOUND", 'My Marked List not found');

/* SERVICE PATHS */
define("WEBSITE_NAME", "http://tsg.emantras.com");
//define("WEBSITE_NAME", "http://localhost");
define('SERVICE_NAME',				WEBSITE_NAME . "/ichitter_service/");

/* REMOTE GALLERY PATHS */
define("IMAGE_UPLOAD_SERVER",		SERVICE_NAME . "upload/photos/");
define("VIDEO_UPLOAD_SERVER",		SERVICE_NAME . "upload/videos/");

/* SERVICE PAGES */

define("LOGIN_SERVICE_PAGE",		SERVICE_NAME . "login_service.php");
define("USER_REGISTER_SERVICE_PAGE", SERVICE_NAME . "registration_service.php");
define("TOPIC_SERVICE_PAGE",		SERVICE_NAME . "topic_service.php");
define("SUBTOPIC_SERVICE_PAGE",		SERVICE_NAME . "subtopic_service.php");
define("POSTING_SERVICE_PAGE",		SERVICE_NAME . "posting_service.php");
define("GALLERY_SERVICE_PAGE",		SERVICE_NAME . "gallery_service.php");
define("MARKING_SERVICE_PAGE",		SERVICE_NAME . "marking_service.php");
define("DISCUSSION_SERVICE_PAGE",	SERVICE_NAME . "discussion_service.php");
define("BW_SERVICE_PAGE",			SERVICE_NAME . "bw_service.php");
define("LOGOUT_SERVICE_PAGE",			SERVICE_NAME . "beforelogout_service.php");

//define("SVR_INCL_PATH",				WEBSITE_NAME . "/fp/services/includes/");
?>