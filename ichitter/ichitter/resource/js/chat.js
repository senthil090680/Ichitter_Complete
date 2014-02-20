/*

Copyright (c) 2009 Anant Garg (anantgarg.com | inscripts.com)

This script may be used for non-commercial purposes only. For any
commercial purposes, please contact the author at 
anant.garg@inscripts.com

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.

*/

var windowFocus = true;
var username;
var chatHeartbeatCount = 0;
var chattitlename = '';
var minChatHeartbeat = 1000;
var maxChatHeartbeat = 33000;
var chatHeartbeatTime = minChatHeartbeat;
var originalTitle;
var blinkOrder = 0;

var chatboxFocus = new Array();
var newMessages = new Array();
var newMessagesWin = new Array();
var chatBoxes = new Array();

$(document).ready(function(){
	originalTitle = document.title;
	startChatSession();

	$([window, document]).blur(function(){
		windowFocus = false;
	}).focus(function(){
		windowFocus = true;
		document.title = originalTitle;
	});
	setInterval (chatHeartbeat, 20000);	//RELOAD THIS FUNCTION EVERY 1 SECOND
});



//This function is called after the user clicked the CHAT CONFIRM BUTTON
function confirmChatHeartBeat(one,userid) {
	$("#confirmPrivateMessage"+userid).css('display','none');
	$("#backgroundChatPopup").fadeOut("slow");
	var itemsfound = 0;
	
	if (windowFocus == false) {
 
		var blinkNumber = 0;
		var titleChanged = 0;
		for (x in newMessagesWin) {
			if (newMessagesWin[x] == true) {
				++blinkNumber;
				if (blinkNumber >= blinkOrder) {
					var chattitlename = userid_ajax(x);
					document.title = chattitlename+' says...';
					titleChanged = 1;
					break;	
				}
			}
		}
		
		if (titleChanged == 0) {
			document.title = originalTitle;
			blinkOrder = 0;
		} else {
			++blinkOrder;
		}

	} else {
		for (x in newMessagesWin) {
			newMessagesWin[x] = false;
		}
	}

	for (x in newMessages) {
		if (newMessages[x] == true) {
			if (chatboxFocus[x] == false) {
				//FIXME: add toggle all or none policy, otherwise it looks funny
				$('#chatbox_'+x+' .chatboxhead').toggleClass('chatboxblink');
			}
		}
	}
	
	$.ajax({
	  url: "chat.php?action=confirmchat&chatfrom="+userid,
	  cache: false,
	  dataType: "json",
	  success: function(data) {
		$.each(data.items, function(i,item){
			if (item)	{ // fix strange ie bug

				chatboxtitle = item.f;
				if ($("#chatbox_"+chatboxtitle).length <= 0) {
					createChatBox(chatboxtitle);
				}
				if ($("#chatbox_"+chatboxtitle).css('display') == 'none') {
					$("#chatbox_"+chatboxtitle).css('display','block');
					restructureChatBoxes();
				}
				if (item.s == 1) {
					item.f = username;
				}

				if (item.s == 2) {
					$("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxinfo">'+item.m+'</span></div>');
				} else {
					var chattitlename = userid_ajax(item.f);
					newMessages[chatboxtitle] = true;
					newMessagesWin[chatboxtitle] = true;
					$("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxmessagefrom">'+chattitlename+':&nbsp;&nbsp;</span><span class="chatboxmessagecontent">'+item.m+'</span></div>');
				}

				$("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop($("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);
				itemsfound += 1;
			}
		});

		chatHeartbeatCount++;

		if (itemsfound > 0) {
			chatHeartbeatTime = minChatHeartbeat;
			chatHeartbeatCount = 1;
		} else if (chatHeartbeatCount >= 10) {
			chatHeartbeatTime *= 2;
			chatHeartbeatCount = 1;
			if (chatHeartbeatTime > maxChatHeartbeat) {
				chatHeartbeatTime = maxChatHeartbeat;
			}
		}
		
		//setTimeout('chatHeartbeat();',chatHeartbeatTime);
	}});
}

function restructureChatBoxes() {
	align = 0;
	for (x in chatBoxes) {
		rechatboxtitle = chatBoxes[x];

		if ($("#chatbox_"+rechatboxtitle).css('display') != 'none') {
			if (align == 0) {
			    var commanchat = $("#wrapperChat").css("display");
			  if(commanchat == "none"){			
				$("#chatbox_"+rechatboxtitle).css('right', '20px');
			  }else{
				$("#chatbox_"+rechatboxtitle).css('right', '250px');
			  }	
			} else {
				width = (align)*(225+7)+20;
				  if(commanchat == "none"){			
					$("#chatbox_"+rechatboxtitle).css('right', width+'px');
				  }else{
					width = width+230;
					$("#chatbox_"+rechatboxtitle).css('right', width+'px');
				  }					
			}
			align++;
		}
	}
}

function chatWith(chatuser) {
	createChatBox(chatuser);
	//beforeCreateChatBox(chatuser);
	$("#chatbox_"+chatuser+" .chatboxtextarea").focus();
}

function closePrivateConfirm(abc,userid) {
	$("#backgroundChatPopup").fadeOut("slow");
	$("#confirmPrivateMessage"+userid).css('display','none');
	$.post("chat.php?action=closechat&senderid="+userid, { chatbox : userid} , function(data){	
	});
	//setTimeout('chatHeartbeat();',chatHeartbeatTime);
}

function busyPrivateConfirmBox(abc,userid) {
	$("#confirmPrivateMessage"+userid).css('display','none');
	$("#backgroundChatPopup").fadeOut("slow");
	$.post("chat.php?action=busychat&senderid="+userid, { chatbox : userid} , function(data){	
	});
	//setTimeout('chatHeartbeat();',chatHeartbeatTime);
}

//This function is called when there is a message sent for the user to ask for confirmation
function beforeCreateChatBox(chatuserid) {
	$.post("chat.php?action=beforechatopen", { chatbox: chatuserid} , function(data){	
	});

	var chattitlename = userid_ajax(chatuserid);

	$(".chatbox").css('z-index','');
	$(".wrapperChat").css('z-index','');

	//if($("#confirmPrivateMessage"+chatuserid).length > 0) {
		$(" <div />" ).attr("id","confirmPrivateMessage"+chatuserid)
		.addClass("confirmMessage")
		.html('<div ><p class="closepbox"> <label class="closexbox"><a class="closelink" href="javascript:void(0)" onclick="javascript:return closePrivateConfirm(this,\''+chatuserid+'\');"><b><img src="resource/images/pop-close-small.png" /></b></a></label></p><p style="padding-top:25px;padding-bottom:20px;padding-left:10px; font-size:11px;"><b>'+chattitlename+' is wanting to chat with you</b></p><div style="clear:both"></div></div><div style="display:block;display:inline;padding-left:20px;padding-right:80px;" ><a class="firstlink" href="javascript:void(0)" onclick="javascript:return confirmChatHeartBeat(this,\''+chatuserid+'\');"><img src="resource/images/accept.png" /></a></div>&nbsp;&nbsp;<div style="display:inline;"  ><a class="secondlink" href="javascript:void(0)" onclick="javascript:return busyPrivateConfirmBox(this,\''+chatuserid+'\');"><img src="resource/images/busy.png" /></a><br/><br/></div>').appendTo($( "body" ));
		$("#confirmPrivateMessage"+chatuserid).css("display","block");
		$("#backgroundChatPopup").css({"opacity": "0.7"});
		$("#backgroundChatPopup").fadeIn("slow");
	//}
}

function createChatBox(chatboxtitle,minimizeChatBox) {	
	if ($("#chatbox_"+chatboxtitle).length > 0) {
		if ($("#chatbox_"+chatboxtitle).css('display') == 'none') {
				$("#chatbox_"+chatboxtitle).css('display','block');
			restructureChatBoxes();
		}
		$("#chatbox_"+chatboxtitle+" .chatboxtextarea").focus();
		return;
	}
	
	var chattitlename = userid_ajax(chatboxtitle);
	$(" <div />" ).attr("id","chatbox_"+chatboxtitle)
	.addClass("chatbox")
	.html('<div class="chatboxhead"><div class="chatboxtitle">'+chattitlename+'</div><div class="chatboxoptions"><a href="javascript:void(0)" onclick="javascript:toggleChatBoxGrowth(this,\''+chatboxtitle+'\')"><img class="minicon" src="resource/images/under.png" alt="Min" /></a> <a href="javascript:void(0)" onclick="javascript:closeChatBox(\''+chatboxtitle+'\')">X</a></div><br clear="all"/></div><div class="chatboxcontent"></div><div class="chatboxinput"><textarea class="chatboxtextarea" onkeydown="javascript:return checkChatBoxInputKey(event,this,\''+chatboxtitle+'\');"></textarea></div>')
	.appendTo($( "body" ));
		
	$('.chatboxhead').mouseover(function(){
		$(this).css('cursor','move');
	});

	$('.chatbox').click(function(){
		$(".chatbox").css('z-index','');
		$(".wrapperChat").css('z-index','');
		$(this).css('z-index','999');
		
	});

	$('.chatboxhead').mousedown(function(){
		$(".chatbox").css('z-index','');
		$(".wrapperChat").css('z-index','');
		$(this).parent().css('z-index','999');
		$(this).css('cursor','move');		
		if(!$(this).find('a').hasClass('test')){
			$("#chatbox_"+chatboxtitle).draggable({ "containment": "window" });
		}
	});

	$('.chatboxhead').mouseup(function(){
		$("#chatbox_"+chatboxtitle).draggable( "destroy" );
	});

	//$("#chatbox_"+chatboxtitle).css('height','315px');
	$("#chatbox_"+chatboxtitle).css('bottom','0px');
	
	chatBoxeslength = 0;

	for (x in chatBoxes) {
		if ($("#chatbox_"+chatBoxes[x]).css('display') != 'none') {
			chatBoxeslength++;
		}
	}
	    var commanchat = $("#wrapperChat").css("display");
	if (chatBoxeslength == 0) {

	  if(commanchat == "none"){			
		$("#chatbox_"+chatboxtitle).css('right', '20px');
	  }else{
	    $("#chatbox_"+chatboxtitle).css('right', '250px');
	  }	
	} else {
		width = (chatBoxeslength)*(225+7)+20;	
	  if(commanchat == "none"){			
		$("#chatbox_"+chatboxtitle).css('right', width+'px');
	  }else{
	    width = width+230;
		$("#chatbox_"+chatboxtitle).css('right', width+'px');
	  }	

	}
	
	chatBoxes.push(chatboxtitle);

	if (minimizeChatBox == 1) {
		minimizedChatBoxes = new Array();

		if ($.cookie('chatbox_minimized')) {
			minimizedChatBoxes = $.cookie('chatbox_minimized').split(/\|/);
		}
		minimize = 0;
		for (j=0;j<minimizedChatBoxes.length;j++) {
			if (minimizedChatBoxes[j] == chatboxtitle) {
				minimize = 1;
			}
		}

		if (minimize == 1) {
			$('#chatbox_'+chatboxtitle).css('height','');
			$('#chatbox_'+chatboxtitle+'.chatbox').animate({ bottom: -290 }, 350);
			$('#chatbox_'+chatboxtitle+' .chatboxoptions a:first-child').addClass('test');

			$('#chatbox_'+chatboxtitle+' .chatboxoptions a:first-child').find('.minicon').attr('src','resource/images/max.png');
			//$('#chatbox_'+chatboxtitle+' .chatboxoptions a:first-child').siblings().attr("src","max.png");
			//$('#chatbox_'+chatboxtitle).css('height','');
			/*$('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display','none');
			$('#chatbox_'+chatboxtitle+' .chatboxinput').css('display','none');*/
		}
	}

	chatboxFocus[chatboxtitle] = false;

	$("#chatbox_"+chatboxtitle+" .chatboxtextarea").blur(function(){
		chatboxFocus[chatboxtitle] = false;
		$("#chatbox_"+chatboxtitle+" .chatboxtextarea").removeClass('chatboxtextareaselected');
	}).focus(function(){
		chatboxFocus[chatboxtitle] = true;
		newMessages[chatboxtitle] = false;
		$('#chatbox_'+chatboxtitle+' .chatboxhead').removeClass('chatboxblink');
		$("#chatbox_"+chatboxtitle+" .chatboxtextarea").addClass('chatboxtextareaselected');
	});

	$("#chatbox_"+chatboxtitle).click(function() {
		if ($('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display') != 'none') {
			$("#chatbox_"+chatboxtitle+" .chatboxtextarea").focus();
		}
	});

	$("#chatbox_"+chatboxtitle).css("display","block");
}

function chatHeartbeat(){
	var itemsfound = 0;
	var increate = 0;
	
	if (windowFocus == false) {
 
		var blinkNumber = 0;
		var titleChanged = 0;
		for (x in newMessagesWin) {
			if (newMessagesWin[x] == true) {
				++blinkNumber;
				if (blinkNumber >= blinkOrder) {
					var chattitlename = userid_ajax(x);
					document.title = chattitlename+' says...';
					titleChanged = 1;
					break;	
				}
			}
		}
		
		if (titleChanged == 0) {
			document.title = originalTitle;
			blinkOrder = 0;
		} else {
			++blinkOrder;
		}

	} else {
		for (x in newMessagesWin) {
			newMessagesWin[x] = false;
		}
	}

	for (x in newMessages) {
		if (newMessages[x] == true) {
			if (chatboxFocus[x] == false) {
				//FIXME: add toggle all or none policy, otherwise it looks funny
				$('#chatbox_'+x+' .chatboxhead').toggleClass('chatboxblink');
			}
		}
	}
	$.ajax({
	  url: "chat.php?action=chatheartbeat",
	  cache: false,
	  dataType: "json",
	  success: function(data) {
		  //alert(data);
		$.each(data.items, function(i,item){
			if (item)	{ 
				// fix strange ie bug
				chatboxtitle = item.f;
				if ($("#chatbox_"+chatboxtitle).length <= 0) {
					//createChatBox(chatboxtitle);
					increate = 1;
					beforeCreateChatBox(chatboxtitle);
					return false;
				}
				if ($("#chatbox_"+chatboxtitle).css('display') == 'none') {
						increate = 1;
						beforeCreateChatBox(chatboxtitle);
						return false;
					//$("#chatbox_"+chatboxtitle).css('display','block');
					//restructureChatBoxes();
				}
				
				if (item.s == 1) {
					item.f = username;
				}
					
					if(increate != 1) {
						if (item.s == 2) {
							$("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxinfo">'+item.m+'</span></div>');						
						} else {
							var chattitlename = userid_ajax(item.f);
							newMessages[chatboxtitle] = true;
							newMessagesWin[chatboxtitle] = true;
							$("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxmessagefrom">'+chattitlename+':&nbsp;&nbsp;</span><span class="chatboxmessagecontent">'+item.m+'</span></div>');
						}
					}

				$.ajax({
					url: "chat.php?action=updatechatheartbeat&chatfromperson="+chatboxtitle,
					cache: false,
					dataType: "text",
					success: function(data) {
				}});


				$("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop($("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);
				itemsfound += 1;
			}
		});

		chatHeartbeatCount++;

		if (itemsfound > 0) {
			chatHeartbeatTime = minChatHeartbeat;
			chatHeartbeatCount = 1;
		} else if (chatHeartbeatCount >= 10) {
			chatHeartbeatTime *= 2;
			chatHeartbeatCount = 1;
			if (chatHeartbeatTime > maxChatHeartbeat) {
				chatHeartbeatTime = maxChatHeartbeat;
			}
		}			
		
			//setTimeout('chatHeartbeat();',chatHeartbeatTime);
	}});
}

function closeChatBox(chatboxtitle) {
	$('#chatbox_'+chatboxtitle).css('display','none');
	restructureChatBoxes();

	$.post("chat.php?action=closechat", { chatbox: chatboxtitle} , function(data){	
	});
	//setTimeout('chatHeartbeat();',chatHeartbeatTime);
}

function toggleChatBoxGrowth(whr,chatboxtitle) {	

	/*if($(whr).hasClass('test')){
		$(whr).parents('.chatbox').animate({ "bottom" : "0px" }, 350);
		$(whr).removeClass('test');
	}else{
		$(whr).parents('.chatbox').css( "top","");
		$(whr).parents('.chatbox').animate({ "bottom" : "-290px" }, 350);
		$(whr).addClass('test');
		return false;
	}*/

	//alert($(whr).parents('.chatbox').css('bottom'));
	//$(whr).parents('.chatboxhead').siblings().animate({ bottom: -180 }, 350);
	//alert($(whr).parents('.chatboxhead').siblings().html());
	//alert($(whr).parents('.chatboxhead').siblings().hasClass('.chatboxcontent'));
	
	//if ($('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display') == 'none') {  
	if ($(whr).parents('.chatbox').css('bottom') == '-290px') {  	
			//alert("abc");

		var minimizedChatBoxes = new Array();
		
		if ($.cookie('chatbox_minimized')) {
			minimizedChatBoxes = $.cookie('chatbox_minimized').split(/\|/);
		}

		var newCookie = '';

		for (i=0;i<minimizedChatBoxes.length;i++) {
			if (minimizedChatBoxes[i] != chatboxtitle) {
				newCookie += chatboxtitle+'|';
			}
		}

		newCookie = newCookie.slice(0, -1)


		$.cookie('chatbox_minimized', newCookie);
		//$(whr).html('<b>_</b>');
		$(whr).find('.minicon').attr('src','resource/images/under.png');
		$(whr).removeClass('test');
		$(whr).parents('.chatbox').animate({ "bottom" : "0px" }, 350);
		
		/*$('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display','block');
		$('#chatbox_'+chatboxtitle+' .chatboxinput').css('display','block');		
		$("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop($("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);*/
	} else {
			//alert("def");
		var newCookie = chatboxtitle;

		if ($.cookie('chatbox_minimized')) 
			newCookie += '|'+$.cookie('chatbox_minimized');
								
			$.cookie('chatbox_minimized',newCookie);
			
			//$(whr).siblings().attr("src","max.png");;

			$(whr).find('.minicon').attr('src','resource/images/max.png');
			
			$(whr).parents('.chatbox').css( "top","");
			$(whr).parents('.chatbox').animate({ "bottom" : "-290px" }, 350);
			$(whr).addClass('test');

			//$(whr).parents('.chatbox').unbind("draggable");
			
			/*$('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display','none');
			$('#chatbox_'+chatboxtitle+' .chatboxinput').css('display','none');*/
		}
	
}

function checkChatBoxInputKey(event,chatboxtextarea,chatboxtitle) {
	 
	if(event.keyCode == 13 && event.shiftKey == 0)  {
		message = $(chatboxtextarea).val();
		message = message.replace(/^\s+|\s+$/g,"");

		$(chatboxtextarea).val('');
		$(chatboxtextarea).focus();
		$(chatboxtextarea).css('height','44px');
		if (message != '') {
			var chattitlename = userid_ajax(username);
			$.post("chat.php?action=sendchat", {to: chatboxtitle, message: message} , function(data){
				message = message.replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/\"/g,"&quot;");
				$("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxmessagefrom">'+chattitlename+':&nbsp;&nbsp;</span><span class="chatboxmessagecontent">'+message+'</span></div>');
				$("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop($("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);
			});
		}
		chatHeartbeatTime = minChatHeartbeat;
		chatHeartbeatCount = 1;

		return false;
	}

	var adjustedHeight = chatboxtextarea.clientHeight;
	var maxHeight = 94;

	if (maxHeight > adjustedHeight) {
		adjustedHeight = Math.max(chatboxtextarea.scrollHeight, adjustedHeight);
		if (maxHeight)
			adjustedHeight = Math.min(maxHeight, adjustedHeight);
		if (adjustedHeight > chatboxtextarea.clientHeight)
			$(chatboxtextarea).css('height',adjustedHeight+8 +'px');
	} else {
		$(chatboxtextarea).css('overflow','auto');
	}
	 
}

//start chat
function startChatSession(){  
	$.ajax({
	  url: "chat.php?action=startchatsession",
	  cache: false,
	  dataType: "json",
	  success: function(data) {
		username = data.username;

		$.each(data.items, function(i,item){
			if (item)	{ // fix strange ie bug

				chatboxtitle = item.f;

				if ($("#chatbox_"+chatboxtitle).length <= 0) {
					createChatBox(chatboxtitle,1);
				}
				
				if (item.s == 1) {
					item.f = username;
				}

				if (item.s == 2) {
					$("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxinfo">'+item.m+'</span></div>');
				} else {
					
					var chattitlename = userid_ajax(item.f);							
					$("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxmessagefrom">'+chattitlename+':&nbsp;&nbsp;</span><span class="chatboxmessagecontent">'+item.m+'</span></div>');
				}
			}
		});
		
		for (i=0;i<chatBoxes.length;i++) {
			chatboxtitle = chatBoxes[i];
			$("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop($("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);
			setTimeout('$("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop($("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);', 100); // yet another strange ie bug
		}
	
	//setTimeout('chatHeartbeat();',chatHeartbeatTime);
		
	}});
}

/**
 * Cookie plugin
 *
 * Copyright (c) 2006 Klaus Hartl (stilbuero.de)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 */

jQuery.cookie = function(name, value, options) {
    if (typeof value != 'undefined') { // name and value given, set cookie
        options = options || {};
        if (value === null) {
            value = '';
            options.expires = -1;
        }
        var expires = '';
        if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
            var date;
            if (typeof options.expires == 'number') {
                date = new Date();
                date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
            } else {
                date = options.expires;
            }
            expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
        }
        // CAUTION: Needed to parenthesize options.path and options.domain
        // in the following expressions, otherwise they evaluate to undefined
        // in the packed version for some reason...
        var path = options.path ? '; path=' + (options.path) : '';
        var domain = options.domain ? '; domain=' + (options.domain) : '';
        var secure = options.secure ? '; secure' : '';
        document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
    } else { // only name given, get cookie
        var cookieValue = null;
        if (document.cookie && document.cookie != '') {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = jQuery.trim(cookies[i]);
                // Does this cookie string begin with the name we want?
                if (cookie.substring(0, name.length + 1) == (name + '=')) {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        return cookieValue;
    }
};

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