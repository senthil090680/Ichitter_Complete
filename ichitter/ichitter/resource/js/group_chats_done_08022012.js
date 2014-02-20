$(document).ready(function(){

$(window).load(function () {
	readcookiegroups();
});
var service_name = $("#service_name_hidden").val();
var glovar = 0;

	$("#openchat").click(function(){
		var group_ids = $("#grp_id_chat").val();
		var posturl = service_name+"chat_service.php";
		var user_ids = $("#user_id_chat").val();
		$.post(posturl, { user_id: user_ids, group_id : group_ids, 'click_get_chats': 'click_get_chats'},
		   function(data) {
		   if(data != ""){
				var checkchat = $("#wrapperChat"+group_ids).css("display");
				//var checkopen = $("#glovar"+chatgroup_id).val();
				var checkopen = readCookie('publicchat'+group_ids);
				var groupname = groupname_ajax(group_ids,posturl);
				$(" <div />" ).attr("id","wrapperChat"+group_ids)
				.addClass("wrapperChat")
				.html('<div id="menu" class="menugrp"><p class="welcome"><b>'+groupname+'<b></p><p class="logout"><a id="exit" class="exit" onclick="javascript:return closeGroupChatBox(this,\''+group_ids+'\');"><b>X</b></a></p><div style="clear:both"></div></div><div id="chatbox" class="chatbox1" style="display:block;"></div><div style="padding-top:280px;"><input type="hidden" value="glovar'+group_ids+'\" name="glovar'+group_ids+'\" id="glovar'+group_ids+'\"/><textarea class="chatboxtextarea1" onkeydown="javascript:return checkGroupChatBoxInputKey(event,this,\''+group_ids+'\');"></textarea></div>').appendTo($( "body" ));
				
				var chatBoxeslength = 0;
				var i,x,y,ARRcookies=document.cookie.split(";");
				for (i=0;i<ARRcookies.length;i++)
				{
					x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
					if(k = x.substr(11)) {
						chatBoxeslength++;
					}
				}								
				
				if (chatBoxeslength == 0) {
					$("#wrapperChat"+group_ids).css('right', '20px');
					$("#wrapperChat"+group_ids).css("float","right");
					$("#wrapperChat"+group_ids).css("display","block");

				} else {
					width = (chatBoxeslength)*(225+7)+20;
					$("#wrapperChat"+group_ids).css('right', width+'px');
					$("#wrapperChat"+group_ids).css("float","right");
					$("#wrapperChat"+group_ids).css("display","block");
				}

				var CookieValue = group_ids;
				createCookie('publicchat'+group_ids,group_ids,1);
			}
		});
		restructureChatBoxes();
	});

	function createCookie(name,value,days) {
		if (days) {
			var date = new Date();
			date.setTime(date.getTime()+(days*24*60*60*1000));
			//date.setTime(date.getTime()+(days*60*24));
			var expires = "; expires="+date.toGMTString();
		}
		else var expires = "";
		document.cookie = name+"="+value+expires+"; path=/";
	}

	//var CookieValue = <?php echo $group_id; ?>;
	//createCookie('publicchat',CookieValue,1);

	function readCookie(name) {
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for(var i=0;i < ca.length;i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1,c.length);
			if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
		}
		return null;
	}
	
	//Load the file containing the chat log
	function loadLog(){
	 var user_ids = $("#user_id_chat").val();
		var posturl = service_name+"chat_service.php";
		$.post(posturl, { user_id: user_ids, get_incomming_chats: 'get_chats'},
		   function(data) {
		       if(data != "error"){
					var dataJSON = $.parseJSON(data);
					$.each(dataJSON, function(cookey,chatgroup_id) {
						alert(chatgroup_id);
						$.post(posturl, { user_id: user_ids, group_id : chatgroup_id, get_chats: 'get_chats'},
						   function(data) {
							   if(data != ""){
									checkincommingchats();								
								}
						});
						checkchatmsg = 0;
					});

				restructureChatBoxes();
				glovar = 1;
			   }else{
			     glovar = 0;
			   }
		});
	}


    function checkincommingchats(){
		var user_ids = $("#user_id_chat").val();
		var posturl = service_name+"chat_service.php";
		$.post(posturl, { user_id: user_ids, get_grpincomming_chats: 'get_chats'},
		   function(data) {
		       if(data != "error"){
					var dataJSON = $.parseJSON(data);
					$.each(dataJSON, function(cookey,chatgroup_id) {
						$.post(posturl, { user_id: user_ids, group_id : chatgroup_id, get_chats: 'get_chats'},
						   function(data) {
							   if(data != "") {
									var checkchat = $("#wrapperChat"+chatgroup_id).css("display");
									var checkopen = readCookie('publicchat'+chatgroup_id);
									var chatopenalr = readCookie('chatopen'+chatgroup_id);
									var groupname = groupname_ajax(chatgroup_id,posturl);
									if(((checkchat != "block") || (typeof checkchat === "undefined")) && ((checkopen == '' || checkopen == null) || (chatopenalr != '')) ) {
										$(" <div />" ).attr("id","wrapperChat"+chatgroup_id)
										.addClass("wrapperChat")
										.html('<div id="menu" class="menugrp"><p class="welcome"><b>'+groupname+'<b></p><p class="logout"><a id="exit" class="exit" onclick="javascript:return closeGroupChatBox(this,\''+chatgroup_id+'\');"><b>X</b></a></p><div style="clear:both"></div></div><div id="chatbox" class="chatbox1" style="display:block;">'+data+'</div><div style="padding-top:280px;"><input type="hidden" value="glovar'+chatgroup_id+'\" name="glovar'+chatgroup_id+'\" id="glovar'+chatgroup_id+'\"/><textarea class="chatboxtextarea1" onkeydown="javascript:return checkGroupChatBoxInputKey(event,this,\''+chatgroup_id+'\');"></textarea></div>').appendTo($( "body" ));
										
										var chatBoxeslength = 0;
										var i,x,y,ARRcookies=document.cookie.split(";");
										for (i=0;i<ARRcookies.length;i++)
										{
											x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
											if(k = x.substr(11)) {
												chatBoxeslength++;
											}
										}								
										
										alert(chatBoxeslength);
										if (chatBoxeslength == 0) {
											$("#wrapperChat"+chatgroup_id).css('right', '20px');
										} else {
											width = (chatBoxeslength)*(225+7)+20;	
											$("#wrapperChat"+chatgroup_id).css('right', width+'px');
										}
								
										$("#wrapperChat"+chatgroup_id).css("float","right");
										$("#wrapperChat"+chatgroup_id).css("display","block");
										
										var CookieValue = chatgroup_id;
										createCookie('publicchat'+chatgroup_id,chatgroup_id,1);
									}									
									else {
										$("#wrapperChat"+chatgroup_id).css("float","right");
										$("#wrapperChat"+chatgroup_id+" .chatbox1").html(data);
									}									
								}
						});
						checkchatmsg = 0;
					});

				restructureChatBoxes();
				glovar = 1;
			   }else{
			     glovar = 0;
			   }
		});
		
	}
	

	//setInterval (checkincommingchats, 3000);	//Reload file every 3 seconds	
	setInterval (loadLog, 1000);	//Reload file every 1 second

	function restructureGrpChatBoxes() {
		align = 0;
		var i,x,y,ARRcookies=document.cookie.split(";");
		for (i=0;i<ARRcookies.length;i++)
		{
			x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
			if(k = x.substr(11)) {
				var group_ids = k;
				if ($("#wrapperChat"+group_ids).css('display') != 'none') {
					if (align == 0) {
						$("#wrapperChat"+group_ids).css('right', '20px');
					} else {
						width = (align)*(225+7)+20;	
						$("#wrapperChat"+group_ids).css('right', width+'px');
					}
					align++;
				}
			}
		}								
	}

	function readcookiegroups() {
		var i,x,ARRcookies=document.cookie.split(";");
		var y=0;
			$.each(ARRcookies, function(cookey,cookeyval) {

			x=cookeyval.substr(0,cookeyval.indexOf("="));
			k = x.substr(11);
			if(k) {
				var group_ids = k;
				var posturl = service_name+"chat_service.php";
				var user_ids = $("#user_id_chat").val();
				$.post(posturl, { user_id: user_ids, group_id : group_ids, 'open_cookie_chats': 'open_cookie_chats'},
				   function(data) {
				   if(data != ""){
						var groupname = groupname_ajax(group_ids,posturl);
						$(" <div />" ).attr("id","wrapperChat"+group_ids)
						.addClass("wrapperChat")
						.html('<div id="menu" class="menugrp"><p class="welcome"><b>'+groupname+'<b></p><p class="logout"><a id="exit" class="exit" onclick="javascript:return closeGroupChatBox(this,\''+group_ids+'\');"><b>X</b></a></p><div style="clear:both"></div></div><div id="chatbox" class="chatbox1" style="display:block;">'+data+'</div><div style="padding-top:280px;"><input type="hidden" value="glovar'+group_ids+'\" name="glovar'+group_ids+'\" id="glovar'+group_ids+'\"/><textarea class="chatboxtextarea1" onkeydown="javascript:return checkGroupChatBoxInputKey(event,this,\''+group_ids+'\');"></textarea></div>').appendTo($( "body" ));			
						if(y == 0) {
							$("#wrapperChat"+group_ids).css('right', '20px');
						} else {
							width = (y)*(225+7)+20;	
							$("#wrapperChat"+group_ids).css('right', width+'px');
						}
						y++;															
						$("#wrapperChat"+group_ids).css("display","block");
						var CookieValue = group_ids;
						createCookie('publicchat'+group_ids,group_ids,1);

					}
				});				
			}
		});
		restructureGrpChatBoxes();
	}

	function userid_ajax(recuser_id) {
		var jsonResp;
		jsonResp = $.ajax({		 
			   url: "chat.php",
			   data: {'action':'get_user_name','user_id':recuser_id},		   
			   Aasync: false,
			   dataType: "json"
		  }).responseText;

		var obj = $.parseJSON(jsonResp);	
		return  obj.recusername;
	}

	function groupname_ajax(group_id,posturl) {
		var jsonResp;
		jsonResp = $.ajax({		 
			url: posturl,
			data: {'get_group_name':'get_group_name','group_id':group_id},
			async: false,
			dataType: "json"
		  }).responseText;
		
		var obj = $.parseJSON(jsonResp);
		return obj.groupname;
	}	
});

	function checkGroupChatBoxInputKey(grpevent,grpchatboxtextarea,chatboxtitle) { 
		var service_name = document.getElementById('service_name_hidden').value;
		if(grpevent.keyCode == 13 && grpevent.shiftKey == 0)  {
			message = $(grpchatboxtextarea).val();
			message = message.replace(/^\s+|\s+$/g,"");

			$(grpchatboxtextarea).val('');
			$(grpchatboxtextarea).focus();
			var user_id = $("#user_id_chat").val();
			$(grpchatboxtextarea).css('height','44px');
			if (message != '') {
				 var posturl = service_name+"chat_service.php";
					$.post(posturl, { chatText: message, user_id: user_id, group_id: chatboxtitle, insertchat: 'insertchat' },
					   function(data) {
					});							
			}
			return false;
		}
	}
	function closeGroupChatBox(groupChat,groupid) {
		$("#wrapperChat"+groupid).css("display","none");		
		eraseCookie('publicchat'+groupid);
		restructureGrpChatBoxes();
		var checkopen = readCookie('publicchat'+groupid);
	}

	function restructureGrpChatBoxes() {
		align = 0;
		//alert("af");
		var i,x,y,ARRcookies=document.cookie.split(";");
		for (i=0;i<ARRcookies.length;i++)
		{
			x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
			if(k = x.substr(11)) {
				var group_ids = k;
				if ($("#wrapperChat"+group_ids).css('display') != 'none') {
					//alert(k);
					if (align == 0) {
						$("#wrapperChat"+group_ids).css('right', '20px');
						$("#wrapperChat"+group_ids).css("float","right");
					} else {
						width = (align)*(225+7)+20;	
						$("#wrapperChat"+group_ids).css('right', width+'px');
						$("#wrapperChat"+group_ids).css("float","right");
					}
					align++;
				}
			}
		}								
	}


	
	function eraseCookie(name) {
		createCookie(name,"",-1);
	}

	function createCookie(name,value,days) {
		if (days) {
			var date = new Date();
			date.setTime(date.getTime()+(days*24*60*60*1000));
			//date.setTime(date.getTime()+(days*60*24));
			var expires = "; expires="+date.toGMTString();
		}
		else var expires = "";
		document.cookie = name+"="+value+expires+"; path=/";
	}

	function readCookie(name) {
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for(var i=0;i < ca.length;i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1,c.length);
			if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
		}
		return null;
	}