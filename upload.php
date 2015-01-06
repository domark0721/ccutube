<?php

?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<?php
		require("css_common.php");
	?>
	<link type="text/css" rel="stylesheet" href="css/upload.css">
	<title>上傳 - CCUtube</title>
</head>

<body>
	<?php
		require("header.php");
	?>
</body>
	<main class="main-wrapper clearfix">
	<div class="videoUploadWrapper">
		<p>Please drap video here</p>
		<div id="uploadVideoArea"  draggable="true">
		</div>
		<div id="uploadVideoName"></div>
		<div id="uploadVideoProgress">0%</div>
	</div>
	<div id="uploadInfo-control">
		<form id="uploadForm" method="POST" action="api/saveFile.php">
			<div>
			<label for="author">video ID</label>
				<input class="formDisplayCSS" id="videoIdShow" name="videoIdShow" disabled type="text">
				<input type="hidden" id="videoId" name="videoId">
			</div>
			<div>
			<label for="author">上傳者</label>
				<input class="formDisplayCSS" id="author" name="author" disabled value="<?php echo $currentUser->get('username');?>">
			</div>
			<div>
			<label for="title">標題</label>
				<input class="formDisplayCSS" id="title" name="title" type="text">
			</div>
			<div>
			<label for="category">類別</label>
				<select  class="formDisplayCSS" id="category" name="category">
					<option selected value="">==Category==</option>
					<option value="Animals">Animals</option>
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
			<label for="content">影片介紹</label>
				<textarea class="formDisplayCSS" id="content" name="content" row="4" cols="50"></textarea>
			</div>
				<div  class="submitBtn"><button type="submit">上傳</button></div>
		</form>
	</div>
	</main>
	<?php
		require("js_common.php");
	?>
	<script src="js/upload.js"></script>
</html>