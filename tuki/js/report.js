var report = function() {

	var bindEvents = function (){
		$('#dp1').fdatepicker({
			format: 'dd/mm/yyyy',
			language: 'es',
			onRender: function (date) {
			}
		});
		$('#dp2').fdatepicker({
			format: 'dd/mm/yyyy',
			language: 'es',
			onRender: function (date) {
			}
		});	

		$('#cleanreport').click(function(event) {
			$('.form-error').removeClass('is-visible');
			$('#form-export')[0].reset();
			$('#reportToExport').empty();
			$('#dataCompare').empty();
			$("#divCompare").hide();
			$("#tableRedemptions").hide();
			$("#tableActiv").hide();
			$("#divSubmitExcel").hide();
			$("#reportDetails").hide();
		});

		$('#makeExcel').click(function(event){
			if(getInputsReport() !== 0){
				makeReportExcel(getInputsReport());
			}
		});

		$('#make-report').click(function(event){
			if(getInputsReport() !== 0){
				$("#divSubmitExcel").hide();
				getDataReport(getInputsReport());
			}
		});			
	}
	var getDataReport = function (inputs){
		$('#make-report').attr('disabled', true);	
		$.ajax({
			url: HOST+'/reportes/report',
			type: 'GET',
			dataType: 'json',
			data: inputs,
		}).done(function(response) {
			$('#reportDetails').show();
			$("#reportToExport").hide();
			if(response.report){
				if(response.report == 1){ /*Report de Actividades*/
					if(response.totalCheckIns > 0 || response.totalUsers > 0 || response.dataRedemption.length > 0){
						var avgVisitClient = Math.ceil((response.totalCheckIns/response.totalUsers));
						if(isNaN(avgVisitClient) || !(isFinite(avgVisitClient))){
							avgVisitClient =0;
						}
						var countRedemptions = 0;
						$.each(response.dataRedemption, function(index, val) {
							countRedemptions = countRedemptions + Number(val.redemptions);
						});										
						$('#totalCheckInsPeriod').text(response.totalCheckIns);
						$('#newClientesPeriod').text(response.totalUsers);
						$('#recVisitPeriod').text(getPorcent(countRedemptions,response.totalCheckIns));
						$('#avgVisitClient').text(avgVisitClient);
						$("#tableActiv").show();
						$("#divSubmitExcel").show();
						if(response.dataRedemption.length > 0){
							$("#reportToExport").show();					
							makeRedemptionsReport(response);
						}
					}else{
						$("#divSubmitExcel").hide();
						$("#reportToExport").hide();
						$("#reportDetails").hide();
						alert('NO SE ENCONTRARON DATOS');				
					}
				}/* END reporte de Actividades */
				if(response.report == 2){/* Reporte de afiliaciones y visitas */
					if(response.dataCommerce.length > 0){
						$("#reportToExport").show();
						var totalRegistrados = 0;
						var totalVisitas = 0;
						var bodytable = null;
						var count =0;
						var countviews = 0;
						var crecimiento = null;
						var crecimientoVisitas = null;
						$.each(response.dataCommerce, function(index, val) {
							totalRegistrados = totalRegistrados + Number(val.afiliations);
							totalVisitas = totalVisitas + Number(val.views);
						});
						var mainTable = '<div id="dataCompare"><table id="tableData" class="responsive table tableData table-bordered table-striped"></table><div>';
						var headerTable =   '<thead>'+
												'<tr>'+
													'<th>Fecha</th>'+
													'<th>Afiliaciones</th>'+
													'<th>Visitas</th>'+
													'<th>% Afiliaciones</th>'+
													'<th>% Visitas</th>'+
												'</tr>'+
											'</thead>'+
										'</div>';
						$('#reportToExport').append(mainTable);
						$('#tableData').append(headerTable);
						$.each(response.dataCommerce, function(index, val) {
							count = count + Number(val.afiliations);
							countviews = countviews + Number(val.views);
							bodytable =bodytable+ ('<tr><td>'+MakeDateFormat(val.date)+'</td><td>'+val.afiliations+'</td><td>'+val.views+'</td><td>'+getPorcent(val.afiliations,totalRegistrados)+'</td><td>'+getPorcent(val.views,totalVisitas)+'</td></tr>');
						});
						$('#tableData').append('<tbody>'+bodytable+'</tbody>');
						bodytable = null;
						$('#tableData').paging({limit:5});
						var totalAfiliations = Number(response.dataComp.afiliations);
						var totalViews = Number(response.dataCompViews.views);
						if (totalAfiliations <= 0){
							crecimiento = "N/A";
						}else{
							crecimiento = getPorcentPeriod(count,response.dataComp.afiliations);
						}
						if(totalViews <= 0){
							crecimientoVisitas = "N/A";
						}else{
							crecimientoVisitas = getPorcentPeriod(countviews,response.dataCompViews.views);
						}
						$("#lastPeriodo").text('Periodo anterior: '+MakeDateNormalFormat(response.dataComp.startPeriod.date)+' - '+MakeDateNormalFormat(response.dataComp.endPeriod.date));
						$("#afiPeriodo").text(count);
						$("#visiPeriodo").text(countviews);
						$("#afiLastPeriodo").text(response.dataComp.afiliations);
						$("#visiLastPeriodo").text(response.dataCompViews.views);
						$("#crecAfi").text(crecimiento);
						$("#crecvisi").text(crecimientoVisitas);
						$("#divCompare").show();
						$("#reportToExport .paging-nav").find("a[data-page='0']").addClass('selected-page');
						$("#divSubmitExcel").show();
					}else{
						$('#reportToExport').empty();
						$("#divCompare").hide();
						$('#dataCompare').empty();
						$("#divSubmitExcel").hide();
						$("#reportToExport").hide();
						$("#reportDetails").hide();
						alert('NO SE ENCONTRARON DATOS');
					}
				}/* END reporte de afiliaciones y visitas */
				if(response.report == 3){ /*Reporte de Redenciones*/
					if(response.dataRedemption.length > 0){
						$("#reportToExport").show();
						$("#divSubmitExcel").show();
						makeRedemptionsReport(response);
						if(response.unconfirmedRedemptions.length > 0){ //Tabla de redenciones sin confirmar
							var mainUnTable = '<div id="dataUnconfirmed" style="height: auto; padding-bottom:30px; background-color: white;" ><div> <table id="tableUnconfirmed" class="responsive table tableData table-bordered table-striped"></table><div>';
							var unconfirmedBodyTale = null;	
							var countRecords = 0;						
							var unconfirmedHeader = '<thead>'+
													'<tr>'+
														'<th>Recompensa sin confirmar</th>'+
														'<th>Total</th>'+
														'<th>% Total</th>'+
													'</tr>'+
												'</thead>'+
											'</div>';
							$('#reportToExport').append(mainUnTable);
							$('#tableUnconfirmed').append(unconfirmedHeader);
							$.each(response.unconfirmedRedemptions, function(index, val) {
								countRecords = countRecords + Number(val.redemptions);
							});
							$.each(response.unconfirmedRedemptions, function(index, val) {
								unconfirmedBodyTale=unconfirmedBodyTale+('<tr><td>'+val.name+'</td><td>'+val.redemptions+'</td><td>'+getPorcent(val.redemptions,countRecords)+'</td></tr>');
							});							
							$('#tableUnconfirmed').append('<tbody>'+unconfirmedBodyTale+'</tbody>');
							$('#tableUnconfirmed').paging({limit:2});
							$("#reportToExport .paging-nav").find("a[data-page='0']").addClass('selected-page');
							$("#divSubmitExcel").show();
						}
					}else{
						$('#reportToExport').empty();
						$("#tableRedemptions").hide();
						$('#dataCompare').empty();
						$("#divSubmitExcel").hide();
						$("#reportDetails").hide();
						$("#reportToExport").hide();
						alert('NO SE ENCONTRARON DATOS');
					}
				} /*END Reporte de Redenciones*/
			}/* response.report	*/
		}).fail(function(response) {
		}).always(function() {
			$('#make-report').removeAttr('disabled');
		});
				
	}
	var makeReportExcel = function (inputs){
		$.ajax({
			url: HOST+'/reportes/make-excel',
			type: 'GET',
			dataType: 'json',
			data: inputs,
		}).done(function(response) {
			console.log("success");
		})
		.fail(function(response) {
			console.log(response);
		});
	}	

	var makeRedemptionsReport = function(response){
		var countRedemptions = 0;
		var totalRedemtions = 0;
		var totalCrecimiento = null;
		var bodytable = null;
		var mainTable = '<div id="dataCompare" style="padding-bottom:30px;"><table id="tableData" class="responsive table tableData table-bordered table-striped"></table><div>';
		var headerTable =   '<thead>'+
								'<tr>'+
									'<th>Recompensa</th>'+
									'<th>Total</th>'+
									'<th>% Total</th>'+
								'</tr>'+
							'</thead>'+
						'</div>';
		$('#reportToExport').append(mainTable);
		$('#tableData').append(headerTable);
		$.each(response.dataRedemption, function(index, val) {
			countRedemptions = countRedemptions + Number(val.redemptions);
		});
		$.each(response.dataRedemption, function(index, val) {
			bodytable=bodytable+('<tr><td>'+val.name+'</td><td>'+val.redemptions+'</td><td>'+getPorcent(val.redemptions,countRedemptions)+'</td></tr>');
		});
		$('#tableData').append('<tbody>'+bodytable+'</tbody>');
		bodytable = null;
		$('#tableData').paging({limit:5});

		if(response.report == 3){	
			var totalLastRedemptions = Number(response.compRedemptions.redemptions);
			if(totalLastRedemptions <= 0){
				totalCrecimiento = "N/A";
			}else{
				totalCrecimiento = getPorcentPeriod(countRedemptions,totalLastRedemptions);
			}				
			$('#redempPeriodo').text(countRedemptions);
			$('#lastPeriodRemdemp').text(totalLastRedemptions);
			$('#crecRedemp').text(totalCrecimiento);					
			$("#lastPeriodRedemptions").text('Periodo anterior: '+MakeDateNormalFormat(response.compRedemptions.startPeriod.date)+' - '+MakeDateNormalFormat(response.compRedemptions.endPeriod.date));					
			$("#tableRedemptions").show();
		}
		$("#reportToExport .paging-nav").find("a[data-page='0']").addClass('selected-page');
	}

	var getMonthNames = function(number){
		var monthNames = ["","Ene", "Feb", "Mar", "Abr", "May", "Jun",
		"Jul", "Ago", "Sep", "Oct", "Nov", "Dec"];
		return monthNames[number];	
	}

	var MakeDateFormat = function(date){
		var day   = (date).substring(0,2);
		var month = Number((date).substring(3,5));
		var year  = (date).substring(6,10);
		var date = day+'/'+getMonthNames(month)+'/'+year;
		return date;
	}

	var getInputsReport = function(){
			$('#form-export span').removeClass('is-visible');
			$('#reportToExport').empty();
			$("#divCompare").hide();
			$("#tableRedemptions").hide();
			$('#dataCompare').empty();
			$("#tableActiv").hide();
			var errorinput = false;

			if( !($('#sel-report').val()) ){
				errorinput = true;
			}

			if( !($('#dp1').val()) ){
				errorinput = true;
				$('#dp1').parent().next('span').addClass('is-visible');	
			}
			if( !($('#dp2').val()) ){
				errorinput = true;
				$('#dp2').parent().next('span').addClass('is-visible');		
			}

			if(!errorinput){
				var	data ={
					reportType : $("#sel-report").val(),
					startDate  : $('#dp1').val(),
					endDate    : $('#dp2').val()
				}
				$("input:hidden[name='reportType']").val(data.reportType);
				$("input:hidden[name='startDate']").val(data.startDate);
				$("input:hidden[name='endDate']").val(data.endDate);
			return data;
			}
		return 0;
	}

	var MakeDateNormalFormat = function(date){
		var year  = (date).substring(0,4);
		var month = Number((date).substring(5,7));
		var day   = (date).substring(8,10);
		var date = day+'/'+getMonthNames(month)+'/'+year;
		return date;
	}

	var getPorcentPeriod = function(numerador,denominador){
		var porcent = (numerador-denominador);
		porcent = Math.round((porcent/denominador)*100) ;
		if(isNaN(porcent)  || !(isFinite(porcent)) ){
			porcent = 0;
		}
		return porcent+"%";
	}

	var getPorcent = function(numerador,denominador){
		var porcent =  Math.round(((numerador/denominador) * 100));
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
}
$(function () {
	// body...
	var rpt = new report();
	rpt.init();
});