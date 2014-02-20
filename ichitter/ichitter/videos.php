<?php
require_once('lib/include_files.php');
require_once('lib/profile_photo_include.php');
//error_reporting(0);
$session_obj = new SESSION();
if (isset($_REQUEST['logout']) && $_REQUEST['logout'] == 'OK') {
    $session_obj->unset_Session('login');
    header('location:index.php');
}
if (trim($_SESSION['login']['user_id']) == '') {
    header('location:index.php');
}
?>

<?php
require_once 'common/header1.php';
?>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function(){
        $("area[rel^='prettyPhoto']").prettyPhoto();
				
        $(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:'light_square',slideshow:3000, autoplay_slideshow: false});
        $(".gallery:gt(0) a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'fast',slideshow:10000, hideflash: true});
		
        $("#custom_content a[rel^='prettyPhoto']:first").prettyPhoto({
            custom_markup: '<div id="map_canvas" style="width:260px; height:265px"></div>',
            changepicturecallback: function(){ initialize(); }
        });

        $("#custom_content a[rel^='prettyPhoto']:last").prettyPhoto({
            custom_markup: '<div id="bsap_1259344" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div><div id="bsap_1237859" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6" style="height:260px"></div><div id="bsap_1251710" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div>',
            changepicturecallback: function(){ _bsap.exec(); }
        });
    });

    var frm;
    function submitfordelete(){
        var a=new Array();
        a=document.getElementsByName("deleteImages[]");
        //alert("Length:"+a.length);
        var p=0;
        for(i=0;i<a.length;i++){
            if(a[i].checked){
                p=1;
            }
        }
        if (p==0){
            alert('Please select Video(s) to delete');
            return false;
        }
        var w=confirm("Are you sure you want to delete the Video(s)?");
        if (w==true)
        {
            document.videosDel.submit();
            return true;
        }
        else
        {				
            return false;
        }							
    }	
    function submitalbumfordelete(){
        var a=new Array();
        a=document.getElementsByName("deleteAlbum[]");
        //alert("Length:"+a.length);
        var p=0;
        for(i=0;i<a.length;i++){
            if(a[i].checked){
                p=1;
            }
        }
        if (p==0){
            alert('Please select Gallery to delete');
            return false;
        }
        var r=confirm("Are you sure you want to delete the Gallery? All Video(s) uploaded in this Gallery will be deleted permanently");
        if (r==true)
        {
            document.albumDel.submit();
            return true;
        }
        else
        {				
            return false;
        }	
    }				
</script>		
<div id="contentLeft">
    <div id="profPhoto"><img width="86" height="106" src="<?php echo $profile_img; ?>" /><br /><?php echo $user_name; ?></div>

    <?php require_once('lib/group_header_include.php'); ?>
    <div class="line"></div>
    <div id="leftmenulist">
        <?php include ('common/side_navigation.php'); ?>		  
    </div>
    <div id="mainupload">			
        <?php
        if ($_GET['msg']) {
            $msg = $_GET['msg'];
            switch ($msg) {
                case "glrysuccess":
                    $message = "Gallery created successfully";
                    break;
                case "direxist":
                    $message = "Gallery already exist";
                    break;
                case "cnntcrtdir":
                    $message = "There is an error creating Gallery";
                    break;
                case "vidsuccess":
                    $message = "Video Uploaded successfully";
                    break;
                case "error":
                    $message = "Error uploading videos";
                    break;
                case "maxSize":
                    $message = "You cannot upload files more than 10MB";
                    break;
                case "delsuccess":
                    $message = "Videos Deleted Successfully";
                    break;
                case "delerror":
                    $message = "Error Deleting videos";
                    break;
                case "Adelsuccess":
                    $message = "Gallery Deleted Successfully";
                    break;
                case "Adelerror":
                    $message = "Error Deleting gallery";
                    break;
            }
            ?>								
            <div class="ucipublishedtxt margintop10"> 
                <h1>Message : <?php echo $message; ?></h1>							
            </div>	
        <?php } ?>								
        <div class="posting" style="margin-bottom:10px;">Videos</div>
        <?php
        $user_id = $_SESSION['login']['user_id'];
        if (isset($_GET['albumid'])) {
            $gallery_id = $_GET['albumid'];
        } else {
            $gallery_id = '0';
        }
        $url = SERVICE_NAME . "video_fetch_service.php";
        $url_path = SERVICE_NAME;
        /* $ch = curl_init();
          curl_setopt($ch, CURLOPT_HEADER, 0);
          curl_setopt($ch, CURLOPT_VERBOSE, 0);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");
          curl_setopt($ch, CURLOPT_POST, true);
          //curl_setopt($ch, CURLOPT_URL, 'http://tsg.emantras.com/ichitter_service/webservice.php' );
          curl_setopt($ch, CURLOPT_URL, $url );
          //most importent curl assues @filed as file field
          $post_array = array(
          "gallery_id"=>$gallery_id,
          "get_videos" => "get_videos",
          "get_gallery"=>"",
          "user_id"=>$user_id,
          "upload"=>"Upload"
          );
          curl_setopt($ch, CURLOPT_POSTFIELDS, $post_array);
          $response = curl_exec($ch); */

        $curl_data = array(
            "gallery_id" => $gallery_id,
            "get_videos" => "get_videos",
            "get_gallery" => "",
            "user_id" => $user_id,
            "upload" => "Upload");
        $curl_data+=$REQ_SEND;
        $curl_call = new INIT_PROCESS(VIDEO_FETCH_SERVICE, $curl_data);
        $response = $curl_call->response;

        //$obj = json_decode($response);
        $obj = $ObjJSON->decode($response);
        $error = $obj->{"error"};
        $gallerynm = $obj->{"gal_name"};
        ?>							
        <div class="ucipublishedhd">
            <h1 style="float:left;"><?php
        if (empty($gallerynm)) {
            echo "Individual Videos";
        } else {
            echo $gallerynm;
        }
        ?></h1> 

        </div>
        <div class="ucipublishedtxt">
            <div class="uciscroll">
                <form name="videosDel" action="video_delete_process.php" method="post">					
                    <ul class="gallery clearfix">
                        <?php
                        if ($error == "") {
                            $valarr = $obj->{"success"};
                            $idsarr = $obj->{"vidids"};
                            for ($i = 0; $i < count($valarr); $i++) {
                                $urls = $valarr[$i];
                                $thmburl = $url_path . $urls;
                                $large_vid = str_replace("thumb/", "", $thmburl);
                                $large_video = str_replace("jpg", "flv", $large_vid);
                                ?>

                                <li class="photos-individual">
                                    <table>
                                        <tr><td>										 
                                                <a href="http://tsg.emantras.com/dev_ichitter/ichitter/video_player.php?file=<?php echo $large_video; ?>&iframe=true&width=670&height=410" rel="prettyPhoto[iframe]">
                                                    <img src="<?php echo $url_path . $urls; ?>" alt="" border="0" title=""/>
                                                </a>
                                            </td></tr>
                                        <tr><td style="font-family:helvetica;font-size:11px;">	
                                                <input style="float:left;" name="deleteImages[]" type="checkbox" id="deleteImages[]" value="<? echo $idsarr[$i]; ?>"><div style="margin:3px;"> Delete </div>	 							   
                                            </td></tr>								   
                                    </table>										
                                </li>	         														
                                <?php
                            }
                        } else {
                            echo "<h1>$error</h1>";
                        }
                        ?>			
                    </ul>	
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                </form>						   
            </div>	
        </div> 
        <div>
            <a href="javascript:;" onclick="return submitfordelete();" style="float: right;height: 31px;margin-bottom: 2px;width: 134px;"><img src="resource/images/delete-videos.png"></a>
        </div>
        <div class="ucipublishedhd margintop10">
            <h1>Video Galleries:</h1> 
        </div>

        <div class="ucipublishedtxt">
            <form name="albumDel" action="delete_video_album_process.php" method="post">						
                <div id="carousel_container">
                    <div id="left_scroll"><img src="resource/images/left.png"></div>
                    <div id="carousel_inner">			

                        <?php
                        /*  $ch = curl_init();
                          curl_setopt($ch, CURLOPT_HEADER, 0);
                          curl_setopt($ch, CURLOPT_VERBOSE, 0);
                          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                          curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");
                          curl_setopt($ch, CURLOPT_POST, true);
                          curl_setopt($ch, CURLOPT_URL, $url );
                          //most importent curl assues @filed as file field
                          $post_array = array(
                          "gallery_id"=>$gallery_id,
                          "get_gallery"=>"get_gallery",
                          "get_photos" => "",
                          "user_id"=>$user_id,
                          "upload"=>"Upload"
                          );
                          curl_setopt($ch, CURLOPT_POSTFIELDS, $post_array);
                          $response = curl_exec($ch); */

                        $curl_data = array(
                            "gallery_id" => $gallery_id,
                            "get_gallery" => "get_gallery",
                            "get_photos" => "",
                            "user_id" => $user_id,
                            "upload" => "Upload");
                        $curl_data+=$REQ_SEND;
                        $curl_call = new INIT_PROCESS(VIDEO_FETCH_SERVICE, $curl_data);
                        $response = $curl_call->response;

                        //$obj = json_decode($response);
                        $obj = $ObjJSON->decode($response);
                        $error = $obj->{"error"};
                        $individualPh = $obj->{"individualPh"};
                        ?>						

                        <ul id="carousel_ul">
                            <li>
                                <div class="conentBg">
                                    <div class="photos-album">
                                        <table>
                                            <tr><td style="font-family:helvetica;font-size:12px;color: #3D86C3; font-weight: bold;text-align:center;">Individual Vid..</td></tr>											  
                                            <tr><td>	
                                                    <a href="videos.php">
                                                        <img class="photoalbum" src="<?php echo $url_path . $individualPh; ?>" border="0">
                                                    </a>
                                                </td></tr>
                                            <tr><td style="font-family:helvetica;font-size:11px;">
                                                    <input style="float:left;" name="deleteAlbum[]" type="checkbox" id="deleteAlbum[]" value="0"><div style="margin:3px;"> Delete </div>
                                                </td></tr>
                                        </table>														
                                    </div>
                                </div>
                            </li>					   
                            <?php
                            if ($error == "") {
                                $valarr = $obj->{"success"};
                                $imgurls = $obj->{"imgurls"};
                                $galleryids = $obj->{"galeryids"};
                                $gallerynms = $obj->{"galname"};
                                echo "<input type='hidden' id='totalGallery' value='" . count($imgurls) . "'>";
                                for ($i = 0; $i < count($imgurls); $i++) {
                                    $gal_name_i = explode("_", $gallerynms[$i]);
                                    $gal_name_final = $gal_name_i[0];
                                    $gal_name_string = substr($gal_name_final, 0, 16);
                                    if (strlen($gal_name_final) > 13) {
                                        $gal_name_string = substr($gal_name_final, 0, 13) . "...";
                                    } else {
                                        $gal_name_string = $gal_name_final;
                                    }
                                    echo '<li>
                                                                                    <div class="conentBg">
                                                                                        <div class="photos-album">
                                                                                        <table>
                                                                                        <tr><td style="font-family:helvetica;font-size:12px;color: #3D86C3; font-weight: bold;text-align:center;">' . $gal_name_string . '</td></tr>											  
                                                                                        <tr><td>	
                                                                                                    <a href="videos.php?albumid=' . $galleryids[$i] . '">
                                                                                                            <img class="photoalbum" src="' . $url_path . $imgurls[$i] . '" border="0">
                                                                                                    </a>
                                                                                        </td></tr>
                                                                                        <tr><td style="font-family:helvetica;font-size:11px;">
                                                                                            <input style="float:left;" name="deleteAlbum[]" type="checkbox" id="deleteAlbum[]" value="' . $galleryids[$i] . '"><div style="margin:3px;"> Delete </div>
                                                                                        </td></tr>
                                                                                        </table>														
                                                                                            </div>
                                                                                    </div>
                                        </li>';
                                }
                            } else {
                                echo "<h1>$error</h1>";
                            }
                            ?>		
                        </ul>	
                    </div>
                    <div id="right_scroll"><img src="resource/images/right.png"></div>
                </div>
        </div> 
        <div>
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            <a href="javascript:;" onclick="return submitalbumfordelete();" style="float: right;height: 31px;margin-right: 10px;width: 124px;"><img src="resource/images/delete-galleries.jpg"></a>
        </div>						
        <div class="ucipublishedtxt margintop10"> 
            <div id="searchuploadGallery" style="text-align:right;">
                <a href="upload_videos.php" title="Upload Videos"><img alt="Upload Videos" src="resource/images/upload-vid.png" /></a>							    
                <a href="creategallery_videos.php" title="Create Video Gallery"><img alt="Create Gallery" src="resource/images/create-gall.png" /></a>
            </div>								
        </div>
    </div>		
</div>
</form>		
<div id="contentRight">
    <?php include ('common/right_side_navigation.php'); ?>		  
</div>
<?php require_once 'common/footer1.php'; ?>