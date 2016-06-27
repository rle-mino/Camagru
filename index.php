<?php
	session_start();

	if (!isset($_SESSION['login']) || $_SESSION['login'] == "") {
		?>
		<meta http-equiv="refresh" content="3;url=account/login.php"/>
		<div>You must be connected...</div>
		<?php }
?>
