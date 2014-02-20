<?php
$REQ_SEND[PARAM_ACTION] = "getrecentposts";
$REQ_SEND[PARAM_USERID] = SESS_USER_ID;
$ObjCURL = new INIT_PROCESS(POSTING_SERVICE_PAGE, $REQ_SEND);

$RecentPosts = Object2Array($ObjJSON->decode($ObjCURL->response));
?>

<div id="mainright">
	<!-- RIGHT STARTS -->
    <div class="freetrial"><img src="resource/images/free-trial.jpg" align="free trial" /></div>
    <div class="coke"><img src="resource/images/coke.jpg" align="free trial" /></div>
	
		<!-- RECENTLY READ STARTS HERE -->
    <div class="rbox">
		<div class="rboxlft"><img src="resource/images/rbox1.jpg" /></div>
		<div class="rboxmid">
			<img src="resource/images/recentlyhead.png" alt="" />
			<?php
			if(count($RecentPosts) > 0) {
				$i=1;
			?>
			<ul>
				<?php 
				$url="";
				foreach($RecentPosts as $idx => $post) { 
					$url = "discussion.php?" . PARAM_TOPICID . "=" . $post['topic_id'] . "&" . PARAM_SUBTOPICID . "=" . $post['sub_topic_id'] . "&" . PARAM_POSTID . "=" . $post['posting_id'] . "";
				?>
				<li>
					<p><span><?php echo "0".$i; ?></span><b><a href="<?php echo $url; ?>"><?php echo $post['posttitle']; ?></a></b></p>
					<div class="count"><span><?php echo $post['counts']; ?></span></div>
				</li>
				<?php 
					$i++;
				} 
				?>
			</ul>
			<?php
			}
			?>
		</div>
		<div class="rboxrgt"><img src="resource/images/rbox3.jpg" /></div>
    </div>
	<!-- RECENTLY READ ENDS HERE -->
<?php
$REQ_SEND[PARAM_ACTION] = "getmostpopular";
$ObjCURL = new INIT_PROCESS(POSTING_SERVICE_PAGE, $REQ_SEND);

$PopularPosts = Object2Array($ObjJSON->decode($ObjCURL->response));
?>
	<!-- MOST POPULAR DISCUSSIONS HERE -->
    <div class="rbox">
		<div class="rboxlft"><img src="resource/images/rbox1.jpg" alt="" /></div>
		<div class="rboxmid">
			<img src="resource/images/most-head.png" alt="" />
			<?php
			if(count($PopularPosts) > 0) {
			?>
			<ul>
				<?php 
				$url="";
				foreach($PopularPosts as $idx => $post) { 
					$url = "discussion.php?" . PARAM_TOPICID . "=" . $post['topic_id'] . "&" . PARAM_SUBTOPICID . "=" . $post['sub_topic_id'] . "&" . PARAM_POSTID . "=" . $post['posting_id'] . "";
				?>
				<li>
					<p><b><a href="<?php echo $url; ?>"><?php echo $post['posttitle']; ?></a></b></p>
					<p><a href="<?php echo $url; ?>"><?php echo $post['content']; ?></a></p>
					<div class="count"><span><?php echo $post['counts']; ?></span></div>
				</li>
				<?php 
					} 
				?>
			</ul>
			<?php
			}
			?>
		</div>
		<div class="rboxrgt"><img src="resource/images/rbox3.jpg" /></div>
    </div>
	<!-- MOST POPULAR DISCUSSIONS ENDS HERE -->
	
    <div class="rbox">
		<div class="rboxlft"><img src="resource/images/rbox1.jpg" /></div>
		<div class="rboxmidgate">
			<img src="resource/images/relatedhead.png" alt="" />
			<ul style="width:213px; margin-left:-3px;">
				<li style="background:url(resource/images/c1.jpg) top left no-repeat; height:38px; width:213px; border:none;">
					<p><a href="javascript: void(0);">Category Name 01</a></p>
				</li>
				<li style="background:url(resource/images/c2.jpg) top left no-repeat; height:38px; width:213px; border:none;">
					<p><a href="javascript: void(0);">Category Name 02</a></p>
				</li>
				<li style="background:url(resource/images/c3.jpg) top left no-repeat; height:38px; width:213px; border:none;">
					<p><a href="javascript: void(0);">Category Name 03</a></p>
				</li>
				<li style="background:url(resource/images/c4.jpg) top left no-repeat; height:38px; width:213px; border:none;">
					<p><a href="javascript: void(0);">Category Name 04</a></p>
				</li>
			</ul>
		</div>
		<div class="rboxrgt"><img src="resource/images/rbox3.jpg" /></div>
    </div>
	<!-- RIGHT ENDS -->
</div>
