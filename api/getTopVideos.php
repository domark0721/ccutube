<?php
	require '../vendor/autoload.php';
	require '../mongodb.php';

	$esClient = new Elasticsearch\Client();

	$topViewCount =
	'{
		"sort" :[
			{ "duration" : "desc" }
		],
		"query":{
			"match_all": {}
		},
		"size": 8
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
	$mon = $collection -> find($mongoQuery);
	print_r($mongoQuery);
	//$totalresult = $results['hits']['total'];	
?>