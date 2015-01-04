<?php
	require '../vendor/autoload.php';
	use Parse\ParseClient;
	use Parse\ParseUser;
	use Parse\ParseSessionStorage;
	use Parse\ParseObject;
	use Parse\ParseQuery;
	ParseClient::initialize('DINPQbvlPessEzSCBOhW83NkxtDIniaWflDtVyav', 'pJnetpTKF1dNmyPOpwzXyVI73oIWNTq8UVNnA3AL', 'tC1QePDQzK5j4sqZMwaxyH1ef8nj0Fgpw5drnh1x');

	session_start();
	ParseClient::setStorage( new ParseSessionStorage() );
	$user = ParseUser::getCurrentUser();

	$vid =$_GET['vid'];

	// new 'like' record
	$like = new ParseObject("Like");
	$like->set("vid", $vid);
	$like->set("user", $user);
	$like->save();

	//count video total like
	$query = new ParseQuery("Like");
	$query->equalTo("vid", $vid);
	$videoLikes = $query->find();

	$result = array(
		"result" => "ok",
		"totalLike" => count($videoLikes)
	);

	echo json_encode($result);
?>