@extends('main.base_main')


@section('extra_css')
	<link rel="stylesheet" type="text/css" href="{{asset('css/alumnos/style_ejemplocurso.css')}}">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
@stop

@section('home_url')
{{route('user.courses.index')}}
@stop

@section('logout_url')
	{{route('user.auth.logout')}}
@stop

@section('contenido_web')


@section('titulo')
	CURSO 1
@stop

<html>
<body>

<!--///////////////////////////// CONTENIDO INTRODUCTORIO ////////////////////////////////////-->
<div class="intro px-5">
	<div class="informacion">
		<br>
		<div class="row">
            <div class="col-sm-6 col-md-5">
            	@if($course->instance->intro_type_id == MULTIMEDIA_TYPE_VIDEO_EMBED)
            	<!-- Esto se muestra en caso de que sea un video -->
                <div class="video_introduccion text-center p-2">
                    <iframe src="{{$course->instance->video_intro}}" allowfullscreen frameborder="0" class="rounded w-100"></iframe>
                </div>
                <br>
                <!-- Esto se muestra en caso de que sea un video -->
                @elseif($course->instance->intro_type_id == MULTIMEDIA_TYPE_IMAGE)
                <!-- Esto se muestra en caso de que sea una imagen -->
                <div class="imagen_introduccion text-center p-2">
                    <img src="{{asset($course->instance->video_intro)}}" class="rounded w-100">
                </div>
                <br>
                <!-- Esto se muestra en caso de que sea una imagen -->
                @endif
            </div>
            <div class="col-sm-6 col-md-7 pr-5 pt-3">
            	<p class="text-uppercase font-weight-bold">{{$course->instance->name}}</p>

            	<p class="text-capitalize"><i class="fas fa-chalkboard-teacher mr-2"></i>Docente: <strong>{{$course->instance->teacher->name . ' ' . $course->instance->teacher->last_name}}</strong></p>
            	<i class="far fa-file-alt mr-2"></i>Descripción : <br>
            	{{$course->course->description}}
			  	<div class="progress mt-3">
					<!--<div class="progress-bar progress-bar-striped progress-bar-green" role="progressbar" style="width: {{$session['progress']}}%;" aria-valuenow="{{$session['progress']}}" aria-valuemin="0" aria-valuemax="100" style="position: absolute;text-align: center;left: 50%;">{{$session['progress']}}% completado</div>-->
					<div class="progress-bar progress-bar-striped progress-bar-success active" role="progressbar" style="width: {{$session['progress']}}%;" aria-valuenow="{{$session['progress']}}" aria-valuemin="0" aria-valuemax="100" style="position: absolute;text-align: center;left: 50%;">{{$session['progress']}}% completado</div>
				</div>
            </div>
        </div>
	</div>

</div>
<!--/////////////////////////////////// TABS DE NAVEGACIÓN //////////////////////////////////////-->
<div class="parent_tabs mt-3">

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
			<a class="nav-item nav-link" id="nav-notas-tab" data-toggle="tab" href="#nav-notas" role="tab" aria-controls="nav-notas" aria-selected="false">
			Notas
			</a>
			<a class="nav-item nav-link" id="nav-asistencia-tab" data-toggle="tab" href="#nav-asistencia" role="tab" aria-controls="nav-asistencia" aria-selected="false">
			Asistencia
			</a>
			<a class="nav-item nav-link" id="nav-certificados-tab" data-toggle="tab" href="#nav-certificados" role="tab" aria-controls="nav-certificados" aria-selected="false">
			Certificados
			</a>
		</div>
	</nav>

	<!-- ************************** CONTENIDO DE TABS ******************************-->
	<div class="tab-content px-4" id="nav-tabContent">
	<!-- **********************************   SESIONES  *******************************************-->
		<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
			<br>
	  		<div class ="container-fluid parent_sesiones" style="max-height: 350px; overflow-y: auto; overflow-x: hidden;">
	  			@if($course->instance->sessions->count() > 0)
	  			<div class="row jusify-content-between">
	  			@foreach($course->instance->sessions as $session)
	  			<!-- *********************    Inicio de PRIMERA SESION    **********************-->
	  			<div class="col-md-6 container_sesion mb-3 rounded px-2" style="max-width: 50%;">
	  					<div id="accordion_{{$session->id}}">
							<div class="card">
								<!-- ***********    Inicio de barra principal    ************-->
							    <div class="card-header py-2 px-3" id="headingOne" data-toggle="collapse" data-target="#collapse_{{$session->id}}" aria-expanded="true" aria-controls="collapseOne">
							      	<h5 class="mb-0">

								      	<div class="linea_1_sesion row">
									      	<div class="text_sesion col-md-8 align-self-center">
									      	 <i class="fas fa-briefcase mr-2" style="position: relative; top: -1px;"></i>
									      	 <span style="font-size: 18px;">Sesión {{$loop->iteration}}</span> <span class="font-weight-bold mx-2" style="width: .5px; position: relative; top: -2px;">|</span> @if($session->type->name == "Presencial")
									<span style="font-size: 18px;" class="font-weight-bold">{{ $session->type->name }}</span> <i class="fas fa-user-circle ml-2 text-success" style="font-size: 19px;" title="Presencial"></i>
									@elseif($session->type->name == "Virtual")
									<span style="font-size: 18px;" class="font-weight-bold">{{ $session->type->name }}</span> <i class="fas fa-desktop text-primary ml-2" style="font-size: 16px;" title="Virtual"></i>
									@else
									{{ '' }}
									@endif
									      	</div>
											<div class="quantity_temas text-right col-md-4 align-self-center">
												<span class="badge badge-info p-2" style="border: 2px solid black;">
									      		<span class="font-weight-bold" style="font-size: 14px;">{{$session->themes->count()}}</span>
									      	</span>
									      	<span class="font-weight-bold text-uppercase">Tema(s)</span>
											</div>
								      	</div>

								      	<div class="linea_2_sesion row">
									      	<div class="title_sesion col-md-7 align-self-center">
									      		<span style="text-transform: capitalize; font-size: 19px;">{{$session->name}}</span>
									      	</div>

										    <!-- Aquí se está creando el triangulo que apunta abajo -->
											<div class="contenedor_triangulo col-md-5 align-self-center text-right">
												<i class="icono_triangulo fas fa-caret-down fa-3x" style="font-size: 35px;">

												</i>
											</div>
										</div>
							      	</h5>
							    </div>
		                        <!-- ******************* Fin de barra principal *****************-->
						        <!-- **************** Inicio de despegable **********************-->
							    <div id="collapse_{{$session->id}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion_{{$session->id}}">
							      <div class="card-body py-2 px-3">
							    <!-- *********** Inicio de primer tema ******************-->
							    <div class="container-fluid">
							    	<div class="row no-gutters">
							    		<div class="col-md-12">
							    			@if($session->themes->count()>0)
							    			<table class="table table-hover table-stripped table-bordered-w-100 text-center">
							    				<thead class="bg-dark text-white">
							    					<tr>
							    						<th scope="col" class="font-weight-bold px-0" style="font-size: 14px; min-width: 170px; vertical-align: middle;">Tema</th>
							    						<th scope="col" class="font-weight-bold" style="font-size: 14px; min-width: 105px; vertical-align: middle;">Status</th>
							    						<th scope="col" class="font-weight-bold" style="font-size: 14px; min-width: 105px; vertical-align: middle;">Nota</th>
							    					</tr>
							    				</thead>
							    				<tbody>
							    					@foreach($GradeCourseThemes[$session->id] as $theme)
							    					<tr>
							    						<td class="text-left title_tema pr-0 pl-2" style="font-size: 13.5px; vertical-align: middle;">
							    							<a href="{{route('user.courses.theme-detail', $theme->id)}}" class="text-primary">
									              			<span style="text-transform: capitalize;">{{$theme->name}}</span>
									                </a></td>
							    						<td scope="col" class="status-theme" style="font-size: 13.5px; vertical-align: middle;">
							    							<span class="badge badge-{{$theme->status=='Por Comenzar'?'secondary':($theme->status=='En Proceso'?'primary':'success')}}">{{$theme->status}}</span>
							    						</td>
							    						<td scope="col" class="time_tema" style="font-size: 13.5px; vertical-align: middle;">
							    							<span class="badge badge-info">{{$theme->status=='En Proceso' || $theme->status=='Por Comenzar' || $theme->score=='' || $theme->score==null ? '' :'Nota: '.$theme->score}}</span>
							    						</td>
							    					</tr>
							    					@endforeach

							    				</tbody>
							    			</table>
							    			@else
							    				<div class="alert alert-info my-1 font-weight-bold" role="alert">
												  Aún no hay temas disponibles !!!
												</div>

							    			@endif
							    		</div>
							    	</div>
							    </div>
							    <!-- *********** Fin de primer tema ******************-->
									</div>
							    </div>

						        <!-- *************** Fin de despegable ****************-->
							</div>
						</div>
				</div>
	  			<!-- **********************   Fin de PRIMERA SESION     *************************-->
	  			@endforeach
	  			</div>
	  			@else
	  			<div class="alert alert-info text-uppercase text-center mt-5" role="alert">
				  aún no hay sesiones disponibles !!!
				</div>
	  			@endif
	  		</div>
	  	</div>
	<!-- **********************************   FIN DE SESIONES *************************************-->


	<!-- **********************************   EXÁMENES  *****************************************-->
		<div class="tab-pane fade" id="nav-examen" role="tabpanel" aria-labelledby="nav-examen-tab">
			<br>
			<div class ="container-fluid py-0 parent_examenes" style="max-height: 350px; overflow-y: auto; overflow-x: hidden;">
				<div class="row justify-content-between">
				@foreach($course->instance->exams as $exam)
				<!-- *********************    Inicio de PRIMER EXAMEN    **********************-->
				<div class ="col-md-6 container_examen px-3 py-2 rounded mb-3" style="max-width: 49.3%;">
					<div class="text_examen row mb-2">
						<div class="col-md-auto pr-0 align-self-center">
							<i class="fas fa-file-alt mr-2"></i><span style="font-size: 18px;">Examen <i class="fas fa-sort-numeric-up mr-2"></i><i class="badge badge-info" style="border-radius: 15px; font-size: 15px; border: 1.5px solid black;">{{$loop->iteration}}</i> :</span>
						</div>
						<div class="title_examen col-md-8 align-self-center">
							<span class="text-uppercase font-weight-bold">{{$exam->name}}</span>
						</div>
					</div>
					<div class="linea_1_examen row">
						<div class="time_examen col-md-auto align-self-center">
							Tiempo: {{$exam->duration}} minutos
						</div>
						<div class="container_nota col-md-6 align-self-center text-right pr-3">
							<span class="nota_examen badge badge-info p-2">
								<span style="font-size: 16px;">{{\App\SubmittedForm::where('entity_name', ENTITY_COURSE_EXAM)->where('entity_id', $exam->id)->where('student_id', auth()->guard('web')->user()->id)->first() ? \App\SubmittedForm::where('entity_name', ENTITY_COURSE_EXAM)->where('entity_id', $exam->id)->where('student_id', auth()->guard('web')->user()->id)->first()->answers->sum('final_score') : 0}}</span>

							</span>
							<div class="text_nota_obtenida pr-2 mt-1">
								Nota obtenida:
							</div>
						</div>
						<div class="button_container_examen col-md-2 align-self-center text-right pr-3">
							@if($form = \App\SubmittedForm::where('entity_name', ENTITY_COURSE_EXAM)->where('entity_id', $exam->id)->where('student_id', auth()->guard('web')->user()->id)->first())
								@if(!$form->evaluated)
								<button class="btn btn-primary btn-sm roudend" title="Esperando resultados">
									<i class="fas fa-pause-circle"></i>
								</button>
								@else
								<a href="{{route('user.questions.result-review', ['entity_name' => ENTITY_COURSE_EXAM, 'entity_id' => $exam->id])}}" class="btn btn-success btn-sm rounded" title="Ver resultados"><i class="fas fa-eye"></i></a>
								@endif
							@else
								<a href="{{route('user.questions.form', ['entity_name' => ENTITY_COURSE_EXAM, 'entity_id' => $exam->id])}}" class="btn btn-secondary button_examen btn-sm rounded" title="Realizar examen">
									<i class="fas fa-pen-square"></i>
								</a>

							@endif
						</div>
					</div>
				</div>
				<!-- *********************    Fin de PRIMER EXAMEN    **********************-->
				@endforeach
			</div>
		</div>
	</div>
	<!-- ***********************   FIN DE EXÁMENES  *****************************************-->

	<!-- **********************************   ACTIVIDADES  **************************************-->
		<div class="tab-pane fade" id="nav-actividad" role="tabpanel" aria-labelledby="nav-actividad-tab">
			<br>
			<div class ="container-fluid py-0 parent_actividades" style="max-height: 350px; overflow-x: hidden; overflow-y: auto;">
				<div class="row justify-content-between">
				@foreach($course->instance->activities as $activity)
				<!-- *********************    Inicio de PRIMERA ACTIVIDAD    *******************-->
				<div class ="col-md-6 container_actividad pl-3 pr-2 py-2 rounded mb-3" style="max-width: 49.3%;">
					<div class="text_actividad row mb-2">
						<div class="col-md-auto pr-0 align-self-center">
							<i class="fas fa-chart-line mr-2"></i><span style="font-size: 18px;">Actividad <i class="fas fa-sort-numeric-up mr-2"></i><i class="badge badge-info" style="border-radius: 15px; font-size: 15px; border: 1.5px solid black;">{{$loop->iteration}}</i> :</span>
						</div>
						<div class="title_examen col-md-8 pr-0 align-self-center">
							<span class="text-uppercase font-weight-bold">{{$activity->name}}</span>
						</div>
					</div>
					<div class="linea_1_actividad row">
						<div class="button_container_actividad col-md-12 align-self-center float-right">
							<div class="row">
							@if($form = \App\SubmittedForm::where('entity_name', ENTITY_ACTIVITY)->where('entity_id', $activity->id)->where('student_id', auth()->guard('web')->user()->id)->first())

								@if(!$form->evaluated)
								<div class="col-md-6 align-self-center text-right">
									<button class="btn btn-primary btn-sm roudend" title="Esperando resultados">
									<i class="fas fa-pause-circle"></i>
									</button>
								</div>
								<div class="col-md-6 align-self-center">
									<a href="#">
										<button class=" btn btn-primary button_actividad btn-sm" disabled title="Ya ha realizado la actividad" style="cursor: not-allowed;">Realizar Actividad</button>
									</a>
								</div>
								@else
								<div class="col-md-6 align-self-center text-right">
									<span class="badge badge-success p-2"><span style="font-size: 14px;">15/20</span></span>
								</div>
								<div class="col-md-6 align-self-center">
									<a href="{{route('user.questions.result-review', ['entity_name' => ENTITY_ACTIVITY, 'entity_id' => $activity->id])}}" class="btn btn-success rounded" title="Ver resultados"><i class="fas fa-eye"></i></a>
								</div>
								@endif
							@else
							<div class="col-md-6 align-self-center text-right">
								<span class="badge badge-secondary rounded">por comenzar</span>
							</div>
							<div class="col-md-6 align-self-center">
								<a href="{{route('user.questions.form', ['entity_name' => ENTITY_ACTIVITY, 'entity_id' => $activity->id])}}">
									<button class="button_actividad btn btn-seconday rounded" title="Realizar actividad"><i class="fas fa-pen-square"></i></button>
								</a>
							</div>
							@endif
							</div>
						</div>
					</div>
				</div>
				<!-- *********************    Fin de PRIMER ACTIVIDAD    **********************-->
				@endforeach
				</div>
			</div>
		</div>
	<!-- ************************   FIN DE ACTIVIDADES  *****************************************-->

	<!-- **********************************  VER NOTAS  **************************************** -->

	<div class="tab-pane fade" id="nav-notas" role="tabpanel" aria-labelledby="nav-notas-tab">
		<br>
		<div class="container-fluid py-0 parent_notas" style="overflow-y: hidden; overflow-x: hidden;">
			<div class="row no-gutters d-flex justify-content-between mt-3 mb-3">
				<div class="col-md-1 align-self-center">
					<a href="" class="btn btn-success" title="Descargar reporte"><i class="fas fa-file-excel"></i></a>
				</div>
				<div class="col-md-10 align-self-center">
					<div class="row no-gutters d-flex justify-content-between">
						<div class="col-3">
							<i class="fas fa-circle text-info"></i>
							<span class="pl-3">Sesiones</span>
						</div>
						<div class="col-3">
							<i class="fas fa-circle text-warning"></i>
							<span class="pl-3">Actividades</span>
						</div>
						<div class="col-3">
							<i class="fas fa-circle text-danger"></i>
							<span class="pl-3">Exámenes</span>
						</div>
					</div>
				</div>
			</div>
			<div class="container_tablas justify-content-center">
				<table class="table table-responsive table-bordered text-center table-hover table-striped w100" style="width:100%; max-width: 100%;max-height: 395px;">
					<thead class="thead-dark">
						<tr>
							<th scope="col" class="font-weight-bold px-0" style="font-size: 16px; min-width: 170px; vertical-align: middle;">Nombre Completo</th>
							<th scope="col" class="font-weight-bold" style="font-size: 16px; min-width: 105px; vertical-align: middle;">DNI</th>

							@foreach($allsesiones as $unasesion)
							<th scope="col" class="font-weight-bold text-info w-100" style="font-size: 16px; min-width: 150px; max-width: 170px; vertical-align: middle;">{{$unasesion->name}}</th>
							@endforeach

							@foreach($allactivities as $oneactivity)
							<th scope="col" class="font-weight-bold text-warning w-100" style="font-size: 16px; min-width: 150px; max-width: 170px; vertical-align: middle;">{{$oneactivity->name}}</th>
							@endforeach

							@foreach($allexams as $unexam)
							<th scope="col" class="font-weight-bold text-danger w-100" style="font-size: 16px; min-width: 150px; max-width: 170px; vertical-align: middle;">{{$unexam->name}}</th>
							@endforeach

						</tr>
					</thead>
					<tbody>
						<!-- Inicio de primer colaborador -->

						<tr>
							<td class="text-left pr-0 pl-2" style="font-size: 15px; vertical-align: middle;">{{$student->name.' '.$student->last_name}}</td>
							<td style="font-size: 15px; vertical-align: middle;">{{$student->dni}}</td>

							<td scope="col" style="font-size: 15px; vertical-align: middle;"></td>

							<td scope="col" style="font-size: 15px; vertical-align: middle;"></td>

							<td scope="col" style="font-size: 15px; vertical-align: middle;"></td>

						</tr>

						<!-- Fin de primer colaborador -->
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="tab-pane fade" id="nav-asistencia" role="tabpanel" aria-labelledby="nav-asistencia-tab">
		<br>
		<div class="container-fluid py-0 parent_asistencia px-1" style="overflow-x: hidden; overflow-y: hidden;">
			<div class="row no-gutters d-flex justify-content-between mt-3 mb-3">
				<div class="col-md-1 align-self-center">
					<a href="" class="btn btn-success" title="Descargar reporte"><i class="fas fa-file-excel"></i></a>
				</div>
				<div class="col-md-10 align-self-center">
					<div class="row no-gutters d-flex justify-content-around">
						<div class="col-2">
							<i class="fas fa-clipboard-check text-success"></i>
							<span class="pl-2">Asististe</span>
						</div>
						<div class="col-3">
							<i class="fas fa-calendar-times text-danger"></i>
							<span class="pl-2">No Asististe</span>
						</div>
						<div class="col-2">
							<i class="fas fa-desktop text-primary"></i>
							<span class="pl-2">Sesión Virtual</span>
						</div>
						<div class="col-4">
							<i class="fas fa-user-clock text-secondary"></i>
						<span class="pl-2">Falta que tomen asistencia</span>
						</div>
					</div>
				</div>
			</div>
			<div class="container_tablas">
				<table class="table table-responsive table-bordered text-center table-hover table-striped" style="width:100%; max-width: 100%;max-height: 395px;">
					<thead class="thead-dark">
						<tr>
							<th scope="col" class="font-weight-bold px-0" style="font-size: 17px; min-width: 170px; vertical-align: middle;">Nombre Completo</th>
							<th scope="col" class="font-weight-bold" style="font-size: 17px; min-width: 135px; vertical-align: middle;">DNI</th>
   							@foreach($allsesiones as $unasesion)
							<th scope="col" class="font-weight-bold w-100" style="font-size: 17px; min-width: 135px; max-width: 170px; vertical-align: middle;">{{$unasesion->name}}</th>
							@endforeach
						</tr>
					</thead>
					<tbody>
						<tr>
						<!-- Inicio de primer colaborador -->
						<td class="text-left pr-0 pl-2" style="font-size: 16px; vertical-align: middle;">{{$student->name.' '.$student->last_name}}</td>
						<td style="font-size: 16px; vertical-align: middle;">{{$student->dni}}</td>
						@foreach($allsesiones as $session)
						<td scope="col" style="font-size: 16px; vertical-align: middle;">
							@if($session->session_type_id == SESSION_FACE)
									        	@if($session->assistances()->whereHas('student', function($query) use ($student){
									        		$query->where('id', $student->id)->where('value', 1);
									        	})->count())
									        	<i class="fas fa-calendar-check text-success" style="font-size: 16px;" title="Asistió"></i>
									        	@elseif($session->assistances()->whereHas('student', function($query) use ($student){
									        		$query->where('id', $student->id)->where('value', 0);
									        	})->count())
									        	<i class="fas fa-calendar-times text-danger" style="font-size: 16px;" title="No asistió"></i>
									        	@else
									        	<i class="fas fa-user-clock text-secondary" style="font-size: 16px;" title="Falta tomar asistencia"></i>
									        	@endif
								        	@elseif($session->session_type_id == SESSION_VIRTUAL)
								        		<i class="fas fa-desktop text-primary" style="font-size: 16px;" title="Virtual"></i>
								        	@endif
								        	</td>
								        @endforeach
									</tr>
						<!-- Fin de primer colaborador -->

					</tbody>
				</table>
			</div>
		</div>
	</div>


	<div class="tab-pane fade" id="nav-certificados" role="tabpanel" aria-labelledby="nav-certificados-tab">
		<br>

		<div class="container py-0 parent_certificados px-1" style="overflow-x: hidden; overflow-y: hidden;">
			@if($allcertificados->count() > 0)
			<div class="container_tablas row" style="width: auto;">

				<table class="table table-responsive table-bordered text-center table-hover table-striped" style="width:auto; margin: 0 auto;">
					<thead class="thead-dark">
						<tr>
							<th scope="col" class="font-weight-bold px-0" style="font-size: 16px; min-width: 170px; vertical-align: middle;">Nombre Completo</th>
							<th scope="col" class="font-weight-bold" style="font-size: 16px; min-width: 135px; vertical-align: middle;">DNI</th>
							<th scope="col" class="font-weight-bold" style="font-size: 16px; min-width: 135px; vertical-align: middle;">Fecha de Emisión</th>
							<th scope="col" class="font-weight-bold" style="font-size: 16px; min-width: 135px; vertical-align: middle;"><i class="fas fa-certificate text-warning mr-3"></i><span>Título del certificado</span></th>
							<th scope="col" class="font-weight-bold" style="font-size: 16px; min-width: 135px; vertical-align: middle;">Descargar</th>
						</tr>
					</thead>
					<tbody>
						@foreach($allcertificados as $onecertificado)
						<tr>
							<td class="text-left pr-0 pl-2" style="font-size: 15px; vertical-align: middle;">{{$student->name.' '.$student->last_name}}</td>
							<td style="font-size: 15px; vertical-align: middle;">{{$student->dni}}</td>
							<td style="font-size: 15px; vertical-align: middle;">{{$onecertificado->created_at}}</td>
							<td style="font-size: 15px; vertical-align: middle;">{{$onecertificado->name}}</td>
							<td><a href="{{asset($onecertificado->attachment)}}" download class="d-inline-block m-0 mr-2 text-primary" title="Descargar certificado"><span class="fas fa-download"></span></a></td>
						</tr>
						@endforeach
					</tbody>
				</table>

			</div>
			@else
		<div class="alert alert-info text-center text-uppercase mt-5" role="alert">
		aún no obtienes ningún certificado !!!
		</div>
		@endif
		</div>
	</div>

	<!-- **************************** FIN DE VER NOTAS **************************************** -->

</div>



@section('extra_scripts')
<script type="text/javascript">
	$("{{$target}}").click();
	$('.collapse').on('show.bs.collapse', function () {
		$(this).siblings('.card-header').find('.icono_triangulo').removeClass('fa-caret-down').addClass('fa-caret-up');
		});

		$('.collapse').on('hide.bs.collapse', function () {
			$(this).siblings('.card-header').find('.icono_triangulo').removeClass('fa-caret-up').addClass('fa-caret-down');
		});
		$('.button_examen').on('click',function(e){
			e.preventDefault();
			let href = $(this).attr("href");
			swal({
		      title: "Recuerda que tienes un tiempo determinado",
		      text: "",
		      icon: "warning",
		      buttons: true,
		      dangerMode: true,
		    })
		    .then((willDelete) => {
		        console.log(willDelete)
		      if (willDelete) {
		        location.href=href;
		      }
		    });
		})
</script>

@stop

</body>
</html>

@stop
