<div id="groupsContain">
			
			<div class="box"> 
			 <div class="grouptext">Groups</div>
			 <div class="boxformone">
			<select name=""  class="forminside1" style="border:0px;" multiple>			 
<?php
	require_once('configuration.php');
	require_once('class.session.php');
	require_once('class.init_process.php');
	require_once('json.php');	
	$session_obj = new SESSION();
	$ObjJSON = new Services_JSON();
								$user_id = $_SESSION['login']['user_id'];
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
									"get_groups" => "get_groups",
									"user_id"=>$user_id,
								);
								curl_setopt($ch, CURLOPT_POSTFIELDS, $post_array);
								$response = curl_exec($ch);*/

								$curl_data = array(
									"get_groups" => "get_groups",
									"user_id"=>$user_id );
								$curl_data+=$REQ_SEND;
								$curl_call = new INIT_PROCESS(CLASS_GROUP_SERVICE, $curl_data);
								$response = $curl_call->response;

								//$obj = json_decode($response);
								$obj = $ObjJSON->decode($response);
								$array = $obj->{"success"};
								$grpnm = $array->{"gname"};
								$grpid = $array->{"gid"};
								for($i=0;$i<count($grpnm);$i++){
								  echo "<option value='".$grpid[$i]."'>".$grpnm[$i]."</option>";
								}
?>
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