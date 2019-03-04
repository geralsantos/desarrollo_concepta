@extends('alumnos.templates.base_alumnos')
@section('extra_css')
	<link rel="stylesheet" type="text/css" href="{{asset('css/alumnos/style_cursos.css')}}">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
	<style>
		.footer{
			position: absolute;
			bottom: 0;
		}
		.boton_ingreso_curso:hover{
			background-color: rgba(41, 81, 32, 0.93);
		}
	</style>
@stop

@section('titulo')
	CURSOS
@stop

@section('home_url')
{{route('user.courses.index')}}
@stop

@section('logout_url')
	{{route('user.auth.logout')}}
@stop

@section('contenido')

<div class="container container_cursos">
	
	<div class="mt-3" style="max-height: 420px; overflow-y: auto; overflow-x: hidden;">
	@foreach($courses as $course)
<!--	****************************   INICIO DEL PRIMER CURSO   ********************** -->
	<div class="mb-3" id="accordion_{{$course->id}}">
		<div class="card">
		    <div class="card-header" id="headingOne" data-toggle="collapse" data-target="#collapse_{{$course->id}}" aria-expanded="true" aria-controls="collapseOne">
		    	<div class="row">
		    		<div class="col-sm-6 col-md-6 align-self-center title_curso">
		    			<i class="fas fa-signature mr-2"></i>{{$course->instance->name}}
		    		</div>
		    		
		    		<div class="col-sm-6 col-md-6 align-self-center button_curso" data-id="{{$course->instance->id}}">
		    			<a class="btn btn-secondary boton_ingreso_curso">Ingresar</a>
		    		</div>
		    	</div>
		    	<div class="row">
		    		<!--<div class="col-sm-6 col-md-6 time_curso">
		    			Tiempo: {{$course->instance->duration_in_minutes}} minutos
		    		</div>-->
		    		<div class="col-sm-6 col-md-10 align-self-center time_curso align-self-center">
		    			<div class="row no-gutters justify-content-between">
		    				<div class="col-3 align-self-center"><i class="fas fa-list-ol mr-2"></i><span class="text-uppercase font-weight-bold" style="font-size: 12.3px;">Número de Sesiones:</span> <span class="ml-2 badge badge-success p-2" style="border: 2px solid black;"><i style="font-size: 13px;">{{$sesiones_e->where('course_id', $course->instance->id)->count()}}</i></span></div>
		    				<div class="col-4 align-self-center"><i class="fas fa-list-ol mr-2"></i><span class="text-uppercase font-weight-bold" style="font-size: 12.3px;">Número de Actividades:</span> <span class="ml-2 badge badge-warning p-2" style="border: 2px solid black;"><i style="font-size: 13px;">{{$actividad_e->where('course_id', $course->instance->id)->count()}}</i></span></div>
		    				<div class="col-3 align-self-center"><i class="fas fa-list-ol mr-2"></i><span class="text-uppercase font-weight-bold" style="font-size: 12.3px;">Número de Exámenes:</span><span class="ml-2 badge badge-danger p-2" style="border: 2px solid black;"><i style="font-size: 13px;">{{$exam_e->where('course_id', $course->instance->id)->count()}}</i></span></div>
		    			</div>
		    		</div>
		    		<div class="col-sm-6 col-md-2 align-self-center triangle_curso align-self-center">
		    				<div class="icono_triangulo fas fa-caret-down fa-3x mr-2">
							</div>
		    		</div>
		    	</div>
		    	<div class="row mt-2">
		    		<div class="col-sm-12 col-md-12">
			    		<!--<div class="progress">
			  				<div class="progress-bar" role="progressbar" style="width: {{$session[$course->course->id]['progress']}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
			  				</div>
			  				<span style="position: absolute;text-align: center;left: 50%;">{{$session[$course->course->id]['progress']}}% completado</span>
						</div>-->
	
						<!--<div class="progress">
							<div class="progress-bar progress-bar-warning progress-bar-striped active" role="progressbar"
						  aria-valuenow="{{$session[$course->course->id]['progress']}}" aria-valuemin="0" aria-valuemax="100" style="width:{{$session[$course->course->id]['progress']}}%">
						    {{$session[$course->course->id]['progress']}}% completado
						  	</div>
						</div>-->
						<div class="progress">
							<div class="progress-bar progress-bar-warning progress-bar-striped active" role="progressbar"
						  aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
						    0% completado
						  	</div>
						</div>

					</div>
		    	</div>

		    </div>
	 		<!-- Todo lo que sale una vez que se habra el despegable -->
		    <div id="collapse_{{$course->id}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion_{{$course->id}}">
		      <div class="card-body px-1">
		        <div class="row ml-3">
		    		<div class="col-sm-12 col-md-12 text_descripcion">
		    			<i class="far fa-file-alt mr-2"></i>Descripción
		    		</div>
		    		<div class="col-sm-12 col-md-12 description_curso">
		    			{{$course->instance->description}}
		    		</div>
		    		<div class="col-sm-12 col-md-12 text_docente">
		    			<i class="fas fa-chalkboard-teacher mr-2"></i>Docente
		    		</div>
		    	</div>
		    	<div class="row ml-3 mt-3">
		    		<div class="col-sm-3 col-md-1 mr-4 pr-0 container_foto">
		    			<div class="docente_foto">
		    				<img src="{{asset($course->instance->teacher->photo)}}" class="photo_docente" onerror="this.onerror=null;this.src='/images/default/user.png';">>
		    			</div>
		    		</div>
		    		<div class="col-sm-9 col-md-10 pl-0 info_docente">
		   				<span class="text-capitalize font-weight-bold">{{$course->instance->teacher->full_name}}</span><br>
		   				<span>{{$course->instance->teacher->description}}</span>
		    		</div>
		    	</div>
		      </div>
		    </div>
		</div>
	</div>
	<!-- ****************************   FINAL DEL PRIMER CURSO   ********************** -->
	@endforeach
	</div>
</div>

@stop

@section('extra_scripts')

	<script type="text/javascript">
		$('.button_curso').click(function(){
			$(this).parents('.card-header').removeAttr('data-toggle');
			location.href="{{env('APP_URL')}}" + "alumnos/cursos/" + $(this).data('id') + "/detalle";
		});
	
	 	$('.collapse').on('show.bs.collapse', function () {
    		$(this).siblings('.card-header').find('.icono_triangulo').removeClass('fa-caret-down').addClass('fa-caret-up');
  		});

  		$('.collapse').on('hide.bs.collapse', function () {
  			$(this).siblings('.card-header').find('.icono_triangulo').removeClass('fa-caret-up').addClass('fa-caret-down');
  		});
  </script>

@stop
