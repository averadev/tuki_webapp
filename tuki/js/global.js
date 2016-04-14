/* FUNCIONES CARGADAS GLOBALMENTE*/	
	var showPanelSuccess = function(message){
		$('.callout').show();
		$('.callout').find('p').text(message);	
		$('.callout').removeClass('warning')
		$('.callout').addClass('success');
		$('.callout').focus();
	}

	var showPanelAlert = function(message){
		$('.callout').show();
		$('.callout').find('p').text(message);	
		$('.callout').removeClass('success')
		$('.callout').addClass('warning');
		$('.callout').focus();
	}

	var regExp_Coords = function (argument){
		regexp = /^[+-]?[0-9]{1,9}(?:\.[0-9]{1,25})?$/;
		return regexp.test(argument);
	}