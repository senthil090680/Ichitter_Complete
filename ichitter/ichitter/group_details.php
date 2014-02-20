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
//$_SESSION['username'] = $user_id;

?>

<link href="resource/css/group_chats.css" rel="stylesheet" type="text/css">
<script src="resource/js/group_chats.js" type="text/javascript"></script>
<link type="text/css" rel="stylesheet" media="all" href="resource/css/chat.css" />
<!--<script type="text/javascript" src="resource/js/jquery.js"></script>-->
<script type="text/javascript" src="resource/js/chat_grp.js"></script>
<!-- calander by noor -->
<link href="resource/css/core.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="resource/css/master.css" type="text/css" />
<script type="text/javascript" src="resource/js/group_popup.js"></script>	
<!-- end -->

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
		<div id="contentLeft">
			<div id="profPhoto"><img width="86" height="106" src="<?php echo $profile_img; ?>" /><br /><?php echo $user_name; ?></div>
			<div id="groupsContainlayer"><?php	//require_once('lib/group_all_header_include.php'); 
			require_once('lib/group_header_include.php'); ?></div>
		<div class="line"></div>
		  <div id="leftmenulist">
			<?php include ('common/side_navigation.php');?>
		  </div>
<?php
								//$user_id = $_SESSION['login']['user_id'];
								$grp_id = $_REQUEST['grpid'];
								$url = SERVICE_NAME . "class.group_service.php";
								$url_path = SERVICE_NAME;
								/*$ch = curl_init();
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
								$response = curl_exec($ch);*/

								$curl_data = array(
									"get_groups_detail" => "get_groups_detail",
									"user_id"=>$user_id,
									"group_id"=>$grp_id );
								$curl_data+=$REQ_SEND;
								$curl_call = new INIT_PROCESS(CLASS_GROUP_SERVICE, $curl_data);
								$response = $curl_call->response;

								$obj = $ObjJSON->decode($response);
								/*echo '<pre />';
								print_r($obj);*/
								$events = $obj->events;
								
								$obj_user_id = $obj->user_id;
								$erro = $obj->{"error"};
								$erross = $obj->{"error"};								
								if($erro != "error"){
								$group_name = $obj->{"group_name"};
								$whoweare = $obj->{"whoweare"};
								$isay = $obj->{"isay"};
								$group_owner_user_id = $obj->{"user_id"};				
								}
?>
							<input type="hidden" name="grp_id_chat" id="grp_id_chat" value="<?php echo $grp_id; ?>">
						<?php
						   if($_GET['msg']){
						    $msg = $_GET['msg'];
							switch ($msg)
							{
							case "memberdelSucss":
							  $message = "Group member inactivated successfully";
							  break;
							case "memberactSucss":
							  $message = "Group member activated successfully";
							  break;							  
							}
						?>
								<div style="margin-left:15px;" class="ucipublishedtxt margintop10">
										<h1>Message : <?php echo $message; ?></h1>
								</div>
                    <?php }  if ($erro != "already joined") {
		     			include('lib/group_all_display.php');
 }
?>								
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
							  <div style="width:130px;float:left;"><h1>Chat Area</h1></div>
							   <?php
								/*$ch = curl_init();
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
								$response = curl_exec($ch);*/

								$curl_data = array(
									"get_chat" => "get_chat",
									"user_id"=>$user_id,
									"group_id"=>$grp_id );
								$curl_data+=$REQ_SEND;
								$curl_call = new INIT_PROCESS(CLASS_GROUP_SERVICE, $curl_data);
								$response = $curl_call->response;

								$obj = $ObjJSON->decode($response);
								$erro = $obj->{"success"};
								$owner_id = $obj->{"owner_id"};				
								$owner_name = $obj->{"owner_name"};				
								$ud = $erro->{'uid'};
							    if($erross == "already joined"){
								  $key = array_search($user_id, $erro->{'uid'}); 
								  $activ = $erro->{'is_active'};

								 if($activ[$key] == 1){
								  $styles		=	 "display:block";
								  $access_type	=	'Group Chat';
								  $openchatid	=	'openchat';
								 }else{
								  $styles = "display:block";
								  $access_type = 'Access Denied';
								  $openchatid	=	'openchat1';
								 }
							    }else{
								    if(($group_owner_user_id == $user_id) && (count($ud) > 0)){
								      $styles = "display:block";
									  $access_type = 'Group Chat';
									  $openchatid	=	'openchat';
                                    }else{
                                      $styles = "display:none";
                                    }
                                }
							   ?>
							  <div id="chatdiv" style='float:right;padding: 5px 8px 0 8px;<?php echo $styles; ?>'>
							    <a href="javascript:;" id='<?php echo $openchatid; ?>'><?php echo $access_type; ?></a>
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
									
									for($k=0;$k<count($uname);$k++){
										if($uid[$k] == $user_id) {
											$loginactivestatus = $is_active[$k];
										}
									}
									if($group_owner_user_id == $user_id){
										if($uid[$i] != $user_id) {									
											$chatIcon = "<a title='Chat' class='chat_user' href='javascript:void(0)' onclick=\"javascript:chatWith('".$uid[$i]."')\"		style='text-decoration:none;color:#888888;padding-right:10px;float:left;'><img src='resource/images/chat-icon.jpg' width='16' height='16' alt='Chat'></a>";
										} else {
											$chatIcon = "";
										}
										if($is_active[$i] == 0){		
										 $dlUser = "<a title='Make Active' class='Activate_user' id='".$uid[$i]."' href='javascript:;'><img src='resource/images/activate.jpg' width='16' height='16' alt='Make Inactive'></a>";
										}else{											
										 $dlUser = "<a title='Make Inactive' class='Delete_user' id='".$uid[$i]."' href='javascript:;'><img src='resource/images/deactivate.jpg' width='16' height='16' alt='Make Active'></a>";									
										}
										if($uid[$i] == $user_id){
											$dlUser = "";
										}

									}else{
									   if($uid[$i] == $user_id){
									    $chatIcon = "";
									   }else{
									    $chatIcon = "<a title='Chat' class='chat_user' href='javascript:void(0)' onclick=\"javascript:chatWith('".$uid[$i]."')\" style='text-decoration:none;color:#888888;padding-right:10px;'><img src='resource/images/chat-icon.jpg' width='16' height='16' alt='Chat'></a>";
										}
									    $dlUser = "";
									}

									$activity = $is_active[$i];
									if($activity == 0){
									 $class = " style='color:#A5A5A5'";			
									    //$dlUser = "";
									    $chatIcon = "<img src='resource/images/inact-chat-icon.jpg' width='16' height='16' alt='Chat' />&nbsp;";										
									}else{
									 $class = " id='chatareas'";
									}

									//echo $status[$i].$uid[$i];
									if($status[$i] == 'Online'){
										
									  if($activity == 0){
									   $imgsts = "<img src='resource/images/inactive.png' height='16' width='16' alt='Inactive'>";
									  }else{
									   $imgsts = "<img src='resource/images/online.png' height='16' width='16' alt='Online'>";
									  } 
									}else{
									  $chatIcon = "<img src='resource/images/inact-chat-icon.jpg' width='16' height='16' alt='Chat' />&nbsp;";
									  if($activity == 0){
									   $imgsts = "<img src='resource/images/inactive.png' height='16' width='16' alt='Inactive'>";
									  }else{
									   $imgsts = "<img src='resource/images/offline.png' height='16' width='16' alt='Offline'>";
									  } 
									}

									if($loginactivestatus == 0) {
										$imgsts = "<img src='resource/images/inactive.png' height='16' width='16' alt='Inactive'>";
										$class = " style='color:#A5A5A5'";
										
										if($uid[$i] != $user_id){
											$chatIcon = "<img src='resource/images/inact-chat-icon.jpg' width='16' height='16' alt='Chat' />&nbsp;";
										} else {
											$chatIcon = "";
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
							<?php if($group_owner_user_id == $user_id || isset($erross)){ ?>
							<div class="republicanssmall">
									<div class="republicansheadsmall"><h1>Black Board/Calendar</h1>
							 <div class="rep-smallbox">
							   <div id="jMonthCalendar"></div>
							  </div>
							</div>
					        </div>
							<?php } ?>
							<div class="republicanssmall">
									<div class="republicansheadsmall"><h1>Published by members</h1>
							 <div class="rep-smallbox">
<?php
								/*$ch = curl_init();
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
								$response = curl_exec($ch);*/

								$curl_data = array(
									"get_postings_published" => "get_postings_published",
									"user_id"=>$user_id,
									"group_id"=>$_REQUEST['grpid'] );
								$curl_data+=$REQ_SEND;
								$curl_call = new INIT_PROCESS(CLASS_GROUP_SERVICE, $curl_data);
								$response = $curl_call->response;

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
								   $urlforLink = "../fp/discussion.php?topicid=".$resp_array['topic_id'][$i]."&subtopicid=".$resp_array['sub_topic_id'][$i]."&postid=".$resp_array['posting_id'][$i];						   
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


<div style="clear: both"   ></div>
    
<?php if($group_owner_user_id == $user_id || isset($erross)){ ?>
<div id="clander_details">

        <div style="background-color: #DBEBFC;padding: 3px;">
            <?php if ($obj_user_id == SESS_USER_ID || (count($events) && $erro = 'already joined')) { ?>
            <div style="margin-left: 15px;float:left">
                <input type="checkbox" onclick="$('input[type*=\'checkbox\']').attr('checked', this.checked);">
</div>      <?php } ?>
            <div style="float: left;font-size: 16px;font-weight: bold;color: #3D86C3;margin-left: 10px;">All Calander Events</div>
            <?php if ($obj_user_id == SESS_USER_ID || (count($events) && $erro = 'already joined')) { ?>
                <div style="float: right;">
                    <span class="caltxtrigh" id="cal_add" ><img src="resource/images/add-event.png" /></span>
                    <span class="caltxtrigh" id="cal_delete" ><img src="resource/images/delete.png" /></span>
                </div>
            <?php } ?>
            <div style="clear:both"></div>
        </div>
    
            <form id="day_event_list">


                <?php if (count($events)) {
                    foreach ($events as $k => $e) { ?>


                        <ul class="Messagechat caltxtrigh">
                            <li>                                        
                                <?php if ($e->event_user_id == SESS_USER_ID || $obj_user_id == SESS_USER_ID) { ?>
                                    <div style="float: left">
                                        <input type="checkbox" value="<?php echo $e->event_id; ?>" name="cal_list_<?php echo $k; ?>" />
                                    </div>
                                <?php }else{ ?>
                            <div style="float: left;width: 20px;border: 1px solid #F8FBFE"></div>
                            <?php } ?>
                                <div style="float: left;margin-left: 10px;width: 420px;">
                                    <div style="float: left">
                                <p class="event_title" style="float: left;"><?php echo $e->event_title; ?></p>
                                <p class="event_desc" style="float: left;"><?php echo $e->event_description; ?></p>
                                </div>
                                <p class="event_date">
                                Created by:<br />
                                <?php echo ($e->priv_name) ? $e->name : $e->email; ?>  
                                <br />
                                <?php echo $e->event_date; ?></p>
                                </div>
                                <?php if ($e->event_user_id == SESS_USER_ID) { ?>
                                    <div style="float: right;cursor: pointer" class="caltxtrigh" onclick="event_edit(this)"><img src="resource/images/edit.png" /></div>
                                <?php } else{ ?>
                            <div style="float: left;width: 20px;border: 1px solid #F8FBFE"></div>
                            <?php } ?>
                            </li>

                            <div style="clear:both"></div>
                        </ul>



                    <?php }
                } else { ?>
                <ul class="Messagechat">
                    <li>No Record(s) found</li>
                </ul>
                <?php } ?>



            </form>
        

        <div style="clear: both"></div>
    </div>
	<?php } ?>
		</div>


		<div id="contentRight">

		<?php include ('common/right_side_navigation.php');?>

		</div>
							<!-- Chat Window HTML Start -->
							<!--<div id="wrapperChat">
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
							</div>-->
							<!-- Chat Window HTML END -->	
<!-- calander by noor -->							
<div id="contact">
    <div id="close"></div>

    <div id="contact_header">Create Event</div>
    <p class="success">Success! your group has been created</p>

    <form action="create_group_process.php" method="post" name="contactForm" id="contactForm">
        <p><input name="event_title" id="event_title" type="text" size="30" value="Event Title" /></p>
        <p><input name="event_date" id="event_date" type="text" disabled="disable" size="30" value="" /><input name="event_date" type="hidden" size="30" value="" /></p>
        <p><textarea name="event_description" id="event_description" rows="5" cols="40">Event Description</textarea></p>

        <input type="hidden" name="group_id" id="group_id" value="<?php echo $_REQUEST['grpid']; ?>">
        <p><input type="submit" id="submit" name="submit" value="Create" /></p>
        <input type="hidden" id="cal_action" name="action" value="" />
		<input type="hidden" id="event_user_id" name="event_user_id" value="<?php echo SESS_USER_ID; ?>" />
    </form>
</div>

<div id="mask"></div>
<input type="hidden" value="" id="seldate" />
<script type="text/javascript">
    var events = [ 	
<?php

foreach ($events as $e) {

    $e = (array) $e;
    $date = explode(' ', $e['event_date']);
    if($obj_user_id == SESS_USER_ID && $e['event_user_id'] == SESS_USER_ID){
        $show_rel = 'created_user';
    }elseif($obj_user_id == SESS_USER_ID){
        $show_rel = 'owner';
    }elseif($e['event_user_id'] == SESS_USER_ID){
        $show_rel = 'user';
    }else{
        $show_rel = '';
    }
	
	$eve_user_name = ($e['priv_name']) ? $e['name'] : $e['email'];
	
    ?>
                    { "EventID": <?php echo $e['event_id']; ?>, "StartDateTime": "<?php echo $date[0]; ?>", "Title": "<?php echo $e['event_title']; ?>", "URL": "javascript:void(0)", "Description": "<?php echo $e['event_description']; ?>", "CssClass": "Meeting","show_rel":"<?php echo $show_rel; ?>","event_user":"<?php echo $eve_user_name; ?>" }
                    ,<?php } ?>
            ];
    $(document).ready(function() {   
        
        
        var currentDate = ''
        var options = {
            height: 138,
            width: 256,
            navHeight: 25,
            labelHeight: 25,
		
            onDayLinkClick: function(date,whr) {
                var fullDate = date;
                var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : '0' + (fullDate.getMonth()+1);
                currentDate = fullDate.getFullYear() + "-" + twoDigitMonth + "-" + fullDate.getDate();
                var seldate = twoDigitMonth + "/" + fullDate.getDate() + "/" + fullDate.getFullYear();              
               
                $('#seldate').val(seldate);               
                $('#event_date,[name=event_date]').val(currentDate);
                   
               
                //return true;
                //alert($(whr).html()); 
                cal_list($(whr));
                
            }
		
        };
			
			

            
            //console.log(events);
          
			
            $.jMonthCalendar.Initialize(options, events);
          
        
            if($(this).find('div').hasClass('Event')){
                $(this).find('div.Event').parent().append('<div class="indicate" style="width:1px;height:1px;border:1px solid red"></div>');
            }
            
            $('#cal_add').click(function(){
                 
               
                if($.trim($('#seldate').val()) == ''){
                    alert('Please choose date');
                }else{
                    
                    if(Validate(currentDate)){
                        $('#cal_action').val('create_event');
                        popup();                        
                    }else{
                        $('#seldate').val('');               
                    }
                }
            });
            
            $('#cal_delete').click(function(){
                if($('#day_event_list [type=checkbox]:checked').length){
                    var url = 'calander_process.php';
                    var data = $('#day_event_list').serialize();
                    var r = ajax_function(url,data);
                    if(JSON.parse(r).success){
                        $('#day_event_list [type=checkbox]:checked').each(function(){
                            jQuery.J.removeEvent_list($(this).parent().next().find('.event_date').text());
                            var t = $('#Event_'+$(this).val());
                            if(t.parent().find('.Event').length == 1){
                                t.parent().find('.indicate').remove();
                            }
                            $('#Event_'+$(this).val()).remove();                           
                            $(this).closest('ul').remove();
                        });

                        if(!$('#day_event_list ul').length){
                            c = '<ul class="Messagechat noevents"><li style="text-align:center">No Record(s) found</li></ul>';
                            $('#day_event_list').append(c);
                    }
                        $('#master').attr('checked','');
                    }
                }else{
                    alert('Please select atleast one event');
                    return false;
                }
            });
        });
                
        function cal_list(whr){
            $('#day_event_list ul').remove();
            whr = whr.closest('td');
            if(whr.find('div').hasClass('Event')){
                var c = '';
                whr.find('div.Event').each(function(i){
                    var rel = $.trim($(this).attr('rel'));
                    var s = $(this).attr('id').split('_');
                   
                    c = '<ul class="Messagechat caltxtrigh">';
                    var d = $('#seldate').val().split('/');
                    d = d[2]+'-'+d[0]+'-'+d[1];
                    
                    c += '<li><div style="float: left">';
                    if(rel == 'user' || rel == 'created_user' || rel == 'owner'){
                    c += '<input type="checkbox" value="'+s[1]+'" name="cal_list_0" />';
                    }else{
                    c += '<div style="float: right;width: 20px;border: 1px solid #F8FBFE"></div>';
                    }
                    c += '</div><div style="float: left;margin-left: 10px;width: 420px;"><p style="float: left;" class="event_title">'+$(this).find('a').text()+'</p><p class="event_date">Created by:<br />'+$(this).find('a').attr('class')+'<br />'+d+'</p><p style="" class="event_desc">'+$(this).find('a').attr('rel')+'</p></div>';
                    
if(rel == 'user' || rel == 'created_user'){
                                        c +=   '<div onclick="event_edit(this)" class="caltxtrigh" style="float: right"><img src="resource/images/edit.png" /></div>';
}else{
                    c += '<div style="float: right;width: 20px;border: 1px solid #F8FBFE"></div>';
                    }
                    
                                 c += '</li><div style="clear:both"></div></ul>';
                                 $('#day_event_list').append(c);
            });
                            
        }else{
                             c = '<ul class="Messagechat noevents"><li style="text-align:center">No Record(s) found</li></ul>';
                             $('#day_event_list').append(c);
        }
    }
        
    function event_edit(whr){ 
        $(whr).prev().find('.event_title').html('<input id="e_title" name="event_title" type="text" value="'+$(whr).prev().find('.event_title').text()+'" />');
        $(whr).prev().find('.event_desc').html('<textarea id="e_description" name="event_description">'+$(whr).prev().find('.event_desc').text()+'</textarea>');
        $(whr).before('<div class="caltxtrigh event_btns" style="cursor:pointer" onclick="event_save(this)"><img src="resource/images/save.png" /></div><div class="event_btns" onclick="eve_cancel(this)" style="float:left;cursor:pointer"><img  src="resource/images/cancel.png" /></div>').remove();
    }
        
    function event_save(whr){
        var id = $(whr).parent().find('input[type=checkbox]').val();
       
            
        var url = 'calander_process.php';
            
        var data = "action=event_edit&id="+id+"&event_title="+$('#e_title').val()+"&event_description="+$('#e_description').val();
                            
                            
        var r = ajax_function(url,data);
                           
        result = JSON.parse(r);
        if(r == '{"success":1}'){
            $(whr).prev().find(':input').each(function(){               
                $(this).parent().html($(this).val());
            });
            $(whr).before('<div onclick="event_edit(this)" class="caltxtrigh" style="float: right;cursor:pointer"><img src="resource/images/edit.png" /></div>').remove();
$('.event_btns').remove();
        }
            
            
    }
	
	function eve_cancel(whr){
        $(whr).prev().prev().find(':input').each(function(){  
            
            $(this).parent().html($(this).val());
        });
        
        $(whr).before('<div onclick="event_edit(this)" class="caltxtrigh" style="float: right;cursor:pointer"><img src="resource/images/edit.png" /></div>').remove();
    $('.event_btns').remove();
    }
</script>
<script type="text/javascript">
    <!--

    function Validate(seldate)
    {
        //var obj = document.getElementById("<%=txtDate.ClientID%>");
  
        var obj = seldate;

        var day = obj.split("-")[2];
        var month = obj.split("-")[1];
        var year = obj.split("-")[0];
        if ((day<1 || day >31) || (month<1&&month>12)&&(year.length != 4)){
            alert("Invalid Format");return false;
        }else{
            var dt = new Date(year, month-1, day);
            var today = new Date();
            if(today.getFullYear() == year){
                if(today.getMonth() == month-1){
                    if(today.getDate() == day){
                        return true;
                    }else if(today.getDate() < day){
                        return true;
                    }else{
                        alert("Invalid Date");return false;
                    }
                }else if(today.getMonth() < month-1){
                    return true;
                }else{
                    alert("Invalid Month");return false;
                }
            }else if(today.getFullYear() < year){
                return true;
            }else{
                alert("Invalid Year");return false;
            }
        }
    }
    //-->
    
</script>
<script src="resource/js/jMonthCalendar.js" type="text/javascript"></script>
			<?php require_once 'common/footer1.php'; ?>