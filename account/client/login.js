var form = document.querySelector('#loginForm');

form.addEventListener('submit', function (e)
{
	e.preventDefault();
	form.querySelector("[type='submit']").disable = true;
	var errorsInForm = form.querySelectorAll('.isError');
	for (var i = 0; i < errorsInForm.length; i++) {
		errorsInForm[i].classList.remove('isError');
		var span = errorsInForm[i];
		if (span) {
			span.parentNode.removeChild(span);
		}
	}
	var data = new FormData(form);
	var ajax = getAjaxOBJ();
	if (ajax)
	{
		ajax.onreadystatechange = function() {
			var button = form.querySelector("[type='submit']");
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
					var success = document.createElement('span');
					success.innerHTML = "You are now connected";
					var successButton = document.querySelector('[type="submit"]');
					successButton.parentNode.insertBefore(success, successButton.nextSibling);
					var inputs = form.querySelectorAll('input');
					for (var j = 0; j < inputs.length; j++) {
						inputs[j].value = "";
					}
					successButton.disabled = true;
					successButton.value = 'Success';
					redir = document.createElement('meta');
					redir.content = '3;url=../../index.php';
					redir.httpEquiv = "refresh";
					form.appendChild(redir);
				}
			}
		};
		ajax.open('POST', form.getAttribute('action'), true);
		ajax.setRequestHeader('X-Requested-With', 'xmlhttprequest');
		ajax.send(data);
	}
});
