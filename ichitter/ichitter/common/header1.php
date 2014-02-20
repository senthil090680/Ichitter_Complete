<?php
require_once('lib/include_files.php');
	$data = array('action'=>'get_header_alt','user_id'=>SESS_USER_ID);	
	
	$data = $REQ_SEND + $data;
	$init_process_obj = new INIT_PROCESS(COMMON_SERVICE,$data);
	
	$process1 = $ObjJSON->decode($init_process_obj->response);	
	//echo $init_process_obj->response;
	$common_arr = (array)($process1);	
	foreach($common_arr as $k=>$v){	
		$common_arr[$k] = (array)($ObjJSON->decode($v));
	}
	
	
	$newsstreams['total'] = $common_arr['all_request']['total'];
	$count_unread_msg['total'] = $common_arr['unread_msg']['total'];
	$count_unread_news['total'] = $common_arr['unread_news']['total'];
	//echo $count_unread_news['total'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>iChitter</title>
<link rel="stylesheet" href="resource/css/general.css" type="text/css" media="screen" />
<link href="resource/css/style.css" rel="stylesheet" type="text/css"/>
<link href="resource/css/style1.css" rel="stylesheet" type="text/css">
<!--[if IE 7]>
<link rel="stylesheet" type="text/css" href="css/style-ie7.css"/>
<![endif]-->
<!--<script type="text/javascript" src="resource/js/jquery-1.6.1.min.js"></script>-->
<script type="text/javascript" src="resource/js/jquery-1.7.min.js"></script>
<script type="text/javascript" src="resource/js/common.js"></script>
<script src="resource/js/scrolling.js" type="text/javascript"></script>
<script src="resource/js/jquery.ui.1.8.18.js" type="text/javascript"></script>

<!--<script src="resource/js/jquery.ui.core.js" type="text/javascript"></script>
<script src="resource/js/jquery.ui.widget.js" type="text/javascript"></script>
<script src="resource/js/jquery.ui.mouse.js" type="text/javascript"></script>
<script src="resource/js/jquery.ui.draggable.js" type="text/javascript"></script>-->

<link rel="stylesheet" href="resource/css/prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
<script src="resource/js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
<script> 
	$(document).ready(function(){
		$('.searchInput,.searchBtn').bind('keyup click',function(e){
			if($(this).hasClass('searchBtn') || ($(this).hasClass('searchInput') && e.which == '13')){
				manual_search();
			}
		});
		
		<?php if($newsstreams['total'] > 0){ ?>
			alt_msg($('#request_ids a'),<?php echo $newsstreams['total']; ?>);
		<?php } ?>
		
		<?php if($count_unread_msg['total'] > 0){ ?>
			alt_msg($('#msg_ids a'),<?php echo $count_unread_msg['total']; ?>);
		<?php } ?>
		
		<?php if($count_unread_news['total'] > 0){ ?>
			alt_msg($('#news_ids a'),<?php echo $count_unread_news['total']; ?>);
		<?php }else{ ?>
			remove_msg_alt($('#news_ids a div.msg_alert'));
		<?php } ?>
		
	});
	
	function alt_msg(whr,tot){
		var val = $.trim($(whr).find('.msg_alert').text());		
		var l = parseInt(whr.offset().left) + parseInt(2) + 'px';
		var t = $('#request_ids').offset().top - 15 + 'px';
		
		$(whr).find('.msg_alert').remove();
		whr.append('<div class="msg_alert" style="display:block;top:'+t+';left:'+l+'">'+tot+'</div>');
		if(tot > val){
			$(whr).find('.msg_alert').fadeOut('slow').fadeIn('slow');
		}
	}
	
	function manual_search(){
		var val = $.trim($('.searchInput').val());
		if(val != ''){
			window.location = 'profilecontacts.php?search='+val;
		}else{
			alert('Please enter your search value');
		}
	}
	
	function req_confirm(whr,response_user_id,request_user_id,status){
		
		var url = "<?php echo CONTACT_SERVICE; ?>";
		var field_name = $.trim($(this).attr('id'));				
		var data = "action=confirmfriend&status="+status+"&response_user_id="+response_user_id+"&request_user_id="+request_user_id+"&url="+url;
		var result = ajax_function('common_process.php',data);
		result = $.parseJSON(result);		
		if(result.success == 'OK'){
			url = "<?php echo REQ_SERVICE; ?>";
			var field_name = $.trim($(this).attr('id'));				
			var data = 'action=get_all_request&user_id=<?php echo SESS_USER_ID; ?>&url='+url;
			var result = ajax_function('common_process.php',data);
			result = $.parseJSON(result);
			
			if(result.total > 0){
				alt_msg($('#request_ids a'),result.total);
			}else{
				$('.msg_alert').remove();
			}
			
			
			if(status == 'confirm'){
			<?php if(isset($_REQUEST['preview_from'])){ ?>			
				var parent_window = window.opener;
				parent_window.$('#'+<?php echo $_REQUEST['user_id']; ?>).hide();				
			<?php }else{ ?>
			$(whr).parents().closest('.friendschat').fadeOut('slow');
			<?php } ?>
				url = "<?php echo CONTACT_SERVICE; ?>";
				var data = 'action=get_group_contact&user_id=<?php echo SESS_USER_ID; ?>&url='+url;
				var result = ajax_function('common_process.php',data);
				var result_data = $.parseJSON(result);
				
				for(var i = 0; i < result_data.length; i++){
					
					if(result_data[i].image_name != null){
						var img_src = "<?php echo IMAGE_UPLOAD_SERVER ?>";
						if($.trim(result_data[i].igallery_name)){
							img_src += result_data[i].user_id +"/"+ result_data[i].igallery_name +"/thumb/"+ result_data[i].image_name;
						}else{
							img_src += result_data[i].user_id +"/thumb/"+ result_data[i].image_name;
						}
						result_data[i].image_name =  img_src;
					}else{
						if(result_data[i].gender = 'm'){
							result_data[i].image_name = 'resource/images/male-small.jpg';
						}else{
							result_data[i].image_name = 'resource/images/female-small.jpg';
						}
					}
				}
				
				var h = '<h1>Contacts </h1>';
				for(var i = 0; i < result_data.length; i++){
					h += '<div class="contactscont"><div class="contactsimg"><a href="profile.php?user_id='+result_data[i].user_id+'"><img width="40" height="40" alt="" src="'+ result_data[i].image_name +'"></a></div><div class="contactstext">';
					if(result_data[i].priv_name == 1){
						h += '<h5>'+result_data[i].first_Name+'</h5>';
					}
					
					h += '<p>';
					if(result_data[i].state_name != null && result_data[i].state_name != ''){
						h += result_data[i].state_name
					} 
					h += '</p></div></div>';
				}
				<?php if(isset($_REQUEST['preview_from'])){ ?>
					parent_window.$('#contacts').html(h);
					window.close();
				<?php }else{ ?>
					$('#contacts').html(h);
				<?php } ?>
				$(whr).parents().closest('.right_side_btn').html('<div class="after_success">Confirmed Successfully!</div>');	
				//window.opener.location.reload();
			}else if(status == 'deny'){
				$(whr).parent().before('<div class="after_success"><?php echo DENIED; ?></div>');				
				$(whr).parent().remove();
			}
		}
	
	}
	
	function addfriend(whr,ids){
	var t = $(whr).parents().hasClass('mutual_frnds');
		var url = "<?php echo CONTACT_SERVICE; ?>";
		var field_name = $.trim($(this).attr('id'));				
		var data = "action=addfriend&ids="+ids+"&url="+url;
		var result = ajax_function('common_process.php',data);
		

		if(t){
            $(whr).parent().slideUp('slow');
			$(whr).parent().remove();
        }
		//result = $.parseJSON(result);
		//if(result.success == 'true'){
			var h = '<div class="after_success"><?php echo SENT_REQUEST; ?></div>';		
		<?php if(isset($_REQUEST['flag']) && $_REQUEST['flag'] == ""){ ?>
			var u_id = <?php echo $_REQUEST['user_id'] ?>;
				window.opener.$('#'+u_id+' .addfrnd').prev().html(h);
				window.opener.$('#'+u_id+' .addfrnd').remove();
				window.close();
		<?php }else{ ?>
				$(whr).parent().prev().html(h);
				
		<?php } ?>
			$(whr).hide();
		//}
	}
	
	function send_msg(whr,status,receiver_user_id,msg_id){
		$('.show_alt_msg').slideUp().remove();		
		var msg = $.trim($('[name=sendInput]').val());
		if(msg != ''){
			var url = "<?php echo MSG_SERVICE; ?>";
			//var field_name = $.trim($(this).attr('id'));	
			var val = $.trim($('[name=sendInput]').val()).replace(/\n/g,"<br>");
			
			if(status == 'send'){
				var data = "action=sendmsg&val="+val+"&sender_user_id=<?php echo SESS_USER_ID; ?>&receiver_user_id="+receiver_user_id+"&url="+url;
			}else if(status == 'reply'){
				var data = "action=replymsg&val="+val+"&sender_user_id=<?php echo SESS_USER_ID; ?>&receiver_user_id="+receiver_user_id+"&msg_id="+msg_id+"&url="+url;
			}
			
			var result = ajax_function('common_process.php',data);
			result = $.parseJSON(result);
			if(result.badword == 'OK'){
				$('.msgInput_bg').after('<div class="show_alt_msg"><?php echo BAD_WORD; ?></div>');
				$('.show_alt_msg').slideDown();
			}else if(result.success == 'OK'){
				$('.msgInput_bg').after('<div class="show_alt_msg"><?php echo MSG_SUCCESS; ?></div>');
				$('#rply_msg label').removeAttr('id');
                    if(!$('#send_msg_box').siblings().hasClass('rply_user_class')){
                        var h = '';
                        if(!$('#send_msg_box').prev().prev().hasClass('msgborder')){
                            h += '<div class="msgborder"></div>';
                        }
                        h += '<div class="msgall rply_user_class"><div class="Messageimg"><img height="50" width="50" src="<?php echo $profile_img; ?>"></div>';
                        h += '<div class="delmessageconts"><h5><?php echo SESS_USER_NAME; ?></h5><p class="rply_msg" class="msg">';
                        h += '<label class="cur" >'+val+'</label>';
                        h += '</p></div></div>';
                        $('#send_msg_box').prev().before(h);
                   }else{
                       
                       $(whr).closest('#send_msg_box').siblings().find('.rply_msg').append('<br /><label class="cur" >'+val+'</label>');
                       
                   }
				$(whr).closest('#send_msg_box').siblings().find('.rply_msg label:last-child').fadeOut().fadeIn();
                    
				$('.show_alt_msg').slideDown();
			}else if(result.failure == 'OK'){
				$('.msgInput_bg').after('<div class="show_alt_msg"><?php echo FAILURE; ?></div>');
				$('.show_alt_msg').slideDown();
			}
			$('[name=sendInput]').val('').height(18);
		}else{
			$('.msgInput_bg').after('<div class="show_alt_msg"><?php echo MSG_EMPTY; ?></div>');
			$('.show_alt_msg').slideDown();
		}
	}
	
	function reply(whr){
		$('#send_msg_box').remove();
		var receiver_id = $(whr).parents('.msgall').attr('id');
		var msg_id = $(whr).parent().prev().find('.msg').attr('id');
			var h = '<div id="send_msg_box"><div id="send_msg_title"><?php echo REPLY_MSG_TXT; ?></div><div style="float:right;color:#fff;font-weight:bold;cursor:pointer" onclick="close_msg()">X</div><div class="clear"></div><div class="msgInput_bg"><div style="float: left;margin-top:2px;"><textarea onkeypress="extend_size(this,event)" name="sendInput" class="reply_txt"></textarea></div><div class="send_btn" onclick="send_msg(this,\'reply\','+receiver_id+','+msg_id+')"><img style="" src="resource/images/reply_small.png" /></div><div class="clear"></div></div><div class="clear"></div></div>';
			
			$(whr).parents('.msgall').append(h);
			$('#send_msg_box').slideDown();
			
			$(whr).attr('onclick','');
	}
	
	function extend_size(whr,e){
		if($(whr).height() != 54 && e.which == 13){
			$(whr).height($(whr).height() + 18);
		}
	}
	
	function close_msg(){
		$('#send_msg_box').slideUp();
	}
	
</script>	
<style>
	.msg_alert{
		width:22px;
		height:20px;
		background-image:url(resource/images/msg-box.png);
		text-align:center;
		font-size:10px;
		display:none;
		position:absolute;
	}
</style>

<?php

    $script = $_SERVER['SCRIPT_NAME'];
	if(!strstr($script,'group_details.php')) { ?>
		
		<link type="text/css" rel="stylesheet" media="all" href="resource/css/chat.css" />
		<script type="text/javascript" src="resource/js/chat.js"></script>

		<link href="resource/css/group_chats.css" rel="stylesheet" type="text/css">
		<script src="resource/js/group_chats.js" type="text/javascript"></script>

	<?php 	
		} 
	$user_id = $_SESSION['login']['user_id'];
	?>

	<script language="javascript" type="text/javascript">
		var isClose = false;
		//this code will handle the F5 or Ctrl+F5 key

		//need to handle more cases like ctrl+R whose codes are not listed here
		document.onkeydown = checkKeycode
		function checkKeycode(e) {
			var keycode;
			if (window.event)
				keycode = window.event.keyCode;
			else if (e)
				keycode = e.which;
			if(keycode == 116)
			{
				isClose = true;
			}
		}
		function somefunction()
		{
			isClose = true;
		}
		window.onbeforeunload=function(e) { 
			if(!isClose)
			{
				var user_ids = $("#user_id_chat").val();
				var jsonResp;
				jsonResp = $.ajax({		 
					   url	: "beforelogout_process.php",
					   data	: {'bflogout':'bf_logout','user_id':user_ids},
					   type	: "POST",
					   async: false
				  }).responseText;
				//alert(jsonResp);
				//alert('window is closing');
			}
		};
		/*function onunl() {
			if(!isClose)
			{
				var user_ids = $("#user_id_chat").val();
				var jsonResp;
				jsonResp = $.ajax({		 
					   url	: "beforelogout_process.php",
					   data	: { 'bflogout' : 'bflogout', 'user_id':user_ids},
					   type	: "POST",
					   async: false
				  }).responseText;

				alert(jsonResp);
				alert('window is closing');
			}
		}*/
	</script>
</head>

<body onmousedown="somefunction()">

<?php if(!strstr($script,'group_details.php')) { 
	$grp_id = $_REQUEST[grp_id_chat];  ?>
<input type="hidden" name="grp_id_chat" id="grp_id_chat" value="<?php echo $grp_id; ?>">
<input type='hidden' id='udetails_<?php echo $user_id; ?>' value='<?php echo $owner_name; ?>'>

				<!-- Chat Window HTML Start -->
				<!--<div id="wrapperChat" class="wrapperChat">
					<div id="menu" class="menugrp">
						<p class="welcome"><b><?php echo $user_name; ?></b></p>
						<p class="logout"><a id="exit" class="exit" href="javascript:;"><b>X</b></a></p>
						<div style="clear:both"></div>
					</div>
					<div id="chatbox" class="chatbox">
						<?php
							if(file_exists("log.html") && filesize("log.html") > 0){
								$handle = fopen("log.html", "r");
								$contents = fread($handle, filesize("log.html"));
								fclose($handle);

								echo $contents;
							}
						?>
					</div>
					<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
					<form name="message" action="">
						<input name="usermsg" class="usermsg" type="text" id="usermsg" size="150" autocomplete="off" />
						<input name="submitmsg" type="submit"  id="submitmsg" value="Send" />
					</form>
				</div>-->

				<!-- Chat Window HTML END -->		

<?php } ?>
<input type="hidden" id="service_name_hidden" value="<?php echo SERVICE_NAME; ?>">
<input type="hidden" name="user_id_chat" id="user_id_chat" value="<?php echo $user_id; ?>">


<div id="container">
	<div id="wrapper">
		<div id="header">
			<a href="index.php"><img src="resource/images/logo.png" border="0" class="logo" /></a>
			<div id="request_ids" style="float:left;margin:25px 0 0 20px;color:#fff;">
				<a alt="Friends Request" title="Friends Request" href="req.php"><img src="resource/images/request.png"  /></a>
			</div>
			<div id="msg_ids">
				<a alt="Messages" title="Messages" href="message.php"><img src="resource/images/msg_small.png"  /></a>
			</div>
			<div id="news_ids">
				<a alt="News Streams" title="News Streams" href="news.php"><img src="resource/images/earth_small.png"  /></a>
			</div>
			<div id="headerRight">
				<div class="headerNav">
					<ul>
						<li><a href="../fp/add_newpost.php" target="_blank">Uploads</a></li>
						<li><a href="message.php">Messages</a></li>
						<li><a href="contacts.php">Contacts</a></li>
						<li><a href="editprofile.php">Profile</a></li>
						<li><a href="#" >My Account</a>						
							<ul>
								<li><a href="overlook.php">Overlook</a></li>
								<li><a href="security-settings.php">Security Settings</a></li>
								<li><a href="#">Customize</a></li>
								<li><a href="changepassword.php">Change Password</a></li>
								<li><a href="?logout=OK">Logout</a></li>
							</ul>
						</li>


					<li style="margin-right:2px"><a href="news.html">Home</a></li>
				</ul>
				</div>
				<div id="searchHeader">
					<input class="searchInput" name="" type="text" size="35" />
					<a href="#"><img class="searchBtn" src="resource/images/search-btn.png" /></a>
				</div>
			</div>
			<div style="clear:both"></div>
			<div style="float:right;margin-top:32px;" class="profiletdtxt2">Welcome <?php echo SESS_USER_NAME; ?></div>
		</div>