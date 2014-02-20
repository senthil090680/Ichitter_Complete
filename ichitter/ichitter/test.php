<?php 
	
	include_once 'common/header.php';
	require_once 'lib/include_files.php';

/*if(trim($_SESSION['login']['user_id']) != ''){
	echo "<script>window.location = 'editprofile.php'</script>";	
}*/

	/*$data = array('get_gender'=>1);	
	$init_process_obj = new INIT_PROCESS(SERVICE_NAME.'registration_service.php',$data);
	$gender = $ObjJSON->objectToArray($ObjJSON->decode($init_process_obj->response));
	
	$data = array('get_states'=>1);	
	$init_process_obj = new INIT_PROCESS(SERVICE_NAME.'registration_service.php',$data);
	$states = $ObjJSON->objectToArray($ObjJSON->decode($init_process_obj->response));
	*/
	include_once 'common/header.php';

?>
<script>
	$(document).ready(function(){
		$('#test_txt').click(function(){
		var test = $.ajax({		 
		   url: "userregistration_process.php",
		   data: {'email':'test@test.com','email_validation':'true'},
		   cache:false,
		   beforeSend:function(){
				$('.success').remove();
				$('.error').remove();
			},
		   async: false,
		   dataType: "json"
	  }).responseText;
	  
	  console.log(test);
	  alert(test);
	  });
	  
	});
</script>
<input type="text" value="" name="test" id="test_txt" />
<?php
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_VERBOSE, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_URL, 'http://tsg.emantras.com/ichitter_service/registration_service.php?email=test@test.com&email_validation=true' );
	//curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
	$response = curl_exec($ch);	
	print_r($response);
?>
