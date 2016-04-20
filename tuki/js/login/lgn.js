var lgn = function (){
	var bindEvents = function(){
		$('#but_log button').click(function(event) {
			event.preventDefault();
			var errorinput = false;
			$('#login span').removeClass('is-visible');
			$('#login input').each(function(){
				if(!$(this).val()){
					errorinput = true;
					$(this).next('span').addClass('is-visible');					
				}
			})
			if(!errorinput){
			var	data = {
					user: $("#login :input[name='username']").val(),
					pass: $("#login :input[name='password']").val()
				};
				send(data);
			}
		});
	}

	var send = function(cred){
		$.ajax({
			url: HOST+'/log-in',
			type: 'POST',
			dataType: 'json',
			data: cred,
		}).done(function(response) {
			if(response.success){
				window.location.href=HOST+'/home';
			}else{
				$('#login span:first-child ').addClass('is-visible');
			}

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