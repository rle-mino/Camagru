(function() {

	//DEFINITION : VARIABLES;

	const	canvas = document.querySelector('#canvas'),
			photo = document.querySelector('#photo'),
			take = document.querySelector('#take'),
			palmier = document.querySelector('[src="../src/palmier_mini.png"]'),
			stars = document.querySelector('[src="../src/star_mini.png"]'),
			moustache = document.querySelector('[src="../src/moustache_mini.png"]'),
			imgabove = document.querySelector('[name="imgabove"]'),
			imgsrc = document.querySelector('[name="imgsrc"]'),
			submit = document.querySelector('[type="submit"]'),
			fileFromUser = document.querySelector('#fileFromUser'),
			webcamSelector = document.querySelector("#webcamSelector"),
			preview = document.querySelector('#preview'),
			width = 600,
			height = 450;

	let		video = document.querySelector('#video'),
			streaming = false;

	const getMediaSRC = {
		video: true,
		audio: false
	};

	const getMediaStream = function(stream)
	{
		if (navigator.mozGetUserMedia) {
			video.mozSrcObject = stream;
		} else {
			const vendorURL = window.URL || window.webkitURL;
			video.src = vendorURL.createObjectURL(stream);
		}
		video.play();
	};

	const getMediaErr = function(err) {
		console.log("An error occured! ", err);
	};

	take.disabled = true;
	navigator.getMedia = (navigator.getUserMedia ||
						navigator.webkitGetUserMedia ||
						navigator.mozGetUserMedia ||
						navigator.msGetUserMedia);

	navigator.getMedia(getMediaSRC, getMediaStream, getMediaErr);

	// DEFINITION : FUNCTION

	function checkExtension(str)
	{
		const re = /(?:\.([^.]+))?$/;
		const ext = re.exec(str)[1];
		if (ext != 'jpg' && ext != 'png')
			return (false);
		return (true);
	}

	function getVideoType()
	{
		if (video.src[11] == 'j')
			return ('jpeg');
		else
			return ('png');
	}

	function takepicture()
	{
		canvas.width = width;
		canvas.height = height;
		canvas.getContext('2d').drawImage(video, 0, 0, width, height);
		const data = canvas.toDataURL('image/' + getVideoType());
		photo.setAttribute('src', data);
		const result = document.querySelector('#result');
		const toDelete = result.querySelector('#superimposed');
		if (toDelete)
			result.removeChild(toDelete);
		const superimposed = document.querySelector("#superimposed").getAttribute('src');
		const superimposedResult = document.createElement('img');
		superimposedResult.setAttribute('src', superimposed);
		superimposedResult.id = 'superimposed';
		result.insertBefore(superimposedResult, photo);
		imgabove.setAttribute('value', superimposed);
		imgsrc.setAttribute('value', photo.getAttribute('src'));
	}

	function deleteActualSelec()
	{
		const superimposed = document.querySelector('#superimposed');
		if (!superimposed)
			return ;
		preview.removeChild(superimposed);
	}

	function setActualSelect(src)
	{
		take.disabled = false;
		const superimposed = document.createElement('img');
		superimposed.setAttribute('src', src);
		superimposed.id = 'superimposed';
		preview.insertBefore(superimposed, video);
	}

	//DEFINITION EVENTLISTENER

	//Button that reactivate webcam
	webcamSelector.addEventListener('click', (e) => {
		e.preventDefault();
		video.parentNode.removeChild(video);
		video = document.createElement('video');
		video.id = 'video';
		video.setAttribute('width', width);
		video.setAttribute('height', height);
		preview.insertBefore(video, fileFromUser);
		navigator.getMedia(getMediaSRC, getMediaStream, getMediaErr);
		fileFromUser.value = "";
		streaming = true;
		webcamSelector.disabled = true;
	}, false);

	//button that switch source from webcam to user's image
	fileFromUser.addEventListener('change', () => {
		if (!checkExtension(fileFromUser.files[0].name)) {
			alert('Please select an image [png or jpeg]');
			return ;
		}
		const reader = new FileReader();
		take.disabled = true;
		const superimposed = document.querySelector('#superimposed');
		if (superimposed)
			superimposed.src = "";
		reader.onload = () =>
		{
			video.parentNode.removeChild(video);
			const replaIMG = document.createElement('img');
			replaIMG.id = '#video';
			video = replaIMG;
			replaIMG.setAttribute('src', reader.result);
			replaIMG.setAttribute('height', '450px');
			replaIMG.setAttribute('width', '600px');
			fileFromUser.parentNode.insertBefore(replaIMG, fileFromUser);
		};
		reader.readAsDataURL(fileFromUser.files[0]);
		streaming = false;
		webcamSelector.disabled = false;
	});

	//When the webcam is available, set size of video
	video.addEventListener('canplay', () =>
	{
		if (!streaming)
		{
			video.setAttribute('width', width);
			video.setAttribute('height', height);
			canvas.setAttribute('width', width);
			canvas.setAttribute('height', height);
			streaming = true;
			webcamSelector.disabled = true;
		}
	}, false);

	//Button that takes a picture and send it to the final preview
	take.addEventListener('click', (ev) =>
	{
		takepicture();
		const serverResponse = document.querySelector('#serverResponse');
		if (serverResponse)
			serverResponse.parentNode.removeChild(serverResponse);
		submit.disabled = false;
		submit.value = 'send';
		ev.preventDefault();
	}, false);

	//Button that send the picture to the server
	submit.addEventListener('click', (e) => {
			e.preventDefault();
			sendPicToServer();
		}, false);

	//Buttons that send the selected image to the preview

	palmier.addEventListener('click', (e) => {
		e.preventDefault();
		deleteActualSelec();
		setActualSelect('../src/palmier.png');
	}, false);

	moustache.addEventListener('click', (e) => {
		e.preventDefault();
		deleteActualSelec();
		setActualSelect('../src/moustache.png');
	}, false);

	stars.addEventListener('click', (e) => {
		e.preventDefault();
		deleteActualSelec();
		setActualSelect('../src/stars.png');
	}, false);

})();
