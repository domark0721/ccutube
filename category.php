<?php

?>
<!doctype html>
<html>
<head>
	<?php
		require("css_common.php");
	?>
	<link type="text/css" rel="stylesheet" href="css/category.css">
	<title>Category - CCUtube</title>
</head>

<body>
	<?php
		require("header.php");
	?>
	<main class="main-wrapper clearfix">
	<div id="leftWrap">
	        <ul id="categoryNav">
		<li><a href="#" cate="animals" class="active">Animals</a></li>
		<li><a href="#" cate="autos">Autos</a></li>
		<li><a href="#" cate="comedy">Comedy</a></li>
		<li><a href="#" cate="education">Education</a></li>
		<li><a href="#" cate="entertainment">Entertainment</a></li>
		<li><a href="#" cate="film">Film</a></li>
		<li><a href="#" cate="games">Games</a></li>
		<li><a href="#" cate="howto">Howto</a></li>
		<li><a href="#" cate="music">Music</a></li>
		<li><a href="#" cate="nonprofit">Nonprofit</a></li>
		<li><a href="#" cate="people">People</a></li>
		<li><a href="#" cate="shows">Shows</a></li>
		<li><a href="#" cate="sports">Sports</a></li>
		<li><a href="#" cate="tech">Tech</a></li>
		<li><a href="#" cate="travel">Travel</a></li>
	        </ul>
	</div>

	<div id="rightWrap">
	     <ul id="howtoDisplay">
	     	<li>order by</li>
	     	<li><a class="clicked" id="orderByDuration" href="#">Duration</a></li>
	     	<li><a class="clicked" id="orderByViewcount" href="#">Viewcount</a></li>
	     	<li><span class="loading" style="display:none;"><img src="img/loader.gif"></span></li>
	     </ul>
	      <div id="videolist-container">
	      	<ul id="videolist">
	      		<span class="relatedLoader"><img  src="img/loaderBig.gif"></span>
	      	</ul>
	      </div>
	</div>
	</main>
	<?php
		require("js_common.php");
	?>
	<script src="js/category.js"></script>

</body>

</html>