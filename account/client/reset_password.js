var form = document.querySelector('#resetPassword');

form.addEventListener('submit', (e) =>
{
	e.preventDefault();
	queryHandler(form, 'reset', 'login.php');
});
