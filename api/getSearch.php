<?php
	require '../vendor/autoload.php';
	$esClient = new Elasticsearch\Client();
	echo "123";
	if(!empty(($_GET['keyword']))){
		$keyword = $_GET['keyword'];

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
		echo json_encode($results['hits']);
	}	


?>