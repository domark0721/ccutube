<?php		
	 	require '../vendor/autoload.php';
	 	include '../mongodb.php';
	 	$videoTitle = $_POST['title'];
	 	//echo $videoTitle;
	 	// $t1 = array('text' => array('$search' => $keyword));
	 	$esClient = new Elasticsearch\Client();
	 	$videoTitle=str_replace("the", "", $videoTitle);
	 	$videoTitle=str_replace("a", "", $videoTitle);
	 	$videoTitle=str_replace(",", "", $videoTitle); 
	 	$videoTitle=str_replace("an", "", $videoTitle);
	 	$videoTitle=str_replace("-", "", $videoTitle);
	 	$videoTitle=str_replace("...", "", $videoTitle);

		$search_keyword =
		'{
			"query":{
				"multi_match" : {
					"query" : "' . $videoTitle . '",
					"fields" : ["title","content"],
					"operator": "or"
				}
			},
			"size": 15
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
		
		$videoList = array();
		foreach($mon as $video){
			$videoList[] =$video;
		}

		$result = array(
			"video" => $videoList
		);
		
		echo json_encode($result);
?>