var cmrce = function (){
	var bindEvents = function(){
		$("#logo").val('');
		$("#portada").val('');
		$('select[name="colorpicker-picker-longlist"]').simplecolorpicker({picker: true});
		$('#locationEditable').attr('checked', false);
		$form.on("formvalid.zf.abide", function(ev,elem) {
			var emptyimage = false;			
			var form = {
				'name' 		  :$('#commerceName').val(),
				'slogan'	  :$('#commerceSlogan').val(),
				'description' :$('#descriptionCom').val(),
				'color' 	  :$('select[name="colorpicker-picker-longlist"]').find(':selected').data('color'),
				'logo' 		  :$("#logo").val(),
				'portada' 	  :$("#portada").val(),
				'website' 	  :$('#webCom').val(),
				'facebook' 	  :$('#facebook').val(),
				'twitter' 	  :$('#twitter').val()
			};
	
			if($('#imgportadatoshow').attr('src') == '') {
				emptyimage = true;
				//$('#imgportadatoshow').parent().parent().find('label').addClass('is-invalid-label');
				$('#imgportadatoshow').parent().parent().find('span.form-error').text('La portada es requerida');
				$('#imgportadatoshow').parent().parent().find('span').addClass('is-visible');
				$('#fileupload').focus();
			}
			if($('#imglogotoshow').attr('src') == '') {
				emptyimage = true;
				//$('#imglogotoshow').parent().parent().find('label').addClass('is-invalid-label');
				$('#imgportadatoshow').parent().parent().find('span.form-error').text('El logotipo es requerido');
				$('#imglogotoshow').parent().parent().find('span').addClass('is-visible');
				$('#portada-upload').focus()
			}
			var table =  $('#tblBranch').DataTable();
			var data = table.rows().data().length;
			if(data>0){
				if(!emptyimage){
					var rowIDs = rowGallery;
					if(rowIDs.length>0){
						rowIDs = JSON.stringify(rowGallery);
						sendGalleryDelete(rowIDs);
					}
					sendData(form);
					var formDataGallery = new FormData();
					//formDataGallery.append(name, blob);
					if(saveblobGallery.length>0){
						$.each(saveblobGallery, function(index, val) {
							formDataGallery.append('photo_'+index, val);
						});
						sendGalleryImages(formDataGallery);					
					}
				}
			}else{
				modal({
					type: 'alert',
					title: 'Mensaje',
					text: "Debe de tener registrada una sucursal"
				});
			}			
		});
		$('#cancelCommerce').click(function(event) {
			event.preventDefault();
			window.location.href=HOST;
		});
		$('#updateCommerce').click(function(event) {
			event.preventDefault();
			$('#addCommerce').foundation('validateForm');	
			$('#addCommerce').find('span.form-error').text('Campo requerido');   					
		});			
		$('#closeModal').click(function(event) {
			event.preventDefault();
			$('#modal-portada').foundation('close');
		});
		$('#dismissModal').click(function(event) {
			event.preventDefault();
			$('#modal-logo').foundation('close');
		});
		$('#hidemodal').click(function(event) {
			event.preventDefault();
			$('#modal-gallery').foundation('close');
		});
		$('#mainGallery').on('click','.remove-image', function(event) {
			event.preventDefault();
			var row = $(this).closest('div').parent('div');
			var position = row.index();
			var rowID = row.attr('data-pic');
			var total = countGallery()-1;
			position =  total-position ;
			row.remove();
			if(!rowID){
				saveblobGallery.splice(position,1);
			}else{
				rowGallery.push(rowID);
			}

		});

		$('#saveLogo').click(function(event) {
			event.preventDefault();
			var img = document.getElementById("imglogo");
			var crop_canvas = document.createElement('canvas');
			crop_canvas.width = 200;
			crop_canvas.height = 200;
			crop_canvas.getContext('2d').drawImage(img, (logoDimImg.x1).toFixed(0), (logoDimImg.y1).toFixed(0), 200, 200, 0, 0, 200, 200);
			$("#imglogotoshow").attr("src",crop_canvas.toDataURL("image/png"));
			$("#logo").val(crop_canvas.toDataURL("image/png"));
			$('#modal-logo').foundation('close');
		});
		$('#savePortada').click(function(event) {
			event.preventDefault();
			var img = document.getElementById("hiddenBanner");
			var crop_canvas = document.createElement('canvas');
			crop_canvas.width = 440;
			crop_canvas.height = 280;
			if(bannerDimImg.x1 > 0){
				bannerDimImg.x1 = (bannerDimImg.x1/0.5).toFixed(0);
			}
			if(bannerDimImg.x2 > 0){
				bannerDimImg.x2 = (bannerDimImg.x2/0.5).toFixed(0);
			}
			if(bannerDimImg.y1 > 0){
				bannerDimImg.y1 = (bannerDimImg.y1/0.5).toFixed(0);
			}
			if(bannerDimImg.y2 > 0){
				bannerDimImg.y2 = (bannerDimImg.y2/0.5).toFixed(0);
			}			
			crop_canvas.getContext('2d').drawImage(img, bannerDimImg.x1, bannerDimImg.y1, 440, 280, 0, 0, 440, 280);
			$("#imgportadatoshow").attr("src",crop_canvas.toDataURL("image/png"));
			$("#portada").val(crop_canvas.toDataURL("image/png"));
			$('#modal-portada').foundation('close');
		});

		$('#savefotoGalery').click(function(event) {
			event.preventDefault();
			var img = document.getElementById("galleryhidden");
			var crop_canvas = document.createElement('canvas');
			crop_canvas.width = 320;
			crop_canvas.height = 240;
			if(galleryDimImg.x1 > 0){
				galleryDimImg.x1 = (galleryDimImg.x1/0.6).toFixed(0);
			}
			if(galleryDimImg.x2 > 0){
				galleryDimImg.x2 = (galleryDimImg.x2/0.6).toFixed(0);
			}
			if(galleryDimImg.y1 > 0){
				galleryDimImg.y1 = (galleryDimImg.y1/0.6).toFixed(0);
			}
			if(galleryDimImg.y2 > 0){
				galleryDimImg.y2 = (galleryDimImg.y2/0.6).toFixed(0);
			}		
			crop_canvas.getContext('2d').drawImage(img, galleryDimImg.x1, galleryDimImg.y1, 320, 240, 0, 0, 320, 240);
			//window.open(crop_canvas.toDataURL("image/png"));
			//$(".gallery-pics").prepend('<img class="gallery-new" src="'+crop_canvas.toDataURL("image/png")+'"/>');
			var imageUrl=crop_canvas.toDataURL("image/png");
			var blob = window.dataURLtoBlob && window.dataURLtoBlob(imageUrl);
			var objurl = window.URL.createObjectURL(blob);
			$(".gallery-pics").prepend('<div class="divPhotoGallery"><div class="afterGallery"><span class"fontRemove"><i class="fa fa-times-circle remove-image"></i></span></div><img class="gallery-new" src="'+objurl+'"/></div>');
			saveblobGallery.push(blob);
			$('#modal-gallery').foundation('close');		
		});

		/*Add area select plugin to img when modal open*/

		$('#modal-logo').on("open.zf.reveal", function(event,elem) {
			$('#imglogo').imgAreaSelect({resizable:false,persistent:true, x1: 0, y1: 0, x2: 200, y2: 200,
				onSelectEnd: function (img, selection) {
					logoDimImg = {
						'x1' : selection.x1,
						'x2' : selection.x2,
						'y1' : selection.y1,
						'y2' : selection.y2
					};
				},onInit: function (img, selection) {
					logoDimImg = {
						'x1' : selection.x1,
						'x2' : selection.x2,
						'y1' : selection.y1,
						'y2' : selection.y2
					};
				}
			 });
		});

		$('#modal-portada').on("open.zf.reveal", function(event,elem) {
			$('#imgportada').imgAreaSelect({resizable:false,persistent:true, x1: 0, y1: 0, x2: 220, y2: 140,
				onSelectEnd: function (img, selection) {
					bannerDimImg = {
						'x1' : selection.x1,
						'x2' : selection.x2,
						'y1' : selection.y1,
						'y2' : selection.y2
					};
				},onInit: function (img, selection) {
					bannerDimImg = {
						'x1' : selection.x1,
						'x2' : selection.x2,
						'y1' : selection.y1,
						'y2' : selection.y2
					};
				}
			});
		});

		$('#modal-gallery').on("open.zf.reveal", function(event,elem) {
			$('#imggallery').imgAreaSelect({resizable:false,persistent:true, x1: 0, y1: 0, x2: 192, y2: 144,
				onSelectEnd: function (img, selection) {
					galleryDimImg = {
						'x1' : selection.x1,
						'x2' : selection.x2,
						'y1' : selection.y1,
						'y2' : selection.y2
					};
				},onInit: function (img, selection) {
					galleryDimImg = {
						'x1' : selection.x1,
						'x2' : selection.x2,
						'y1' : selection.y1,
						'y2' : selection.y2
					};
				}
			});
		});		

		/*END ADD PLUGIN*>

		/*Remove areaselect plugins onclose*/
		$('#modal-logo').on("closed.zf.reveal", function(event,elem) {
			$('#imglogo').imgAreaSelect({remove:true});
		});

		$('#modal-portada').on("closed.zf.reveal", function(event,elem) {
			$('#imgportada').imgAreaSelect({remove:true});
		});

		$('#modal-gallery').on("closed.zf.reveal", function(event,elem) {
			$('#imggallery').imgAreaSelect({remove:true});
		});

		/*END REMOVE*/		

		$("#addnewPhoto").click(function(event) {
			event.preventDefault();
			$('#photogalleryUp').trigger('click');
		});

		$('input[name=logo-upload]').change(function(e) {
			var file = e.target.files[0];
			canvasResize(file, {
				width: 200,
				height: 200,
				real_width: 200,
				real_height: 200,	
				progressbar : $('#logobar'),
				crop: false,
				quality: 100,
				//rotate: 90,
				callback: function(data, width, height,sameSize,radio,resizeWidth,original_sizePic) {
					if(!sameSize){
						var newComponent = "<div class='overlay'><div class='overlay-inner'></div></div><img class='imgStopMaxWidth' id='imglogo' src=''/>";
						$("#modal-logo .reveal-body").empty();
						$('#modal-logo .reveal-body').append(newComponent);
						var blob = window.dataURLtoBlob && window.dataURLtoBlob(data);
						var objurl = window.URL.createObjectURL(blob);
						$("#imglogo").attr("src", objurl);

						$('#modal-logo').foundation('open');						
					}else{
						$("#imglogotoshow").attr("src", original_sizePic);
						$("#logo").val(original_sizePic);
					}
				}
			});
		});

		$('input[name=portada-upload]').change(function(e) {
			var file = e.target.files[0];
			canvasResize(file, {
				width: 220,
				height: 140,
				real_width: 440,
				real_height: 280,				
				progressbar : $('#portadabar'),
				crop: false,
				quality: 100,
				//rotate: 90,
				callback: function(data, width, height,sameSize,radio,resizeWidth,original_sizePic) {
					if(!sameSize){
						var newComponent = 	"<div class='overlay portada'><div class='overlay-inner'></div></div><img class='imgStopMaxWidth' id='imgportada' src=''/>";
						$("#modal-portada .reveal-body").empty();
						$('#modal-portada .reveal-body').append(newComponent);
						var blob = window.dataURLtoBlob && window.dataURLtoBlob(data);
						var objurl = window.URL.createObjectURL(blob);
						var real_blob = window.dataURLtoBlob && window.dataURLtoBlob(original_sizePic);
						var real_objurl = window.URL.createObjectURL(real_blob);
						var realImgComponent = "<img class='imgStopMaxWidth hidden' id='hiddenBanner' src=''/>";					
						$('#modal-portada .reveal-body').append(realImgComponent);
						$("#imgportada").attr("src", objurl);
						$("#hiddenBanner").attr("src", real_objurl);
						$('#modal-portada').foundation('open');
					}else{
						$("#imgportadatoshow").attr("src", data);
						$("#portada").val(data);
					}
				}
			});
		});	

		$('input[name=photogalleryUp]').change(function(e) {
			var file = e.target.files[0];
			canvasResize(file, {
				width: 192,
				height: 144,				
				real_width: 320,
				real_height: 240,
				progressbar : $('#gallery-progress'),
				crop: false,
				quality: 100,
				//rotate: 90,
				callback: function(data, width, height,sameSize,radio,resizeWidth,original_sizePic) {
					if(!sameSize){
						var newComponent = 	"<img class='imgStopMaxWidth' id='imggallery' src=''/>";
						$("#modal-gallery .reveal-body").empty();
						$('#modal-gallery .reveal-body').append(newComponent);
						var blob = window.dataURLtoBlob && window.dataURLtoBlob(data);
						var objurl = window.URL.createObjectURL(blob);
						var real_blob = window.dataURLtoBlob && window.dataURLtoBlob(original_sizePic);
						var real_objurl = window.URL.createObjectURL(real_blob);
						var realImgComponent = "<img class='imgStopMaxWidth hidden' id='galleryhidden' src=''/>";
						$('#modal-gallery .reveal-body').append(realImgComponent);						
						$("#imggallery").attr("src", objurl);
						$("#galleryhidden").attr("src", real_objurl);	
						$('#modal-gallery').foundation('open');
					}else{
						//$(".gallery-pics").prepend('<img class="gallery-new" src="'+data+'"/>');
						var blob = window.dataURLtoBlob && window.dataURLtoBlob(original_sizePic);
						var objurl = window.URL.createObjectURL(blob);
						$(".gallery-pics").prepend('<div class="divPhotoGallery"><div class="afterGallery"><span class"fontRemove"><i class="fa fa-times-circle remove-image"></i></span></div><img class="gallery-new" src="'+objurl+'"/></div>');
						saveblobGallery.push(blob);
					}
				}
			});
		});

	/*  B R A N C H S */

	$('#modalNewBranch').on("open.zf.reveal", function(ev,elem) {
		ev.preventDefault();

		google.maps.event.trigger(_self.vars.map, 'resize');
		//if(!googleloaded){
		//	$(document).gMapsLatLonPicker().init( $(".gllpLatlonPicker") );
		//	googleloaded = 1;
		//}
	});
	$("#addNewBranch").click(function(event) { /*Open modal to add new branch*/
		event.preventDefault();
		$("#headerNewBranch").text('Nueva sucursal');
		$("#addNewBranchForm").attr('data-row', null);
		$("#saveBranch").show();
		$("#updateBranch").hide();
		cleanAddBranchForm();
		$(".gllpUpdateButton").trigger( "click" );
		$("#modalNewBranch").foundation("open");
	});
	$("#closeModalBranch").click(function(event) {
		event.preventDefault();
		$("#modalNewBranch").foundation("close");
	});
	$("#updateBranch").click(function(event) {
		event.preventDefault();
		$('#addNewBranchForm').foundation('validateForm');
		if(!($("#latBranch").val() && $("#longBranch").val()) || ($("#latBranch").val() == 0 && $("#longBranch").val() == 0) ){
			$("#span-coords").show();
		}else{
			$("#span-coords").hide();
		}		
	});

	$("#saveBranch").click(function(event) {
		event.preventDefault();
		$('#addNewBranchForm').foundation('validateForm');
		if(!($("#latBranch").val() && $("#longBranch").val()) || ($("#latBranch").val() == 0 && $("#longBranch").val() == 0) ){
			$("#span-coords").show();
		}else{
			$("#span-coords").hide();
		}
	});

	$('#addNewBranchForm').on("formvalid.zf.abide", function(ev,elem) {
		ev.preventDefault();
		var update = $("#addNewBranchForm").attr('data-row');
		var validform = false;
		var form = {
			'name'			:$('#branchName').val(),
			'address'		:$('#branchAddress').val(),
			'phone'			:$('#branchPhone').val(),
			'latbranch'		:$('#latBranch').val(),
			'longbranch'	:$('#longBranch').val()
		};
		if(!($("#latBranch").val() && $("#longBranch").val()) || ($("#latBranch").val() == 0 && $("#longBranch").val() == 0) ){
			validform = false;
		}else{
			validform = true;
		}
		if(validform){
			if(update){
				form.branchRow = Number(update);
				updateBranch(form);
			}else{
				sendNewBranch(form);
			}
		}
	});

	$('#tblBranch').on('click', '.edtBranch', function(event) {
		event.preventDefault();
		$("#modalNewBranch").foundation("open");
		$("#headerNewBranch").text('Actualizar sucursal');
		$("#span-coords").hide();
		$("#saveBranch").hide();
		$("#updateBranch").show();
		$('#locationEditable').attr('checked', false);
		$('#locationEditable').trigger("change");
		$('#addNewBranchForm').foundation('resetForm');
		$("#autocomplete-google").val("");
		var row= $(this).closest('tr');
		var idx = tblBranch.row( row ).index();
		var rowID = row.children('td').eq(2).find('.divdata').find('.dataBranchRow').text();
		var address = row.children('td').eq(2).find('.divdata').find('.dataBranchAddress').text();
		var latitud = row.children('td').eq(2).find('.divdata').find('.dataBranchLat').text();
		var longitud = row.children('td').eq(2).find('.divdata').find('.dataBranchLong').text();
		var name = row.children('td').eq(0).text().trim();
		var phone = row.children('td').eq(1).text().trim();
		$('#latBranch').val(latitud);
		$('#longBranch').val(longitud);
		$('#branchName').val(name);
		$('#branchAddress').val(address);
		$('#branchPhone').val(phone);
		$(".gllpUpdateButton").trigger( "click" );
		$("#addNewBranchForm").attr('data-row', rowID);	  /*ID data*/
		$("#addNewBranchForm").attr('selected-row', idx); /*Row table selected*/
	});

	$('#tblBranch').on('click', '.delBranch', function(event) {
		event.preventDefault();
		var row= $(this).closest('tr');
		var rowData = row.children('td').eq(2).find('.divdata').find('.dataBranchRow').text();
		var numberRow = tblBranch.row( row ).index();
		var branch = row.children('td').eq(0).text().trim();
		modal({
			type: 'confirm',
			title: 'Eliminar sucursal',
			text: '¿Estas seguro que desea eliminar la sucursal  <b>'+branch+'</b>?, sus usuarios y cajeros seran desasignados.' ,
			callback: function(result) {
				if(result){
					deleteBranch(rowData,numberRow);
				}
			}
		});
	});
	/*  E N D   B R A N C H S */

	}
	/*AJAX REQUESTS*/
	var sendData = function (form){
		$('#updateCommerce').attr('disabled', true);	
		$.ajax({
			type: "PUT",
			dataType: "json", 
			url:  HOST+'/comercio/update-commerce',
			data: form, 
		}).done(function(response) {
			if(!response.error){
				showSuccesMessage(response.msg);
				if($("#logo").val() !== ''){
					$("#logo_header").attr("src", $("#logo").val());
				}
				$("#logo").val('');
				$("#portada").val('');
			}else{
				showAlertMessage(response.msg);
			}
		}).fail(function() {
		}).always(function() {
		$('#updateCommerce').removeAttr('disabled');
		});
	}

	var sendNewBranch = function(form){
		$.ajax({
			type: "POST",
			dataType: "json", 
			url:  HOST+'/comercio/store-branch',
			data: form, 
		}).done(function(response) {
			if(!response.error){
				showSuccesMessage(response.msg);
				tblBranch.row.add( [
					form.name,
					form.phone,					
					"<span><a class='edtBranch font-color-black'><i class='fa fa-pencil-square-o'></i></a></span> <span><a class='delBranch font-color-black'><i class='fa fa-trash-o'></i></a></span>"+
					"<div class='divdata' hidden='true'><data class='dataBranchRow'>"+response.dataRow+"</data><data class='dataBranchAddress'>"+form.address+"</data><data class='dataBranchLat'>"+form.latbranch+"</data><data class='dataBranchLong'>"+form.longbranch+"</data></div>"
				] ).draw( false );				
				$("#modalNewBranch").foundation("close");
			}else{
				showAlertMessage(response.msg);
			}
		}).fail(function(response) {
			console.log("error");
		});
		
	}
 
	var updateBranch = function(form){
		$.ajax({
			url:  HOST+'/comercio/update-branch',
			type: 'PUT',
			dataType: 'json',
			data: form,
		}).done(function(response) {
			if(!response.error){
				showSuccesMessage(response.msg);
				var rowToUpdate = $("#addNewBranchForm").attr('selected-row');				
				$('#tblBranch').dataTable().fnUpdate( [
					form.name,
					form.phone,					
					"<span><a class='edtBranch font-color-black'><i class='fa fa-pencil-square-o'></i></a></span> <span><a class='delBranch font-color-black'><i class='fa fa-trash-o'></i></a></span>"+					
					"<div class='divdata' hidden='true'><data class='dataBranchRow'>"+form.branchRow+"</data><data class='dataBranchAddress'>"+form.address+"</data><data class='dataBranchLat'>"+form.latbranch+"</data><data class='dataBranchLong'>"+form.longbranch+"</data></div>"
					], rowToUpdate );
				$("#modalNewBranch").foundation("close");
			}else{
				showAlertMessage(response.msg);
			}
		}).fail(function(response) {
			console.log("error");
		});		
	}

	var deleteBranch = function(dataId,numberRow){

		$.ajax({
			url:  HOST+'/comercio/drop-branch',
			type: 'DELETE',
			dataType: 'json',
			data: {daraRow: dataId},
		}).done(function(response) {
			if(!(response.error)){
				showSuccesMessage(response.msg);
				tblBranch.row(numberRow).remove().draw();
			}else{
				showAlertMessage(response.msg);
			}
		}).fail(function() {
			console.log("error");
		});
		
	}

	var sendGalleryImages = function(formGallery){
		$.ajax({
			url: HOST+'/comercio/image-gallery',
			processData: false,
  			contentType: false,
			type: 'POST',
			data: formGallery,
		}).done(function(response) {
			var img = null;
			var addnewpic = $("#gallerytoShow").detach();
			$("#mainGallery").empty();
			$.each(response.photos, function(index, val) {
				img = '<div class="divPhotoGallery" data-pic="'+val.id+'"><div class="afterGallery"><span class"fontRemove"><i class="fa fa-times-circle remove-image"></i></span></div><img src="api/assets/img/api/commerce/photos/'+val.image+'"/></div>';
				$("#mainGallery").append(img);	
			});
			$("#mainGallery").append(addnewpic);
		}).fail(function(response) {
			console.log(response);
		}).always(function() {
			saveblobGallery = [];
		});			
	}

	var sendGalleryDelete = function(data){
		$.ajax({
			url: HOST+'/comercio/drop-photos',
			type: 'DELETE',
			dataType: 'json',
			data: {row: data},
		}).done(function(response) {
			console.log(response);
		}).fail(function(response) {
			console.log(response);
		}).always(function() {
			//$("#mainGallery").find('.gallery-new').removeClass('gallery-new'); /*Se elimina la clase que identificar a las imagenes que se acaban de agregaar y subir*/
			rowGallery =[];
		});		
	}	

	var validation = function(){
		Foundation.Abide.defaults.patterns['dashes_only'] = /^[0-9-]*$/;
		Foundation.Abide.defaults.validators['max50char'] = function($el,required,parent) {
			if ($el.val().length > 50) {
				$el.next('span').text('No debe ser mayor de 50 caracteres');
				return false;
			}			
		}
		Foundation.Abide.defaults.validators['max100char'] = function($el,required,parent) {
			if ($el.val().length > 100) {
				$el.next('span').text('No debe ser mayor de 100 caracteres');
				return false;
			}			
		},Foundation.Abide.defaults.validators['max500char'] = function($el,required,parent) {
			if ($el.val().length > 500) {
				$el.next('span').text('No debe ser mayor de 500 caracteres');
				return false;
			}			
		},Foundation.Abide.defaults.validators['max30char'] = function($el,required,parent) {
			if ($el.val().length > 30) {
				$el.next('span').text('No debe ser mayor de 30 caracteres');
				return false;
			}			
		},Foundation.Abide.defaults.validators['max150char'] = function($el,required,parent) {
			if ($el.val().length > 150) {
				$el.next('span').text('No debe ser mayor de 150 caracteres');
				return false;
			}			
		},Foundation.Abide.defaults.validators['check-coords'] = function($el,required,parent) {
			if ((!regExp_Coords($el.val()))) {
				$el.next('span').text('Verifique campo');
				return false;
			}			
		}
	}
	
	var cleanAddBranchForm = function(){
		$('#locationEditable').prop('checked', false);
		$('#locationEditable').trigger("change");
		$('#addNewBranchForm').foundation('resetForm');
		$("#span-coords").hide();
		$("#branchName").val("");
		$("#branchPhone").val("");
		$("#branchAddress").val("");
		$("#latBranch").val("");
		$("#longBranch").val("");
		$("#autocomplete-google").val("");
	}

	var loadTable  = function(){
	 tblBranch = $('#tblBranch').DataTable({
			"columns": [
			{ "width": "40%" },
			{ "width": "40%" },
			{ "width": "20%" },
  			],
			"autoWidth": true,
			"bPaginate": false,  /*paging disabled on false*/
			"bInfo": false,		 /*General info disabled on false*/
			"bSort": true,
			"scrollX": false, /*Enable horizontal scrolling. When a table is too wide to fit into a certain layout, pero causaba desajute en el tamaño cuando se ocultaba la tabla*/
			"bLengthChange": false,
			"bFilter": false ,  /*searchbox completly disable on false*/
			  "columnDefs": [ {
			  "targets": [2],
			  "orderable": false /*desactivar sorting para columna 5*/
			} ],
			"language": {
				"lengthMenu": "Mostrar _MENU_ Regristros por pagina",
				"zeroRecords": "No se encontraron datos",
				"info": "Mostrando _START_ hasta _END_ de _TOTAL_ Sucursales.",
				"infoEmpty": "Sin datos",
				"infoFiltered":   "(filtrados de _MAX_ Sucursales)",
				"search": "",
					"paginate": {
						"previous": "<<",
						"next": ">>",
					},
			 }, "createdRow": function ( row, data, index ) {
			},

		}); 
	}

	var countGallery = function(){
		var count = 0;
		$('#mainGallery .gallery-new').each(function(i, obj) {
			count++;
		});
		return count;
	}

	var onloadExec = function(){
		$form    = $('#addCommerce');
		loadTable();
		saveblobGallery = []; /* Imagenes a guardar */
		rowGallery = [];   /*imagenes a eliminar*/
		bindEvents();
		validation();
	}
	return {
		init:onloadExec
	}

};
$(function(){
	var cm = new cmrce();
	cm.init();
});