<?php
	session_start();
	$rootDir = '.';
	if (!isset($_SESSION['login']) || $_SESSION['login'] == "") {
		?>
		<meta http-equiv="refresh" content="3;url=<?php echo $rootDir . '/account/client/login.php'?>"/>
		<div>You must be connected...</div>
		<?php }
?>
