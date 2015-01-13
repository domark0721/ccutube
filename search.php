<?php		
	if(!empty($_GET['keyword'])){
	 	require 'vendor/autoload.php';
	 	include 'mongodb.php';
	 	$keyword = $_GET['keyword'];
	 	$category = $_GET['category'];
	 	$author = $_GET['author'];
	 	$viewCount = $_GET['viewCount'];
	 	$from = $_GET['from'];
	 	$to = $_GET['to'];

	 	// $t1 = array('text' => array('$search' => $keyword));
	 	$esClient = new Elasticsearch\Client();

	 // 	$search_keyword =
		// '{
		// 	"query":{
		// 		"filtered" :{
		// 			"filter" :{
						// "range" :{ 
						// 	"viewCount" :{ "gte" : '.$viewCount.' }
						// 	 }
		// 		},
		// 		"query" :{
		// 			"multi_match" : {
		// 				"query" : "'.$keyword.'",
		// 				"fields" : ["title","content"]
		// 				}
		// 			}
		// 		}
		// 	},
		// 	"size": 20
		// }'; 
		// echo $search_keyword;

	 	//category
	 	if(!empty($_GET['category'])){$filterCol = '"category": "'.$category.'"';};

	 	//author
	 	if(!empty($_GET['author'])){
	 		if(!empty($_GET['category'])){
	 			$filterCol =$filterCol .  ',';
	 		}
	 		$filterCol =$filterCol .  '"author": "'.$author.'"';
	 	}
	 	$stepOne = 0;
	 	// category + author wrap
	 	if(!empty($_GET['category']) || !empty($_GET['author'])){
	 		$filterCol =  '"term" :{' .$filterCol.'}';
	 		$stepOne = 1;
	 	}

	 	//viewCount
	 	if(!empty($_GET['viewCount'])){
	 		$filterColl ='"viewCount" :{ "gte" : '.$viewCount.' }';
	 	}

	 	//time
	 	if(!empty($_GET['from'])){
	 		if(!empty($_GET['viewCount'])){
	 			$filterColl =$filterColl .  ',';
	 		}
	 		$filterColl = $filterColl . '"published" :{ "gte" : "'.$from.'" , "lte" : "'.$to.'"}';
	 	}

	 	//viewCount + time wrap
	 	if(!empty($_GET['viewCount']) || !empty($_GET['from'])){
	 		if($stepOne==1){
	 			$filterCol =$filterCol .  '},';
	 			$filterCol = $filterCol . '{"range" :{' .$filterColl.'}';
	 		}else{
	 				$filterCol = $filterCol . '"range" :{' .$filterColl.'}';
				}
	 		if($stepOne==1){
	 			$filterCol =' "and":[{' . $filterCol . '}]';
	 		}
	 	}

	 	if(!empty($_GET['keyword']) &&( !empty($_GET['category']) || !empty($_GET['author']) || !empty($_GET['viewCount']) ||!empty($_GET['from']))) {
			$search_keyword =
			'{
				"query":{
					"filtered" :{
						"filter" :{
							'.$filterCol.'
					},
					"query":{
						"multi_match" : {
							"query" : "'.$keyword.'",
							"fields" : ["title","content"]
							}
						}
					}
				},
				"size": 20
			}'; 
			// echo $search_keyword;
	 	}else{
	 		$search_keyword =
			'{
				"query":{
					"multi_match" : {
						"query" : "'.$keyword.'",
						"fields" : ["title","content"]
						}
				},
				"size": 20
			}';

			// echo $search_keyword;
	 	}
	 	// $search_keyword ='{ "query":{ "filtered" :{ "filter" :{ "and":[{"range" :{"viewCount" :{ "gte" : 300 }}},{"term" :{"author": "psy"}}] }, "query":{ "multi_match" : { "query" : "psy", "fields" : ["title","content"] } } } }, "size": 20 }';
	 	// $search_keyword =
		// 	'{
		// 		"query":{
		// 			"multi_match" : {
		// 				"query" : "'.$keyword.'",
		// 				"fields" : ["title","content"]
		// 				}
		// 		},
		// 		"size": 20
		// 	}';	
		$searchQuery = array(
			'index' => 'youtube',
			'type' => 'utubedata',
			'body' => $search_keyword
		);

		$results = $esClient->search($searchQuery);
		//print_r($results);

		$ids = array();
		foreach($results['hits']['hits'] as $value){
		 	$ids[] = new MongoId($value['_id']);
		 }
		 //print_r($ids);
		$mongoQuery = array(
		 	'_id' => array(
		 		'$in' => $ids
		 		)
		 	);
		$mon = $collection -> find($mongoQuery);
		// print_r($mon);
		$totalresult = $results['hits']['total'];
	 }
?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<?php
		require("css_common.php");
		$keywordTitle = $_GET['keyword'];
		echo ('<title>'. $keywordTitle .' - CCUtube </title>')
	?>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
	<link type="text/css" rel="stylesheet" href="css/search.css">
</head>

<body>
	<?php
		require("header.php");
	?>
	<main class="main-wrapper clearfix">
	<div id="leftWrap">
		<label id="searchLabel">進階搜尋</label><br><br>
		<form id="advancedSearchForm" method="GET" action="search.php">
			<input type="hidden" id="keyword" name="keyword" value="<?php echo $keyword;?>">
			<select id="category" name="category" >
			<?php
				 if(empty($_GET['category'])){ 
			?>
				<option selected value="">==== 類 別 ====</option>
			<?php 
				}else { 
			?>
				<option selected value="<?php echo $category;?>"><?php echo $category;?></option>
			<?php 
				} 
			?>
				<option value="">All</option>
				<option value="animals">Animals</option>
				<option value="autos">Autos</option>
				<option value="comedy">Comedy</option>
				<option value="education">Education</option>
				<option value="entertainment">Entertainment</option>
				<option value="film">Film</option>
				<option value="games">Games</option>
				<option value="howto">Howto</option>
				<option value="music">Music</option>
				<option value="nonprofit">Nonprofit</option>
				<option value="people">People</option>
				<option value="shows">Shows</option>
				<option value="sports">Sports</option>
				<option value="tech">Tech</option>
				<option value="travel">Travel</option>
			</select><br>
			<label for="author" class="filterLabel">提供者</label>
				<input type="text" id="author" name="author" class="position" value="<?php echo $author;?>">
			<label for="viewCount" class="filterLabel">人氣</label><br>
				<input type="number" id="viewCount" name="viewCount" class="position" value="<?php echo $viewCount;?>">
			<div id="timeWrap">
				<label for="from" class="filterLabel">時間</label><br>
				<div>
					<label for="from" class="timeLabel">from </label>
						<input type="text" id="from" name="from" class="fromPosition" value="<?php echo $from;?>">
				</div>
				<div>
					<label for="to" class="timeLabel" id="toLabel">to </label>
						<input type="text" id="to" name="to" class="position" value="<?php echo $to;?>">
				</div>
				<div  class="submitBtn"><button type="submit">搜尋</button></div>
			</div>
		</form>
	</div>

	<div id="rightWrap">
	     <ul id="howtoDisplay">
	     	<li>order by</li>
	     	<li><a>Title<a></li>
	     	<li><a>Viewcount</a></li>
	     </ul>
	      <div id="videolist-container">
	      	<ul id="videolist">
			<?php
				foreach($mon as $doc){
					if(empty($doc['isCCUtube'])) {
						$videoImg = "http://img.youtube.com/vi/". $doc['id']. "/mqdefault.jpg";
					} else {
						$videoImg = "uploads/screenshot/" . $doc['id'] . ".jpg";
					}

					echo ('<li class="videoItem" ><div class="videoCard"><div class="video-img" ><img src="'. $videoImg. '"></div>');
					echo ('<div class="video-info"><a href="video.php?vid='. $doc['_id'].'">'. $doc['title'] .'</a><span class="video-info-author">by ' .$doc['author']. '</span>');
					echo ('<span><i class="fa fa-eye"> '.number_format($doc['viewCount']).'</i><i class="fa fa-clock-o"> '.$doc['duration'].'</i><i class="fa fa-cloud-upload"> '.$doc['published'].'</i></span>');
					echo ('<p class="video-content">'. mb_strimwidth($doc['content'], 0, 50, '...' , 'utf-8').'</p></div></div></li>');
				}		
			?>
	      	</ul>
	      </div>
	</div>
	</main>
	<?php
		require("js_common.php");
	?>
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
	<script>
	$(function() {
		$( "#from" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			changeYear: true,
			numberOfMonths: 1,
			onClose: function( selectedDate ) {
			$( "#to" ).datepicker( "option", "minDate", selectedDate );
			$( "#to" ).datepicker( "option", "dateFormat", "yymmdd" );	
				}
		});
		$( "#to" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			changeYear: true,
			numberOfMonths: 1,
			onClose: function( selectedDate ) {
			$( "#from" ).datepicker( "option", "maxDate", selectedDate );
			$( "#from" ).datepicker( "option", "dateFormat", "yymmdd" );
					}
			});
		});
	</script>
</body>

</html>




