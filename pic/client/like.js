(function() {
	const	likeButton = document.querySelector('#likeButton'),
			user = document.querySelector('#login'),
			imgID = document.querySelector('#image');

	likeButton.addEventListener('click', like, true);

	function like(evt)
	{
		evt.preventDefault();
		const liked = likeButton.getAttribute('liked');
		const data = new FormData();
		const ajax = getAjaxOBJ();
		data.append('liker', user.value);
		data.append('img_id', imgID.value);
		if (!ajax)
			return ;
		ajax.onreadystatechange = () => {
			if (ajax.readyState == 1)
			{
				console.log("ANIMATE !!!!");
			}
			if (ajax.readyState == 4 && ajax.status == 200)
			{
				console.log("OK !!!!");
			}
		};
		ajax.open("POST", "../server/edit_like.php", true);
		ajax.setRequestHeader('X-Requested-With', 'xmlhttprequest');
		ajax.send(data);
	}
})();