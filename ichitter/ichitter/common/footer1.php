<div id="backgroundChatPopup"></div>
<div id="footer">
		  <div class="social">
<ul>
<p>Join Us</p>
<li><a href="#"><img src="resource/images/socialicon1.png" alt="facebook" border="0" /></a></li>
<li><a href="#"><img src="resource/images/socialicon2.png" alt="twitter" border="0" /></a></li>
<li><a href="#"><img src="resource/images/socialicon3.png" alt="myspace" border="0" /></a></li>
<li><a href="#"><img src="resource/images/socialicon4.png" alt="digg" border="0" /></a></li>
<li><a href="#"><img src="resource/images/socialicon5.png" alt="orkut" border="0" /></a></li>


</ul>


</div>

<div class="footernavi">
	  <ul>
	    <li ><a href="#">Privacy Policy</a></li>
		<li ><a href="#">Site Map</a></li>
		<li style="border-right:none;"><a href="#">Contact Us</a></li>
	   </ul>
	   <div class="copyright"><p>© 2011</p><img src="resource/images/bot-logo.jpg" alt="" /></div>
	   	</div>
		 </div>

	</div>
	
</div>
<script>
	var request_ids = $.trim($('#request_ids .msg_alert').text());
	var msg_ids = $.trim($('#msg_ids .msg_alert').text());
	var news_ids = $.trim($('#news_ids .msg_alert').text());
	window.setInterval(function(){
		msg_alt_count_loader();		
		
	},10000);
	
	function remove_msg_alt(msg_alt){
		msg_alt.remove();
	}
	
	function msg_alt_count_loader(){
		var data = "action=get_header_alt&user_id=<?php echo SESS_USER_ID;?>&url=<?php echo COMMON_SERVICE;?>";
		var url = "common_process.php";
		var result = ajax_function(url,data);
		var process1 = $.parseJSON(result);
		var newsstreams = $.parseJSON(process1.all_request).total;
		var count_unread_msg = $.parseJSON(process1.unread_msg).total;
		var count_unread_news = $.parseJSON(process1.unread_news).total;
		
		if(newsstreams > 0 && newsstreams > request_ids){
			alt_msg($('#request_ids a'),newsstreams);
		}
		
		if(count_unread_msg > 0 && count_unread_msg > msg_ids){
			alt_msg($('#msg_ids a'),count_unread_msg);
		}
		
		if(count_unread_news > 0 && count_unread_news > news_ids){
			alt_msg($('#news_ids a'),count_unread_news);
		}else if($('#news_ids a div').hasClass('msg_alert') && count_unread_news == 0){
			remove_msg_alt($('#news_ids a div.msg_alert'));			
		}
	}
	
</script>
</body>
</html>
