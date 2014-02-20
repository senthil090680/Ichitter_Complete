<?php
$REQ_SEND[PARAM_ACTION] = "videobyuser";
$REQ_SEND[PARAM_USERID] = "$user_id";

$ObjCURL = new INIT_PROCESS(GALLERY_SERVICE_PAGE, $REQ_SEND);
$vGallery = Object2Array($ObjJSON->decode($ObjCURL->response));
?>
<div class="videobg">
    <a class="galleryClose"><img src="resource/images/close-new.png" alt="" /></a>
    <div class="gallerytitle">Select a Video</div>
    <div class="gallerybox">
		<div class="galleryboxscroll">
			<?php
			if (count($vGallery) > 0) {
				$vgalid = "";
				foreach ($vGallery as $key => $vdo) {
					if (trim($vgalid) != $vdo['vgallery_id']) {
						$igalid = $vdo['vgallery_id'];
						$gname = $vdo['vgallery_name'];
						$gname_ar = explode('_', $gname);
						echo "<div class='galleryinnertitle'>" . $gname_ar[0] . "</div>";
					}
					if ($vdo['video_name'] != "") {
						$video_name = $vdo['video_name'];
						$video_thumb_name = substr($video_name, 0, strlen($video_name) - 3) . "jpg";
						$vdoPath = VIDEO_UPLOAD_SERVER . $vdo['user_id'] . '/' . $vdo['vgallery_name'] . '/thumb/' . $video_thumb_name;
						?>
						<div class="imgbox"><a href='javascript: setID("<?php echo $vdo['video_id']; ?>", "<?php echo urldecode($vdoPath); ?>");' ><img src="<?php echo $vdoPath; ?>" alt="" border="0" /><p></p></a></div>
						<?php
					} else {
						$vdoPath = $vdoSource;
						echo "<div class='imgbox' style='text-align:center; width: 500px;'>Video(s) not found</div>";
					}
				}
			} else {
				echo "<div style='text-align:center; margin: 15px 0px;'>Video(s) not found</div>";
			}
			?>
		</div>
    </div>
</div>