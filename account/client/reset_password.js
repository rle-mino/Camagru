var form = document.querySelector('#resetPassword');

form.addEventListener('submit', function (e)
{
	e.preventDefault();
	queryHandler(form, 'reset', 'login.php');
});
