<?php
	require '../vendor/autoload.php';
	use Parse\ParseClient;
	use Parse\ParseUser;
	use Parse\ParseSessionStorage;
	use Parse\ParseException;
	ParseClient::initialize('DINPQbvlPessEzSCBOhW83NkxtDIniaWflDtVyav', 'pJnetpTKF1dNmyPOpwzXyVI73oIWNTq8UVNnA3AL', 'tC1QePDQzK5j4sqZMwaxyH1ef8nj0Fgpw5drnh1x');

	session_start();
	ParseClient::setStorage( new ParseSessionStorage() );

	$userid = $_POST['userid'];
	$userpwd = $_POST['userpwd'];

	try {
	  	$user = ParseUser::logIn($userid, $userpwd);
	  	Header("Location: ../user.php");
	  	// Hooray! Let them use the app now.
	} catch (ParseException $error) {
	  	// Show the error message somewhere and let the user try again.
		echo "hi";
	  	Header("Location: ../login.php?login=false");

	}	
?>
