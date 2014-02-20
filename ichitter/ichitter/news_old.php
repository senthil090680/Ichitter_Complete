<?php
	require_once 'lib/include_files.php';
//print_r($_SESSION);

	if(isset($_REQUEST['logout']) && $_REQUEST['logout'] == 'OK'){
		$session_obj->unset_Session('login');	
		//header('location:index.php');	
		echo "<script>window.location = 'index.php'</script>";
	}
	
	/*if(!$session_obj->get_Session('login')){
		header('location:index.php');
	}*/

if(trim($_SESSION['login']['user_id']) == ''){
	echo "<script>window.location = 'index.php'</script>";
	//header('location:editprofile.php');
}

	$data = array('get_user_record'=>1,'user_id'=>$session_obj->get_Session('user_id'));	
	$init_process_obj = new INIT_PROCESS(SERVICE_NAME.'registration_service.php',$data);
	
	$user_data = $ObjJSON->objectToArray($ObjJSON->decode($init_process_obj->response));
	/*echo '<pre />';
	print_r($user_data);*/
	require_once 'common/header1.php';
?>
		
		<div id="contentLeft">
			<div id="profPhoto"><img src="resource/images/paula-jones.jpg" /><br />Paula Jones</div>
			
			
			<div id="groupsContain">
			
			<div class="box"> 
			 <div class="grouptext">Groups</div>
			 <div class="boxformone">
			<select name=""  class="forminside1" style="border:0px;" multiple>
			  <option>UCI Rep.</option>
			  <option>OC T-Party</option>
			  <option>California coast</option>
			</select>

			  </div>
			 </div>
			 
			<div class="box"> 
			 <div class="discussionstext">Discussions</div>
			 <div class="boxformtwo">
			 
			 <textarea name="text" class="forminside2" cols="" rows=""></textarea>
			
			 
			  </div>
			 </div>
			
			
			</div>
<div class="line"></div>
							<div id="leftmenulist">	
							<?php include ('common/side_navigation.php');?>
							</div>						
							<div id="mainupload">	
								<div class="posting">News Stream</div>
									<div id="newsdata"> 
										 <h1>Pellentesque habitant morbi</h1>
										 <p>Ehicu fusce auctor, metus eu ul. nusquam percipitur cotidieq porta percipitur ipsum dolor duiss..</p>
										 <div id="line" align="center"><img src="resource/images/line.jpg" /></div>
										 <h1>Nulla mauris odio</h1>
										 <p>Nullam usu causae efficiendi  nusquam percipitur cotidieq porta percipitur ipsum dolor duiss..</p>
										 <div id="line" align="center"><img src="resource/images/line.jpg" /></div>
										 <h1>Nunc tempus felis</h1>
										 <p>Mnusquam percipitur cotidieq porta percipitur ipsum dolor duiss..auris vel lacus vitae felis ves...</p>
										 <div id="line" align="center"><img src="resource/images/line.jpg" /></div>
										 <h1>Maecenas aliquet velit</h1>
										 <p>Vestibulum ligula nusquam percipitur cotidieq porta percipitur ipsum dolor duiss..augue, um a...</p>
										 <div id="line" align="center"><img src="resource/images/line.jpg" /></div>
										 <h1>Nulla mauris odio</h1>
										 <p>Nullam usu causae efficiendi  nusquam percipitur cotidieq porta percipitur ipsum dolor duiss..</p>
									</div>
								 </div>
							</div>

		<div id="contentRight">
		
		<?php include ('common/right_side_navigation.php');?>
		
		</div>
		

	<?php require_once 'common/footer1.php'; ?>	
		