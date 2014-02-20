$(document).ready(function(){
	$("#start_emb").hide();
	$("#create").click(function(){
		$("#start_emb").slideToggle("slow");

		var maskHeight = $(document).height();
		var maskWidth = $(window).width();

		$('#mask').css({
			'width':maskWidth,
			'height':maskHeight,
			backgroundColor:"black"
		});

		$('#mask').fadeIn(1000);	
		$('#mask').fadeTo("slow",0.8);

		$('#post_title').val('') ;
		$('#summary_description').val('') ;
		$('#tags2').val('') ;

		$("#t_error").html("");
		$("#d_error").html("");
		$("#tg_error").html("");
	});

	$("#cls").click(function(){
		$('#mask').hide();
		$("#start_emb").hide("slow");
	}); 
   
	$('#add_tag_btn').click(function(){
		var title_r = $('#post_title').val();
		var desc_r = $('#summary_description').val();
		var tag_r = $('#tags2').val();

		var title = $.trim(title_r);
		var desc = $.trim(desc_r);
		var tag_r = $.trim(tag_r);
		var login ="Login";
		var start ="start";

		if (title != '' &&  desc!=''  &&  tag_r!='' ) {
			$('#t_error').hide();
			$('#d_error').hide();
			$('#tg_error').hide();
		} else {
			if(title==''){
				$('#t_error').show();
				$("#t_error").html("(Not Empty.)");
			}
			if(desc==''){
				$('#d_error').show();
				$("#d_error").html("(Not Empty.)");
			}
			if(tag_r==''){
				$('#tg_error').show();
				$("#tg_error").html("(Not Empty.)");
			}
		}
	});
});	