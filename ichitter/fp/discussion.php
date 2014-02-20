<?php
include_once 'library/include_files.php';
include_once 'library/class.discussiontree.php';

$topicsid = $_REQUEST[PARAM_TOPICID];
$subtopicid = $_REQUEST[PARAM_SUBTOPICID];
$postid = $_REQUEST[PARAM_POSTID];

$msg = "";
if(isset($_REQUEST[PARAM_MESSAGE])){
	$msg = $_REQUEST[PARAM_MESSAGE];
}

$user_id = "";
if ($_SESSION['login']['user_id'] != "") {
    $user_id = $_SESSION['login']['user_id'];
}

$userid = "";
$REQ_SEND[PARAM_ACTION] = "listpost";
$REQ_SEND[PARAM_POSTID] = "$postid";
$REQ_SEND[PARAM_TOPICID] = "$topicsid";
$REQ_SEND[PARAM_SUBTOPICID] = "$subtopicid";
$REQ_SEND[PARAM_USERID] = "$userid";
$REQ_SEND[PARAM_ORDER] = "DESC";
$REQ_SEND[PARAM_LIMIT] = "1";
$REQ_SEND[PARAM_IS_ARCHIVED] = "0";
$REQ_SEND[PARAM_IS_MARKED] = false;

$ObjCURL = new INIT_PROCESS(POSTING_SERVICE_PAGE, $REQ_SEND);
$result = array();

$result = Object2Array($ObjJSON->decode($ObjCURL->response));
$PostDtl = $result[0];

$topicTitle = $PostDtl['topic'];
$subTopicTitle = $PostDtl['subtopic'];

$uid = $PostDtl['user_id'];

$gtype = $PostDtl['graphic_type'];

$imgSource = "resource/images/no-img.jpg";
$vdoSource = "resource/images/videotemp.jpg";

$src = "";
if ($PostDtl['image_name'] != "") {
    $src = IMAGE_UPLOAD_SERVER . $uid . '/' . $PostDtl['igallery_name'] . '/' . $PostDtl['image_name'];
    $imgSource = $src;
}

$video_name = $PostDtl['video_name'];
$src = VIDEO_UPLOAD_SERVER . $uid . '/' . $PostDtl['vgallery_name'] . '/' . $video_name;

if ($video_name != "") {
    $vdoSource = $src;
}

$REQ_SEND[PARAM_ACTION] = "setrecent";
$REQ_SEND[PARAM_USERID] = $_SESSION['login']['user_id'];
$ObjCURL = new INIT_PROCESS(POSTING_SERVICE_PAGE, $REQ_SEND);

$REQ_SEND[PARAM_ACTION] = "discussionlist";
$REQ_SEND[PARAM_FOR_DISCUSSION] = "0";

$stord = "1";
if(isset($_REQUEST[PARAM_SORT_ORDER])) {
	$stord = $_REQUEST[PARAM_SORT_ORDER];
}

$REQ_SEND[PARAM_SORT_ORDER] = $stord;
$ObjCURL = new INIT_PROCESS(DISCUSSION_SERVICE_PAGE, $REQ_SEND);
$discussions = array();
$discussions = Object2Array($ObjJSON->decode($ObjCURL->response));

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title><?php echo ALL_PAGE_TITLE; ?></title>
	<link rel="stylesheet" href="admin/css/general.css" type="text/css" media="screen" />
	<link rel="stylesheet" type="text/css" href="resource/css/styles.css" />
	<link rel="stylesheet" type="text/css" href="resource/css/login-style.css"/>
	<link rel="stylesheet" href="resource/css/ddsmoothmenu.css" type="text/css" media="screen" />
	<script type="text/javascript" src="resource/js/ddsmoothmenu.js"></script>
	<script type="text/javascript" src="resource/js/jquery-1.7.1.js"></script>
	<script type="text/javascript" src="resource/js/jquery.corner.js"></script>
	<script type="text/javascript" src="resource/js/popup-gallery.js"></script>
	<script type="text/javascript">
		var iCnt = 1;
		var ud = <?php echo $ud = ($user_id != "")? "true" : "false"; ?>;
	    $(function(){
			//Hide (Collapse) the toggle containers on load
			$(".toggle_container").hide(); 
			
			//Switch the "Open" and "Close" state per click then slide up/down (depending on open/close state)
			$(".trigger").click(function(){
				$(".span_" + this.id).hide();
				$(this).toggleClass("active").next().slideToggle("slow");
				var anc = $(this).children().children().children().children();
				toggleStatus(anc);
				return false; //Prevent the browser jump to the link anchor
			});
			
			$(".reply a").click(function(){
				<?php if( $session_obj->checkSession()) { ?>
					chkdisc();
				<?php } else { ?>
					var spanid = this.id;
					$(".span_" + spanid).show();
					var par = $(this).parent().parent().parent().parent().parent();
					replyDiscussion(spanid, par);
					
				<?php } ?>
				return false;
			});
			
			//To add new Comment
			$('#newcomment').click(function(event){
				var tid = $('#' + '<?php echo PARAM_TOPICID; ?>').val();
				var stid = $('#' + '<?php echo PARAM_SUBTOPICID; ?>').val();
				var pid = $('#' + '<?php echo PARAM_POSTID; ?>').val();
				var cid = $('#' + '<?php echo PARAM_FOR_DISCUSSION; ?>').val();
				var cntt = $('#' + '<?php echo PARAM_CONTENT; ?>').val();
				
				if(cntt == "") {
					alert("Please enter your Discussion Content");
					return false;
				}
				
				if(!filterBadWords(cntt)){
					alert("Adding Discussion Failed. Discussion contains prohibited words");
					return false;
				};
				
				textret =  $.ajax({	
					type: "POST",
					url: "discussion_process.php",
					data: {'<?php echo PARAM_TOPICID ?>':tid,'<?php echo PARAM_SUBTOPICID; ?>':stid,'<?php echo PARAM_POSTID; ?>':pid,'<?php echo PARAM_CONTENT; ?>':cntt,'<?php echo PARAM_FOR_DISCUSSION; ?>':cid ,'<?php echo PARAM_ACTION; ?>':'adddiscussion'},
					async: false,
					dataType: "json",
					cache: false
				}).responseText;

				var res = jQuery.parseJSON(textret);
				
				/*noor*/
				$('.curveone:first-child').before('<div class="curveone"><div class="curveouterone" style="padding: 1px; border-radius: 3px 3px 3px 3px;"><div class="inner roundinnerone" style="border-radius: 3px 3px 3px 3px;"><div style="width:684px;" class="inbox2 bright btm "><div id="'+res.last_insert.discussion_id+'" class="trigger"><div style="float:left; width:670px; clear:right; height:auto;"><div class="disphotos"><img src="http://tsg.emantras.com/ichitter_service/upload/photos/4/'+res.last_insert.image+'"></div><div class="distitle"><a href="javascript:;">'+res.last_insert.uname+'</a>,<span>'+res.last_insert.posted_date+'</span></div><div class="open disrighttxt"><p class="discuss"><a id="'+res.last_insert.discussion_id+'" href="javascript: void(0);">VIEW AND REPLY</a></p></div></div></div><div class="toggle_container" style="display: none;"><div class="block"><p>'+res.last_insert.discussion_content+'</p><div class="reply"><p class="discuss"><a id="'+res.last_insert.discussion_id+'" href="javascript: void(0);">REPLY</a></p></div><div class="brk"></div></div><span class="span_'+res.last_insert.discussion_id+'"><div class="brk"></div><textarea id="content_'+res.last_insert.discussion_id+'" name="content_'+res.last_insert.discussion_id+'" style="width: 95%; height:100px; margin: 15px 0 0 8px; resize: none;"></textarea><div class="brk"></div><div class="replycomment"><a id="replycomment" href="javascript: void(0);"></a></div></span></div></div><div class="brk"></div></div></div></div>');
				
				if(res.result == "OK") {
					window.location = 'discussion.php?' + <?php echo "'" . $_SERVER['QUERY_STRING'] . "'"; ?>;
				}
			});
			edgeDes();
		});
			
		function replyDiscussion(discCont, par) {
			$('.span_' + discCont + ' a').unbind('click');
			$('.span_' + discCont + ' a').click(function(event) {
				var tid = $('#' + '<?php echo PARAM_TOPICID;?>');
				var stid = $('#' + '<?php echo PARAM_SUBTOPICID;?>');
				var pid = $('#' + '<?php echo PARAM_POSTID;?>');
				var cid = discCont;
				var cntt = $('#' + '<?php echo PARAM_CONTENT;?>_'+ discCont);
				if(cntt.val() == "") {
					alert("Please enter your Reply Content");
					return false;
				}
				
				if(!filterBadWords(cntt.val())){
					alert("Adding Discussion Failed. Discussion contains prohibited words");
					return false;
				};
				
				$.ajax({	
					type: "POST",
					url: "discussion_process.php",
					data: {'<?php echo PARAM_TOPICID ?>': tid.val(), '<?php echo PARAM_SUBTOPICID;?>':stid.val(), '<?php echo PARAM_POSTID;?>':pid.val(), '<?php echo PARAM_CONTENT; ?>': cntt.val(), '<?php echo PARAM_FOR_DISCUSSION; ?>': cid, '<?php echo PARAM_ACTION; ?>' : 'adddisc' },
					dataType: "json",
					cache: false,
					success: function(res){
						if(res.result == "OK") {
							$(".span_" + discCont).hide();
							var vals = res.rec;
							var disc = constructDiscussion(vals, par);
							var ins = $(par).find('> div').eq(1);
							ins.children().last().before(disc);
							replyButton();
							edgeDes();
							cntt.val("");
						}
						else  {
							alert("Reply failure");
						}
					}
				});
			});
		}
		
		$(document).ready(function(){
			/*$('.corner').corner("round 8px").css('padding', '4px').parent().corner("round 10px");*/
			//$('.inner').corner("round 3px").parent().css('padding', '1px').corner("round 3px");
		});

	</script>
	<script type="text/javascript" src="resource/js/common.js"></script>
	<style>
		/* ----Curve border Start--- */
		.curveone{ float:left; width:auto; height:auto; margin:4px 0 0 0; padding:5px 0 7px 5px;}
		.curvetwo{ float:right; background:#f9eded; width:auto; height:auto; margin:4px 6px 10px 0;}
		div.curveouterone {background-color:#c8787b;float: left; margin: 0px;}
		.roundinnerone{ float:left;width:auto; min-height:47px; height:auto; background:url(resource/images/bg-grad.jpg) repeat-x;background-color:#f9eded;}
		/* ----Curve border End--- */

		.disphotos{float:left; width:32px; height:32px;background:url(resource/images/photos-bg.jpg) no-repeat top left; margin:1px 0px 0 0px; }
		.disphotos img{ float:left; padding:0px; margin:2px 0 0 2px; width:28px;height:28px;}
		
		.distitle{float:left; padding:7px 0 0 10px; width:auto; height:32px;text-align:left; font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; color:#ab3232;}
		.distitle span{text-align:left; font-weight:normal; font-family:Arial, Helvetica, sans-serif; font-size:11px;color:#000000}
		.distitle a{color:#ab3232; text-decoration:none;}
		.distitle a:hover{color:#e76767; text-decoration:none;}
		.disrighttxt{float:right;  padding:7px 0px 0 0;  border:0px solid red;margin:0px;width:120px; height:32px; text-align:right; font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; color:#ab3232;}
		.disrighttxt a{color:#ab3232; text-decoration:none;}
		.disrighttxt a:hover{color:#e76767; text-decoration:none;}
	</style>
	</head>
	<body>
	<div id="container">
	    <div id="wrapper">
		<?php include_once 'common/header.php';	?>
		<div id="main">
		    <div id="maincontent">
			<h1 class="dischdr">
			    <?php echo $topicTitle . " - " . $subTopicTitle; ?>
			    <div class="gotopost" >
					<?php if(!$session_obj->checkSession()) { ?>
				<a href="subtopics.php?<?php echo PARAM_TOPICID . "="  . $topicsid; ?>">Go to Postings</a>
				<?php if(!$session_obj->checkSession()) { ?>
				 | <a href="markedlist.php?<?php echo PARAM_TOPICID . "="  . $topicsid; ?>">My Marked List</a>
				<?php } } ?> 
			    </div>
			</h1>
			<div style=" margin:10px 0px 0px 0px; height:25px; font-size: 13px; color: green; text-align: center;"><?php echo $$msg; ?></div>
			<div class="videobigwrap">
			    <h2 style="height:20px;"><a href="#"><?php echo $PostDtl['title']; ?></a></h2>
			    <?php if ($gtype == 'I') { ?>
    			    <div class="videobig"><img src="<?php echo $imgSource; ?>" alt="" style="width: 480px; height: 320px;" /></div>
			    <?php } else { ?>
    			    <div class="videobig">
    				<object width="480px" align="middle" height="320px" id="TKPlayer" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000">
    				    <param value="sameDomain" name="allowScriptAccess" />
    				    <param value="false" name="allowFullScreen" />
    				    <param value="swf/ichitter_player.swf?flv=<?php echo $vdoSource; ?>&amp;vwidth=480&amp;vheight=320" name="movie" />
    				    <param value="high" name="quality" />
    				    <param value="#000000" name="bgcolor" />
    				    <embed width="480" align="middle" height="320" pluginspage="http://www.adobe.com/go/getflashplayer" type="application/x-shockwave-flash" allowfullscreen="false" allowscriptaccess="sameDomain" name="TKPlayer" bgcolor="#000000" quality="high" src="swf/ichitter_player.swf?flv=<?php echo $vdoSource; ?>&amp;vwidth=480&amp;vheight=320" />
    				</object>
    			    </div>
			    <?php } ?>
			    <div class="keywordsbox" style="background: white;">
				<p></p>	
				<?php
				if (!$session_obj->checkSession()) {
				    if ($PostDtl['user_id'] == $_SESSION['login']['user_id']) {
					?>
					<div class="editlink">
					    <a href="update_post.php?<?php echo PARAM_TOPICID . "=". $topicsid . "&" . PARAM_SUBTOPICID . "=" . $subtopicid . "&" . PARAM_POSTID  . "=" . $postid; ?>">
							<img src="resource/images/edit.png" border="0" alt="" style="width: 68px; height: 28px;" />
					    </a>
						<a href="javascript: removePosting('<?php print $PostDtl['posting_id']; ?>',<?php print $rs = ($PostDtl['counts']>0) ? 1: 0; ?>, true);"><img src="resource/images/delete.png" border="0" alt="" style="width: 84px; height: 28px;" /></a>
					</div>
					<?php
				    }
				}
				?>
				<p></p>
				<p></p>
				<div class="keywordscomment">
				    <?php if($PostDtl['counts'] > 1) { ?>
						<p><?php echo $PostDtl['counts'];?> Comments</p>
					<?php } else {?>
						<p><?php echo $PostDtl['counts'];?> Comment</p>
					<?php }?>
				</div>
			    </div>
			    <p><?php echo htmlspecialchars_decode($PostDtl['post_content']); ?></p>
			</div>
			<!-- Discussions Start -->
			<?php include_once 'common/discuss.php'; ?>    
			<!-- Discussions End -->
		    </div>
			<?php include_once 'common/right_side.php'; ?>
		</div>
		<?php include_once 'common/footer.php'; ?>
	    </div>
	</div>
    </body>
</html>