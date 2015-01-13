<head>
	<meta charset="UTF-8">
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
	<link type="text/css" rel="stylesheet" href="css/oldsearch.css"/> 
	<title>MongoDB Search - Mark Tsai</title>

</head>
<body>
<form name="search" method="GET" action="msearch.php">
	<input id="keyword" type="text" name="keyword" placeholder="Input the keyword"> <br/><br/>
	<select id="category" name="category"> 
		<option selected value="">==Category==</option>
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
	<input id="bdate" type="text" name="bdate" placeholder="YYYY-MM-DD"> <a>   ~   </a>
	<input id="fdate" type="text" name="fdate" placeholder="YYYY-MM-DD"><br/><br/>
	 <select id="abovebelow" name="abovebelow"> 
		<option selected value="">View  &#8645;</option>
		<option value="above">Above &#8607;</option>
		<option value="below">Below &#8609;</option>
	</select>
	<input id="viewcount" type="text" name="viewcount" placeholder="View Count"> <br/><br/>
	<input class="gogo" type="submit" name="gogo" value="Search">
</form>
<?php
if(isset($_GET["gogo"])){
	//echo "hi";
	require 'vendor/autoload.php';
	include 'mongodb.php';
	$keyword = $_GET["keyword"];
	$category = $_GET["category"];
	$author = $_GET["author"];
	$bdate = $_GET["bdate"];
	$fdate = $_GET["fdate"];
	$abovebelow = $_GET["abovebelow"];
	$viewcount = $_GET["viewcount"];
	
	if($_GET["category"]==""){$category=null;}
	if($_GET["abovebelow"]==""){$abovebelow=null;}
	if($_GET["bdate"]==""){$bdate=null;}
	if($_GET["fdate"]==""){$fdate=null;}
	 // $temp = empty($_GET["category"]);
	 // echo $temp;
	//$search = array('author' => 'officialpsy' );
	// $search = array( 
	// 		'title' => new MongoRegex ("/^$keyword/i")
	// 		);
	// $result = $collection->find($search)->LIMIT(5);
	// $result -> timeout(-1);
	// foreach ($result as $doc) {
	// 	var_dump($doc);
	// }

	//page initial
	if(!isset($_GET["page"])){
		$page=1;
	}else{
		$page =intval($_GET["page"]); //確認頁數只能夠是數值資料
	};	
	
	if(isset($_GET['keyword']) && $keyword=="" ){
		echo "<div id='warning'>You don't input any keyword!</div>";
		//echo '<input type ="button" onclick="history.back()" value="&#8592;Back"></input>';
	}elseif((empty($_GET["bdate"] ) && !empty($_GET["fdate"]) ) || (  !empty($_GET["bdate"]) && empty($_GET["fdate"])) ) {
		echo "<div id='warning'>You have to fill out the both DATE GRIDS!</div>";
	}elseif ($_GET["bdate"] > $_GET["fdate"] ) {
		echo "<div id='warning'>Right date grid must be more than left date grid!</div>";
	}
	else{
		/* title  content */
		// $t1 = array( 
		//    	'$or' => array(
		// 	array( 
		// 		'title' => new MongoRegex ("/$keyword/i") 
		// 		), 
		// 	array(
		// 		'content' => new MongoRegex ("/$keyword/i") 
		// 		) 
		// 	) 
		// 	);
		$t1 = array( '$text'  => array('$search' => $keyword));
		/* 2 title content + catogory */
		$t2 = array( '$and'  => array( array('category' => $category), $t1) ); 
		/* 2 title content + author */
		$t3 = array('$and'  => array(array( 'author' => new MongoRegex("/$author/i")), $t1 ) );
		/* 2 title content + b(f)date */
		$tdate = array('published' => array('$gte' => $bdate,  '$lte' => $fdate));
		$t4 = array('$and' => array($t1, $tdate));
		/* 2 title content + above.viewcount  gte: >  */
		$tabove = array( 'viewCount' => array('$gte' => (int)$viewcount));
		$t51 = array( '$and' => array($t1 ,$tabove) );
		/* 2 title content + below.viewcount  lte: <  */
		$tbelow = array( 'viewCount' => array('$lte' => (int)$viewcount));
		$t52 = array( '$and' => array($t1 ,$tbelow) );
		/* 3 title content + catogory + above.viewcount */
			$n1 = array('and'=>array($tabove,$t2));
		/* 3 title content + catogory + below.viewcount */
			$n2 = array('and'=>array($tbelow,$t2));
		/* 3 title content + b(f)date + catogory */
			$n3 = array('and'=>array($tdate,$t2));
		/* 3 title content + b(f)date + above.viewcount*/
			$n4 = array('and'=>array($tabove,$tdate));
		/* 3 title content + b(f)date + below.viewcount */
			$n5 = array('and'=>array($tbelow,$tdate));
		/* 3 title content + author + catogory */
		$t6 = array( '$and'  => array( array('category' => $category), $t3) ); 
		/* 3 title content + author + b(f)date */
		$t7 = array( '$and'  => array( $tdate, $t3) ); 
		/* 3 title content + author + above.viewcount */
		$t8above = array( '$and'  => array( $tabove, $t3) ); 
		/* 3 title content + author + below.viewcount */
		$t8below = array( '$and'  => array( $tbelow, $t3) );
		/* 4 title content + catogory + b(f)date* + above.viewcount */
			$n6 = array( '$and'  => array( $tabove, $n3) );
		/* 4 title content + catogory + b(f)date* + below.viewcount */
			$n7 = array( '$and'  => array( $tbelow, $n3) );
		/* 4 title content + author + b(f)date* + above.viewcount */
			$n8 = array( '$and'  => array( $tabove, $t7) );
		/* 4 title content + author + b(f)date* + below.viewcount */
			$n9 = array( '$and'  => array( $tbelow, $t7) );
		/* 4 title content + author + catogory + b(f)date*/
		$t9 = array('$and' => array($tdate, $t6));
		/* 4 title content + author + catogory + above.viewcount */
		$t10above = array('$and' => array($tabove, $t6));
		/* 4 title content + author + catogory + below.viewcount */
		$t10below = array('$and' => array($tbelow, $t6));
		/* title content + author + catogory + b(f)date + above.viewcount*/
		$t11above = array('$and' => array($tabove, $t9));
		/* title content + author + catogory + b(f)date + below.viewcount*/
		$t11below = array('$and' => array($tbelow, $t9));

		$time_start = microtime(true);  //timer start
		// echo !empty($keyword) ."<br/>";
		// echo empty($category) ."<br/>";
		// echo empty($author) ."<br/>";
		// echo empty($bdate) ."<br/>";
		// echo empty($fdate) ."<br/>";
		// echo empty($viewcount)."<br/>";

		$per = 10;
		//echo "start: ".$pages ."<br/>";
		$start = ($page-1)*$per; 
		// $mon = $mon->SKIP($start)->LIMIT($per);

		if( !empty($keyword) && empty($category) && empty($author) && empty($bdate) && empty($fdate) && empty($viewcount)){
			/* title  content */
			// $mon = $collection->find($t1)->SKIP($start)->LIMIT($per);
			// $mon = $collection->find(array("category"=>"Animals"))->LIMIT(10);
			// $items =$mon->count();
			//elastic search
			$esClient = new Elasticsearch\Client();

                                          $search_data = 
                                          '{
                                          	"query":{
                                          		"multi_match" : {
                                          			"query" : "'.$keyword.'",
                                          			"fields": ["title","content"]
                                          		}
                                          	},
                                          	"from": '.$start.',
                                          	"size":  '.$per.'
                                          }'; 
			$searchQuery = array(
				'index'=>'youtube',
				'type'=>'utubedata',
				'body'=> $search_data
				);
			$results = $esClient->search($searchQuery);

			$ids = array();
			foreach ($results['hits']['hits'] as  $value) {
				$ids[] = new MongoId($value['_id']);
			}
			//print_r($ids);
			$mongoQuery = array (
				'_id' => array(
					'$in' => $ids
					)
				);
			//print_r($mongoQuery);

			$mon = $collection->find($mongoQuery);
			print_r($mon);
			//$items = $mon->count();
			
			$pages = ceil($results['hits']['total']/$per); //計算總頁數


		}elseif (!empty($category) && empty($author) && empty($bdate) && empty($fdate) && empty($viewcount) ){
			/* title content + catogory */
			$mon = $collection->find($t2); //var_dump($t1) ;
			$items =$mon->count();
		}elseif(empty($category) && !empty($author) && empty($bdate) && empty($fdate) && empty($viewcount) ){
			/* title + content + author */
			$mon = $collection->find($t3); //echo " here";
			$items =$mon->count();
		}elseif (empty($category) && empty($author) && !empty($bdate) && !empty($fdate) && empty($viewcount)) {
			/* title content + b(f)date */
			$mon = $collection->find($t4); //echo "here";
			$items =$mon->count();
		}elseif(empty($category) && empty($author) && empty($bdate) && empty($fdate) && !empty($viewcount) && $abovebelow=="above"){
			/* title content + viewcount */
			$mon = $collection->find($t51); //echo $viewcount;
			$items =$mon->count();
		}elseif(empty($category) && empty($author) && empty($bdate) && empty($fdate) && !empty($viewcount) && $abovebelow=="below"){
			/* title content + viewcount */
			$mon = $collection->find($t52);
			$items =$mon->count();
		}elseif(!empty($category) && !empty($author) && empty($bdate) && empty($fdate) && empty($viewcount) ){
			/* title content + author + catogory */
			$mon = $collection->find($t6);  //echo "here";
			$items =$mon->count();
		}elseif(empty($category) && !empty($author) && !empty($bdate) && !empty($fdate) && empty($viewcount) ){
			/* title content + author + b(f)date */
			$mon = $collection->find($t7);  //echo "here";
			$items =$mon->count();
		}elseif(empty($category) && !empty($author) && empty($bdate) && empty($fdate) && !empty($viewcount) && $abovebelow=="above" ){
			/* title content + author + above.viewcount */
			$mon = $collection->find($t8above);  //echo "here";
			$items =$mon->count();
		}elseif(empty($category) && !empty($author) && empty($bdate) && empty($fdate) && !empty($viewcount) && $abovebelow=="below" ){
			/* title content + author + below.viewcount */
			$mon = $collection->find($t8below);  //echo "here";
			$items =$mon->count();
		}elseif(!empty($category) && !empty($author) && !empty($bdate) && !empty($fdate) && empty($viewcount) ){
			/* title content + author + catogory + b(f)date*/
			$mon = $collection->find($t9);  //echo "here";
			$items =$mon->count();
		}elseif(!empty($category) && !empty($author) && !empty($bdate) && !empty($fdate) && empty($viewcount) ){
			/* title content + author + catogory + b(f)date*/
			$mon = $collection->find($t10);  //echo "here";
			$items =$mon->count();
		}elseif(!empty($category) && !empty($author) && empty($bdate) && empty($fdate) && !empty($viewcount) && $abovebelow=="above"){
			/* title content + author + catogory + above.viewcount */
			$mon = $collection->find($t10above);  //echo "here";
			$items =$mon->count();
		}elseif(!empty($category) && !empty($author) && empty($bdate) && empty($fdate) && !empty($viewcount) && $abovebelow=="below" ){
			/* title content + author + catogory + below.viewcount */
			$mon = $collection->find($t10below);  //echo "here";
			$items =$mon->count();
		}elseif(!empty($category) && !empty($author) && !empty($bdate) && !empty($fdate) && !empty($viewcount)&& $abovebelow=="above"){
			/* title content + author + catogory + b(f)date + above.viewcount*/
			$mon = $collection->find($t11above);  //echo "here";
			$items =$mon->count();
		}elseif(!empty($category) && !empty($author) && !empty($bdate) && !empty($fdate) && !empty($viewcount)&& $abovebelow=="below"){
			/* title content + author + catogory + b(f)date + below.viewcount*/
			$mon = $collection->find($t11below);  //echo "here";
			$items =$mon->count();
		}elseif (!empty($category) && empty($author) && empty($bdate) && empty($fdate) && !empty($viewcount)&& $abovebelow=="above") {
			/* 3 title content + catogory + above.viewcount */
			$mon = $collection->find($n1);  //echo "here";
			$items =$mon->count();
		}elseif (!empty($category) && empty($author) && empty($bdate) && empty($fdate) && !empty($viewcount)&& $abovebelow=="below") {
			/* 3 title content + catogory + below.viewcount */
			$mon = $collection->find($n2);  //echo "here";
			$items =$mon->count();
		}elseif (!empty($category) && empty($author) && !empty($bdate) && !empty($fdate) && empty($viewcount)) {
			/* 3 title content + b(f)date + catogory */
			$mon = $collection->find($n3);  //echo "here";
			$items =$mon->count();
		}elseif (empty($category) && empty($author) && !empty($bdate) && !empty($fdate) && !empty($viewcount)&& $abovebelow=="above") {
			/* 3 title content + b(f)date + above.viewcount*/
			$mon = $collection->find($n4);  //echo "here";
			$items =$mon->count();
		}elseif (empty($category) && empty($author) && !empty($bdate) && !empty($fdate) && !empty($viewcount)&& $abovebelow=="below") {
			/* 3 title content + b(f)date + below.viewcount */
			$mon = $collection->find($n5);  //echo "here";
			$items =$mon->count();
		}elseif (!empty($category) && empty($author) && !empty($bdate) && !empty($fdate) && !empty($viewcount)&& $abovebelow=="above") {
			/* 4 title content + catogory + b(f)date* + above.viewcount */
			$mon = $collection->find($n6);  //echo "here";
			$items =$mon->count();
		}elseif (!empty($category) && empty($author) && !empty($bdate) && !empty($fdate) && !empty($viewcount)&& $abovebelow=="below") {
			/* 4 title content + catogory + b(f)date* + below.viewcount */
			$mon = $collection->find($n7);  //echo "here";
			$items =$mon->count();
		}elseif (empty($category) && !empty($author) && !empty($bdate) && !empty($fdate) && !empty($viewcount)&& $abovebelow=="above") {
			/* 4 title content + author + b(f)date* + above.viewcount */
			$mon = $collection->find($n8);  //echo "here";
			$items =$mon->count();
		}elseif (empty($category) && !empty($author) && !empty($bdate) && !empty($fdate) && !empty($viewcount)&& $abovebelow=="below") {
			/* 4 title content + author + b(f)date* + below.viewcount */
			$mon = $collection->find($n9);  //echo "here";
			$items =$mon->count();
		}
		$totalresult = $results['hits']['total'];
		

		$time_end= microtime(true); //timer end
		$searchtime = $time_end-$time_start;

		//echo "123";
		$mon -> timeout(-1);
?>

</div>
<div class="time-container">
<span>Total results: <?php echo $totalresult;?></span>
<span><?php echo round($searchtime,7);?> secs</span>
</div>
<div class="result-container">
<?php
		 foreach ($mon as $doc) {
		 	echo ('<div class="item"><div class="left"><img src="http://img.youtube.com/vi/'. $doc['id'] .'/mqdefault.jpg"'. '">' . "</img></div>");
		 	echo ('<div class="right"><h3 class="item_title"><a TARGET="_blank" href="https://www.youtube.com/watch?v='. $doc['id'] . '">' . $doc['title'] . "</a></h3>");
		 	echo ("<div class='item_detail'>View Count:  " .  $doc['viewCount'] ." | Author: " . $doc['author'] . "</div>");
		 	echo ("<div class='item_detail'><span>" .  $doc['category'] .  "</span>  Duration: " . $doc['duration'] ."</div>");	 	
		 	echo ("<div class='item_detail'>Published: " .  $doc['published'] . "</div>");
		 	echo ("<div class='item_content'>" .  $doc['content'] . "</div></div></div>");
		 	//echo ("favoriteCount: " .  $doc['favoriteCount'] . "<br/>");		 	
		 	//echo ("keyword: " .  $doc['keyword'] . "<br/>");
		 	//echo ("uid: " .  $doc['uid'] . "<br/><br/>");
		 }
?>

<div class="page">
<?php
		for($i=1; $i<=$pages; $i++){
			if($i ==$page){
				$this_url = 'msearch.php?page=' . $i . '&category=' . $category .'&keyword='. urlencode($keyword). '&author=' . urlencode($author) . '&bdate=' . $bdate .'&fdate='.$fdate.'&abovebelow='.$abovebelow.'&viewcount='. $viewcount.'&gogo=Search';
				echo ('<a class="current_page"  href=" '.$this_url . '">'  . $i. '</a>');  
			}
			elseif ($i == $pages) {
				$end_url = 'msearch.php?page=' . $i . '&category=' . $category .'&keyword='. urlencode($keyword). '&author=' . urlencode($author) . '&bdate=' . $bdate .'&fdate='.$fdate.'&abovebelow='.$abovebelow.'&viewcount='. $viewcount.'&gogo=Search' ;
				echo ('<a href=" '.$end_url . '">' . $i . '</a>');  
			}else{
				$other_url = 'msearch.php?page=' . $i . '&category=' . $category .'&keyword='. urlencode($keyword). '&author=' . urlencode($author) . '&bdate=' . $bdate .'&fdate='.$fdate.'&abovebelow='.$abovebelow.'&viewcount='. $viewcount.'&gogo=Search' ;
				echo ('<a  href=" '.$other_url . '">' . $i . '</a>');  
			}	
		}		
	}
}
?>
</div>
</body>