var form = document.querySelector('#createAccountForm');

form.addEventListener('submit', (e) =>
{
	e.preventDefault();
	form.querySelector("[type='submit']").disable = true;
	const errorsInForm = form.querySelectorAll('.isError');
	errorsInForm.forEach((errorInForm) => {
		errorInForm.classList.remove('isError');
		errorInForm.parentNode.removeChild(errorInForm);
	});
	const data = new FormData(form);
	const ajax = getAjaxOBJ();
	if (ajax)
	{
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
					button.value = 'GO';
					button.disabled = false;
				}
				else
				{
					const success = document.createElement('span');
					success.innerHTML = "You are now registred, you have to confirm your mail address";
					const successButton = document.querySelector('[type="submit"]');
					successButton.parentNode.insertBefore(success, successButton.nextSibling);
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
