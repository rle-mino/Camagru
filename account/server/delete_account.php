<?php
	session_start();
	$rootDir = '../..';
	require_once($rootDir . '/php_tools.php');
	if (!isset($_SESSION['login']) || $_SESSION['login'] == "") {
		echo '<meta http-equiv="refresh" content="3;url=' . rootDir . '/account/client/login.php' . '/>';
		echo 'An error occured';
	}
	else
	{
		?>
		<!DOCTYPE html>
		<html>
			<head>
				<meta charset="utf-8">
				<title>Delete account</title>
			</head>
			<body>
		<?php
		if ($_POST['submit'] == "DELETE")
		{
			$sql_co = connectToDB();
			$query = $sql_co->prepare("DELETE FROM users WHERE login LIKE :login");
			$query->execute(array(':login' => $_SESSION['login']));
			$_SESSION['login'] = NULL;
			?>
				<meta http-equiv="refresh" content="3;url=<?php echo $rootDir . '/account/client/login.php'?>"/>
				<div>Your account has been deleted</div>
			<?php
		}
		else if ($_POST['submit'] == "NOPE")
		{
			?>
				<meta http-equiv="refresh" content="3;url=<?php echo $rootDir . '/index.php'?>"/>
				<div>:)</div>
			<?php
		}
		else
		{
			?>
				<meta http-equiv="refresh" content="<?php echo $rootDir . '/index.php'?>"/>
				<div>An error occured</div>
			<?php
		}
	}
?>
		</body>
</html>
