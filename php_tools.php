<?php
	function connectToDB()
	{
		include('config/database.php');
		try {
			$sql_co = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		} catch (PDOException $Exception) {
			echo $Exception->getMessage();
			return (NULL);
		}
		$sql_co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return ($sql_co);
	}

	function isConnected($session)
	{
		if (isset($session) && isset($session['login']) && $session['login'] != "")
			return (TRUE);
		return (FALSE);
	}

	function getMail($login)
	{
		if (!($sql_co = connectToDB()))
			return ('');
		$query = $sql_co->prepare("SELECT mail FROM users WHERE login LIKE :login");
		$query->execute(array(':login' => $login));
		if ($user = $query->fetch(PDO::FETCH_ASSOC))
			return $user['mail'];
	}

	function getIMGS($user, $start, $range)
	{
		if (!($sql_co = connectToDB()))
			return (NULL);
		if (isset($user) && $user == 'root') {
			$query = $sql_co->prepare("SELECT source_img, id FROM img
										ORDER BY id DESC LIMIT " . $start . "," . $range);
			$query->execute();
		} else if (isset($user) && $user != "") {
			$query = $sql_co->prepare("SELECT source_img, id FROM img
										WHERE author like :user
										ORDER BY id DESC LIMIT " . $start . "," . $range);
			$query->execute(array(':user' => $user));
		} else
			return (NULL);
		return ($query->fetchAll(PDO::FETCH_ASSOC));
	}

	function isAjax()
	{
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
			(strtolower(getenv('HTTP_X_REQUESTED_WITH')) === 'xmlhttprequest'))
			return (TRUE);
		return (FALSE);
	}

	function writeErrors($errors)
	{
		if (!empty($errors) && isAjax()) {
			header('Content-Type: application/json');
			http_response_code(201);
			echo(json_encode($errors));
			die();
		}
		else if (!empty($errors)) {
			foreach ($errors as $error)
				echo($error) . '<br>';
			die();
		}
	}

	function getImageById($sql_co, $id)
	{
		$query = $sql_co->prepare("SELECT source_img, likes, author, nb_comments, crea_date, id
									FROM img WHERE id LIKE :id");
		$query->execute(array(':id' => $id));
		return ($query->fetch(PDO::FETCH_ASSOC));
	}

	function getCommentsByID($sql_co, $id)
	{
		$query = $sql_co->prepare("SELECT comment, commenter, id
									FROM comments WHERE img_id LIKE :img_id
									ORDER BY id DESC");
		$query->execute(array(':img_id' => $id));
		return($query->fetchAll(PDO::FETCH_ASSOC));
	}

	function liked($sql_co, $login, $img_id)
	{
		$query = $sql_co->prepare("SELECT liker
									FROM likes
									WHERE liker LIKE :login AND img_id LIKE :img_id AND liked = 1");
		$query->execute(array(':login' => $login, 'img_id' => $img_id));
		if ($query->fetch(PDO::FETCH_ASSOC))
			return TRUE;
		return FALSE;
	}

	function removeOrAddLike($sql_co, $login, $img_id)
	{
		$query = $sql_co->prepare("SELECT liked
									FROM likes
									WHERE liker LIKE :login AND img_id LIKE :img_id");
		$query->execute(array(':login' => $login, ':img_id' => $img_id));
		if ($liked = $query->fetch(PDO::FETCH_ASSOC))
		{
			$liked['liked'] = $liked['liked'] ? 0 : 1;
			$query = $sql_co->prepare("UPDATE likes SET liked = :reverse
										WHERE liker LIKE :login
										AND img_id LIKE :img_id");
			$query->execute(array(':reverse' => $liked['liked'],
									':login' => $login,
									':img_id' => $img_id));
			if ($liked['liked']) {
				$query = $sql_co->prepare('UPDATE img SET likes = likes + 1
											WHERE id LIKE :img_id');
				$query->execute(array(':img_id' => $img_id));
			}
			else {
				$query = $sql_co->prepare('UPDATE img SET likes = likes - 1
											WHERE id LIKE :img_id');
				$query->execute(array(':img_id' => $img_id));				
			}
		}
		else {
			$query = $sql_co->prepare("INSERT INTO likes (img_id, liker, liked)
										VALUES (:img_id, :liker, 1)");
			$query->execute(array(':img_id' => $img_id, ':liker' => $login));
			$query = $sql_co->prepare('UPDATE img SET likes = likes + 1 WHERE id LIKE :img_id');
			$query->execute(array(':img_id' => $img_id));
		}
	}

	function nbLike($sql_co, $img_id)
	{
		$query = $sql_co->prepare("SELECT likes FROM img WHERE id LIKE :img_id");
		$query->execute(array(':img_id' => $img_id));
		return ($query->fetch(PDO::FETCH_ASSOC)['likes']);
	}

	function addComment($sql_co, $img_id, $commenter, $comment)
	{
		$query = $sql_co->prepare("INSERT INTO comments (img_id, commenter, comment)
									VALUES (:img_id, :commenter, :comment)");
		$query->execute(array(":img_id" => $img_id, ':commenter' => $commenter, ':comment' => $comment));
	}

	function deleteComment($sql_co, $id)
	{
		$query = $sql_co->prepare("DELETE FROM comments WHERE id = :id");
		$query->execute(array(':id' => $id));
	}

	function getMostRecentComment($sql_co, $id)
	{
		$query = $sql_co->prepare("SELECT id FROM comments WHERE img_id LIKE :img_id ORDER BY id DESC LIMIT 1");
		$query->execute(array(':img_id' => $id));
		return ($query->fetch(PDO::FETCH_ASSOC)['id']);
	}
?>
