<?phpഀ
ഀ
    session_start();ഀ
    error_reporting(0);ഀ
ഀ
    include("includes/session_check.php");ഀ
    include("includes/dbobj.php");ഀ
ഀ
    include("includes/class.topics.php");ഀ
    include("includes/messages.php");ഀ
    $message    =    urldecode($_REQUEST['msg']);ഀ
ഀ
?>ഀ
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">ഀ
<html xmlns="http://www.w3.org/1999/xhtml">ഀ
<head>ഀ
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />ഀ
<title>FrontedPage - Admin</title>ഀ
<link href="css/style.css" rel="stylesheet" type="text/css">ഀ
<!--script language="JavaScript" src="js/jquery.js"></script-->ഀ
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>ഀ
<script type="text/javascript" src="js/jquery-ui-1.7.1.custom.min.js"></script>ഀ
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />ഀ
<script language="JavaScript" src="js/ddsmoothmenu.js"></script>ഀ
<script language="JavaScript" src="js/validations.js"></script>ഀ
<script type="text/javascript">ഀ
ഀ
ddsmoothmenu.init({ഀ
    mainmenuid: "smoothmenu1", //menu DIV idഀ
    orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"ഀ
    classname: 'ddsmoothmenu', //class added to menu's outer DIVഀ
    contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]ഀ
})ഀ
$(document).ready(function() {ഀ
    $("#listtbl").sortable({ഀ
      handle : '.handle',ഀ
      update : function () {ഀ
          var order = $('#listtbl').sortable('serialize');ഀ
          $("#info").load("ordertopics.php?"+order);ഀ
      }ഀ
    });ഀ
});ഀ
ഀ
</script>ഀ
</head>ഀ
ഀ
<body>ഀ
 <form name="frmedittopics" action="topicsupdate.php?action=edittopics" method="post" enctype="multipart/form-data">ഀ
<div id="container">ഀ
    <div id="wrapper">ഀ
         <?php include("header.php"); ?>ഀ
ഀ
        <div class="middle-section">ഀ
           <div class="width">ഀ
             <span class="curve-top-left"></span>ഀ
             <span class="curve-top-mid"></span>ഀ
             <span class="curve-top-right"></span>ഀ
           </div>ഀ
           <div class="curve-mid">ഀ
             <h1>List - Topics </h1>ഀ
             <div class="form">ഀ
                 <ul class="form-area">ഀ
                    <li class="form-name">ഀ
                         &nbsp;ഀ
                        <?phpഀ
                          if(isset($message))ഀ
                            {ഀ
                                echo $$message;ഀ
                            }ഀ
                        ?>ഀ
                    </li>ഀ
ഀ
                </ul>ഀ
                <ul id="info">ഀ
ഀ
                </ul>ഀ
                <table width="95%" border="0" align="center" cellpadding="0"  cellspacing="0">ഀ
ഀ
                <tr>ഀ
                    <td height="400">ഀ
                        <?phpഀ
                            $topics    =    new topics;ഀ
                            $result = $topics->get_allthetopics();ഀ
                            echo "<br><br><ul id='listtbl' bgcolor='#e4e4e4'>";ഀ
                            //echo "<li bgcolor='#793318' class='admintitle' style='color:#ffffff;' >Title</li>";ഀ
ഀ
                            while($row = mysql_fetch_row($result))ഀ
                            {ഀ
                                echo "<li style='padding:10px;background-color:#f4f4f4;' class='handle' >$row[1]</li>";ഀ
                            }ഀ
                            echo "</ul><br>";ഀ
                        ?>ഀ
                    </td>ഀ
                </tr>ഀ
                </table>ഀ
ഀ
             </div>ഀ
           </div>ഀ
           <div class="width">ഀ
             <span class="curve-bot-left"></span>ഀ
             <span class="curve-bot-mid"></span>ഀ
             <span class="curve-bot-right"></span>ഀ
           </div>ഀ
        </div>ഀ
ഀ
        <div id="footer">ഀ
          <div class="footernavi">ഀ
ഀ
           <div class="copyright">© 2011</div>ഀ
           </div>ഀ
         </div>ഀ
ഀ
    </div>ഀ
ഀ
</div>ഀ
</form>ഀ
</body>ഀ
</html>ഀ
