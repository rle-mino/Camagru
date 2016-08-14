var form = document.querySelector('#modifAccount');
var successButton = document.querySelector('[type=submit]');

form.addEventListener('submit', (e) =>
{
	e.preventDefault();
	form.querySelector("[type='submit']").disable = true;
	const errorsInForm = form.querySelectorAll('.isError');
	errorsInForm.forEach((errorInForm) => {
		errorInForm.style.width = '0px';
		errorInForm.classList.remove('isError');
		errorInForm.parentNode.removeChild(errorInForm);
	});
	const data = new FormData(form);
	const ajax = getAjaxOBJ();
	if (ajax)
	{
		ajax.onreadystatechange = () => {
			const button = form.querySelector("[type='submit']");
			if (ajax.readyState !== 4)
				button.value = 'Loading....';
				button.disabled = true;
			if (ajax.readyState === 4)
			{
				if (ajax.status != 200)
				{
					displayAjaxErrors(ajax);
					button.value = 'modify';
					button.disabled = false;
				}
				else
				{
					const message = JSON.parse(ajax.responseText);
					const messageKeys = Object.keys(message);
					for (let k = 0; k < messageKeys.length; k++)
					{
						const key2 = messageKeys[k];
						const mess = message[key2];
						const input2 = document.querySelector('[name=' + key2 + ']');
						const span2 = document.createElement('span');
						span2.innerHTML = mess;
						span2.class = 'success';
						input2.parentNode.insertBefore(span2, input2.nextSibling);
					}
					const inputs = form.querySelectorAll('input');
					inputs.forEach((input) => input.value = "");
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
});
