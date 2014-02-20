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
            } else {
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

//alert(hrf.QueryStringToJSON().toSource());

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
//var string_value = getQuerystring('id');

//function collapseText(group){
function collapseText(){
    for(var _i=1;_i <= iCnt;_i++)
    {
        $("#history" + _i).addClass("collapseText");
        $('#more' + _i + ' img').attr("src","resource/images/more-btn.jpg");
        $('#edit' + _i + ' img').attr("src","resource/images/edit-btn.png");
    }
    //$("#history").slideUp("slow");
    $('.morebtn a').click(function(event){

        var id = this.id.replace("more","");

        var checkExpand = $('#more' + id + ' img').attr("src").indexOf("more-btn.jpg");

        if(checkExpand == -1){
            $("#history"+ id).removeClass("expandText");
            $("#history"+ id).addClass("collapseText");
            $('#more' + id + ' img').attr("src","resource/images/more-btn.jpg");
            $('#edit' + id + ' img').attr('src','resource/images/edit-btn.png');
            
            end;
        } else {

            $("#history"+ id).removeClass("collapseText");
            $("#history"+ id).addClass("expandText");
            $('#more' + id + ' img').attr('src','resource/images/less-btn.png');
            $('#edit' + id + ' img').attr('src','resource/images/edit-btn.png');
            
        }
    });
}

$(function() {
    //$('#slider').nivoSlider();
	
    //$('.homebtn').mouseup(function() {
    //alert('fdsf');
    //$(this).css('cursor', 'hand');
    //});
	
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
	
    $('#markit').click(function(event){
        toggleChecked(true);
    //var chox = $("input[name='cb_mark[]']");
    //for(i=0; i < chox.length; i++) {
    //	chox[i].checked = true;
    //}
    });

    $('#markit').click(function(event){
        //toggleChecked(true);
        var chox = $("input[name='cb_mark[]']");
        for(i=0; i < chox.length; i++) {
            chox[i].checked = true;
        }
        //$(this).attr("checked", status);
        var fields = $("input[name='cb_mark[]']").serializeArray(); 
        if (fields.length == 0) { 
            alert("Please select atleast one Post to mark"); 
            return false;
        }
        $('#frmMarks').attr('method', 'POST');
        $('#frmMarks').submit();
    });
	
});

function toggleChecked(status) {
    $(".styled").each( function() {
        $(this).attr("checked", status);
    });
}

function markPost(elem) {
	
    var tsp = $('[name="tsp[]"]'); // $("#tsp");
	
    var elvalue = elem.value;
    var elv_arr = elvalue.split('_');
    var postid = elv_arr[0];
    var subtopicid = elv_arr[1];
    var ischecked = elem.checked;
    $.ajax({  
        type: "POST",  
        url: "mark_process.php",  
        data: {
            'postid' : postid,
            'subtopicid': subtopicid, 
            'topicid' : topic_id, 
            'action':'markpost', 
            'ismarked' : ischecked
        },  
        async: false,
        dataType: "json",  
        cache: false,
        success: function(data){
        //alert(data.msg);
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

function toggleStatus(anc) {
    var opens = $(anc).html();
    if(opens == "VIEW") {
        $(anc).html("COLLAPSE");
    }else {
        $(anc).html("VIEW");
    }
}

function constructDiscussion(obj, parNode) {
    var dt = getDatetime(obj.posted_on);
    var did = obj.discussion_id;
	
    var parcls = $(parNode).attr('class');
	
    var boxcls = 'inbox2 btm';
    if(parcls.indexOf('inbox2') != -1) {
        boxcls = 'inbox1 btm';
    }else {
        boxcls = 'inbox2 btm';
    }
	
    var htmltxt = '<div class="' + boxcls + '">';
    htmltxt += '<div class="trigger" id="' + did + '">';
    htmltxt += '<a href="#">' + obj.uname + ', </a>';
    htmltxt += '<span> ' + dt + '</span>';
    htmltxt += '<div class="open">';
    htmltxt += '<p class="discuss">';
    htmltxt += '<a href="javascript: void(0);" id="' + did + '">COLLAPSE</a>';
    htmltxt += '</p>';
    htmltxt += '</div>';
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
    htmltxt += '<textarea style="width: 95%; height:100px; margin: 0 0 0 8px;" name="content_' + did + '" id="content_' + did + '"></textarea>';
    htmltxt += '<div class="brk"></div>';
    htmltxt += '<div class="replycomment"><a href="javascript: void(0);" id="replycomment"></a></div>';
    htmltxt += '</span>';
    htmltxt += '</div>';
    htmltxt += '</div>';
    htmltxt += '<div class="brk"></div>';
		
    return htmltxt;
}

function replyButton() {
    toggleTrigger();
    $('.reply a').unbind('click');
    $(".reply a").click(function(){
        var spanid = "span_"+ this.id;
        $("." + spanid).show();
        var par = $(this).parent().parent().parent().parent().parent();
        //alert(par.attr('class'));
        replyDiscussion(this.id, par);
        return false;
    });
}

function toggleTrigger() {
    $(".trigger").unbind('click');
    $(".trigger").click(function(){
        $(".span_" + this.id).hide();
        $(this).toggleClass("active").next().slideToggle("slow");
        var anc = $(this).children().children().children();
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
