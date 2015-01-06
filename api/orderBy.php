<?php
	require '../vendor/autoload.php';
	require '../mongodb.php';
	$esClient = new Elasticsearch\Client();
		
		$category = $_GET["category"];
		$orderCol= $_GET['orderCol'];

		$search_category =
		'{
			"query":{
				"match": {"category": "'.$category.'"}
			},
			"sort":[
				{"'.$orderCol.'" : {"order" : "desc"}}
			],
			"size": 21
		}';
		//print_r($search_category);

		$searchQuery = array(
			'index' => 'youtube',
			'type' => 'utubedata',
			'body' => $search_category
			);
		$results = $esClient->search($searchQuery);

		echo json_encode($results['hits']);
?>