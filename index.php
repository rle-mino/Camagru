<?php
	require_once('header.php');
	$rootDir = '.';
	if (goHeader('Camagru', "CHECK", $rootDir) == FALSE)
		return ;
?>
	<?php require_once($rootDir . '/footer.html')?>
