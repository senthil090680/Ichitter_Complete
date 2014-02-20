<div id="disc-container" >
	<table  border="0" cellpadding="0" cellspacing="0">
		<tr bgcolor="#FFFFFF">
		  <td class="select-box">
				<label>Sort By</label>
				<select style="border:1px solid #278db8;">
					<option>Article</option>
					<option>User</option>
					<option>Most responded to</option>
					<option>Most recent</option>
					<option>My responses</option>
					<option>New responses</option>
					<option>I was responded to</option>
				</select>					</td>
		  <td valign="bottom" class="mine-btn">&nbsp;</td>
		  <td valign="bottom" class="other-btn">&nbsp;</td>
		  <td valign="bottom" class="new-btn">&nbsp;</td>
	  </tr>
	<?php
	$topic = "";
	$subtopic = "";
	$mine = "<span>Mine</span>";
	$other = "<span>Others</span>";
	$new = "<span>New</span>";
	$i = 1;
	$bg = "";
	foreach($posts as $idx => $post) {
		$bg = ($bg == "bg_light")? "bg_dark" : "bg_light";
		if($idx != '0') {
			$mine = "&nbsp;";
			$other = "&nbsp;";
			$new = "&nbsp;";
		}
		if($topic != $post['topic']) {
			$topic = $post['topic'];
	?>
		<tr bgcolor="#d2efff">
		  <td class="dischdtitle"><?php echo $topic; ?></td>
		  <td valign="center" class="mine-btn"><?php echo $mine; ?></td>
		  <td valign="center" class="other-btn"><?php echo $other; ?></td>
		  <td valign="center" class="new-btn"><?php echo $new; ?></td>
		</tr>
	<?php
		}
		if($subtopic != $post['subtopic']) {
			$subtopic = $post['subtopic'];
	?>
		<tr bgcolor="#f4f4f4">
		  <td class="dischdsubtitle"><?php echo $subtopic; ?></td>
		  <td bgcolor="#ebebeb" valign="bottom" class="mine-btn">&nbsp;</td>
		  <td bgcolor="#f4f4f4" valign="bottom" class="other-btn">&nbsp;</td>
		  <td bgcolor="#ebebeb" valign="bottom" class="new-btn">&nbsp;</td>
	  </tr>
	<?php
		}
	?>
	  <tr>
			<td class="disc-text trigger <?php echo $bg; ?>">
				<div class="morebtn">
					<a href="javascript: void(0);" id="more<?php echo $i; ?>">
						<img src="resource/images/bot-arrow.png" alt="" />
						<strong><?php echo $post['posted_date']; ?></strong>
					</a>
				</div>
				<div  id="history<?php echo $i; ?>" class="history" >
					<p><?php echo $post['post_content']; ?></p>
				</div>
			</td>
			<td class="mine-box"><a href="javascript: void(0);"><?php echo $post['mine']; ?></a></td>
			<td class="other-box"><a href="javascript: void(0);"><?php echo $post['others']; ?></a></td>
			<td class="new-box"><a href="javascript: void(0);"><?php echo $post['newpost']; ?></a></td>
		</tr>
	<?php	
		$i++;
	}
	?>
	</table>
</div>