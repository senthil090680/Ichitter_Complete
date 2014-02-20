$(document).ready(function(){
var service_name = $("#service_name_hidden").val();
var glovar = 0;
	$("#openchat").click(function(){
		$("#wrapperChat").css("display","block");
		restructureChatBoxes();
		glovar = 1; 
		
	});
	$("#exit").click(function(){
		$("#wrapperChat").css("display","none");
		glovar = 0;
	});

	//If user submits the form
	$("#submitmsg").click(function(){
		var clientmsg = $("#usermsg").val();        
        var user_id = $("#user_id_chat").val();
        var group_id = $("#grp_id_chat").val();
      if(clientmsg != "" && user_id != "" && group_id != ""){
	    var posturl = service_name+"chat_service.php";
		$.post(posturl, { chatText: clientmsg, user_id: user_id, group_id: group_id, insertchat: 'insertchat' },
		   function(data) {
		   if(data == '{"response":"success"}'){
		     var uname = $("#udetails_"+user_id).val();
			 $("#chatbox").append('<div class=\'msgln\'><b>'+uname+'</b>: '+clientmsg+'<br></div>');
		   }
		});
      }

		$("#usermsg").attr("value", "");
		return false;
	});

	//Load the file containing the chat log
	function loadLog(){
	 var checkchat = $("#wrapperChat").css("display");
	 //if((checkchat == "block") && (glovar == 1)){
		var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20;
		var user_ids = $("#user_id_chat").val();
		var group_ids = $("#grp_id_chat").val();
		var posturl = service_name+"chat_service.php";

		$.post(posturl, { group_id: group_ids, user_id: user_ids, get_chats: 'get_chats'},
		   function(data) {
			   if(data == 1){
			    data = "";
			   }
				$("#chatbox").html(data); //Insert chat log into the #chatbox div
				if(data != ""){
 		        $("#wrapperChat").css("display","block");
				}else{
				//$("#wrapperChat").css("display","none");
				}	
				var newscrollHeight = $("#chatbox").attr("scrollHeight") - 20;
				if(newscrollHeight > oldscrollHeight){
					$("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
				}
		});
     //}
	}
    function checkincommingchats(){
		var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20;
		var user_ids = $("#user_id_chat").val();
		var group_ids = $("#grp_id_chat").val();
		var posturl = service_name+"chat_service.php";
		$.post(posturl, { group_id: group_ids, user_id: user_ids, get_incomming_chats: 'get_chats'},
		   function(data) {
		       if(data == "success"){
		        $("#wrapperChat").css("display","block");	
				restructureChatBoxes();
				glovar = 1;
			   }else{
		        //$("#wrapperChat").css("display","none");			   
			     glovar = 0;
			   }
		});
	}
	setInterval (checkincommingchats, 3000);	//Reload file every 1 seconds	
	setInterval (loadLog, 1000);	//Reload file every 1 seconds


});