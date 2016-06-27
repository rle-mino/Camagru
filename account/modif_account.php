<?php
	session_start();
	require_once('../php_tools.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Modify your account</title>
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
		<form id="modifAccount" action="modif.php" method="post">
			<p>Mail</p><input type="text" name="mail" value="<?php echo getMail($_SESSION['login']);?>">
			<p>Password</p><input type="password" name="old_passwd" value="">
			<p>New password</p><input type="password" name="new_passwd" value="">
			<input type="submit" name="submit" value="modify">
		</form>
		<script src="modif_account.js"></script>
		<script src="../ajax_tools.js"></script>
		<?php
	}
?>
	</body>
</html>
