var cmrce = function (){
	var bindEvents = function(){
		
		$('select[name="colorpicker-picker-longlist"]').simplecolorpicker({picker: true});

		$('#updateCommerce').click(function(event) {
			$('#addCommerce').find('span.form-error').text('Campo requerido');
		});



		$('#fileupload').change(function(e){
			e.preventDefault();
			var file = this.files[0];
		
		//var bar = new FormData($('#addCommerce')[0]);
		//var formdata = document.forms.namedItem("addCommerce"); // high importance!, here you need change "yourformname" with the name of your form
		//var form = new FormData(formdata); // high importance!
		
		 	file = $("#fileupload")[0].files[0];
		   var form = new FormData();
		   form.append('fileupload', file);
			console.log(form);
			$.ajax({
				url : HOST+'/comercio/store-commerce',
				type: "POST",
				dataType: "json", // or html if you want...
				contentType: false,
				processData: false,
				data : form,
				success: function(response){
					console.log(response);
				}
			});
		});


	$("#newCommerce").click(function(event){
		event.preventDefault();
		file = $("#fileupload")[0].files[0];
		var form = new FormData();
		form.append('fileupload', file);
		data = {
			commerce: 'hi',
			month: 'delul',
			chart: 'cdee'
		};
		form.append('data', data);

		sendData(form);
	});

	/*SUBIR IMAGEN LOGOTIPO*/

	var uploadButton = ('<p class="tagprocess"> Subiendo ... </p>');
	$('#fileupload').fileupload({
		formData:{extra:1},
		autoUpload: false,
		acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
		previewMaxWidth: 142,
		previewMaxHeight: 142,
		dropZone: $('.drop-zone-logotipo'),
		replaceFileInput:false
	}).on('fileuploadadd', function (e, data) {
		$('#files').empty();
		data.context = $('<div/>').appendTo('#files');
		$.each(data.files, function (index, file) {
			var node = $('<p/>').append(uploadButton);
					//.append($('<span/>').text(file.name));
			node.appendTo(data.context);
		});
	}).on('fileuploadprocessalways', function (e, data) {
		var index = data.index,
			file = data.files[index],
			node = $(data.context.children()[index]);
		if (file.preview) {
			node
				.prepend('<br>')
				.prepend(file.preview);
		}
		if (file.error) {
			node
				.append('<br>')
				.append($('<span class="text-danger"/>').text(file.error));
		}
		if (index + 1 === data.files.length) {
			data.context.find('p.tagprocess')
				.text('');
		}
	}).on('fileuploadprogressall', function (e, data) {
		var progress = parseInt(data.loaded / data.total * 100, 10);
		$('#progress .progress-bar').css(
			'width',
			progress + '%'
		);
	}).on('fileuploaddone', function (e, data) {
		$.each(data.result.files, function (index, file) {
			if (file.url) {
				var link = $('<a>')
					.attr('target', '_blank')
					.prop('href', file.url);
				$(data.context.children()[index])
					.wrap(link);
			} else if (file.error) {
				var error = $('<span class="text-danger"/>').text(file.error);
				$(data.context.children()[index])
					.append('<br>')
					.append(error);
			}
		});
	}).on('fileuploadfail', function (e, data) {
		$.each(data.files, function (index) {
			var error = $('<span class="text-danger"/>').text('Error al subir archivo');
			$(data.context.children()[index])
				.append('<br>')
				.append(error);
		});
	}).prop('disabled', !$.support.fileInput)
		.parent().addClass($.support.fileInput ? undefined : 'disabled');

	/*SUBIR IMAGEN PORTADA*/


	$('#portada-upload').fileupload({
		formData:{extra:1},
		autoUpload: false,
		acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
		previewMaxWidth: 142,
		previewMaxHeight: 142,
		dropZone: $('.drop-zone-portada'),
		replaceFileInput:false
	}).on('fileuploadadd', function (e, data) {
		$('#files-portada').empty();
		data.context = $('<div/>').appendTo('#files-portada');
		$.each(data.files, function (index, file) {
			var node = $('<p/>').append(uploadButton);
					//.append($('<span/>').text(file.name));
			node.appendTo(data.context);
		});
	}).on('fileuploadprocessalways', function (e, data) {
		var index = data.index,
			file = data.files[index],
			node = $(data.context.children()[index]);
		if (file.preview) {
			node
				.prepend('<br>')
				.prepend(file.preview);
		}
		if (file.error) {
			node
				.append('<br>')
				.append($('<span class="text-danger"/>').text(file.error));
		}
		if (index + 1 === data.files.length) {
			data.context.find('p.tagprocess')
				.text('');
		}
	}).on('fileuploadprogressall', function (e, data) {
		var progress = parseInt(data.loaded / data.total * 100, 10);
		$('#progress .progress-bar').css(
			'width',
			progress + '%'
		);
	}).on('fileuploaddone', function (e, data) {
		$.each(data.result.files, function (index, file) {
			if (file.url) {
				var link = $('<a>')
					.attr('target', '_blank')
					.prop('href', file.url);
				$(data.context.children()[index])
					.wrap(link);
			} else if (file.error) {
				var error = $('<span class="text-danger"/>').text(file.error);
				$(data.context.children()[index])
					.append('<br>')
					.append(error);
			}
		});
	}).on('fileuploadfail', function (e, data) {
		$.each(data.files, function (index) {
			var error = $('<span class="text-danger"/>').text('Error al subir archivo');
			$(data.context.children()[index])
				.append('<br>')
				.append(error);
		});
	}).prop('disabled', !$.support.fileInput)
		.parent().addClass($.support.fileInput ? undefined : 'disabled');



	}
	/*AJAX REQUESTS*/
	var sendData = function (form){
		$.ajax({
			type: "POST",
			dataType: "json", // or html if you want...
			contentType: false, // high importance!
			url:  HOST+'/comercio/store-commerce',
			data: form, // high importance!
			processData: false, // high importance!
		})
		.done(function(response) {
			console.log(response);
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
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
		}
	}


	/*IMAGE RESIZE AND CROP*/
	var editimage = function(){
		$('.pane img').jrac({
			'crop_width': 250,
			'crop_height': 120,
			'crop_left': 100,
			'crop_top': 100,
			'image_width': 400,
			'viewport_onload': function() {
				var $viewport = this;
				var inputs = $viewport.$container.parent('.pane').find('.coords input:text');
				var events = ['jrac_crop_x','jrac_crop_y','jrac_crop_width','jrac_crop_height','jrac_image_width','jrac_image_height'];
				for (var i = 0; i < events.length; i++) {
					var event_name = events[i];
					// Register an event with an element.
					$viewport.observator.register(event_name, inputs.eq(i));
					// Attach a handler to that event for the element.
					inputs.eq(i).bind(event_name, function(event, $viewport, value) {
						$(this).val(value);
					})
					// Attach a handler for the built-in jQuery change event, handler
					// which read user input and apply it to relevent viewport object.
					.change(event_name, function(event) {
						var event_name = event.data;
						$viewport.$image.scale_proportion_locked = $viewport.$container.parent('.pane').find('.coords input:checkbox').is(':checked');
						$viewport.observator.set_property(event_name,$(this).val());
					})
				}
			}
			})
			// React on all viewport events.
			.bind('jrac_events', function(event, $viewport) {
				var inputs = $(this).parents('.pane').find('.coords input');
				inputs.css('background-color',($viewport.observator.crop_consistent())?'chartreuse':'salmon');
		});
	}

	
	/*OTROS METODOS*/	


	var onloadExec = function(){		
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