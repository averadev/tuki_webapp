var lgn = function (){
	var bindEvents = function(){
		$('#but_log button').click(function(event) {
			event.preventDefault();
			data = {
				user: $("#login :input[name='username']").val(),
				pass: $("#login :input[name='password']").val()
			};
			send(data);
		});
	}

	var send = function(cred){
		$.ajax({
			url: HOST+'/log-in',
			type: 'POST',
			dataType: 'json',
			data: cred,
		}).done(function(response) {
		}).fail(function(response) {
		});	
	}

	var onloadExec = function(){
		bindEvents();
	}
	return {
		init:onloadExec
	}

};
$(function(){
	var login = new lgn();
	login.init();
});