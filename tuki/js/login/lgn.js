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

		$('#recovery').on("formvalid.zf.abide", function(ev,elem) {
			//var	data = {
			//	email: $("#emailrecover").val()
			//};
			//sendrecovery(data);
		});
	}
	$('#resetpass').click(function(event) {
		event.preventDefault();
		$('#recovery').foundation('validateForm');
	});

	var sendrecovery = function(email){
		$.ajax({
			url: HOST+'/passreset/remind',
			type: 'POST',
			dataType: 'json',
			data: email,
		}).done(function(response) {
			$("#recovery span").text(response.msg);
			$("#recovery span").addClass('is-visible');
		}).fail(function(response) {
			console.log(response);
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

	var validation = function(){
		Foundation.Abide.defaults.patterns['valemail'] =  /^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i;
		Foundation.Abide.defaults.validators['max100char'] = function($el,required,parent) {
			if ($el.val().length > 100) {
				return false;
			}			
		}
	}

	var onloadExec = function(){
		bindEvents();
		validation();
	}
	return {
		init:onloadExec
	}

};
$(function(){
	var login = new lgn();
	login.init();
});