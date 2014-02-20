<div id="groupsContain" style="margin-left:5px;margin-bottom:10px;">
			
			<div class="box"> 
			 <div class="grouptext">All Groups</div>
			 <div class="boxformone">
			<select name=""  class="forminside1" style="border:0px;" multiple>			 
<?php
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
								  echo "<option value='".$grpid[$i]."' style='cursor:pointer;' onclick='window.location=\"group_details.php?grpid=\"+this.value;'>".$grpnm[$i]."</option>";
								}
?>
			</select>
		</div>
	</div>
	<div class="box"> 
		<div class="discussionstext">Discussions</div>
		<div class="boxformtwo">
			<?php
			$url = DISCUSSION_SERVICE;
			$REQ_SEND[PARAM_ACTION] = "getichdisc";
			$REQ_SEND[PARAM_USERID] = $user_id;
			$curl_call = new INIT_PROCESS($url, $REQ_SEND);
			$result = Object2Array($ObjJSON->decode($curl_call->response));
			if (count($result)) {
				$cls = "disc_even";
				?>
				<div class="forminside3a">
					<?php
					foreach ($result as $key => $REC) {
						$cls = ($cls == "disc_even") ? "disc_odd" : "disc_even";
						echo "<div class='$cls'>
						<div class='disc_cont'>" . $REC['content'] . "</div>
						<div class='disc_poston'>Posted on: " . $REC['posted_date'] . "</div>
					</div>";
					}
					?>
				</div>
				<?php
			} else {
				echo '<textarea name="text" class="forminside2" cols="" rows="" readonly></textarea>';
			}
			?>
		</div>
	</div>
</div>