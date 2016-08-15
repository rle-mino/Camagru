<?php
	require_once('header.php');
	$rootDir = '.';
	if (goHeader('Camagru', "LOG", $rootDir) == FALSE)
		return ;
?>
	<div class="loading" style="opacity=0">
			<div class="bar0"></div>
			<div class="bar1"></div>
			<div class="bar2"></div>
			<div class="bar3"></div>
			<div class="bar4"></div>
		</div>
	<script defer src="ajax_tools.js" charset="utf-8"></script>
	<script defer src="get_all_image.js" charset="utf-8"></script>
<?php require_once($rootDir . '/footer.html')?>
