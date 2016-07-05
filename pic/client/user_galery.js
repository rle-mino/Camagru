(function() {
	const thumbnails = document.querySelector('#thumbnails');
	let actualPage = 0;
	let prevScrollPos = window.pageYOffset;
	let updateInitiated = false;
	const distance = 300;
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
	
	function easing(t, b, c, d) {
		t /= d;
		t--;
		return -c * (t*t*t*t - 1) + b;
	}

	function fadeIn(element, display, initMargin, endMargin) {
		element.style.opacity = 0;
		element.style.marginTop = initMargin + 'px';
		element.style.display = display || "block";
		const duration = 5000;
		const startTime = new Date();
		(function fade() {
			let actualMargin = parseInt(element.style.marginTop);
			let actualOpacity = parseFloat(element.style.opacity);
			actualOpacity += actualOpacity <= 1 ? 0.05 : 0;
			const time = new Date() - startTime;
			actualMargin = easing(time, actualMargin, endMargin - actualMargin, duration);
			if (actualOpacity <= 1)
				element.style.opacity = actualOpacity;
			if (actualMargin > endMargin)
				element.style.marginTop = actualMargin + 'px';
			if (actualOpacity <= 1 || time > duration)
				requestAnimationFrame(fade);
		})();
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

	function getNewImages(good)
	{
		const ajax = getAjaxOBJ();
		if (!ajax) return ;
		ajax.onreadystatechange = () =>
		{
			if (ajax.readyState == 1)
			{
				const loading = document.querySelector('.loading');
				fadeIn(loading);
			}
			if (ajax.readyState === 4 && ajax.status == 200)
			{
				const loading = document.querySelector(".loading");
				fadeOutOpacity(loading);
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
					a.href = 'image.php?img=' + newImage[id];
					img.src = 'data:image/png;base64, ' + newImage[imgSRC];
					div.appendChild(a);
					a.appendChild(img);
					div.className = 'img_thumb';
					thumbnails.appendChild(div);
					fadeIn(div, "inline-block", 100, 0);
				}
			}
			if (ajax.readyState === 4)
					good();
		};
		ajax.open("GET", "../server/get_image_from_user.php?page=" + (actualPage++), true);
		ajax.setRequestHeader('X-Requested-With', 'xmlhttprequest');
		ajax.send();
	}

}());
