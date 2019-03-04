@extends('admin.templates.base_admin')
@section('extra_css')
	<link rel="stylesheet" type="text/css" href="{{asset('css/config/user.css')}}">
@stop

@section('titulo')
	Configuración de Usuario
@stop

@section('home_url')
{{route('admin.courses.index')}}
@stop

@section('logout_url')
{{route('admin.auth.logout')}}
@stop

@section('contenido')

<div class="row shadow p-3 mb-5 bg-white rounded" style="margin-top:20px;margin: auto;width: 100%;padding: 10px;height: 100%;">
	<div class="container" style="max-height: 600px; overflow-x: hidden; overflow-y: auto;">
	<form method="POST" action="{{route('admin.config.update')}}" enctype="multipart/form-data">
            {!! csrf_field() !!}
    <div class="fotoUsuario py-3 mb-4">
      <div class="circle_photo p-2" id="preview-upload-photo" style="width: 200px;height: 200px;margin-left: auto;margin-right: auto;background-image: url('{{asset($photo)}}')">
                  <!-- SE TIENE QUE ACTIVAR PARA QUE LA FOTO SE PUEDA VER UNA VEZ ESTA HAYA SIDO SELECCIONADA -->
      </div>
      <input type="hidden" name="imagenActual" value="{{$photo}}">
      <input type="file" id="file_new_account" name="image" class="ml-5">
    </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="txtusername">Usuario :</label>
      <input type="text" class="form-control" id="txtusername" name="txtusername" placeholder="Usuario" value="{{$username}}" autocomplete="off">
    </div>
    <div class="form-group col-md-6">
      <label for="txtpassword">Contraseña :</label>
      <input type="hidden" name="txtpasswordActual" value="{{$password}}">
      <input type="password" class="form-control" id="txtpassword" name="txtpassword" placeholder="Ingrese su nueva Contraseña (SOLO SI DESEA CAMBIARLA)" autocomplete="new-password" autocomplete="off">
    </div>
  </div>
  <div class="form-group row mb-3">
    <div class="col-4">
      <label for="txtnombres">Nombre :</label>
      <input type="text" class="form-control" id="txtnombres" name="txtnombres" placeholder="Nombres" value="{{$name}}">
    </div>
    <div class="col-4">
      <label for="txtapellidos">Apellidos :</label>
    <input type="text" class="form-control" id="txtapellidos" name="txtapellidos" placeholder="Apellidos" value="{{$last_name}}">
    </div>
    <div class="col-4">
      <label for="txtdni">DNI :</label>
      <input type="text" class="form-control" id="txtdni" name="txtdni" placeholder="Usuario" value="{{$dni}}">
    </div>
  </div>
  <div class="form-group row mb-3">
    <div class="col-md-4">
      <label for="txtemail">Email :</label>
      <input type="email" class="form-control" id="txtemail" name="txtemail" placeholder="Email" value="{{$email}}">
    </div>
    <div class="col-md-4">
      <label for="txtpersonalemail">Email Personal :</label>
      <input type="email" class="form-control" id="txtpersonalemail" name="txtpersonalemail" placeholder="Email Personal" value="{{$personal_email}}">
    </div>
    <div class="col-md-4">
      <label for="txtphone">Telefono :</label>
      <input type="text" class="form-control" id="txtphone" name="txtphone" placeholder="Ingrese su número" value="{{$phone}}">
    </div>
  </div>
  <button type="submit" class="btn btn-primary btn-sm btn-block">Guardar</button>
</form>
</div>
</div>
@stop

@section('extra_scripts')
	<script type="text/javascript">

$('document').ready(function(){

  $("#txtpassword").val('');

});

$('#file_new_account').on('change',function(ev){
			inputFile(ev)
		});
		
		var inputFile = function(evente){
            var input = evente.currentTarget;
			console.log(input)
            console.log(input.files,input.files[0])
            if (input.files && input.files[0]) {
              var reader = new FileReader();
              reader.onload = function(e) {
                   document.querySelector('#preview-upload-photo').style.backgroundImage='url('+e.target.result+')';
          document.querySelector('#preview-upload-photo').style.display = 'block';
              }
              reader.readAsDataURL(input.files[0]);
            }
        }
     </script>
@stop
