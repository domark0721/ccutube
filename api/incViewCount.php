<?php
	require '../vendor/autoload.php';
	require '../mongodb.php';

	$vid = $_GET['vid'];

	$mongoid = array('_id' => new MongoId($vid));
	$incViewCount = array('$inc' => array('viewCount' => 1));
	$collection->update(
		$mongoid, 
		$incViewCount
		); 	
	
	echo "increase+1";
?>