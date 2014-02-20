function CheckFields(){
	login_name = document.getElementById("username");
	password = document.getElementById("password");
	if (login_name.value==""){
		alert( 'Please enter User Name' );
		login_name.focus();
		return false;
	}
	else if (password.value == ""){
		alert('Please enter Password');
		password.focus();
		return false;
	}
	else{
		document.login.action = "validate_login.php";
		document.login.method = "POST";
		document.login.submit();
		return true;
	}
}

function ValidateAddTopicsFields(){
	topicTitle = document.getElementById("topicTitle");
	fileupload = document.getElementById("fileupload");
	if ( topicTitle.value==""){
		alert( 'Please enter Topic Title' );
		topicTitle.focus();
		return false;
	}
	else if (fileupload.value == ""){
		alert('Please upload any Image File');
		fileupload.focus();
		return false;
	}
	else if(!checkFileExtension(fileupload.value)) {
        	
		alert('Please upload Image File only \n(jpg, jpeg, png, bmp, gif)');
		fileupload.focus();
		return false;
	}
	else{
		document.login.action = "topicsupdate.php?action=addtopics";
		document.login.method = "POST";
		document.login.submit();
		return true;
	}
}

function ValidateAddSubTopicsFields(){
	var objTitle =document.getElementById("TopicTitle");
	topicId = objTitle.options[objTitle.selectedIndex].value;
	topicTitle = document.getElementById("subtopicTitle");
	fileupload = document.getElementById("fileupload");
	if(topicId == 0){
		alert("Please select Topic Title");
		objTitle.focus();
		return false;
	}
	if ( topicTitle.value==""){
		alert("Please enter Sub Topic Title");
		topicTitle.focus();
		return false;
	}
	else if (fileupload.value == ""){
		alert('Please upload any Image File');
		fileupload.focus();
		return false;
	}
	else if(!checkFileExtension(fileupload.value)) {
		alert('Please upload Image File only \n(jpg, jpeg, png, bmp, gif)');
		fileupload.focus();
		return false;
	}
	else{
		document.login.action = "subtopicsupdate.php?action=addsubtopics";
		document.login.method = "POST";
		document.login.submit();
		return true;
	}
}

function ValidateEditTopicsFields(){
	topicTitle = document.getElementById("topicTitle");
	fileupload = document.getElementById("fileupload");
      
	if ( topicTitle.value==""){
		alert( 'Please enter Topic Title' );
		topicTitle.focus();
		return false;
	}
	else if (fileupload.value != ""){
		if(!checkFileExtension(fileupload.value)) {
			alert('Please upload Image File only \n(jpg, jpeg, png, bmp, gif)');
			fileupload.focus();
			return false;
		}
	}
	else{
		document.login.action = "topicsupdate.php?action=edittopics";
		document.login.method = "POST";
		document.login.submit();
		return true;
	}
}

function ValidateEditSubTopicsFields(){
	var objTitle =document.getElementById("TopicTitle");
	topicId = objTitle.options[objTitle.selectedIndex].value;
	topicTitle = document.getElementById("subtopicTitle");
	fileupload = document.getElementById("fileupload");
     
	if(topicId == 0){
		alert("Please select Topic Title");
		objTitle.focus();
		return false;
	}
	if ( topicTitle.value==""){
		alert( 'Please enter Sub Topics Title' );
		topicTitle.focus();
		return false;
	} 
	else if (fileupload.value != ""){
		if(!checkFileExtension(fileupload.value)) {
			alert('Please upload Image File only \n(jpg, jpeg, png, bmp, gif)');
			fileupload.focus();
			return false;
		}
	}
	else{
		document.login.action = "subtopicsupdate.php?action=edittopics";
		document.login.method = "POST";
		document.login.submit();
		return true;
	}
}

function deletetopics(topicsid){
	if (confirm("Are you sure you want to delete?")) {
		document.frmedittopics.action = "topicsupdate.php?action=delete&topicsid="+topicsid+"";
		document.frmedittopics.method = "POST";
		document.frmedittopics.submit();
		return true;
	}else {
		return false;
	}
}

function deletesubtopics(subtopicsid){
	if (confirm("Are you sure you want to delete?")) {
		document.frmedittopics.action = "subtopicsupdate.php?action=delete&subtopicsid="+subtopicsid+"";
		document.frmedittopics.method = "POST";
		document.frmedittopics.submit();
		return true;
	}else {
		return false;
	}
}

function RedirectToPriorityPage(){
	document.frmedittopics.action = "ordertopics.php";
	document.frmedittopics.method = "POST";
	document.frmedittopics.submit();
}

function RedirectTosubTopicsPriorityPage(){
	document.frmedittopics.action = "ordersubtopics.php";
	document.frmedittopics.method = "POST";
	document.frmedittopics.submit();
}

function populateSubTopics(obj){
	document.frmedittopics.action = "ordersubtopics.php?id=" + obj.value;
	document.frmedittopics.method = "POST";
	document.frmedittopics.submit();
}

function validateChangePasswordFields(){
	var username = document.getElementById("username");
	var password = document.getElementById("oldpassword");
	var newpassword = document.getElementById("newpassword");
	var confirmpassword = document.getElementById("confirmpassword");

	/*if(username.value == "")
	{
		alert("Please enter user name");
		username.focus();
		return false;
	}*/
	if(password.value == "")
	{
		alert("Please enter password");
		password.focus();
		return false;
	}
	if(newpassword.value == "")
	{
		alert("Please enter new password");
		newpassword.focus();
		return false;
	}
	if(confirmpassword.value == "")
	{
		alert("Please enter confirm password");
		confirmpassword.focus();
		return false;
	}
	else
	{
		if(newpassword.value != confirmpassword.value)
		{
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
function resetBackground(){
	$(".product-table").css("background","url(images/login-bg2.jpg) no-repeat");
	$(".product-table").css("width","479px");
	$(".product-table").css("height","315px");

}

function checkFileExtension(fname) {
	var val = fname;
	var arr = val.split(".");
	//var arr1 = val.split("\\");
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