String.prototype.QueryStringToJSON = function () {
	href = this;
	qStr = href.replace(/(.*?\?)/, '');
	qArr = qStr.split('&');
	stack = {};
	for (var i in qArr) {
		var a = qArr[i].split('=');
		var name = a[0], value = isNaN(a[1]) ? a[1] : parseFloat(a[1]);
		if (name.match(/(.*?)\[(.*?)]/)) {
			name = RegExp.$1;
			name2 = RegExp.$2;
			//alert(RegExp.$2)
			if (name2) {
				if (!(name in stack)) {
					stack[name] = {};
				}
				stack[name][name2] = value;
			}else {
				if (!(name in stack)) {
					stack[name] = [];
				}
				stack[name].push(value);
			}
		} else {
			stack[name] = value;
		}
	};
	return stack;
};

function IsEmail(email) {
	//var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	//alert(regex.test(email));
	return regex.test(email);
}
;
//alert(hrf.QueryStringToJSON().toSource());

/*function getQuerystring(key, default_) {
	if (default_==null) default_="";
	key = key.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
	var regex = new RegExp("[\\?&]"+key+"=([^&#]*)");
	var qs = regex.exec(window.location.href);
	if(qs == null)
		return default_;
	else
		return qs[1];
}*/

function RedirectToPriorityPage()
{
  document.frmedittopics.action = "order_topics.php";
  document.frmedittopics.method = "POST";
  document.frmedittopics.submit();
}
function RedirectTosubTopicsPriorityPage()
{
  document.frmedittopics.action = "order_subtopics.php";
  document.frmedittopics.method = "POST";
  document.frmedittopics.submit();
}
function dd_subtopics(obj) {
  document.frmedittopics.action = "order_subtopics.php?id=" + obj.value;
  document.frmedittopics.method = "POST";
  document.frmedittopics.submit();
}

//function collapseText(group){
function collapseText(){
	for(var _i=1;_i <= iCnt;_i++) {
		$("#history" + _i).addClass("collapseText");
		$('#more' + _i + ' img').attr("src","resource/images/more-bt.png");
		$('#edit' + _i + ' img').attr("src","resource/images/edit-bt.png");
		$('#del' + _i + ' img').attr("src","resource/images/delete-bt.png");
	}
	
	$('.morebtn a').click(function(event) {
		var cls = this.id;
		var more = cls.indexOf("more");
		if (more != -1) {
			var id = this.id.replace("more", "");
			var checkExpand = $('#more' + id + ' img').attr("src").indexOf("more-bt.png");
			if(checkExpand == -1){
				$("#history"+ id).removeClass("expandText");
				$("#history"+ id).addClass("collapseText");
				$('#more' + id + ' img').attr("src","resource/images/more-bt.png");
				//$('#edit' + id + ' img').attr('src','resource/images/edit-bt.png');
				//$('#del' + id + ' img').attr('src','resource/images/delete-bt.png');
				 // end;
			} else {
				$("#history"+ id).removeClass("collapseText");
				$("#history"+ id).addClass("expandText");
				$('#more' + id + ' img').attr('src','resource/images/less-bt.png');
				//$('#edit' + id + ' img').attr('src','resource/images/edit-bt.png');
				//$('#del' + id + ' img').attr('src','resource/images/delete-bt.png');
			}
		}
	});
}

var email_count;
$(function() {
	
	var btn = $('.forgotloginButton');
    var bx = $('.forgotloginBox');
    var frm = $('.forgotloginFormarea');
    btn.removeAttr('href');
    btn.mouseup(function(login) {
        bx.toggle();
        btn.toggleClass('active');
    });
    frm.mouseup(function() { 
        return false;
    });
    $(this).mouseup(function(login) {
        if(!($(login.target).parent('.forgotloginButton').length > 0)) {
            btn.removeClass('active');
            bx.hide();
        }
    });
	
	
	var button = $('.loginButton');
	var box = $('.loginBox');
	var form = $('.loginForm');
	button.removeAttr('href');
	button.mouseup(function(login) {
		box.toggle();
		button.toggleClass('active');
	});
	form.mouseup(function() { 
		return false;
	});
	$(this).mouseup(function(login) {
		if(!($(login.target).parent('.loginButton').length > 0)) {
			button.removeClass('active');
			box.hide();
		}
	});
    
	$("#logfrm").submit(function(){
		var ismail = IsEmail(document.logfrm.username.value);
        
		if(ismail) {
			$.ajax({  
				type: "POST",  
				url: "login_process.php",  
				data: $("#logfrm").serialize(),  
				dataType: "json",  
				success: function(msg){
					if(msg.success == "OK") {
						var curPage = $("#curpage").val();
						var params = $("#params").val();
						var redirect_to = curPage + "?" + params;
						window.location.href = redirect_to;
					}
					else if(msg.failure == "OK") {
						$("#loginmsg").html("<span class='logerr'>Invalid Email or Password</span>");
					}
					else if(msg.login_flag == "OK") {
						$("#loginmsg").html("<span class='logerr'>Login failed. Your account is inactive</span>");
					}
				},  
				error: function(){
					$("#loginmsg").html("<span class='logerr'>Invalid Email or Password</span>");
				}
			});
		}
		else {
			$("#loginmsg").html("<span class='logerr'>Invalid Email or Password</span>");
		}  
		//make sure the form doesn't post  
		return false;  
	});
    
	$('#addPost').click(function(event){
		var pg = $("#pg").val();
		window.location.href = "add_post.php?" + QSTRING + "&pg=" + pg;
	});
	
	$('#addnewposts').click(function(event){
		window.location.href = "add_newpost.php";
	});
	
	$('.add_topic').click(function(event){
		alert('add_topic');
		window.showModelessDialog("add_topic.php", window, "...");
	});
	
	$('.add_sub_topic').click(function(event){
		alert('add_sub_topic');
		window.showModelessDialog("add_subtopic.php", window , "...");
	});
	
	$('#markit').click(function(event){
		toggleChecked(true);
	});

	$('#markit').click(function(event){
		var chox = $("input[name='cb_mark[]']");
		for(i=0; i < chox.length; i++) {
			chox[i].checked = true;
		}
		var fields = $("input[name='cb_mark[]']").serializeArray(); 
		if (fields.length == 0) { 
			alert("Please select atleast one Post to mark"); 
			return false;
		}
		$('#frmMarks').attr('method', 'POST');
		$('#frmMarks').submit();
	});
	
	$('.forgot_email').blur(function(){
		var whr = $('#forgot_btn').prev();
		if($.trim($(this).val()) && !IsEmail($(this).val())){
			write_error_msg(whr,'Invalid Email id');
		}else{
			var obj = exist_email_validation($('.forgot_email'));
			var json = $.parseJSON(obj);
			email_count = json.total;
		}
	});

	$('#forgot_btn').click(function(){
		var whr = $('#forgot_btn').prev();
		if($.trim($('.forgot_email').val())){
			if(email_count == 0){
				write_error_msg(whr,'Invalid Email id');
				return false;
			}else{
				$('#forgotlogfrmtxt').submit();
				return true;
			}
		}else{
			write_error_msg(whr,'Please enter Email');
			//whr.find('a').parent().append('<div style="text-align:left;float:left;margin-top:5px" class="error">Invalid Email id</div>');
			return false;
		}
	});
	
	//$('select#srtod').change(function() {});
	ddsmoothmenu.init({
		mainmenuid: "smoothmenu1", //menu DIV id
		orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
		classname: 'ddsmoothmenu', //class added to menu's outer DIV
		contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
	})
});

function write_error_msg(whr,msg,place){
	whr.addClass('error').text(msg);
}

function toggleChecked(status) {
	$(".styled").each( function() {
		$(this).attr("checked", status);
	});
}

function filterBadWords(content) {
	var isbadword;
	if(content != "") {
		isbadword = $.ajax({  
			type: "POST",  
			url: "bw_process.php",  
			data: {'action' : 'checkbw', 'txt' : content}, 
			async: false,
			dataType: "json",
			cache:false
		}).responseText;
	}
	
	var obj = $.parseJSON(isbadword);
	if(obj.msg == '0') {
		return false;
	}else {
		return true;
	}
}

function markPost(elem) {
	//var tsp = $('[name="tsp[]"]'); // $("#tsp");
	var elvalue = elem.value;
	var elv_arr = elvalue.split('_');
	var postid = elv_arr[0];
	var subtopicid = elv_arr[1];
	var topic_id = elv_arr[2];
	//if(topic_id == "") {
	//	topic_id = elv_arr[2];
	//}
	var ischecked = elem.checked;
	$.ajax({  
		type: "POST",  
		url: "mark_process.php",  
		data: {'postid' : postid,'subtopicid': subtopicid, 'topicid' : topic_id, 'action':'markpost', 'ismarked' : ischecked},  
		async: false,
		dataType: "json",  
		cache: false,
		success: function(data){//alert(data.msg); 
		},  
		error: function(){
			//$("#loginmsg").html("<span class='logerr'>Invalid Username or Password</span>");
		}
	});
}

var month = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

function getDatetime(dt) {
	var datentime = dt.split(" ");
	var date = datentime[0];
	var time = datentime[1];
	var dtarray = date.split("-");
	var tiarray = time.split(":");
	var retdate = month[dtarray[1]-1] + " " + dtarray[2] + ", " + dtarray[0];
	var rettime = tiarray[0] + ":" + dtarray[1];
	if(tiarray[0] >= 12) {
		rettime += " PM";
	}else {
		rettime += " AM";
	}
	return retdate + " at " + rettime;
}

function setDiscussionViewed(dd) {
	isViewed = $.ajax({  
		type: "POST",  
		url: "discussion_process.php",  
		data: {
			'dd' : dd
		}, 
		async: false,
		dataType: "json",
		cache:false
	}).responseText;
}

function toggleStatus(anc) {
	var opens = $(anc).html();
	if(opens == "VIEW AND REPLY") {
		if(ud){setDiscussionViewed($(anc).attr('id'));}
		$(anc).html("COLLAPSE");
	}else {
		$(anc).html("VIEW AND REPLY");
	}
}

function edgeDes() {
	$('.inner').corner("round 3px").parent().css('padding', '1px').corner("round 3px");
}

function constructDiscussion(obj, parNode) {
	//var dt = getDatetime(obj.posted_on);
	var did = obj.discussion_id;
	var dt = obj.posted_date;
	var parcls = $(parNode).attr('class');
	
	var boxcls = 'inbox2 btm';
	if(parcls.indexOf('inbox2') != -1) {
		boxcls = 'inbox1 btm';
	}else {
		boxcls = 'inbox2 btm';
	}
	
	var htmltxt = '<div class="curveone" style="width:100%;">';
	htmltxt += '<div class="curveouterone" style="width:100%;">';
	htmltxt += '<div class="inner roundinnerone" style="width:100%;">';
	htmltxt += '<div class="' + boxcls + '" style="width:98%;">';
	htmltxt += '<div class="trigger" id="' + did + '"><div style="float:left;width:98%; clear:right; height:auto;"><div class="disphotos">';
	htmltxt += '<img src="' + obj.image + '" /></div>';
	htmltxt += '<div class="distitle"><a href="#" class="dname">' + obj.uname + ', </a>';
	htmltxt += '<span> ' + dt + '</span></div>';
	htmltxt += '<div class="open disrighttxt">';
	htmltxt += '<p class="discuss">';
	htmltxt += '<a href="javascript: void(0);" id="' + did + '">COLLAPSE</a>';
	htmltxt += '</p>';
	htmltxt += '</div></div>';
	htmltxt += '</div>';
	htmltxt += '<div class="toggle_container">';
	htmltxt += '<div class="block">';
	htmltxt += '<p>' + obj.discussion_content + '</p>';
	htmltxt += '<div class="reply">';
	htmltxt += '<p class="discuss">';
	htmltxt += '<a href="javascript: void(0);" id="' + did + '">REPLY</a>';
	htmltxt += '</p>';
	htmltxt += '</div>';
	htmltxt += '<div class="brk"></div></div>';
	htmltxt += '<span class="span_' + did + '" style="display:none;">';
	htmltxt += '<div class="brk"></div>';
	htmltxt += '<textarea style="width: 95%; height:100px; margin: 0 0 0 8px; resize:none;" name="content_' + did + '" id="content_' + did + '"></textarea>';
	htmltxt += '<div class="brk"></div>';
	htmltxt += '<div class="replycomment"><a href="javascript: void(0);" id="replycomment"></a></div>';
	htmltxt += '</span></div></div>';
	htmltxt += '<div class="brk"></div>';
	htmltxt += '</div></div></div>';
		
	return htmltxt;
}

function replyButton() {
	toggleTrigger();
	$('.reply a').unbind('click');
	$(".reply a").click(function(){
		var spanid = "span_"+ this.id;
		$("." + spanid).show();
		var par = $(this).parent().parent().parent().parent().parent();
		replyDiscussion(this.id, par);
		return false;
	});
}

function toggleTrigger() {
	$(".trigger").unbind('click');
	$(".trigger").click(function(){
		$(".span_" + this.id).hide();
		$(this).toggleClass("active").next().slideToggle("slow");
		var anc = $(this).children().children().children().children();
		toggleStatus(anc);
		return false; //Prevent the browser jump to the link anchor
	});
}

function chkdisc() {
	alert("You must Login to participate in Discussion.");
}

function checks(obj) {
	$(".divdisc").show();
}

function checkFileExtension(fname) {
	var val = fname;
	var arr = val.split(".");
	var extn = new Array("gif", "bmp", "jpeg", "jpg", "png");
	var alen = arr.length;
	var ext = "";
	if(arr.length > 2) {ext = arr[alen-1].toLowerCase();}	else {ext = arr[1].toLowerCase();}
	var retval = $.inArray(ext, extn);
	if(retval == -1) {
		return false;
	}else {
		return true;
	}
}

/*
function ajaxFileUpload() {
	var topicTitle = $("#topicTitle").val();
	var topicDesc = $("#topicDesc").val();
	var userid = $("#userid").val();
	var action = $("#act").val();
	
	$.ajaxFileUpload ({
		url:'topic_process.php',
		secureuri:false,
		fileElementId:'fileupload',
		dataType: 'json',
		data:{"action": action, "topicTitle": topicTitle, 'topicDesc': topicDesc, "userid" : userid},
		cache: false,
		async: false,
		success: function (data, status) {
			//var json = $.parseJSON(data);
			if(typeof(data.error) != 'undefined') {
				if(data.error != '') {
					alert(data.error);
				}else {
					alert(data.msg);
				}
			}
		},
		error: function (data, status, e) {
			alert(e);
		}
	});
	
	return false;
}
*/

function removePosting(pid, cnt, snd) {
	var msg1 = "";
	if(parseInt(cnt) > 0) {
		msg1 = 'This Post contains Discussions. Are you sure you want to delete this Post?';
	} else {
		msg1 = 'Are you sure you want to delete this Post?';
	}
	var conf = confirm(msg1);
	if(conf) {
		
		var resp = $.ajax({  
			type: "POST",  
			url: "posting_process.php",  
			data: {
				'pid' : pid,
				'action' : 'delPost'
			}, 
			async: false,
			dataType: "json",
			cache:false
		}).responseText;
		
		var rs = $.parseJSON(resp);
		
		var loc = window.location;
		var lstr = loc.toString();
		var lmidx = lstr.indexOf("&msg");
		
		if(!snd) {
			if(lmidx != -1){
				var rd2 = lstr.substring(0, lmidx);
				window.location = rd2.toString() + '&msg=' + rs.msg;
			} else{
				var lidx = lstr.indexOf('?');
				if(lidx != -1){
					window.location = window.location + '&msg=' + rs.msg;
				}
				else {
					window.location = window.location + '?msg=' + rs.msg;
				}
			}
		}
		else{
			var q_val = getQuerystring('topicid');
			window.location = 'subtopics.php?topicid=' + q_val + '&msg=' + rs.msg;
		}
	}
}

function getQuerystring(key, default_) {
	if (default_==null) default_=""; 
	key = key.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
	var regex = new RegExp("[\\?&]"+key+"=([^&#]*)");
	var qs = regex.exec(window.location.href);
	if(qs == null)
		return default_;
	else
		return qs[1];
}

function getsubtopics(obj) {
	var tid = obj.value;
	if(tid != 0) {
		var subtopicslist = $.ajax({  
				type: "POST",  
				url: "posting_process.php",  
				data: {
					'tid' : tid,
					'action' : 'getsubtopicslist'
				}, 
				async: false,
				dataType: "json",
				cache:false
		}).responseText;
		var rs = $.parseJSON(subtopicslist);
		$("#" + cbSubTopic + " option").remove();
		$("#" + cbSubTopic).append('<option value="0">---------- Select -----------</option>');
		$.each(rs, function(idx, dt_subtopic) { 
			$("#" + cbSubTopic).append('<option value="' + dt_subtopic.sub_topic_id + '">' + dt_subtopic.subtopic + '</option>');
		});
	}
}

function orderUserTopics(lst) {
	if(lst != undefined) {
		var vals = "action=topicreorder&" + lst; 
		$.ajax({  
			type: "POST",  
			url: "topic_process.php",
			data: vals, 
			async: false,
			dataType: "json",
			cache:false,
			success: function(data){
				if(data.msg == "ok") {
					alert("Topics Order Updated Successfully");
				}
			}
		});
	} else {
		alert("Please rearrange Topics and click");
	}
}

function orderUserSubTopics(lst) {
	if(lst != undefined) {
		var tid = $('#TopicTitle').val();
		var vals = "action=subtopicreorder&tid=" + tid + "&" + lst; 
		$.ajax({  
			type: "POST",  
			url: "subtopic_process.php",
			data: vals, 
			async: false,
			dataType: "json",
			cache:false,
			success: function(data){
				if(data.msg == "ok") {
					alert("Sub Topics Order Updated Successfully");
				}
			}
		});
	} else {
		alert("Please rearrange Sub Topics and click");
	}
}