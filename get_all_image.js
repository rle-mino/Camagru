(function() {
	let		actualPage = 0;
	let		prevScrollPos = window.pageYOffset;
	let		updateInitiated = false;
	const	distance = 300;

	window.onscroll = handleScroll;
	getNewImages( () => {});

	function handleScroll()
	{
		if (updateInitiated) return;
		const scrollPos = window.pageYOffset;
		if (scrollPos == prevScrollPos) return;
		const pageHeight = document.documentElement.scrollHeight;
		const clientHeight = document.documentElement.clientHeight;
		if (pageHeight - (scrollPos + clientHeight) < distance)
		{
			updateInitiated = true;
			getNewImages ( () => updateInitiated = false);
		}
		prevScrollPos = scrollPos;
	}

	function getNewImages(good)
	{
		const ajax = getAjaxOBJ();
		if (!ajax) return ;
		ajax.onreadystatechange = () =>
		{
			if (ajax.readyState == 1)
			{
				const loading = document.querySelector('.loading');
			}
			if (ajax.readyState === 4 && ajax.status == 200)
			{
				const newGroup = document.createElement('div');
				newGroup.className = "thumbnails";
				const loading = document.querySelector(".loading");
				fadeOutOpacity(loading);
				document.body.insertBefore(newGroup, loading);
				const response = JSON.parse(ajax.responseText);
				const responseKeys = Object.keys(response);
				for (let i = 0; i < responseKeys.length; i++)
				{
					const key = responseKeys[i];
					const newImage = response[key];
					const id = Object.keys(newImage)[1];
					const imgSRC = Object.keys(newImage)[0];
					const div = document.createElement('div');
					const a = document.createElement('a');
					const img = document.createElement('img');
					div.setAttribute('class', 'img_thumb');
					a.href = 'pic/client/image.php?img=' + newImage[id];
					img.src = 'data:image/png;base64, ' + newImage[imgSRC];
					div.appendChild(a);
					a.appendChild(img);
					div.className = 'img_thumb';
					newGroup.appendChild(div);
				}
			}
			if (ajax.readyState === 4)
					good();
		};
		ajax.open("GET", "get_all_image.php?page=" + (actualPage++), true);
		ajax.setRequestHeader('X-Requested-With', 'xmlhttprequest');
		ajax.send();
	}


	function fadeOutOpacity(element, display) {
		element.style.opacity = 1;
		element.style.display = display || "block";
		(function fade() {
			let val = parseFloat(element.style.opacity);
			if ((val -= 0.05) >= 0) {
				element.style.opacity = val;
				requestAnimationFrame(fade);
			}
		})();
	}

})();