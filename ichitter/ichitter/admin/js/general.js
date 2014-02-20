function activateuser(uid)
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

