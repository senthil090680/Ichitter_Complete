<?php
require_once('library/include_files.php');
$REQ_SEND = $REQ_SEND + $_REQUEST;


foreach ($_GET['listItem'] as $position => $item) :
	$sql[] = "UPDATE `tbl_topics` SET `priority` = ($position + 1) WHERE `topics_id` = $item";
endforeach;
for($i=0;$i<count($sql);$i++) {
    mysql_query($sql[$i]);
}
?>