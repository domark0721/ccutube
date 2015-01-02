<?php
	require '../vendor/autoload.php';
	require '../mongodb.php';
	$esClient = new Elasticsearch\Client();

	if(!empty(($_GET['category']))) {
		$category = $_GET["category"];

		$search_category =
		'{
			"query":{
				"match": {"category": "'.$category.'"}
			},
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
	}
?>