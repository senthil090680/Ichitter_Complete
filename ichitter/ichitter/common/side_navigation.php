<?php 

	$REQ_SEND['action'] = 'get_group_contact';
	$REQ_SEND['user_id'] = SESS_USER_ID;
	
	$init_process_obj = new INIT_PROCESS(CONTACT_SERVICE,$REQ_SEND);
	
	$user_data = (array)($ObjJSON->decode($init_process_obj->response));
    
	foreach($user_data as $k => $v){
		$user_data[$k] = (array)$v;
	}	
	$data = $user_data;
	
	/*profile image name*/
		foreach($data as $k => $v){
			if(isset($v['image_name']) && trim($v['image_name']) != ''){
				$user_data[$k]['image_name'] = $data[$k]['image_name'] = IMAGE_UPLOAD_SERVER. $v['user_id'] ."/". $v['igallery_name'] ."/thumb/". $v['image_name'];
			}elseif($v['gender'] == 'm'){
				$user_data[$k]['image_name'] = $data[$k]['image_name'] = "resource/images/male-small.jpg";
			}elseif($v['gender'] == 'f'){
				$user_data[$k]['image_name'] = $data[$k]['image_name'] = "resource/images/female-small.jpg";
			}
		}	
	
	
	
?>
<div class="menu">
<ul>
	 <li class="first"><a href="news.php">News Stream</a></li>
	 <li><a href="discussion-forums.php">Discussions</a></li>
	 <li><a href="groups.php">Groups</a></li>								 							 
	 <li><a href="postings.php">Postings</a></li>
	 <li><a href="author.php">I, Author</a></li>
	 <li><a href="recently-read.php">Recently Read</a></li>
	 <li><a href="marked.php">Marked</a></li>
	 <li><a href="editprofile.php">Profile</a></li>
	 <li><a href="photos.php">Photos</a></li>
	 <li><a href="videos.php">Videos</a></li>
	 <li style="border:none;"><a href="contacts.php">Contacts</a></li>							
</ul>
</div>
<div id="contacts">
  <h1>Contacts </h1>
  <?php 
  	if(!empty($user_data)){
  		foreach($user_data as $k => $v){ 
		
  ?>					  
  <div class="contactscont"> 
	<div class="contactsimg">
		<a href="profile.php?user_id=<?php echo $v['user_id']; ?>"><img src="<?php echo $v['image_name']; ?>" width="40" height="40" alt=""  /></a>
	</div>
	<div class="contactstext"> 
		<h5>
			<?php 
				if($v['priv_name'] == 1){
					echo ucfirst($v['first_Name']); 
				}
			?>
		</h5>
		<p><?php echo $v['state_name']; ?></p></div>
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