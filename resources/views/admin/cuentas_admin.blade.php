@extends('admin.templates.base_admin')
@section('extra_css')
	<link rel="stylesheet" type="text/css" href="{{asset('css/admin/style_cuentas.css')}}">
@stop

@section('titulo')
	CUENTAS
@stop

@section('home_url')
{{route('admin.courses.index')}}
@stop

@section('logout_url')
{{route('admin.auth.logout')}}
@stop

@section('contenido')

<!-- ********  BARRA SUPERIOR PARA SELECCION Y CREACION  **********-->
<div class="row select_account py-3">
	<div class="col-sm-6 col-md-3 align-self-center">
		<select onchange="account_selection(this)" id="true_select_account">
			<option>Selecciona el tipo de cuenta</option>
			<option value="estudiante">Estudiante</option>
			<option value="docente">Docente</option>
			<option value="empresa">Empresa</option>
			<option value="coordinador_empresa">Coordinador de Empresa</option>
			@if(auth()->guard('admin')->user()->role_id == ROLE_ADMIN)
			<option value="coordinador_concepta">Coordinador de CONCEPTA</option>
			@endif
		</select>	
	</div>
	<div class="col-sm-6 col-md-3 align-self-center">
		<a href="#">
			<div class="container-fluid add_cuenta">
				<div class="row">
					<div class="col-sm-12 col-md-12 text_crear_cuenta" data-target="#popup_add_account" data-toggle="modal">
						<button class="btn btn-secondary btnCrearCuentas" disabled="disabled"><span class="fas fa-plus-circle"></span> Crear una nueva cuenta</button>
					</div>
				</div>
			</div>
		</a>
	</div>
	<div class="col-md-6 align-self-center">
		<div class="alert alert-warning text-center font-weight-bold mensaje_de_alerta d-none" role="alert">
		  ¡¡¡ Apenas se cree una nueva 'EMPRESA', se debe crear un coordinador de esa empresa para evitar errores futuros !!!
		</div>
		<div class="alert alert-success text-center font-weight-bold anuncio_de_importancia d-none" role="alert">
		  ¡¡¡ Rercuede que cada 'EMPRESA' debe estar asignada a un coordinador para evitar errores futuros !!!
		</div>
	</div>
</div>


<!-- ********  CONTAINER DE TODAS LAS CUENTAS  **********-->
<div class="container-fluid container_cuentas" style="max-height: 400px; display: none;" id="cuentas_estudiantes">
	<div class="row accounts">
		@foreach($students as $student)
		<!-- ********  Inicio de Cuenta 1   **********-->
		<div class="col-sm-6 col-md-2 justify-content-center col-cuenta">
			<div class="box_cuenta" data-id="{{$student->id}}">
				<div class="box_cuenta_top">
					<img src="{{asset($student->photo)}}" class="photo_cuenta mt-1 img-fluid" alt="image not available" onerror="this.onerror=null;this.src='/images/default/user.png';">
				</div>
				<div class="box_cuenta_bottom mt-2">
					<p class="mb-0">{{$student->full_name}}<br>
						DNI: {{$student->dni}}
					</p>
				</div>
			</div>
			
		</div>
		<!-- ********  Fin de Cuenta 1  **********-->
		@endforeach
	</div>
</div>

<div class="container-fluid container_cuentas" style="max-height: 400px; display: none;" id="cuentas_docentes">
	<div class="row accounts">
		@foreach($teachers as $teacher)
		<!-- ********  Inicio de Cuenta 1   **********-->
		<div class="col-sm-6 col-md-2 justify-content-center col-cuenta">
			<div class="box_cuenta" data-id="{{$teacher->id}}">
				<div class="box_cuenta_top">
					<img src="{{asset($teacher->photo)}}" class="photo_cuenta mt-1 img-fluid" alt="image not available" onerror="this.onerror=null;this.src='/images/default/user.png';">
				</div>
				<div class="box_cuenta_bottom mt-2">
					<p>{{$teacher->full_name}}<br>
						DNI: {{$teacher->dni}}
					</p>
				</div>
			</div>
			
		</div>
		<!-- ********  Fin de Cuenta 1  **********-->
		@endforeach
	</div>
</div>

<div class="container-fluid container_cuentas" style="max-height: 340px; display: none;" id="cuentas_empresas">
	<div class="row accounts">
		@foreach($businesses as $business)
		<!-- ********  Inicio de Cuenta 1   **********-->
		<div class="col-sm-6 col-md-2 justify-content-center col-cuenta">
			<div class="box_cuenta" data-id="{{$business->id}}">
				<div class="box_cuenta_top">
					<img src="{{asset($business->logo)}}" class="photo_cuenta mt-1 img-fluid" alt="image not available" onerror="this.onerror=null;this.src='/images/default/user.png';">
				</div>
				<div class="box_cuenta_bottom mt-2">
					<p>{{$business->social_reason}}<br>
						RUC: {{$business->ruc}}
					</p>
				</div>
			</div>
			
		</div>
		<!-- ********  Fin de Cuenta 1  **********-->
		@endforeach
	</div>
</div>

<div class="container-fluid container_cuentas" style="max-height: 340px; display: none;" id="cuentas_coordinador_empresa">
	<div class="row accounts">
		@foreach($companies as $company)
		<!-- ********  Inicio de Cuenta 1   **********-->
		<div class="col-sm-6 col-md-2 justify-content-center col-cuenta">
			<div class="box_cuenta" data-id="{{$company->id}}">
				<div class="box_cuenta_top">
					<img src="{{asset($company->photo)}}" class="photo_cuenta mt-1 img-fluid" alt="image not available" onerror="this.onerror=null;this.src='/images/default/user.png';">
				</div>
				<div class="box_cuenta_bottom mt-2">
					<p>{{$company->full_name}}<br>
						DNI: {{$company->dni}}
					</p>
				</div>
			</div>
			
		</div>
		<!-- ********  Fin de Cuenta 1  **********-->
		@endforeach
	</div>
</div>
@if(auth()->guard('admin')->user()->role_id == ROLE_ADMIN)
<div class="container-fluid container_cuentas" style="max-height: 400px; display: none;" id="cuentas_coordinador_concepta">
	<div class="row accounts">
		@foreach($admins as $admin)
		<!-- ********  Inicio de Cuenta 1   **********-->
		<div class="col-sm-6 col-md-2 justify-content-center col-cuenta">
			<div class="box_cuenta" data-id="{{$admin->id}}">
				<div class="box_cuenta_top">
					<img src="{{asset($admin->photo)}}" class="photo_cuenta mt-1 img-fluid" alt="image not available" onerror="this.onerror=null;this.src='/images/default/user.png';">
				</div>
				<div class="box_cuenta_bottom mt-2">
					<p>{{$admin->full_name}}<br>
						DNI: {{$admin->dni}}
					</p>
				</div>
			</div>
			
		</div>
		<!-- ********  Fin de Cuenta 1  **********-->
		@endforeach
	</div>
</div>
@endif

<!-- *********************** INICIO POP-UP AGREGAR ALUMNO ************************* -->
<div class="modal fade" id="popup_add_account" tabindex="-1" role="dialog" aria-labelledby="popup_accountLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="height: 450px">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar Cuenta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body body_add_account" style="overflow-y: auto;">
      	<div class="container_agregar_account">
	      	<form id="form_create_student" role="form" enctype="multipart/form-data" method="post" action="{{route('admin.students.create')}}">
	      		{!! csrf_field() !!}
	      		<div class="row new_alumno">
		      		<div class="col-sm-6 col-md-5 photo_new_alumno">
		      			<div class="circle_photo img_estudiante" id="preview-upload-photo" style="width: 200px;height: 200px;margin-left: auto;margin-right: auto;">
		      				<!-- SE TIENE QUE ACTIVAR PARA QUE LA FOTO SE PUEDA VER UNA VEZ ESTA HAYA SIDO SELECCIONADA -->
		      			</div>
		      			<input type="hidden" name="student_imagen_ahora" class="student_imagen_bd" value="">
		      			<input type="file" class="ml-4 mt-4" id="file_new_account" name="image">
		      			<br>
		      		</div>
	      			<br>
	      			<!--****************  Inicio de cuenta de estudiante  *****************-->
		      		<div class="col-sm-6 col-md-7 info_new_account" id="account_estudiante">
		      			<input type="hidden" id="upload_file" name="upload_file">
					    DNI: <input type="text" name="dni" id="dni_estudiante"><hr>
				      	NOMBRE(S): <input type="text" name="name" id="name_estudiante"><hr>
				      	APELLIDO(S): <input type="text" name="last_name" id="last_name_estudiante"><hr>
				      	TELÉFONO: <input type="text" name="phone" id="phone_estudiante"><hr>
				      	EMPRESA: <select name="company_id" id="company_estudiante">
				      		<option value="" selected disabled>Seleccione una empresa</option>
				      		@foreach($businesses as $business)
					      		@if($business->company)
					      		<option value="{{$business->company->id}}">{{$business->social_reason}}</option>
					      		@endif
				      		@endforeach
				      	</select><hr>
				      	E-MAIL EMPRESARIAL: <input type="text" name="email" id="email_estudiante"><hr>
				      	E-MAIL PERSONAL: <input type="text" name="personal_email" id="personal_email_estudiante"><hr>
				      	<input type="hidden" name="type" >
				      	<input type="hidden" name="id" >

		      		</div>
		      		<!--****************  Fin de cuenta de estudiante  *****************-->
	      		</div>
	      	</form>
	      	<form id="form_create_teacher" role="form" enctype="multipart/form-data" method="post" action="{{route('admin.teachers.create')}}">
	      		{!! csrf_field() !!}
	      		<div class="row new_alumno">
		      		<div class="col-sm-6 col-md-5 photo_new_alumno">
		      			<div class="circle_photo img_docente" id="preview-upload-photo" style="width: 200px;height: 200px;margin-left: auto;margin-right: auto;">
		      				<!-- SE TIENE QUE ACTIVAR PARA QUE LA FOTO SE PUEDA VER UNA VEZ ESTA HAYA SIDO SELECCIONADA -->
		      			</div>
		      			<input type="hidden" name="docente_imagen_ahora" class="docente_imagen_bd" value="">
		      			<input type="file" class="ml-4 mt-4" id="file_new_account" name="image">
		      			<br>
		      		</div>
	      			<br>
	      			<!--****************  Inicio de cuenta de estudiante  *****************-->
                    <div class="col-sm-6 col-md-7 info_new_account" id="account_docente">
                        DNI: <input type="text" name="dni" id="dni_docente"><hr>
                        NOMBRE(S): <input type="text" name="name" id="name_docente"><hr>
                        APELLIDO(S): <input type="text" name="last_name" id="last_name_docente"><hr>
                        TELÉFONO: <input type="text" name="phone" id="phone_docente"><hr>
                        EMPRESA: <input type="text" name="company" id="company_docente"><hr>
                        E-MAIL EMPRESARIAL: <input type="text" name="email" id="email_docente"><hr>
                        E-MAIL PERSONAL: <input type="text" name="personal_email" id="personal_email_docente"><hr>
                        RESUMEN DE CV: <input type="text" name="description" id="description_docente" class="w-100">
                        <input type="hidden" name="type" >
				      	<input type="hidden" name="id" >
                    </div>
		      		<!--****************  Fin de cuenta de estudiante  *****************-->
	      		</div>
	      	</form>
	      	<form id="form_create_business" role="form" enctype="multipart/form-data" method="post" action="{{route('admin.businesses.create')}}">
	      		{!! csrf_field() !!}
	      		<div class="row new_alumno">
		      		<div class="col-sm-6 col-md-5 photo_new_alumno">
		      			<div class="circle_photo img_empresa" id="preview-upload-photo" style="width: 200px;height: 200px;margin-left: auto; margin-right: auto;">
		      				<!-- SE TIENE QUE ACTIVAR PARA QUE LA FOTO SE PUEDA VER UNA VEZ ESTA HAYA SIDO SELECCIONADA -->
		      			</div>
		      			<input type="hidden" name="empresa_imagen_ahora" class="empresa_imagen_bd" value="">
		      			<input type="file" class="ml-4 mt-4" id="file_new_account" name="image">
		      			<br>
		      		</div>
	      			<br>
	      			<!--****************  Inicio de cuenta de estudiante  *****************-->
                    <div class="col-sm-6 col-md-7 info_new_account" id="account_docente">
                        RUC: <input type="text" name="ruc" id="ruc_empresa"><hr>
                        RAZON SOCIAL: <input type="text" name="social_reason" id="social_reason_empresa"><hr>
                        DIRECCIÓN: <input type="text" name="address" id="address_empresa"><hr>
                        TELÉFONO: <input type="text" name="phone" id="phone_empresa"><hr>
                        E-MAIL: <input type="text" name="email" id="email_empresa"><hr>
                        CONTACTO: <input type="text" name="contact_name" id="contact_name_empresa"><hr>
                        E-MAIL (CONTACTO): <input type="text" name="contact_email" id="contact_email_empresa"><hr>
                        <input type="hidden" name="type" >
				      	<input type="hidden" name="id" >
                    </div>
		      		<!--****************  Fin de cuenta de estudiante  *****************-->
	      		</div>
	      	</form>
	      	<form id="form_create_company" role="form" enctype="multipart/form-data" method="post" action="{{route('admin.companies.create')}}">
	      		{!! csrf_field() !!}
	      		<div class="row new_alumno">
		      		<div class="col-sm-6 col-md-5 photo_new_alumno">
		      			<div class="circle_photo img_coordinador" id="preview-upload-photo" style="width: 200px;height: 200px;margin-left: auto;margin-right: auto;">
		      				<!-- SE TIENE QUE ACTIVAR PARA QUE LA FOTO SE PUEDA VER UNA VEZ ESTA HAYA SIDO SELECCIONADA -->
		      			</div>
		      			<input type="hidden" name="coord_empresa_imagen_ahora" class="coord_empresa_imagen_bd" value="">
		      			<input type="file" class="ml-4 mt-4" id="file_new_account" name="image">
		      			<br>
		      		</div>
	      			<br>
	      			<!--****************  Inicio de cuenta de estudiante  *****************-->
                    <div class="col-sm-6 col-md-7 info_new_account" id="account_coordinador_empresa">
                        DNI: <input type="text" name="dni" id="dni_coordinador"><hr>
                        NOMBRE(S): <input type="text" name="name" id="name_coordinador"><hr>
                        APELLIDO(S): <input type="text" name="last_name" id="last_name_coordinador"><hr>
                        TELÉFONO: <input type="text" name="contact_phone" id="contact_phone_coordinador"><hr>
                        EMPRESA: 
                            <select name="business_id" id="business_id_coordinador">
                                <option selected="true" disabled="disabled">Selecciona la empresa</option>
                                @foreach($businesses as $business)
                                	<option value="{{$business->id}}">{{$business->social_reason}}</option>
                                @endforeach
                            </select><hr>
                        E-MAIL EMPRESARIAL: <input type="text" name="email" id="email_coordinador"><hr>
                        E-MAIL PERSONAL: <input type="text" name="personal_email" id="personal_email_coordinador"><hr>
                        <input type="hidden" name="type" >
				      	<input type="hidden" name="id" >
                    </div>
		      		<!--****************  Fin de cuenta de estudiante  *****************-->
	      		</div>
	      	</form>
	      	@if(auth()->guard('admin')->user()->role_id == ROLE_ADMIN)
	      	<form id="form_create_admin" role="form" enctype="multipart/form-data" method="post" action="{{route('admin.admins.create')}}">
	      		{!! csrf_field() !!}
	      		<div class="row new_alumno">
		      		<div class="col-sm-6 col-md-5 photo_new_alumno">
		      			<div class="circle_photo img_coordinador_concepta" id="preview-upload-photo" style="width: 200px;height: 200px;margin-left: auto;margin-right: auto;">
		      				<!-- SE TIENE QUE ACTIVAR PARA QUE LA FOTO SE PUEDA VER UNA VEZ ESTA HAYA SIDO SELECCIONADA -->
		      			</div>
		      			<input type="hidden" name="admin_imagen_ahora" class="admin_imagen_bd" value="">
		      			<input type="file" class="ml-4 mt-4" id="file_new_account" name="image">
		      			<br>
		      		</div>
	      			<br>
	      			<!--****************  Inicio de cuenta de estudiante  *****************-->
                    <div class="col-sm-6 col-md-7 info_new_account" id="account_coordinador_concepta">
                        DNI: <input type="text" name="dni" id="dni_coordinador_concepta"><hr>
                        NOMBRE(S): <input type="text" name="name" id="name_coordinador_concepta"><hr>
                        APELLIDO(S): <input type="text" name="last_name" id="last_name_coordinador_concepta"><hr>
                        TELÉFONO: <input type="text" name="phone" id="phone_coordinador_concepta"><hr>
                        E-MAIL EMPRESARIAL: <input type="text" name="email" id="email_coordinador_concepta"><hr>
                        E-MAIL PERSONAL: <input type="text" name="personal_email" id="personal_email_coordinador_concepta"><hr>
                        <span class="w-100">¿Desea darle permisos para crear y editar roles administrativos? :</span>
                        <select name="role_id" id="role_id">
                        	<option selected disabled hidden="">Escoga una opción</option>
                        	<option value="1">Sí, darle permisos</option>
                        	<option value="2">No, no darle permisos</option>
                        </select><hr>
                        <input type="hidden" name="type" >
				      	<input type="hidden" name="id" >
                    </div>
		      		<!--****************  Fin de cuenta de estudiante  *****************-->
	      		</div>
	      	</form>
	      	@endif
	    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="save" disabled>Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- *********************** FIN DE POP-UP AGREGAR ALUMNO ************************* -->

<!-- *********************** INICIO POP-UP EDITAR ALUMNO ************************* -->
<div class="modal fade" id="popup_edit_account" tabindex="-1" role="dialog" aria-labelledby="popup_accountLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="height: 450px">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Cuenta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body body_add_account" style="overflow-y: auto;">
      	<div class="container_agregar_account">
	      	<form id="form_edit_student" role="form" enctype="multipart/form-data" method="post" action="{{route('admin.students.create')}}">
	      		{!! csrf_field() !!}
	      		<div class="row new_alumno">
		      		<div class="col-sm-6 col-md-5 photo_new_alumno">
		      			<div class="circle_photo">
		      				<!-- SE TIENE QUE ACTIVAR PARA QUE LA FOTO SE PUEDA VER UNA VEZ ESTA HAYA SIDO SELECCIONADA -->
		      			</div>
		      			<input type="hidden" class="student_imagen_bd" value="">
		      			<input type="file" class="ml-4 mt-4" id="file_new_account" name="image">
		      			<br>
		      		</div>
	      			<br>
	      			<!--****************  Inicio de cuenta de estudiante  *****************-->
		      		<div class="col-sm-6 col-md-7 info_new_account" id="account_estudiante">
					    DNI: <input type="text" name="dni"><hr>
				      	NOMBRE(S): <input type="text" name="name"><hr>
				      	APELLIDO(S): <input type="text" name="last_name"><hr>
				      	TELÉFONO: <input type="text" name="phone"><hr>
				      	EMPRESA: <select name="company_id">
				      		@foreach($businesses as $business)
					      		@if($business->company)
					      		<option value="{{$business->company->id}}">{{$business->social_reason}}</option>
					      		@endif
				      		@endforeach
				      	</select><hr>
				      	E-MAIL EMPRESARIAL: <input type="text" name="email"><hr>
				      	E-MAIL PERSONAL: <input type="text" name="personal_email"><hr>
		      		</div>
		      		<!--****************  Fin de cuenta de estudiante  *****************-->
	      		</div>
	      	</form>
	      	<form id="form_edit_teacher" role="form" enctype="multipart/form-data" method="post" action="{{route('admin.teachers.create')}}">
	      		{!! csrf_field() !!}
	      		<div class="row new_alumno">
		      		<div class="col-sm-6 col-md-5 photo_new_alumno">
		      			<div class="circle_photo">
		      				<!-- SE TIENE QUE ACTIVAR PARA QUE LA FOTO SE PUEDA VER UNA VEZ ESTA HAYA SIDO SELECCIONADA -->
		      			</div>
		      			<input type="hidden" class="docente_imagen_bd" value="">
		      			<input type="file" class="ml-4 mt-4" id="file_new_account" name="profile_image">
		      			<br>
		      		</div>
	      			<br>
	      			<!--****************  Inicio de cuenta de estudiante  *****************-->
                    <div class="col-sm-6 col-md-7 info_new_account" id="account_docente">
                        DNI: <input type="text" name="dni"><hr>
                        NOMBRE(S): <input type="text" name="name"><hr>
                        APELLIDO(S): <input type="text" name="last_name"><hr>
                        TELÉFONO: <input type="text" name="phone"><hr>
                        EMPRESA: <input type="text" name="company"><hr>
                        E-MAIL EMPRESARIAL: <input type="text" name="email"><hr>
                        E-MAIL PERSONAL: <input type="text" name="personal_email"><hr>
                    </div>
		      		<!--****************  Fin de cuenta de estudiante  *****************-->
	      		</div>
	      	</form>
	      	<form id="form_edit_business" role="form" enctype="multipart/form-data" method="post" action="{{route('admin.businesses.create')}}">
	      		{!! csrf_field() !!}
	      		<div class="row new_alumno">
		      		<div class="col-sm-6 col-md-5 photo_new_alumno">
		      			<div class="circle_photo">
		      				<!-- SE TIENE QUE ACTIVAR PARA QUE LA FOTO SE PUEDA VER UNA VEZ ESTA HAYA SIDO SELECCIONADA -->
		      			</div>
		      			<input type="hidden" class="empresa_imagen_bd" value="">
		      			<input type="file" class="ml-4 mt-4" id="file_new_account" name="logo">
		      			<br>
		      		</div>
	      			<br>
	      			<!--****************  Inicio de cuenta de estudiante  *****************-->
                    <div class="col-sm-6 col-md-7 info_new_account" id="account_docente">
                        RUC: <input type="text" name="ruc"><hr>
                        RAZON SOCIAL: <input type="text" name="social_reason"><hr>
                        DIRECCIÓN: <input type="text" name="address"><hr>
                        TELÉFONO: <input type="text" name="phone"><hr>
                        E-MAIL: <input type="text" name="email"><hr>
                        CONTACTO: <input type="text" name="contact_name"><hr>
                        E-MAIL (CONTACTO): <input type="text" name="contact_email"><hr>
                    </div>
		      		<!--****************  Fin de cuenta de estudiante  *****************-->
	      		</div>
	      	</form>
	      	<form id="form_edit_company" role="form" enctype="multipart/form-data" method="post" action="{{route('admin.companies.create')}}">
	      		{!! csrf_field() !!}
	      		<div class="row new_alumno">
		      		<div class="col-sm-6 col-md-5 photo_new_alumno">
		      			<div class="circle_photo">
		      				<!-- SE TIENE QUE ACTIVAR PARA QUE LA FOTO SE PUEDA VER UNA VEZ ESTA HAYA SIDO SELECCIONADA -->
		      			</div>
		      			<input type="hidden" class="coord_empresa_imagen_bd" value="">
		      			<input type="file" class="ml-4 mt-4" id="file_new_account" name="photo">
		      			<br>
		      		</div>
	      			<br>
	      			<!--****************  Inicio de cuenta de estudiante  *****************-->
                    <div class="col-sm-6 col-md-7 info_new_account" id="account_coordinador_empresa">
                        DNI: <input type="text" name="dni"><hr>
                        NOMBRE(S): <input type="text" name="name"><hr>
                        APELLIDO(S): <input type="text" name="last_name"><hr>
                        TELÉFONO: <input type="text" name="contact_phone"><hr>
                        EMPRESA: 
                            <select name="business_id">
                                <option selected="true" disabled="disabled">Selecciona la empresa</option>
                                @foreach($businesses as $business)
                                	<option value="{{$business->id}}">{{$business->social_reason}}</option>
                                @endforeach
                            </select><hr>
                        E-MAIL EMPRESARIAL: <input type="text" name="email"><hr>
                        E-MAIL PERSONAL: <input type="text" name="personal_email"><hr>
                    </div>
		      		<!--****************  Fin de cuenta de estudiante  *****************-->
	      		</div>
	      	</form>
	      	@if(auth()->guard('admin')->user()->role_id == ROLE_ADMIN)
	      	<form id="form_edit_admin" role="form" enctype="multipart/form-data" method="post" action="{{route('admin.admins.create')}}">
	      		{!! csrf_field() !!}
	      		<div class="row new_alumno">
		      		<div class="col-sm-6 col-md-5 photo_new_alumno">
		      			<div class="circle_photo">
		      				<!-- SE TIENE QUE ACTIVAR PARA QUE LA FOTO SE PUEDA VER UNA VEZ ESTA HAYA SIDO SELECCIONADA -->
		      			</div>
		      			<input type="hidden" class="admin_imagen_bd" value="">
		      			<input type="file" class="ml-4 mt-4" id="file_new_account" name="photo">
		      			<br>
		      		</div>
	      			<br>
	      			<!--****************  Inicio de cuenta de estudiante  *****************-->
                    <div class="col-sm-6 col-md-7 info_new_account" id="account_coordinador_concepta">
                        DNI: <input type="text" name="dni"><hr>
                        NOMBRE(S): <input type="text" name="name"><hr>
                        APELLIDO(S): <input type="text" name="last_name"><hr>
                        TELÉFONO: <input type="text" name="phone"><hr>
                        E-MAIL EMPRESARIAL: <input type="text" name="email"><hr>
                        E-MAIL PERSONAL: <input type="text" name="personal_email"><hr>
                        <select name="role_id" id="role_id">
                        	<option selected disabled hidden="">Escoga una opción</option>
                        	<option value="1">Sí, darle permisos</option>
                        	<option value="2">No, no darle permisos</option>
                        </select><hr>
                    </div>
		      		<!--****************  Fin de cuenta de estudiante  *****************-->
	      		</div>
	      	</form>
	      	@endif
	    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="save" disabled>Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- *********************** FIN DE POP-UP AGREGAR ALUMNO ************************* -->



@stop

@section('extra_scripts')
	<script type="text/javascript">

		var button_save_disabled = true;
		var calling_show = false;

		$('.container_agregar_account').find('form').hide();
		$('.button_cuenta').click(function(){
			$(this).parents('.card-header').removeAttr('data-toggle');
			location.href="{{env('APP_URL')}}" + "admin/cuentas/" + $(this).data('id') + "/edit";
		});

		$(".btnCrearCuentas").click(function(){

			var elementoSeleccionado = $("#true_select_account").val();

			if(elementoSeleccionado == "estudiante"){

				$(".img_estudiante").css({'background-image':'url("null")'});
				$("#dni_estudiante").val("");
				$("#name_estudiante").val("");
				$("#last_name_estudiante").val("");
				$("#phone_estudiante").val("");
				//$("#company_estudiante").select(option[0]);
				$("#email_estudiante").val("");
				$("#personal_email_estudiante").val("");
				//alert(elementoSeleccionado);

			}else if(elementoSeleccionado == "docente"){

				$(".img_docente").css({'background-image':'url("null")'});
				$("#dni_docente").val("");
				$("#name_docente").val("");
				$("#last_name_docente").val("");
				$("#phone_docente").val("");
				$("#company_docente").val("");
				$("#email_docente").val("");
				$("#description_docente").val("");
				$("#personal_email_docente").val("");

			}else if(elementoSeleccionado == "empresa"){

				$(".img_empresa").css({'background-image':'url("null")'});
				$("#ruc_empresa").val("");
				$("#social_reason_empresa").val("");
				$("#address_empresa").val("");
				$("#phone_empresa").val("");
				$("#email_empresa").val("");
				$("#contact_name_empresa").val("");
				$("#contact_email_empresa").val("");

			}else if(elementoSeleccionado == "coordinador_empresa"){

				$(".img_coordinador").css({'background-image':'url("null")'});
				$("#dni_coordinador").val("");
				$("#name_coordinador").val("");
				$("#last_name_coordinador").val("");
				$("#contact_phone_coordinador").val("");
				//$("business_id_coordinador").select();
				$("#email_coordinador").val("");
				$("#personal_email_coordinador").val("");

			}else{

				$(".img_coordinador_concepta").css({'background-image':'url("null")'});
				$("#dni_coordinador_concepta").val("");
				$("#name_coordinador_concepta").val("");
				$("#last_name_coordinador_concepta").val("");
				$("#phone_coordinador_concepta").val("");
				$("#email_coordinador_concepta").val("");
				$("#personal_email_coordinador_concepta").val("");

			}
						

		});

		function account_selection(that) {
			button_save_disabled = false;
			$('.text_crear_cuenta').children('button').removeAttr('disabled');
			$('.container_agregar_account').find('form').hide();

	        if (that.value == "estudiante") {
	        	$('#form_create_student').show();
	            document.getElementById("cuentas_estudiantes").style.display = "block";
	            document.getElementById("cuentas_docentes").style.display = "none";
	            document.getElementById("cuentas_empresas").style.display = "none";
	            document.getElementById("cuentas_coordinador_empresa").style.display = "none";
	            document.getElementById("cuentas_coordinador_concepta").style.display = "none";
	            $(".mensaje_de_alerta").removeClass("d-inline-block");
	            $(".mensaje_de_alerta").addClass("d-none");
	        
	            $(".anuncio_de_importancia").removeClass("d-inline-block");
	            $(".anuncio_de_importancia").addClass("d-none");
	        } else if (that.value == "docente"){
	        	$('#form_create_teacher').show();
	        	document.getElementById("cuentas_docentes").style.display = "block";
	        	document.getElementById("cuentas_estudiantes").style.display = "none";
	            document.getElementById("cuentas_empresas").style.display = "none";
	            document.getElementById("cuentas_coordinador_empresa").style.display = "none";
	            document.getElementById("cuentas_coordinador_concepta").style.display = "none";
	            $(".mensaje_de_alerta").removeClass("d-inline-block");
	            $(".mensaje_de_alerta").addClass("d-none");

	            $(".anuncio_de_importancia").removeClass("d-inline-block");
	            $(".anuncio_de_importancia").addClass("d-none");
	        } else if (that.value == "empresa"){
	        	$('#form_create_business').show();
	        	document.getElementById("cuentas_empresas").style.display = "block";
	        	document.getElementById("cuentas_estudiantes").style.display = "none";
	            document.getElementById("cuentas_docentes").style.display = "none";
	            document.getElementById("cuentas_coordinador_empresa").style.display = "none";
	            document.getElementById("cuentas_coordinador_concepta").style.display = "none";
	            $(".mensaje_de_alerta").removeClass("d-none");
	            $(".mensaje_de_alerta").addClass("d-inline-block");
	            $(".anuncio_de_importancia").removeClass("d-inline-block");
	            $(".anuncio_de_importancia").addClass("d-none");
	        } else if (that.value == "coordinador_empresa"){
	        	$('#form_create_company').show();
	        	document.getElementById("cuentas_coordinador_empresa").style.display = "block";
	        	document.getElementById("cuentas_estudiantes").style.display = "none";
	            document.getElementById("cuentas_docentes").style.display = "none";
	            document.getElementById("cuentas_empresas").style.display = "none";
	            document.getElementById("cuentas_coordinador_concepta").style.display = "none";
	            $(".mensaje_de_alerta").removeClass("d-inline-block");
	            $(".mensaje_de_alerta").addClass("d-none");
	            $(".anuncio_de_importancia").removeClass("d-none");
	            $(".anuncio_de_importancia").addClass("d-inline-block");
	        } else if (that.value == "coordinador_concepta"){
	        	$('#form_create_admin').show();
	        	document.getElementById("cuentas_coordinador_concepta").style.display = "block";
	        	document.getElementById("cuentas_estudiantes").style.display = "none";
	            document.getElementById("cuentas_docentes").style.display = "none";
	            document.getElementById("cuentas_empresas").style.display = "none";
	            document.getElementById("cuentas_coordinador_empresa").style.display = "none";
	            $(".mensaje_de_alerta").removeClass("d-inline-block");
	            $(".mensaje_de_alerta").addClass("d-none");
	            $(".anuncio_de_importancia").removeClass("d-inline-block");
	            $(".anuncio_de_importancia").addClass("d-none");
	        }
	    }
	    
	    $('#save').click(function(){

	    	var elementoSelect = $('#true_select_account').val()

	    	switch(elementoSelect){
	    		case 'estudiante':{
	    			if ($('#popup_add_account').attr('data-mode')=='UPDATE') {
	    				$('#form_create_student').attr('action',"{{route('admin.accounts.edit')}}")
	    			};

	    			$('#form_create_student').submit();
	    			document.getElementById("cuentas_estudiantes").style.display = "block";
	    			document.getElementById("cuentas_docentes").style.display = "none";
	            	document.getElementById("cuentas_empresas").style.display = "none";
	            	document.getElementById("cuentas_coordinador_empresa").style.display = "none";
	            	document.getElementById("cuentas_coordinador_concepta").style.display = "none";
	    			break;
	    		}
	    		case 'docente':{
	    			if ($('#popup_add_account').attr('data-mode')=='UPDATE') {
	    			$('#form_create_teacher').attr('action',"{{route('admin.accounts.edit')}}")
	    			}
	    			$('#form_create_teacher').submit();
	    			document.getElementById("cuentas_docentes").style.display = "block";
	        		document.getElementById("cuentas_estudiantes").style.display = "none";
	            	document.getElementById("cuentas_empresas").style.display = "none";
	            	document.getElementById("cuentas_coordinador_empresa").style.display = "none";
	            	document.getElementById("cuentas_coordinador_concepta").style.display = "none";
	    			break;
	    		}
	    		case 'empresa':{
	    			if ($('#popup_add_account').attr('data-mode')=='UPDATE') {
	    			$('#form_create_business').attr('action',"{{route('admin.accounts.edit')}}")

	    			}
	    			$('#form_create_business').submit();
	    			break;
	    		}
	    		case 'coordinador_empresa':{
	    			if ($('#popup_add_account').attr('data-mode')=='UPDATE') {
	    			$('#form_create_company').attr('action',"{{route('admin.accounts.edit')}}")
	    				
	    			}
	    			$('#form_create_company').submit();
	    			break;
	    		}
	    		case 'coordinador_concepta':{
	    			if ($('#popup_add_account').attr('data-mode')=='UPDATE') {
	    			$('#form_create_admin').attr('action',"{{route('admin.accounts.edit')}}")
	    				
	    			}
	    			$('#form_create_admin').submit();
	    			break;
	    		}
	    	}

	    	$('select#true_select_account option[value="'+elementoSelect+'"]').attr("selected", true);

	    });

	    $('.box_cuenta').click(function(){
	    	var this_el = $(this);
	    	$('.container_agregar_account').find('form').hide();
	    	button_save_disabled = false;
	    	calling_show = true;
	    	var tmp_form = null;
	    	$("#popup_add_account").attr('data-mode','UPDATE')
	    	switch($('#true_select_account').val()){
	    		case 'estudiante':{
	    			tmp_form = $('#form_create_student');
					$.ajax({
					  method: "GET",
					  url: "{{route('admin.accounts.find')}}" + "?" + "type={{ACCOUNT_STUDENT}}&" + "id=" + this_el.data('id')
					}).done(function( data ) {
						console.log(data)
						tmp_form.find('input[name="type"]').val("{{ACCOUNT_STUDENT}}");
						tmp_form.find('input[name="id"]').val(this_el.data('id'));

						tmp_form.find('input[name="dni"]').val(data.dni);
						tmp_form.find('input[name="name"]').val(data.name);
						tmp_form.find('input[name="last_name"]').val(data.last_name);
						tmp_form.find('input[name="phone"]').val(data.phone);
						tmp_form.find('select[name="company_id"]').val(data.company_id);
						tmp_form.find('input[name="email"]').val(data.email);
						tmp_form.find('input[name="personal_email"]').val(data.personal_email);
						tmp_form.find('#preview-upload-photo').css('background-image','url('+data.photo+')');	
						tmp_form.find('input.student_imagen_bd').val(data.photo);

						tmp_form.find('input[name="image"]').val(data.photo);
					});
	    			tmp_form.show();
	    			
	    			break;
	    		}
	    		case 'docente':{
	    			tmp_form = $('#form_create_teacher');
					$.ajax({
					  method: "GET",
					  url: "{{route('admin.accounts.find')}}" + "?" + "type={{ACCOUNT_TEACHER}}&" + "id=" + this_el.data('id')
					}).done(function( data ) {
						tmp_form.find('input[name="type"]').val("{{ACCOUNT_TEACHER}}");
						tmp_form.find('input[name="id"]').val(this_el.data('id'));
						tmp_form.find('input[name="dni"]').val(data.dni);
						tmp_form.find('input[name="name"]').val(data.name);
						tmp_form.find('input[name="last_name"]').val(data.last_name);
						tmp_form.find('input[name="phone"]').val(data.phone);
						tmp_form.find('input[name="company"]').val(data.company);
						tmp_form.find('input[name="email"]').val(data.email);
						tmp_form.find('input[name="personal_email"]').val(data.personal_email);
						tmp_form.find('input[name="description"]').val(data.description);
						tmp_form.find('#preview-upload-photo').css('background-image','url('+data.photo+')');
						tmp_form.find('input.docente_imagen_bd').val(data.photo);	

					});
	    			tmp_form.show();
	    			break;
	    		}
	    		case 'empresa':{
	    			tmp_form = $('#form_create_business');
	    			$.ajax({
	    			  method: "GET",
					  url: "{{route('admin.accounts.find')}}" + "?" + "type={{ACCOUNT_BUSINESS}}&" + "id=" + this_el.data('id')
					}).done(function( data ) {
						tmp_form.find('input[name="type"]').val("{{ACCOUNT_BUSINESS}}");
						tmp_form.find('input[name="id"]').val(this_el.data('id'));
						tmp_form.find('input[name="ruc"]').val(data.ruc);
						tmp_form.find('input[name="social_reason"]').val(data.social_reason);
						tmp_form.find('input[name="address"]').val(data.address);
						tmp_form.find('input[name="phone"]').val(data.phone);
						tmp_form.find('input[name="email"]').val(data.email);
						tmp_form.find('input[name="contact_name"]').val(data.contact_name);
						tmp_form.find('input[name="contact_email"]').val(data.contact_email);
						tmp_form.find('#preview-upload-photo').css('background-image','url('+data.logo+')');	
						tmp_form.find('input.empresa_imagen_bd').val(data.logo);

					});
	    			tmp_form.show();
	    			break;
	    		}
	    		case 'coordinador_empresa':{
	    			tmp_form = $('#form_create_company');
					$.ajax({
					  method: "GET",
					  url: "{{route('admin.accounts.find')}}" + "?" + "type={{ACCOUNT_COMPANY}}&" + "id=" + this_el.data('id')
					}).done(function( data ) {
						tmp_form.find('input[name="type"]').val("{{ACCOUNT_COMPANY}}");
						tmp_form.find('input[name="id"]').val(this_el.data('id'));
						tmp_form.find('input[name="dni"]').val(data.dni);
						tmp_form.find('input[name="name"]').val(data.name);
						tmp_form.find('input[name="last_name"]').val(data.last_name);
						tmp_form.find('input[name="contact_phone"]').val(data.contact_phone);
						tmp_form.find('select[name="business_id"]').val(data.business_id).change();
						tmp_form.find('input[name="email"]').val(data.email);
						tmp_form.find('input[name="personal_email"]').val(data.personal_email);
						tmp_form.find('#preview-upload-photo').css('background-image','url('+data.photo+')');	
						tmp_form.find('input.coord_empresa_imagen_bd').val(data.photo);

					});
	    			tmp_form.show();
	    			break;
	    		}
	    		case 'coordinador_concepta':{
	    			tmp_form = $('#form_create_admin');
					$.ajax({
					  method: "GET",
					  url: "{{route('admin.accounts.find')}}" + "?" + "type={{ACCOUNT_ADMIN}}&" + "id=" + this_el.data('id')
					}).done(function( data ) {
						tmp_form.find('input[name="type"]').val("{{ACCOUNT_ADMIN}}");
						tmp_form.find('input[name="id"]').val(this_el.data('id'));
						tmp_form.find('input[name="dni"]').val(data.dni);
						tmp_form.find('input[name="name"]').val(data.name);
						tmp_form.find('input[name="last_name"]').val(data.last_name);
						tmp_form.find('input[name="phone"]').val(data.phone);
						tmp_form.find('input[name="company"]').val(data.company);
						tmp_form.find('input[name="email"]').val(data.email);
						tmp_form.find('input[name="personal_email"]').val(data.personal_email);
						tmp_form.find('#preview-upload-photo').css('background-image','url('+data.photo+')');
						tmp_form.find('select[name="role_id"]').val(data.role_id)
						
						tmp_form.find('input.admin_imagen_bd').val(data.photo);

					});
	    			tmp_form.show();
	    			break;
	    		}
	    	}
	    	$('#popup_add_account').modal('toggle');
	    });

		$('#popup_add_account').on('show.bs.modal', function (e) {
			$('#save').prop('disabled', button_save_disabled);
		})

		$('#popup_add_account').on('hidden.bs.modal', function (e) {
			button_save_disabled = !calling_show;
			calling_show = false;
			$(this).attr('data-mode','')

		})
		$('#form_create_student #file_new_account').on('change',function(ev){
			inputFile("#form_create_student",ev)
		});
		$('#form_create_teacher #file_new_account').on('change',function(ev){
			inputFile("#form_create_teacher",ev)
		});
		$('#form_create_business #file_new_account').on('change',function(ev){
			inputFile("#form_create_business",ev)
		});
		$('#form_create_company #file_new_account').on('change',function(ev){
			inputFile("#form_create_company",ev)
		});
		$('#form_create_admin #file_new_account').on('change',function(ev){
			inputFile("#form_create_admin",ev);
		});
		
		var inputFile = function(id,evente){
            var input = evente.currentTarget;
			console.log(input)
            console.log(input.files,input.files[0])
            if (input.files && input.files[0]) {
              var reader = new FileReader();
              reader.onload = function(e) {
                   document.querySelector(id+' #preview-upload-photo').style.backgroundImage='url('+e.target.result+')';
          document.querySelector(id+' #preview-upload-photo').style.display = 'block';
              }
              reader.readAsDataURL(input.files[0]);
            }
        }
  </script>

@stop
