<?php
error_reporting(0);
require_once('lib/include_files.php');
require_once('lib/profile_photo_include.php');
	$session_obj = new SESSION();
	if(isset($_REQUEST['logout']) && $_REQUEST['logout'] == 'OK'){
		$session_obj->unset_Session('login');
		header('location:index.php');
	}
	if(trim($_SESSION['login']['user_id']) == ''){
		header('location:index.php');
	}
	
require_once 'common/header1.php';
$user_id = $_SESSION['login']['user_id'];
		?>
<link rel="stylesheet" href="resource/css/master.css" type="text/css" />
<script type="text/javascript" src="resource/js/group_popup.js"></script>		
		<div id="contentLeft">
			<div id="profPhoto"><img width="86" height="106" src="<?php echo $profile_img; ?>" /><br /><?php echo $user_name; ?></div>
		<div id="groupsContainlayer"><?php	require_once('lib/group_all_header_include.php');  ?></div>
<div class="line"></div>
		   <div id="leftmenulist">	
							<?php include ('common/side_navigation.php');?>
							</div>		
							<div id="mainupload">	
							<div class="posting" style="margin-bottom:10px;">My Groups</div>
							<div style="float:right;" style="margin-bottom:10px;"><a class="modal" href="javascript:;"><img src="resource/images/create-group.png"></a></div>
							

<?php
								$user_id = $_SESSION['login']['user_id'];
								$url = SERVICE_NAME . "class.group_service.php";
								$url_path = SERVICE_NAME;

								$curl_data = array('get_groups_user_or_joined' => 'get_groups', 'user_id' => $user_id);
								$curl_data+=$REQ_SEND;
								$curl_call = new INIT_PROCESS(CLASS_GROUP_SERVICE, $curl_data);
								$response = $curl_call->response;

								//$obj = json_decode($response);
								$obj = $ObjJSON->decode($response);
								$array = $obj->{"success"};
                            if($array != "error"){
								$grpnm = $array->{"gname"};
								$grpid = $array->{"gid"};
								$usrJoincnt = $array->{"user_joined_count"};												
						
								for($i=0;$i<count($grpnm);$i++){
?>
								<div class="ucipublishedhd">
									<h1><a href="group_details.php?grpid=<?php echo $grpid[$i]; ?>"><?php echo $grpnm[$i]; ?></a></h1>
									<div id="rightheader"><?php echo $usrJoincnt[$i] ?> Members</div>
								</div>
								<div class="ucipublishedtxt">
<?php
								$gidofI	= $grpid[$i];	
								$posting_id = $ObjJSON->objectToArray($array->{"posting_id"});									
								$user_id_fetched = $ObjJSON->objectToArray($array->{"user_id"});							
								$topic_id = $ObjJSON->objectToArray($array->{"topic_id"});	
								$sub_topic_id = $ObjJSON->objectToArray($array->{"sub_topic_id"});			
								$title = $ObjJSON->objectToArray($array->{"title"});			
								$post_content = $ObjJSON->objectToArray($array->{"post_content"});		
								$posted_on = $ObjJSON->objectToArray($array->{"posted_on"});
							if(count($posting_id[$gidofI]) > 0){
								for($h=0;$h<count($posting_id[$gidofI]);$h++){
								 for($r=0;$r<count($posting_id[$gidofI][$h]);$r++){
								   $timeanddate = date("F j, Y, g:i a", strtotime($posted_on[$gidofI][$h][$r]));      
								   $strle = strlen($post_content[$gidofI][$h][$r]);
								   if($strle > 150){
								   $rest = substr($post_content[$gidofI][$h][$r], 0,150)."..";
								   }else{
								   $rest = $post_content[$gidofI][$h][$r];
								   }
								   $urlforLink = "http://tsg.emantras.com/dev%5Fichitter/fp/discussion.php?topicid=".$topic_id[$gidofI][$h][$r]."&subtopicid=".$sub_topic_id[$gidofI][$h][$r]."&postid=".$posting_id[$gidofI][$h][$r];
?>								    
									<h1><span><a target="_blank" style="color:#066193;text-decoration:none;" href="<?php echo $urlforLink; ?>"><?php echo ucwords($user_id_fetched[$gidofI][$h][$r]); ?></a>,</span> <?php echo $timeanddate; ?></h1>
									<p><?php echo $rest; ?></p><div id="line" align="center"><img src="resource/images/line.jpg" /></div>
<?php
								 }
								}
							}else{
							       echo '<p>No Postings Yet!</p><div id="line" align="center"><img src="resource/images/line.jpg" /></div>';
							}	
?>									
								</div>									
<?php
								}
							}else{
?>
								<div class="ucipublishedhd">
									<h1>No Groups Created</h1>
								</div>
<?php							
							}	
?>						
							</div>
		</div>
		<div id="contact">
			<div id="close"></div>

			<div id="contact_header">Create Group</div>
			<p class="success">Success! your group has been created</p>

		  <form action="create_group_process.php" method="post" name="contactForm" id="contactForm">
		  <p><input name="name" id="name" type="text" size="30" value="Group Name" /></p>
			<p><textarea name="WhoWeAre" id="WhoWeAre" rows="5" cols="40">Who We Are</textarea></p>
			<p><textarea name="Isay" id="Isay" rows="5" cols="40">I say</textarea></p>			
			<input type="hidden" id="user_id" value="<?php echo $user_id; ?>">
		  <p><input type="submit" id="submit" name="submit" value="Create" /></p>
		 </form>
		</div>

		<div id="mask"></div>
		<div id="contentRight">
		
		<?php include ('common/right_side_navigation.php');?>
		
		</div>
		

			<?php require_once 'common/footer1.php'; ?>	