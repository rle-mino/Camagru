const thumbnails = document.querySelector('#thumbnails');
let actualPage = 0;
window.onscroll = () => {
	if ((window.scrollY + window.innerHeight) >= document.body.offsetHeight - 10) {
		const ajax = getAjaxOBJ();
		if (!ajax)
			return ;
		ajax.onreadystatechange = () => {
			if (ajax.readyState === 4 && ajax.status == 200)
			{
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
					thumbnails.appendChild(div);
				}
			}
		};
		ajax.open("GET", "../server/get_image_from_user.php?page=" + (++actualPage), true);
		ajax.setRequestHeader('X-Requested-With', 'xmlhttprequest');
		ajax.send();
	}
};
