/***************************/
//@Author: Adrian "yEnS" Mato Gondelle
//@website: www.yensdesign.com
//@email: yensamg@gmail.com
//@license: Feel free to use it, but keep this credits please!					
/***************************/

//SETTING UP OUR POPUP
//0 means disabled; 1 means enabled;
var popupStatus = 0;

//loading popup with jQuery magic!
function loadPopup(){
	//loads popup only if it is disabled
	if(popupStatus==0){
		$("#backgroundPopup").css({
			"opacity": "0.7"
		});
		$("#backgroundPopup").fadeIn("slow");
		$(".gallerybg").fadeIn("slow");
		//$(".frm-topics").fadeIn("slow");
		//$(".frm-subtopics").fadeIn("slow");
		popupStatus = 1;
	}
}

function loadvdoPopup(){
	//loads popup only if it is disabled
	if(popupStatus==0){
		$("#backgroundPopup").css({
			"opacity": "0.7"
		});
		$("#backgroundPopup").fadeIn("slow");
		$(".videobg").fadeIn("slow");
		popupStatus = 1;
	}
}

function loadTopicPopup(){
	//loads popup only if it is disabled
	if(popupStatus==0){
		$("#backgroundPopup").css({
			"opacity": "0.7"
		});
		$("#backgroundPopup").fadeIn("slow");
		$(".frm-topics").fadeIn("slow");
		popupStatus = 1;
	}
}
function getTopicsList() {
	var tid = $("#topicid").val();
	//alert($('span#selarea').html());
	tot = $.ajax({  
			type: "POST",  
			url: "subtopic_process.php",  
			data: {'action':'gettopicslist', 'tid':tid}, 
			async: false,
			dataType: "json",
			cache:false
		}).responseText;
	$('span#selarea').html("");
	$('span#selarea').html(tot);
	//var obj = $.parseJSON(tot);
	//alert(obj.topic_id);
}
function loadSubtopicPopup(){
	//loads popup only if it is disabled
	if(popupStatus==0){
		$("#backgroundPopup").css({
			"opacity": "0.7"
		});
		getTopicsList();
		$("#backgroundPopup").fadeIn("slow");
		$(".frm-subtopics").fadeIn("slow");
		popupStatus = 1;
	}
}

//disabling popup with jQuery magic!
function disablePopup(){
	//disables popup only if it is enabled
	if(popupStatus==1){
		$("#backgroundPopup").fadeOut("slow");
		//$("#gallerybg").fadeOut("slow");
		$(".gallerybg").fadeOut("slow");
		$(".videobg").fadeOut("slow");
		$(".frm-topics").fadeOut("slow");
		$(".frm-subtopics").fadeOut("slow");
		popupStatus = 0;
	}
}

//centering popup
function centerPopup(){
	//request data for centering
	var windowWidth = document.documentElement.clientWidth;
	var windowHeight = document.documentElement.clientHeight;
	var popupHeight = $(".gallerybg").height();
	var popupWidth = $(".gallerybg").width();
	//centering
	$(".gallerybg").css({
		"position": "absolute",
		"top": windowHeight / 2 - popupHeight / 2,
		"left": windowWidth / 2 - popupWidth / 2
	});
	//only need force for IE6
	
	$("#backgroundPopup").css({
		"height": windowHeight
	});
}

//centering popup
function centerTopicPopup(){
	//request data for centering
	var windowWidth = document.documentElement.clientWidth;
	var windowHeight = document.documentElement.clientHeight;
	var popupHeight = $(".frm-topics").height();
	var popupWidth = $(".frm-topics").width();
	//centering
	$(".frm-topics").css({
		"position": "absolute",
		"top": windowHeight / 2 - popupHeight / 2,
		"left": windowWidth / 2 - popupWidth / 2
	});
	//only need force for IE6
	
	$("#backgroundPopup").css({
		"height": windowHeight
	});
}
//centering popup
function centerSubTopicPopup(){
	//request data for centering
	var windowWidth = document.documentElement.clientWidth;
	var windowHeight = document.documentElement.clientHeight;
	var popupHeight = $(".frm-subtopics").height();
	var popupWidth = $(".frm-subtopics").width();
	//centering
	$(".frm-subtopics").css({
		"position": "absolute",
		"top": windowHeight / 2 - popupHeight / 2,
		"left": windowWidth / 2 - popupWidth / 2
	});
	//only need force for IE6
	
	$("#backgroundPopup").css({
		"height": windowHeight
	});
}

//centering popup
function centervdoPopup(){
	//request data for centering
	var windowWidth = document.documentElement.clientWidth;
	var windowHeight = document.documentElement.clientHeight;
	var popupHeight = $(".gallerybg").height();
	var popupWidth = $(".gallerybg").width();
	//centering
	$(".videobg").css({
		"position": "absolute",
		"top": windowHeight / 2 - popupHeight / 2,
		"left": windowWidth / 2 - popupWidth / 2
	});
	//only need force for IE6
	
	$("#backgroundPopup").css({
		"height": windowHeight
	});
	
}


function setID(imgid, imsrc) {
	$("#rdimg").val(imgid);
	$("#imgSrc").html("<img src='"  + imsrc + "' border='0' alt='' title='' style='width: 200px; border: 2px solid #d4989a;' /><div class='remImg'>Remove</div>");
	$(".slcimg").show();
	$(".slcimg1").show();
	$('.remImg').unbind('click');
	$(".remImg").click(function(){
		$(".slcimg").hide();
		$(".slcimg1").hide();
		$("#rdimg").val("");
	});
	$("#selGrap").show();
	/*$.ajax({  
        type: "POST",  
        url: "services/login_service.php",  
        data: {'image_id' : imgid},  
        dataType: "json",  
        chache : false,
        success: function(msg){
			$("#imgSrc").html("<img src='"  + msg.src + "' border='0' alt='' title='' />");
        },  
        error: function(){
        	$("#imgSrc").html("");
            //$("#imgSrc").html("<span style='color:red;'>Invalid Username or password</span>");
        }
    });*/
	disablePopup();
}


//centering popup
function centertopicPopup(){
	//request data for centering
	var windowWidth = document.documentElement.clientWidth;
	var windowHeight = document.documentElement.clientHeight;
	var popupHeight = $(".frm-topics").height();
	var popupWidth = $(".frm-topics").width();
	//centering
	$(".frm-topics").css({
		"position": "absolute",
		"top": windowHeight / 2 - popupHeight / 2,
		"left": windowWidth / 2 - popupWidth / 2
	});
	//only need force for IE6
	
	$("#backgroundPopup").css({
		"height": windowHeight
	});
	
}

$(function() {
	//LOADING POPUP
	//Click the button event!
	$("#imgGal1").click(function(){
		//centering with css
		centerPopup();
		//load popup
		loadPopup();
	});
	
	$("#vdoGal1").click(function(){
		//centering with css
		centervdoPopup();
		//load popup
		loadvdoPopup();
	});
	
	$("#frm-topics").click(function(){
		//centering with css
		centertopicPopup();
		//load popup
		loadTopicPopup();
	});
	
	$("#frm-subtopics").click(function(){
		//centering with css
		centerSubTopicPopup();
		//load popup
		loadSubtopicPopup();
	});
	
	/*
	$("#imgGal").click(function(){
		//centering with css
		centerPopup();
		//load popup
		loadPopup();
	});
	
	$("#vdoGal").click(function(){
		//centering with css
		centervdoPopup();
		//load popup
		loadvdoPopup();
	});
	*/			
	//CLOSING POPUP
	//Click the x event!
	$(".galleryClose").click(function(){
		disablePopup();
	});
	
	$(".btn-close").click(function(){
		disablePopup();
	});
	//Click out event!
	$("#backgroundPopup").click(function(){
		//disablePopup();
		});
});
//Press Escape event!
$(document).keypress(function(e){
	if(e.keyCode==27 && popupStatus==1){
		disablePopup();
	}
});
