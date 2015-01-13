<?php
	require 'vendor/autoload.php';
	use Parse\ParseClient;
	use Parse\ParseUser;
	use Parse\ParseSessionStorage;
	ParseClient::initialize('DINPQbvlPessEzSCBOhW83NkxtDIniaWflDtVyav', 'pJnetpTKF1dNmyPOpwzXyVI73oIWNTq8UVNnA3AL', 'tC1QePDQzK5j4sqZMwaxyH1ef8nj0Fgpw5drnh1x');
	session_start();
	ParseClient::setStorage( new ParseSessionStorage() );

	$currentUser = ParseUser::getCurrentUser();
	//var_dump($currentUser);
	$keyword = $_GET['keyword'];
?>
<header class="headerBar">
	<div id="headerContainer">
		<div id="headerLogo">
			<a href="index.php"><span >CCU</span>tube</a>
		</div>
	<div id="headerBar-control">
	<form id="headerBar-searchform" method="GET" action="search.php">
		<input id="headerBar-input" type="text" name="keyword" placeholder="search for keywords" value="<?php echo $keyword ?>">
		<button class="headerBar-submit-btn" id="headerBar-submit"><i class="fa fa-search"></i></button>
	</form>
	<ul id="headerBar-nav">
<?php
	if ($currentUser) {
?>
	<li><a href="category.php"><i class="fa fa-list-ol"> 分類</i></a></li>
	<li><a href="upload.php"><i class="fa fa-cloud-upload"> 上傳</i></a></li>
	<li><a href="user.php"><i class="fa fa-user"> <?php echo $currentUser->get("username");?></i></a></li>
	<li><a href="api/logout.php"><i class="fa fa-sign-out"> 登出</i></a></li>
<?php 
	} else {
?>
	<li><a href="category.php"><i class="fa fa fa-list-ol"> 分類</i></a></li>
	<li><a href="login.php"><i class="fa fa-power-off"> 登入</i></a></li>
<?php
	}
?>
	</ul>
</div>
</div>
</header>