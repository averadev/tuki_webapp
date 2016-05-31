/* FUNCIONES CARGADAS GLOBALMENTE*/	
	var showPanelSuccess = function(message){
		$('.callout').show();
		$('.callout').find('p').text(message);	
		$('.callout').removeClass('warning');
		$('.callout').removeClass('alert');
		$('.callout').addClass('success');
		$('.callout').focus();
	}

	var showPanelAlert = function(message){
		$('.callout').show();
		$('.callout').find('p').text(message);
		$('.callout').removeClass('success');
		$('.callout').removeClass('alert');
		$('.callout').addClass('warning');
		$('.callout').focus();
	}

	var showPanelRed = function(message){
		$('.callout').show();
		$('.callout').find('p').text(message);
		$('.callout').removeClass('success');
		$('.callout').removeClass('warning');
		$('.callout').addClass('alert');
		$('.callout').focus();
	}

	var showSuccesMessage = function(message){
		$('body').showMessage({
			'thisMessage'		: [message],
			className		: 'success',
			location		: 'top',
			autoClose		: true,
			delayTime		: 8000 //in miliseconds
		});
	}
	var showAlertMessage = function(message){
		$('body').showMessage({
			'thisMessage'		: [message],
			className		: 'alert',
			location		: 'top',
			autoClose		: true,
			delayTime		: 8000 //in miliseconds
		});
	}

	var getMonthNames = function(number){
		var monthNames = ["","Ene", "Feb", "Mar", "Abr", "May", "Jun","Jul", "Ago", "Sep", "Oct", "Nov", "Dec"];
		return monthNames[number];
	}

	var MakeDateFormat = function(date){
		var day		= (date).substring(0,2);
		var month	= Number((date).substring(3,5));
		var year	= (date).substring(6,10);
		var date	= day+'/'+getMonthNames(month)+'/'+year;
		return date;
	}

	var MakeDateNormalFormat = function(date){
		var year  = (date).substring(0,4);
		var month = Number((date).substring(5,7));
		var day   = (date).substring(8,10);
		var date = day+'/'+getMonthNames(month)+'/'+year;
		return date;
	}

	var MakeDateNormalFormatNumMonth = function(date){
		var year  = (date).substring(0,4);
		var month = ((date).substring(5,7));
		var day   = (date).substring(8,10);
		var date = day+'/'+month+'/'+year;
		return date;		
	}

	/*Match: coordenada 1.222234567*/
	var regExp_Coords = function (argument){
		regexp = /^[+-]?[0-9]{1,9}(?:\.[0-9]{1,25})?$/;
		return regexp.test(argument);
	}
	/* Match: date DD/MM/YYYY */
	var regExp_Date = function (argument){
		regexp = /^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/;
		return regexp.test(argument);
	}
	/* Match: only integers */
	var regExp_Only_Integers = function (argument){
		regexp = /^[1-9][0-9]*$/;
		return regexp.test(argument);
	}