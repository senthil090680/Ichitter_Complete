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
							<div class="posting" style="margin-bottom:10px;">Postings</div>
								
								
										<div class="disc-containernew" >
																	 
										 <table  border="0" cellpadding="0" cellspacing="0">
											  <tr bgcolor="#FFFFFF">
											    <td class="select-box"><label>Sort By</label><select><option>Article</option></select></td>
											    <td valign="bottom" class="mine-btn"><span>Mine</span></td>
											    <td valign="bottom" class="other-btn"><span>Others</span></td>
											    <td valign="bottom" class="new-btn"><span>New</span></td>
									       </tr>
											  <tr>
												<td class="dischdtext">NOV 11, 2010 at 4:05 pm</td>
												<td rowspan="2" class="mine-box"><a href="#">01</a></td>
												<td rowspan="2"  class="other-box"><a href="#">04</a></td>
												<td rowspan="2"  class="new-box">&nbsp;</td>
											  </tr>
											  <tr>
												<td class="disc-text">Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. In posuere felis nec tortor.</td>
											  </tr>
											  <tr>
                                                <td class="dischdtextbt">NOV 11, 2010 at 4:05 pm</td>
                                                <td rowspan="2" class="mine-box"><a href="#">03</a></td>
                                                <td rowspan="2"  class="other-box"><a href="#">07</a></td>
                                               <td rowspan="2"  class="new-box">&nbsp;</td>
									       </tr>
											  <tr>
                                                <td class="disc-textbt">Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. In posuere felis nec tortor. Pellentesque faucibus. Ut accumsan ultricies elit.
                                                </td>
									       </tr>
										   
										  <tr>
												<td class="dischdtext">NOV 11, 2010 at 4:05 pm</td>
												<td rowspan="2" class="mine-box"><a href="#">02</a></td>
												<td rowspan="2"  class="other-box"><a href="#">05</a></td>
												<td rowspan="2"  class="new-box"><a href="#">01</a></td>
										   </tr>
											  <tr>
												<td class="disc-text">Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. In posuere felis nec tortor.</td>
											  </tr>
									      </table>

							</div>
							
							</div>
		</div>

		<div id="contentRight">
		
		<?php include ('common/right_side_navigation.php');?>
		
		</div>
		

			<?php require_once 'common/footer1.php'; ?>	