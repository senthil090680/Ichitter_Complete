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
	require_once 'common/header1.php';	
		
	$user_id = SESS_USER_ID;
	$data = array('get_all_newsstreams'=>1,'user_id'=>$user_id);
	
	$init_process_obj = new INIT_PROCESS(NEWS_SERVICE,$data);
     //echo $init_process_obj->response;
	$news = ($ObjJSON->decode($init_process_obj->response));	
	
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

<div class="Messagechat">
    <?php 
        foreach ($news as $v){
           $v = (array)$v;
          
    ?>
    <div class="Messageconts">
         <?php if($v['priv_name']){ ?>
           <h5><a href="profile.php?user_id=<?php echo $v['user_id']; ?>"><?php echo $v['name']; ?></a></h5>
        <?php }else{ ?>
           <h5><a href="profile.php?user_id=<?php echo $v['user_id']; ?>"><?php echo $v['email']; ?></a></h5>
        <?php } ?>
		<?php if($v['news'] == 'Profile'){ ?>
           <p>has changed their <?php echo $v['news']; ?></p>
		<?php }elseif($v['news'] == 'Added Friend'){ ?>
			<p><?php echo $v['news']; ?></p>
		<?php }elseif($v['news'] == 'Private'){ ?>
			<p>has changed their <?php echo $v['news']; ?> settings</p>
		<?php }elseif($v['news'] == 'Public'){ ?>
			<p>has changed their <?php echo $v['news']; ?> settings</p>
		<?php } ?>
           <div id="line" align="center"><img src="resource/images/line.jpg" /></div>
      </div>
    <?php } ?>
</div>
	

	
		</div>
		</div>

		
		<div id="contentRight">
		
		<?php include ('common/right_side_navigation.php');?>
		
		</div>
		

			<?php require_once 'common/footer1.php'; ?>	