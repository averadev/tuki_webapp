var cmrce = function (){
	var bindEvents = function(){
		$("#logo").val('');
		$("#portada").val('');
		$('select[name="colorpicker-picker-longlist"]').simplecolorpicker({picker: true});

		$form.on("formvalid.zf.abide", function(ev,elem) {
			var emptyimage = false;			
			form = {
				'name' 		  :$('#commerceName').val(),
				'description' :$('#descriptionCom').val(),
				'color' 	  :$('select[name="colorpicker-picker-longlist"]').find(':selected').data('color'),
				'logo' 		  :$("#logo").val(),
				'portada' 	  :$("#portada").val(),
				'address' 	  :$('#addressCom').val(),
				'phone' 	  :$('#phoneCom').val(),
				'website' 	  :$('#webCom').val(),
				'facebook' 	  :$('#facebook').val(),
				'twitter' 	  :$('#twitter').val(),
				'lat' 		  :$('#latCom').val(),
				'long' 		  :$('#longCom').val()
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
			if(!emptyimage){
				sendData(form);
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

		$('#saveLogo').click(function(event) {
			event.preventDefault();
			var img = document.getElementById("imglogo");
			$container =  $('#imglogo').parent('.resize-container');
			var crop_canvas,
			left = $('.overlay').offset().left - $container.offset().left,
			top =  $('.overlay').offset().top - $container.offset().top,
			width = $('.overlay').width(),
			height = $('.overlay').height();

			crop_canvas = document.createElement('canvas');
			crop_canvas.width = width;
			crop_canvas.height = height;
			
			crop_canvas.getContext('2d').drawImage(img, left+2, top+1, width, height, 0, 0, width, height);
			$("#imglogotoshow").attr("src",crop_canvas.toDataURL("image/png"));
			$("#logo").val(crop_canvas.toDataURL("image/png"));
			$('#modal-logo').foundation('close');
		});

		$('#savePortada').click(function(event) {
			event.preventDefault();
			var img = document.getElementById("imgportada");
			$container =  $('#imgportada').parent('.resize-container');
			var crop_canvas,
			left = $('.overlay.portada').offset().left - $container.offset().left,
			top =  $('.overlay.portada').offset().top - $container.offset().top,
			width = $('.overlay.portada').width(),
			height = $('.overlay.portada').height();
			crop_canvas = document.createElement('canvas');
			crop_canvas.width = width;
			crop_canvas.height = height;			
			crop_canvas.getContext('2d').drawImage(img, left+2, top+2, width, height, 0, 0, width, height);
			//window.open(crop_canvas.toDataURL("image/png"));
			$("#imgportadatoshow").attr("src",crop_canvas.toDataURL("image/png"));
			$("#portada").val(crop_canvas.toDataURL("image/png"));
			$('#modal-portada').foundation('close');
		});

		$('input[name=portada-upload]').change(function(e) {
			var file = e.target.files[0];
			//console.log(file);
			canvasResize(file, {
				width: 440,
				height: 280,
				crop: false,
				quality: 100,
				//rotate: 90,
				callback: function(data, width, height) {
					var newComponent = 	"<div class='overlay portada'><div class='overlay-inner'></div></div><img id='imgportada' src=''/>";
					$("#modal-portada .component").empty();
					$('#modal-portada .component').append(newComponent);
					$("#imgportada").attr("src", data);
					resizeableImage($('#imgportada'));	
					$('#modal-portada').foundation('open');
				}
			});
		});	
		$('input[name=logo-upload]').change(function(e) {
			var file = e.target.files[0];
			canvasResize(file, {
				width: 200,
				height: 200,
				crop: false,
				quality: 100,
				//rotate: 90,
				callback: function(data, width, height) {
					var newComponent = 	"<div class='overlay'><div class='overlay-inner'></div></div><img id='imglogo' src=''/>";
					$("#modal-logo .component").empty();
					$('#modal-logo .component').append(newComponent);
					$("#imglogo").attr("src", data);
					resizeableImage($('#imglogo'));	
					$('#modal-logo').foundation('open');
				}
			});
		});
	}
	/*AJAX REQUESTS*/
	var sendData = function (form){
		$.ajax({
			type: "POST",
			dataType: "json", 
			url:  HOST+'/comercio/store-commerce',
			data: form, 
		}).done(function(response) {
			if(!response.error){
				showPanelSuccess(response.msg);
				if($("#logo").val() !== ''){
					$("#logo_header").attr("src", $("#logo").val());
				}
				$("#logo").val('');
				$("#portada").val('');
			}else{
				showPanelAlert(response.msg);
			}
		}).fail(function() {
		});
	}

	var validation = function(){
		Foundation.Abide.defaults.patterns['dashes_only'] = /^[0-9-]*$/;

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


	/*IMAGE RESIZE AND CROP*/

	
	/*OTROS METODOS*/	


	var onloadExec = function(){
	 	$form    = $('#addCommerce');		
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