<?php
	session_start();
	$rootDir = '../..';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Create account</title>
		<style type="text/css">
			html	{background-color:#505050; color:white; font-family:verdana;}
			a		{color:inherit;}
		</style>
	</head>
	<body>
<?php
		if (!isset($_SESSION['login']) || $_SESSION['login'] == "") {
?>
			<form id="createAccountForm" action="<?php echo $rootDir . '/account/server/create.php'?>" method="post">
				<p>Login</p><input  type="text" name="login" value="">
				<p>Password</p><input type="password" name="passwd" value="">
				<p>Confirm password</p><input type="password" name="passwd_confirm" value="">
				<p>Mail</p><input type="text" name="mail" value="">
				<p>Confirm mail</p><input type="text" name="mail_confirm" value="">
				<input type="submit" name="submit" value="GO">
			</form>
			<a href="<?php echo $rootDir . '/account/client/login.php'?>">Already register ?</a>
			<script src="create_account.js"></script>
			<script src="<?php echo $rootDir . '/ajax_tools.js'?>"></script>
<?php
	} else {
?>
		<meta http-equiv="refresh" content="3;url=<?php echo $rootDir . '/index.php'?>"/>
		<div>You are already connected...</div>
<?php
	}
?>
	</body>
</html>
