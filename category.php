<?php

?>

<html>
<head>
	<meta charser="UTF-8">
	<?php
		require("css_common.php");
	?>
	<title>CCUtube - Category</title>
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
	     	<li><a>Title<a></li>
	     	<li><a>Viewcount</a></li>
	     </ul>
	      <div id="videolist-container">
	      	<ul id="videolist">    
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