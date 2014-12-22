<?php
	$con = mysql_connect('localhost', 'root', '602410038') or die("DB connect fault!");
	//if(!$con){ echo "DB connect fault!";}
	//else echo "Connected!";
	mysql_select_db('youtube', $con);
	mysql_set_charset('utf8', $con);
?>