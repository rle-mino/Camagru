<?php
	session_start();
	$rootDir = '../..';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Login</title>
		<style type="text/css">
			html 	{background-color:#505050; color:white; font-family:verdana;}
			a		{color:inherit;}
		</style>
	</head>
	<body>
<?php
	if (isset($_SESSION['login']) && $_SESSION['login'] != "") {
?>
		<meta http-equiv="refresh" content="3;url=<?php echo $rootDir . '/index.php'?>"/>
		<div>You are already connected...</div>
<?php
	}
	else {
?>
		<form id="loginForm" action="<?php echo $rootDir . '/account/server/check_login.php'?>" method="post">
			<p>Login or mail</p><input  type="text" name="login" value="">
			<p>Password</p><input type="password" name="passwd" value="">
			<input type="submit" name="submit" value="GO">
		</form>
		<a href="<?php echo $rootDir . "/account/client/create_account.php";?>">Sign up !</a>
		<script src="login.js"></script> 
		<script src="../../ajax_tools.js"></script> 
<?php
	}
?>
	</body>
</html>
