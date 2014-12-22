<?php
	include 'mongodb.php';

	$fileContent="";
	$id="";
	$title="";
	$published="";
	$content="";
	$category="";
	$duration="";
	$favoriteCount="";
	$viewCount="";
	$author="";
	$uid="";

	$num=1;

	$time_start = microtime(true);
	$fileOpen = fopen("y1_20.rec","r");
	while (!feof($fileOpen)) {
		$fileContent= fgets($fileOpen);
		//echo $fileContent;

		if(stripos($fileContent, "@id:")!==false) //判斷是否有@id:的字串
		{
			$id = preg_split("/@[^:]+:/", $fileContent);
			//var_dump($id);
		}
		elseif(stripos($fileContent, "@title:")!==false)
		{
			$fileContent=str_replace('"', '\"', $fileContent); //Mysql insert會有問題
			$fileContent=str_replace("'", "\'", $fileContent); //Mysql insert會有問題
			$title = preg_split("/@[^:]+:/", $fileContent);
		}
		elseif(stripos($fileContent, "@published:")!==false)
		{
			$fileContent=str_replace("T", " ", $fileContent);
			$fileContent=str_replace(".000Z", "", $fileContent);
			$published = preg_split("/@[^:]+:/", $fileContent);
		}
		elseif(stripos($fileContent, "@content:")!==false)
		{
			$fileContent=str_replace('"', '\"', $fileContent); //Mysql insert會有問題
			$fileContent=str_replace("'", "\'", $fileContent); //Mysql insert會有問題			
			$fileContent=str_replace("@ ", "", $fileContent); //@會導致顯示錯誤	
			$content = preg_split("/@[^:]+:/", $fileContent);
		}
		elseif(stripos($fileContent, "@category:")!==false)
		{
			$category = preg_split("/@[^:]+:/", $fileContent);
		}
		elseif(stripos($fileContent, "@duration:")!==false)
		{
			$duration = preg_split("/@[^:]+:/", $fileContent);
		}
		elseif(stripos($fileContent, "@favoriteCount:")!==false)
		{
			$favoriteCount = preg_split("/@[^:]+:/", $fileContent);
		}
		elseif(stripos($fileContent, "@\$viewCount:")!==false)
		{
			$viewCount = preg_split("/@[^:]+:/", $fileContent);
		}
		elseif(stripos($fileContent, "@author:")!==false)
		{
			$author = preg_split("/@[^:]+:/", $fileContent);
		}
		elseif(stripos($fileContent, "@_uid:")!==false)
		{
			$uid = preg_split("/@[^:]+:/", $fileContent);

			/*print_r($id);echo "<br>";print_r($title);echo "<br>";
			print_r($published);echo "<br>";print_r($content);echo "<br>";
			print_r($category);echo "<br>";print_r($duration);echo "<br>";
			print_r($favoriteCount);echo "<br>";print_r($viewCount);echo "<br>";
			print_r($author);echo "<br>";print_r($uid);echo "<br><br>";	*/		
			/*var_dump($id);var_dump($title);var_dump($published);
			var_dump($content);var_dump($category);var_dump($duration);
			var_dump($favoriteCount);var_dump($viewCount);var_dump($author);var_dump($uid)*/
			$json_doc = array(
                "id" => $id[1],
                "title" => $title[1],
                "published" => $published[1],
                "content" => $content[1],
				"category" =>$category[1],
				"duration" =>$duration[1],
				"favoriteCount" => $favoriteCount[1],
				"viewCount" => $viewCount[1],
				"author" => $author[1],
				"uid" =>$uid[1]
            );
//var_dump($json_doc);
			$rs=$collection->insert($json_doc);
		}

	}

	$time_end= microtime(true);

	echo $time_end-$time_start."seconds.";

	fclose($fileOpen);

?>