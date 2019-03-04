@extends('coordinador_empresa.templates.base_coordinador_empresas')

@section('extra_css')
	<link rel="stylesheet" type="text/css" href="{{asset('css/coordinador_empresa/style_evaluaciones.css')}}">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
	<style>
		.footer{
			position: absolute;
			bottom: 0;
		}
	</style>
@stop

@section('titulo')
	EVALUACIONES
@stop

@section('home_url')
{{route('company.courses.index')}}
@stop

@section('logout_url')
	{{route('company.auth.logout')}}
@stop

@section('contenido')

<div class="container container_evaluaciones">
	<div class="row no-gutters" style="overflow-y: auto; overflow-x: hidden; max-height: 430px;">
	@foreach($exams as $exam)
	<!-- ****************************   INICIO DEL PRIMER evaluacion   ********************** -->
	<div id="accordion_{{$exam->id}}" class="mb-3 col-md-12">
		<div class="card">
		    <div class="card-header pb-0" id="headingOne" data-toggle="collapse" data-target="#collapse_{{$exam->id}}" aria-expanded="true" aria-controls="collapseOne">
		    	<div class="row">
		    		<div class="col-sm-6 col-md-6 align-self-center title_evaluacion">
		    			{{$exam->instance->title}}
		    		</div>
		    		<div class="col-sm-6 col-md-6 align-self-center button_evaluacion">
		    			<a href="{{route('company.exams.detail', $exam->id)}}" class="btn btn-secondary btn_to_ingresar">Ingresar</a>
		    		</div>
		    	</div>
		    	<div class="row">
		    		<div class="col-sm-6 col-md-6 align-self-center time_evaluacion">
		    			<i class="fas fa-clock mr-1"></i>Tiempo: {{$exam->instance->duration_in_minutes}} minutos
		    		</div>
		    		<div class="col-sm-6 col-md-6 align-self-center triangle_evaluacion">
		    				<div class="icono_triangulo fas fa-caret-down fa-3x">
							</div>
		    		</div>
		    	</div>

		    </div>
	 		<!-- Todo lo que sale una vez que se habra el despegable -->
		    <div id="collapse_{{$exam->id}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion_{{$exam->id}}">
		      	<div class="card-body">
			        <div class="row">
			    		<div class="col-sm-12 col-md-12 description_simulador">
			    			<i class="far fa-file-alt mr-1"></i>Descripción<br>
			    			<span>{{$exam->instance->description}}</span>
			    		</div>
			    	</div>
			    		<!--@foreach($exam->students as $student)
			    		********** Inicio de primer alumno ************-->
			    		<!--<div class="row students_simulador">
			    			<div class="col-sm-3 col-md-3 name_colaborador">
			    				<span class="fas fa-user"></span>{{$student->full_name}}
			    			</div>
			    			<div class="col-sm-3 col-md-2 code_colaborador">
			    				{{$student->id}}
			    			</div>
			    			<div class="col-sm-3 col-md-5 tries_colaborador">
			    			
			    			</div>
			    			<div class="col-sm-3 col-md-2 average_colaborador">
			    				0
			    			</div>
			    		</div>-->
			    		<!--********** Final de primer alumno ************
			    		@endforeach-->
		    	</div>
		      </div>
		    </div>
		</div>
	<!-- ****************************   FINAL DEL PRIMER evaluacion   ********************** -->
	@endforeach
	</div>
</div>
@stop

@section('extra_scripts')
	<script type="text/javascript">
	 	$('.collapse').on('show.bs.collapse', function () {
    		$(this).siblings('.card-header').find('.icono_triangulo').removeClass('fa-caret-down').addClass('fa-caret-up');
  		});

  		$('.collapse').on('hide.bs.collapse', function () {
  			$(this).siblings('.card-header').find('.icono_triangulo').removeClass('fa-caret-up').addClass('fa-caret-down');
  		});
  </script>

@stop
