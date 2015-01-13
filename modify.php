<?php
	require 'vendor/autoload.php';
	require 'mongodb.php';

	$vid = $_GET['vid'];
	$mongoQuery = array(
	 	'_id' => new MongoId($vid)
 	);
 	$videoInfo = $collection -> findOne($mongoQuery);
?>

<!doctype html>
<html>
<head>
	<?php
		require("css_common.php");
	?>
	<link type="text/css" rel="stylesheet" href="css/upload.css">
	<link type="text/css" rel="stylesheet" href="css/modify.css">
	<title>Modify - CCUtube</title>
</head>

<body>
	<?php
		require("header.php");
	?>

	<main class="main-wrapper clearfix">
		<div id="aboveVideo-contorl">
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
		</div>

		<div id="uploadInfo-control">
		<form id="uploadForm" method="POST" action="api/saveModify.php">
			<input type="hidden" id="videoId" name="videoId" value="<?php echo $vid;?>">
			<div id="aboveWrap">
				<div class="videoAuthorLeft">
					<div>
					<label for="author" class="id_author_inline">上傳者</label>
						<input class="formDisplayCSS" id="author" name="author" disabled value="<?php echo $currentUser->get('username');?>">
					</div>
				</div>
				<div class="videoIdRight">
					<div>
					<label for="videoIdShow" class="id_author_inline">video ID</label>
						<input class="formDisplayCSS" id="videoIdShow" name="videoIdShow" disabled type="text" value="<?php echo $videoInfo['id'];?>">
					</div>
				</div>
			<div>
			<div id="belowWrap">
				<div>
				<label for="title" class="belowInfo">標題</label>
					<input class="formDisplayCSS" id="title" name="title" type="text" value="<?php echo $videoInfo['title'];?>">
				</div>
				<div>
				<label for="category" class="belowInfo">類別</label>
					<select  class="formDisplayCSS" id="category" name="category">
						<option selected value="<?php echo $videoInfo['category'];?>"><?php echo $videoInfo['category'];?></option>
						<option value="Autos">Autos</option>
						<option value="Comedy">Comedy</option>
						<option value="Education">Education</option>
						<option value="Entertainment">Entertainment</option>
						<option value="Film">Film</option>
						<option value="Games">Games</option>
						<option value="Howto">Howto</option>
						<option value="Music">Music</option>
						<option value="Nonprofit">Nonprofit</option>
						<option value="People">People</option>
						<option value="Shows">Shows</option>
						<option value="Sports">Sports</option>
						<option value="Tech">Tech</option>
						<option value="Travel">Travel</option>
					</select>
				</div>
				<div>
				<label for="content" class="belowInfo">影片介紹</label>
					<textarea class="formDisplayCSS" id="content" name="content" row="8" cols="50" ><?php echo $videoInfo['content'];?></textarea>
				</div>
			<div>
				<div id="btnWrap">
					<div><a href="user.php" class="backDelete">上一頁</a></div>
					<div  class="submitBtn"><button type="reset" class="submitBtn">重設</button></div>
					<div  class="submitBtn"><button type="submit" class="submitBtn">更新</button></div>
					<div> <a href="api/deleteFile.php?vid=<?php echo $vid; ?>&id=<?php echo $videoInfo['id'];?>" class="backDelete">刪除</a>
				</div>
		</form>
	</div>
	</main>
</body>

</html>