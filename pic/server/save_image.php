<?php
	session_start();
	$rootDir = '../..';
	require_once($rootDir . '/php_tools.php');
	if (!isConnected($_SESSION))
		echo "An error occured";
	var_dump($_POST);
?>