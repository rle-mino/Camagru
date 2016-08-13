(function() {

	const	submit = document.querySelector('#addComment button'),
			commentContent = document.querySelector('textarea'),
			imgID = document.querySelector('#image').getAttribute('imgid'),
			deleteButtons = document.querySelectorAll('.deleteComment'),
			commentsList = document.querySelector('#comments'),
			actualUser = document.querySelector('#login');

	submit.addEventListener('click', comment, true);
	deleteButtons.map( (deleteButton) => deleteButton.addEventListener('click', deleteComment, true) );

	function deleteComment(evt)
	{
		evt.preventDefault();
		const data = new FormData();
		data.append('id', this.getAttribute('commentid'));
		const ajax = getAjaxOBJ();
		this.disabled = true;
		this.innerHTML = "Wait...";
		if (!ajax)
			return ;
		ajax.onreadystatechange = () =>
		{
			if (ajax.readyState == 4 && ajax.status == 200) {
				this.parentNode.parentNode.removeChild(this.parentNode);
			}
		}
		ajax.open("POST", "../server/remove_comment.php", true);
		ajax.setRequestHeader('X-Requested-With', 'xmlhttprequest');
		ajax.send(data);
	}

	function comment(evt)
	{
		evt.preventDefault();
		const data = new FormData;
		data.append('comment', commentContent.value);
		data.append('img_id', imgID);
		submit.disabled = true;
		submit.innerHTML = "PLEASE WAIT...";
		const ajax = getAjaxOBJ();
		if (!ajax)
			return ;
		ajax.onreadystatechange = () =>
		{
			if (ajax.readyState == 4)
			{
				submit.innerHTML = "COMMENT SENT";
				const newComment = document.createElement('div');
				const newCommenter = document.createElement('div');
				const newCommentContent = document.createElement('div');
				const newDeleteButton = document.createElement('button');
				newComment.appendChild(newCommenter);
				newComment.appendChild(newCommentContent);
				newComment.appendChild(newDeleteButton);
				newComment.className = 'comment';
				newCommenter.className = 'commenter';
				newCommentContent.className = 'commentContent';
				newDeleteButton.className = 'deleteComment';
				newCommentContent.innerHTML = commentContent.value;
				newCommenter.innerHTML = actualUser.innerHTML;
				newDeleteButton.innerHTML = "Delete";
				newDeleteButton.setAttribute('commentid', ajax.responseText);
				comments.insertBefore(newComment, comments.childNodes[0]);
				commentContent.value = "";
			}
		}
		ajax.open("POST", "../server/add_comment.php", true);
		ajax.setRequestHeader('X-Requested-With', 'xmlhttprequest');
		ajax.send(data);
	}

})();