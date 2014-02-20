$(function() {

	// load the modal window
	$('.modal').click(function(){popup();});

	// close the modal window is close div or mask div are clicked.
	$('div#close, div#mask').click(function() {
		$('div#contact, div#mask').stop().fadeOut('slow');

	});

	var i = $.trim($('#contactForm input').val());
	$('#contactForm input').focus(function() { 
         var j = $.trim($(this).val());
        if(i == j){
            $(this).val('');
        }
	});
     
     $('#contactForm input').blur(function() { 
         var j = $.trim($(this).val());
        if(!j){
            $(this).val(i);
        }
	});
	
     var t = $.trim($('#contactForm textarea').val());
	$('#contactForm textarea').focus(function() {
        var j = $.trim($(this).val());
        if(t == j){
            $(this).val('');
        }
    });

	// when the Submit button is clicked...
	$('input#submit').click(function() {
	$('.error').hide().remove();
	$('#submit').val("Create");	
		//Inputed Strings
			var username = $('#name').val();	
			var WhoWeAre = $('#WhoWeAre').val();
			var Isay = $('#Isay').val();     
			var user_id = $('#user_id').val();
               var event_title = $('#event_title').val();
               var event_description = $('#event_description').val();
               var event_date = $('#event_date').val();
               var group_id = $('#group_id').val();
	
		//Error Count
		var error_count = 0;
		
		//Regex Strings
		
			//Test Username
			if ((username == "") || (username == "Group name")) {                  
				$('#contact_header').after('<p class=error>Invalid Group name entered!</p>');
				error_count += 1;
			}else if((WhoWeAre == "") || (WhoWeAre == "Who We Are")){
				$('#contact_header').after('<p class=error>Invalid "Who we are" entered!</p>');
				error_count += 1;
			}else if((Isay == "") || (Isay == "Who We Are")){
				$('#contact_header').after('<p class=error>Invalid "I say" entered!</p>');
				error_count += 1;			
			}else if((event_title == "") || (event_title == "Event Title")){
				$('#contact_header').after('<p class=error>Invalid "Event Title" entered!</p>');
				error_count += 1;			
			}else if((event_description == "") || (event_description == "Event Description")){
				$('#contact_header').after('<p class=error>Invalid "Event Description" entered!</p>');
				error_count += 1;			
			}else{
				error_count = 0;	
			}
			
			if($.trim(event_date) != "" && error_count == 0){
                 $(this).hide();
                     var url = 'calander_process.php';
                    var data = [];
                    var field_name = $.trim($(this).attr('id'));				
                    //var data = "event_title="+event_title+"&event_description="+event_description+"&event_date="+event_date+"&group_id="+group_id;
                    var data = $('#contactForm').serialize();
                    var r = ajax_function(url,data);
                   r = JSON.parse(r);
                    if(r.success){
                        var sel_id = $('#'+('c_'+$('#seldate').val().replace('/','')).replace('/',''));
                        var eve = '<div id="Event_'+r.success+'" class="Event" style="display: none;"><a href="javascript:void(0)" rel="'+event_description+'">'+event_title+'</a></div><div style="width: 1px; height: 1px; border: 1px solid red;" class="indicate"></div>';
                        sel_id.append(eve);                        
                        $('.error').hide();
                        $('.noevents').remove();
                        c = '<ul class="Messagechat caltxtrigh">';
                        c += '<li><div style="float: left"><input type="checkbox" value="'+r.success+'" name="cal_list_'+$('#clander_details ul').length+'" /></div><div style="float: left;margin-left: 10px;width: 440px;"><p style="float: left;" class="event_title">'+event_title+'</p><p class="event_date">'+event_date+'</p><p style="" class="event_desc">'+event_description+'</p></div><div onclick="event_edit(this)" class="caltxtrigh" style="float: right">Edit</div></li><div style="clear:both"></div></ul>';
                        $('#day_event_list').append(c);
                        $('#contact,#mask').fadeOut();                       
                      $(this).show();
                       var event_update = {"EventID":r.success, "StartDateTime":event_date, "Title":event_title, "URL": "javascript:void(0)", "Description": event_description, "CssClass": "Meeting"};
                        
                       jQuery.J.AddEvents(event_update);
                    }
               }else if((error_count == 0) && (user_id != "") && ($.trim(user_id) != "undefined")) {
                  
				$.ajax({
					type: "post",
					url: "create_group_process.php",
					data: "name=" + username + "&WhoWeAre=" + WhoWeAre + "&Isay=" + Isay + "&user_id=" +user_id,
					error: function() {			
						$('.error').hide();
						$('#sendError').slideDown('slow');
					},
					success: function (data) {					
						var json = $.parseJSON(data);				
						var res= json.success;
						if(res == "success"){
						//$('#groupsContainlayer').load('lib/header_js_ld.php');						
						$('.error').hide();
						$('.success').slideDown('fast');
						$('form#contactForm').fadeOut('fast');
                        location.reload(true);

						}else{
						$('#contact_header').after('<p class=error>Group already be created!</p>');						
						$('.error').show();
						$('#sendError').slideDown('slow');						
						}
					}				
				});	
			}
			
			else {
                $('.error').show();
            }
			
		return false;
	});
	
});

function popup(){        
		// scroll to top
		//$('html, body').animate({scrollTop:0}, 'fast');

		// before showing the modal window, reset the form incase of previous use.
		$('.success, .error').hide();
		$('form#contactForm').show();
		
		// Reset all the default values in the form fields
		$('#name').val('Group name');
		$('#WhoWeAre').val('Who We Are');
		$('#Isay').val('I say');		

          $('#event_title').val('Event Title');
          $('#event_description').val('Event Description');
          
		//show the mask and contact divs
		$('#mask').show().fadeTo('', 0.7);
		$('div#contact').fadeIn();

		// stop the modal link from doing its default action
		return false;
	
}