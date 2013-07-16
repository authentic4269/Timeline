var SERVER_URL = document.location.protocol + '//' + document.location.host + '/';

function sendAjaxRequest(url, data, success, error, async) {
	$('#loader').show();
	$('#send_btn').addClass('disabled');
	
	function successCallback (response) {
		$('#loader').hide();
		$('#send_btn').removeClass('disabled');
		if(success)
			success(response);
	}
	
	function errorCallback (response) {
		$('#loader').hide();
		$('#send_btn').removeClass('disabled');
		if(error)
			error(response);
	}
	
	$.ajax({
		url : url,
		type : 'POST',
		async : (async) ? async : true,
		data : data,
		//dataType : 'json',
		cache : false,
		crossDomain: true,
		success : successCallback,
		error : errorCallback,
	});
}
