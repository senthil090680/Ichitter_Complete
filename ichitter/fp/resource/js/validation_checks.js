 
/* 著者                   : カーティケヤン　ハリハラン 		*/
/* 作成年月日    : 08-02-2011				*/
/* 手順                   : 与えられた条件の検証をチェック	*/


/* FUNCTION NAME : trim															*/
/* INPUT		 : String														*/
/* RETURN TYPE	 : String														*/
/* RETURN VALUE	 : Trimmed String												*/
/* PROCESS		 : Return the trimmed string(Removes white spaces in both ends)	*/
function trim(str){
   return str.replace(/^\s+|\s+/g,'');  //trim the string
}

/* FUNCTION NAME : isEmpty						*/
/* INPUT		 : String						*/
/* RETURN TYPE	 : Boolean						*/
/* RETURN VALUE	 : True or False				*/
/* PROCESS		 : Check if the string is empty	*/
function isEmpty(sname){
   if((trim(sname)).length == 0)     //check the empty
   {
      return true;
   }
   return false;
}

/* FUNCTION NAME : isEmail									*/
/* INPUT		 : String									*/
/* RETURN TYPE	 : Boolean									*/
/* RETURN VALUE	 : True or False							*/
/* PROCESS		 : Check if the string is valid EMAIL ID	*/
function isEmail(cemail){
	var strMail = trim(cemail);
	var regMail =  /^\w+([-.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
	if (regMail.test(strMail))		//check with given pattern
	{ 
		return true;
    }
    else
    {     
       return false;
    }
}


/* FUNCTION NAME : checkMinLength												*/
/* INPUT		 : String,length												*/
/* RETURN TYPE	 : Boolean														*/
/* RETURN VALUE	 : True or False												*/
/* PROCESS		 : Check if the length of the given string is in minimum limit.	*/
function checkMinLength(str,len){
	if(str.length>=len)  	//check minimum length
	{
      return true;
	}
	return false;
}


/* FUNCTION NAME : checkMaxLength												*/
/* INPUT		 : String,length												*/
/* RETURN TYPE	 : Boolean														*/
/* RETURN VALUE	 : True or False												*/
/* PROCESS		 : Check if the length of the given string is in maximum limit.	*/
function checkMaxLength(str,len){
	if(str.length<=len)	//check maximum length
	{
      return true;
	}
	return false;
}

/* FUNCTION NAME : checkMaxLength	日本語											*/
/* INPUT		 : String,length												*/
/* RETURN TYPE	 : Boolean														*/
/* RETURN VALUE	 : True or False												*/
/* PROCESS		 : Check if the length of the given string is in maximum limit.	*/
function checkMaxLengthjp(str,len){
	count=0;
	for(i=0;i<str.length;i++) {
		(escape(str.charAt(i)).length< 4)?count++:count+=2;
	}
	if(count<=len){	//check maximum length
      return true;
	}
	return false;
}

/* FUNCTION NAME : isAlphanumeric								*/
/* INPUT		 : String										*/
/* RETURN TYPE	 : Boolean										*/
/* RETURN VALUE	 : True or False								*/
/* PROCESS		 : Check if given string is Alphanumeric only.	*/
function isAlphanumeric(str){
	var numaric = str;
	for(var j=0; j<numaric.length; j++)			//check alphanumeric by each character of the string
		{
		  var alphaa = numaric.charAt(j);
		  var hh = alphaa.charCodeAt(0);
		  if((hh > 47 && hh<58) || (hh > 64 && hh<91) || (hh > 96 && hh<123))
		  {
		  }
		  else
		  {
             return false;
		  }
 		}
 return true;
}


/* FUNCTION NAME : isAlpha									*/
/* INPUT		 : String									*/
/* RETURN TYPE	 : Boolean									*/
/* RETURN VALUE	 : True or False							*/
/* PROCESS		 : Check if given string is Alphabet only.	*/
function isAlpha(field){
 var re = /^([a-zA-Z])$/;
 var str=field;
 for(var i=0;i<str.length;i++)		//check alpha by each character of the string
 {
  if(re.test(str.charAt(i))!=1)
  {
	 return false;
  }
 }
  return true;
}


/* FUNCTION NAME : isNumeric								*/
/* INPUT		 : String									*/
/* RETURN TYPE	 : Boolean									*/
/* RETURN VALUE	 : True or False							*/
/* PROCESS		 : Check if given string is Numeric only.	*/
function isNumeric(field){
   var ValidChars = "0123456789.";
   var Char;
   var sText=field;
   for (i = 0; i < sText.length; i++) 		//check numeric by each character of the string
   { 
      Char = sText.charAt(i); 
      if (ValidChars.indexOf(Char) == -1) 
         {
            return false;
         }
   }
   return true;
}

/* FUNCTION NAME : isJapanese								*/
/* INPUT		 : String									*/
/* RETURN TYPE	 : Boolean									*/
/* RETURN VALUE	 : True or False							*/
/* PROCESS		 : Check if given string is Japanese only.	*/
function isJapanese(str){
	for(var j=0; j<str.length; j++)		//check japanese string by each character of the string
		{
		  var ch = str.charAt(j);
		  var hh = ch.charCodeAt(0);
		  if((hh > 0x4E00 && hh<0x9FFF) || (hh > 0x3040 && hh<0x309F) || (hh > 0x30A0 && hh<0x30FF))
		  {
		  }
		  else
		  {
             return false;
		  }
 		}
 return true;
}


/* FUNCTION NAME : checkDecimalpart										*/
/* INPUT		 : Floating,N											*/
/* RETURN TYPE	 : Boolean												*/
/* RETURN VALUE	 : True or False										*/
/* PROCESS		 : Check if length the decimal part of the value is less than or equal to N	*/
function checkDecimalpart(val,n){
  var len = val.length;
  var pos = val.indexOf("."); // zero-based counting.
  var num_dec = (len - pos) - 1; // -1 to compensate for the zero-based count in strpos()
  if(num_dec<=n)
  {
  	return true;
  }
  return false;
}

/* FUNCTION NAME : checkIntegralpart										*/
/* INPUT		 : Floating,N												*/
/* RETURN TYPE	 : Boolean													*/
/* RETURN VALUE	 : True or False											*/
/* PROCESS		 : Check if length of the integral part of the value is less than or equal to N	*/
function checkIntegralpart(val,n){
  var pos = val.indexOf("."); // zero-based counting.
  if(pos<=n)
  {
  	return true;
  }
  return false;
}

/**
 * 指定された文字列が電話番号として有効かどうかチェックします。
 * ※9999-9999-9999の形式と一致するかどうかで判断します。
 *
 * @param argValue チェック対象文字列
 * @return 電話番号として有効な場合はtrue、
 * 電話番号として無効な場合はfalse
*/
function isTelNumber(argValue)
{
	if (isEmpty(argValue))
    {
        // 未入力の場合
        return false;
    }
    if (argValue.match(/^[0-9]+\-[0-9]+\-[0-9]+$/) || argValue.match(/^[0-9]+$/))
    {
        return true;
    }
    else
    {
        return false;
    }
}


/* FUNCTION NAME : chkYYMMDD				`		*/
/* INPUT		 : date,type,delimiter(/-.)				*/
/* @param type	0-"YYYYMMDD"
 * 				1-"YYMMDD"
 * 				2-"YYYYMM"
 * 				3-"YYMM"							*/
/* RETURN TYPE	 : BOOLEAN							*/
/* RETURN VALUE	 : TRUE or FALSE					*/
/* PROCESS		 : Check if valid Year Format		*/
function chkYYMMDD(date,type,dlmt)
{
	var temp = new Array();
	var re = "/^([0-9"+dlmt+"])$/";
	for(var i=0;i<date.length;i++){
		if(re.test(date.charAt(i))!=1)
		  {
			 return false;
		  }
	}
	switch(type){
		case '0':	temp = date.split(dlmt);
					if(((temp[0].length)==4)&&((temp[1].length)==2)&&((temp[2].length)==2))
						return true;
					else 	
						return false;
		case '1':	temp = date.split(dlmt);
					if(((temp[0].length)==2)&&((temp[1].length)==2)&&((temp[2].length)==2))
						return true;
					else 
						return false;
		case '2':	temp = date.split(dlmt);
					if(((temp[0].length)==4)&&((temp[1].length)==2))
						return true;
					else 
						return false;
		case '3':	temp = date.split(dlmt);
					if(((temp[0].length)==2)&&((temp[1].length)==2))
						return true;
					else 
						return false;
		default:	return false;
}	
}

/*Date Check*/
function checkValidDate(dateStr) {
	
    // dateStr must be of format month day year with either slashes
    // or dashes separating the parts. Some minor changes would have
    // to be made to use day month year or another format.
    // This function returns True if the date is valid.
    var slash1 = dateStr.indexOf("/");
    if (slash1 == -1) { slash1 = dateStr.indexOf("-"); }
    // if no slashes or dashes, invalid date
    if (slash1 == -1) { return false; }
    var dateMonth = dateStr.substring(0, slash1);
    var dateMonthAndYear = dateStr.substring(slash1+1, dateStr.length);
    var slash2 = dateMonthAndYear.indexOf("/");
    if (slash2 == -1) { slash2 = dateMonthAndYear.indexOf("-"); }
    // if not a second slash or dash, invalid date
    if (slash2 == -1) { return false; }
    var dateDay = dateMonthAndYear.substring(0, slash2);
    var dateYear = dateMonthAndYear.substring(slash2+1, dateMonthAndYear.length);
    if ( (dateMonth == "") || (dateDay == "") || (dateYear == "") ) { return false; }
    // if any non-digits in the month, invalid date
    for (var x=0; x < dateMonth.length; x++) {
        var digit = dateMonth.substring(x, x+1);
        if ((digit < "0") || (digit > "9")) { return false; }
    }
    // convert the text month to a number
    var numMonth = 0;
    for (var x=0; x < dateMonth.length; x++) {
        digit = dateMonth.substring(x, x+1);
        numMonth *= 10;
        numMonth += parseInt(digit);
    }
    if ((numMonth <= 0) || (numMonth > 12)) { return false; }
    // if any non-digits in the day, invalid date
    for (var x=0; x < dateDay.length; x++) {
        digit = dateDay.substring(x, x+1);
        if ((digit < "0") || (digit > "9")) { return false; }
    }
    // convert the text day to a number
    var numDay = 0;
    for (var x=0; x < dateDay.length; x++) {
        digit = dateDay.substring(x, x+1);
        numDay *= 10;
        numDay += parseInt(digit);
    }
    if ((numDay <= 0) || (numDay > 31)) { return false; }
    // February can't be greater than 29 (leap year calculation comes later)
    if ((numMonth == 2) && (numDay > 29)) { return false; }
    // check for months with only 30 days
    if ((numMonth == 4) || (numMonth == 6) || (numMonth == 9) || (numMonth == 11)) {
        if (numDay > 30) { return false; }
    }
    // if any non-digits in the year, invalid date
    for (var x=0; x < dateYear.length; x++) {
        digit = dateYear.substring(x, x+1);
        if ((digit < "0") || (digit > "9")) { return false; }
    }
    // convert the text year to a number
    var numYear = 0;
    for (var x=0; x < dateYear.length; x++) {
        digit = dateYear.substring(x, x+1);
        numYear *= 10;
        numYear += parseInt(digit);
    }
    // Year must be a 2-digit year or a 4-digit year

    if ( (dateYear.length != 2) && (dateYear.length != 4) ) { return false; }
    // if 2-digit year, use 50 as a pivot date
    if ( (numYear < 50) && (dateYear.length == 2) ) { numYear += 2000; }
    if ( (numYear < 100) && (dateYear.length == 2) ) { numYear += 1900; }
    if ((numYear <= 0) || (numYear > 9999)) { return false; }
    // check for leap year if the month and day is Feb 29
    if ((numMonth == 2) && (numDay == 29)) {
        var div4 = numYear % 4;
        var div100 = numYear % 100;
        var div400 = numYear % 400;
        // if not divisible by 4, then not a leap year so Feb 29 is invalid
        if (div4 != 0) { return false; }
        // at this point, year is divisible by 4. So if year is divisible by
        // 100 and not 400, then it's not a leap year so Feb 29 is invalid
        if ((div100 == 0) && (div400 != 0)) { return false; }
    }
    // date is valid
    return true;
}

function checkvaliddata(dateStr) {
	var objValue = dateStr;
	if(objValue.length < 10) {
		return false;
	}
	var dt = objValue.split('/');

	var dt0 = dt[0];
	var dt1 = dt[1];
	var dt2 = dt[2];

	if(dt0.length < 4 || dt0.length > 4){
		return false;
	}
	if(dt1.length < 2 || dt1.length > 2){
		return false;
	}
	if(dt2.length < 2 || dt2.length > 2){
		return false;
	}

	var fdate = dt1 + '-' + dt2 + '-' + dt0;
	return checkValidDate(fdate);
}

/*End of Datecheck*/
