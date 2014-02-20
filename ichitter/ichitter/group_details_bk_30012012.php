<?php
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
$_SESSION['username'] = $user_id;
?>

<link href="resource/css/group_chats.css" rel="stylesheet" type="text/css">
<script src="resource/js/group_chats.js" type="text/javascript"></script>
<link type="text/css" rel="stylesheet" media="all" href="resource/css/chat.css" />
<script type="text/javascript" src="resource/js/jquery.js"></script>
<script type="text/javascript" src="resource/js/chat.js"></script>
<script>
function joingroup(){
var user_id = $("#user_id").val();
var user_id_join = $("#user_id_join").val();
var group_id = $("#group_id").val();
if(user_id != "" && user_id_join != "" && group_id != ""){
				$.ajax({
					type: "post",
					url: "join_group.php",
					data: "group_id=" + group_id + "&user_id_join=" + user_id_join + "&user_id=" + user_id,
					error: function() {
					},
					success: function (data) {
						var json = $.parseJSON(data);
						var res= json.success;
						if(res == "success"){
						  $("#join").html("");
						  $("#join").html("You have joined successfully!");
						  $("#chatdiv").css("display","block");
						}else{
						  $("#join").hide();
						}
					}
				});
}
return false;
}

$(document).ready(function(){
	//If user Clicks to remove user
	$(".Delete_user").click(function(){
		var user_id_to_delete = this.id;
		var groupid = $("#grp_id_chat").val();

      if(groupid != "" && user_id_to_delete != ""){
		$.post("delete_group_process.php", { group_id: groupid, user_id: user_id_to_delete},
		   function(data) {
						if(data == '{"success":"success"}'){
						var loc = location.href;
                        var urlString = String(window.location);
                        var pieces = urlString.split('&');
						var urlStrings = String(pieces[0]);							
						loca = urlStrings + "&msg=memberdelSucss";
                        //location.reload(true);			
						window.location.href=loca;	
						}
		});
      }
		return false;
	});
	
	//If user Clicks to Activate user
	$(".Activate_user").click(function(){
		var user_id_to_delete = this.id;
		var groupid = $("#grp_id_chat").val();

      if(groupid != "" && user_id_to_delete != ""){
		$.post("activate_user_process.php", { group_id: groupid, user_id: user_id_to_delete},
		   function(data) {
						if(data == '{"success":"success"}'){
						var loc = location.href;
                        var urlString = String(window.location);
                        var pieces = urlString.split('&');
						var urlStrings = String(pieces[0]);									
						loca = urlStrings + "&msg=memberactSucss";
                        //location.reload(true);			
						window.location.href=loca;	
						}
		});
      }
		return false;
	});	
});

</script>
		<input type="hidden" id="service_name_hidden" value="<?php echo SERVICE_NAME; ?>">
		<div id="contentLeft">
			<div id="profPhoto"><img width="86" height="106" src="<?php echo $profile_img; ?>" /><br /><?php echo $user_name; ?></div>
			<div id="groupsContainlayer"><?php	require_once('lib/group_all_header_include.php'); ?></div>
		<div class="line"></div>
		  <div id="leftmenulist">
			<?php include ('common/side_navigation.php');?>
		  </div>
<?php
								$user_id = $_SESSION['login']['user_id'];
								$grp_id = $_REQUEST['grpid'];
								$url = SERVICE_NAME . "class.group_service.php";
								$url_path = SERVICE_NAME;
								$ch = curl_init();
								curl_setopt($ch, CURLOPT_HEADER, 0);
								curl_setopt($ch, CURLOPT_VERBOSE, 0);
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
								curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");
								curl_setopt($ch, CURLOPT_POST, true);
								curl_setopt($ch, CURLOPT_URL, $url );
								$post_array = array(
									"get_groups_detail" => "get_groups_detail",
									"user_id"=>$user_id,
									"group_id"=>$grp_id
								);
								curl_setopt($ch, CURLOPT_POSTFIELDS, $post_array);
								$response = curl_exec($ch);

								$obj = $ObjJSON->decode($response);
								$erro = $obj->{"error"};
								$erross = $obj->{"error"};								
								if($erro != "error"){
								$group_name = $obj->{"group_name"};
								$whoweare = $obj->{"whoweare"};
								$isay = $obj->{"isay"};
								$group_owner_user_id = $obj->{"user_id"};
								}
?>
							<input type="hidden" name="user_id_chat" id="user_id_chat" value="<?php echo $user_id; ?>">
							<input type="hidden" name="grp_id_chat" id="grp_id_chat" value="<?php echo $grp_id; ?>">
						<?php
						   if($_GET['msg']){
						    $msg = $_GET['msg'];
							switch ($msg)
							{
							case "memberdelSucss":
							  $message = "Group member deleted successfully";
							  break;
							case "memberactSucss":
							  $message = "Group member activated successfully";
							  break;							  
							}
						?>
								<div style="margin-left:15px;" class="ucipublishedtxt margintop10">
										<h1>Message : <?php echo $message; ?></h1>
								</div>
                    <?php } ?>								
							<div class="republicans">						
							<div class="republicanscont" style="margin-bottom:10px;">
							   <?php
    							   echo $group_name;
								if($group_owner_user_id != $user_id){
							   ?>

							   <form name="join" action="" method="post" style="float:right;">
							   <div id="join" style="float:right;" style="margin-bottom:10px;">
							    <input type="hidden" name="user_id_join" id="user_id_join" value="<?php echo $user_id; ?>">
								<input type="hidden" name="user_id" id="user_id" value="<?php echo $group_owner_user_id; ?>">
								<input type="hidden" name="group_id" id="group_id" value="<?php echo $grp_id; ?>">
							   <?php
							    if($erro == "already joined"){
								 echo "Already joined";
								}else{
							   ?>
							     <a onclick="return joingroup();" href="javascript:;">
								   <img src="resource/images/join.png">
								 </a>
							   <?php
							    }
							   ?>
							   </div>
							   </form>
							   <?php
							    }
							   ?>
							</div>
							<div class="republicanshead"><h1>Who We Are</h1>
							 <div class="rep-bigbox">
							  <p><?php echo $whoweare; ?></p>
							  </div>
							</div>


					        </div>
							<div class="republicanssmall">
									<div class="republicansheadsmall"><h1>I say</h1>
							 <div class="rep-smallbox">
							  <p><?php echo $isay; ?></p>
							  </div>
							</div>
					        </div>
							<div class="republicanssmall">
							<div class="republicansheadsmall">
							  <div style="width:200px;float:left;"><h1>Chat Area</h1></div>
							   <?php
								$ch = curl_init();
								curl_setopt($ch, CURLOPT_HEADER, 0);
								curl_setopt($ch, CURLOPT_VERBOSE, 0);
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
								curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");
								curl_setopt($ch, CURLOPT_POST, true);
								curl_setopt($ch, CURLOPT_URL, $url );
								$post_array = array(
									"get_chat" => "get_chat",
									"user_id"=>$user_id,
									"group_id"=>$grp_id
								);
								curl_setopt($ch, CURLOPT_POSTFIELDS, $post_array);
								$response = curl_exec($ch);
								$obj = $ObjJSON->decode($response);
								$erro = $obj->{"success"};
								$owner_id = $obj->{"owner_id"};				
								$owner_name = $obj->{"owner_name"};				
								$ud = $erro->{'uid'};
							    if($erross == "already joined"){
								  $key = array_search($user_id, $erro->{'uid'}); 
								  $activ = $erro->{'is_active'};
								 if($activ[$key] == 1){
								  $styles = "display:block";
								 }else{
								  $styles = "display:none";
								 }
							    }else{
								    if(($group_owner_user_id == $user_id) && (count($ud) > 0)){
								      $styles = "display:block";
                                    }else{
                                      $styles = "display:none";
                                    }
                                }
							   ?>
							  <div id="chatdiv" style='float:right;padding: 5px 8px 0 8px;<?php echo $styles; ?>'>
							    <a href="javascript:;" id="openchat">Chat</a>
						      </div>
							  <div class="rep-smallbox">
<?php

								if($erro != "error"){
								 $uid = $erro->{'uid'};
								 $uname = $erro->{'uname'};
								 $grp_id = $erro->{'gid'};
								 $is_active = $erro->{'is_active'};								 
								 $status = $erro->{'sts'};
									 echo "<input type='hidden' id='udetails_".$owner_id."' value='$owner_name'>";
                                  for($i=0;$i<count($uname);$i++){
								     $user_names = ucwords($uname[$i]);
									 echo "<input type='hidden' id='udetails_".$uid[$i]."' value='$user_names'>";
								    if($group_owner_user_id == $user_id){
									    $chatIcon = "<a  title='Chat' class='chat_user' href='javascript:void(0)' onclick=\"javascript:chatWith('".$uid[$i]."',0)\" style='text-decoration:none;color:#888888;padding-right:10px;float:left;'><img src='resource/images/chat-icon.jpg' width='16' height='16' alt='Chat'></a>";
										if($is_active[$i] == 0){
										 $dlUser = "<a title='Make Active' class='Activate_user' id='".$uid[$i]."' href='javascript:;'><img src='resource/images/activate.jpg' width='16' height='16' alt='Make Inactive'></a>";
										}else{
										 $dlUser = "<a title='Make Inactive' class='Delete_user' id='".$uid[$i]."' href='javascript:;'><img src='resource/images/deactivate.jpg' width='16' height='16' alt='Make Active'></a>";																				 
										} 
									}else{
									   if($uid[$i] == $user_id){
									    $chatIcon = "";
									   }else{
									    $chatIcon = "<a title='Chat' class='chat_user' href='javascript:void(0)' onclick=\"javascript:chatWith('".$uid[$i]."',0)\" style='text-decoration:none;color:#888888;padding-right:10px;'><img src='resource/images/chat-icon.jpg' width='16' height='16' alt='Chat'></a>";
										}
									    $dlUser = "";
									}
									$activity = $is_active[$i];
									if($activity == 0){
									 $class = " style='color:#A5A5A5'";			
									    //$dlUser = "";
									    $chatIcon = "";										
									}else{
									 $class = " id='chatareas'";
									}
									if($status[$i] == 'Online'){
									  if($activity == 0){
									   $imgsts = "<img src='resource/images/inactive.png' height='16' width='16' alt='Inactive'>";
									  }else{
									   $imgsts = "<img src='resource/images/online.png' height='16' width='16' alt='Online'>";
									  } 
									}else{
									  $chatIcon = "";
									  if($activity == 0){
									   $imgsts = "<img src='resource/images/inactive.png' height='16' width='16' alt='Inactive'>";
									  }else{
									   $imgsts = "<img src='resource/images/offline.png' height='16' width='16' alt='Offline'>";
									  } 
									}
									 echo "<p $class><span><span>$imgsts </span><span style='vertical-align: top;'>$user_names</span></span><span style='float:right;clear:both;'>$chatIcon $dlUser</span></p>";
								  }
								}else{
								     echo "<p>No user joined</p>";
								}
?>	    					  </div>
							</div>
					        </div>
							<div class="republicanssmall">
									<div class="republicansheadsmall"><h1>Black Board/Calendar</h1>
							 <div class="rep-smallbox">
							  <p>content coming soon</p>
							   <p>content coming soon</p>
							  </div>
							</div>
					        </div>

							<div class="republicanssmall">
									<div class="republicansheadsmall"><h1>Published by members</h1>
							 <div class="rep-smallbox">
<?php
								$ch = curl_init();
								curl_setopt($ch, CURLOPT_HEADER, 0);
								curl_setopt($ch, CURLOPT_VERBOSE, 0);
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
								curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");
								curl_setopt($ch, CURLOPT_POST, true);
								curl_setopt($ch, CURLOPT_URL, $url );
								$post_array = array(
									"get_postings_published" => "get_postings_published",
									"user_id"=>$user_id,
									"group_id"=>$_REQUEST['grpid']
								);
								curl_setopt($ch, CURLOPT_POSTFIELDS, $post_array);
								$response = curl_exec($ch);
								$obj = $ObjJSON->decode($response);
								$error_pub = $obj->{"success"};		
								if($error_pub != "error"){
								$resp_array = $ObjJSON->objectToArray($error_pub);
                                for($i=0;$i<count($resp_array['title']);$i++){
								   $title = strlen($resp_array['title'][$i]);
								   if($title > 70){
								   $rest = substr($resp_array['title'][$i], 0,70)."..";
								   }else{
								   $rest = $resp_array['title'][$i];
								   }		
								   $urlforLink = "http://tsg.emantras.com/dev%5Fichitter/fp/discussion.php?topicid=".$resp_array['topic_id'][$i]."&subtopicid=".$resp_array['sub_topic_id'][$i]."&postid=".$resp_array['posting_id'][$i];						   
								  echo "<p style='padding-bottom:5px;'><a target='_blank' style=\"color:#066193;text-decoration:none;\" href='$urlforLink'>$rest</a></p>";
								}
								}else{
								 echo "<p>No Postings Yet!</p>";
								}
?>							 
<!--							  <p>content coming soon</p>
							   <p>content coming soon</p> -->
							  </div>
							</div>
					        </div>





		</div>

		<div id="contentRight">

		<?php include ('common/right_side_navigation.php');?>

		</div>
							<!-- Chat Window HTML Start -->
							<div id="wrapperChat">
								<div id="menu">
									<p class="welcome"><b><?php echo $user_name; ?></b></p>
									<p class="logout"><a id="exit" href="javascript:;"><b>X</b></a></p>
									<div style="clear:both"></div>
								</div>
								<div id="chatbox">
									<?php
										if(file_exists("log.html") && filesize("log.html") > 0){
											$handle = fopen("log.html", "r");
											$contents = fread($handle, filesize("log.html"));
											fclose($handle);

											echo $contents;
										}
									?>
								</div>
								<form name="message" action="">
									<input name="usermsg" type="text" id="usermsg" size="150" autocomplete="off" />
									<input name="submitmsg" type="submit"  id="submitmsg" value="Send" />
								</form>
							</div>
							<!-- Chat Window HTML END -->												
			<?php require_once 'common/footer1.php'; ?>