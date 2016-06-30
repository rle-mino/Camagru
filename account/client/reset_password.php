<?php
	$rootDir = '../..';
	require_once($rootDir . '/header.php');
	goHeader("Reset password", "NO_CHECK", $rootDir);
	if (!isset($_GET['mail']) || $_GET['mail'] == '')
		echo "An error occured";
	else
	{
		if (!$sql_co = connectToDB())
			die ("An error occured");
		$query = $sql_co->prepare("SELECT mail, c_key FROM users WHERE mail LIKE :mail");
		$query->execute(array(':mail' => $_GET['mail']));
		if ($user = $query->fetch(PDO::FETCH_ASSOC))
		{
			if ($user['c_key'] != $_GET['c_key'])
				die ("An error occured");
			else
			{
?>
				<body>
					<form id="resetPassword" action="<?php echo $rootDir . '/account/server/reset.php?' . $_GET['mail']?>" method="post">
						<p>New password</p><input type="password" name="password" value="">
						<p>Confirm</p><input type="password" name="password_check" value="">
						<input type="submit" name="submit" value="reset">
					</form>
					<script src="<?php echo $rootDir . '/ajax_tools.js';?>"></script>
					<script src="reset_password.js"></script>
				</body>
<?php
			}
		}
	}
?>
</html>
