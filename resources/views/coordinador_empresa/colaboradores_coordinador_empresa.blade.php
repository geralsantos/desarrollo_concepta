@extends('coordinador_empresa.templates.base_coordinador_empresas')
@section('extra_css')
	<link rel="stylesheet" type="text/css" href="{{asset('css/coordinador_empresa/style_colaboradores.css')}}">
@stop

@section('titulo')
	COLABORADORES
@stop

@section('home_url')
{{route('company.courses.index')}}
@stop

@section('logout_url')
	{{route('company.auth.logout')}}
@stop

@section('contenido')

<div class="container">
	<div class="container-fluid container_alumnos">
		<div class="row add_alumno">
			<button class="btn btn-success" data-target="#popup_add_alumno" data-toggle="modal">
				<span class="fas fa-user-plus mr-2"></span>
				<span> Crear nuevo alumno</span>
			</button>

		</div>
		<div class="row text_listado">
			<div class="col-sm-12 col-md-12">
				Listado de colaboradores
			</div>
		</div>
		<div class="row row_alumnos">
			@foreach($students as $student)
			<!-- ********  Inicio de Alumno   **********-->
			<div class="col-sm-4 col-md-2 col-alumno">
	  			<a href="#" style="text-decoration: none;">
		  			<div class="box_alumnos">
		  				<div class="box_alumnos_top">
		  					<img src="{{asset($student->photo)}}" class="photo_alumno my-2 img-fluid" alt="image not available" onerror="this.onerror=null;this.src='/images/default/user.png';">
		  				</div>
		  				<div class="box_alumno_bottom">
					  		<p class="mb-1 mt-2">{{$student->full_name}}<br>
					  		DNI: {{$student->dni}}
					  		</p>
				  		</div>
		  			</div>
	  			</a>
			</div>
			<!-- ********  Fin de Alumno   **********-->
			@endforeach
		</div>
		<!-- ********  Fin de PRIMERA FILA DE ALUMNOS   **********-->
	</div>
</div>

<!-- *********************** INICIO POP-UP AGREGAR ALUMNO ************************* -->
<div class="modal fade" id="popup_add_alumno" tabindex="-1" role="dialog" aria-labelledby="popup_alumnoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="height: 450px">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar Alumno</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body body_add_alumnos" style="overflow-y: hidden;">
      	<div class="container_agregar_alumno">
	      	<div class="row no-gutters new_alumno">
	      		<form id="form_create_student" role="form" enctype="multipart/form-data" method="post"  class="col-md-12">
	      			<div class="row no-gutters">
	      				<div class="col-sm-6 text-center mt-4 col-md-5 photo_new_alumno">
	      			<img class="circle_photo img-fluid" src="/images/default/user.png" width="130" style="border-radius: 50%; border: 1.5px solid black;">
	      				<!-- SE TIENE QUE ACTIVAR PARA QUE LA FOTO SE PUEDA VER UNA VEZ ESTA HAYA SIDO SELECCIONADA -->
	      			<br>
	      			<input type="file" class="file_new_alumno ml-4 mt-5" id="file_new_alumno" name="image">
	      			
	      		</div>
	      		<div class="col-sm-6 col-md-7 align-self-center info_new_alumno">
                        {!! csrf_field() !!}
					    DNI: <input type="text" style="width: 400px;" name="dni_alumno" id="dni_alumno"><hr class="my-1">
				      	NOMBRE(S): <input type="text" style="width: 337px;" name="nombres_alumno" id="nombres_alumno"><hr class="my-1">
				      	APELLIDO(S): <input type="text" style="width: 330px;" name="apellidos_alumno" id="apellidos_alumno"><hr class="my-1">
				      	TELÉFONO: <input type="text" style="width: 345px;" name="telefono_alumno" id="telefono_alumno"><hr class="my-1">

				      	E-MAIL EMPRESARIAL: <input type="text" style="width: 260px;" name="email_empresarial_alumno" id="email_empresarial_alumno"><hr class="my-1">
				      	E-MAIL PERSONAL: <input type="text" style="width: 288px;" name="email_personal_alumno" id="email_personal_alumno"><hr class="my-1">
	      			</div>
	      			</div>
	      		</form>
	      	</div>
	    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="save_student">Guardar</button>
      </div>
    </div>
  </div>
</div>

<!-- *********************** FIN DE POP-UP AGREGAR ALUMNO ************************* -->



@stop

@section('extra_scripts')
	<script type="text/javascript">

	
		$(".file_new_alumno").change(function(){

	var imagen = this.files[0];

	if(imagen["type"] != "image/jpeg" && imagen["type"] != "image/png"){

		$(".file_new_alumno").val("");

		swal({
			type: "error",
			title: "Error al subir la imagen",
			text: "¡La imagen debe ser formato JPG o PNG!",
			confirmButtonText: "Cerrar"
		});

	}else if(imagen["size"] > 2000000){

		$(".file_new_alumno").val("");

		swal({
			type: "error",
			title: "Error al subir la imagen",
			type: "¡La imagen no debe pesar más de 2MB",
			confirmButtonText: "Cerrar"
		});

	}else{

		var datosImagen = new FileReader;
		datosImagen.readAsDataURL(imagen);

		$(datosImagen).on("load", function(){

			var rutaImagen = event.target.result;
			$(".circle_photo").attr("src", rutaImagen);

		});

	}

});

	 	$('.collapse').on('show.bs.collapse', function () {
    		$(this).siblings('.card-header').find('.icono_triangulo').removeClass('fa-caret-down').addClass('fa-caret-up');
  		});

  		$('.collapse').on('hide.bs.collapse', function () {
  			$(this).siblings('.card-header').find('.icono_triangulo').removeClass('fa-caret-up').addClass('fa-caret-down');
  		});

  		$('#save_student').click(function(){
        var fd = new FormData($('#form_create_student')[0]);

        $.ajax({
            type: "POST",
            url: "{{route('company.students.json-create')}}",
            data: fd,
            processData: false,
            contentType: false,
            success: function (data) {
                $('#popup_add_alumno').modal('toggle');
                location.reload();
            },
            error: function(data) {
            	var array = $.map(data.responseJSON, function(value, index) {
                    return [value];
                });
                alert(array.toString());
            }
        });
    });





  </script>

@stop
