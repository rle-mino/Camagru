var form = document.querySelector('#forgotPassword');

form.addEventListener('submit', (e) =>
{
	e.preventDefault();
	queryHandler(form, 'send', 'login.php');
});
