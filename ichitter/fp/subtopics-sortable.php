<?php
require_once('library/include_files.php');

$log = new Logging();

$log->lwritearray($_REQUEST['listItem']);
die;

include("includes/dbobj.php");

foreach ($_GET['listItem'] as $position => $item) :
	$sql[] = "UPDATE `tbl_sub_topics` SET `priority` = ($position + 1) WHERE `sub_topic_id` = $item";
endforeach;

//$trans = mysql_query(begin);
for($i=0;$i<count($sql);$i++)
{
    mysql_query($sql[$i]);
}
/*
if (mysql_error())
{
mysql_query(rollback);
}
else
{
mysql_query(commit);
}
*/
//print_r ($sql);
?>