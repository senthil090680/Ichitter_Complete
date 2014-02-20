<?php
/* default settings */
session_start();
error_reporting(0);
/* define variables */

define('ENC_KEY',"EmAnTrAs");
//define('WEB_SERVICE_URL', "http://tsg.emantras.com/");
define('WEB_SERVICE_URL', "http://localhost/");
define('SERVICE_NAME', WEB_SERVICE_URL. "ichitter_service/");
define('IMAGE_UPLOAD_SERVER', SERVICE_NAME . "upload/photos/");
define('VIDEO_UPLOAD_SERVER', SERVICE_NAME . "upload/videos/");
?>