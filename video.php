<?php
	include 'mongodb.php';
	$vid = $_GET['vid'];
	echo $vid;
	$mongoQuery = array(
	 	'_id' => new MongoId($vid)
 	);

	//print_r($mongoQuery);
 	$videoInfo = $collection -> findOne($mongoQuery);
 	//print_r($mon);
?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<?php
		require("css_common.php");
	?>
	<link type="text/css" rel="stylesheet" href="css/video.css">
	<title>Video - CCUtube</title>
</head>

<body>
<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>

	<?php
		require("header.php");
	?>
	<main class="main-wrapper clearfix">
	<div id="leftVideo">
		<div id="video">
			<iframe src="http://www.youtube.com/embed/<?php echo $videoInfo['id'];?>">
			</iframe>
		</div>

		<div id="videoInfo" class="infocard">
			<div class="title"><?php echo $videoInfo['title']; ?></div>
			<div class="author">提供者：<?php echo $videoInfo['author']; ?></div>
			<div class="published">發佈日期：<?php echo date("Y-m-d" ,strtotime($videoInfo['published'])); ?></div>
			<div class="viewcount">觀看次數：<?php echo number_format($videoInfo['viewCount']); ?></div>
			 
			<div class="control">
				<div class="video-button">1,223 Like</div>
				<div class="video-button">稍候觀看</div>
			</div>
		</div>

		<div id="videoContent" class="infocard"> 
			<div class="category">分類：<?php echo $videoInfo['category']; ?></div>
			<p><?php echo $videoInfo['content']; ?></p>
		</div>

		<div class="infocard">
		<div class="fb-comments" data-href="http://localhost/youtube/video.php?vid=549605dcacfc62f259ac23ef" data-numposts="5" data-width="100%" data-colorscheme="light"></div>
		</div>
	</div>

	<div id="rightRelated">
		<div id="relatedBar">
		</div>
	</div>
</body>

</html>