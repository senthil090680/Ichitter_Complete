<?php
/* This is where you would inject your sql into the database
  but we're just going to format it and send it back
 */
require_once 'includes/includes.inc';

foreach ($_GET['listItem'] as $position => $item) :
	$sql[] = "UPDATE `tbl_topics` SET `priority` = ($position + 1) WHERE `topics_id` = $item";
endforeach;

for ($i = 0; $i < count($sql); $i++) {
	mysql_query($sql[$i]);
}
?>