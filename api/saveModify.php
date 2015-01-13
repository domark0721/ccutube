<?php
	require '../vendor/autoload.php';
	require '../mongodb.php';
	$esClient = new Elasticsearch\Client();
	use Parse\ParseClient;
	use Parse\ParseUser;
	use Parse\ParseSessionStorage;
	use Parse\ParseObject;
	use Parse\ParseQuery;
	ParseClient::initialize('DINPQbvlPessEzSCBOhW83NkxtDIniaWflDtVyav', 'pJnetpTKF1dNmyPOpwzXyVI73oIWNTq8UVNnA3AL', 'tC1QePDQzK5j4sqZMwaxyH1ef8nj0Fgpw5drnh1x');

	session_start();
	ParseClient::setStorage( new ParseSessionStorage() );
	$user = ParseUser::getCurrentUser();

	$vid = $_POST['videoId'];
	$title = $_POST['title'];
	$category = $_POST['category'];
	$content = $_POST['content'];
	// echo $vid;

	//update to mongo
	$mongoid = array('_id' => new MongoId($vid));
	$updateCol = array('$set' => array('title' => $title, 'category' => $category, 'content' =>$content));
	$collection->update(
		$mongoid, 
		$updateCol
		); 

	//update to elasticsearch
	$json_doc = array(
		"title" => $title,
		"category" => $category,
		"content" => $content
	);

	$indexData = array(
		'index'=>'youtube',
		'type'=>'utubedata',
		'id'=> $vid,
		'body'=>array(
			'doc' => $json_doc 
			)
		);

	$ret = $esClient->update($indexData);


	// redirect to user page
	header("location: ../user.php");

?>