@extends('main.base_main')

 
@section('extra_css')
	<link rel="stylesheet" type="text/css" href="{{asset('css/coordinador_empresa/style_curso_ejemplo.css')}}">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
	<style>
		
		.footer{
			display: none;
		}

	</style>
@stop

@section('home_url')
{{route('company.courses.index')}}
@stop

@section('titulo')
	Nombre de Curso
@stop


@section('logout_url')
	{{route('company.auth.logout')}}
@stop

@section('contenido_web')

<!--///////////////////////////// CONTENIDO INTRODUCTORIO ////////////////////////////////////-->
<div class="intro px-5">
	

	<div class="informacion">
		<div class="row">
            <div class="col-sm-6 col-md-5">
            	@if($course->intro_type_id == MULTIMEDIA_TYPE_VIDEO_EMBED)
            	<!-- Esto se muestra en caso de que sea un video -->
                <div class="video_introduccion text-center p-2">
                    <iframe src="{{$course->video_intro}}" allowfullscreen frameborder="0" class="rounded w-100"></iframe>
                </div>
                <br>
                <!-- Esto se muestra en caso de que sea un video -->
                @elseif($course->intro_type_id == MULTIMEDIA_TYPE_IMAGE)
                <!-- Esto se muestra en caso de que sea una imagen --> 
                <div class="imagen_introduccion text-center p-2">
                    <img src="{{asset($course->video_intro)}}" class="rounded w-100">
                </div>
                <!-- Esto se muestra en caso de que sea una imagen -->
                @endif
            </div>
            <div class="col-sm-6 col-md-7 pr-5 pt-3">
            	<p class="text-uppercase font-weight-bold">{{$course->name}}</p>

            	<p class="text-capitalize"><i class="fas fa-chalkboard-teacher mr-2"></i>Docente: <strong>{{$course->teacher->full_name}}</strong></p>
            	<i class="far fa-file-alt mr-2"></i>Descripción : <br>
            	{{$course->teacher->description}}
			  	<div class="progress mt-3">
					
					<div class="progress-bar progress-bar-striped progress-bar-success active" role="progressbar" style="width: {{$course->progress}}%;" aria-valuenow="{{$course->progress}}" aria-valuemin="0" aria-valuemax="100" style="position: absolute;text-align: center;left: 50%;">{{$course->progress}}% completado</div>
				</div>
            </div>
        </div>    	
	</div>

	
</div>
<!--/////////////////////////////////// TABS DE NAVEGACIÓN //////////////////////////////////////-->
<div class="parent_tabs mt-3 mb-5">
	
	<nav>
		<div class="nav nav-tabs" id="nav-tab" role="tablist">
			<a class="nav-item nav-link active" id="nav-sesion-tab" data-toggle="tab" href="#nav-sesion" role="tab" aria-controls="nav-home" aria-selected="true">
			Sesiones
			</a>
			<a class="nav-item nav-link" id="nav-examen-tab" data-toggle="tab" href="#nav-examen" role="tab" aria-controls="nav-examen" aria-selected="false">
			Exámenes
			</a>
			<a class="nav-item nav-link" id="nav-actividad-tab" data-toggle="tab" href="#nav-actividad" role="tab" aria-controls="nav-actividad" aria-selected="false">
			Actividades
			</a>
			<a class="nav-item nav-link" id="nav-nota-tab" data-toggle="tab" href="#nav-nota" role="tab" aria-controls="nav-nota" aria-selected="false">
			Notas
			</a>
			<a class="nav-item nav-link" id="nav-asistencia-tab" data-toggle="tab" href="#nav-asistencia" role="tab" aria-controls="nav-asistencia" aria-selected="false">
			Asistencia
			</a>
			<a class="nav-item nav-link" id="nav-colaborador-tab" data-toggle="tab" href="#nav-colaborador" role="tab" aria-controls="nav-colaborador" aria-selected="false">
			Colaboradores
			</a>
			<a class="nav-item nav-link" id="nav-certificado-tab" data-toggle="tab" href="#nav-certificado" role="tab" aria-controls="nav-colaborador" aria-selected="false">
			Certificados
			</a>
		</div>
	</nav>

	<!-- ************************** CONTENIDO DE TABS ******************************-->
	<div class="tab-content px-4" id="nav-tabContent">
	<!-- **********************************   SESIONES  *******************************************-->
		<div class="tab-pane fade show active" id="nav-sesion" role="tabpanel" aria-labelledby="nav-sesion-tab">
			<br>
	  		<div class ="container-fluid parent_sesiones" style="max-height: 350px; overflow-y: auto; overflow-x: hidden;">
	  			@if($sessions->count() > 0)
	  			<div class="row jusify-content-between">
	  			@foreach($sessions as $session)
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
							    						<th scope="col" class="font-weight-bold px-0" style="font-size: 15px; min-width: 170px; vertical-align: middle;">Tema</th>
							    						<th scope="col" class="font-weight-bold" style="font-size: 15px; min-width: 105px; vertical-align: middle;">Status</th>
							    						<th scope="col" class="font-weight-bold" style="font-size: 15px; min-width: 105px; vertical-align: middle;">Ingresar</th>
							    					</tr>
							    				</thead>
							    				<tbody>
							    					
							    					@foreach($session->themes as $theme)
							    					<tr>
							    						<td class="text-left title_tema pr-0 pl-2" style="font-size: 14px; vertical-align: middle;">
							    							
									              			<span style="text-transform: capitalize;">{{$theme->name}}</span>
									                </td>
							    						<td scope="col" class="status-theme" style="font-size: 14px; vertical-align: middle;">
							    							<span class="badge badge-{{$theme->status=='Por Comenzar'?'secondary':($theme->status=='En Proceso'?'primary':'success')}}">{{$theme->status}}</span>
							    						</td>
							    						<td scope="col" class="time_tema" style="font-size: 14px; vertical-align: middle;">
							    							<a class="btn btn-success button_editar_curso" data-id="" href="{{route('company.themes.detail', $theme->id)}}" title="Ver tema"><i class="fas fa-sign-in-alt"></i></a></span>
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
				@foreach($exams as $exam)
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
			<div class ="container-fluid px-3 py-0 parent_actividades" style="max-height: 350px; overflow-x: hidden; overflow-y: auto;">
				<div class="row justify-content-between">
				@foreach($activities as $activity)
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
				</div>
				<!-- *********************    Fin de PRIMER ACTIVIDAD    **********************-->
				@endforeach
				</div>
			</div>
		</div>

	<!-- ************************   FIN DE ACTIVIDADES  *****************************************-->
	<!-- **********************************   NOTAS  **************************************-->
		<div class="tab-pane fade" id="nav-nota" role="tabpanel" aria-labelledby="nav-nota-tab">
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
							
							@foreach($sessions as $session)
							<th scope="col" class="font-weight-bold text-info w-100" style="font-size: 16px; min-width: 150px; max-width: 170px; vertical-align: middle;">{{$session->name}}</th>
							@endforeach
							
							@foreach($activities as $activity)
							<th scope="col" class="font-weight-bold text-warning w-100" style="font-size: 16px; min-width: 150px; max-width: 170px; vertical-align: middle;">{{$activity->name}}</th>
							@endforeach	

							@foreach($exams as $exam)					
							<th scope="col" class="font-weight-bold text-danger w-100" style="font-size: 16px; min-width: 150px; max-width: 170px; vertical-align: middle;">{{$exam->name}}</th>
							@endforeach
											        
						</tr>
					</thead>
					<tbody>
						<!-- Inicio de primer colaborador -->
						@foreach($students as $student)
						<tr>
							<td class="text-left pr-0 pl-2" style="font-size: 15px; vertical-align: middle;">{{$student->name.' '.$student->last_name}}</td>
							<td style="font-size: 15px; vertical-align: middle;">{{$student->dni}}</td>
							
							<td scope="col" style="font-size: 15px; vertical-align: middle;"></td>
							
							<td scope="col" style="font-size: 15px; vertical-align: middle;"></td>
							
							<td scope="col" style="font-size: 15px; vertical-align: middle;"></td>
							
						</tr>
						@endforeach
						
						<!-- Fin de primer colaborador -->
					</tbody>
				</table>
			</div>	
		</div>
	</div>

	<!-- ************************   FIN DE NOTAS  *****************************************-->
		<!-- **********************************   ASISTENCIA  **************************************-->
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
							<span class="pl-2">Asistió</span>
						</div>
						<div class="col-3">
							<i class="fas fa-calendar-times text-danger"></i>
							<span class="pl-2">No Asistió</span>
						</div>
						<div class="col-2">
							<i class="fas fa-desktop text-primary"></i>
							<span class="pl-2">Sesión Virtual</span>
						</div>
						<div class="col-4">
							<i class="fas fa-user-clock text-secondary"></i>
						<span class="pl-2">Falta tomar asistencia</span>
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
   							@foreach($sessions as $session)
							<th scope="col" class="font-weight-bold w-100" style="font-size: 17px; min-width: 135px; max-width: 170px; vertical-align: middle;">{{$session->name}}</th>
							@endforeach
						</tr>
					</thead>
					<tbody>
						@foreach($students as $student)
						<tr>			
						<!-- Inicio de primer colaborador -->
						<td class="text-left pr-0 pl-2" style="font-size: 16px; vertical-align: middle;">{{$student->name.' '.$student->last_name}}</td>
						<td style="font-size: 16px; vertical-align: middle;">{{$student->dni}}</td>
						@foreach($sessions as $session)
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
									@endforeach
						<!-- Fin de primer colaborador -->
								   
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- ************************   FIN DE ASISTENCIA  *****************************************-->


	<!-- **********************************   COLABORADORES  **************************************-->
		<div class="tab-pane fade" id="nav-colaborador" role="tabpanel" aria-labelledby="nav-colaborador-tab">
			<!-- ************************************** ALUMNOS *******************************************-->
			<div class="container alumnos_inscritos mt-5 py-3 px-5">
				<!--<div class="row select_alumno">
					<a href="#" data-target="#popup_select_alumno" data-toggle="modal"><span class="fas fa-user-plus"></span><span>Seleccionar alumnos</span></a>
				</div>-->
				<div class="row justify-content-center">
					<div class="col-md-6 add_alumno text-right">
						<button class="btn btn-success" data-target="#popup_add_alumno" data-toggle="modal"><span class="fas fa-user-plus mr-2"></span><span>Crear nuevo alumno</span></button>
					</div>
					<div class="col-md-6 select_alumno">
						<button class="btn btn-primary" data-target="#popup_select_alumno" data-toggle="modal"><span class="fas fa-mouse-pointer mr-2"></span><span>Seleccionar alumnos</span></button>
					</div>
				</div>
				<div class="row text_alumnos">
					<div class="col-sm-12 col-md-12 text_alumnos text-uppercase'font-weight-bold text-center">
						ALUMNOS INSCRITOS
					</div>
				</div>

				<div class="row justify-content-center">
					<div class="col-md-8">
						<table class="table table-responsive text-center mb-2 table-hover table-striped" style="margin: 0 auto;">
					<thead class="bg-dark text-white">
						<tr>
							<th scope="col" width="100%" class="font-weight-bold px-0" style="font-size: 16.5px;">Nombre Completo</th>
							<th scope="col" width="100%" class="font-weight-bold" style="font-size: 16.5px;">DNI</th>
							<th scope="col" width="100%" class="font-weight-bold" style="font-size: 16.5px;">E-mail</th>
						</tr>
					</thead>
					<tbody>
						@foreach($added_students as $student)
						<tr>
							<td class="text-left pr-0 pl-2" style="font-size: 15px;">{{$student->full_name}}</td>
							<td style="font-size: 15px;">{{$student->dni}}</td>
							<td style="font-size: 15px;">{{$student->personal_email}}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
					</div>
				</div>
			</div>
		</div>
	<!-- ************************   FIN DE COLABORADORES  *****************************************-->
		<div class="tab-pane fade" id="nav-certificado" role="tabpanel" aria-labelledby="nav-certificado-tab">
			<br>
			<!--<div class="container alumnos_inscritos mt-5 py-3 px-5">
				<div class="row no-gutters">
					<div class="col-md-6">
						<table class="table table-hover table-stripped w-100 text-center table-responsive">
							
						</table>
					</div>
				</div>
			</div>-->



			<div class="container py-0 px-1" style="overflow-x: hidden; overflow-y: hidden;">
			@if($allcertificados->count() > 0)
			<div class="container_tablas row" style="width: auto;">
				
				<table class="table table-responsive table-bordered text-center table-hover table-striped w-100" style="width:auto; margin: 0 auto;">
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
						@foreach($certificados as $certificado)
						
						@if($certificado->student->company_id == $valorId)
						<tr>
							<td class="text-left pr-0 pl-2" style="font-size: 15px; vertical-align: middle;">{{$certificado->student->name.' '.$certificado->student->last_name}}</td>
							<td style="font-size: 15px; vertical-align: middle;">{{ $certificado->student->dni }}</td>
							<td>{{ $certificado->created_at }}</td style="font-size: 15px; vertical-align: middle;">
							<td>{{ $certificado->name }}</td>
							<td style="font-size: 15px; vertical-align: middle;"><a href="{{asset($certificado->attachment)}}" download class="d-inline-block m-0 mr-2 text-primary" title="Descargar certificado"><span class="fas fa-download"></span></a></td>
						</tr>
						@endif
						
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



</div>
<!-- ************************   FIN DE TABS  *****************************************-->

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


<!-- *********************** INICIO POP-UP SELECT ALUMNO ************************* -->
<div class="modal fade" id="popup_select_alumno" tabindex="-1" role="dialog" aria-labelledby="popup_alumnoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="max-height: 560px">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Seleccionar Alumno</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body body_select_alumnos" style="overflow-y: auto;">


      	<div class="container-fluid container_alumnos">
			<div class="row row_alumnos">
				@foreach($students as $student)
				<!-- ********  Inicio de Alumno 1   **********-->
				<div class="col-sm-6 col-md-3 col-alumno">
					<div class="highlightbox_alumno {{$course->product->students->contains('id', $student->id) ? 'highlight_alumno' : ''}}">
			  			<input type="checkbox" value="{{$student->id}}" name="checkbox_alumno[]" id="alumno{{$student->id}}" data-id="{{$student->id}}" {{$course->product->students->contains('id', $student->id) ? 'checked' : ''}}><br>
			  			<label for="alumno{{$student->id}}" data-full_name="{{$student->full_name}}">
				  			<div class="box_alumno">
				  				<div class="box_alumno_top">
		    						<img src="{{asset($student->photo)}}" class="photo_alumno my-2" alt="image not available" onerror="this.onerror=null;this.src='/images/default/user.png';">
				  				</div>
				  				<div class="box_alumno_bottom">
					  				<p class="mb-1">{{$student->full_name}}<br>
					  					DNI: {{$student->dni}}
					  				</p>
				  				</div>
				  			</div>
			  			</label>
		  			</div>
		  		</div>
				<!-- ********  Fin de Alumno 1  **********-->
				@endforeach
			</div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="assign_students">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- *********************** FIN DE POP-UP SELECCIONAR ALUMNO ************************* -->
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

	//$('.fa-user-plus').click(function(){
	//	$(this).parents('.card-header').removeAttr('data-toggle');
	//});


 	$('.collapse').on('show.bs.collapse', function () {
		$(this).siblings('.card-header').find('.icono_triangulo').removeClass('fa-caret-down').addClass('fa-caret-up');
	});

	$('.collapse').on('hide.bs.collapse', function () {
		$(this).siblings('.card-header').find('.icono_triangulo').removeClass('fa-caret-up').addClass('fa-caret-down');
	});

//		var students_subscribed = {\App\Subscription::where('product_id', $course->product_id)->whereIn('student_id', $specific_business->company->students->pluck('id')->toArray())->count()};
//		var max_students = {$specific_business->products()->withPivot('max_students')->get()->find($course->product_id)->pivot->max_students};
//		if (students_subscribed >= max_students) {
//			$('#add-student').find('input').prop('disabled', true);
//			$('#btn-add-student').prop('type', 'button');
//		}

    var added_students = [];
    var add_highlight_alumno = 'highlight_alumno';

    $('input[name="checkbox_alumno[]"]:checked').map(function(){
        added_students.push(parseInt($(this).val()));
    });

    $('.row_alumnos').on('click', '.highlightbox_alumno', function(evt){
            evt.preventDefault();
            var id = $(this).find('input').data('id');

            if (!$(this).find('input').is(':checked')) {
                $(this).find('input').prop('checked', true);
                $(this).addClass(add_highlight_alumno);
                added_students.push(id);
                $('.added_alumnos').append('<div data-id="' + id + '"></div>');
                $('.added_alumnos').children().last().append('<span class="fas fa-user"></span>').append($(this).find('input').siblings('label').data('full_name'));
            } else {
                var i = added_students.indexOf(id);
                $(this).find('input').prop('checked', false);
                $(this).removeClass(add_highlight_alumno);
                added_students.splice(i,1);
                $('.added_alumnos').find('div[data-id="' + id + '"]').remove();
            }
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
                var template = $('<div class="col-sm-6 col-md-3 col-alumno"><div class="highlightbox_alumno"><input type="checkbox" value="x" name="checkbox_alumno[]" id="alumnox" data-id="x"><br><label for="alumnox" data-full_name="x"><div class="box_alumno"><div class="box_alumno_top"><img src="x" class="photo_docente"></div><div class="box_alumno_bottom"><p>x<br>DNI: x</p></div></div></label></div></div>');
                template.find('input').attr('value', data.id)
                                      .attr('id', 'alumno' + data.id)
                                      .attr('data-id', data.id);
                template.find('label').attr('for', 'alumno' + data.id)
                                      .attr('data-full_name', data.full_name);
                template.find('img').attr('src', '{{env("APP_URL")}}' + data.photo);
                template.find('.box_alumno_bottom').html('<p>' + data.full_name + '<br>DNI: ' + data.dni + '</p>');

                $('.row_alumnos').append(template);
                $('#popup_add_alumno').modal('toggle');
                window.location.href = window.location.pathname + window.location.search + window.location.hash;
            }
        });

    });


    $('#assign_students').click(function(e){

        e.preventDefault();
        //added_students = added_students.length > 0 ? added_students : [""];
        var students = $('input[name="checkbox_alumno[]"]:checked').val();

        $.ajax({
            url: "{{route('company.courses.edit', request()->route('id'))}}",
            type: "POST",
            data: {
                "students": added_students,
                "_token" : "{{csrf_token()}}"
            }
        }).done(function(data){
            $('#popup_select_alumno').modal('toggle');
        }).fail(function(data){
        	alert(data.responseJSON.students.toString());
        });
        window.location.href = window.location.pathname + window.location.search + window.location.hash;
    });

</script>

@stop