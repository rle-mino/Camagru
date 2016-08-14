<?php
	$rootDir = '../..';
	require_once($rootDir . '/header.php');
	require_once($rootDir . '/php_tools.php');
	if (goHeader("logout", "CHECK", $rootDir) == FALSE)
		return ;
	$_SESSION['login'] = NULL;
?>
	<meta http-equiv="refresh" content="3;url=<?php echo $rootDir . '/account/client/login.php'?>"/>
	<div class="errorBeforeRedir"><p>You are now disconnected<p></div>
<?php
?>
