var rwd = function (){
	var bindEvents = function(){
		$("#showRewards").show();
		$("#addReward").hide(); /*intercambiar*/
		//$("#updateReward").hide();	/*borrar*/

		$("#openNewReward").click(function(event) {
			event.preventDefault();
			cleanForm();
			$("#showRewards").hide();
			$("#addReward").show();
			$("#updateReward").hide();
			$("#addNewReward").show();
			$("#addRewardForm").attr('data-row', null);
		});
		$("#cancelReward").click(function(event) {
			event.preventDefault();
			$('.callout').hide();
			$("#showRewards").show();
			$("#addReward").hide();		
		});
		$("#searchbox").on("keyup search input paste cut", function() {
			tblRedemp.search(this.value).draw();
		});
		var nowTemp = new Date();
		var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
		var validdate = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate()+1, 0, 0, 0, 0);
		$('#rewardVig').fdatepicker({
			initialDate: validdate ,
			format: 'dd/mm/yyyy',
			language: 'es',
			onRender: function (date) {
				return date.valueOf() < now.valueOf() ? 'disabled' : '';
			}
		});
		$('#closeModal').click(function(event) {
			event.preventDefault();
			$('#modal-reward').foundation('close');
		});
		$('#saveReward').click(function(event) {
			event.preventDefault();
			/*Agrego la imagen y el css con las dimensiones seleccionadas por el usuario*/
			//$("#imgrewardtoshow").attr("src",objurl);
			var img = document.getElementById("imagereal");
			var crop_canvas = document.createElement('canvas');
			crop_canvas.width = 440;
			crop_canvas.height = 330;
			if(rewardImg.x1 > 0){
				rewardImg.x1 = (rewardImg.x1/0.5).toFixed(0);
			}
			if(rewardImg.x2 > 0){
				rewardImg.x2 = (rewardImg.x2/0.5).toFixed(0);
			}
			if(rewardImg.y1 > 0){
				rewardImg.y1 = (rewardImg.y1/0.5).toFixed(0);
			}
			if(rewardImg.y2 > 0){
				rewardImg.y2 = (rewardImg.y2/0.5).toFixed(0);
			}
			crop_canvas.getContext('2d').drawImage(img, rewardImg.x1, rewardImg.y1, 440, 330, 0, 0, 440, 330);
			$("#imgrewardtoshow").attr("src",crop_canvas.toDataURL("image/png"));
			$("#inputimgreward").val(crop_canvas.toDataURL("image/png"));			
			/*Elimino el plugin para el area select de la imagen*/
			$('#imgreward').imgAreaSelect({remove:true});
			/*Cierro el modal*/
			$('#modal-reward').foundation('close');
		});
		$('#addNewReward').click(function(event) {
			event.preventDefault();
			$('#addRewardForm').foundation('validateForm');
		});

		$('#updateReward').click(function(event) {
			event.preventDefault();
			$('#addRewardForm').foundation('validateForm');   					
		});		
		
		$('#modal-reward').on("open.zf.reveal", function(event,elem) {
			$('#imgreward').imgAreaSelect({resizable:false,persistent:true, x1: 0, y1: 0, x2: 220, y2: 165,
				onSelectEnd: function (img, selection) {
					rewardImg = {
						'x1' : selection.x1,
						'x2' : selection.x2,
						'y1' : selection.y1,
						'y2' : selection.y2
					};
				},onInit: function (img, selection) {
					rewardImg = {
						'x1' : selection.x1,
						'x2' : selection.x2,
						'y1' : selection.y1,
						'y2' : selection.y2
					};
				}
			});
		});

		$('#modal-reward').on("closed.zf.reveal", function(event,elem) {
			$('#imgreward').imgAreaSelect({remove:true});
		});

		$('#addRewardForm').on("formvalid.zf.abide", function(ev,elem) {
			var update = $("#addRewardForm").attr('data-row');
			var redemptionsNumber = $("#addRewardForm").attr('redemptions-row'); 
			var imgSelected = false;
			var form = {
				'name'		  :$('#rewardName').val(),
				'description' :$('#rewardDesc').val(),
				'terms'		  :$('#rewardtermns').val(),
				'points'	  :$('#rewardPoints').val(),
				'image' 	  :$("#inputimgreward").val(),
				'vigency'	  :$('#rewardVig').val()
			}
			if(update){
				form.rewardList = Number(update); /*Agregar el id en caso de que sea una actualizacion*/
				sendDataUpdate(form,redemptionsNumber);
			}else{
				if($("#inputimgreward").val()){
					imgSelected = true;
				}else{
					$('#reward-upload').next('span').show();
				}
				if(imgSelected){
					sendData(form);
				}
			}
		});
		$('#tblRedemp').on('click', '.edtReward', function(event) {
			event.preventDefault();
			cleanForm();		
			var row= $(this).closest('tr');
			var idx = tblRedemp.row( row ).index();
			$("#showRewards").hide();
			$("#addReward").show();
			$("#updateReward").show();
			$("#addNewReward").hide();
			var rowID = row.children('td').eq(4).find('.divdata').find('.dataRewList').text();
			var rowImage = row.children('td').eq(4).find('.divdata').find('.dataRewImage').text();
			var rowDesc = row.children('td').eq(4).find('.divdata').find('.dataRewDesc').text();
			var rowTerms = row.children('td').eq(4).find('.divdata').find('.dataRewTerms').text();
			var rowRedemptions = row.children('td').eq(2).text();			
			/*set form values*/
			$("#rewardName").val(row.children('td').eq(0).text());
			$("#rewardDesc").val(rowDesc.trim());
			$('#rewardtermns').val(rowTerms.trim());
			$("#rewardVig").val(row.children('td').eq(3).text());
			$("#rewardPoints").val(row.children('td').eq(1).text());
			$("#addRewardForm").attr('data-row', rowID); /*ID data*/
			$("#addRewardForm").attr('selected-row', idx); /*Row table selected*/
			$("#addRewardForm").attr('redemptions-row', rowRedemptions);
			$("#addRewardForm").attr('image-row',rowImage.trim());
			$("#imgrewardtoshow").attr("src","api/assets/img/api/rewards/"+rowImage.trim());
			/*end set form values*/			
		});		

		$('input[name=reward-upload]').change(function(e) {
			$('#reward-upload').next('span').hide();
			var file = e.target.files[0];
			canvasResize(file, {
				width: 220,
				height: 165,
				real_width: 440,
				real_height: 330,
				progressbar : $('#rewardbar'),
				crop: false,
				quality: 100,
				//rotate: 90,
				callback: function(data, width, height,sameSize,radio,resizeWidth,original_sizePic) {
					if(!sameSize){
						var newComponent = 	"<img class='imgStopMaxWidth' id='imgreward' src=''/>";

						$("#modal-reward .reveal-body").empty();
						$('#modal-reward .reveal-body').append(newComponent);
						var blob = window.dataURLtoBlob && window.dataURLtoBlob(data);
						var objurl = window.URL.createObjectURL(blob);
						var real_blob = window.dataURLtoBlob && window.dataURLtoBlob(original_sizePic);
						var real_objurl = window.URL.createObjectURL(real_blob);
						var realImgComponent = "<img class='imgStopMaxWidth hidden' id='imagereal' src=''/>";
						$('#modal-reward .reveal-body').append(realImgComponent);
						$("#imagereal").attr("src", real_objurl);
						$("#imgreward").attr("src", objurl);
						$('#modal-reward').foundation('open');						
					}else{
						$("#imgrewardtoshow").attr("src", original_sizePic);
						$("#inputimgreward").val(original_sizePic);
					}
				}
			});
		});		
	}

	var loadTable  = function(){
	 tblRedemp = $('#tblRedemp').DataTable({
			"columns": [
			{ "width": "40%" },
			{ "width": "15%" },
			{ "width": "15%" },
			{ "width": "20%" },
			{ "width": "10%" },
  			],	 	
			"autoWidth": false,
			"bSort": true,
			"scrollX": false, /*Enable horizontal scrolling. When a table is too wide to fit into a certain layout, pero causaba desajute en el tamaño cuando se ocultaba la tabla*/
			"bLengthChange": false,
			"bFilter": true ,  /*searchbox completly disable on false*/
			  "columnDefs": [ {
			  "targets": [4],
			  "orderable": false /*desactivar sorting para columna 5*/
			} ],
			"language": {
				"lengthMenu": "Mostrar _MENU_ Regristros por pagina",
				"zeroRecords": "No se encontraron datos",
				"info": "Mostrando _START_ hasta _END_ de _TOTAL_ recompensas.",
				"infoEmpty": "Sin datos",
				"infoFiltered":   "(filtrados de _MAX_ recompensas)",
				"search": "",
					"paginate": {
						"previous": "<<",
						"next": ">>",
					},
			 }, "createdRow": function ( row, data, index ) {
				$('td', row).eq(3).html(MakeDateNormalFormatNumMonth(data[3]));
			},

		}); 
	}

	var validation = function(){
		Foundation.Abide.defaults.validators['check-date'] = function($el,required,parent) {
			if (!($el.val())) {
				$el.next('span').text('Campo requerido');
				return false;
			}			
			if ((!regExp_Date($el.val()))) {
				$el.next('span').text('El formato no es correcto');
				return false;
			}
		}
		Foundation.Abide.defaults.validators['check-only-interger'] = function($el,required,parent) {
			if (!($el.val())) {
				$el.next('span').text('Campo requerido');
				return false;
			}			
			if ((!regExp_Only_Integers($el.val()))) {
				$el.next('span').text('Solo numeros enteros');
				return false;
			}			
		}
	}
	var sendData = function(form){
		$('#addNewReward').attr('disabled', true);
		$.ajax({
			url: HOST+'/recompensas/new-reward',
			type: 'POST',
			dataType: 'json',
			data: form,
		}).done(function(response) {
			if(!(response.error)){
				cleanForm();
				showSuccesMessage(response.msg);
				$("#showRewards").show();
				$("#addReward").hide();	
				tblRedemp.row.add( [
					form.name,
					form.points,
					'0',
					response.vigency,
					"<span><a class='edtReward font-color-black'><i class='fa fa-pencil-square-o'></i>editar</a></span>"+
					"<div class='divdata' hidden='true'><data class='dataRewDesc'>"+form.description+"</data><data class='dataRewTerms'>"+form.terms+"</data><data class='dataRewImage'>"+response.image+"</data><data class='dataRewList'>"+response.listReward+"</data></div>"
				] ).draw( false );
			}else{
				showAlertMessage(response.msg);
			}
		}).fail(function(response) {
			console.log(response);
		}).always(function() {
			$('#addNewReward').removeAttr('disabled');
		});		
	}
	var sendDataUpdate = function(form,redempnumber){
		$('#updateReward').attr('disabled', true);
		$.ajax({
			url: HOST+'/recompensas/update-reward',
			type: 'PUT',
			dataType: 'json',
			data: form,
		}).done(function(response) {
			if(!(response.error)){
				showSuccesMessage(response.msg);
				$("#showRewards").show();
				$("#addReward").hide();
				var imageAction
				if(form.image){
					 imageAction = response.image;
				}else{
 					imageAction = $("#addRewardForm").attr('image-row');
				}
				var rowToUpdate = $("#addRewardForm").attr('selected-row');
				$('#tblRedemp').dataTable().fnUpdate( [
					form.name, 
					form.points, 
					redempnumber, 
					form.vigency, 
					"<span><a class='edtReward font-color-black'><i class='fa fa-pencil-square-o'></i>editar</a></span>"+
					"<div class='divdata' hidden='true'><data class='dataRewDesc'>"+form.description+"</data><data class='dataRewTerms'>"+form.terms+"</data><data class='dataRewImage'>"+imageAction+"</data><data class='dataRewList'>"+form.rewardList+"</data></div>"], rowToUpdate ); // Row
			/*	$('#tblRedemp').dataTable().fnUpdate('Example update', rowToUpdate, 1);	*/
			}else{
				showAlertMessage(response.msg);
			}
		}).fail(function(response) {
			console.log(response);
		}).always(function() {
			$('#updateReward').removeAttr('disabled');
		});		
	}
	var cleanForm = function(){
		$('.callout').hide();
		$("#addRewardForm").find('.is-invalid-input').removeClass('is-invalid-input');
		$("#addRewardForm").find('.is-invalid-label').removeClass('is-invalid-label');
		$("#addRewardForm").find('.form-error.is-visible').removeClass('is-visible');
		$('#rewardName').val('');
		$('#rewardDesc').val('');
		$('#rewardtermns').val('');
		$('#rewardPoints').val('');
		$("#inputimgreward").val('');
		$('#rewardVig').val('');
		$("#imgrewardtoshow").attr("src", '');
		$('#addNewReward').removeAttr('disabled');
		$('#updateReward').removeAttr('disabled');
	}

	var onloadExec = function(){
		loadTable();
		validation();
		bindEvents();
		objurl = "";
	}	
	return {
		init:onloadExec
	}	
};
$(function(){
	var reward = new rwd();
	reward.init();
});
