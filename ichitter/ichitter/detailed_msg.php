<?php
	require_once 'lib/include_files.php';
	require_once('lib/profile_photo_include.php');
	if(isset($_REQUEST['logout']) && $_REQUEST['logout'] == 'OK'){
		$session_obj->unset_Session('login');	
		echo "<script>window.location = 'index.php'</script>";
	}
	
	if(trim(SESS_USER_ID) == ''){
		echo "<script>window.location = 'index.php'</script>";
	}
	
	$user_id = SESS_USER_ID;
	$data = array('action'=>'readmsg','user_id'=>SESS_USER_ID.':'.$_REQUEST['user_id']);
	$data += $REQ_SEND;
	$init_process_obj = new INIT_PROCESS(MSG_SERVICE,$data);
	//echo $init_process_obj->response;
	
	require_once 'common/header1.php';
	/* $newsstreams array comes from header1.php*/
	//if($count_unread_msg['total'] > 0){	
		
		$user_id = SESS_USER_ID;
		$data = array();
		$data = array('action'=>'get_indivitual_msg','sender_user_id'=>SESS_USER_ID,'receiver_user_id'=>$_REQUEST['user_id']);
		$data += $REQ_SEND;
		
		$init_process_obj = new INIT_PROCESS(MSG_SERVICE,$data);
		//echo $init_process_obj->response;
		$user_datas = (array)($ObjJSON->decode($init_process_obj->response));
		
		foreach($user_datas['msg'] as $k => $v){
			$user_datas['msg'][$k] = $ObjJSON->objectToArray($v);	
		}
		
			
		$requested_frnd_img = '';
		if(isset($user_datas['image_name']) && trim($user_datas['image_name']) != ''){
			if(isset($user_datas['igallery_name'])){				
				$requested_frnd_img = IMAGE_UPLOAD_SERVER. $user_datas['user_id'] ."/". $user_datas['igallery_name'] ."/thumb/". $user_datas['image_name'];
			}else{
				$requested_frnd_img = IMAGE_UPLOAD_SERVER. $user_datas['user_id'] ."/thumb/". $user_datas['image_name'];
			}
		}else{
			if(isset($user_datas['gender']) && $user_datas['gender'] == 'm'){
				$requested_frnd_img = "resource/images/male-small.jpg";
			}elseif(isset($user_datas['gender']) &&  $user_datas['gender'] == 'f'){
				$requested_frnd_img = "resource/images/female-small.jpg";
			}		
		}
		
		//echo $requested_frnd_img;
?>

<script>
	$(document).ready(function(){
		$('.unread > .msgall').hover(function(){
			if(!$(this).find('#send_msg_box').length || $('#send_msg_box').css('display') == 'none'){
				$('.msg_read').remove();			
				if($(this).find('.msg').css('display') == 'none'){
					$(this).find('.hdm').append('<p onclick="open_msg(this)" class="msg_read" id="read_msg">Read</p>');
				}else{
					$(this).find('.hdm').append('<p onclick="reply(this)" class="msg_read" id="reply_msg">Reply</p>');
				}
			}
		},function(){
			$('.msg_read').remove();
		});
		
		 $('.read > .msgall').hover(function(){
			if(!$(this).find('#send_msg_box').length || $('#send_msg_box').css('display') == 'none'){
				$('.msg_read').remove();
					$(this).find('.hdm').append('<p onclick="reply(this)" class="msg_read" id="reply_msg">Reply</p>');
			}
		},function(){
			$('.msg_read').remove();
		});
		
	});
	
	function open_msg(whr){
		$(whr).parent().prev().find('.msg').slideDown();
		$(whr).hide();
		$(whr).after('<p onclick="reply(this)" class="msg_read" id="reply_msg">Reply</p>');
		var url = "<?php echo MSG_SERVICE; ?>";		
		var data = "readmsg=1&val="+$(whr).parent().prev().find('.msg').attr('id');
		var result = ajax_function(url,data);
		result = $.parseJSON(result);
		if(result.success == 'OK'){
			var c = $.trim($('#msg_ids .msg_alert').text()) - 1;
			if(c > 0){
				$('#msg_ids .msg_alert').text(c);
			}else{
				$('#msg_ids .msg_alert').remove();
			}
		}else if(result.failure == 'OK'){
		
		}
	}
	
	

</script>
		<div id="contentLeft">
		    <div id="leftmenulist">	
			<?php include ('common/side_navigation.php');?>
			</div>
		  <div id="mainupload">	
<div class="msgheader"><?php echo MSG_TITLE; ?></div>
	<div class="Messagechat">
	<?php
		
		foreach($user_datas['msg'] as $k => $v){
			if($v['receiver_user_id'] == SESS_USER_ID){
	?>
	<div class="msgall">
					<div class="Messageimg"><img width="50" height="50" src="<?php echo $requested_frnd_img ; ?>"></div>
					<div class="delmessageconts">
						<h5><?php echo $user_datas['name']; ?></h5>
						<p id="<?php echo $v['msg_id']; ?>" class="msg"><?php echo $v['msg']; ?></p>
					</div>
					<div class="hdm">
						<p><?php echo $v['msg_sent_time']; ?></p>			
					</div>
					<div class="clear"></div>
				</div>
				<div class="msgborder"></div>
	<?php
		}else{
	?>
	<div class="msgall">
		<div class="Messageimg"><img width="50" height="50" src="<?php echo $profile_img ; ?>"></div>
		<div class="delmessageconts">
			<h5><?php echo $user_name; ?></h5>
			<p class="msg"><?php echo $v['msg']; ?></p>
		</div>
		<div class="hdm">
			<p><?php echo $v['msg_sent_time']; ?></p>			
		</div>
		<div class="clear"></div>
	</div>
	<div class="msgborder"></div>
	<?php 
		}
		}
		
		$reply_id = end($user_datas['msg']);
		
		if($reply_id['sender_user_id'] != SESS_USER_ID){
			$msg_status = 'reply';	
			$user_id = $_REQUEST['user_id'];		
			$reply_id = $reply_id['msg_id'];
			$param = "'".$msg_status."',".$user_id.",".$reply_id;
		}else{
			$msg_status = 'send';
			$reply_id = $_REQUEST['user_id'];
			$param = "'".$msg_status."',".$reply_id;
		}
		
	?>
	<div class="clear"></div>
	<div id="send_msg_box" style="display: block;"><div id="send_msg_title">Reply message</div><div class="clear"></div><div class="msgInput_bg"><div style="float: left;margin-top:2px;"><textarea class="reply_txt" name="sendInput" onkeypress="extend_size(this,event)"></textarea></div><div onclick="send_msg(this,<?php echo $param;  ?>)" class="send_btn"><img src="resource/images/reply_small.png" style=""></div><div class="clear"></div></div><div class="clear"></div></div>
</div>

	
	

	
		</div>
		</div>

		
		<div id="contentRight">
		
		<?php include ('common/right_side_navigation.php');?>
		
		</div>
		

			<?php require_once 'common/footer1.php'; ?>	