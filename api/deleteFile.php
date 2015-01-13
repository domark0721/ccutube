<?php
	require '../vendor/autoload.php';
	include "../mongodb.php";
	$esClient = new Elasticsearch\Client();
	use Parse\ParseClient;
	use Parse\ParseUser;
	use Parse\ParseSessionStorage;
	use Parse\ParseQuery;
	ParseClient::initialize('DINPQbvlPessEzSCBOhW83NkxtDIniaWflDtVyav', 'pJnetpTKF1dNmyPOpwzXyVI73oIWNTq8UVNnA3AL', 'tC1QePDQzK5j4sqZMwaxyH1ef8nj0Fgpw5drnh1x');

	session_start();
	ParseClient::setStorage( new ParseSessionStorage() );
	// $user = ParseUser::getCurrentUser();

	$vid = $_GET['vid'];
	$id = $_GET['id'];
	//remove mongo
	$removeVid = array('_id' => new MongoID($vid));
	$collection->remove($removeVid);

	//remove elasticsearch
	$indexData = array(
		'index'=>'youtube',
		'type'=>'utubedata',
		'id'=> $vid
		);

	// $esClient->delete($indexData);	
	//remove parse
	$query = new ParseQuery("userVideo");
	$query->equalTo("vid", $vid);
	$removeDataList=$query->find();
	$removeData = $removeDataList[0];
	var_dump($removeData);
	$removeData->destroy();
	$removeData->save();
	
	//delete video and screenshot
	$fileName = $id. "." . $extension;
	$fileName = $id.".mp4";
	$screenshotName= $id. ".jpg";

	$DelVideoPath = "../uploads/video/" . $fileName;
	$DelscreenshotPath = "../uploads/screenshot/" . $screenshotName;
	
	if (file_exists($DelVideoPath)) { unlink ($DelVideoPath); }
	if (file_exists($DelscreenshotPath)) { unlink ($DelscreenshotPath); }

	// redirect to user page
	header("location: ../user.php");
?>