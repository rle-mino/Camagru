var form = document.querySelector('#loginForm');

form.addEventListener('submit', function (e)
{
	e.preventDefault();
	queryHandler(form, 'GO', '../../index.php');
});
