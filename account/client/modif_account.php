<?php
	session_start();
	$rootDir = '../..';
	require_once($rootDir . '/php_tools.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Modify your account</title>
		<style type="text/css">
			html 	{background-color:#505050; color:white; font-family:verdana;}
			a		{color:inherit;}
		</style>
	</head>
	<body>
<?php
	if (!isset($_SESSION['login']) || $_SESSION['login'] == "") {
?>
		<meta http-equiv="refresh" content="3;url=login.php"/>
		<div>You must be connected...</div>
<?php
	}
	else {
?>
		<form id="modifAccount" action="<?php echo $rootDir . '/account/server/modif.php'?>" method="post">
			<p>Mail</p><input type="text" name="mail" value="<?php echo getMail($_SESSION['login']);?>">
			<p>Password</p><input type="password" name="old_passwd" value="">
			<p>New password</p><input type="password" name="new_passwd" value="">
			<input type="submit" name="submit" value="modify">
		</form>
		<a href="delete.php">Delete my account</a>
		<script src="modif_account.js"></script>
		<script src="<?php echo $rootDir . '/ajax_tools.js';?>"></script>
<?php
	}
?>
	</body>
</html>
