@extends('coordinador_empresa.templates.base_coordinador_empresas')
@section('extra_css')
	<link rel="stylesheet" type="text/css" href="{{asset('css/coordinador_empresa/style_simuladores.css')}}">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
	<style>
		.nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link {
    color: #495057;
    background-color: #fff;
    border-color: #dee2e6 #dee2e6 #fff;
}
.active[data-toggle="tab"] {
    background-color: #295120 !important;
    color: white !important;
}

.container_tabs .nav-item:hover {
    background-color: #295120 !important;
    border: medium none;
    border-radius: 0;
    color: white;
}

.nav-item {
    border: medium none;
    color: #295120;
}
.btn-secondary:hover{
background: rgba(41,81,32,.93);
}
	</style>

@stop

@section('titulo')
	SIMULADORES
@stop

@section('home_url')
{{route('company.courses.index')}}
@stop

@section('logout_url')
	{{route('company.auth.logout')}}
@stop

@section('contenido')

<div class = "container container_simuladores">
	<div class="rounded" style="overflow-y: auto; max-height: 620px; overflow-x: hidden;">
	@foreach($simulators as $simulator)
	<!-- Este es el cuadro que contiene toda la información -->
	<div id="accordion_{{ $simulator->id }}" class="mb-3">
		<div class="card" data-id="{{ $simulator->id }}">
			<div class="card-header" id="headingOne" data-toggle="collapse" data-target="#collapse_{{ $simulator->id }}" aria-expanded="true" aria-controls="collapseOne">
				<div class="row">
					<div class="col-md-6 align-self-center title_simulador">
						{{ $simulator->instance->name }}
					</div>
					<div class="col-md-6 align-self-center button_simulador">
						<a href="{{ route('company.simulators.detail', $simulator->id) }}" class="btn btn-secondary">Ingresar</a>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 align-self-center time_simulador">
						<i class="fas fa-user-graduate mr-2"></i>Alumnos registrados: <span class="badge badge-info" style="font-size: 1em; height: 33px; width: 33px; border: 1.5px solid black;"><span style="position: relative; top: 3px;">{{$simulator->instance->product->students()->count()}}</span></span>
					</div>
					<div class="col-md-6 align-self-center triangle_simulador">
						<div class="icono_triangulo fas fa-caret-down fa-3x"></div>
					</div>
				</div>
			</div>
			<div id="collapse_{{ $simulator->id }}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion_{{ $simulator->id }}">
				<div class="card-body">
					<div class="row">
						<div class="col-md-12 description_simulator">
							<i class="far fa-file-alt mr-1"></i>Descripción : <br>
							<span>{{ $simulator->instance->description }}</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@endforeach
	</div>
</div>

<!--//////-->








<!-- *********************** INICIO POP-UP AGREGAR ALUMNO ************************* -->
<div class="modal fade" id="popup_add_alumno" tabindex="-1" role="dialog" aria-labelledby="popup_alumnoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
  	<form id="form_create_student" role="form" enctype="multipart/form-data" method="post" action="{{route('company.products.add-student', '@')}}">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar Alumno</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body body_add_alumnos">
      	<div class="container_agregar_alumno">
	      	<div class="row new_alumno">
	      		<div class="col-sm-6 col-md-3 photo_new_alumno">
	      			<div class="circle_photo">
	      				<!-- SE TIENE QUE ACTIVAR PARA QUE LA FOTO SE PUEDA VER UNA VEZ ESTA HAYA SIDO SELECCIONADA -->
	      			</div>
	      			<br>
	      			<input type="file" id="file_new_alumno" name="photo">
	      			
	      		</div>
	      		<div class="col-sm-6 col-md-9 info_new_alumno">
                        {!! csrf_field() !!}
					    DNI: <input type="text" name="dni"><hr>
				      	NOMBRE(S): <input type="text" name="name"><hr>
				      	APELLIDO(S): <input type="text" name="last_name"><hr>
				      	TELÉFONO: <input type="text" name="phone"><hr>
				      	E-MAIL EMPRESARIAL: <input type="text" name="email"><hr>
				      	E-MAIL PERSONAL: <input type="text" name="personal_email"><hr>
	      		</div>
	      	</div>
	    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary" id="save_student">Guardar</button>
      </div>
    </div>
    </form>
  </div>
</div>
<!-- *********************** FIN DE POP-UP AGREGAR ALUMNO ************************* -->
@stop

@section('extra_scripts')
	<script type="text/javascript">
	 	$('.collapse').on('show.bs.collapse', function () {
    		$(this).siblings('.card-header').find('.icono_triangulo').removeClass('fa-caret-down').addClass('fa-caret-up');
  		});

  		$('.collapse').on('hide.bs.collapse', function () {
  			$(this).siblings('.card-header').find('.icono_triangulo').removeClass('fa-caret-up').addClass('fa-caret-down');
  		});

		$('.add-students').click(function(){
			$(this).parents('.card-header').removeAttr('data-toggle');
			var form = $('#form_create_student');
			var simulator_id = $(this).parents('.card').data('id');
			var action_form = form.prop('action').replace("@", simulator_id);
			form.prop('action', action_form);
			$('#popup_add_alumno').modal('show');

		});
  </script>

@stop
