
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<?php
		require("css_common.php");
	?>
	<link type="text/css" rel="stylesheet" href="css/user.css">
</head>

<body>
	<?php
		require("header.php");
		 if (!$currentUser){
		 	header("Location: login.php");
		 }
	?>

	<title><?php echo $currentUser->get("username");?> - CCUtube</title>
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

				<li class="videoItem" ><div class="videoCard"><div class="video-img" ><div class="modifyBtn"><a href="modify.php?vid=54b00ae7acfc6262558b4567" class="fontStyle">修改</a></div><img src="img/1.jpg"></div>
				<div class="video-info"><a href="video.php?vid=54b00ae7acfc6262558b4567">蔡東軒</a><span class="video-info-author">by Mark</span>
				<span><i class="fa fa-eye"> 12047498792</i><i class="fa fa-clock-o"> 256</i><i class="fa fa-cloud-upload"> 2015-01-06</i></span>
				<p class="video-content">蔡東軒蔡東軒蔡東軒</p></div></div></li>

		      	</ul>
	      </div>	
	</div>
	</main>

	<?php
		require("js_common.php");
	?>
</body>

</html>