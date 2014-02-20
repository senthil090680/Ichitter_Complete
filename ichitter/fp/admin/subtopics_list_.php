<?php

    session_start();
    error_reporting(0);

    include("includes/session_check.php");
    include("includes/dbobj.php");

    include("includes/class.subtopics.php");
    include("includes/messages.php");
    $message    =    urldecode($_REQUEST['msg']);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>FrontedPage - Admin</title>
<link href="css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="js/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script language="JavaScript" src="js/ddsmoothmenu.js"></script>
<script language="JavaScript" src="js/validations.js"></script>
<script type="text/javascript">

ddsmoothmenu.init({
    mainmenuid: "smoothmenu1", //menu DIV id
    orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
    classname: 'ddsmoothmenu', //class added to menu's outer DIV
    contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})
</script>
</head>

<body>
 <form name="frmedittopics" action="topicsupdate.php?action=edittopics" method="post" enctype="multipart/form-data">
<div id="container">
    <div id="wrapper">
         <?php include("header.php"); ?>

        <div class="middle-section">
           <div class="width">
             <span class="curve-top-left"></span>
             <span class="curve-top-mid"></span>
             <span class="curve-top-right"></span>
           </div>
           <div class="curve-mid">
             <h1>List - Topics </h1>
             <div class="form">
                 <ul class="form-area">
                    <li class="form-name">
                         &nbsp;
                        <?php
                          if(isset($message))
                            {
                                echo $$message;
                            }
                        ?>
                    </li>

                </ul>
                <table width="95%" border="0" align="center" cellpadding="0"  cellspacing="0">
                <tr>
                     <td align="right">
                        <input type="button" id="btnOrder" name="btnOrder" onclick="RedirectToPriorityPage()" value="Set Topic Order">
                     </td>
                </tr>
                <tr>
                    <td height="400">
                        <?php
                            $topics    =    new subtopics;
                            $result = $topics->get_alltopics(10);
                            echo "<br><br><table border='0'  cellspacing='1' cellpadding='5' width='100%' bgcolor='#e4e4e4'>";
							echo "<tr><td bgcolor='#793318' class='admintitle' style='color:#ffffff;' >Title</td><td bgcolor='#793318' class='admintitle' style='color:#ffffff;'>Description</td><td bgcolor='#793318' class='admintitle' style='color:#ffffff;'>Image Name</td><td bgcolor='#793318' class='admintitle' style='color:#ffffff;' align='center'>Edit</td><td bgcolor='#793318' class='admintitle' style='color:#ffffff;' align='center'>Delete</td></tr>";

                            while($row = mysql_fetch_row($result))
							{
                                echo "<tr><td width='25%' style='padding:10px; background-color:#f4f4f4;' class='content'>$row[2]</td>";
                                echo "<td width='25%' style='padding:10px; background-color:#f4f4f4;' class='content'>$row[3]</td>";
                                echo "<td width='25%' style='padding:10px; background-color:#f4f4f4;' class='content'>$row[4]</td>";

                                echo "<td width='8%' style='padding-left:5px; background-color:#f4f4f4;' class='content' align='center'><a href='editsubtopics.php?editaction=edit&id=$row[0]'>Edit</a></td>";
                                echo "<td width='8%' style='padding-left:5px; background-color:#f4f4f4;' class='content' align='center'><a href='#' onclick='return deletesubtopics($row[0]);'>Delete</a></td></tr>\n";
                            }
                            echo "</table><br>";
                        ?>
                    </td>
                </tr>
                </table>

             </div>
           </div>
           <div class="width">
             <span class="curve-bot-left"></span>
             <span class="curve-bot-mid"></span>
             <span class="curve-bot-right"></span>
           </div>
        </div>

        <div id="footer">
          <div class="footernavi">

           <div class="copyright">© 2011</div>
           </div>
         </div>

    </div>

</div>
</form>
</body>
</html>
