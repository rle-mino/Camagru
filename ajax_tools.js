function displayAjaxErrors (ajax) {
	var errors = JSON.parse(ajax.responseText);
	var errorsKey = Object.keys(errors);
	for (var i = 0; i < errorsKey.length; i++)
	{
		var key = errorsKey[i];
		var error = errors[key];
		var input = document.querySelector('[name=' + key + ']');
		var span = document.createElement('span');
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
