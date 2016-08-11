<?php
	$rootDir = '../..';
	require_once($rootDir . '/php_tools.php');
	require_once($rootDir . '/header.php');
	if (!goHeader('Take a picture', "CHECK", $rootDir))
		return ;
	$sql_co = connectToDB();
	if (!$sql_co)
		die('An error occured');
	$img_data = getImageById($sql_co, $_GET['img']);
	if (!$img_data)
		die ("An error occured");
	$liked = liked($sql_co, $_SESSION['login'], $_GET['img']);
?>
	<div id="bloc">
		<div id="comandlikes">
			<div id="data">
				<div id="author"><?php echo $img_data['author']?></div>
				<div id="likeContent">
					<button id="likeButton" class="<?php echo($liked ? 'liked' : 'notliked')?>" style="background-color:<?php echo($liked ? '#E50000' : '#FFF')?>;">LIKE</button>
					<p><?php echo $img_data['likes']?> like<?php echo($img_data['likes'] > 1 ? 's' : '')?></p>
				</div>
			</div>
			<div id="comments">

			</div>
		</div>
		<div id="image">
			<img src="<?php echo('data:image/png;base64,' . $img_data['source_img'])?>" imgId="<?php echo $img_data['id']?>">
		</div>
	</div>
	<script defer src="<?php echo $rootDir . '/ajax_tools.js';?>"></script>
	<script defer src="like.js" charset="utf-8"></script>
