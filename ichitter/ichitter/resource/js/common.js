// JavaScript Document

function elem_remove(){
	/*$('.error').remove();
	$('.success').remove();	*/
	
	$('.msg').removeClass('error').text('');

}

function write_error_msg(whr,msg,place){
	whr.addClass('error').text(msg);
	/*if($('.error').length > 0){
		$('.error').text(msg);
		return false;
	}else{		
		if(place == 'before'){
			whr.before('<div class="error">'+msg+'</div>');
		}else if(place == 'after'){
			whr.after('<div class="error">'+msg+'</div>');
		}else if(place == 'append'){
			whr.append('<div class="error">'+msg+'</div>');
		}
		return false;
	}*/
}

function write_success_msg(whr,msg){
	elem_remove();
	if($('.success').length > 0){
		$('.success').text(msg);
		return false;
	}else{
		whr.before('<div class="success">'+msg+'</div>');
		return false;
	}
}

function exist_email_validation(whr){	
	var val = $.trim(whr.val());		
	whr.next().remove();
	if(val && IsEmail(val)){
		
		return $.ajax({		 
		   url: "userregistration_process.php",
		    /*beforeSend: function(){
               $('.msgpass').addClass('error').text('Please wait while your email id is checking');
             },*/
		   data: {'email':whr.val(),'action':'email_validation'},		   
		   async: false,
		   dataType: "json"/*,
		   complete:function(){
                 $('.msgpass').removeClass('error').text('');
             }*/
	  }).responseText;
	}
}
 
function IsEmail(email) {
	var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	//var regex = /^\w+([-.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;	
	//var regex = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	//var regex = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;
	return regex.test(email);
}

function on_blur_check_value(whr,data){
	var value = $.trim($(whr).val());
	if(value == ''){
		$(whr).val(data);
	}
}

function onclick_clear_data(whr,data){
	var value = $.trim($(whr).val());
	if(value == data){
		$(whr).val('');
	}
}

function ajax_function(url,data){	
	return $.ajax({		 
		   url: url,
		   data: data,
		   beforeSend:function(){
				$('.success').remove();
				$('.error').remove();
			},
		   async: false,
		   dataType: "json"
	  }).responseText;
}

function collapseText(group){
	for(var _i=1;_i<=iCnt;_i++)
	{
		$("#history" + _i).addClass("collapseText");
		$('#more' + _i + ' img').attr("src","resource/images/bot-arrow.png");
	}
	$('.morebtn a').click(function(event){
		var id = this.id.replace("more","");
		var checkExpand = $('#more' + id + ' img').attr("src").indexOf("bot-arrow.png");
		if(checkExpand == -1){
			$("#history"+ id).removeClass("expandText");
			$("#history"+ id).addClass("collapseText");			
			$('#more' + id + ' img').attr("src","resource/images/bot-arrow.png");
		} else {		 	

			$("#history"+ id).removeClass("collapseText");
			$("#history"+ id).addClass("expandText");	
			$('#more' + id + ' img').attr('src','resource/images/top-arrow.png');			
		}
	});
}
var w_i = '';
$(document).ready(function(){
    
    var m_h = $('#mututal_wrapper .mutual_frnds:first-child').outerHeight();
    var l = $('#mututal_wrapper .mutual_frnds').length;
    var m_c_h = m_h * l;
    
    $('#mututal_container').css('height',m_c_h+'px');
    
    if(l > 3){
    w_i = window.setInterval(ani_top, 3000,m_h);
    
    $('#mututal_container').hover(function(){
        ani_stop();
        
        var s = $(this).css('top');
        var t = parseInt(/([0-9]+)/.exec(s));
       if(t < 82){
           $(this).animate({'top':'0px'},1000);   
       }
        $(this).stop();
    },function(){
      if($(this).find('.mutual_frnds').length < 4){
        ani_stop();
      }else{
        w_i = window.setInterval(ani_top, 3000,m_h);
      }
    });
    }
    
});

function ani_stop(){
    clearInterval(w_i);
}

function ani_top(m_h){ 
    var ht = '';
    $('#mututal_container').animate({'top':'-'+m_h+'px'},1000,function(){
        $('#mututal_container').css('top','0px');
        ht = '<div class="mutual_frnds">'+$('#mututal_container > div:first-child').html()+'</div>';
        $('#mututal_container > div:last-child').after(ht);
        $('#mututal_container > div:first-child').remove();
    });  
}