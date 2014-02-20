<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title><?php echo ADMIN_TITLE; ?></title>
	<link href="css/style.css" rel="stylesheet" type="text/css" />
	<script language="JavaScript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.7.1.custom.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
	<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu-ich.css" />
	<!--[if IE 7]>
	<link rel="stylesheet" type="text/css" href="css/style-ie7.css" />
	<![endif]-->
	<!--[if IE 9]>
	<link href="css/styles-ie9.css" rel="stylesheet" type="text/css" />
	<![EndIf]-->
	<script language="JavaScript" src="js/ddsmoothmenu.js"></script>
	<script src="js/popup-gallery.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/validations.js"></script>
	<script type="text/javascript">
		ddsmoothmenu.init({
			mainmenuid: "smoothmenu1", //menu DIV id
			orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
			classname: 'ddsmoothmenu', //class added to menu's outer DIV
			contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
		});
		
		ddsmoothmenu.init({
			mainmenuid: "smoothmenu2", //menu DIV id
			orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
			classname: 'ddsmoothmenu2', //class added to menu's outer DIV
			contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
		});
		$(document).ready(function() {
				var order;
				$("#listtbl").sortable({
					handle : '.handle',
					update : function () {
						order = $("#listtbl").sortable('serialize');
					}
				});
				$("#btnSubmit").click(function() {
					$("#info").load("process-sortable.php?"+order);
					alert("Topics Order Updated Successfully");
				});
				
				$("#btnSubmit1").click(function() {
					$("#info").load("subtopics-sortable.php?"+order);
					alert("Sub Topics Order Updated Successfully");
				});
			});
	</script>
	<style type="text/css">
		.curve-mid {
			 min-height: 525px;
		}
	</style>
</head>