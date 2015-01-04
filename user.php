<?php

?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<?php
		require("css_common.php");
	?>
	<link type="text/css" rel="stylesheet" href="css/user.css">
	<title>Mark - CCUtube</title>
</head>

<body>
	<?php
		require("header.php");
	?>
	<main class="main-wrapper clearfix">
	<div id="leftWrap">
		<div id="userpic"></div>
		<div id="username"><?php echo $currentUser->get("username");?></div>
	       <ul id="categoryNav">
		<li><a href="#" id="myVideo" class="active">我的影片</a></li>
		<li><a href="#" id="myLater">稍候觀看</a></li>
		<li><a href="#" id="myHistory">觀看紀錄</a></li>
		<li><a href="#" id="myLike">喜歡的影片</a></li>
		<li><a href="#" id="upload">上傳影片</a></li>		
	        </ul>
	</div>

	<div id="rightWrap">
	      <div id="videolist-container">
		      	<ul id="videolist">    
		      	</ul>
	      </div>	
	</div>
	</main>

	<?php
		require("js_common.php");
	?>
	<script src="js/user.js"></script>
</body>

</html>