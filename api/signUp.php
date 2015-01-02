<?php
	require '../vendor/autoload.php';
	use Parse\ParseClient;
	use Parse\ParseUser;
	ParseClient::initialize('DINPQbvlPessEzSCBOhW83NkxtDIniaWflDtVyav', 'pJnetpTKF1dNmyPOpwzXyVI73oIWNTq8UVNnA3AL', 'tC1QePDQzK5j4sqZMwaxyH1ef8nj0Fgpw5drnh1x');

	$userNewid = $_POST['userNewid'];
	$userNewpwd = $_POST['userNewpwd'];

	$user = new ParseUser();
	$user->set("username", $userNewid);
	$user->set("password", $userNewpwd);

	try {
	  	$user->signUp();
	  	Header("Location: ../login.php?signup=true");
	  	// Hooray! Let them use the app now.
	} catch (ParseException $ex) {
	  	// Show the error message somewhere and let the user try again.
	  	echo "<script>alert(\"Error:". $ex->getCode() . " " . $ex->getMessage()."\");</script>";
	  	Header("Location: ../login.php?signup=false");

	}	
?>
