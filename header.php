<?php
	function goHeader($title, $check, $rootDir)
	{
		session_start();
		require_once('php_tools.php');
?>
	<!DOCTYPE html>
	<html>
		<head>
			<meta charset="utf-8">
			<title><?php echo $title;?></title>
			<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
			<style media="screen">
				header 	{background-color:#404040; color:white; font-family:roboto;}
				a		{color:inherit; text-decoration: none}
				html 	{background-color:#505050; color:white; font-family:roboto;}
			</style>
		</head>
		<body>
			<header>
<?php
				if (!isConnected($_SESSION) && $check == "CHECK")
				{
?>
					<meta http-equiv="refresh" content="3;url=<?php echo $rootDir . '/account/client/login.php'?>"/>
					<div>You must be connected...</div>
<?php
					return (FALSE);
				}
				else
				{
?>
					<a href="<?php echo $rootDir . '/index.php'?>">Camagru</a>
					<a href="<?php echo $rootDir . '/account/client/modif_account.php'?>"><?php echo $_SESSION['login'];?></a>
<?php
					if (isConnected($_SESSION))
					{
?>
						<a href="<?php echo $rootDir . '/account/server/logout.php'?>">logout</a>
						<a href="<?php echo $rootDir . '/pic/client/take.php'?>">Take a picture</a>
<?php
					}
				}
?>
			</header>
<?php
		return (TRUE);
	}
?>
