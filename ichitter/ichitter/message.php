<?php
	require_once 'lib/include_files.php';
	require_once('lib/profile_photo_include.php');
	
	//error_reporting(E_ALL);

	if(isset($_REQUEST['logout']) && $_REQUEST['logout'] == 'OK'){
		$session_obj->unset_Session('login');	
		echo "<script>window.location = 'index.php'</script>";
	}
	
	if(trim(SESS_USER_ID) == ''){
		echo "<script>window.location = 'index.php'</script>";
	}
	require_once 'common/header1.php';
	
		
	$user_id = $_SESSION['login']['user_id'];
	$data = array('action'=>'getall_msg','user_id'=>SESS_USER_ID);
	$data += $REQ_SEND;
	$init_process_obj = new INIT_PROCESS(MSG_SERVICE,$data);
	//echo $init_process_obj->response;
	$unread_msg = (array)($ObjJSON->decode($init_process_obj->response));
	
	foreach($unread_msg as $k => $v){
		$unread_msg[$k] = (array)($v);
		$unread_msg[$k]['msgsenttime'] = (array)($unread_msg[$k]['msgsenttime']);
	}
	/*echo '<pre />';
	print_r($unread_msg);*/
	
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



	<?php if($count_unread_msg['total'] > 0){ ?>
	<div class="Messagechat unread">
	<?php 
	
			foreach($unread_msg as $v){
				if(!$v['msg_flag']){
				$requested_frnd_img = '';
				if(isset($v['image_name']) && trim($v['image_name']) != ''){
				
					if(isset($v['igallery_name'])){
						
						$requested_frnd_img = IMAGE_UPLOAD_SERVER. $v['user_id'] ."/". $v['igallery_name'] ."/thumb/". $v['image_name'];
					}else{
						$requested_frnd_img = IMAGE_UPLOAD_SERVER. $v['user_id'] ."/thumb/". $v['image_name'];
					}
				}else{
					if($v['gender'] == 'm'){
						$requested_frnd_img = "resource/images/male-small.jpg";
					}elseif($v['gender'] == 'f'){
						$requested_frnd_img = "resource/images/female-small.jpg";
					}		
				}
				
				
	?>
	<div class="msgall" id="<?php echo $v['user_id']; ?>">
		<div class="Messageimg"><img width="50" height="50" src="<?php echo $requested_frnd_img; ?>"  /></div>
		<div class="delmessageconts">
			<h5><?php echo $v['name']; ?></h5>
			<p class="msg" id="<?php echo $v['msg_id']; ?>"><?php echo $v['msg']; ?></p>
		</div>
		<div class="hdm">
			<p><?php 
					echo $v['msg_sent_time']; 
				?></p>	
				<p><a href="detailed_msg.php?user_id=<?php echo $v['user_id']; ?>" ><?php echo VIEWMORE; ?></a></p>		
		</div>
		<div class="clear"></div>
	</div>
	<div class="msgborder"></div>
	<?php } }  ?>
	</div>
	<?php }?>
	


	<?php if(sizeof($unread_msg)){ 
			$read = 0;			
			foreach($unread_msg as $v){
				if($v['msg_flag']){
				$requested_frnd_img = '';
				if(isset($v['image_name']) && trim($v['image_name']) != ''){
				
					if(isset($v['igallery_name'])){
						
						$requested_frnd_img = IMAGE_UPLOAD_SERVER. $v['user_id'] ."/". $v['igallery_name'] ."/thumb/". $v['image_name'];
					}else{
						$requested_frnd_img = IMAGE_UPLOAD_SERVER. $v['user_id'] ."/thumb/". $v['image_name'];
					}
				}else{
					if($v['gender'] == 'm'){
						$requested_frnd_img = "resource/images/male-small.jpg";
					}elseif($v['gender'] == 'f'){
						$requested_frnd_img = "resource/images/female-small.jpg";
					}		
				}
				
				if(!$read){ $read = 1;
				
	?>
	<div class="Messagechat read">
	<?php } ?>
	<div class="msgall" id="<?php echo $v['user_id']; ?>">
		<div class="Messageimg"><img width="50" height="50" src="<?php echo $requested_frnd_img; ?>"  /></div>
		<div class="delmessageconts">
			<h5><?php echo $v['name']; ?></h5>
			<p class="msg" id="<?php echo $v['msg_id']; ?>"><?php echo $v['msg']; ?></p>
		</div>
		<div class="hdm">
			<p><?php echo $v['msg_sent_time']; ?></p>			
			<p><a href="detailed_msg.php?user_id=<?php echo $v['user_id']; ?>" ><?php echo VIEWMORE; ?></a></p>
		</div>
		<div class="clear"></div>
	</div>
	
	
	
	
	<div class="msgborder"></div>
	<?php }
	}  if($read) {?>
</div>	
	<?php } } 
		if(!sizeof($unread_msg)){
	?>
	<div class="Messagechat norecords">Message(s) not found</div>
	<?php } ?>
	
		</div>
		</div>

		
		<div id="contentRight">
		
		<?php include ('common/right_side_navigation.php');?>
		
		</div>
		

			<?php require_once 'common/footer1.php'; ?>	