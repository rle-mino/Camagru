<?php
	$rootDir = '../..';
	require_once($rootDir . '/header.php');
	goHeader('Forgot password', "NO CHECK", $rootDir);
?>
	<body>
		<form id="forgotPassword" action="<?php echo $rootDir . '/account/server/forgot.php';?>" method="post">
			<p>Mail or login</p><input type="text" name="mailorLogin" value="">
			<input type="submit" name="submit" value="send">
		</form>
		<script src="<?php echo $rootDir . '/ajax_tools.js';?>"></script>
		<script src="forgot_password.js"></script>
	</body>
</html>
