<?php
	$rootDir = '../..';
	require_once($rootDir . '/php_tools.php');
	session_start();
	if (!isConnected($_SESSION))
		die ('An error occured');
	$img = getIMGS($_SESSION['login'], $_GET['page'] * 15, 15);
	echo (json_encode($img));
	return ;
?>