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
	
	if(isset($_REQUEST['user_id'])){
		$user_id = $_REQUEST['user_id'];
	}else{
		$user_id = SESS_USER_ID;
	}
	$data = array('action'=>'get_all_newsstreams','user_id'=>$user_id);
	$data = $REQ_SEND + $data;
	$init_process_obj = new INIT_PROCESS(NEWS_SERVICE,$data);
     
	$news = ($ObjJSON->decode($init_process_obj->response));
	
	//echo $init_process_obj->response;
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
<div class="msgheader"><?php echo NEWS_TITLE; ?></div>


    <?php 
		$unread = "";
		$read = "";
        foreach ($news as $v){
           $v = (array)$v;
		  /* echo '<pre />';
		   print_r($v);*/
		  if($v['news_added_time'] > $v['read_time']){
    	$unread .= '<div class="Messageconts ">';
        if($v['priv_name']){ $user_name = $v['name']; 
           $unread .= '<h5><a href="profile.php?user_id='. $v['user_id']. '">'. $v['name']. '</a></h5>';
        }else{ 
		 	$user_name = $v['email']; 
           $unread .= '<h5><a href="profile.php?user_id='.$v['user_id'].'">'. $v['email'].'</a></h5>';
        } 
		switch($v['news']){
			case 'Profile':
				$unread .= '<p>'.$user_name.' has changed '. $v['news'].'</p>';
			break;
			case 'Added Friend':
				$unread .= '<p>'.$user_name.' '.$v['news'].' with <a href="profile.php?user_id='.$v['news_rel_details']->user_id.'">'.$v['news_rel_details']->name.'</a></p>';
			break;
			case 'Requested Friend':
				$unread .= '<p>'.$user_name.' '.$v['news'].' to <a href="profile.php?user_id='.$v['news_rel_details']->user_id.'">'.$v['news_rel_details']->name.'</a></p>';
			break;
			case 'Private':
				$unread .= '<p>'.$user_name.'  has changed '.$v['news'].' settings</p>';
			break;
			case 'Public':
				$unread .= '<p>'.$user_name.' has changed '.$v['news'].' settings</p>';
			break;
			case 'Groups':
				$unread .= '<p>'.$user_name.' has created <a href="group_details.php?grpid='.$v['news_rel_id'].'" >'.$v['news_rel_details']->group_name.'</a> group</p>';
			break;
			case 'Group Members':
				if($v['news_rel_details']->priv_name){ 
					$user_name = $v['news_rel_details']->first_name; 				   
				}else{ 
					$user_name = $v['news_rel_details']->email; 				   
				} 
				$unread .= '<p>'.$user_name.' has joined <a href="group_details.php?grpid='.$v['news_rel_details']->group_id.'" >'.$v['news_rel_details']->group_name.'</a> group</p>';
			break;
		}
           $unread .= '<div id="line" align="center"><img src="resource/images/line.jpg" /></div>
      </div>';
    }else{ 
	$read .= '<div class="Messageconts ">';
        if($v['priv_name']){ $user_name = $v['name']; 
           $read .= '<h5><a href="profile.php?user_id='. $v['user_id']. '">'. $v['name']. '</a></h5>';
         }else{ 
		 	$user_name = $v['email']; 
           $read .= '<h5><a href="profile.php?user_id='.$v['user_id'].'">'. $v['email'].'</a></h5>';
        } 
		
		switch($v['news']){
			case 'Profile':
				$read .= '<p>'.$user_name.' has changed '. $v['news'].'</p>';
			break;
			case 'Added Friend':
				//$read .= '<p>'.$v['news'].'</p>';
				$read .= '<p>'.$user_name.' '.$v['news'].' with <a href="profile.php?user_id='.$v['news_rel_details']->user_id.'">'.$v['news_rel_details']->name.'</a></p>';
			break;
			case 'Requested Friend':
				$read .= '<p>'.$user_name.' '.$v['news'].' to <a href="profile.php?user_id='.$v['news_rel_details']->user_id.'">'.$v['news_rel_details']->name.'</a></p>';
			break;
			case 'Private':
				$read .= '<p>'.$user_name.'  has changed '.$v['news'].' settings</p>';
			break;
			case 'Public':
				$read .= '<p>'.$user_name.' has changed '.$v['news'].' settings</p>';
			break;
			case 'Groups':
				$read .= '<p>'.$user_name.' has created <a href="group_details.php?grpid='.$v['news_rel_id'].'" >'.$v['news_rel_details']->group_name.'</a> group</p>';
			break;
			case 'Group Members':
				$read .= '<p>'.$user_name.' has joined <a href="group_details.php?grpid='.$v['news_rel_id'].'" >'.$v['news_rel_details']->group_name.'</a> group</p>';
			break;
		}
           $read .= '<div id="line" align="center"><img src="resource/images/line.jpg" /></div>
      </div>';
	}} 
		if(trim($unread)){
	?>
	
	<div class="Messagechat unread">
		<?php echo $unread; ?>
	</div>
	<?php }
	
	if(trim($read)){
	?>
	
	<div class="Messagechat">
		<?php echo $read; ?>
	</div>
	<?php
	
	}?>
	

	
		</div>
		</div>

		
		<div id="contentRight">
		
		<?php include ('common/right_side_navigation.php');?>
		
		</div>
		

			<?php require_once 'common/footer1.php'; ?>	