@extends('template.main')
@section('addCss')
	{{ HTML::style('vendor/plugins/data-tables/datatables.min.css') }}
	{{ HTML::style('vendor/plugins/font-awesome/css/font-awesome.css') }}	
	{{ HTML::style('vendor/plugins/messagemodal/css/jquery.modal.css') }}

<style type="text/css" media="screen">
.dataTables_filter {
     display: none;
}
.button.formbutton {
	/*padding: 7px 30px 7px 30px;*/
	font-size: 23px;
}
</style>
@stop
@section('content')
	<div style=" background-image: url('vendor/img/nube.png'); background-repeat: no-repeat; background-size: 50% 100%;  background-color: #00BFF1;  " >
		<div class="row">
			<div class="medium-11 large-11 large-centered columns" style="height: 130px; display: flex; align-items: center; padding: 0px; justify-content: center;">
				<div class="medium-4 large-4 large-centered columns ">
					<div class="row">
						<a href="{{URL::to('/')}}">
							<img class="goback-bar" src="vendor/img/volver.png" alt="logo" />
						</a>
					</div>
				</div>
				<div class="medium-8 large-8 large-centered columns">				
					<h2 class="header-perfiles not-selectable" unselectable="on">Usuarios</h2>
				</div>
			</div>	
		</div>		
	</div>
	<div class="main-div content-body" style="padding-bottom: 40px; font-family: oswaldoregular;">
		<div class="row">
			<div class=" small-12 medium-12 medium-centered large-12 large-centered columns" style="background-color: white;">
				<div class="row">
					<div class="custom-panel-heading">
						Mis usuarios
					</div>
					<div hidden="true" class="success callout" tabindex="100" data-closable>
						<p class="message-alert"></p>
						<button class="close-button" aria-label="Dismiss alert" type="button" data-close>
							<span aria-hidden="true">&times;</span>
						</button>
					</div>	
					<div style="float: left;"  class=" small-12 small-centered medium-12 medium-centered large-12 large-centered columns">					
						<div class="row margin-top-20">
							<div class="small-2 medium-2 large-1 columns left">
								<label class="text-right search">Buscar:</label>
							</div>
							<div class="small-3 medium-3 large-3columns left">
								<input class="input-form" id="searchbox" type="text" >
							</div>
							<div class="small 3 medium 3 large-3 right margin-right-15" >
								<input id="openModalNewUser" style="float: right;" type="submit" class="formbutton button"  value="Nuevo usuario">
							</div>
	 					</div>
						<table id="tblUser" class="display rewardstable" cellspacing="0" width="100%">
							<thead >
								<tr >
									<th>NOMBRE</th>
									<th>USUARIO</th>
									<th>SUCURSAL</th>
									<th>CORREO</th>
									<th>OPCIONES</th>
								</tr>
							</thead>
							<tbody>
								@foreach($users AS $user)
									<tr data-row="{{$user->userRow}}" data-branch="{{$user->branchID}}">
										<td>{{$user->nombre}}</td>
										<td>{{ ($user->roleName) ? $user->roleName : 'Administrador' }}</td>
										<td>{{ ($user->branchName) }}</td>
										<td>{{$user->email}}</td>
										<td>
											<span><a class="edtUser font-color-black"><i class="fa fa-pencil-square-o"></i></a></span>
											<span><a class="edtPass font-color-black"><i class="fa fa-key"></i></a></span>
											<span><a class="delUser font-color-black"><i class="fa fa-trash-o"></i></a></span>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div> <!-- End main div -->
	<div class="reveal" id="modalUser" data-reveal> <!-- modal add new user -->
		<div class="reveal-title">
			<h3>Nuevo usuario</h3>
		</div>
		<div class="reveal-body">
			<div class="row">
				<form data-abide novalidate id="addNewUserForm" data-row="" class="standard-form">
					<div class="row">
						<div class="small-12 medium-12 large-12 columns" style="margin-bottom:5px; ">
							<input id="adminUser" type="checkbox"><label  class="label-form" for="adminUser">Administrador</label>
							<input id="passwordgen" type="checkbox"><label  class="label-form" for="passwordgen">Generar contraseña</label>
						</div>
					</div>
					<div class="row">
						<div class="small-12 medium-6 large-6 columns">
							<label class="label-form">Nombre:
								<input maxlength="100" id="userName" required type="text" placeholder="Nombre">
								<span class="form-error" style="font-size: 20px;"> Campo requerido </span>								
							</label>
						</div>
						<div class="small-12 medium-6 large-6 columns">
							<label class="label-form">Sucursal:
								<select id="userBranch" disabled class=select-form>
									@foreach($branchs AS $branch)
									<option value="{{$branch->idBranch}}">{{$branch->name}}</option>
									@endforeach
								</select>
							</label>
						</div>
					</div>
					<div class="row">
						<div class="small-12 medium-6 large-6 columns">
							<label class="label-form">E-mail:
								<input maxlength="60" id="userEmail" required type="text" placeholder="E-mail">
								<span class="form-error" style="font-size: 20px;"> Campo requerido </span>								
							</label>
						</div>
						<div class="small-12 medium-6 large-6 columns">
							<label class="label-form">Usuario:
								<select id="userRole" disabled class=select-form>
									@foreach($roles AS $role)
									<option value="{{$role->idRole}}">{{$role->name}}</option>
									@endforeach
								</select>
								<span class="form-error" style="font-size: 20px;"> Campo requerido </span>
							</label>
						</div>
					</div>
					<div class="row">
						<div class="small-12 medium-6 large-6 columns">
							<label class="label-form">Contraseña:
								<input maxlength="60" id="userPassword" required type="password" placeholder="Contraseña">
								<span class="form-error" style="font-size: 20px;"> Campo requerido </span>								
							</label>
						</div>
						<div class="small-12 medium-6 large-6 columns">
							<label class="label-form">Confirme su contraseña:
								<input id="userConfirm"  data-equalto="userPassword" type="password" placeholder="Confirme su contraseña">
								<span class="form-error" style="font-size: 20px;">Las contraseñas deben coincidir</span>								
							</label>
						</div>
					</div>
				<span class="alert">Nota: Si selecciona generar contraseña, su usario y la contraseña generada seran enviados al correo con el que esta registrando el usuario.</span>	
				</form>
			</div>
		</div>
		<div class="reveal-footer">
			<div class="row">
				<div class="custom-panel-footer small-12 medium-12 large-12 columns">
					<input id="saveUser" style="float: right;" type="submit" class="formbutton standard button"  value="Aceptar">
					<input id="closeModal" style="float: right; margin-right: 20px;" type="button" class="cancel standard button"  value="Cancelar">
				</div>
			</div>
		</div>		
		<button class="close-button" data-close aria-label="Close modal" type="button">
			<span aria-hidden="true">&times;</span>
		</button>
	</div> <!-- End modal Add new User-->
	<div class="reveal" id="modalUpdateUser" data-reveal>  <!-- modal update user -->
		<div class="reveal-title">
			<h3>Actualiza usuario</h3>
		</div>
		<div class="reveal-body">
			<div class="row">
				<form data-abide novalidate id="updateUserForm" data-row="" class="standard-form">
					<div class="row">
						<div class="small-12 medium-12 large-12 columns" style="margin-bottom:5px; ">
							<input id="upAdminUser" type="checkbox"><label  class="label-form" for="upAdminUser">Administrador</label>
						</div>
					</div>
					<div class="row">
						<div class="small-12 medium-6 large-6 columns">
							<label class="label-form">Nombre:
								<input maxlength="45" id="upUserName" required type="text" placeholder="Nombre">
								<span class="form-error" style="font-size: 20px;"> Campo requerido </span>								
							</label>
						</div>
						<div class="small-12 medium-6 large-6 columns">
							<label class="label-form">Sucursal:
								<select required id="upUserBranch" class=select-form>
									@foreach($branchs AS $branch)
									<option value="{{$branch->idBranch}}">{{$branch->name}}</option>
									@endforeach
								</select>
							</label>
						</div>
					</div>
					<div class="row">
						<div class="small-12 medium-6 large-6 columns">
							<label class="label-form">E-mail:
								<input maxlength="45" id="upUserEmail" required type="text" placeholder="E-mail">
								<span class="form-error" style="font-size: 20px;"> Campo requerido </span>
							</label>
						</div>
						<div class="small-12 medium-6 large-6 columns">
							<label class="label-form">Usuario:
								<select required id="upUserRole" class=select-form>
									@foreach($roles AS $role)
									<option value="{{$role->idRole}}">{{$role->name}}</option>
									@endforeach
								</select>
							</label>
						</div>						
					</div>
				</form>
			</div>
		</div>
		<div class="reveal-footer">	
			<div class="row">
				<div class="custom-panel-footer small-12 medium-12 large-12 columns">
					<input id="updateUser" style="float: right;" type="submit" class="formbutton standard button"  value="Aceptar">
					<input id="dismissModal" style="float: right; margin-right: 20px;" type="button" class="cancel standard button"  value="Cancelar">
				</div>
			</div>
		</div>		
		<button class="close-button" data-close aria-label="Close modal" type="button">
			<span aria-hidden="true">&times;</span>
		</button>
	</div> <!-- End modal update User-->
	<div class="reveal" id="modalUpdatePass" data-reveal>  <!-- modal change password -->
		<div class="reveal-title">
			<h3 id="headerchangepass">Cambiar contraseña</h3>
		</div>
		<div class="reveal-body">
			<form data-abide novalidate id="changePasswordForm" data-row="" class="standard-form">
				<div class="row">
					<div class="small-12 medium-6 large-6 columns">
						<label class="label-form">Nueva contraseña:
							<input maxlength="60" id="changePassword" required type="password" placeholder="Contraseña">
							<span class="form-error" style="font-size: 20px;"> Campo requerido </span>								
						</label>
					</div>			
					<div class="small-12 medium-6 large-6 columns">
						<label class="label-form">Confirme su contraseña:
							<input id="changeConfirm" data-equalto="changePassword" type="password" placeholder="Confirme su contraseña">
							<span class="form-error" style="font-size: 20px;">Las contraseñas deben coincidir</span>								
						</label>			
					</div>
				</div>
			</form>
		</div>
		<div class="reveal-footer">
			<div class="row">
				<div class="custom-panel-footer small-12 medium-12 large-12 columns">
					<input id="updatePassword" style="float: right;" type="submit" class="formbutton standard button"  value="Aceptar">
					<input id="dismissPassword" style="float: right; margin-right: 20px;" type="button" class="cancel standard button"  value="Cancelar">
				</div>
			</div>
		</div>		
		<button class="close-button" data-close aria-label="Close modal" type="button">
			<span aria-hidden="true">&times;</span>
		</button>
	</div> <!-- End modal change password-->		
@stop
@section('addJs')
	{{HTML::script('js/users.js')}}
	{{HTML::script('/vendor/plugins/data-tables/datatables.min.js')}}
	{{HTML::script('/vendor/plugins/messagemodal/js/jquery.modal.min.js')}}
@stop
@stop