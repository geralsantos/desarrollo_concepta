@extends('docentes.templates.base_docentes')

@section('extra_css')
	<link rel="stylesheet" type="text/css" href="{{asset('css/docentes/style_docentes_cursos.css')}}">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
@stop

@section('titulo')
	CURSOS
@stop

@section('home_url')
{{route('teacher.courses.index')}}
@stop

@section('logout_url')
    {{route('teacher.auth.logout')}}
@stop

@section('contenido')


<div class="container">
	<div style="max-height: 425px; overflow-y: auto;">
	@foreach($courses as $course)
	<!--////////////////////  INICIO DE PRIMER CURSO  ////////////////////// -->
	<div class="container_curso p-3 mb-3">
		<div class="row header_curso">
			<div class="col-sm title_curso px-0">
	  			<span class="px-3 font-weight-bold text-uppercase" style="font-size: 22px;">{{$course->name}}</span>
			</div>
	    	<div class="col-sm button_curso">
	      		<a href="{{route('teacher.courses.edit', $course->id)}}" class ="button_ingresar_curso btn btn-secondary" data-id="{{$course->id}}"> Ingresar </a>
	    	</div>
		</div>
		<div class="row  alumnos_inscritos">
			<div class="col-sm text_alumnos px-0">
	  			<span class="px-3"><i class="fas fa-user-graduate mr-3"></i>N° de alumnos inscritos: <span class="ml-2 badge badge-info" style="font-size: 1em; height: 33px; width: 33px; border: 1.5px solid black;"><span class="cantidadE">{{$course->product->students->count()}}</span></span></span>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<span><i class="fas fa-code-branch mr-3"></i>Código: <span class="text-uppercase font-weight-bold">{{$course->product->code}}</span></span>
			</div>
			<!--<div class="col-sm time_curso">
	  			Tiempo: {{$course->duration_in_minutes}} minutos
			</div>
	    	<div class="col-sm advance_curso">
	      		33% completado - Sesión 2
	    	</div>-->
		</div>
		<!--<div class="progress">
			<div class="progress-bar" role="progressbar" style="width: {{$course->progress}}%;" aria-valuenow="{{$course->progress}}" aria-valuemin="0" aria-valuemax="100">{{$course->progress}}%</div>
		</div>-->
	</div>
	<!--//////////////////////  FIN DE PRIMER CURSO  //////////////////////// -->
	@endforeach
	</div>
</div>


@stop

@section('extra_scripts')
	<script type="text/javascript">

		/*$('.button_ingresar_curso').click(function(){
			$(this).parents('.card-header').removeAttr('data-toggle');
			location.href="{{env('APP_URL')}}" + "docentes/cursos/" + $(this).data('id') + "/edit";
		});*/
	
	 	$('.collapse').on('show.bs.collapse', function () {
    		$(this).siblings('.card-header').find('.icono_triangulo').removeClass('triangle-down').addClass('triangle-up');
  		});

  		$('.collapse').on('hide.bs.collapse', function () {
  			$(this).siblings('.card-header').find('.icono_triangulo').removeClass('triangle-up').addClass('triangle-down');
  		});
  </script>

@stop
