<?php
	/*limit word to editprofile page*/
	define('SHORT_WORD',20);
	define('SENT_REQUEST','"Add  Friend" request has been sent');
	define('ALREADY_SENT','"Add Friend" request has been sent already.');
	
	//SESSION
	define('SESS_USER_ID',$_SESSION['login']['user_id']); // USER ID
	define('SESS_USER_NAME',$_SESSION['login']['username']); // USER NAME
	//search
	define('SINGLE_SRC_RESULT','Search Result');
	define('SRC_RESULTS','Search Results');
	define('SRC_ERROR','No matches found for your keyword');
	
	//contact
	define('CONTACT_ERROR','No Available contacts!');
	define('MSG_SUCCESS','Your message has been sent successfully.');
	define('BAD_WORD','You have bad word(s) in msg.');
	
	// news
	
	define('DENIED','"Not Now" request has been sent');
	
	// profile errors
	define('NO_PHOTO','No Available Photos!');
	define('NO_VIDEO','No Available Videos!');
	
	//profile_contacts error
	define('ADDED_INNERCIRCLE','Added in Inner Circle.');
	
	// request page error
	define('NO_REQ','No Friend Request!');
	
	//page titles	
	define('CONTACTS_TITLE','Contacts');
	define('REQUEST_TITLE','Friends Request');
	define('MSG_TITLE','Messages');	
	define('NEWS_TITLE','News Streams');
	
	/* SERVICE PAGES */
	define('CONTACT_SERVICE', SERVICE_NAME.'contact_service.php');
	define('EDITPROFILE_SERVICE', SERVICE_NAME.'editprofile_service.php');
	define('REQ_SERVICE', SERVICE_NAME.'request_service.php');
	define('REGISTRATION_SERVICE', SERVICE_NAME . 'registration_service.php');
	define('POSTING_SERVICE', SERVICE_NAME . 'posting_service.php');
	define('MSG_SERVICE',SERVICE_NAME.'msg_service.php');
	define('COMMON_SERVICE',SERVICE_NAME.'common_service.php');
	define('NEWS_SERVICE',SERVICE_NAME.'news_service.php');	
	define('SECURITY_SERVICE',SERVICE_NAME.'security_service.php');
	define('CALANDER_SERVICE',SERVICE_NAME.'calander_service.php');
	define('DISCUSSION_SERVICE',SERVICE_NAME.'discussion_service.php');
	define('CHATTING_SERVICE', SERVICE_NAME.'chatting_service.php');
	define('BEFORELOGOUT_SERVICE', SERVICE_NAME.'beforelogout_service.php');
	define('CLASS_GROUP_SERVICE', SERVICE_NAME.'class.group_service.php');
	define('CREATE_GROUP_SERVICE', SERVICE_NAME.'class.group_service.php');
	define('GET_GROUPS_USER_OR_JOINED', SERVICE_NAME.'class.group_service.php');
	define('GRP_CHAT_SERVICE', SERVICE_NAME.'chat_service.php');
	define('CREATE_GALLERY_SERVICE', SERVICE_NAME.'create_gallery_service.php');
	define('CREATE_VIDEO_GALLERY_SERVICE', SERVICE_NAME.'create_video_gallery_service.php');
	define('DELETE_ALBUM_SERVICE', SERVICE_NAME.'delete_album_service.php');
	define('DELETE_IMAGES_SERVICE', SERVICE_NAME.'delete_images_service.php');
	define('DELETE_VIDEO_ALBUM_SERVICE', SERVICE_NAME.'delete_video_album_service.php');
	define('PHOTOS_FETCH_SERVICE', SERVICE_NAME.'photos_fetch_service.php');
	define('VIDEO_FETCH_SERVICE', SERVICE_NAME.'video_fetch_service.php');
	define('VIDEO_UPLOAD_SERVICE', SERVICE_NAME.'video_upload_service.php');
	define('DELETE_VIDEOS_SERVICE', SERVICE_NAME.'delete_videos_service.php');
	define('GET_VIDEO_GALLERY_SERVICE', SERVICE_NAME.'get_video_gallery_service.php');
	define('WEBSERVICE_URL', SERVICE_NAME.'webservice.php');
	define('GET_PHOTO_GALLERY_SERVICE', SERVICE_NAME.'get_photo_gallery_service.php');
			
			

	//common msg
	
	define('VIEWMORE','View More');
	
	//common error
	
	define('FAILURE','Failure of current action. Please retry');
	define('MSG_EMPTY','Please enter your msg');
	
	
	
	// MSG PAGE
	
	define('SEND_MSG_TXT','Send message');
	define('REPLY_MSG_TXT','Reply message'); 
?>