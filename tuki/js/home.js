var home = function (){
	var bindEvents = function(){
		$("#month-chart").val($('#panelgraph').attr("data-month"));
		$('#panel1v').append('<canvas id="canvasCommerce" height="109"></canvas>');		
		sendDataChar();
		$('#panelgraph button').click(function(event) {
			event.preventDefault();
			$("#porcents").hide();
			var tabSelected = '';			
			$('#panelgraph .active-blue').removeClass('active-blue');
			$(this).addClass('active-blue');
			tabSelected = $(this).attr("data-tab");
			$('.is-active').removeClass('is-active');
			$(tabSelected).addClass('is-active');
			sendDataChar();
		});
		$("#reportes").click(function(event){
			event.preventDefault();
			window.location.href=HOST+"/reportes";
		});
		$("#comercio").click(function(event){
			event.preventDefault();
			window.location.href=HOST+"/comercio";
		});
		$('#recompensas').click(function(event) {
			event.preventDefault();
			window.location.href=HOST+"/recompensas";
		});	
		$('#month-chart').on('change', function() {
			$("#porcents").hide();
		  sendDataChar();
		});
	}

	var sendDataChar = function(){
		var selectedMonth = $("#month-chart option:selected").val();
		var chart = null;
		if($('#panel1v').hasClass('is-active') ){
			$('#panel1v').empty();
			chart = 1;
		}
		if($('#panel2v').hasClass('is-active')){
			$('#panel2v').empty();
			chart = 2;
		}
		if($('#panel3v').hasClass('is-active')){
			$('#panel3v').empty();
			chart  = 3;
		}
		data = {
			month: selectedMonth,
			chart: chart
		};
		getDataChar(data);	
	}

	var getDataChar = function(data){
		$.ajax({
			url: HOST+'/home/make-charts',
			type: 'GET',
			dataType: 'json',
			data: data,
		}).done(function(response) {
			if(response.success){
				if(response.chart == 1){
					$('#panel1v').empty();
        			$('#panel1v').append('<canvas id="canvasCommerce" height="109"></canvas>');
        			makepercents(response);
				}
				if(response.chart == 2){
					$('#panel2v').empty();
        			$('#panel2v').append('<canvas id="canvasCheck" height="109"></canvas>');
					makepercents(response);
				}
				if(response.chart == 3){
					$('#panel3v').empty();
        			$('#panel3v').append('<canvas id="canvasRedemp" height="109"></canvas>');
        			makepercents(response);
				}
				printChar(response.data,response.chart,response.dataPercents);
				$("#porcents").show();
			}
		}).fail(function(response) {
		});	
	}
	var printChar = function(data,chart,totalsmonth){
		var currentyear = new Date().getFullYear();
		var barChartData = {
			labels : ["1-5","6-10","11-15","16-20","21-25","26-"+getDaysInMonth($("#month-chart option:selected").val(),currentyear)],
			datasets : [
				{
					label: "My First dataset",
					fillColor : "rgba(51,204,51,0.5)",
					strokeColor : "rgba(151,187,205,0.8)",
					highlightFill : "rgba(151,187,205,0.75)",
					highlightStroke : "rgba(151,187,205,1)",
					data :data
				}
			]
		}
		if(chart == 1){
			var ctx = $('#canvasCommerce').get(0).getContext("2d");
			$("#monthTotal").text("Total mes seleccionado: "+totalsmonth.totalCurrentMonthCheckIns+" afiliados.");
		}
		if(chart ==2){
			var ctx = $('#canvasCheck').get(0).getContext("2d");
			$("#monthTotal").text("Total mes seleccionado: "+totalsmonth.totalCurrentMonthCheckIns+" visitas.");
		}
		if(chart == 3){
			var ctx = $('#canvasRedemp').get(0).getContext("2d");
			$("#monthTotal").text("Total mes seleccionado: "+totalsmonth.totalCurrentMonthCheckIns+" redenciones.");	
		}
		var myNewChart = new Chart(ctx).Bar(barChartData, {
			responsive : true
		});
		
	}
	var getDaysInMonth = function(month,year) {
 		return new Date(year, month, 0).getDate();
	}
	var makepercents = function(response){
        var crecimiento = getPorcentPeriod(response.dataPercents.totalCurrentMonthCheckIns,response.dataPercents.totalLastMonthCheckIns)
        var crecimientoRel = getPorcentPeriod(response.dataPercents.totalCurrentMonthCheckIns,response.dataPercents.totalLastMonthSamePeriod)
        if(response.dataPercents.totalCurrentMonthCheckIns == 0 && response.dataPercents.totalLastMonthCheckIns >0 ){
        	crecimiento = '-100%'
        }
     	if(response.dataPercents.totalCurrentMonthCheckIns > 0 && response.dataPercents.totalLastMonthCheckIns ==0 ){
        	crecimiento = '100%'
        }
        if(response.dataPercents.totalCurrentMonthCheckIns == 0 && response.dataPercents.totalLastMonthSamePeriod >0 ){
        	crecimientoRel = '-100%'
        }
     	if(response.dataPercents.totalCurrentMonthCheckIns > 0 && response.dataPercents.totalLastMonthSamePeriod ==0 ){
        	crecimientoRel = '100%'
        }
        $('#lastMonthTotal').text(response.dataPercents.totalLastMonthCheckIns);
        $('#crecimiento').text(crecimiento);
        $('#creRelativo').text(crecimientoRel);		
	}
	var getPorcentPeriod = function(numerador,denominador){
		var porcent = (numerador-denominador);
		porcent = Math.round((porcent/denominador)*100) ;
		if(isNaN(porcent)  || !(isFinite(porcent)) ){
			porcent = 0;
		}
		return porcent+"%";
	}	
	var onloadExec = function(){
		
		bindEvents();
	}
	return {
		init:onloadExec
	}

};
$(function(){
	var hm = new home();
	hm.init();
});