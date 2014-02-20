<?php
require_once 'lib/include_files.php';
require_once('lib/profile_photo_include.php');

if (isset($_REQUEST['logout']) && $_REQUEST['logout'] == 'OK') {
	$session_obj->unset_Session('login');
	echo "<script>window.location = 'index.php'</script>";
}

if (trim($_SESSION['login']['user_id']) == '') {
	echo "<script>window.location = 'index.php'</script>";
}

$data = array('action' => 'get_security_settings', 'user_id' => SESS_USER_ID);

$init_process_obj = new INIT_PROCESS(SECURITY_SERVICE, $data);
$security_data = (array) ($ObjJSON->decode($init_process_obj->response));
/* echo '<pre />';
  print_r($security_data); */
$check = 'resource/images/tick.png';
$uncheck = 'resource/images/wrong.png';
require_once 'common/header1.php';
?>

<div id="contentLeft">
	<div id="profPhoto"><img width="86" height="106" src="<?php echo $profile_img; ?>" /><br /><?php echo $user_name; ?></div>
<?php require_once('lib/group_header_include.php'); ?>
	<div class="line"></div>
	<div id="leftmenulist">	
		<?php include_once ('common/side_navigation.php'); ?>
	</div>		
<?php
	
	$REQ_SEND[PARAM_ACTION] = 'get_user_record';
	$REQ_SEND['user_id'] = SESS_USER_ID;
	$init_process_obj = new INIT_PROCESS(SERVICE_NAME.'registration_service.php', $REQ_SEND);
	$user_info = (array)($ObjJSON->decode($init_process_obj->response));
	?>
<div id="mainupload">	
							<div class="posting" style="margin-bottom:10px;"><?php echo $user_info['first_Name'] . " " . $user_info['last_Name']; ?></div>							
							
							<div class="ucipublishedtxt">
								
					  			<div class="overlook">
								  <ul>
								    <li class="type1">Name : </li>
									<li class="type2"><?php echo $user_info['first_Name'] . " " . $user_info['last_Name']; ?></li>
								  </ul>
								  <ul>
								    <li class="type1">Place : </li>
									<li class="type2"><?php echo $user_info['location']; ?></li>
								  </ul>
								  <ul>
								    <li class="type1">Status : </li>
									<li class="type2"><?php echo $user_info['status']; ?></li>
								  </ul>
								  <ul>
								    <li class="type1">Poltifical affiliation : </li>
									<li class="type2"><?php echo $user_info['political_affiliation']; ?></li>
								  </ul>
								  <ul>
								    <li class="type1">Active involment : </li>
									<li class="type2"><?php echo $user_info['active_involment']; ?></li>
								  </ul>
								  <ul>
								    <li class="type1">Issues close to heart : </li>
									<li class="type2"><?php echo $user_info['issues_close_at_heart']; ?></li>
								  </ul>
								</div>
								<div class="overlook">
								  <ul>
								    <li class="type1">Education : </li>
									<li class="type2"><?php echo $user_info['college']; ?></li>
								  </ul>
								  <ul>
								    <li class="type1">Profession : </li>
									<li class="type2"><?php echo $user_info['profession']; ?></li>
								  </ul>
								  <ul>
								    <li class="type1">Career : </li>
									<li class="type2"><?php echo $user_info['career']; ?></li>
								  </ul>
								  <ul>
								    <li class="type1">Hobbies : </li>
									<li class="type2"><?php echo $user_info['hobbies']; ?></li>
								  </ul>
								  <ul>
								    <li class="type1">Interest : </li>
									<li class="type2"><?php echo substr(stripcslashes($user_info['interests']), 0, 13) ; ?></li>
								  </ul>
								  <ul>
								    <li class="type1">Family : </li>
									<li class="type2"><?php echo $user_info['family']; ?></li>
								  </ul>
								</div>
					        </div>
							</div>
	
	<div id="mainupload">
						    	
					
					
					
					<div class="groupsContain">
			
			<div class="box"> 
			 <div class="grouptext">My Group</div>
			 <div class="boxformone">
			<select multiple="" style="border:0px;" class="forminside1" name="">
			  <?php
			  for($i=0;$i<count($grpnm);$i++){
				 echo "<option value='".$grpid[$i]."' style='cursor:pointer;' onclick='window.location=\"group_details.php?grpid=\"+this.value;'>".$grpnm[$i]."</option>";
			}
			?>
			</select>

			  </div>
			 </div>
			 
			<div class="box"> 
			 <div class="discussionstext">Inner Circle</div>
			 <div class="boxformtwo">			 
			  <div class="innersec">
				  <?php 
					if(!empty($user_data)){
						foreach($user_data as $k => $v){ 
				  ?>
				  <div class="innercont"> 
					 <div class="innerimg"><img src="<?php echo $v['image_name']; ?>" width="40" height="40" alt=""  /></div>
					 <div class="innertext"> <h5><?php 
				if($v['priv_name'] == 1){
					echo ucfirst($v['first_Name']); 
				}
			?></h5><p><?php echo $v['state_name']; ?></p></div>
				  </div>
				 <?php 
						} 
					}else{
				  ?>
						<div class="norecords">No Available contacts!</div>
				  <?php 
					}
				  ?>
			  </div>			 
			  </div>
			 </div>
			
			</div>
			
			</div>
	
	


	<div id="mainupload">	
		
		<div class="ucipublishedhd margin-top10"><h1>Security Settings:</h1></div>					
		<div class="ucipublishedtxt">
			<div class="security">
				<ul>
					<li class="list1 border-r">Data</li>
					<li class="list1 border-r">Public</li>
					<li class="list1">Inner Circle</li>  
				</ul>
				<ul class="security_panel" for="name">
					<li class="list2 border-r">Name</li>

					<li class="list2 border-r <?php echo ($security_data['pub_name'] == 1) ? 'yes' : 'no'; ?>">
						<img src="<?php echo ($security_data['pub_name'] == 1) ? $check : $uncheck; ?>"  />
					</li>  
					<li class="list2  <?php echo ($security_data['priv_name'] == 1) ? 'yes' : 'no'; ?>">
						<img src="<?php echo ($security_data['priv_name'] == 1) ? $check : $uncheck; ?>"  />
					</li>
				</ul>
				<ul class="security_panel" for="place">
					<li class="list2 border-r">Place</li>

					<li class="list2 border-r <?php echo ($security_data['pub_place'] == 1) ? 'yes' : 'no'; ?>">
						<img src="<?php echo ($security_data['pub_place'] == 1) ? $check : $uncheck; ?>"  />
					</li> 
					<li class="list2  <?php echo ($security_data['priv_place'] == 1) ? 'yes' : 'no'; ?>">
						<img src="<?php echo ($security_data['priv_place'] == 1) ? $check : $uncheck; ?>"  />
					</li>  
				</ul>
				<ul class="security_panel" for="status">
					<li class="list2 border-r">Status</li>

					<li class="list2 border-r <?php echo ($security_data['pub_status'] == 1) ? 'yes' : 'no'; ?>">
						<img src="<?php echo ($security_data['pub_status'] == 1) ? $check : $uncheck; ?>"  />
					</li> 

					<li class="list2  <?php echo ($security_data['priv_status'] == 1) ? 'yes' : 'no'; ?>">
						<img src="<?php echo ($security_data['priv_status'] == 1) ? $check : $uncheck; ?>"  />
					</li>   
				</ul>
				<ul class="security_panel" for="poltifical_affiliation">
					<li class="list2 border-r">Poltifical affiliation</li>

					<li class="list2 border-r <?php echo ($security_data['pub_poltifical_affiliation'] == 1) ? 'yes' : 'no'; ?>">
						<img src="<?php echo ($security_data['pub_poltifical_affiliation'] == 1) ? $check : $uncheck; ?>"  />
					</li>
					<li class="list2 <?php echo ($security_data['priv_poltifical_affiliation'] == 1) ? 'yes' : 'no'; ?>">
						<img src="<?php echo ($security_data['priv_poltifical_affiliation'] == 1) ? $check : $uncheck; ?>"  />
					</li> 
				</ul>
				<ul class="security_panel" for="active_involment">
					<li class="list2 border-r">Active involment </li>

					<li class="list2 border-r <?php echo ($security_data['pub_active_involment'] == 1) ? 'yes' : 'no'; ?>">
						<img src="<?php echo ($security_data['pub_active_involment'] == 1) ? $check : $uncheck; ?>"  />
					</li> 
					<li class="list2 <?php echo ($security_data['priv_active_involment'] == 1) ? 'yes' : 'no'; ?>">
						<img src="<?php echo ($security_data['priv_active_involment'] == 1) ? $check : $uncheck; ?>"  />
					</li> 
				</ul>
				<ul class="security_panel" for="issues_close_to_heart">
					<li class="list2 border-r">Issues close to heart</li>

					<li class="list2 border-r <?php echo ($security_data['pub_issues_close_to_heart'] == 1) ? 'yes' : 'no'; ?>">
						<img src="<?php echo ($security_data['pub_issues_close_to_heart'] == 1) ? $check : $uncheck; ?>"  />
					</li>
					<li class="list2 <?php echo ($security_data['priv_issues_close_to_heart'] == 1) ? 'yes' : 'no'; ?>">
						<img src="<?php echo ($security_data['priv_issues_close_to_heart'] == 1) ? $check : $uncheck; ?>"  />
					</li> 
				</ul>
				<ul class="security_panel" for="education">
					<li class="list2 border-r">Education </li>

					<li class="list2 border-r <?php echo ($security_data['pub_education'] == 1) ? 'yes' : 'no'; ?>">
						<img src="<?php echo ($security_data['pub_education'] == 1) ? $check : $uncheck; ?>"  />
					</li> 
					<li class="list2 <?php echo ($security_data['priv_education'] == 1) ? 'yes' : 'no'; ?>">
						<img src="<?php echo ($security_data['priv_education'] == 1) ? $check : $uncheck; ?>"  />
					</li>
				</ul>
				<ul class="security_panel" for="profession">
					<li class="list2 border-r">Profession </li>

					<li class="list2 border-r <?php echo ($security_data['pub_profession'] == 1) ? 'yes' : 'no'; ?>">
						<img src="<?php echo ($security_data['pub_profession'] == 1) ? $check : $uncheck; ?>"  />
					</li> 
					<li class="list2 <?php echo ($security_data['priv_profession'] == 1) ? 'yes' : 'no'; ?>">
						<img src="<?php echo ($security_data['priv_profession'] == 1) ? $check : $uncheck; ?>"  />
					</li>
				</ul>
				<ul class="security_panel" for="career">
					<li class="list2 border-r">Career </li>

					<li class="list2 border-r <?php echo ($security_data['pub_career'] == 1) ? 'yes' : 'no'; ?>">
						<img src="<?php echo ($security_data['pub_career'] == 1) ? $check : $uncheck; ?>"  />
					</li> 
					<li class="list2 <?php echo ($security_data['priv_career'] == 1) ? 'yes' : 'no'; ?>">
						<img src="<?php echo ($security_data['priv_career'] == 1) ? $check : $uncheck; ?>"  />
					</li>
				</ul>
				<ul class="security_panel" for="hobbies">
					<li class="list2 border-r">Hobbies </li>

					<li class="list2 border-r <?php echo ($security_data['pub_hobbies'] == 1) ? 'yes' : 'no'; ?>">
						<img src="<?php echo ($security_data['pub_hobbies'] == 1) ? $check : $uncheck; ?>"  />
					</li> 
					<li class="list2 <?php echo ($security_data['priv_hobbies'] == 1) ? 'yes' : 'no'; ?>">
						<img src="<?php echo ($security_data['priv_hobbies'] == 1) ? $check : $uncheck; ?>"  />
					</li>
				</ul>
				<ul class="security_panel" for="interest">
					<li class="list2 border-r">Interest </li>

					<li class="list2 border-r <?php echo ($security_data['pub_interest'] == 1) ? 'yes' : 'no'; ?>">
						<img src="<?php echo ($security_data['pub_interest'] == 1) ? $check : $uncheck; ?>"  />
					</li>
					<li class="list2 <?php echo ($security_data['priv_interest'] == 1) ? 'yes' : 'no'; ?>">
						<img src="<?php echo ($security_data['priv_interest'] == 1) ? $check : $uncheck; ?>"  />
					</li>
				</ul>
				<ul class="security_panel" for="family">
					<li class="list2 border-r">Family </li>

					<li class="list2 border-r <?php echo ($security_data['pub_family'] == 1) ? 'yes' : 'no'; ?>">
						<img src="<?php echo ($security_data['pub_family'] == 1) ? $check : $uncheck; ?>"  />
					</li>
					<li class="list2 <?php echo ($security_data['priv_family'] == 1) ? 'yes' : 'no'; ?>">
						<img src="<?php echo ($security_data['priv_family'] == 1) ? $check : $uncheck; ?>"  />
					</li> 
				</ul>
				<ul class="security_panel" for="news_stream">
					<li class="list2 border-r">News Stream</li>

					<li class="list2 border-r <?php echo ($security_data['pub_news_stream'] == 1) ? 'yes' : 'no'; ?>">
						<img src="<?php echo ($security_data['pub_news_stream'] == 1) ? $check : $uncheck; ?>"  />
					</li>
					<li class="list2 <?php echo ($security_data['priv_news_stream'] == 1) ? 'yes' : 'no'; ?>">
						<img src="<?php echo ($security_data['priv_news_stream'] == 1) ? $check : $uncheck; ?>"  />
					</li>  
				</ul>
				<ul class="security_panel" for="photographs">
					<li class="list2 border-r">Photographs</li>

					<li class="list2 border-r <?php echo ($security_data['pub_photographs'] == 1) ? 'yes' : 'no'; ?>">
						<img src="<?php echo ($security_data['pub_photographs'] == 1) ? $check : $uncheck; ?>"  />
					</li> 
					<li class="list2 <?php echo ($security_data['priv_photographs'] == 1) ? 'yes' : 'no'; ?>">
						<img src="<?php echo ($security_data['priv_photographs'] == 1) ? $check : $uncheck; ?>"  />
					</li>
				</ul>
				<ul class="security_panel" for="movies">
					<li class="list2 border-r">Videos</li>

					<li class="list2 border-r <?php echo ($security_data['pub_movies'] == 1) ? 'yes' : 'no'; ?>">
						<img src="<?php echo ($security_data['pub_movies'] == 1) ? $check : $uncheck; ?>"  />
					</li>
					<li class="list2 <?php echo ($security_data['priv_movies'] == 1) ? 'yes' : 'no'; ?>">
						<img src="<?php echo ($security_data['priv_movies'] == 1) ? $check : $uncheck; ?>"  />
					</li> 
				</ul>
				<ul class="security_panel" for="contacts">
					<li class="list2 border-r">Contacts</li>

					<li class="list2 border-r <?php echo ($security_data['pub_contacts'] == 1) ? 'yes' : 'no'; ?>">
						<img src="<?php echo ($security_data['pub_contacts'] == 1) ? $check : $uncheck; ?>"  />
					</li>
					<li class="list2 <?php echo ($security_data['priv_contacts'] == 1) ? 'yes' : 'no'; ?>">
						<img src="<?php echo ($security_data['priv_contacts'] == 1) ? $check : $uncheck; ?>"  />
					</li> 
				</ul>
				<ul class="security_panel" for="i_Author">
					<li class="list2 border-r">I, Author</li>

					<li class="list2 border-r <?php echo ($security_data['pub_i_Author'] == 1) ? 'yes' : 'no'; ?>">
						<img src="<?php echo ($security_data['pub_i_Author'] == 1) ? $check : $uncheck; ?>"  />
					</li>
					<li class="list2 <?php echo ($security_data['priv_i_Author'] == 1) ? 'yes' : 'no'; ?>">
						<img src="<?php echo ($security_data['priv_i_Author'] == 1) ? $check : $uncheck; ?>"  />
					</li> 
				</ul>
			</div>
		</div>
	</div> 
	
	
</div>

<div id="contentRight">
	<?php include_once ('common/right_side_navigation.php'); ?>
</div>
<?php require_once 'common/footer1.php'; ?>