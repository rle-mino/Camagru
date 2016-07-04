<?php
	$rootDir = '../..';
	require_once($rootDir . '/php_tools.php');
	require_once($rootDir . '/header.php');
	goHeader('My galery', "CHECK", $rootDir);
	$userIMGS = getIMGS($_SESSION['login'], 0, 5);
?>
	<div id="thumbnails">
<?php
		foreach ($userIMGS as $img)
		{
?>
			<div class="img_thumb">
				<a href="image.php?img=<?php echo $img['id']?>">
					<img src="<?php echo 'data:image/png;base64, ' . $img['source_img']?>">
				</a>
			</div>
<?php
		}
?>
	</div>
	<script defer src="../../ajax_tools.js" charset="utf-8"></script>
	<script defer src="user_galery.js" charset="utf-8"></script>
</body>