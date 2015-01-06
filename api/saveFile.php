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

	$author = $user->username;
	$title = $_POST['title'];
	$category = $_POST['category'];
	$content = $_POST['content'];
	$id = $_POST['videoId'];

	$published = date('Y-m-d H:i:s');

	$json_doc = array(
		"id" =>(string) $id,
		"title" => $title,
		"published" => $published,
		"content" => $content,
		"category" =>$category,
		"duration" => 0, // check ffmpeg function
		"favoriteCount" => 0,
		"viewCount" => 0,
		"author" => $author,
		"keyword" => "",
		"uid" => "",
		"isCCUtube" => true
	);
	$collection->insert($json_doc); //insert to mongodb

	//build elasticsearch index
	$newInsertedId = (string) $json_doc['_id'];
	$indexData = array(
		'index'=>'youtube',
		'type'=>'utubedata',
		'id'=> $newInsertedId,
		'body'=>$json_doc
		);
	$ret = $esClient->index($indexData); 

	// parse: user video  record
	$userVideo = new ParseObject("userVideo");
	$userVideo->set("vid", $newInsertedId);
	$userVideo->set("user", $user);
	$userVideo->save();

	// redirect to user page
	header("location: ../user.php");

?>