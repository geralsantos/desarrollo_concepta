@extends('main.base_main')


@section('extra_css')
	<link rel="stylesheet" type="text/css" href="{{asset('css/docentes/style_curso_ejemplo.css')}}">
@stop

@section('home_url')
{{route('teacher.courses.index')}}
@stop

@section('logout_url')
    {{route('teacher.auth.logout')}}
@stop

@section('contenido_web')


@section('titulo')
	Nombre de Curso
@stop

<html>
<body>

<!--///////////////////////////// CONTENIDO INTRODUCTORIO ////////////////////////////////////-->
<div class="intro">
	<div class="container informacion">
		<div class="row">
            <div class="col-sm">
            	<video class="video_introduccion" controls>
            		<source src="" type="video/mp4">
                    Your browser doesn't support HTML5 video.
                </video>
            </div>
            <div class="col-sm">
            	<p>{{$course->name}}</p>

            	<p>Docente: {{$course->teacher->full_name}}</p>

			  	<div class="progress">
					<div class="progress-bar progress-bar-striped progress-bar-green" role="progressbar" style="width: {{$course->progress}}%;" aria-valuenow="{{$course->progress}}" aria-valuemin="0" aria-valuemax="100">{{$course->progress}}% completado</div>
				</div>
				<a href="{{route('teacher.courses.edit', $course->id)}}" class="btn btn-info">Editar</a>
            </div>
        </div>
	</div>

</div>
<!--/////////////////////////////////// TABS DE NAVEGACIÓN //////////////////////////////////////-->
<div class="parent_tabs">

	<nav>
		<div class="nav nav-tabs" id="nav-tab" role="tablist">
			<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">
			Sesiones
			</a>
			<a class="nav-item nav-link" id="nav-examen-tab" data-toggle="tab" href="#nav-examen" role="tab" aria-controls="nav-examen" aria-selected="false">
			Exámenes
			</a>
			<a class="nav-item nav-link" id="nav-actividad-tab" data-toggle="tab" href="#nav-actividad" role="tab" aria-controls="nav-actividad" aria-selected="false">
			Actividades
			</a>
			<a class="nav-item nav-link" id="nav-alumno-tab" data-toggle="tab" href="#nav-alumno" role="tab" aria-controls="nav-alumno" aria-selected="false">
			Alumnos
			</a>
		</div>
	</nav>

	<!-- ************************** CONTENIDO DE TABS ******************************-->
	<div class="tab-content" id="nav-tabContent">
	<!-- **********************************   SESIONES  *******************************************-->
		<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
			<br>
	  		<div class ="container">
	  			@foreach($course->sessions as $session)
	  			<!-- *********************    Inicio de PRIMERA SESION    **********************-->
	  			<div class="container_sesion">
	  					<div id="accordion_{{$session->id}}">
							<div class="card">
								<!-- ***********    Inicio de barra principal    ************-->
							    <div class="card-header" id="headingOne" data-toggle="collapse" data-target="#collapse_{{$session->id}}" aria-expanded="true" aria-controls="collapseOne">
							      	<h5 class="mb-0">

								      	<div class="linea_1_sesion">
									      	<div class="text_sesion">
									      		Sesión {{$loop->iteration}}
									      		@if($session->type)
									      		<span>| {{$session->type->name}} <a href="#" class="btn btn-primary btn-sm" data-target="#sesion_{{$session->id}}" data-toggle="modal"><span class="fas fa-user-plus"></span></a></span>
									      		@endif
									      	</div>

									      	<div class="quantity_temas">
									      		0/{{$session->themes()->count()}}
									      	</div>
								      	</div>

								      	<div class="linea_2_sesion">
									      	<div class="title_sesion">
									      		{{$session->name}}
									      	</div>

										    <!-- Aquí se está creando el triangulo que apunta abajo -->
											<div class="contenedor_triangulo">
												<div class="icono_triangulo triangle-down">
									  				<img/>
												</div>
											</div>
										</div>
							      	</h5>
							    </div>
		                        <!-- ******************* Fin de barra principal *****************-->
						        <!-- **************** Inicio de despegable **********************-->
							    <div id="collapse_{{$session->id}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion_{{$session->id}}">
							    	<div class="card-body">
							    		@foreach($session->themes as $theme)
							    <!-- *********** Inicio de primer tema ******************-->
									    <div class="row row_tema">
										    <div class="col-sm title_tema">
										    	<span class="fas fa-edit"></span> {{$theme->name}}
										    </div>
										    <div class="col-sm button_tema">
										    	<a href="{{route('teacher.themes.detail', $theme->id)}}" class ="btn button_editar_curso">Ver Tema </a>
										    </div>
										    <div class="col-sm button_tema">
										    	<button class ="button_editar_curso" data-id=""> Editar Tema </button>
										    </div>
										    <div class="col-sm time_tema">
										    	{{$theme->formatted_duration}}
										    </div>
									    </div>
							    <!-- *********** Fin de primer tema ******************-->
							    		@endforeach
									</div>
							    </div>

						        <!-- *************** Fin de despegable ****************-->
							</div>
						</div>
				</div>
				<br>
	  			<!-- **********************   Fin de PRIMERA SESION     *************************-->
	  			@endforeach
	  		</div>
	  	</div>
	<!-- **********************************   FIN DE SESIONES *************************************-->


	<!-- **********************************   EXÁMENES  *****************************************-->
		<div class="tab-pane fade" id="nav-examen" role="tabpanel" aria-labelledby="nav-examen-tab">
			<br>
			<div class="container">
				@foreach($course->exams as $exam)
				<!-- **********************   Inicio de PRIMER EXAMEN     *************************-->
				<div class="container_examen">
					<div class="row">
						<div class="col-sm text_examen">
				  			Examen {{$loop->iteration}}
						</div>
					</div>
					<div class="row">
						<div class="col-sm title_examen">
				  			{{$exam->name}}
						</div>
				    	<div class="col-sm button_examen">
				      		<button class ="button_editar_examen" data-id=""> Editar Examen </button>
				    	</div>
					</div>
					<div class="row">
						<div class="col-sm time_examen">
				  			Tiempo: {{$exam->duration}} minutos
						</div>
					</div>
					@foreach($exam->course->product->students as $student)
						<!-- Estudiante 1 -->
						<div  class="row students_examenes">
							<div class="col-sm-6 col-md-3">
								<span class="fas fa-check-circle"></span> {{$student->full_name}}<br>
							</div>
							<div class="col-sm-6 col-md-9">
								<a href="{{route('teacher.questions.review', ['entity_name' => ENTITY_COURSE_EXAM, 'entity_id' => $exam->id, 'student_id' => $student->id])}}"><span class="fas fa-clipboard-check" title="Corregir"></span></a>
							</div>
						</div>
						<!-- Estudiante 1 -->
					@endforeach
				</div>
				<br>
				<!-- **********************   Fin de PRIMER EXAMEN     *************************-->
				@endforeach
			</div>
		</div>
	<br>
	<!-- ***********************   FIN DE EXÁMENES  *****************************************-->

	<!-- **********************************   ACTIVIDADES  **************************************-->
		<div class="tab-pane fade" id="nav-actividad" role="tabpanel" aria-labelledby="nav-actividad-tab">

			<div class="container">
				@foreach($course->activities as $activity)
				<!-- **********************   Inicio de PRIMERA ACTIVIDAD     *************************-->
				<div class="container_actividad">
					<div class="row">
						<div class="col-sm text_actividad">
				  			Actividad {{$loop->iteration}}
						</div>
					</div>
					<div class="row">
						<div class="col-sm title_actividad">
				  			{{$activity->name}}
						</div>
				    	<div class="col-sm button_actividad">
				      		<button class ="button_editar_actividad" data-id=""> Editar Actividad </button>
				    	</div>
					</div>
					@foreach($activity->course->product->students as $student)
						<!-- Estudiante 1 -->
						<div  class="row students_examenes">
							<div class="col-sm-6 col-md-3">
								<span class="fas fa-check-circle"></span> {{$student->full_name}}<br>
							</div>
							<div class="col-sm-6 col-md-9">
								<a href="{{route('teacher.questions.review', ['entity_name' => ENTITY_ACTIVITY, 'entity_id' => $activity->id, 'student_id' => $student->id])}}"><span class="fas fa-clipboard-check" title="Corregir"></span></a>
							</div>
						</div>
						<!-- Estudiante 1 -->
					@endforeach
				</div>
				<br>
				<!-- **********************   Fin de PRIMERA ACTIVIDAD     *************************-->
				@endforeach
			</div>
		</div>
	<!-- ************************   FIN DE ACTIVIDADES  *****************************************-->
	<!-- **********************************   ALUMNOS  **************************************-->
		<div class="tab-pane fade" id="nav-alumno" role="tabpanel" aria-labelledby="nav-alumno-tab">

			<div class="container">
				<div class="container-fluid container_alumnos">
					<!-- ********  Inicio de PRIMERA FILA DE ALUMNOS   **********-->
					<div class="row row_alumnos">
						@foreach($course->product->students as $student)
						<!-- ********  Inicio de Alumno   **********-->
						<div class="col-sm-6 col-md-2 col-alumno">
				  			<a href="#">
					  			<div class="box_alumnos">
					  				<div class="box_alumnos_top">
					  					<i class="fas fa-user fa-5x"></i>
					  				</div>
					  				<div class="box_alumnos_bottom">
						  				{{$student->full_name}}
						  				<p>Código de alumno: {{$student->id}}</p>
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
		</div>
	<!-- ************************   FIN DE ALUMNOS  *****************************************-->

</div>
<!-- ************************   FIN DE TABS  *****************************************-->
@foreach($course->sessions as $session)
<div class="modal" id="sesion_{{$session->id}}" data-id="{{$session->id}}">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Lista de Asistencia - Sesión {{$loop->iteration}}</h4>
				<button class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<form method="post" action="{{route('teacher.courses.save-assistances')}}">
					{!! csrf_field() !!}
					<input type="hidden" name="session_id" value="{{$session->id}}">
					<div class="form-group">
						<div class="row">
							<div class="col-sm-8 col-nombre">
								Nombre del Estudiante
							</div>
							<div class="col-sm-2 col-asistio">
								Asistió
							</div>
							<div class="col-sm-2 col-falto">
								Faltó
							</div>
						</div>
						<br>
						@foreach($course->product->students as $student)
						<!--*********  Inicio de Primer Estudiante  *********** -->
						<div class="row">
							<div class="col-sm-8">
								{{$student->full_name}}
							</div>
							<div class="col-sm-2 col-asistio">
								<input type="radio" name="alumnos[{{$student->id}}]" value="1" {{$student->assistance_by_session($session->id) ? ($student->assistance_by_session($session->id)->value ? 'checked' : '') : ''}}>
							</div>
							<div class="col-sm-2 col-falto">
								<input type="radio" name="alumnos[{{$student->id}}]" value="0" {{$student->assistance_by_session($session->id) ? (!$student->assistance_by_session($session->id)->value ? 'checked' : '') : ''}}>
							</div>
						</div>
						<hr>
						<!--*********  Fin de Primer Estudiante  *********** -->
						@endforeach
					</div>
					<div class="modal-footer" style="border: none">
						<button class="btn btn-primary button_guardar" type="submit">Guardar</button>
						<button class="btn btn-primary button_cerrar" data-dismiss="modal">Cerrar</button>
					</div>
				</form>
			</div>
		</div>
	</div>

</div>
@endforeach




@section('extra_scripts')
	<script type="text/javascript">

	 	$('.fa-user-plus').click(function(){
			$(this).parents('.card-header').removeAttr('data-toggle');
		});

		$('.button_guardar, .button_cerrar').click(function(){
			var id = $(this).parents('.modal').data('id');

			$('#accordion_' + id).find('.card-header').attr('data-toggle', 'collapse');
		});


	 	$('.collapse').on('show.bs.collapse', function () {
    		$(this).siblings('.card-header').find('.icono_triangulo').removeClass('triangle-down').addClass('triangle-up');
  		});

  		$('.collapse').on('hide.bs.collapse', function () {
  			$(this).siblings('.card-header').find('.icono_triangulo').removeClass('triangle-up').addClass('triangle-down');
  		});
  </script>

@stop

</body>
</html>

@stop
