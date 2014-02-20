$(document).ready(function(){
var service_name = $("#service_name_hidden").val();
var get_user_id = $("#user_id_chat").val();
var obj_group_ids = get_group_id_service(get_user_id);
var glovar = 0;
	$("#openchat").click(function(){
		$("#wrapperChat").css("display","block");
		restructureChatBoxes();
		glovar = 1; 
		
	});
	
	$("#exit").click(function(){
		$("#wrapperChat").css("display","none");
		glovar = 0;
		exit;
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

	function eraseCookie(name) {
		createCookie(name,"",-1);
	}

	
	var subgroup_id = readCookie('group_id');
	$("#submitmsg").attr("id", "submitmsg"+subgroup_id);
	//If user submits the form
	$("#submitmsg"+subgroup_id).click(function(){
		var clientmsg = $("#usermsg"+subgroup_id).val();
        var user_id = $("#user_id_chat").val();
        var group_id = readCookie('group_id');
		if(clientmsg != "" && user_id != "" && group_id != ""){
	    var posturl = service_name+"chat_service.php";
		$.post(posturl, { chatText: clientmsg, user_id: user_id, group_id: group_id, insertchat: 'insertchat' },
		   function(data) {
		   if(data == '{"response":"success"}'){
		     var uname = userid_ajax(user_id);
			 $("#chatbox").attr("id", "chatbox"+group_id);
			 $("#chatbox"+group_id).append('<div class=\'msgln\'><b>'+uname+'</b>: '+clientmsg+'<br></div>');
		   }
		});
      }
		$("#usermsg").attr("id", "usermsg"+group_id);
		$("#usermsg"+group_id).attr("value", "");
		return false;
	});

	//Load the file containing the chat log
	function loadLog(){
	 var checkchat = $("#wrapperChat").css("display");
	 //if((checkchat == "block") && (glovar == 1)){
		var user_ids = $("#user_id_chat").val();
		var group_ids = $("#grp_id_chat").val();
		var posturl = "publicchatprocess.php";
		var cookievalue = readCookie('group_id');

		$.each(obj_group_ids, function(i,item){
			var chatgroup_id = item; 

			$.post(posturl, { group_id: chatgroup_id, user_id: user_ids, get_chats: 'get_chats'},
			   function(data) {
				   if(data == 1){
					data = "";
				   }
					if(data != ""){
					
					var cookiearray = cookievalue.split(',');

					$.each(cookiearray, function(cookey,cookval) {						
						if(chatgroup_id != cookval) {
							var cookienew = chatgroup_id;
							createCookie('group_id',cookievalue+','+cookienew,1);
						}
						else { //alert("hello"); 
						}
					});

					$("#wrapperChat").attr("id", "wrapperChat"+chatgroup_id);
					$("#wrapperChat"+chatgroup_id).css("display","block");

					$("#usermsg").attr("id", "usermsg"+chatgroup_id);
					$("#chatbox").attr("id", "chatbox"+chatgroup_id);
					$("#chatbox"+chatgroup_id).css("display","block");
					$("#chatbox"+chatgroup_id).html(data); //Insert chat log into the #chatbox div
					var oldscrollHeight = $("#chatbox"+chatgroup_id).attr("scrollHeight") - 20;		
					
					$("#exit").attr("id", "exit"+chatgroup_id);

					
					$("#wrapperChat"+chatgroup_id).css("height","350px");
					}else{
					//$("#wrapperChat").css("display","none");
					}	
					var newscrollHeight = $("#chatbox"+chatgroup_id).attr("scrollHeight") - 20;
					if(newscrollHeight > oldscrollHeight){
						$("#chatbox"+chatgroup_id).animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
					}
			});
		});
     //}
	}
    function checkincommingchats(){
		var user_ids = $("#user_id_chat").val();
		var group_ids = $("#grp_id_chat").val();
		var posturl = service_name+"chat_service.php";

		$.each(obj_group_ids, function(i,item){
		var chatgroup_id = item; 

			$.post(posturl, { group_id: chatgroup_id, user_id: user_ids, get_incomming_chats: 'get_chats'},
			   function(data) {
				   if(data == "success"){

					$("#wrapperChat").attr("id", "wrapperChat"+chatgroup_id);
					$("#wrapperChat"+chatgroup_id).css("display","block");
					$("#chatbox").attr("id", "#chatbox"+chatgroup_id);
					$("#chatbox"+chatgroup_id).css("display","block");

					var oldscrollHeight = $("#chatbox"+chatgroup_id).attr("scrollHeight") - 20;
					
					$("#exit").attr("id", "exit"+chatgroup_id);

					$("#wrapperChat"+chatgroup_id).css("height","350px");
					$("#grp_id_chat").val() = chatgroup_id;
					restructureChatBoxes();
					glovar = 1;
				   }else{
					//$("#wrapperChat").css("display","none");			   
					 glovar = 0;
				   }
			});
		});
	}
	setInterval (checkincommingchats, 3000);	//Reload file every 1 seconds	
	setInterval (loadLog, 1000);	//Reload file every 1 seconds


	function userid_ajax(recuser_id) {
		var jsonResp;
		jsonResp = $.ajax({		 
			   url: "chat.php",
			   data: {'action':'get_user_name','user_id':recuser_id},		   
			   async: false,
			   dataType: "json"
		  }).responseText;

		var obj = $.parseJSON(jsonResp);	
		return  obj.recusername;
	}

	function get_group_id_service(user_id) {
		var jsonResp_grp = $.ajax({
			   url: service_name+"chat_service.php",
			   data: {'get_group_id':'get_group_id','user_id':user_id},		   
			   async: false,
			   dataType: "json"
		  }).responseText;
		
		var obj_grp = $.parseJSON(jsonResp_grp);
		return obj_grp;
	}


});


