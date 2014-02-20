$(document).ready(function(){

$(window).load(function () {
	readcookiegroups();
});
var service_name = $("#service_name_hidden").val();
var GroupnewMessages = new Array();
var GroupchatboxFocus = new Array();
var glovar = 0;
	
	$("#openchat").click(function(){
		var group_ids = $("#grp_id_chat").val();
		//var posturl = service_name+"chat_service.php";
		var posturl = "group_chatting_process.php";
		var user_ids = $("#user_id_chat").val();
			var checkchat = $("#wrapperChat"+group_ids).css("display");
			var checkopen = readCookie('publicchat'+group_ids);
			if((checkchat != "block") || (typeof checkchat === "undefined")) {
				var groupname = groupname_ajax(group_ids,posturl);
				$(" <div />" ).attr("id","wrapperChat"+group_ids)
				.addClass("wrapperChat")
				.html('<div id="menu" class="menugrp"><p class="welcome"><b>'+groupname+'<b></p><p class="logout"><a href="javascript:void(0)" class="minimi" onclick="javascript:toggleGroupChatBoxGrowth(this,\''+group_ids+'\')"><img class="minicon" src="resource/images/under.png" alt="Min" /></a>&nbsp;<a id="exit" class="exitone" href="javascript:void(0)" onclick="javascript:return closeGroupChatBox(this,\''+group_ids+'\');"><b>X</b></a></p><div style="clear:both"></div></div><div id="chatbox" class="chatbox1" style="display:block;"></div><div style="padding-top:280px;"><input type="hidden" value="glovar'+group_ids+'\" name="glovar'+group_ids+'\" id="glovar'+group_ids+'\"/><textarea class="chatboxtextarea1" onkeydown="javascript:return checkGroupChatBoxInputKey(event,this,\''+group_ids+'\');"></textarea></div>').appendTo($( "body" ));
				
				$('.menugrp').mouseover(function(){
					$(this).css('cursor','move');
				});

				$('.wrapperChat').click(function(){
					$(".wrapperChat").css('z-index','');
					$(".chatbox").css('z-index','');
					$(this).css('z-index','999');
					
				});

				$('.menugrp').mousedown(function(){
					$(".wrapperChat").css('z-index','');
					$(".chatbox").css('z-index','');
					$(this).parent().css('z-index','999');
					$(this).css('cursor','move');
					if(!$(this).find('a').hasClass('test')){
						$("#wrapperChat"+group_ids).draggable({ "containment": "window" });
					}					
				});

				$('.menugrp').mouseup(function(){
					$("#wrapperChat"+group_ids).draggable("destroy");
				});
				

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
			else {
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
		restructureGrpChatBoxes();
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
		//var posturl = service_name+"chat_service.php";
		var posturl = "group_chatting_process.php";

		for (x in GroupnewMessages) {
			//alert(x);
			//alert(GroupchatboxFocus[x]+"inchat");
			if (GroupnewMessages[x] == true) {
				//alert($("#wrapperChat"+x+" .chatboxtextarea1").hasClass('chatboxtextareaselected'));
				if($("#wrapperChat"+x+" .chatboxtextarea1").hasClass('chatboxtextareaselected')) {
					GroupchatboxFocus[x] = true;
				} else if (!$("#wrapperChat"+x+" .chatboxtextarea1").hasClass('chatboxtextareaselected')) {
					GroupchatboxFocus[x] = false;
				}
				if (GroupchatboxFocus[x] == false) {
					//FIXME: add toggle all or none policy, otherwise it looks funny
					$("#wrapperChat"+x+" .menugrp").toggleClass('grpchatboxblink');
				}
			}
		}
		$.post(posturl, { user_id: user_ids, get_incomming_chats: 'get_chats'},
		   function(data) {
		       if(data != "error"){
				    //alert(data);
					var dataJSON = $.parseJSON(data);
					$.each(dataJSON, function(cookey,chatgroup_id) {
						//alert(chatgroup_id);
						$.post(posturl, { user_id: user_ids, group_id : chatgroup_id, get_chats: 'get_chats'},
						   function(data) {
							   if(data != ""){
								    //alert("13");
									updateincommingchats();
									var groupstatus = usercurstatus_ajax(user_ids,chatgroup_id,posturl);
									if(groupstatus == 1) {

										var checkchat	= $("#wrapperChat"+chatgroup_id).css("display");
										var checkopen	= readCookie('publicchat'+chatgroup_id);
										var chatopenalr	= readCookie('chatopen'+chatgroup_id);
										var groupname	= groupname_ajax(chatgroup_id,posturl);
										var username	= userid_ajax(user_ids);

										if(((checkchat != "block") || (typeof checkchat === "undefined")) && ((checkopen == '' || checkopen == null) || (chatopenalr != '')) ) {
											
											$(".chatbox").css('z-index','');
											$(".wrapperChat").css('z-index','');

											var grpchatusrids = $.ajax({
												type		: "POST",
												url         : posturl,
												data        : { 'user_id' : user_ids, 'group_id' : chatgroup_id, 'get_usrupdchat' : 'get_chats' },
												cache		: false,
												async		: false,
												dataType	: "text"

											}).responseText;

											var grpJSON = grpchatusrids;

											var grpusername	= userid_ajax(grpJSON);					

											$(" <div />" ).attr("id","confirmMessage"+chatgroup_id)
											.addClass("confirmMessage")
											.html('<div ><p class="closepbox"><label class="closexbox"><a class="closelink" href="javascript:void(0)" onclick="javascript:return closeConfirmBox(this,\''+chatgroup_id+'\');"><b><img src="resource/images/pop-close-small.png" /></b></a></label></p><p style="padding-top:25px;padding-bottom:20px;padding-left:10px;"><b> '+grpusername+' from group '+groupname+' is wanting to chat with you</b></p><div style="clear:both"></div></div><div style="display:block;display:inline;padding-left:20px;padding-right:80px;"><a class="firstlink" href="javascript:void(0)" onclick="javascript:return OpenGroupChatBox(this,\''+chatgroup_id+'\');"><img src="resource/images/accept.png" /></a></div>&nbsp;&nbsp;<div style="display:inline;"><a class="secondlink" href="javascript:void(0)" onclick="javascript:return closeConfirmBox(this,\''+chatgroup_id+'\');"><img src="resource/images/busy.png" /></a><br/><br/></div>').appendTo($( "body" ));
											$("#confirmMessage"+chatgroup_id).css("display","block");
											//checkincommingchats();

											$("#backgroundChatPopup").css({"opacity": "0.7"});
											$("#backgroundChatPopup").fadeIn("slow");
										}
										groupstatus = '';
									}
								}
						});
						checkchatmsg = 0;
					});

				//restructureGrpChatBoxes();
				glovar = 1;
			   }else{
			     glovar = 0;
			   }
		});
	}


    function checkincommingchats(){
		var user_ids = $("#user_id_chat").val();
		//var posturl = service_name+"chat_service.php";
		var posturl = "group_chatting_process.php";
		var y = 0;
		var grpdata;
		
		grpdata = $.ajax({
			url         : posturl,
            data        : { 'user_id' : user_ids, get_grpincomming_chats : 'get_chats' },
			cache		: false,
			async		: false,
			dataType	: "json",			
		}).responseText;

		if(grpdata != "error"){
			var dataJSON = $.parseJSON(grpdata);				 
			$.each(dataJSON, function(cookey,chatgroup_id) {
				var grpchatdata = $.ajax({
					type		: "POST",
					url         : posturl,
					data        : { 'user_id' : user_ids, 'group_id' : chatgroup_id, 'get_chats' : 'get_chats' },
					cache		: false,
					async		: false,
					dataType	: "text"

				}).responseText;
				
			   if(grpchatdata != "") {
						
					var checkchat = $("#wrapperChat"+chatgroup_id).css("display");
					var checkopen = readCookie('publicchat'+chatgroup_id);
					var chatopenalr = readCookie('chatopen'+chatgroup_id);
					var groupname = groupname_ajax(chatgroup_id,posturl);

					if(((checkchat != "block") || (typeof checkchat === "undefined")) && ((checkopen == '' || checkopen == null) || (chatopenalr != '')) ) {
						$(" <div />" ).attr("id","wrapperChat"+chatgroup_id)
						.addClass("wrapperChat")
						.html('<div id="menu" class="menugrp"><p class="welcome"><b>'+groupname+'<b></p><p class="logout"><a href="javascript:void(0)" class="minimi" onclick="javascript:toggleGroupChatBoxGrowth(this,\''+chatgroup_id+'\')"><img class="minicon" src="resource/images/under.png" alt="Min" /></a>&nbsp;<a id="exit" class="exitone" href="javascript:void(0)" onclick="javascript:return closeGroupChatBox(this,\''+chatgroup_id+'\');"><b>X</b></a></p><div style="clear:both"></div></div><div id="chatbox" class="chatbox1" style="display:block;">'+grpchatdata+'</div><div style="padding-top:280px;"><input type="hidden" value="glovar'+chatgroup_id+'\" name="glovar'+chatgroup_id+'\" id="glovar'+chatgroup_id+'\"/><textarea class="chatboxtextarea1" onkeydown="javascript:return checkGroupChatBoxInputKey(event,this,\''+chatgroup_id+'\');"></textarea></div>').appendTo($( "body" ));
						
						$('.menugrp').mouseover(function(){
							$(this).css('cursor','move');
						});

						$('.wrapperChat').click(function(){
							$(".wrapperChat").css('z-index','');
							$(".chatbox").css('z-index','');
							$(this).css('z-index','999');
							
						});

						$('.menugrp').mousedown(function(){
							$(".wrapperChat").css('z-index','');
							$(".chatbox").css('z-index','');
							$(this).parent().css('z-index','999');
							$(this).css('cursor','move');							
							if(!$(this).find('a').hasClass('test')){
								$("#wrapperChat"+chatgroup_id).draggable({ "containment": "window" });
							}
						});

						$('.menugrp').mouseup(function(){
							$("#wrapperChat"+chatgroup_id).draggable("destroy");
						});
						
						GroupchatboxFocus[chatgroup_id] = false;
						//alert(GroupchatboxFocus[chatgroup_id]+"usu1out");

						$("#wrapperChat"+chatgroup_id+" .chatboxtextarea1").blur(function(){
							GroupchatboxFocus[chatgroup_id] = false;
							//alert(GroupchatboxFocus[chatgroup_id]+"usu1");
							$("#wrapperChat"+chatgroup_id+" .chatboxtextarea1").removeClass('chatboxtextareaselected');
						}).focus(function(){
							GroupchatboxFocus[chatgroup_id] = true;
							//alert(GroupchatboxFocus[chatgroup_id]+"usu2");
							GroupnewMessages[chatgroup_id] = false;
							$('#wrapperChat'+chatgroup_id+' .menugrp').removeClass('grpchatboxblink');
							$("#wrapperChat"+chatgroup_id+" .chatboxtextarea1").addClass('chatboxtextareaselected');
						});

						$("#wrapperChat"+chatgroup_id).click(function() {
							//alert("usucheck1");
							if ($('#wrapperChat'+chatgroup_id+' .chatbox1').css('display') != 'none') {
								//alert("usucheck2");
								$("#wrapperChat"+chatgroup_id+" .chatboxtextarea1").focus();
							}
						});							
													
						//alert(y+"tg");
						if(y == 0) {
							$("#wrapperChat"+chatgroup_id).css('right', '20px');
						} else {
							width = (y)*(225+7)+20;	
							$("#wrapperChat"+chatgroup_id).css('right', width+'px');
						}
						y++;
						//alert(y+"ac");
									
						$("#wrapperChat"+chatgroup_id).css("float","right");
						$("#wrapperChat"+chatgroup_id).css("display","block");
						
						var CookieValue = chatgroup_id;
						createCookie('publicchat'+chatgroup_id,chatgroup_id,1);
					}									
					else {
						//alert(y+"ty");
						if(y == 0) {
							$("#wrapperChat"+chatgroup_id).css('right', '20px');
						} else {
							width = (y)*(225+7)+20;	
							$("#wrapperChat"+chatgroup_id).css('right', width+'px');
						}
						y++;
						//alert(y+"ab");
						
						GroupnewMessages[chatgroup_id] = true;
						//$("#wrapperChat"+chatgroup_id+" .menugrp").toggleClass('grpchatboxblink');
						$("#wrapperChat"+chatgroup_id+" .chatbox1").html(grpchatdata);
					}									
				}
				checkchatmsg = 0;
			});
			restructureGrpChatBoxes();
	   }else{
		 glovar = 0;
	   }
	}

	function updateincommingchats(){
		var user_ids = $("#user_id_chat").val();
		//var posturl = service_name+"chat_service.php";
		var posturl = "group_chatting_process.php";
		var y = 0;
		var grpdata;
		
		grpdata = $.ajax({
			url         : posturl,
			data        : { 'user_id' : user_ids, get_updincomming_chats : 'get_chats' },
			cache		: false,
			async		: false,
			dataType	: "json",			
		}).responseText;

		if(grpdata != "error"){
			var dataJSON = $.parseJSON(grpdata);				 
			$.each(dataJSON, function(cookey,chatgroup_id) {
				//alert(chatgroup_id);
				var grpchatdata = $.ajax({
					type		: "POST",
					url         : posturl,
					data        : { 'user_id' : user_ids, 'group_id' : chatgroup_id, 'get_chats' : 'get_chats' },
					cache		: false,
					async		: false,
					dataType	: "text"

				}).responseText;
				
			   if(grpchatdata != "") {

					var grpchatgrpids = $.ajax({
						type		: "POST",
						url         : posturl,
						data        : { 'user_id' : user_ids, 'group_id' : chatgroup_id, 'get_updchat' : 'get_chats' },
						cache		: false,
						async		: false,
						dataType	: "text"

					}).responseText;

					var grpJSON = grpchatgrpids;
					//alert(grpJSON);
					var checkchat = $("#wrapperChat"+chatgroup_id).css("display");
					var checkopen = readCookie('publicchat'+chatgroup_id);
					var chatopenalr = readCookie('chatopen'+chatgroup_id);
					var groupname = groupname_ajax(chatgroup_id,posturl);

					if(((checkchat != "block") || (typeof checkchat === "undefined")) && ((checkopen == '' || checkopen == null) || (chatopenalr != '')) ) {
						
					}									
					else {
						//alert(y+"ty");
						if(y == 0) {
							$("#wrapperChat"+chatgroup_id).css('right', '20px');
						} else {
							width = (y)*(225+7)+20;	
							$("#wrapperChat"+chatgroup_id).css('right', width+'px');
						}
						y++;
						//alert(y+"ab");
						
						GroupchatboxFocus[chatgroup_id] = false;
						//alert(GroupchatboxFocus[chatgroup_id]+"updaout");
						$("#wrapperChat"+chatgroup_id+" .chatboxtextarea1").blur(function(){
							GroupchatboxFocus[chatgroup_id] = false;
							//alert(GroupchatboxFocus[chatgroup_id]+"upda1");
							$("#wrapperChat"+chatgroup_id+" .chatboxtextarea1").removeClass('chatboxtextareaselected');
						}).focus(function(){
							GroupchatboxFocus[chatgroup_id] = true;
							//alert(GroupchatboxFocus[chatgroup_id]+"upda2");
							GroupnewMessages[chatgroup_id] = false;
							$('#wrapperChat'+chatgroup_id+' .menugrp').removeClass('grpchatboxblink');
							$("#wrapperChat"+chatgroup_id+" .chatboxtextarea1").addClass('chatboxtextareaselected');
						});

						$("#wrapperChat"+chatgroup_id).click(function() {
							//alert("updcheck1");
							if ($('#wrapperChat'+chatgroup_id+' .chatbox1').css('display') != 'none') {
								//alert("updcheck1");
								$("#wrapperChat"+chatgroup_id+" .chatboxtextarea1").focus();
							}
						});
						
						//$("#wrapperChat"+chatgroup_id+" .menugrp").effect("pulsate", { times:3 }, 2000);
						//$("#wrapperChat"+chatgroup_id+" .menugrp").toggleClass('grpchatboxblink');
						//alert(grpchatdata);
						
						if(grpJSON != "") {
							GroupnewMessages[chatgroup_id] = true;
						}
						//GroupnewMessages[chatgroup	_id] = true;
						$("#wrapperChat"+chatgroup_id+" .chatbox1").html(grpchatdata);
					}									
				}
				checkchatmsg = 0;
			});
			restructureGrpChatBoxes();
	   }else{
		 glovar = 0;
	   }
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
				//alert(cookeyval);
			x=cookeyval.substring(0,cookeyval.indexOf("="));
			//alert(navigator.appName);
			k = x.substring(11);
			if(k) {
				//alert(k);
				var group_ids = k;
				//var posturl = service_name+"chat_service.php";
				var posturl = "group_chatting_process.php";
				var user_ids = $("#user_id_chat").val();
				$.post(posturl, { user_id: user_ids, group_id : group_ids, 'open_cookie_chats': 'open_cookie_chats'},
				   function(data) {
				   if(data != ""){
					   var groupstatus = usercurstatus_ajax(user_ids,group_ids,posturl);
						
						if(groupstatus == 1) {
							var groupname = groupname_ajax(group_ids,posturl);
							$(" <div />" ).attr("id","wrapperChat"+group_ids)
							.addClass("wrapperChat")
							.html('<div id="menu" class="menugrp"><p class="welcome"><b>'+groupname+'<b></p><p class="logout"><a href="javascript:void(0)" class="minimi" onclick="javascript:toggleGroupChatBoxGrowth(this,\''+group_ids+'\')"><img class="minicon" src="resource/images/under.png" alt="Min" /></a>&nbsp;<a id="exit" class="exitone" href="javascript:void(0)" onclick="javascript:return closeGroupChatBox(this,\''+group_ids+'\');"><b>X</b></a></p><div style="clear:both"></div></div><div id="chatbox" class="chatbox1" style="display:block;">'+data+'</div><div style="padding-top:280px;"><input type="hidden" value="glovar'+group_ids+'\" name="glovar'+group_ids+'\" id="glovar'+group_ids+'\"/><textarea class="chatboxtextarea1" onkeydown="javascript:return checkGroupChatBoxInputKey(event,this,\''+group_ids+'\');"></textarea></div>').appendTo($( "body" ));
							
							$('.menugrp').mouseover(function(){
								$(this).css('cursor','move');
							});

							$('.wrapperChat').click(function(){
								$(".wrapperChat").css('z-index','');
								$(".chatbox").css('z-index','');
								$(this).css('z-index','999');
								
							});

							$('.menugrp').mousedown(function(){
								$(".wrapperChat").css('z-index','');
								$(".chatbox").css('z-index','');
								$(this).parent().css('z-index','999');
								$(this).css('cursor','move');		
								if(!$(this).find('a').hasClass('test')){
									$("#wrapperChat"+group_ids).draggable({ "containment": "window" });
								}
							});

							$('.menugrp').mouseup(function(){
								$("#wrapperChat"+group_ids).draggable("destroy");
							});

							var minimizedGroupChatBoxes = new Array();

							if ($.cookie('groupchatbox_minimized')) {
								minimizedGroupChatBoxes = $.cookie('groupchatbox_minimized').split(/\|/);
							}
							minimize = 0;
							for (j=0;j<minimizedGroupChatBoxes.length;j++) {
								if (minimizedGroupChatBoxes[j] == group_ids) {
									minimize = 1;
								}
							}

							if (minimize == 1) {
								$('#wrapperChat'+group_ids).css('height','');
								$('#wrapperChat'+group_ids+'.wrapperChat').animate({ bottom: -349 }, 350);
								$('#wrapperChat'+group_ids+' .menugrp a:first-child').addClass('test');
								$('#wrapperChat'+group_ids+' .menugrp a:first-child').find('.minicon').attr('src','resource/images/max.png');
							}

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
			   cache: false,
			   data: {'action':'get_user_name','user_id':recuser_id},		   
			   async: false,
			   dataType: "json"
		  }).responseText;

		//alert(jsonResp);
		var obj = $.parseJSON(jsonResp);	
		return  obj.recusername;
	}	

	function groupname_ajax(group_id,posturl) {
		var jsonResp;
		jsonResp = $.ajax({		 
			url: posturl,
			cache: false,
			data: {'get_group_name':'get_group_name','group_id':group_id},
			async: false,
			dataType: "text"
		  }).responseText;		
		return jsonResp;
	}
	
	function usercurstatus_ajax(user_id,group_id,posturl) {
		var jsonResp;
		//alert(user_id);
		//alert(group_id);
		//alert(posturl);
		jsonResp = $.ajax({		 
			   url: posturl,
			   cache: false,
			   data: {'get_user_group_status':'get_user_group_status','user_id':user_id,'group_id':group_id},	   
			   async: false,
			   dataType: "text"
		  }).responseText;
		return  jsonResp;
	}
});
	

	function toggleGroupChatBoxGrowth(whr,chatboxtitle) {	
		if ($(whr).parents('.wrapperChat').css('bottom') == '-349px') {  	

			var minimizedGroupChatBoxes = new Array();
			
			if ($.cookie('groupchatbox_minimized')) {
				minimizedGroupChatBoxes = $.cookie('groupchatbox_minimized').split(/\|/);
			}

			var newCookie = '';

			for (i=0;i<minimizedGroupChatBoxes.length;i++) {
				if (minimizedGroupChatBoxes[i] != chatboxtitle) {
					newCookie += chatboxtitle+'|';
				}
			}

			newCookie = newCookie.slice(0, -1)


			$.cookie('groupchatbox_minimized', newCookie);
			$(whr).find('.minicon').attr('src','resource/images/under.png');
			$(whr).removeClass('test');
			$(whr).parents('.wrapperChat').animate({ "bottom" : "0px" }, 350);			
		} else {
			var newCookie = chatboxtitle;

			if ($.cookie('groupchatbox_minimized')) 
				newCookie += '|'+$.cookie('groupchatbox_minimized');
									
				$.cookie('groupchatbox_minimized',newCookie);
				
				$(whr).find('.minicon').attr('src','resource/images/max.png');
				$(whr).parents('.wrapperChat').css( "top","");
				$(whr).parents('.wrapperChat').animate({ "bottom" : "-349px" }, 350);
				$(whr).addClass('test');
		}		
	}

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
				 //var posturl = service_name+"chat_service.php";
		     	 var posturl = "group_chatting_process.php";
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

	function OpenGroupChatBox(groupChat,groupid) { 
		$("#confirmMessage"+groupid).css("display","none");
		$("#backgroundChatPopup").fadeOut("slow");
		checkincommingchats();
	}

	function checkincommingchats(){
		var user_ids = $("#user_id_chat").val();
		var service_name = document.getElementById('service_name_hidden').value;
		//var posturl = service_name+"chat_service.php";
		var posturl = "group_chatting_process.php";
		var GroupnewMessages = new Array();
		var GroupchatboxFocus = new Array();

		var y = 0;
		var grpdata;
		
		grpdata = $.ajax({
			url         : posturl,
            data        : { 'user_id' : user_ids, get_grpincomming_chats : 'get_chats' },
			cache		: false,
			async		: false,
			dataType	: "json",			
		}).responseText;

		if(grpdata != "error"){
			var dataJSON = $.parseJSON(grpdata);				 
			$.each(dataJSON, function(cookey,chatgroup_id) {
				var grpchatdata = $.ajax({
					type		: "POST",
					url         : posturl,
					data        : { 'user_id' : user_ids, 'group_id' : chatgroup_id, 'get_chats' : 'get_chats' },
					cache		: false,
					async		: false,
					dataType	: "text"

				}).responseText;
				
			   if(grpchatdata != "") {
						
					var checkchat = $("#wrapperChat"+chatgroup_id).css("display");
					var checkopen = readCookie('publicchat'+chatgroup_id);
					var chatopenalr = readCookie('chatopen'+chatgroup_id);
					var groupname = groupname_ajax(chatgroup_id,posturl);

					if(((checkchat != "block") || (typeof checkchat === "undefined")) && ((checkopen == '' || checkopen == null) || (chatopenalr != '')) ) {
						$(" <div />" ).attr("id","wrapperChat"+chatgroup_id)
						.addClass("wrapperChat")
						.html('<div id="menu" class="menugrp"><p class="welcome"><b>'+groupname+'<b></p><p class="logout"><a href="javascript:void(0)" class="minimi" onclick="javascript:toggleGroupChatBoxGrowth(this,\''+chatgroup_id+'\')"><img class="minicon" src="resource/images/under.png" alt="Min" /></a>&nbsp;<a id="exit" class="exitone" href="javascript:void(0)" onclick="javascript:return closeGroupChatBox(this,\''+chatgroup_id+'\');"><b>X</b></a></p><div style="clear:both"></div></div><div id="chatbox" class="chatbox1" style="display:block;">'+grpchatdata+'</div><div style="padding-top:280px;"><input type="hidden" value="glovar'+chatgroup_id+'\" name="glovar'+chatgroup_id+'\" id="glovar'+chatgroup_id+'\"/><textarea class="chatboxtextarea1" onkeydown="javascript:return checkGroupChatBoxInputKey(event,this,\''+chatgroup_id+'\');"></textarea></div>').appendTo($( "body" ));
						
						$('.menugrp').mouseover(function(){
								$(this).css('cursor','move');
						});

						$('.wrapperChat').click(function(){
							$(".wrapperChat").css('z-index','');
							$(".chatbox").css('z-index','');
							$(this).css('z-index','999');
							
						});

						$('.menugrp').mousedown(function(){
							$(".wrapperChat").css('z-index','');
							$(".chatbox").css('z-index','');
							$(this).parent().css('z-index','999');
							$(this).css('cursor','move');		
							if(!$(this).find('a').hasClass('test')){
								$("#wrapperChat"+chatgroup_id).draggable({ "containment": "window" });
							}
						});

						$('.menugrp').mouseup(function(){
							$("#wrapperChat"+chatgroup_id).draggable("destroy");
						});

						/*GroupchatboxFocus[chatgroup_id] = false;

						//alert(GroupchatboxFocus[chatgroup_id]+"after1");

						$("#wrapperChat"+chatgroup_id+" .chatboxtextarea1").blur(function(){
							GroupchatboxFocus[chatgroup_id] = false;
							//alert(GroupchatboxFocus[chatgroup_id]+"after2");
							$("#wrapperChat"+chatgroup_id+" .chatboxtextarea1").removeClass('chatboxtextareaselected');
						}).focus(function(){
							alert("1");
							GroupchatboxFocus[chatgroup_id] = true;
							//alert(GroupchatboxFocus[chatgroup_id]+"after3");
							GroupnewMessages[chatgroup_id] = false;
							$('#wrapperChat'+chatgroup_id+' .menugrp').removeClass('grpchatboxblink');
							$("#wrapperChat"+chatgroup_id+" .chatboxtextarea1").addClass('chatboxtextareaselected');
						});

						$("#wrapperChat"+chatgroup_id).click(function() {
							//alert("confcheck1");
							if ($('#wrapperChat'+chatgroup_id+' .chatbox1').css('display') != 'none') {
								//alert("confcheck1");
								$("#wrapperChat"+chatgroup_id+" .chatboxtextarea1").focus();
							}
						});	*/

													
						//alert(y+"tg");
						if(y == 0) {
							$("#wrapperChat"+chatgroup_id).css('right', '20px');
						} else {
							width = (y)*(225+7)+20;	
							$("#wrapperChat"+chatgroup_id).css('right', width+'px');
						}
						y++;
						//alert(y+"ac");
									
						$("#wrapperChat"+chatgroup_id).css("float","right");
						$("#wrapperChat"+chatgroup_id).css("display","block");
						
						var CookieValue = chatgroup_id;
						createCookie('publicchat'+chatgroup_id,chatgroup_id,1);
					}									
					else {
						//alert(y+"ty");
						if(y == 0) {
							$("#wrapperChat"+chatgroup_id).css('right', '20px');
						} else {
							width = (y)*(225+7)+20;	
							$("#wrapperChat"+chatgroup_id).css('right', width+'px');
						}
						y++;
						//alert(y+"ab");
						GroupnewMessages[chatgroup_id] = true;
						$("#wrapperChat"+chatgroup_id+" .chatbox1").html(grpchatdata);
					}									
				}
				checkchatmsg = 0;
			});
			restructureGrpChatBoxes();
	   }else{
		 glovar = 0;
	   }
	}

	function groupname_ajax(group_id,posturl) {
		var jsonResp;
		jsonResp = $.ajax({		 
			url: posturl,
			cache: false,
			data: {'get_group_name':'get_group_name','group_id':group_id},
			async: false,
			dataType: "text"
		  }).responseText;	
		return jsonResp;
	}

	function closeConfirmBox(groupChat,groupid) {
		$("#confirmMessage"+groupid).css("display","none");		
		$("#backgroundChatPopup").fadeOut("slow");
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