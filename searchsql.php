<head>
	<meta charset="UTF-8">
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
	<link type="text/css" rel="stylesheet" href="css/search.css"/> 
	<title>MySQL Search - Mark Tsai</title>

</head>
<body>
 
<form name="search" method="GET" action="search.php">
	<input id="keyword" type="text" name="keyword" placeholder="Input your keyword"> <br/><br/>
	<a>Order by: </a>
	<input class="checkbox" type="checkbox" name="ordercategory"><label>category</label>
	<input class="checkbox" type="checkbox" name="orderauthor"><label>author</label>
	<input class="checkbox" type="checkbox" name="orderviewcount"><label>view count</label>
	<input class="checkbox" type="checkbox"><br/>
	<select id="category" name="category"> 
		<option selected value="NULL">==Category==</option>
		<option value="NULL">All</option>
		<option value="Animals">Animals</option>
		<option value="Autos">Autos</option>
		<option value="Comedy">Comedy</option>
		<option value="Education">Education</option>
		<option value="Entertainment">Entertainment</option>
		<option value="Film">Film</option>
		<option value="Games">Games</option>
		<option value="Howto">Howto</option>
		<option value="Music">Music</option>
		<option value="Nonprofit">Nonprofit</option>
		<option value="People">People</option>
		<option value="Shows">Shows</option>
		<option value="Sports">Sports</option>
		<option value="Tech">Tech</option>
		<option value="Travel">Travel</option>
	</select>
	<input id="author" type="text" name="author" placeholder="Author"> <br/><br/>
	<input id="bdate" type="text" name="bdate" placeholder="YYYY-MM-DD"> <a>  ~  </a>
	<input id="fdate" type="text" name="fdate" placeholder="YYYY-MM-DD"><br/><br/>
	 <select id="abovebelow" name="abovebelow"> 
		<option selected value="NULL">View  &#8645;</option>
		<option value="above">Above</option>
		<option value="below">Below</option>
	</select>
	<input id="viewcount" type="text" name="viewcount" placeholder="View Count"> <br/><br/>
	<input class="gogo" type="submit" name="gogo" value="Search">
</form>
<?php
	if(isset($_GET["gogo"])){
		include 'mysqldb.php';

		$keyword = $_GET["keyword"];
		$category = $_GET["category"];
		$author = $_GET["author"];
		$bdate = $_GET["bdate"];
		$fdate = $_GET["fdate"];
		$abovebelow = $_GET["abovebelow"];
		$viewcount = $_GET["viewcount"];
		
		//page initial
		if(!isset($_GET["page"])){
			$page=1;
		}else{
			$page =intval($_GET["page"]); //確認頁數只能夠是數值資料
		};

		$sql = "SELECT* FROM utubedata WHERE (title LIKE '$keyword%' OR content LIKE '$keyword%' ) ";
		//echo $sql."<br/>";
		$yn_category = " AND category='$category'";
		$yn_author = " AND author LIKE '$author%'";
		$yn_bdate = " AND published > '$bdate'";
		$yn_fdate = " AND published < '$fdate'";
		$yn_above_view= " AND viewCount > '$viewcount'";
		$yn_below_view= " AND viewCount < '$viewcount'";

		// if(!isset($_GET['start']) ||  $_GET['start'] =="")
		// {
		// 	$start = 0;
		// } 
		
		if(isset($_GET['keyword']) && $keyword==""){
			echo "<div id='warning'>You don't input any keyword!</div>";
			//echo '<input type ="button" onclick="history.back()" value="&#8592;Back"></input>';
		}elseif((empty($_GET["bdate"] ) && !empty($_GET["fdate"]) ) || (  !empty($_GET["bdate"]) && empty($_GET["fdate"])) ) {
			echo "<div id='warning'>You have to fill out the both DATE GRIDS!</div>";
		}elseif ($_GET["bdate"] > $_GET["fdate"] ) {
			echo "<div id='warning'>Right date grid must be more than left date grid!</div>";
		}
		else{
			if($category!="NULL"){
				$sql = $sql . $yn_category;
				//echo $sql."<br/>";
			}
			if($author!=""){
				$sql = $sql . $yn_author;
			}
			if($bdate!=""){
				$sql = $sql . $yn_bdate;
				
			}
			if($fdate!=""){
				$sql = $sql . $yn_fdate;
			}
			if($_GET['abovebelow']=="above"){
				$sql = $sql . $yn_above_view;
			}
			if($_GET['abovebelow']=="below"){
				$sql = $sql . $yn_below_view;
				//echo $sql;
			}
			$time_start = microtime(true);  //timer start
			$result = mysql_query($sql) or die('MySQL query error');
			

			$items = mysql_affected_rows();//取得總項數,以便算出分頁須幾頁
			$totalresult=$items;

			if($items >=100){$items = 100;}
			//echo "start: ".$items ."<br/>";
			$per = 10;
			$pages = ceil($items/$per); //計算總頁數
			//echo "start: ".$pages ."<br/>";
			$start = ($page-1)*$per; 
			$sql = $sql . " LIMIT " .  $start  . "," . $per  ; 
			//echo $sql;

			$result = mysql_query($sql) or die('MySQL query error');
			
			
?>
</div>
<div class="time-container">
<span>Total results: <?php echo $totalresult;?></span>
<span><?php echo round($searchtime,5);?> secs</span>
</div>
<div class="result-container">
<?php 
			while($row = mysql_fetch_array($result)){
			echo ('<div class="item"> <div class="left"> <img src="http://img.youtube.com/vi/'. $row["id"] .'/mqdefault.jpg'. '">' . "</img></div>");
			echo (' <div class="right"> <h3 class="item_title"><a TARGET="_blank" href="https://www.youtube.com/watch?v='. $row["id"] . '">' . $row['title'] . "</a></h3>");
			echo "<div class='item_detail'> View Count: " . $row['viewCount']  .  " | Author: " . $row['author'] . "</div>" ; 
			echo "<div class='item_detail'><span>" . $row['category'] . "</span>  Duration: " . $row['duration'] . "</div>"; 
			echo "<div class='item_detail'>Published: " . $row['published']  . "</div>";
			echo "<div class='item_content'>Content: " . $row['content'] ."</div></div></div>"; 
			//echo "favoriteCount: " . $row['favoriteCount'] . "<br/>"; 
			//echo "keyword: " . $row['keyword'] . "<br/>"; 
			//echo "uid: " . $row['uid'] . "<br/><br/>";	
			}
			$searchtime=$time_end-$time_start;
?>

<?php
		 foreach ($mon as $doc) {
		 	$oktitle=$doc['title'];
		 	$oktitle=str_replace('\"', '"', $oktitle); 
			$oktitle=str_replace("\'", "'", $oktitle);
			$okcontent = $doc['content'];
			$okcontent=str_replace('\"', '"', $okcontent); 
			$okcontent=str_replace("\'", "'", $okcontent);
		 	echo ('<div class="item"><div class="left"><img src="http://img.youtube.com/vi/'. $doc['id'] .'/mqdefault.jpg"'. '">' . "</img></div>");
		 	echo ('<div class="right"><h3 class="item_title"><a TARGET="_blank" href="https://www.youtube.com/watch?v='. $doc['id'] . '">' . $oktitle . "</a></h3>");
		 	echo ("<div class='item_detail'>View Count:  " .  $doc['viewCount'] ." | Author: " . $doc['author'] . "</div>");
		 	echo ("<div class='item_detail'><span>" .  $doc['category'] .  "</span>  Duration: " . $doc['duration'] ."</div>");	 	
		 	echo ("<div class='item_detail'>Published: " .  $doc['published'] . "</div>");
		 	echo ("<div class='item_content'>" .  $okcontent . "</div></div></div>");
		 	//echo ("favoriteCount: " .  $doc['favoriteCount'] . "<br/>");		 	
		 	//echo ("keyword: " .  $doc['keyword'] . "<br/>");
		 	//echo ("uid: " .  $doc['uid'] . "<br/><br/>");
		 }
?>

</div>
<div class="page">
<?php

			//echo (' Title: <a TARGET="_blank" href="https://www.youtube.com/watch?v='. $row["id"] . '">' . $row['title'] . "</a><br/>");
			for($i=1; $i<=$pages; $i++){
				if($i ==$page){
					$this_url = 'searchh.php?page=' . $i . '&category=' . $category .'&keyword='. urlencode($keyword). '&author=' . urlencode($author) . '&bdate=' . $bdate .'&fdate='.$fdate.'&abovebelow='.$abovebelow.'&viewcount='. $viewcount.'&gogo=Search';
					echo ('<a class="current_page"  href=" '.$this_url . '">'  . $i. '</a>');  
				}
				elseif ($i == $pages) {
					$end_url = 'searchh.php?page=' . $i . '&category=' . $category .'&keyword='. urlencode($keyword). '&author=' . urlencode($author) . '&bdate=' . $bdate .'&fdate='.$fdate.'&abovebelow='.$abovebelow.'&viewcount='. $viewcount.'&gogo=Search' ;
					echo ('<a href=" '.$end_url . '">' . $i . '</a>');  
				}else{
					$other_url = 'searchh.php?page=' . $i . '&category=' . $category .'&keyword='. urlencode($keyword). '&author=' . urlencode($author) . '&bdate=' . $bdate .'&fdate='.$fdate.'&abovebelow='.$abovebelow.'&viewcount='. $viewcount.'&gogo=Search' ;
					echo ('<a  href=" '.$other_url . '">' . $i . '</a>');  
				}	
			}

		}
	}
?>
</div>
</body>