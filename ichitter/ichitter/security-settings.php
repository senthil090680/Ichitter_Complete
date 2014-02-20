<?php
	require_once 'lib/include_files.php';
	require_once('lib/profile_photo_include.php');

	if(isset($_REQUEST['logout']) && $_REQUEST['logout'] == 'OK'){
		$session_obj->unset_Session('login');	
		echo "<script>window.location = 'index.php'</script>";
	}
	
	if(trim($_SESSION['login']['user_id']) == ''){
		echo "<script>window.location = 'index.php'</script>";
	}

	$data = array('action'=>'get_security_settings','user_id'=>SESS_USER_ID);	
	$data = $REQ_SEND + $data;
	$init_process_obj = new INIT_PROCESS(SECURITY_SERVICE,$data);
	$security_data = (array)($ObjJSON->decode($init_process_obj->response));
	/*echo '<pre />';
	print_r($security_data);*/
	$check = 'resource/images/tick.png';
	$uncheck = 'resource/images/wrong.png';
	require_once 'common/header1.php';
?>

<script>
	$(document).ready(function(){
		$('.security_panel li').click(function(){
			if($(this).index() == 1){
				var field_name = 'pub_';
			}else if($(this).index() == 2){
					var field_name = 'priv_';
			}
			field_name += $.trim($(this).closest('ul').attr('for'));
			var url = 'security_process.php';
			var rclass = '';
			var addc = '';
			var img_src = '';
			if($(this).hasClass('yes')){
				rclass = 'yes';
				addc = 'no';
				img_src = 'resource/images/wrong.png';
				var val = 0;
			}else if($(this).hasClass('no')){
				rclass = 'no';
				addc = 'yes';
				img_src = 'resource/images/tick.png';
				var val = 1;
			}
						
			if($(this).index() == 1){
				var data = "action=security_setting&change=public&field_name="+field_name+"&val="+val;
			}else if($(this).index() == 2){
				var data = "action=security_setting&change=private&field_name="+field_name+"&val="+val;
			}
			var result = ajax_function(url,data);
			result = $.parseJSON(result);
			//alert(result.success);
			if(result.success && $(this).index() == 1){
				$(this).removeClass(rclass).addClass(addc).find('img').attr('src',img_src);
				$(this).next().removeClass(rclass).addClass(addc).find('img').attr('src',img_src);
			}else if(result.success && $(this).index() == 2){
				$(this).removeClass(rclass).addClass(addc).find('img').attr('src',img_src);
				
			}
		});
	});
</script>
		
		<div id="contentLeft">
			<div id="profPhoto"><img width="86" height="106" src="<?php echo $profile_img; ?>" /><br /><?php echo $user_name; ?></div>
			
			
		
			<?php   require_once('lib/group_header_include.php'); ?>
<div class="line"></div>
		  <div id="leftmenulist">	
				
					<?php include ('common/side_navigation.php');?>
					 
				
			</div>		
							
							
							
							
							<div id="mainupload">	
							<div class="posting" style="margin-bottom:10px;">Security Settings</div>
							   <div class="ucipublishedhd"> <h1>Password</h1> </div>					
					        <div class="ucipublishedtxt">
							   <input type="text" class="txtbox" /> 
					        </div> 
				            
					        <div class="ucipublishedhd margin-top10"><h1>Security Questions</h1> </div>					
					        <div class="ucipublishedtxt">
					   		  <div style="height:50px; width:300px; float:left; font-size:12px; "><div style="padding:5px;">What is your pet name?</div>
							  <input type="text" class="txtbox" /> </div>				 
	                        </div>
							
							<div class="ucipublishedhd margin-top10"><h1>Login Approval &amp; Notifications</h1> </div>					
					        <div class="ucipublishedtxt">
					   		  <div style="height:50px; float:left;"></div>				 
	                        </div>
							
							<div class="ucipublishedhd margin-top10"><h1>Last Session</h1> </div>					
					        <div class="ucipublishedtxt">
					   		  <div style="height:50px; float:left; font-size:12px; padding:5px;">Oct 11, 2011 Monday 3:30pm </div>				 
	                        </div>
							
							 <div class="ucipublishedhd margin-top10"><h1>App Securitys</h1> </div>					
					        <div class="ucipublishedtxt">
					   		  <div style="height:50px; float:left;"></div>				 
	                        </div>
							
					 
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
								   
								   <li class="list2 border-r <?php echo ($security_data['pub_name'] == 1) ? 'yes' : 'no';   ?>">
								   	<img src="<?php echo ($security_data['pub_name'] == 1) ? $check : $uncheck;   ?>"  />
								   </li>  
								   <li class="list2  <?php echo ($security_data['priv_name'] == 1) ? 'yes' : 'no';   ?>">
								   		<img src="<?php echo ($security_data['priv_name'] == 1) ? $check : $uncheck;   ?>"  />
								   </li>
								 </ul>
								 <ul class="security_panel" for="place">
								   <li class="list2 border-r">Place</li>
								   
								   <li class="list2 border-r <?php echo ($security_data['pub_place'] == 1) ? 'yes' : 'no';   ?>">
								   	<img src="<?php echo ($security_data['pub_place'] == 1) ? $check : $uncheck;   ?>"  />
								   </li> 
								   <li class="list2  <?php echo ($security_data['priv_place'] == 1) ? 'yes' : 'no';   ?>">
								   		<img src="<?php echo ($security_data['priv_place'] == 1) ? $check : $uncheck;   ?>"  />
								   </li>  
								 </ul>
								 <ul class="security_panel" for="status">
								   <li class="list2 border-r">Status</li>
								   
								   <li class="list2 border-r <?php echo ($security_data['pub_status'] == 1) ? 'yes' : 'no';   ?>">
								   	<img src="<?php echo ($security_data['pub_status'] == 1) ? $check : $uncheck;   ?>"  />
								   </li> 
								   
								   <li class="list2  <?php echo ($security_data['priv_status'] == 1) ? 'yes' : 'no';   ?>">
								   		<img src="<?php echo ($security_data['priv_status'] == 1) ? $check : $uncheck;   ?>"  />
								   </li>   
								 </ul>
								 <ul class="security_panel" for="poltifical_affiliation">
								   <li class="list2 border-r">Poltifical affiliation</li>
								  
								   <li class="list2 border-r <?php echo ($security_data['pub_poltifical_affiliation'] == 1) ? 'yes' : 'no';   ?>">
								   	<img src="<?php echo ($security_data['pub_poltifical_affiliation'] == 1) ? $check : $uncheck;   ?>"  />
								   </li>
								   <li class="list2 <?php echo ($security_data['priv_poltifical_affiliation'] == 1) ? 'yes' : 'no';   ?>">
								   		<img src="<?php echo ($security_data['priv_poltifical_affiliation'] == 1) ? $check : $uncheck;   ?>"  />
								   </li> 
								 </ul>
								 <ul class="security_panel" for="active_involment">
								   <li class="list2 border-r">Active involment </li>
								   
								   <li class="list2 border-r <?php echo ($security_data['pub_active_involment'] == 1) ? 'yes' : 'no';   ?>">
								   	<img src="<?php echo ($security_data['pub_active_involment'] == 1) ? $check : $uncheck;   ?>"  />
								   </li> 
								   <li class="list2 <?php echo ($security_data['priv_active_involment'] == 1) ? 'yes' : 'no';   ?>">
								   		<img src="<?php echo ($security_data['priv_active_involment'] == 1) ? $check : $uncheck;   ?>"  />
								   </li> 
								 </ul>
								 <ul class="security_panel" for="issues_close_to_heart">
								   <li class="list2 border-r">Issues close to heart</li>
								   
								   <li class="list2 border-r <?php echo ($security_data['pub_issues_close_to_heart'] == 1) ? 'yes' : 'no';   ?>">
								   	<img src="<?php echo ($security_data['pub_issues_close_to_heart'] == 1) ? $check : $uncheck;   ?>"  />
								   </li>
								   <li class="list2 <?php echo ($security_data['priv_issues_close_to_heart'] == 1) ? 'yes' : 'no';   ?>">
								   		<img src="<?php echo ($security_data['priv_issues_close_to_heart'] == 1) ? $check : $uncheck;   ?>"  />
								   </li> 
								 </ul>
								 <ul class="security_panel" for="education">
								   <li class="list2 border-r">Education </li>
								  
								   <li class="list2 border-r <?php echo ($security_data['pub_education'] == 1) ? 'yes' : 'no';   ?>">
								   	<img src="<?php echo ($security_data['pub_education'] == 1) ? $check : $uncheck;   ?>"  />
								   </li> 
								   <li class="list2 <?php echo ($security_data['priv_education'] == 1) ? 'yes' : 'no';   ?>">
								   		<img src="<?php echo ($security_data['priv_education'] == 1) ? $check : $uncheck;   ?>"  />
								   </li>
								 </ul>
								 <ul class="security_panel" for="profession">
								   <li class="list2 border-r">Profession </li>
								  
								   <li class="list2 border-r <?php echo ($security_data['pub_profession'] == 1) ? 'yes' : 'no';   ?>">
								   	<img src="<?php echo ($security_data['pub_profession'] == 1) ? $check : $uncheck;   ?>"  />
								   </li> 
								   <li class="list2 <?php echo ($security_data['priv_profession'] == 1) ? 'yes' : 'no';   ?>">
								   		<img src="<?php echo ($security_data['priv_profession'] == 1) ? $check : $uncheck;   ?>"  />
								   </li>
								 </ul>
								 <ul class="security_panel" for="career">
								   <li class="list2 border-r">Career </li>
								   
								   <li class="list2 border-r <?php echo ($security_data['pub_career'] == 1) ? 'yes' : 'no';   ?>">
								   	<img src="<?php echo ($security_data['pub_career'] == 1) ? $check : $uncheck;   ?>"  />
								   </li> 
								   <li class="list2 <?php echo ($security_data['priv_career'] == 1) ? 'yes' : 'no';   ?>">
								   		<img src="<?php echo ($security_data['priv_career'] == 1) ? $check : $uncheck;   ?>"  />
								   </li>
								 </ul>
								 <ul class="security_panel" for="hobbies">
								   <li class="list2 border-r">Hobbies </li>
								   
								   <li class="list2 border-r <?php echo ($security_data['pub_hobbies'] == 1) ? 'yes' : 'no';   ?>">
								   	<img src="<?php echo ($security_data['pub_hobbies'] == 1) ? $check : $uncheck;   ?>"  />
								   </li> 
								   <li class="list2 <?php echo ($security_data['priv_hobbies'] == 1) ? 'yes' : 'no';   ?>">
								   		<img src="<?php echo ($security_data['priv_hobbies'] == 1) ? $check : $uncheck;   ?>"  />
								   </li>
								 </ul>
								 <ul class="security_panel" for="interest">
								   <li class="list2 border-r">Interest </li>
								   
								   <li class="list2 border-r <?php echo ($security_data['pub_interest'] == 1) ? 'yes' : 'no';   ?>">
								   	<img src="<?php echo ($security_data['pub_interest'] == 1) ? $check : $uncheck;   ?>"  />
								   </li>
								   <li class="list2 <?php echo ($security_data['priv_interest'] == 1) ? 'yes' : 'no';   ?>">
								   		<img src="<?php echo ($security_data['priv_interest'] == 1) ? $check : $uncheck;   ?>"  />
								   </li>
								 </ul>
								 <ul class="security_panel" for="family">
								   <li class="list2 border-r">Family </li>
								  
								   <li class="list2 border-r <?php echo ($security_data['pub_family'] == 1) ? 'yes' : 'no';   ?>">
								   	<img src="<?php echo ($security_data['pub_family'] == 1) ? $check : $uncheck;   ?>"  />
								   </li>
								   <li class="list2 <?php echo ($security_data['priv_family'] == 1) ? 'yes' : 'no';   ?>">
								   		<img src="<?php echo ($security_data['priv_family'] == 1) ? $check : $uncheck;   ?>"  />
								   </li> 
								 </ul>
								 <ul class="security_panel" for="news_stream">
								   <li class="list2 border-r">News Stream</li>
								  
								   <li class="list2 border-r <?php echo ($security_data['pub_news_stream'] == 1) ? 'yes' : 'no';   ?>">
								   	<img src="<?php echo ($security_data['pub_news_stream'] == 1) ? $check : $uncheck;   ?>"  />
								   </li>
								   <li class="list2 <?php echo ($security_data['priv_news_stream'] == 1) ? 'yes' : 'no';   ?>">
								   		<img src="<?php echo ($security_data['priv_news_stream'] == 1) ? $check : $uncheck;   ?>"  />
								   </li>  
								 </ul>
								 <ul class="security_panel" for="photographs">
								   <li class="list2 border-r">Photographs</li>
								   
								   <li class="list2 border-r <?php echo ($security_data['pub_photographs'] == 1) ? 'yes' : 'no';   ?>">
								   	<img src="<?php echo ($security_data['pub_photographs'] == 1) ? $check : $uncheck;   ?>"  />
								   </li> 
								   <li class="list2 <?php echo ($security_data['priv_photographs'] == 1) ? 'yes' : 'no';   ?>">
								   		<img src="<?php echo ($security_data['priv_photographs'] == 1) ? $check : $uncheck;   ?>"  />
								   </li>
								 </ul>
								 <ul class="security_panel" for="movies">
								   <li class="list2 border-r">Videos</li>
								   
								   <li class="list2 border-r <?php echo ($security_data['pub_movies'] == 1) ? 'yes' : 'no';   ?>">
								   	<img src="<?php echo ($security_data['pub_movies'] == 1) ? $check : $uncheck;   ?>"  />
								   </li>
								   <li class="list2 <?php echo ($security_data['priv_movies'] == 1) ? 'yes' : 'no';   ?>">
								   		<img src="<?php echo ($security_data['priv_movies'] == 1) ? $check : $uncheck;   ?>"  />
								   </li> 
								 </ul>
								 <ul class="security_panel" for="contacts">
								   <li class="list2 border-r">Contacts</li>
								   
								   <li class="list2 border-r <?php echo ($security_data['pub_contacts'] == 1) ? 'yes' : 'no';   ?>">
								   	<img src="<?php echo ($security_data['pub_contacts'] == 1) ? $check : $uncheck;   ?>"  />
								   </li>
								   <li class="list2 <?php echo ($security_data['priv_contacts'] == 1) ? 'yes' : 'no';   ?>">
								   		<img src="<?php echo ($security_data['priv_contacts'] == 1) ? $check : $uncheck;   ?>"  />
								   </li> 
								 </ul>
								 <ul class="security_panel" for="i_Author">
								   <li class="list2 border-r">I, Author</li>
								   
								   <li class="list2 border-r <?php echo ($security_data['pub_i_Author'] == 1) ? 'yes' : 'no';   ?>">
								   	<img src="<?php echo ($security_data['pub_i_Author'] == 1) ? $check : $uncheck;   ?>"  />
								   </li>
								   <li class="list2 <?php echo ($security_data['priv_i_Author'] == 1) ? 'yes' : 'no';   ?>">
								   		<img src="<?php echo ($security_data['priv_i_Author'] == 1) ? $check : $uncheck;   ?>"  />
								   </li> 
								 </ul>
								 <!--<ul class="security_panel" for="recommend">
								   <li class="list2 border-r">Recommend</li>
								   
								   <li class="list2 border-r <?php echo ($security_data['pub_recommend'] == 1) ? 'yes' : 'no';   ?>">
								   	<img src="<?php echo ($security_data['pub_recommend'] == 1) ? $check : $uncheck;   ?>"  />
								   </li> 
								   <li class="list2 <?php echo ($security_data['priv_recommend'] == 1) ? 'yes' : 'no';   ?>">
								   		<img src="<?php echo ($security_data['priv_recommend'] == 1) ? $check : $uncheck;   ?>"  />
								   </li>
								 </ul>
								 <ul class="security_panel" for="my_premise">
								   <li class="list2 border-r">My Premise</li>
								   
								   <li class="list2 border-r <?php echo ($security_data['pub_my_premise'] == 1) ? 'yes' : 'no';   ?>">
								   	<img src="<?php echo ($security_data['pub_my_premise'] == 1) ? $check : $uncheck;   ?>"  />
								   </li> 
								   <li class="list2 <?php echo ($security_data['priv_my_premise'] == 1) ? 'yes' : 'no';   ?>">
								   		<img src="<?php echo ($security_data['priv_my_premise'] == 1) ? $check : $uncheck;   ?>"  />
								   </li>
								 </ul>-->
							   </div>
							</div>
							<!-- <a href="javascript:void(0);"><img class="searchBtn" style="float:left; padding:5px;" src="resource/images/update.jpg"> </a>	 -->
					        </div> 	
		</div>
		 
		<div id="contentRight">
		
		<?php include ('common/right_side_navigation.php');?>
		
		</div>

		<?php require_once 'common/footer1.php'; ?>