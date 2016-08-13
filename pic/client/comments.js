(function() {

	const	submit = document.querySelector('#addComment button'),
			commentContent = document.querySelector('textarea'),
			imgID = document.querySelector('#image').getAttribute('imgid');

	submit.addEventListener('click', comment, true)

	function comment(evt)
	{
		evt.preventDefault();
		const data = new FormData;
		data.append('comment', commentContent.value);
		data.append('img_id', imgID);
		submit.disabled = true;
		const ajax = getAjaxOBJ();
		if (!ajax)
			return ;
		ajax.onreadystatechange = () =>
		{
			if (ajax.readyState == 4)
				submit.innerHTML = ajax.responseText;
		}
		ajax.open("POST", "../server/add_comment.php", true);
		ajax.setRequestHeader('X-Requested-With', 'xmlhttprequest');
		ajax.send(data);
	}

})();