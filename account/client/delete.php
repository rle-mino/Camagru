<?php
	session_start();
	$rootDir = dirname(__DIR__, 2);
	if (!isset($_SESSION['login']) || $_SESSION['login'] == "") {
		?>
		<meta http-equiv="refresh" content="3;url=login.php"/>
		<div>You must be connected...</div>
		<?php
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Delete my account</title>
	</head>
	<body>
		<div>Are you sure ?</div>
		<form class="" action="<?php echo $rootDir . '/server/delete_account.php'?>" method="post">
			<input type="submit" name="submit" value="DELETE">
			<input type="submit" name="submit" value="NOPE">
		</form>
	</body>
</html>
