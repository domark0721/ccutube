<?php
	require '../vendor/autoload.php';
	include "../mongodb.php";
	use Parse\ParseClient;
	use Parse\ParseUser;
	use Parse\ParseSessionStorage;
	// use Parse\ParseObject;
	use Parse\ParseQuery;
	ParseClient::initialize('DINPQbvlPessEzSCBOhW83NkxtDIniaWflDtVyav', 'pJnetpTKF1dNmyPOpwzXyVI73oIWNTq8UVNnA3AL', 'tC1QePDQzK5j4sqZMwaxyH1ef8nj0Fgpw5drnh1x');

	session_start();
	ParseClient::setStorage( new ParseSessionStorage() );
	$user = ParseUser::getCurrentUser();
	//get like videos 
	$query = new ParseQuery("userVideo");
	$query->equalTo("user", $user);
	//query.ascending("createdAt");
	$userLike = $query->find();

	//get from mongo
	$ids = array();
	foreach($userLike as $value){
	 	$ids[] = new MongoId($value->vid);
	 }
	 //print_r($ids);
	$mongoQuery = array(
	 	'_id' => array(
	 		'$in' => $ids
	 		)
	 	);
	$mon = $collection -> find($mongoQuery)->sort(array('published' => -1));

	//save to our array for api response
	$videoList = array();
	foreach($mon as $video){
		$videoList[] =$video;
	}

	$result = array(
		"video" => $videoList
	);

	echo json_encode($result);

?>