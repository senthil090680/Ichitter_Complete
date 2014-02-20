<div id="header">
	<span class="logo"><span></span></span>
	<div id="headerRight">
		<div class="headerNav">
			<ul>
				<li><a href="changepassword.php">Change Password</a></li>
				<li><a href="resetlogin.php" >Log Out</a></li>
			</ul>
			<div class="welcome">Welcome <?php echo $_SESSION['user_name']; ?>
						<br/><span style="font-size:9px;">Last loggedin: <?php echo date("m-d-Y H:i:s", strtotime($_SESSION['last_logged'])); ?></span>
			</div>
		</div>

	</div>
</div>

<div id="smoothmenu1" class="ddsmoothmenu">
	<ul class="flt">
		<li style="border-right:none;" class="menu-left"></li>
		
		<li>
			<a href="javascript:void(0);"><span>Topics</span></a>
			<ul>
				<li><a href="Add_Topics.php"><span>Add Topic</span></a></li>
				<li><a href="topics_list.php"><span>List Topics</span></a></li>
				<li><a href="ordertopics.php"><span>Set Topic Order</span></a></li>
			</ul>
		</li>
		<li>
			<a href="javascript:void(0);"><span>Sub Topics</span></a>
			<ul>
				<li><a href="Add_SubTopics.php"><span>Add Sub Topic</span></a></li>
				<li><a href="subtopics_list.php"><span>List Sub Topics</span></a></li>
				<li><a href="ordersubtopics.php"><span>Set Sub Topic Order</span></a></li>
			</ul>
		</li>
		<li>
			<a href="javascript:void(0);"><span>User Details</span></a>
			<ul>
				<li><a href="viewusers.php"><span>List Users</span></a></li>
			</ul>
		</li>
	</ul>
	
</div>