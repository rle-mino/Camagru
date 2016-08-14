<?php
	session_start();
	$rootDir = '../..';
	if (!isset($_SESSION['login']) || $_SESSION['login'] == "") {
?>
		<meta http-equiv="refresh" content="3;url=login.php"/>
		<div>You must be connected...</div>
<?php
	}
	else
	{
?>
		<!DOCTYPE html>
		<html>
			<head>
				<meta charset="utf-8">
				<title>Delete my account</title>
				<style type="text/css">
					html 	{background-color:#505050; color:white; font-family:verdana;}
					a		{color:inherit;}
				</style>
			</head>
			<body>
				<div>Are you sure ?</div>
				<form class="" action="<?php echo $rootDir . '/account/server/delete_account.php'?>" method="post">
					<input type="submit" name="submit" value="DELETE">
					<input type="submit" name="submit" value="NOPE">
				</form>
			</body>
		</html>
<?php
	}
?>

	<?php require_once($rootDir . '/footer.html')?>
