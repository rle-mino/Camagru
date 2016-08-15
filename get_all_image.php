<?php
	$rootDir = '.';
	require_once($rootDir . '/php_tools.php');

	$img = getIMGS('root', $_GET['page'] * 15, 15);
	echo (json_encode($img));
?>