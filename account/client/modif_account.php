<?php
	$rootDir = '../..';
	require_once($rootDir . '/php_tools.php');
	require_once($rootDir . '/header.php');
	if (goHeader('Update your informations', "CHECK", $rootDir) == FALSE)
		return ;
?>
	<body>
		<form id="modifAccount" action="<?php echo $rootDir . '/account/server/modif.php'?>" method="post">
			<p>Mail</p><input type="text" name="mail" value="<?php echo getMail($_SESSION['login']);?>">
			<p>Password</p><input type="password" name="old_passwd" value="">
			<p>New password</p><input type="password" name="new_passwd" value="">
			<input type="submit" name="submit" value="modify">
			<a class="suppForm" href="delete.php"><p>Delete my account</p></a>
		</form>
		<script src="modif_account.js"></script>
		<script src="<?php echo $rootDir . '/ajax_tools.js';?>"></script>
	</body>
</html>
