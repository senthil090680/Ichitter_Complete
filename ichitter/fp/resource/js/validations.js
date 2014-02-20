// JavaScript Document
//Intenational Phone Validation
// Declaring required variables
var digits = "0123456789";
// non-digit characters which are allowed in phone numbers
var phoneNumberDelimiters = "()- ";
// characters which are allowed in international phone numbers
// (a leading + is OK)
var validWorldPhoneChars = phoneNumberDelimiters + "+";
// Minimum no of digits in an international phone no.
var minDigitsInIPhoneNumber = 10;
function isInteger(s) {
	var i;
	for (i = 0; i < s.length; i++) {
		// Check that current character is number.
		var c = s.charAt(i);
		if (((c < "0") || (c > "9"))) return false;
	}
	// All characters are numbers.
	return true;
}

function ischar(svalue) {
	var checkOK = "abcdefghijklmnopqrstuvwxyz ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	var checkStr = svalue;
	//var allValid = true;
	//var decPoints = 0;
	var allNum = "";

	for (i = 0;  i < checkStr.length;  i++) {
		ch = checkStr.charAt(i);
		for (j = 0;  j < checkOK.length;  j++)
			if (ch == checkOK.charAt(j))
				break;
		if (j == checkOK.length) {
			//alert(msg);
			//eval("document."+frmpage+"."+ctrlname+"."+"focus();")
			return false;
			break;
		}
		allNum += ch;
	}
}

function stripCharsInBag(s, bag) {
	var i;
	var returnString = "";
	// Search through string's characters one by one.
	// If character is not in bag, append to returnString.
	for (i = 0; i < s.length; i++) {
		// Check that current character isn't whitespace.
		var c = s.charAt(i);
		if (bag.indexOf(c) == -1) returnString += c;
	}
	return returnString;
}

function checkInternationalPhone(strPhone){
	s=stripCharsInBag(strPhone,validWorldPhoneChars);
	return (isInteger(s) && s.length >= minDigitsInIPhoneNumber);
}

//International phone number validation
/////////Url validation

function checkUrl(theUrl) {
	if(theUrl.value.match(/^w+([\.\-]\w+)*\.\w{2,4}(\:\d+)*([\/\.\-\?\&\%\#]\w+)*\/?$/i) ||
		theUrl.value.match(/^mailto\:\w+([\.\-]\w+)*\@\w+([\.\-]\w+)*\.\w{2,4}$/i))
		{

		return true;
	} else {

		return false;
	}
}

//////////URL validation

function trim(s) {
	while (s.substring(0,1) == ' ') {
		s = s.substring(1,s.length);
	}
	while (s.substring(s.length-1,s.length) == ' ') {
		s = s.substring(0,s.length-1);
	}
	return s;
}

function isEmail(email) {
	invalidChars = " ~\'^\`\"*+=\\|][(){}$&!#%/:,;";
	// Check for invalid characters as defined above
	for (i=0; i<invalidChars.length; i++) {
		badChar = invalidChars.charAt(i);
		if (email.indexOf(badChar,0) > -1) {
			return false;
		}
	}
	lengthOfEmail = email.length;
	if ((email.charAt(lengthOfEmail - 1) == ".") || (email.charAt(lengthOfEmail - 2) == ".")) {
		return false;
	}
	Pos = email.indexOf("@",1);
	if (email.charAt(Pos + 1) == ".") {
		return false;
	}
	while ((Pos < lengthOfEmail) && ( Pos != -1)) {
		Pos = email.indexOf(".",Pos);
		if (email.charAt(Pos + 1) == ".") {
			return false;
		}
		if (Pos != -1) {
			Pos++;
		}
	}
	// There must be at least one @ symbol
	atPos = email.indexOf("@",1);
	if (atPos == -1) {
		return false;
	}
	// But only ONE @ symbol
	if (email.indexOf("@",atPos+1) != -1) {
		return false;
	}
	// Also check for at least one period after the @ symbol
	periodPos = email.indexOf(".",atPos);
	if (periodPos == -1) {
		return false;
	}
	if (periodPos+3 > email.length) {
		return false;
	}
	return true;
}

function alphaNumeric(sText) {
	var ValidChars = "1234567890";
	var IsNumber=true;
	var Char;
	for (i = 0; i < sText.length && IsNumber == true; i++) {
		Char = sText.charAt(i);
		if (ValidChars.indexOf(Char) == -1) {
			IsNumber = false;
		}
	}
	return IsNumber;
}

function IsNumeric(sText) {
	var ValidChars = "0123456789";
	var IsNumber=true;
	var Char;
	for (i = 0; i < sText.length && IsNumber == true; i++) {
		Char = sText.charAt(i);
		if (ValidChars.indexOf(Char) == -1) {
			IsNumber = false;
		}
	}
	return IsNumber;
}

function IsNumericPhone(sText) {
	var ValidChars = "0123456789-";
	var IsNumber=true;
	var Char;
	for (i = 0; i < sText.length && IsNumber == true; i++) {
		Char = sText.charAt(i);
		if (ValidChars.indexOf(Char) == -1) {
			IsNumber = false;
		}
	}
	return IsNumber;
}


function isEmailAddr(email) {
	var oRegExp = /^[a-zA-Z][\w\.-]*[a-zA-Z0-9]@[a-zA-Z0-9][\w\.-]*[a-zA-Z0-9]\.[a-zA-Z][a-zA-Z\.]*[a-zA-Z]$/g;
	if (oRegExp.test(tri(email))) {
		return true;
	}
	else {
		return false;
	}
}

function validate_login() {
	var msg = "";
	var focus = "";

	if((document.getElementById("username").value) == "") {
		msg = "Email\n" + msg;
		focus = "username";
	}
	if((document.getElementById("password").value) == "") {
		msg = "Password\n" + msg;
		focus = "password";
	}
	if(focus != "") {
		msg = "Please enter the following\n\n" + msg;
		alert(msg);
		document.getElementById(focus).focus();
		return false;
	}
	else {
		document.login.action = "login_check.php";
		document.login.method = "POST";
		document.login.submit();
		return true;
	}
}

function validate_newsletter() {
	var msg = "";
	var focus = "";
	if((document.getElementById("txtyouremail").value) == "" || (document.getElementById("txtyouremail").value) == "Your Email") {
		msg = "Your Email\n" + msg;
		focus = "txtyouremail";
	}
	else
	{
		if(!isEmail((document.getElementById("txtyouremail").value)) && (document.getElementById("txtyouremail").value) != "Your Email") {
			msg = "Invalid Email \n" + msg;
			focus = "txtyouremail";
		}
	}
	if(focus != "") {
		msg = "Please enter the following\n\n" + msg;
		alert(msg);
		document.getElementById(focus).focus();
		return false;
	}
	else {
		document.frmindex.action = "newsletterupdate.php?action=addnewsletter";
		document.frmindex.method = "POST";
		document.frmindex.submit();
		return true;
	}
}

function forgotPassword() {
	if((document.getElementById("username").value) == "") {
		alert("Please enter Email and Click 'Forgot Password'");
		document.getElementById("username").focus();
		return false;
	}
	else {
		document.login.action = "login_check.php?action=forgot_pass";
		document.login.method = "POST";
		document.login.submit();
		return true;
	}
}

function validate_password() {
	var msg = "";
	var focus = "";

	if((document.getElementById("txtNewPassword2").value) == "") {
		msg = "Re-Enter New password\n" + msg;
		focus = "txtNewPassword2";
	}
	else {
		if((document.getElementById("txtNewPassword").value) != (document.getElementById("txtNewPassword2").value))
		{
			msg = "New Password and Re-Enter New Password mismatch!\n" + msg;
			focus = "txtNewPassword2";
		}
	}
	if((document.getElementById("txtNewPassword").value) == "") {
		msg = "New password\n" + msg;
		focus = "txtNewPassword";
	}
	if((document.getElementById("txtOldPassword").value) == "") {
		msg = "Old password\n" + msg;
		focus = "txtOldPassword";
	}

	if(focus != "") {
		msg = "Please enter the following\n\n" + msg;
		alert(msg);
		document.getElementById(focus).focus();
		return false;
	}
	else {
		return true;
	}
}

function openKLOK1170() {
	var w = 590;
	var h = 570;
	var LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
	var TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
	var settings = 'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars=no,resizable=yes,status=no';
	win = window.open('popup.html','PravasvaniOnAir',settings);
	win.focus();
}

function openeventPopup(winPopup) {
	var w = 800;
	var h = 640;
	var LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
	var TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
	var settings = 'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars=yes,resizable=yes,status=no';
	win = window.open(winPopup,'Pravasvani',settings);
	win.focus();
}

function programPopup(prgName,titleText) {
	var w = 410;
	var h = 360;
	var LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
	var TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
	var settings = 'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars=no,resizable=yes,status=no';
	win = window.open('programPopup.php?title='+prgName+'&desc='+titleText,'Pravasvani',settings);
	win.focus();
}

function validate_banner(option) {
	var msg = "";
	var focus = "";
	if((document.getElementById("txtlink").value) != "") {
		if(!checkLink(document.getElementById("txtlink").value)) {
			msg = "Invalid Buzz Link\n" + msg;
			focus = "txtlink";
		}
	}
	if((document.getElementById("fileupload").value) == "" && option == "0") {
		msg = "Buzz Image\n" + msg;
		focus = "fileupload";
	}
	if((document.getElementById("txtdescription").value) == "") {
		msg = "Description\n" + msg;
		focus = "txtdescription";
	}
	if((document.getElementById("txttitle").value) == "") {
		msg = "Title\n" + msg;
		focus = "txttitle";
	}

	if(focus != "") {
		msg = "Please enter the following\n\n" + msg;
		alert(msg);
		document.getElementById(focus).focus();
		return false;
	}
	else {
		if((document.getElementById("fileupload").value) != "") {
			var file = document.getElementById("fileupload").value;
			extArray = new Array(".gif", ".jpg", ".png", ".jpeg");
			allowSubmit = false;
			while (file.indexOf("\\") != -1) {
				file = file.slice(file.indexOf("\\") + 1);
				ext = file.slice(file.indexOf(".")).toLowerCase();
				for (var i = 0; i < extArray.length; i++) {
					if (extArray[i] == ext) {
						allowSubmit = true;
						break;
					}
				}
			}
			if (allowSubmit) {
				return true;
			}
			else {
				msg = "Invalid File. Accept only(.gif,.jpg,.png,.jpeg) file type.\n" + msg;
				focus = "fileupload";
				alert(msg);
				document.getElementById(focus).focus();
				return false;
			}
		}
	}
}

function checkLink(theUrl) {
	var regexp = /http:\/\/[A-Za-z0-9\.-]{3,}\.[A-Za-z]{3}/;
	return regexp.test(theUrl);
}

function deletebanner(bannerid) {
	if (confirm("Are you sure to delete?")) {
		document.frmbannerlist.action = "bannerUpdate.php?action=delete&bannerid="+bannerid+"";
		document.frmbannerlist.method = "POST";
		document.frmbannerlist.submit();
		return true;
	}
}
function validate_ourrjs(option) {
	var msg = "";
	var focus = "";

	if((document.getElementById("txtachivements").value) == "") {
		msg = "Achievements & Specialty\n" + msg;
		focus = "txtachivements";
	}

	if((document.getElementById("txtrjstyle").value) == "") {
		msg = "RJ-ing Style\n" + msg;
		focus = "txtrjstyle";
	}


	if((document.getElementById("txtcurrentposition").value) == "") {
		msg = "Current Position\n" + msg;
		focus = "txtcurrentposition";
	}
	if((document.getElementById("fileupload").value) == "" && option == "0") {
		msg = "RJ's Photo\n" + msg;
		focus = "fileupload";
	}
	if((document.getElementById("txtrjfirstname").value) == "") {
		msg = "RJ's First Name\n" + msg;
		focus = "txtrjfirstname";
	}
	if(focus != "") {
		msg = "Please enter the following\n\n" + msg;
		alert(msg);
		document.getElementById(focus).focus();
		return false;
	}
	else {
		if((document.getElementById("fileupload").value) != "") {
			var file = document.getElementById("fileupload").value;
			extArray = new Array(".gif", ".jpg", ".png", ".jpeg");
			allowSubmit = false;
			while (file.indexOf("\\") != -1) {
				file = file.slice(file.indexOf("\\") + 1);
				ext = file.slice(file.indexOf(".")).toLowerCase();
				for (var i = 0; i < extArray.length; i++) {
					if (extArray[i] == ext)
					{
						allowSubmit = true;
						break;
					}
				}
			}
			if (allowSubmit) {
				return true;
			}
			else {
				msg = "Invalid File. Accept only(.gif,.jpg,.png,.jpeg) file type.\n" + msg;
				focus = "fileupload";
				alert(msg);
				document.getElementById(focus).focus();
				return false;
			}

		}

	}
}

function deleteourrjs(rjsid) {
	if (confirm("Are you sure to delete?")) {
		document.frmourrjslist.action = "ourrjsUpdate.php?action=delete&rjsid="+rjsid+"";
		document.frmourrjslist.method = "POST";
		document.frmourrjslist.submit();
		return true;
	}
}

function updaterjsorder(cnt) {
	document.frmourrjslist.action = "ourrjsUpdate.php?action=updateorder&cnt="+cnt+"";
	document.frmourrjslist.method = "POST";
	document.frmourrjslist.submit();
	return true;
}

function deletenewsletter(nid) {
	if (confirm("Are you sure to delete?")) {
		document.frmnewsletterlist.action = "newsletterlist.php?action=delete&nid="+nid+"";
		document.frmnewsletterlist.method = "POST";
		document.frmnewsletterlist.submit();
		return true;
	}
}

function validate_programschedule(option) {
	var msg = "";
	var focus = "";
	if((document.getElementById("fileupload").value) == "" && option == "0") {
		msg = "Program Image\n" + msg;
		focus = "fileupload";
	}
	if((document.getElementById("txtcontent").value) == "") {
		msg = "Content\n" + msg;
		focus = "txtcontent";
	}
	if((document.getElementById("txtemail").value) == "") {
		msg = "Email\n" + msg;
		focus = "txtemail";
	}
	else {
		if(!isEmail((document.getElementById("txtemail").value))) {
			msg = "Invalid Email \n" + msg;
			focus = "txtemail";
		}
	}
	if((document.getElementById("txtshowtime").value) == "") {
		msg = "Show Time\n" + msg;
		focus = "txtshowtime";

	}
	if((document.getElementById("txtshowdays").value) == "") {
		msg = "Show Days\n" + msg;
		focus = "txtshowdays";

	}

	if((document.getElementById("txtrjname").value) == "") {
		msg = "RJ Name\n" + msg;
		focus = "txtrjname";

	}
	if((document.getElementById("txtprogramname").value) == "") {
		msg = "Program Name\n" + msg;
		focus = "txtprogramname";

	}
	if(focus != "") {
		msg = "Please enter the following\n\n" + msg;
		alert(msg);
		document.getElementById(focus).focus();
		return false;
	}
	else {
		if((document.getElementById("fileupload").value) != "") {
			var file = document.getElementById("fileupload").value;
			extArray = new Array(".gif", ".jpg", ".png", ".jpeg");
			allowSubmit = false;
			while (file.indexOf("\\") != -1) {
				file = file.slice(file.indexOf("\\") + 1);
				ext = file.slice(file.indexOf(".")).toLowerCase();
				for (var i = 0; i < extArray.length; i++) {
					if (extArray[i] == ext) {
						allowSubmit = true;
						break;
					}
				}
			}
			if (allowSubmit) {
				return true;
			}
			else {
				msg = "Invalid File. Accept only(.gif,.jpg,.png,.jpeg) file type.\n" + msg;
				focus = "fileupload";
				alert(msg);
				document.getElementById(focus).focus();
				return false;
			}
		}
	}
}

function deleteprogramschedule(programid) {
	if (confirm("Are you sure to delete?")) {
		document.frmprogramlist.action = "programupdate.php?action=delete&programid="+programid+"";
		document.frmprogramlist.method = "POST";
		document.frmprogramlist.submit();
		return true;
	}
}

function updateprogramorder(cnt) {
	document.frmprogramlist.action = "programupdate.php?action=updateorder&cnt="+cnt+"";
	document.frmprogramlist.method = "POST";
	document.frmprogramlist.submit();
	return true;
}

function validatecontestanswer() {
	var cnt = 0;
	var cnt1 = 0;

	var msg = "";
	var focus = "";

	var rdoanswers = document.getElementsByName("rdoanswer");
	var rdogenders = document.getElementsByName("rdogender");

	for (var i = 0; i < rdoanswers.length; i ++) {
		if (rdoanswers[i].checked) {
			cnt = cnt + 1;
		}
	}
	for (var i = 0; i < rdogenders.length; i ++) {
		if (rdogenders[i].checked) {
			cnt1 = cnt1 + 1;
		}
	}
	if((document.getElementById("txtdob").value) == "") {
		msg = "Date of Birth\n" + msg;
		focus = "txtdob";
	}
	if(cnt1 == 0) {
		msg = "Select Gender\n" + msg;
	}

	if((document.getElementById("txtemail").value) == "") {
		msg = "Email\n" + msg;
		focus = "txtemail";
	}
	else {
		if(!isEmail((document.getElementById("txtemail").value))) {
			msg = "Invalid Email \n" + msg;
			focus = "txtemail";
		}
	}
	if((document.getElementById("txtname").value) == "") {
		msg = "Name\n" + msg;
		focus = "txtname";
	}
	if(cnt == 0) {
		msg = "Select Answer\n" + msg;
	}
	if(focus != "") {
		msg = "Please enter the following\n\n" + msg;
		alert(msg);
		document.getElementById(focus).focus();
		return false;
	}
	else {
		document.frmcontest.action = "contestupdate.php";
		document.frmcontest.method = "POST";
		document.frmcontest.submit();
		return true;
	}
}

function validate_contest(option) {
	var msg = "";
	var focus = "";
	if((document.getElementById("fileupload").value) == "" && option == "0") {
		msg = "Contest Image\n" + msg;
		focus = "fileupload";
	}
	if((document.getElementById("ddlanswer").value) == "0") {
		msg = "Select Answer\n" + msg;
		focus = "ddlanswer";
	}

	if((document.getElementById("txtoption4").value) == "") {
		msg = "Answer - 4\n" + msg;
		focus = "txtoption4";
	}
	if((document.getElementById("txtoption3").value) == "") {
		msg = "Answer - 3\n" + msg;
		focus = "txtoption3";
	}
	if((document.getElementById("txtoption2").value) == "") {
		msg = "Answer - 2\n" + msg;
		focus = "txtoption2";
	}
	if((document.getElementById("txtoption1").value) == "") {
		msg = "Answer - 1\n" + msg;
		focus = "txtoption1";
	}
	if((document.getElementById("txtquestionname").value) == "") {
		msg = "Question Name\n" + msg;
		focus = "txtquestionname";
	}

	if(focus != "") {
		msg = "Please enter the following\n\n" + msg;
		alert(msg);
		document.getElementById(focus).focus();
		return false;
	}
	else {
		if((document.getElementById("fileupload").value) != "") {
			var file = document.getElementById("fileupload").value;
			extArray = new Array(".gif", ".jpg", ".png", ".jpeg");
			allowSubmit = false;
			while (file.indexOf("\\") != -1) {
				file = file.slice(file.indexOf("\\") + 1);
				ext = file.slice(file.indexOf(".")).toLowerCase();
				for (var i = 0; i < extArray.length; i++) {
					if (extArray[i] == ext) {
						allowSubmit = true;
						break;
					}
				}
			}
			if (allowSubmit) {
				return true;
			}
			else {
				msg = "Invalid File. Accept only(.gif,.jpg,.png,.jpeg) file type.\n" + msg;
				focus = "fileupload";
				alert(msg);
				document.getElementById(focus).focus();
				return false;
			}
		}
	}
}

function deletecontest(contestid){
	if (confirm("Are you sure to delete?")) {
		document.frmcontestlist.action = "updatecontest.php?action=delete&contestid="+contestid+"";
		document.frmcontestlist.method = "POST";
		document.frmcontestlist.submit();
		return true;
	}
}

function validate_events() {
	var msg = "";
	var focus = "";
	if((document.getElementById("ddlentryfee").value) == "B") {
		if((document.getElementById("txtprice").value) == "") {
			msg = "Entry Fee\n" + msg;
			focus = "txtprice";
		}
	}
	if((document.getElementById("ddlentryfee").value) == "0") {
		msg = "Select Fee Option\n" + msg;
		focus = "ddlentryfee";
	}

	if((document.getElementById("txtcontactinformation").value) == "") {
		msg = "Contact Information\n" + msg;
		focus = "txtcontactinformation";
	}
	if((document.getElementById("txteventstate").value) == "") {
		msg = "State\n" + msg;
		focus = "txteventstate";
	}
	if((document.getElementById("txteventcity").value) == "") {
		msg = "City\n" + msg;
		focus = "txteventcity";
	}
	if((document.getElementById("txteventaddress").value) == "") {
		msg = "Address\n" + msg;
		focus = "txteventaddress";
	}
	if((document.getElementById("txteventcontent").value) == "") {
		msg = "Event Content\n" + msg;
		focus = "txteventcontent";
	}
	if((document.getElementById("txteventdate").value) == ""){
		msg = "Event Date\n" + msg;
		focus = "txteventdate";
	}
	if((document.getElementById("txteventname").value) == ""){
		msg = "Event Name\n" + msg;
		focus = "txteventname";
	}
	if(focus != ""){
		msg = "Please enter the following\n\n" + msg;
		alert(msg);
		document.getElementById(focus).focus();
		return false;
	}
	else {
		return true;
	}
}

function displayprice() {
	if((document.getElementById("ddlentryfee").value) == "0" || (document.getElementById("ddlentryfee").value) == "F"){
		document.getElementById("txtprice").style.display='none';
	}
	if((document.getElementById("ddlentryfee").value) == "B") {
		document.getElementById("txtprice").style.display='';
	}
}

function deleteevent(eventid) {
	if (confirm("Are you sure to delete?")) {
		document.frmeventlist.action = "updateevent.php?action=delete&eventid="+eventid+"";
		document.frmeventlist.method = "POST";
		document.frmeventlist.submit();
		return true;
	}
}

function deletecontestanswer(answerid) {
	if (confirm("Are you sure to delete?")) {
		document.frmcontestanswerlist.action = "updatecontest.php?action=deleteanswer&answerid="+answerid+"";
		document.frmcontestanswerlist.method = "POST";
		document.frmcontestanswerlist.submit();
		return true;
	}
}

function deleteadvertiser(advertiserid) {
	if (confirm("Are you sure to delete?")) {
		document.frmaddlist.action = "advertiserrequestlist.php?action=deleteadd&advertiserid="+advertiserid+"";
		document.frmaddlist.method = "POST";
		document.frmaddlist.submit();
		return true;
	}
}

function deletesongs(songid) {
	if (confirm("Are you sure to delete?")) {
		document.frmsonglist.action = "songrequestlist.php?action=deletesong&songid="+songid+"";
		document.frmsonglist.method = "POST";
		document.frmsonglist.submit();
		return true;
	}
}

function validate_changepassword() {
	var msg = "";
	var focus = "";

	if((document.getElementById("txtconfirmpassword").value) == "") {
		msg = "Confirm Password\n" + msg;
		focus = "txtconfirmpassword";
	}
	if((document.getElementById("txtnewpassword").value) == "") {
		msg = "New Password\n" + msg;
		focus = "txtnewpassword";
	}
	if((document.getElementById("txtoldpassword").value) == "") {
		msg = "Old Password\n" + msg;
		focus = "txtoldpassword";
	}
	if((document.getElementById("txtnewpassword").value) != (document.getElementById("txtoldpassword").value)) {
		msg = "New Password and Confirm Password should be same\n" + msg;
		focus = "txtnewpassword";
	}
	if(focus != "") {
		msg = "Please enter the following\n\n" + msg;
		alert(msg);
		document.getElementById(focus).focus();
		return false;
	}
	else {
		return true;
	}
}

function exporttoexcel() {	
	document.frmnewsletterlist.action = "newsletterlist.php?action=export";
	document.frmnewsletterlist.method = "POST";
	document.frmnewsletterlist.submit();
	return true;
}

function validate_sponsor(option) {
	var msg = "";
	var focus = "";
	if((document.getElementById("txtlink").value) != "") {
		if(!checkLink(document.getElementById("txtlink").value)) {
			msg = "Invalid Sponsor Link\n" + msg;
			focus = "txtlink";
		}
	}
	if((document.getElementById("fileupload").value) == "" && option == "0") {
		msg = "Sponsor Image\n" + msg;
		focus = "fileupload";
	}

	if(focus != "") {
		msg = "Please enter the following\n\n" + msg;
		alert(msg);
		document.getElementById(focus).focus();
		return false;
	}
	else {
		if((document.getElementById("fileupload").value) != "") {
			var file = document.getElementById("fileupload").value;
			extArray = new Array(".gif", ".jpg", ".png", ".jpeg");
			allowSubmit = false;
			while (file.indexOf("\\") != -1) {
				file = file.slice(file.indexOf("\\") + 1);
				ext = file.slice(file.indexOf(".")).toLowerCase();
				for (var i = 0; i < extArray.length; i++) {
					if (extArray[i] == ext) {
						allowSubmit = true;
						break;
					}
				}
			}
			if (allowSubmit) {
				return true;
			}
			else {
				msg = "Invalid File. Accept only(.gif,.jpg,.png,.jpeg) file type.\n" + msg;
				focus = "fileupload";
				alert(msg);
				document.getElementById(focus).focus();
				return false;
			}
		}
	}
}

/*
function checkLink(theUrl) {
	var regexp = /http:\/\/[A-Za-z0-9\.-]{3,}\.[A-Za-z]{3}/;
	return regexp.test(theUrl);
}
*/

function deletesponsor(sponsorid) {
	if (confirm("Are you sure to delete?")) {
		document.frmsponsorslist.action = "sponsorUpdate.php?action=delete&sponsorid="+sponsorid+"";
		document.frmsponsorslist.method = "POST";
		document.frmsponsorslist.submit();
		return true;
	}
}

function validate_careers(option) {
	var msg = "";
	var focus = "";
	if((document.getElementById("txtdescription").value) == "") {
		msg = "Job Description\n" + msg;
		focus = "txtdescription";
	}
	if((document.getElementById("txtposition").value) == "") {
		msg = "Position\n" + msg;
		focus = "txtposition";
	}
	if(focus != "") {
		msg = "Please enter the following\n\n" + msg;
		alert(msg);
		document.getElementById(focus).focus();
		return false;
	}
	else {
		return true;
	}
}

function deletecareers(careerid) {
	if (confirm("Are you sure to delete?")) {
		document.frmcareerslist.action = "careersUpdate.php?action=delete&careerid="+careerid+"";
		document.frmcareerslist.method = "POST";
		document.frmcareerslist.submit();
		return true;
	}
}

function validate_advertising(option) {
	var msg = "";
	var focus = "";
	var editorcontent = CKEDITOR.instances['txtadvertising'].getData().replace(/<[^>]*>/gi, '');
	if (!editorcontent.length){
		msg = "Advertising Content\n" + msg;
		focus = "txtadvertising";
	}
	if(focus != "") {
		msg = "Please enter the following\n\n" + msg;
		alert(msg);
		document.getElementById(focus).focus();
		return false;
	}
	else {
		return true;
	}
}

function val_post() {
	var tDesc = $("#" + txtDesc).val();
	var ttitle = $("#" + txtTitle).val();
	var lst_subtopic = $("#" + cbSubTopic).val();
	var gtype = $('input[name=gtype]:checked', '#frmaddpost').val();
	
	if(lst_subtopic == "0") {
		alert("Please select Sub Topic");
		$("#" + cbSubTopic).focus();
		return false;
	}
	
	if(trim(ttitle) == "") {
		alert("Please enter Title");
		$("#" + txtTitle).focus();
		return false;
	}
	if(!filterBadWords(ttitle)){
		alert("Title contains prohibited words");
		return false;
	};
	
	if(trim(tDesc) == "") {
		alert("Please enter Content");
		$("#" + txtDesc).focus();
		return false;
	}
	if(!filterBadWords(tDesc)){
		alert("Title contains prohibited words");
		return false;
	};
	if((gtype != 'I') && (gtype != 'V')) {
		alert("Please choose Input Graphic");
		//$('input[name=gtype]', '#frmaddpost').focus();
		return false;
	}else {
		$("#frmaddpost").attr("action", "posting_process.php");
		$("#frmaddpost").attr("method", "POST");
		document.frmaddpost.submit();
	}	
	return false;
}
    
function val_New_post() {
	var st_topics = $("#st_topics").val();
	var tDesc = $("#" + txtDesc).val();
	var ttitle = $("#" + txtTitle).val();
	var lst_subtopic = $("#" + cbSubTopic).val();
	var gtype = $('input[name=gtype]:checked', '#frmaddpost').val();
	
	if(st_topics == "0") {
		alert("Please select Topic Title");
		$("#st_topics").focus();
		return false;
	}
	
	if(lst_subtopic == "0") {
		alert("Please select Sub Topic");
		$("#" + cbSubTopic).focus();
		return false;
	}
	
	if(trim(ttitle) == "") {
		alert("Please enter Title");
		$("#" + txtTitle).focus();
		return false;
	}
	if(!filterBadWords(ttitle)){
		alert("Title contains prohibited words");
		return false;
	};
	
	if(trim(tDesc) == "") {
		alert("Please enter Content");
		$("#" + txtDesc).focus();
		return false;
	}
	if(!filterBadWords(tDesc)){
		alert("Title contains prohibited words");
		return false;
	};
	if((gtype != 'I') && (gtype != 'V')) {
		alert("Please choose Input Graphic");
		//$('input[name=gtype]', '#frmaddpost').focus();
		return false;
	}else {
		$("#frmaddpost").attr("action", "posting_process.php");
		$("#frmaddpost").attr("method", "POST");
		document.frmaddpost.submit();
	}	
	return false;
}


function toggleSelections(ipt) {
	if(ipt == 'I') {
		$('#divvdo :input').attr('disabled', true);
		$('#divimg :input').removeAttr('disabled');	        
	}
	if(ipt == 'V') {
		$('#divimg :input').attr('disabled', true);
		$('#divvdo :input').removeAttr('disabled');
	}
}

function checkMaxSubtopics(tid) {
	var tot;
	if(tid != "") {
		tot = $.ajax({  
			type: "POST",  
			url: "subtopic_process.php",  
			data: {
				'action' : 'getmax', 
				'tid' : tid
			}, 
			async: false,
			dataType: "json",
			cache:false
		}).responseText;
	}
	var obj = $.parseJSON(tot);
	if(obj.total > 15 ) {
		return false;
	}else {
		return true;
	}
}

function val_AddNewTopics() {
	var topicTitle  = $("#" + txtTitle);
	//var topicDesc = $("#" + txtDesc);
	var iid = $("#" + gid);
	if (topicTitle.val() == "") {
		alert( 'Please enter Topic Title' );
		topicTitle.focus();
		return false;
	} else if(iid.val() == "") {
		alert('Please select an Image File');
		iid.focus();
		return false;
	}
	document.frmaddtopics.action = "topic_process.php";
	document.frmaddtopics.method = "POST";
	document.frmaddtopics.submit();
	return true;
}


function val_AddNewSubTopics() {
	var objTitle =  $("#st_topics");
	var topicId = objTitle.val();
	var topicTitle = $("#st_title");
	//var stDesc = $("#" + st_desc);
	var iid = $("#rdimg");
	
	if(topicId == 0) {
		alert("Please select Topic Title");
		objTitle.focus();
		return false;
	}
	if (topicTitle.val() == "") {
		alert("Please enter Sub Topic Title");
		topicTitle.focus();
		return false;
	}
	if (iid.val() == "") {
		alert('Please select an Image File');
		iid.focus();
		return false;
	}
	if(!checkMaxSubtopics(topicId)) {
		alert("The maximum[15] number of sutopics has been created already");
		return false;
	}
	document.frmaddsubtopics.action = "subtopic_process.php";
	document.frmaddsubtopics.method = "POST";
	document.frmaddsubtopics.submit();
	return true;
}

function ValidateAddTopicsFields() {
	var topicTitle = document.getElementById("topicTitle");
	var fileupload = document.getElementById("fileupload");
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
		//return ajaxFileUpload();
		var topicTitle  = $("#topicTitle").val();
		var topicDesc = $("#topicDesc").val();
		var userid = $("#userid").val();
		var action = $("#tact").val();

		$.ajaxFileUpload ({
			url:'topic_process.php',
			secureuri:false,
			fileElementId:'fileupload',
			dataType: 'json',
			data:{
				"action": action, 
				"topicTitle": topicTitle, 
				'topicDesc': topicDesc, 
				"userid" : userid
			},
			cache: false,
			async: false,
			success: function (data, status) {
				if(typeof(data.error) != 'undefined') {
					if(data.msg == "OK") {
						alert("New Topic added successfully");
						disablePopup();
					}else {
						alert("Failed to add New Topic! Try again!");
					}
				}
			},
			error: function (data, status, e) {
				alert(e);
			}
		});

		return false;
	//document.login.action = "topicsupdate.php?action=addtopics";
	//document.login.method = "POST";
	//document.login.submit();
	//return true;
	}
}



function ValidateAddSubTopicsFields() {
	var objTitle = document.getElementById("st_topics");
	var topicId = objTitle.options[objTitle.selectedIndex].value;
	var topicTitle = document.getElementById("st_title");
	var fileupload= document.getElementById('st_fileupload');
	//var fileupload = fu[0];
	
	if(topicId == 0) {
		alert("Please select Topic Title");
		objTitle.focus();
		return false;
	}
	if (topicTitle.value == "") {
		alert("Please enter Sub Topic Title");
		topicTitle.focus();
		return false;
	}
	if (fileupload.value == "") {
		alert('Please upload any Image File');
		fileupload.focus();
		return false;
	}
	
	if(!checkFileExtension(fileupload.value)) {
		alert('Please upload Image File only \n(jpg, jpeg, png, bmp, gif)');
		fileupload.focus();
		return false;
	}
	else {
		var tid = topicId;
		var sttitle = $("#st_title").val();
		var STDesc = $("textarea#st_desc").val();
		var userid = $("#userid").val();
		var action = $("#stact").val();
		if(checkMaxSubtopics(tid)) {
			$.ajaxFileUpload ({
				url:'subtopic_process.php',
				secureuri:false,
				fileElementId:'st_fileupload',
				dataType: 'json',
				data:{
					"action": action, 
					"tid" : tid, 
					"sttitle": sttitle, 
					'stdesc': STDesc, 
					"userid" : userid
				},
				cache: false,
				async: false,
				success: function (data, status) {
					if(typeof(data.error) != 'undefined') {
						if(data.error != '') {
							alert(data.error);
						}else {
							if(data.msg == "OK") {
								alert("New SubTopic added successfully");
								disablePopup();
							}else {
								alert("Failed to add New SubTopic! Try again!")
							}
						}
					}
				},
				error: function (data, status, e) {
					alert(e);
				}
			});
		}
		else {
			alert("The maximum[15] number of sutopics has been created already");
			disablePopup();
		}
				
		return false;
	//document.login.action = "subtopicsupdate.php?action=addsubtopics";
	//document.login.method = "POST";
	//document.login.submit();
	//return true;
	}
	return false;
}
