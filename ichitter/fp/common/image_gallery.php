<?php
$REQ_SEND[PARAM_ACTION] = "imagebyuser";
$REQ_SEND[PARAM_USERID] = "$user_id";

$ObjCURL = new INIT_PROCESS(GALLERY_SERVICE_PAGE, $REQ_SEND);
$iGallery = Object2Array($ObjJSON->decode($ObjCURL->response));
?>
<div class="gallerybg">
    <a class="galleryClose"><img src="resource/images/close-new.png" alt="" /></a>
    <div class="gallerytitle">Select an Image</div>
    <div class="gallerybox">
		<div class="galleryboxscroll">
			<?php
			if (count($iGallery) > 0) {
				$igalid = "";
				foreach ($iGallery as $key => $img) {
					if (trim($igalid) != $img['igallery_id']) {
						$igalid = $img['igallery_id'];
						$gname = $img['igallery_name'];
						$gname_ar = explode('_', $gname);
						echo "<div class='galleryinnertitle'>" . $gname_ar[0] . "</div>";
					}
					if ($img['image_name'] != "") {
						$imgPath = IMAGE_UPLOAD_SERVER . $img['user_id'] . '/' . $img['igallery_name'] . '/';
						?>
						<div class="imgbox"><a href='javascript: setID("<?php echo $img['image_id']; ?>", "<?php echo urldecode($imgPath . $img['image_name']); ?>");' ><img src="<?php echo $imgPath . $img['image_name']; ?>" alt="" border="0" /><p></p></a></div>
						<?php
					} else {
						$imgPath = $imgSource;
						echo "<div class='imgbox' style='text-align:center; width: 500px;'>Image(s) not found</div>";
					}
				}
			} else {
				echo "<div style='text-align:center; margin: 15px 0px;'>Image(s) not found</div>";
			}
			?>	
		</div>
    </div>
</div>