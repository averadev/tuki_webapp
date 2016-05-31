var usr = function (){
	var bindEvents = function(){
		$("#searchbox").on("keyup search input paste cut", function() {
			tblUser.search(this.value).draw();
		});
		$("#openModalNewUser").click(function(event) {
			event.preventDefault();
			$('#addNewUserForm').foundation('resetForm');
			$('#adminUser').prop('checked', true);
			$('#userBranch').prop('disabled', true);
			$('#userRole').prop('disabled', true);
			$('#passwordgen').prop('checked', false);
			$('#userPassword').prop('disabled', false);
			$('#userConfirm').prop('disabled', false);
			cleanForm();
			$('#modalUser').foundation('open');
		});
		$("#closeModal").click(function(event) {
			event.preventDefault();
			$('#modalUser').foundation('close');
		});
		$("#dismissModal").click(function(event) {
			event.preventDefault();
			$('#modalUpdateUser').foundation('close');
		});
		$("#dismissPassword").click(function(event) {
			event.preventDefault();
			$('#modalUpdatePass').foundation('close');
		});				
		$("#saveUser").click(function(event) {
			event.preventDefault();
			$('#addNewUserForm').foundation('validateForm');
		});
		$("#updateUser").click(function(event) {
			event.preventDefault();
			$('#updateUserForm').foundation('validateForm');
		});
		$("#updatePassword").click(function(event) {
			event.preventDefault();
			$('#changePasswordForm').foundation('validateForm');
		});		
		$('#addNewUserForm').on("formvalid.zf.abide", function(ev,elem) {
			ev.preventDefault();
			var form = {
				'nombre'	 : $("#userName").val(),
				'branch'	 : $("#userBranch option:selected").val(),
				'email'		 : $("#userEmail").val(),
				'password'	 : $("#userPassword").val(),
				'confirm'	 : $("#userConfirm").val(), /*password confirm*/
				'user_role'	 : $("#userRole option:selected").val(),
				'admin_user' : ($("#adminUser").is(":checked")) ? 'true' : 'false',
				'pass_gen'	 : ($("#passwordgen").is(":checked")) ? 'true' : 'false'
			};
			//console.log(form);
			sendForm(form);
		});
		$('#updateUserForm').on("formvalid.zf.abide", function(ev,elem) {
			ev.preventDefault();
			var form = {
				'nombre'	 : $("#upUserName").val(),
				'branch'	 : $("#upUserBranch option:selected").val(),
				'user_role'	 : $("#userRole option:selected").val(),
				'email'		 : $("#upUserEmail").val(),
				'dataRow'	 : $('#updateUserForm').attr('data-row'),
				'admin_user' : ($("#upAdminUser").is(":checked")) ? 'true' : 'false'
			}
			updateForm(form);
		});
		$('#changePasswordForm').on("formvalid.zf.abide", function(ev,elem) {
			ev.preventDefault();
			var form = {
				'password'	: $("#changePassword").val(),
				'confirm'	: $("#changeConfirm").val(),
				'dataRow'	: $('#changePasswordForm').attr('data-row')
			}
			changePassword(form);
		});			
		$('#tblUser').on('click', '.edtUser', function(event) {
			event.preventDefault();
			$('#modalUpdateUser').foundation('open');
			var row= $(this).closest('tr');
			var idx = tblUser.row( row ).index();
			$("#updateUserForm").attr('selected-row', idx); /*save row to change in form */
			$('#updateUserForm').attr('data-row',row.attr('data-row'));  /* save id in form*/
			var branchID = row.attr('data-branch');
			if(branchID){
				$('#upAdminUser').prop('checked', false);
				$('#upUserBranch').prop('disabled', false);
				$('#upUserRole').prop('disabled', false);
				$("#upUserBranch option:selected").val(branchID);
			}else{
				$('#upUserBranch').prop('disabled', true);
				$('#upUserRole').prop('disabled', true);
				$('#upAdminUser').prop('checked', true);
			}
			$("#upUserName").val(row.children('td').eq(0).text().trim());
			$("#upUserEmail").val(row.children('td').eq(3).text().trim());
			var branch = row.children('td').eq(2).text().trim();
			var role = row.children('td').eq(1).text().trim();
			$('#upUserRole').find('option:contains("'+role+'")').prop('selected', true);
			if(branch){
				$('#upUserBranch').find('option:contains("'+branch+'")').prop('selected', true);				
			}else{
				$("#upUserBranch").val($("#upUserBranch option:first").val());
				$("#upUserRole").val($("#upUserRole option:first").val());
			}
		});
		$('#tblUser').on('click', '.edtPass', function(event) {
			event.preventDefault();
			var row= $(this).closest('tr');
			var user = row.children('td').eq(0).text().trim();
			$('#changePasswordForm').foundation('resetForm');
			$('#headerchangepass').text("Cambiar contraseña de "+user);
			$('#modalUpdatePass').foundation('open');
			$('#changePasswordForm').attr('data-row',row.attr('data-row'));
		});
		$('#tblUser').on('click', '.delUser', function(event) {
			event.preventDefault();
			var row= $(this).closest('tr');
			var rowData = row.attr('data-row');
			var numberRow = tblUser.row( row ).index();
			var user = row.children('td').eq(0).text().trim();
			modal({
				type: 'confirm',
				title: 'Eliminar usuario',
				text: '¿Estas seguro de elimar al usuario: <b>'+user+'</b>?',
				callback: function(result) {
					if(result){
						deleteUser(rowData,numberRow);
					}
				}
			});
		});
		$('#adminUser:checkbox').change(function () {
			if($('#adminUser').is(":checked")){
				$('#userBranch').prop('disabled', true);
				$('#userRole').prop('disabled', true);
				$("#userBranch").prop('required',false);
				$("#userRole").prop('required',false);
				$('#addNewUserForm').foundation('removeErrorClasses',$('#userPassword'));
				$('#addNewUserForm').foundation('removeErrorClasses',$('#userConfirm'))				
			}else{
				$("#userBranch").prop('required',true);
				$("#userRole").prop('required',true);
				$('#userBranch').prop('disabled', false);
				$('#userRole').prop('disabled', false);
			}
		});
		$('#upAdminUser:checkbox').change(function () {
			if($('#upAdminUser').is(":checked")){
				$('#upUserBranch').prop('disabled', true);
				$('#upUserRole').prop('disabled', true);
			}else{
				$('#upUserBranch').prop('disabled', false);
				$('#upUserRole').prop('disabled', false);
			}
		});		
		$('#passwordgen:checkbox').change(function () {
			if($('#passwordgen').is(":checked")){
				$('#userPassword').prop('disabled', true);
				$('#userConfirm').prop('disabled', true);
				$("#userPassword").prop('required',false);
				$('#addNewUserForm').foundation('removeErrorClasses',$('#userPassword'));
				$('#addNewUserForm').foundation('removeErrorClasses',$('#userConfirm'));
				$("#userPassword").val('');
				$("#userConfirm").val('');
			}else{
				$('#userPassword').prop('disabled', false);
				$('#userConfirm').prop('disabled', false);
				$("#userPassword").prop('required',true);
			}
		});

	} /* END bindEvents */

	var cleanForm = function(){
		$("#userName").val('');
		$("#userBranch").val($("#userBranch option:first").val());
		$("#userEmail").val('');
		$("#userPassword").val('');
		$("#userConfirm").val('');
		$("#userBranch").prop('required',false);
		$("#userRole").prop('required',false);
		$("#userPassword").prop('required',true);
	}

	var cleanInputs = function(){
		$("#changePassword").val('');
		$("#changeConfirm").val('');
	}

	var sendForm = function(form){
		$.ajax({
			url: HOST+'/perfiles/new-user',
			type: 'POST',
			dataType: 'json',
			data: form,
		}).done(function(response) {
			if(!(response.error)){
				showSuccesMessage(response.msg);
				var options = "<span><a class='edtUser font-color-black'><i class='fa fa-pencil-square-o'></i></a></span> <span><a class='edtPass font-color-black'><i class='fa fa-key'></i></a></span> <span><a class='delUser font-color-black'><i class='fa fa-trash-o'></i></a></span>"
				rowIndex = tblUser.row.add([
						form.nombre,
						$("#userBranch option:selected").text(),
						form.email,
						options
					]).draw(false);
				var row = tblUser.row(rowIndex[0]).node();
				$(row).attr('data-row',response.dataRow);
				$('#modalUser').foundation('close');
			}else{
				showAlertMessage(response.msg);
			}
		}).fail(function(response) {
			console.log(response);
		}).always(function() {
		});
	}

	var updateForm = function(form){
		$.ajax({
			url: HOST+'/perfiles/update-user',
			type: 'PUT',
			dataType: 'json',
			data: form,
		}).done(function(response) {
			if(!(response.error)){
				showSuccesMessage(response.msg);
				var userRole = 'Administrador';
				var userBranch = '';
				var rowToUpdate = $("#updateUserForm").attr('selected-row');
				var options = "<span><a class='edtUser font-color-black'><i class='fa fa-pencil-square-o'></i></a></span> <span><a class='edtPass font-color-black'><i class='fa fa-key'></i></a></span> <span><a class='delUser font-color-black'><i class='fa fa-trash-o'></i></a></span>";
				if(form.admin_user == 'false'){
					var userRole = $("#upUserRole option:selected").text();
					var userBranch = $("#upUserBranch option:selected").text();
				}
				$('#tblUser').dataTable().fnUpdate([
						form.nombre,
						userRole,
						userBranch,
						form.email,
						options					
				], rowToUpdate );
			}else{
				showAlertMessage(response.msg);
			}
		}).fail(function(response) {
			console.log(response);
		}).always(function() {
			$('#modalUpdateUser').foundation('close');
		});		
	}

	var deleteUser = function(dataId,nuberRow){
		$.ajax({
			url: HOST+'/perfiles/drop-user',
			type: 'DELETE',
			dataType: 'json',
			data: {daraRow: dataId},
		}).done(function(response) {
			if(!(response.error)){
				showSuccesMessage(response.msg);
				tblUser.row(nuberRow).remove().draw();
			}else{
				showAlertMessage(response.msg);
			}
		}).fail(function(response) {
			console.log(response);
		});
	}

	var changePassword = function(form){
		$.ajax({
			url: HOST+'/perfiles/update-pass',
			type: 'PUT',
			dataType: 'json',
			data: form,
		}).done(function(response) {
			if(!(response.error)){
				showPanelSuccess(response.msg);
			}else{
				showPanelAlert(response.msg);
			}
		}).fail(function(response) {
			console.log(response);
		}).always(function() {
			$('#modalUpdatePass').foundation('close');
		});
		
	}

	var loadTable  = function(){
	 tblUser = $('#tblUser').DataTable({
			"columns": [
			{ "width": "23%" },
			{ "width": "23%" },
			{ "width": "22%" },
			{ "width": "22%" },
			{ "width": "10%" },
  			],
			"autoWidth": true,
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
				"info": "Mostrando _START_ hasta _END_ de _TOTAL_ Usuarios.",
				"infoEmpty": "Sin datos",
				"infoFiltered":   "(filtrados de _MAX_ Usuarios)",
				"search": "",
					"paginate": {
						"previous": "<<",
						"next": ">>",
					},
			 }, "createdRow": function ( row, data, index ) {
			},

		}); 
	}

	var onloadExec = function(){
		bindEvents();
		loadTable();
	}	
	return {
		init:onloadExec
	}	

};
$(function(){
	var user = new usr();
	user.init();
});
