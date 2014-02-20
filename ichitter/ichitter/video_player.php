<?php
$file = $_REQUEST['file'];
?>
<html>
<head>
</head>
<body>
 <object width="640px" align="middle" height="380px" id="Ichitter Player" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000">
 <param value="sameDomain" name="allowScriptAccess">
 <param value="false" name="allowFullScreen">
 <param value="resources/swf/ichitter_player.swf?flv=<?php echo $file; ?>&amp;vwidth=640&amp;vheight=380" name="movie">
 <param value="high" name="quality"><param value="#000000" name="bgcolor">	
 <embed width="640" align="middle" height="380" pluginspage="http://www.adobe.com/go/getflashplayer" type="application/x-shockwave-flash" allowfullscreen="false" allowscriptaccess="sameDomain" name="Ichitter Player" bgcolor="#000000" quality="high" src="resources/swf/ichitter_player.swf?flv=<?php echo $file; ?>&amp;vwidth=640&amp;vheight=380">
 </object>
</body>
</html>