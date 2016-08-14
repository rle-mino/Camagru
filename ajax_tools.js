const arrayMethods = Object.getOwnPropertyNames( Array.prototype );

function attachArrayMethodsToNodeList(methodName) {
	NodeList.prototype[methodName] = Array.prototype[methodName];
}

arrayMethods.forEach( attachArrayMethodsToNodeList );

function sendPicToServer()
{
	const form = document.querySelector('#sendImage');
	const data = new FormData(form);
	const ajax = getAjaxOBJ();
	if (!ajax)
		return (false);
	ajax.onreadystatechange = () =>
	{
		if (ajax.readyState !== 4)
		{
			var button = document.querySelector('#take');
			button.innerHTML = 'loading...';
			button.disabled = true;
			button = document.querySelector('[type="submit"]');
			button.value = 'loading...';
			button.disabled = true;
		}
		if (ajax.readyState === 4)
		{
			button = document.querySelector('#take');
			button.innerHTML = "Take a picture";
			button.disabled = false;
			button = form.querySelector('[type="submit"]');
			button.value = ajax.responseText;
			button.disabled = false;
		}
	};
	ajax.open('POST', form.getAttribute('action'), true);
	ajax.setRequestHeader('X-Requested-With', 'xmlhttprequest');
	ajax.send(data);
}

function queryHandler(form, buttonValue, linkToRedir)
{
	const errorsInForm = form.querySelectorAll('.isError');
	errorsInForm.forEach((errorInForm) => {
		errorInForm.classList.remove('isError');
		errorInForm.parentNode.removeChild(errorInForm);
	});
	const data = new FormData(form);
	data.append("submit", form.querySelector("[type='submit']").value);
	const ajax = getAjaxOBJ();
	if (!ajax)
		return ;
	ajax.onreadystatechange = () =>
	{
		const button = form.querySelector("[type='submit']");
		if (ajax.readyState !== 4)
			button.value = 'Loading....';
			button.disabled = true;
		if (ajax.readyState === 4)
		{
			if (ajax.status != 200)
			{
				displayAjaxErrors(ajax);
				button.value = buttonValue;
				button.disabled = false;
			}
			else
			{
				const success = document.createElement('span');
				success.innerHTML = ajax.responseText;
				const successButton = document.querySelector('[type="submit"]');
				successButton.parentNode.insertBefore(success, successButton.nextSibling);
				const inputs = form.querySelectorAll('input');
				inputs.forEach((input) => input.value = '');
				successButton.disabled = true;
				successButton.value = 'Success';
				window.setTimeout("location=('../../index.php');",3000);
			}
		}
	};
	ajax.open('POST', form.getAttribute('action'), true);
	ajax.setRequestHeader('X-Requested-With', 'xmlhttprequest');
	ajax.send(data);
}

function displayAjaxErrors (ajax) {
	const errors = JSON.parse(ajax.responseText);
	const errorsKey = Object.keys(errors);
	for (let i = 0; i < errorsKey.length; i++)
	{
		const key = errorsKey[i];
		const error = errors[key];
		const input = document.querySelector('[name=' + key + ']');
		const span = document.createElement('span');
		span.innerHTML = error;
		span.className = 'isError';
		input.parentNode.insertBefore(span, input.nextSibling);
	}
}

function getAjaxOBJ () {
	var httpRequest = false;

	if (window.XMLHttpRequest) {
		httpRequest = new XMLHttpRequest();
		if (httpRequest.overrideMimeType) {
			httpRequest.overrideMimeType('text/xml');
		}
	}
	else if (window.ActiveXObject)
	{
		try {
			httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try {
				httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e) {}
		}
	}
	return (httpRequest ? httpRequest : false);
}
