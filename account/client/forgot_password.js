var form = document.querySelector('#forgotPassword');

form.addEventListener('submit', function (e)
{
	e.preventDefault();
	queryHandler(form, 'send', 'login.php');
});
