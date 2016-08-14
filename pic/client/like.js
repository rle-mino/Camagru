(function() {
	const	likeButton = document.querySelector('#likeButton'),
			user = document.querySelector('#login'),
			imgID = document.querySelector('#image').getAttribute('imgid'),
			likesCounter = document.querySelector("#likes"),
			imageData = document.querySelector('#data');

	likeButton.addEventListener('mouseover', mouseover, true);
	likeButton.addEventListener('mouseleave', mouseleave, true);
	likeButton.addEventListener('click', like, true);

	function mouseover(evt)
	{
		evt.preventDefault();
		const liked = likeButton.className == "liked" ? true : false;
		likeButton.style.backgroundColor = liked ? "#FFF" : "#E50000";
		likeButton.style.color = liked ? "#000" : "#FFF";
	}

	function mouseleave(evt)
	{
		evt.preventDefault();
		const liked = likeButton.className == "liked" ? true : false;
		likeButton.style.backgroundColor = liked ? "#E50000" : "#FFF";
		likeButton.style.color = liked ? "#FFF" : "#000";
	}

	function like(evt)
	{
		evt.preventDefault();
		const liked = likeButton.className == "liked" ? true : false;
		likeButton.className = liked ? "notliked" : "liked";
		likeButton.disabled = true;
		likeButton.innerHTML = "WAIT";
		const data = new FormData();
		const ajax = getAjaxOBJ();
		data.append('liker', user.innerHTML);
		data.append('img_id', imgID);
		if (!ajax)
			return ;
		ajax.onreadystatechange = () =>
		{
			if (ajax.readyState == 4 && ajax.status == 200) {
				likesCounter.innerHTML = ajax.responseText + " like" + (ajax.responseText >= 2 ? "s" : "");
				likeButton.disabled = false;
				likeButton.innerHTML = "LIKE";
			}
		};
		ajax.open("POST", "../server/edit_like.php", true);
		ajax.setRequestHeader('X-Requested-With', 'xmlhttprequest');
		ajax.send(data);
	}
})();