var brch = function (){
	var bindEvents = function(){
		$("#addNewBranch").click(function(event) {
			event.preventDefault();
			$('#addNewBranchForm').foundation('resetForm');
			$("#modalNewBranch").foundation('open');
		});
		$("#saveBranch").click(function(event) {
			event.preventDefault();
			$('#addNewBranchForm').foundation('validateForm');
		});
		$('#addNewUserForm').on("formvalid.zf.abide", function(ev,elem) {
			ev.preventDefault();
	
		});
		$("#closeModal").click(function(event) {
			event.preventDefault();
			$("#modalNewBranch").foundation('close');
		});
	}
	var loadTable  = function(){
	 tblUser = $('#tblBranch').DataTable({
			"columns": [
			{ "width": "20%" },
			{ "width": "30%" },
			{ "width": "20%" },
			{ "width": "10%" },
			{ "width": "10%" },
			{ "width": "10%" },
  			],
			"autoWidth": true,
			"bSort": true,
			"scrollX": false, /*Enable horizontal scrolling. When a table is too wide to fit into a certain layout, pero causaba desajute en el tamaño cuando se ocultaba la tabla*/
			"bLengthChange": false,
			"bFilter": true ,  /*searchbox completly disable on false*/
			  "columnDefs": [ {
			  "targets": [3],
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
	var onloadExec = function(){
		bindEvents();
		loadTable();
	}	
	return {
		init:onloadExec
	}	
}

$(function(){
	var branch = new brch();
	branch.init();
});
