<?php
	session_start();

	if (!isset($_SESSION['login']))
		?>
		<meta http-equiv="refresh" content="3;url=login.php"/>
		<div>You must be connected...</div>
		<?php
?>
