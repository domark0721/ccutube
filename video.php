<?php
	require 'vendor/autoload.php';
	use Parse\ParseClient;
	use Parse\ParseQuery;
	use Parse\ParseObject;
	use Parse\ParseUser;
	use Parse\ParseSessionStorage;
	ParseClient::initialize('DINPQbvlPessEzSCBOhW83NkxtDIniaWflDtVyav', 'pJnetpTKF1dNmyPOpwzXyVI73oIWNTq8UVNnA3AL', 'tC1QePDQzK5j4sqZMwaxyH1ef8nj0Fgpw5drnh1x');	
	include 'mongodb.php';

	session_start();
	ParseClient::setStorage( new ParseSessionStorage() );
	$user = ParseUser::getCurrentUser();

	$vid = $_GET['vid'];
	// echo $vid;
	$mongoQuery = array(
	 	'_id' => new MongoId($vid)
 	);

	//print_r($mongoQuery);
 	$videoInfo = $collection -> findOne($mongoQuery);
	//print_r($videoInfo);

 	// get video like count
 	$queryLikesNum = new ParseQuery("Like");
	$queryLikesNum->equalTo("vid", $vid);
	$videoLikesNum = count($queryLikesNum->find());

	//get current user history
	$queryHistory = new ParseQuery("History");
	$queryHistory->equalTo("user", $user);
	$queryHistory->equalTo("vid", $vid);
	$videoHistory = $queryHistory->find();
	$videoHistoryNum = count($videoHistory);

	//detele old history and set new
	if($videoHistoryNum){
		$videoHistoryData = $videoHistory[0];
		$videoHistoryData->destroy();
		$videoHistoryData->save();
		$like = new ParseObject("History");
		$like->set("vid", $vid);
		$like->set("user", $user);
		$like->save();
	}

	//first view
	if(!$videoHistoryNum){
		$like = new ParseObject("History");
		$like->set("vid", $vid);
		$like->set("user", $user);
		$like->save();
	}
	

	// $c = new MongoId($videoInfo['_id']) ;
	//echo $videoInfo['_id']; 

	//update viewCount

?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<?php
		require("css_common.php");
	?>
	<link type="text/css" rel="stylesheet" href="css/video.css">
	<title><?php echo $videoInfo['title']; ?> - CCUtube</title>
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
		<?php
			if(empty($videoInfo['isCCUtube'])) {
		?>
			<iframe src="http://www.youtube.com/embed/<?php echo $videoInfo['id'];?>">
			</iframe>
		<?php
			} else {
		?>
			<video controls>
			  <source src="<?php echo 'uploads/video/'. $videoInfo['id'] .'.mp4';?>" type="video/mp4">
			  Your browser does not support the video tag.
			</video>
		<?php
			}
		?>
		</div>

		<div id="videoInfo" class="infocard">
			<div class="title"><?php echo $videoInfo['title']; ?></div>
			<div class="author">提供者：<?php echo $videoInfo['author']; ?></div>
			<div class="published">發佈日期：<?php echo date("Y-m-d" ,strtotime($videoInfo['published'])); ?></div>
			<div class="viewcount">觀看次數：<?php echo number_format($videoInfo['viewCount']); ?></div>
			 
			<div class="control">
				<?php 
						$queryLikeOrNot = new ParseQuery("Like");
						$queryLikeOrNot->equalTo("user", $user);
						$queryLikeOrNot->equalTo("vid", $vid);
						$videoHistoryNum = count($queryLikeOrNot->find());
						if(!$videoHistoryNum){
				?>
				<span id="likeBtnCheck">
				<div class="video-button" id="likeBtn" vid="<?php echo $videoInfo['_id'];?>"><span id="likeCount"><?php echo $videoLikesNum ?></span> Like</div>
				</span>
				<?php
					} else {
				?>
				<div  class="video-button-yes" id="likeBtnYes" ><span id="likeCount"><?php echo $videoLikesNum ?></span> Like</div>
				<?php 
					}
				?>
				<?php 
						$queryLaterOrNot = new ParseQuery("Later");
						$queryLaterOrNot->equalTo("user", $user);
						$queryLaterOrNot->equalTo("vid", $vid);
						$videoLaterNum = count($queryLaterOrNot->find());
						if(!$videoLaterNum){
				?>
				<span id="laterBtnCheck">				
				<div class="video-button" id="laterBtn"  vid="<?php echo $videoInfo['_id'];?>"><span id="laterWatch">稍候觀看</span></div>
				</span>
				<?php
					} else{
				?>
				<div class="video-button-yes" id="laterBtn" ><span id="laterWatch">已加入</span></div>
				<?php
					}
				?>

				<span class="loading" style="display:none;"><img src="img/loader.gif"></span>
			</div>
		</div>

		<div id="videoContent" class="infocard"> 
			<div class="category">分類：<?php echo $videoInfo['category']; ?></div>
			<p><?php echo $videoInfo['content']; ?></p>
		</div>

		<div class="infocard">
		<div class="fb-comments" data-href="http://localhost/youtube/video.php?vid=<?php echo $vid;?>" data-numposts="5" data-width="100%" data-colorscheme="light"></div>
		</div>
	</div>

	<div id="rightRelated">
		<div id="relatedBar">
			<ul id="relativeList">
				<span class="relatedLoader"><img  src="img/loaderBig.gif"></span>
<!-- 					<li class="relatedItem">
						<div class="relatedPic"><img src="img/1.jpg"></div>
						<div class="relatedContent"><div class="relatedTitle" class="">【科學不一樣】廢棄物製作濾水器　調整酸鹼保護河川</div>
						<div class="relatedAuthor">by Mark</div>
						<div class="relatedViewcount"><i class="fa fa-eye"></i> 18492</div></div>
					</li> -->
			</ul>
		</div>
	</div>
	<?php
		require("js_common.php");
	?>	
	<script src="js/video.js"></script>
</body>

</html>