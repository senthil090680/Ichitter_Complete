$(function() {

	// load the modal window
	$('a.modal').click(function(){

		// scroll to top
		$('html, body').animate({scrollTop:0}, 'fast');

		// before showing the modal window, reset the form incase of previous use.
		$('.success, .error').hide();
		$('form#contactForm').show();
		
		// Reset all the default values in the form fields
		$('#name').val('Group name');
		$('#WhoWeAre').val('Who We Are');
		$('#Isay').val('I say');		

		//show the mask and contact divs
		$('#mask').show().fadeTo('', 0.7);
		$('div#contact').fadeIn();

		// stop the modal link from doing its default action
		return false;
	});

	// close the modal window is close div or mask div are clicked.
	$('div#close, div#mask').click(function() {
		$('div#contact, div#mask').stop().fadeOut('slow');

	});

	$('#contactForm input').focus(function() {
		$(this).val('');
	});
	
	$('#contactForm textarea').focus(function() {
        $(this).val('');
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
			}else{
				error_count = 0;	
			}
			
			if((error_count == 0) && (user_id != "")) {
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