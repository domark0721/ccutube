<?php		
	if(!empty($_GET['keyword'])){
	 	require 'vendor/autoload.php';
	 	include 'mongodb.php';
	 	$keyword = $_GET['keyword'];

	 	// $t1 = array('text' => array('$search' => $keyword));
	 	$esClient = new Elasticsearch\Client();
		$search_keyword =
		'{
			"query":{
				"multi_match" : {
					"query" : "'.$keyword.'",
					"fields" : ["title","content"]
				}
			},
			"size": 20
		}';

		$searchQuery = array(
			'index' => 'youtube',
			'type' => 'utubedata',
			'body' => $search_keyword
		);

		$results = $esClient->search($searchQuery);
		//print_r($results);

		$ids = array();
		foreach($results['hits']['hits'] as $value){
		 	$ids[] = new MongoId($value['_id']);
		 }
		 //print_r($ids);
		$mongoQuery = array(
		 	'_id' => array(
		 		'$in' => $ids
		 		)
		 	);
		$mon = $collection -> find($mongoQuery);
		// print_r($mon);
		$totalresult = $results['hits']['total'];
	 }
?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<?php
		require("css_common.php");
		$keywordTitle = $_GET['keyword'];
		echo ('<title>'. $keywordTitle .' - CCUtube </title>')
	?>
	
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
			<?php
				foreach($mon as $doc){
				   echo ('<li class="videoItem" ><div class="videoCard"><div class="video-img" ><img src="http://img.youtube.com/vi/'. $doc['id']. '/mqdefault.jpg"></div>');
			    	   echo ('<div class="video-info"><a href="video.php?vid='. $doc['_id'].'">'. $doc['title'] .'</a><span class="video-info-author">by ' .$doc['author']. '</span>');
			      	   echo ('<span><i class="fa fa-eye"> '.$doc['viewCount'].'</i><i class="fa fa-clock-o"> '.$doc['duration'].'</i><i class="fa fa-cloud-upload"> '.$doc['published'].'</i></span>');
			     	   echo ('<p class="video-content">"+"put content here"+"</p></div></div></li>');
				}		
			?>
	      	</ul>
	      </div>
	</div>
	</main>
	<?php
		require("js_common.php");
	?>
</body>

</html>




