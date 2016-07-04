var form = document.querySelector('#loginForm');

form.addEventListener('submit', (e) =>
{
	e.preventDefault();
	queryHandler(form, 'GO', '../../index.php');
});
