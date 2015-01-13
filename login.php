<?php
if(isset($_GET['signup'])){
	if($_GET['signup'] ==true) {
		echo "<script>alert(\"sign up success\");</script>";
	} else {
		echo "<script>alert(\"sign up failed\");</script>";
	}
}
  $loginMsg=$_GET['login'];
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<?php
		require("css_common.php");
	?>
	<link type="text/css" rel="stylesheet" href="css/login.css">
	<title>登入 - CCUtube</title>
</head>

<body>
	<?php
		require("header.php");
	?>
</body>
	<main class="main-wrapper clearfix">
	<div class="card">
		<form id="loginForm" class="stackForm" action="api/loginCheck.php" method="POST">
			<label for="userid">帳號</label>
			<input id="userid" name="userid" type="text"><br>
			<label for="userpwd">密碼</label>
			<input id="userpwd" name="userpwd" type="password"><br>
			<p> <?php if($loginMsg=="false"){echo "ID or password ERROR!!";}?></p>
			<button type="submit">登入</button>
		</form>
	</div>
	<div class="tipstitle">註冊新帳號</div>
	<div class="card">
		<form id="registerForm" class="stackForm" action="api/signUp.php" method="POST">
			<label for="userNewid">新帳號</label>
			<input id="userNewid" name="userNewid" type="text"><br>
			<label for="userNewpwd">密碼</label>
			<input id="userNewpwd" name="userNewpwd"><br>
			<label id="userNewpwdc">確認密碼</label>
			<input id="userNewpwdc" name="userNewpwdc"><br>
			<button type="submit">註冊</button>
		</form>
<?php
	if(isset($_GET['isSignUp']) && $_GET['isSignUp'] ==false) {
		echo "<div>sign up failed</div>";
	}
?>
	</div>
	</main>

</html>