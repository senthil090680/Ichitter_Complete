function CheckFields() {
	login_name = document.getElementById("username");
	password = document.getElementById("password");
	if ( login_name.value=="") {
		alert( 'Please enter User Name' );
		login_name.focus();
		return false;
	}
	else if (password.value == "") {
		alert('Please enter Password');
		password.focus();
		return false;
	}
	else {
		document.login.action = "validate_login.php";
		document.login.method = "POST";
		document.login.submit();
		return true;
	}
}

function ValidateAddTopicsFields() {
	topicTitle = document.getElementById("topicTitle");
	fileupload = document.getElementById("fileupload");

	if ( topicTitle.value=="") {
		alert( 'Please enter Topic Title' );
		topicTitle.focus();
		return false;
	}
	else if (fileupload.value == "") {
		alert('Please upload any Image File');
		fileupload.focus();
		return false;
	}
	else if(!checkFileExtension(fileupload.value)) {
		alert('Please upload Image File only \n(jpg, jpeg, png, bmp, gif)');
		fileupload.focus();
		return false;
	}
	else {
		document.login.action = "topicsupdate.php?action=addtopics";
		document.login.method = "POST";
		document.login.submit();
		return true;
	}
}

function ValidateAddSubTopicsFields() {
	var objTitle =document.getElementById("TopicTitle");
	topicId = objTitle.options[objTitle.selectedIndex].value;
	topicTitle = document.getElementById("subtopicTitle");
	fileupload = document.getElementById("fileupload");
	if(topicId == 0) {
		alert("Please select Topic Title");
		objTitle.focus();
		return false;
	}
	if ( topicTitle.value=="") {
		alert("Please enter Sub Topic Title");
		topicTitle.focus();
		return false;
	}
	else if (fileupload.value == "") {
		alert('Please upload any Image File');
		fileupload.focus();
		return false;
	}
	else if(!checkFileExtension(fileupload.value)) {
		alert('Please upload Image File only \n(jpg, jpeg, png, bmp, gif)');
		fileupload.focus();
		return false;
	}
	else {
		document.login.action = "subtopicsupdate.php?action=addsubtopics";
		document.login.method = "POST";
		document.login.submit();
		return true;
	}
}

function ValidateEditTopicsFields() {
	topicTitle = document.getElementById("topicTitle");
	fileupload = document.getElementById("fileupload");
      
	if (topicTitle.value=="") {
		alert( 'Please enter Topic Title' );
		topicTitle.focus();
		return false;
	}
	else if (fileupload.value != "") {
		if(!checkFileExtension(fileupload.value)) {
			alert('Please upload Image File only \n(jpg, jpeg, png, bmp, gif)');
			fileupload.focus();
			return false;
		}
	}
	else {
		document.login.action = "topicsupdate.php?action=edittopics";
		document.login.method = "POST";
		document.login.submit();
		return true;
	}
}

function ValidateEditSubTopicsFields() {
	var objTitle =document.getElementById("TopicTitle");
	var topicId = objTitle.options[objTitle.selectedIndex].value;
	var topicTitle = document.getElementById("subtopicTitle");
	var fileupload = document.getElementById("fileupload");
     
	if(topicId == 0) {
		alert("Please select Topic Title");
		objTitle.focus();
		return false;
	}
	if ( topicTitle.value=="") {
		alert( 'Please enter Sub Topics Title' );
		topicTitle.focus();
		return false;
	} 
	else if (fileupload.value != "") {
		if(!checkFileExtension(fileupload.value)) {
			alert('Please upload Image File only \n(jpg, jpeg, png, bmp, gif)');
			fileupload.focus();
			return false;
		}
	}
	else {
		document.login.action = "subtopicsupdate.php?action=edittopics";
		document.login.method = "POST";
		document.login.submit();
		return true;
	}
}

function deletetopics(topicsid) {
	var conf = false;
	if (confirm("Are you sure you want to delete?")) {
		document.frmedittopics.action = "topicsupdate.php?action=delete&topicsid="+topicsid+"";
		document.frmedittopics.method = "POST";
		document.frmedittopics.submit();
		conf = true;
	}
	return conf;
}

function deletesubtopics(subtopicsid)  {
	var conf = false;
	
	if (confirm("Are you sure you want to delete?")) {
		document.frmedittopics.action = "subtopicsupdate.php?action=delete&subtopicsid="+subtopicsid+"";
		document.frmedittopics.method = "POST";
		document.frmedittopics.submit();
		conf = true;
	}
	return conf;
}

function RedirectToPriorityPage() {
	document.frmedittopics.action = "ordertopics.php";
	document.frmedittopics.method = "POST";
	document.frmedittopics.submit();
}

function RedirectTosubTopicsPriorityPage() {
	document.frmedittopics.action = "ordersubtopics.php";
	document.frmedittopics.method = "POST";
	document.frmedittopics.submit();
}

function populateSubTopics(obj) {
	document.frmedittopics.action = "ordersubtopics.php?id=" + obj.value;
	document.frmedittopics.method = "POST";
	document.frmedittopics.submit();
}

function validateChangePasswordFields() {
	var username =document.getElementById("username");
	var password =document.getElementById("oldpassword");
	var newpassword =document.getElementById("newpassword");
	var confirmpassword =document.getElementById("confirmpassword");

	/*if(username.value == "") {
		alert("Please enter user name");
		username.focus();
		return false;
	}*/
	if(password.value == "") {
		alert("Please enter password");
		password.focus();
		return false;
	}
	if(newpassword.value == "") {
		alert("Please enter new password");
		newpassword.focus();
		return false;
	}
	if(confirmpassword.value == "") {
		alert("Please enter confirm password");
		confirmpassword.focus();
		return false;
	}
	else {
		if(newpassword.value != confirmpassword.value) {
			alert("New password and confirm password are same");
			confirmpassword.focus();
			return false;
		}
	}

	document.login.action = "updatepassword.php";
	document.login.method = "POST";
	document.login.submit();
	return true;
}

function resetBackground() {
	$(".product-table").css("background","url(images/login-bg2.jpg) no-repeat");
	$(".product-table").css("width","479px");
	$(".product-table").css("height","315px");

}

function checkFileExtension(fname) {
	var val = fname;
	var arr = val.split(".");
	var alen = arr.length;
	if(arr.length > 2) {
		var ext = arr[alen-1].toLowerCase();
	}
	else {
	var ext = arr[1].toLowerCase();
	}
	if (ext == "jpg" || ext == "png" || ext == "gif" || ext == "bmp" || ext == "jpeg") {
		return true;
	} else {
		return false;
	}
}

function activateUser(uid, dos, obj) {
	$.ajax({  
		type: "POST",  
		url: "userprocess.php",
		data: {'act': 'cngact', 'uid':uid, vals:dos}, 
		async: false,
		dataType: "json",
		cache:false,
		success: function(data){
			if(data.err == '') {
				location.reload();
			} else {
				alert('Error')
			}
		}
	});
}

function viewpostcontent(pid) {
	$.ajax({  
		type: "POST",  
		url: "postingprocess.php",
		data: {'act': 'getcont', 'pid':pid}, 
		async: false,
		dataType: "json",
		cache:false,
		success: function(data){
			if(data.err == '') {
				$('#post-content').html(data.post_content);
			} else {
				alert('Error')
			}
		}
	});
}

function getsubtopics(obj) {
	var tid = obj.value;
	if(tid != 0) {
		var subtopicslist = $.ajax({  
				type: "POST",  
				url: "postingprocess.php",  
				data: {
					'tid' : tid,
					'act' : 'getsubtopicslist'
				}, 
				async: false,
				dataType: "json",
				cache:false
		}).responseText;
		var rs = $.parseJSON(subtopicslist);
		$("#lst_subtopic option").remove();
		$("#lst_subtopic").append('<option value="0">--- SELECT ---</option>');
		$.each(rs, function(idx, dt_subtopic) { 
			$("#lst_subtopic").append('<option value="' + dt_subtopic.sub_topic_id + '">' + dt_subtopic.title + '</option>');
		});
	}
}


function approvepost(pid){
	$.ajax({  
		type: "POST",  
		url: "postingprocess.php",
		data: {'act': 'approve', 'pid':pid}, 
		async: false,
		dataType: "json",
		cache:false,
		success: function(data){
			if(data.err == '') {
				alert("Post approved successfully");
				location.reload(true);
			} else {
				alert('Error : Post approval unsuccessful');
			}
		}
	});
}

function deletepost(pid, cnt){
	var msg = "";
	if(parseInt(cnt) > 0) {
		msg = 'This Post contains Discussions. Are you sure you want to delete this Post?';
	} else {
		msg = 'Are you sure you want to delete this Post?';
	}
	var conf = confirm(msg);
	if(conf) {
		$.ajax({  
			type: "POST",  
			url: "postingprocess.php",
			data: {'act': 'remove', 'pid':pid}, 
			async: false,
			dataType: "json",
			cache:false,
			success: function(data){
				if(data.err == '') {
					alert("Post deleted successfully");
					location.reload(true);
				} else {
					alert('Error : Post delete unsuccessfull');
				}
			}
		});
	}
}

function valSpamFields() {
	var spamword = document.getElementById("spamword");
	if(spamword.value == "") {
		alert("Please enter Spam Word");
		spamword.focus();
		return false;
	}
	
	if(chkSpamWord(spamword.value) == 1) {
		alert("Error: '" + spamword.value + "' is already exists.");
		spamword.focus();
		return false;
	}
	document.frmaddspam.action = "spamprocess.php";
	document.frmaddspam.method = "POST";
	document.frmaddspam.submit();
	return true;
}

function chkSpamWord(spamword){
	var ret = 0;
	var isexists =  $.ajax({
		type: "POST",
		url: "spamprocess.php",
		data: {'act':'isexists', 'spamword':spamword},
		async: false,
		dataType: "json",
		cache:false
	}).responseText;
	var rs = $.parseJSON(isexists);
	if(rs.err == 'err') {
		ret = 1;
	}
	return ret;
}

function delSpamWord(sid){
	var msg = "Are you sure you want to delete this Spam Word?";
	var conf = confirm(msg);
	if(conf) {
		$.ajax({
			type: "POST",
			url: "spamprocess.php",
			data: {'act': 'delspam', 'spamid':sid},
			async: false,
			dataType: "json",
			cache:false,
			success: function(data){
				if(data.err == '') {
					window.location = "spam_list.php?msg=deletespam_success";
				} else {
					window.location = "spam_list.php?msg=deletespam_fail";
				}
			}
		});
	}
}