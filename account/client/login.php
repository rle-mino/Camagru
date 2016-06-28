<?php
	session_start();
	$rootDir = '../../';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Login</title>
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
		<!-- <script src="login.js"></script> -->
		<!-- <script src="../../ajax_tools.js"></script> -->
<?php
	}
?>
	</body>
</html>
