<?php 
    $REQ_SEND[PARAM_USERID] = $_SESSION['login']['user_id'];
    
    $REQ_SEND[PARAM_ACTION] = "getmutual_friends";
    $ObjCURL = new INIT_PROCESS(COMMON_SERVICE, $REQ_SEND);
    
    
    $mutual_frnd = (array)($ObjJSON->decode($ObjCURL->response));
    //echo $ObjCURL->response;
    
    
    foreach($mutual_frnd as $k => $v){
		$mutual_frnd[$k] = (array)$v;
	}	
	
	
	/*profile image name*/
		foreach($mutual_frnd as $k => $v){
               if(!$v['pub_name']){
                $mutual_frnd[$k]['uname'] = $mutual_frnd[$k]['email'];
               }
              
			if(isset($v['image_name']) && trim($v['image_name']) != ''){
				$mutual_frnd[$k]['image_name'] = IMAGE_UPLOAD_SERVER. $v['user_id'] ."/". $v['igallery_name'] ."/thumb/". $v['image_name'];
			}elseif($v['gender'] == 'm'){
				$mutual_frnd[$k]['image_name'] = "resource/images/male-small.jpg";
			}elseif($v['gender'] == 'f'){
				$mutual_frnd[$k]['image_name'] = "resource/images/female-small.jpg";
			}
		}	
          
//          echo '<pre />';
//    print_r($mutual_frnd);
    
?>
<div class="leftbox1">
    <h1>Mutual friends</h1>
    <div id="mututal_wrapper">
        <div id="mututal_container" class="<?php echo !count($mutual_frnd) ? 'norecords' : ''; ?>">
    <?php if(count($mutual_frnd)){ foreach($mutual_frnd as $k => $v){ ?>
    <div class="mutual_frnds"> 
         <div class="contactsimg">
              <a href="profile.php?user_id=<?php echo $v['user_id']; ?>"><img height="40" width="40" alt="" src="<?php echo $v['image_name']; ?>"></a>
         </div>
         <div class="contactstext"> 
              <h5><?php echo $v['uname']; ?></h5>
              <p><?php echo $v['state_name']; ?></p>
         </div>
        <div style="clear: both"></div>
        <img onclick="addfriend(this,'<?php echo SESS_USER_ID.':'.$v['user_id']; ?>')" style="float: right" src="resource/images/add-friend.png" />
        <div style="clear: both"></div>
   </div>
   <?php }}else{ echo 'Your mutual friend(s) not found'; } ?>
            </div>
    </div>
</div>
<div class="rigimg"><img src="resource/images/img-netflix.jpg"  alt="" /></div>
<div class="rigimg"><img src="resource/images/img-cola.jpg"  alt="" /></div>
<?php
$REQ_SEND[PARAM_USERID] = $_SESSION['login']['user_id'];
$REQ_SEND[PARAM_ORDER] = "DESC";
$REQ_SEND[PARAM_LIMIT] = "4";

$REQ_SEND[PARAM_ACTION] = "getuserposts";
$ObjCURL = new INIT_PROCESS(POSTING_SERVICE, $REQ_SEND);
$MyPosts = array();
$MyPosts = Object2Array($ObjJSON->decode($ObjCURL->response));
?>
<div id="author">
	<h1>I Author</h1>
	<?php 
	if(count($MyPosts) > 0) {
		$url="";
		foreach($MyPosts as $idx => $post) { 
			$url = "../fp/discussion.php?" . PARAM_TOPICID . "=" . $post['topic_id'] . "&" . PARAM_SUBTOPICID . "=" . $post['sub_topic_id'] . "&" . PARAM_POSTID . "=" . $post['posting_id'] . "";
			print "<h2><a href='$url'>" . $post['posttitle'] . "</a></h2>";
			print "<p>" . $post['ic_content'] . "</p>";
		?>
			
	<?php
		}
	} else {
		echo '<div style="font-size: 12px; ">Postings are not found.</div>';
	} 
	?>
</div>
<?php
$REQ_SEND[PARAM_POSTID] = "";
$REQ_SEND[PARAM_TOPICID] = "";
$REQ_SEND[PARAM_SUBTOPICID] = "";
$REQ_SEND[PARAM_USERID] = $_SESSION['login']['user_id'];
$REQ_SEND[PARAM_ORDER] = "DESC";
$REQ_SEND[PARAM_LIMIT] = "";
$REQ_SEND[PARAM_IS_MARKED] = false;
$REQ_SEND[PARAM_IS_ARCHIVED] = "0";
$REQ_SEND[PARAM_ACTION] = "getrecentposts";
$ObjCURL = new INIT_PROCESS(POSTING_SERVICE, $REQ_SEND);
$RecentPosts = array();
$RecentPosts = Object2Array($ObjJSON->decode($ObjCURL->response));
?>

<!-- RECENTLY READ Start HERE -->
<div class="leftbox1">
	<h1>Recently Read</h1>
	<?php 
	if(count($RecentPosts) > 0) {
		print "<ul>";
		$i=1;
		$url="";
		foreach($RecentPosts as $idx => $post) { 
			$url = "../fp/discussion.php?" . PARAM_TOPICID . "=" . $post['topic_id'] . "&" . PARAM_SUBTOPICID . "=" . $post['sub_topic_id'] . "&" . PARAM_POSTID . "=" . $post['posting_id'] . "";
			print "<li><h2>0" . $i . "</h2>";
			print "<h3><a href='$url' target='_blank'>" . $post['posttitle'] . "</a></h3>";
			print "<div class='msboxrig'><div class='conbox'>" . $post['counts'] . "</div>";
			print "<div class='conboximg'></div></div>";
			print "<h4>" . $post['ic_content'] . "</h4></li>";
			$i++;
		}
		print "</ul>";
	} else {
		echo '<div style="font-size: 12px;">Postings are not found.</div>';
	} 
	?>
</div>

<!-- RECENTLY READ End HERE -->

<?php
$REQ_SEND[PARAM_ACTION] = "geticposts";
$REQ_SEND[PARAM_IS_MARKED] = true;
$REQ_SEND[PARAM_IS_ARCHIVED] = "0";
$REQ_SEND[PARAM_SORT_ORDER] = "0";
$REQ_SEND[PARAM_LIMIT] = "5";
$ObjCURL = new INIT_PROCESS(POSTING_SERVICE, $REQ_SEND);
$marked_list = array();
$marked_list = Object2Array($ObjJSON->decode($ObjCURL->response));
?>
<!-- RECENTLY READ Start HERE -->
<div class="leftbox1">
	<h1>Marked</h1>
	<?php 
	if(count($marked_list) > 0) {
		print "<ul>";
		$url="";
		$i=1;
		foreach($marked_list as $idx => $post) { 
			$url = "../fp/discussion.php?" . PARAM_TOPICID . "=" . $post['topic_id'] . "&" . PARAM_SUBTOPICID . "=" . $post['sub_topic_id'] . "&" . PARAM_POSTID . "=" . $post['posting_id'] . "";
			print "<li><h2>0" . $i . "</h2>";
			print "<h3><a href='$url' target='_blank'>" . $post['posttitle'] . "</a></h3>";
			print "<div class='msboxrig'><div class='conbox'>" . $post['counts'] . "</div>";
			print "<div class='conboximg'></div></div>";
			print "<h4>" . $post['ic_content'] . "</h4></li>";
			$i++;
		}
		print "</ul>";
	} else {
		echo '<div style="font-size: 12px;">Postings are not found.</div>';
	}
	?>
</div>
<!-- RECENTLY READ End HERE -->