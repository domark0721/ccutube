<?php
	 $mongo = new  MongoClient("mongodb://admin:10038@localhost");
 
	$db=$mongo->youtube;
	$collection=$db->utubedata; //$collection相當於mysql的table
	                            // $mon = $collection->find();

?>
