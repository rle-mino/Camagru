<?php
	session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Create account</title>
	</head>
	<body>
		<?php
		if (!isset($_SESSION['login']) || $_SESSION['login'] == "") {
		?>
			<form id="createAccountForm" action="create.php" method="post">
				<p>Login</p><input  type="text" name="login" value="">
				<p>Password</p><input type="password" name="passwd" value="">
				<p>Confirm password</p><input type="password" name="passwd_confirm" value="">
				<p>Mail</p><input type="text" name="mail" value="">
				<p>Confirm mail</p><input type="text" name="mail_confirm" value="">
				<input type="submit" name="submit" value="GO">
			</form>
			<script src="create_account.js"></script>
			<script src="../ajax_tools.js"></script>
		<?php
	} else {
		?>
		<meta http-equiv="refresh" content="3;url=../index.php"/>
		<div>You are already connected...</div>
		<?php
	}
?>
	</body>
</html>
