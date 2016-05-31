var remind = function (){
	var bindEvents = function(){
		$("#changepass").click(function(event) {
			event.preventDefault();
			$('#msgbox').hide();
			$('#passform').foundation('validateForm');			
		});

		$('#passform').on("formvalid.zf.abide", function(ev,elem) {			
			data = {
				'email': 					$('#correo').val(),
				'password': 				$('#password').val(),
				'password_confirmation': 	$('#passconfirmed').val(),
				'token': 					$("#passform :input[name='_token']").val()
			};
			sendData(data);
		});

	}

	var sendData = function(data){
		$.ajax({
			url: 		HOST+'/passreset/reset-pass',
			type: 		'POST',
			dataType: 	'json',
			data: 		data,
		}).done(function(response) {
			$('#msgbox').show();
			$('#msgbox').text(response.msg);
		}).fail(function(response) {
			console.log(response);
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
	var reminder = new remind();
	reminder.init();
});