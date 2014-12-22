<?php
	include '../mongo/mongodb.php';

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
	$keyword="";
	$uid="";

	$flag_id=0; 		$flag_title=0;
	$flag_published=0;	$flag_content=0;
	$flag_category=0;	$flag_duration=0;
	$flag_favoriteCount=0;	$flag_viewCount=0;
	$flag_author=0;		$flag_keyword=0;
	
	$temp_count = 0;

	$total_count=1;
	$error_count=1;
	$time_start = microtime(true);
	$fileOpen = fopen("y1_20.rec","r");
	//$fileOpen = fopen("1134err.txt","r");
	//$fileOpen = fopen("899err.txt","r");
	echo "open the data!\n";
	while (!feof($fileOpen)) {
		$fileContent= fgets($fileOpen);
		//echo $fileContent;

		if(stripos($fileContent, "@id:")!==false) //判斷是否有@id:的字串
		{
			$id = preg_split("/@[^:]+:/", $fileContent);
			$fileContent=str_replace("\n", "", $fileContent);//結尾符號
			$fileContent=str_replace("\r", "", $fileContent);//結尾符號
			//var_dump($id);
			$flag_id=1;
		}
		elseif(stripos($fileContent, "@title:")!==false)
		{
			$fileContent=str_replace("@title:", "title:", $fileContent); 
			//$fileContent=str_replace("\\", "\\\\", $fileContent); //Mysql insert會有問題
			$fileContent=str_replace("@", "", $fileContent); //@會導致顯示錯誤
			$fileContent=str_replace("title:", "@title:", $fileContent); 
			//$fileContent=str_replace('"', '\"', $fileContent); //Mysql insert會有問題
			//$fileContent=str_replace("'", "\'", $fileContent); //Mysql insert會有問題
			$fileContent=str_replace("\x", "", $fileContent); //@會導致顯示錯誤
			$fileContent=str_replace("\n", "", $fileContent); //結尾符號
			$fileContent=str_replace("\r", "", $fileContent);//結尾符號
			$title = preg_split("/@[^:]+:/", $fileContent);
			$flag_title=1;
		}
		elseif(stripos($fileContent, "@published:")!==false)
		{
			$fileContent=str_replace("T", " ", $fileContent);
			$fileContent=str_replace(".000Z", "", $fileContent);
			$fileContent=str_replace("\n", "", $fileContent); //結尾符號
			$fileContent=str_replace("\r", "", $fileContent);//結尾符號
			$published = preg_split("/@[^:]+:/", $fileContent);
			$flag_published=1;
		}
		elseif(stripos($fileContent, "@content:")!==false)
		{			
			$fileContent=str_replace("@content:", "content:", $fileContent); 
			//$fileContent=str_replace("\\", "\\\\", $fileContent); //Mysql insert會有問題
			//$fileContent=str_replace('"', '\"', $fileContent); //Mysql insert會有問題
			//$fileContent=str_replace("'", "\'", $fileContent); //Mysql insert會有問題			
			//$fileContent=str_replace("@ ", "", $fileContent); //@會導致顯示錯誤
			$fileContent=str_replace("@", "", $fileContent); //@會導致顯示錯誤
			$fileContent=str_replace("content:", "@content:", $fileContent); 
			$fileContent=str_replace("\n", "", $fileContent); //結尾符號
			$fileContent=str_replace("\r", "", $fileContent);//結尾符號
			$content = preg_split("/@[^:]+:/", $fileContent);
			$flag_content=1;
		}
		elseif(stripos($fileContent, "@category:")!==false)
		{
			$fileContent=str_replace("\n", "", $fileContent); //結尾符號
			$fileContent=str_replace("\r", "", $fileContent);//結尾符號
			$category = preg_split("/@[^:]+:/", $fileContent);
			$flag_category=1;
		}
		elseif(stripos($fileContent, "@duration:")!==false)
		{
			$duration = preg_split("/@[^:]+:/", $fileContent);
			$flag_duration=1;
		}
		elseif(stripos($fileContent, "@favoriteCount:")!==false)
		{
			$favoriteCount = preg_split("/@[^:]+:/", $fileContent);
			$flag_favoriteCount=1;
		}
		elseif(stripos($fileContent, "@\$viewCount:")!==false)
		{
			$viewCount = preg_split("/@[^:]+:/", $fileContent);
			$flag_viewCount=1;
		}
		elseif(stripos($fileContent, "@author:")!==false)
		{
			$fileContent=str_replace("@author:", "author:", $fileContent); 
			//$fileContent=str_replace("\\", "\\\\", $fileContent); //Mysql insert會有問題
			$fileContent=str_replace("@", "", $fileContent); //@會導致顯示錯誤
			$fileContent=str_replace("author:", "@author:", $fileContent); 
			//$fileContent=str_replace('"', '\"', $fileContent); //Mysql insert會有問題
			//$fileContent=str_replace("'", "\'", $fileContent); //Mysql insert會有問題
			$fileContent=str_replace("\n", "", $fileContent); //結尾符號
			$fileContent=str_replace("\r", "", $fileContent);//結尾符號
			$author = preg_split("/@[^:]+:/", $fileContent);
			$flag_author=1;
		}
		elseif (stripos($fileContent, "@keyword:")!==false) //特殊欄位
		{
			$fileContent=str_replace("@keyword:", "keyword:", $fileContent); 
			$fileContent=str_replace("\\", "\\\\", $fileContent); //Mysql insert會有問題
			$fileContent=str_replace("@", "", $fileContent); //@會導致顯示錯誤
			$fileContent=str_replace("keyword:", "@keyword:", $fileContent); 
			$fileContent=str_replace('"', '\"', $fileContent); //Mysql insert會有問題
			$fileContent=str_replace("'", "\'", $fileContent); //Mysql insert會有問題			
			$fileContent=str_replace("\n", "", $fileContent); //結尾符號
			$fileContent=str_replace("\r", "", $fileContent);//結尾符號
			$keywordStr = preg_split("/@[^:]+:/", $fileContent);
			$keyword = explode(",",$keywordStr[1]);
			$flag_keyword=1;
		}
		elseif(stripos($fileContent, "@_uid:")!==false)
		{
			$uid = preg_split("/@[^:]+:/", $fileContent);

			if($flag_id==0){$id = array("",NULL);}
			if($flag_title==0){$title = array("",NULL);}
			if($flag_published==0){$published = array("",NULL);}
			if($flag_content==0){$content = array("",NULL);}
			if($flag_category==0){$category = array("",NULL);}
			if($flag_duration==0){$duration = array("",NULL);}
			if($flag_favoriteCount==0){$favoriteCount = array("",NULL);}
			if($flag_viewCount==0){$viewCount = array("",NULL);}
			if($flag_author==0){$author = array("",NULL);}
			if($flag_keyword==0){$keyword = array("",NULL);}
			/*print_r($id);echo "<br>";print_r($title);echo "<br>";
			print_r($published);echo "<br>";print_r($content);echo "<br>";
			print_r($category);echo "<br>";print_r($duration);echo "<br>";
			print_r($favoriteCount);echo "<br>";print_r($viewCount);echo "<br>";
			print_r($author);echo "<br>";print_r($keyword);echo "<br>";
			print_r($uid);echo "<br><br>";*/
			
			/*var_dump($id);var_dump($title);var_dump($published);
			var_dump($content);var_dump($category);var_dump($duration);
			var_dump($favoriteCount);var_dump($viewCount);var_dump($author);var_dump($uid)*/
			$json_doc = array(
			              "id" => $id[1],
			              "title" => $title[1],
			              "published" => $published[1],
			              "content" => $content[1],
				"category" =>$category[1],
				"duration" => (int)$duration[1],
				"favoriteCount" => (int)$favoriteCount[1],
				"viewCount" => (int)$viewCount[1],
				"author" => $author[1],
				"keyword" => $keyword,
				"uid" => (int)$uid[1]
            				);
			//var_dump($json_doc);
			$collection->insert($json_doc);
			//var_dump($rs);



			$flag_id=0; 		$flag_title=0;
			$flag_published=0;	$flag_content=0;
			$flag_category=0;	$flag_duration=0;
			$flag_favoriteCount=0;	$flag_viewCount=0;
			$flag_author=0;		$flag_keyword=0;
			// $temp_count++;
			// if($temp_count == 50000)
			// 	break;
		}

	}
	$time_end= microtime(true);

	echo $time_end-$time_start." seconds.\n";
	fclose($fileOpen);
	

?>