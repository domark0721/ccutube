<?php
	require 'vendor/autoload.php';
	require 'mongodb.php';

	$esClient = new Elasticsearch\Client();

	$topViewCount =
	'{
		"sort" :[
			{ "viewCount" : "desc" }
		],
		"query":{
			"match_all": {}
		},
		"size": 18
	}';

	$searchQuery = array(
		'index' => 'youtube',
		'type' => 'utubedata',
		'body' => $topViewCount
		);
	$topViewCountResults = $esClient->search($searchQuery);

	$ViewCountIds = array();
	foreach($topViewCountResults['hits']['hits'] as $value){
	 	$ViewCountIds[] = new MongoId($value['_id']);
	 }
	 // print_r($ViewCountIds);
	$mongoQuery = array(
	 	'_id' => array(
	 		'$in' => $ViewCountIds
	 		)
	 	);
	$topViewCountMon = $collection->find($mongoQuery);
?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<?php
		require("css_common.php");
	?>
	<link type="text/css" rel="stylesheet" href="css/index.css">
	<title>CCUtube</title>
</head>

<body>
	<?php
		require("header.php");
	?>

	<main class="main-wrapper clearfix">
		<div class="topChart">
			<div class="topChartTitle">最夯影片</div>
			<ul id="topChart-videolist">
			<?php
			foreach($topViewCountMon as $doc){
				echo ('<li class="videoItem" ><div class="videoCard"><div class="video-img" ><img src="http://img.youtube.com/vi/'. $doc['id']. '/mqdefault.jpg"></div>');
		  		echo ('<div class="video-info"><a href="video.php?vid='. $doc['_id'].'">'. $doc['title'] .'</a><span class="video-info-author">by ' .$doc['author']. '</span>');
	    	 		echo ('<span><i class="fa fa-eye"> '.number_format($doc['viewCount']).'</i><i class="fa fa-clock-o"> '.$doc['duration'].'</i><i class="fa fa-cloud-upload"> '.$doc['published'].'</i></span>');
	      	   		echo ('<p class="video-content">"+"put content here"+"</p></div></div></li>');						
			}	
			?>	
			</ul>
		</div>
		<div class="topChart">
			<div class="topChartTitle">最新影片</div>
			<div id="topChart-videolist">
				
			</div>
		</div>
	</main>
</body>

</html>