@extends('main.base_main')
@section('extra_css')
	<link rel="stylesheet" type="text/css" href="{{asset('css/admin/style_crear_cursos.css')}}">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
	<style>
		.footer{
	position: absolute;
	bottom: 0;
}

.fa-table:hover{
	cursor: pointer;
}
	</style>
@stop

@section('titulo')
	CREAR CURSO
@stop

@section('home_url')
{{route('teacher.courses.index')}}
@stop

@section('logout_url')
    {{route('teacher.auth.logout')}}
@stop

@section('contenido_web')

<div class="container-fluid container_crear_curso">
	<div class="row info_curso">
		<div class="col-sm-12 col-md-12 input_curso">
		<form>
			<input type="text" name="nombre_curso" placeholder="NOMBRE DEL CURSO" id="name" value="{{$course->name or ''}}" readonly title="Este campo no se puede editar" style="cursor: not-allowed;">
			<input type="text" name="codigo_curso" placeholder="CÓDIGO DEL CURSO" id="code" value="{{$course->product->code}}" readonly title="Este campo no se puede editar" style="cursor: not-allowed;">
		</form>
		</div>
	</div>


	<div class="row">
		<div class="col-sm-12 col-md-12 content_curso">
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item">
			    	<a class="nav-link active" id="intro-tab" data-toggle="tab" href="#intro" role="tab" aria-controls="intro" aria-selected="true">Introducción</a>
			    </li>
				<li class="nav-item">
			    	<a class="nav-link" id="sesion-tab" data-toggle="tab" href="#sesion" role="tab" aria-controls="sesion" aria-selected="true">Sesiones</a>
			    </li>
			    <li class="nav-item">
			    	<a class="nav-link" id="examenes-tab" data-toggle="tab" href="#examenes" role="tab" aria-controls="examenes" aria-selected="false">Exámenes</a>
			    </li>
			    <li class="nav-item">
			    	<a class="nav-link" id="actividades-tab" data-toggle="tab" href="#actividades" role="tab" aria-controls="actividades" aria-selected="false">Actividades</a>
			    </li>
			    <li class="nav-item">
			    	<a class="nav-link" id="notas-tab" data-toggle="tab" href="#notas" role="tab" aria-controls="notas" aria-selected="false">Notas</a>
			    </li>
			    <li class="nav-item">
			    	<a class="nav-link" id="asistencia-tab" data-toggle="tab" href="#asistencia" role="tab" aria-controls="asistencia" aria-selected="false">Asistencia</a>
			    </li>
			</ul>
			<div class="tab-content" id="myTabContent">

				<!--///////////////////////////////// TAB DE INTRODUCIÓN //////////////////////////////////-->
				<!--///////////////////////////////////////////////////////////////////////////////////////-->
				<div class="tab-pane fade show active" id="intro" role="tabpanel" aria-labelledby="intro-tab">
					<div class="container_introduccion">
						<div class="upload_intro">
						<form method="post" enctype="multipart/form-data" action="{{route('teacher.courses.edit', request()->route('id'))}}">
						{!! csrf_field() !!}
							<!-- //////////////   SELECCIONAR VIDEO O IMAGEN   //////////////// -->
							<div class="row">
								<div class="col-sm-12 col-md-12 select_type">
									<h5>Contenido introductorio del curso</h5>
									<select onchange="type_selection(this)" id="selection_made" name="type" class="my-3">
										<option selected="true" disabled="disabled">Selecciona el tipo de contenido</option>
										@foreach($multimedia_types as $type)
										<option value="{{$type->id}}">{{$type->name}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<!-- //////////////   INICIO DE GUARDAR VIDEO   //////////////// -->
							<div class="row" style="display: none" id="add_video">
								<div class="col-sm-12 col-md-12">
									<div class="row upload_archivo">
											<div class="col-sm-12 col-md-12 ">
												<div  class="row upload_text">
													<div class="col-sm-6 col-md-12 title_intro">
														<div class="row no-gutters">
															<div class="col-md-5 align-self-center">
																<input type="text" name="title_video" placeholder="Ingresa el título del video" value="{{$course->title_intro}}" class="w-100">
															</div>
															<div class="col-md-3 align-self-center">
																<button type="submit" class="btn btn-secondary mt-0 ml-3 float-left">Guardar</button>
															</div>
														</div>
														<div class="row mt-3 no-gutters">
															<div class="col-5 align-self-center">
															@if($course->intro_type_id == '2')
															<input type="url" class="w-100" name="link_video" placeholder="Ingresa el link del video" value="{{$course->video_intro}}">
															@else
															<input type="url" class="w-100" name="link_video" placeholder="Ingresa el link del video">
															@endif
															</div>
															<div class="col-md-3 pl-3 float-left align-self-center">
																<a data-toggle="modal" data-target="#instrucciones_subir_video" class="text-dark" title="Instrucciones" style="cursor: pointer; font-size: 20px;"><i class="fas fa-info-circle"></i></a>
															</div>
														</div>
													</div>
													<!--<div class="col-sm-6 col-md-6 upload_button_video">
														<button type="submit" class="btn btn-secondary float-right">Guardar</button>
													</div>-->
												</div>
											</div>
									</div>
								</div>
							</div>
							<!-- //////////////   FIN DE GUARDAR ARCHIVO   //////////////// -->
							<!-- //////////////   INICIO DE GUARDAR IMAGEN   //////////////// -->
							<div class="row" style="display: none" id="add_imagen">
								<div class="col-sm-12 col-md-12">
									<div class="row upload_archivo">
											<div class="col-sm-12 col-md-12 ">
												<form method="post" enctype="multipart/form-data" action="">
												{!! csrf_field() !!}
												<div  class="row upload_text">
													<div class="col-sm-6 col-md-5 align-self-center title_intro">
														<input type="text" name="title_imagen" placeholder="Ingresa el título de la imagen" value="{{$course->title_intro}}" class="w-100">
													</div>
													<div class="col-sm-6 col-md-8 align-self-center upload_button_video mt-2">
														@if($course->intro_type_id == '1')
														<div class="row no-gutters">
															<div class="col-6 align-self-center">
																<input type="file" id="video-image-ppt" name="uploaded_file" value="{{$course->video_intro}}">
															</div>
															<div class="col-6 align-self-center">
																<a data-toggle="modal" data-target="#img-introducctorio" class="text-success" title="Ver imagen"><i class="fas fa-check-circle mr-2"></i>Ya hay una imagen subida.</a>
															</div>
														</div>
														@else
														<input type="file" id="video-image-ppt" name="uploaded_file">
														@endif
													</div>
													<div class="col-sm-6 col-md-3 align-self-center mt-2">
														<button type="submit" class="btn btn-secondary mt-0">Guardar</button>
													</div>
												</div>
												</form>
											</div>
									</div>
								</div>
							</div>
							</form>
						</div>
						<!-- //////////////   FIN DE GUARDAR IMAGEN   //////////////// -->


						<!-- //////////////   DESCRIPCION DEL CURSO   //////////////// -->
						<h5>Descripción del curso</h5>
						<div class="row">
							<div class="col-sm-12 col-md-12 description_curso">
								<form>
									<textarea id="description" class="p-2" placeholder="Ingresa la descripcion del curso">{{$course->description}}</textarea>
								</form>
							</div>
						</div>

					</div>

				</div>


				<!--///////////////////////////////////// TAB DE SESIONES /////////////////////////////////-->
				<!--///////////////////////////////////////////////////////////////////////////////////////-->
				<div class="tab-pane fade" id="sesion" role="tabpanel" aria-labelledby="sesion-tab">

					<!-- ********* CREAR SESIONES DEL CURSO **********-->
					<a href="{{route('teacher.sessions.create', ['course_id' => $course->id])}}">
						<div class="container-fluid add_sesion">
							<div class="row">
								<div class="col-sm-12 col-md-12 text_crear_sesion">
									<span class="fas fa-plus-circle fa-2x"></span> <p>Agregar sesión</p>
								</div>
							</div>
						</div>
					</a>
					<br>
					<!-- ********* SESIONES YA CREADAS DEL CURSO **********-->
					<div class="container-fluid" style="max-height: 280px; overflow-y: auto;">
					<div class="row justify-content-between">
						@foreach($course->sessions as $session)
						<div class="col-6 container_sesion pl-3 mb-3 rounded" style="max-width: 49.3%;">
							<div class="row">
								<div class="col-sm-6 col-md-8 align-self-center">
								Sesión {{$loop->iteration}}
								@if($session->type->name == "Presencial")
								<span>| {{$session->type->name}} <a href="#" class="btn btn-success btn-sm ml-2 p-2" data-target="#sesion_{{$session->id}}" data-toggle="modal" title="Tomar asistencia"><i class="fas fa-user-plus"></i></a></span>
								@elseif($session->type->name == "Virtual")
								<span>| {{$session->type->name}} <button class="btn btn-primary btn-sm ml-2 p-2" title="Virtual" readonly><i class="fas fa-desktop"></i></button></span>
								@endif
								<br>
								{{$session->name}}
								</div>
								<div class="col-sm-3 text-center pr-0 col-md-3 align-self-center">
									<a href="{{route('teacher.sessions.edit', $session->id)}}" class="btn btn-secondary mt-0">Ingresar</a>
								</div>
								<div class="col-sm-3 text-center p-0 col-md-1 align-self-center delete_column">
									<a href="#" data-id="{{$session->id}}" class=" text-danger delete_sesion" title="Eliminar sesión"><span class="fas fa-trash-alt delete_tema"></span></a>
								</div>
							</div>

						</div>
						@endforeach
					</div>

			   	 	</div>
				</div>


				<!--///////////////////////////////////// TAB DE EXAMENES /////////////////////////////////-->
				<!--///////////////////////////////////////////////////////////////////////////////////////-->
				<div class="tab-pane fade" id="examenes" role="tabpanel" aria-labelledby="examenes-tab">
					<div class="container_examenes py-2 px-3" style="max-height: 423px;">

						<div class="row">
							<div class="col-sm-6 col-md-6 pl-1 added_examen">
								<h5 class="mb-2 py-1 pl-2">Exámenes Agregados</h5>
								<div class="container-fluid" style="max-height: 335px; overflow-y: auto;">
								@foreach($exams as $exam)
								<!-- Inicio de Examen agregado 1 -->
								<div class="row my-1">
									<div class="col-sm-7 align-self-center pr-0 title_examen">
										<a href="{{route('teacher.questions.create', ['entity_name' => ENTITY_COURSE_EXAM, 'entity_id' => $exam->id])}}" title="Ver examen" style="text-decoration: none;"><span class="fas fa-file-alt text-dark mr-1"></span> <span class="text-primary">{{$exam->name}}</span></a>
									</div>
									<div class="col sm-6 text-left pl-0 col-md-4 align-self-center">
										<span>Listado de Alumnos</span><i class="fas fa-table text-success ml-2" data-target="#popup_listado_{{ $exam->id }}" data-toggle="modal"></i>
									</div>
									<div class="col-sm-1 pr-2 align-self-center pt-0 delete_examen">
	                                    <a href="{{route('teacher.courses.exams.delete' ,$exam->id)}}" class="text-danger" title="Eliminar examen">
	                                        <span class="fas fa-trash-alt"></span>
	                                    </a>
									</div>
								</div>

								<!-- Fin de Examen agregado 1 -->
								@endforeach
								</div>
							</div>

							<div class="col-sm-6 col-md-6 container_add">
								<div class="row">
									<div class="col-sm-12 col-md-12 a new_examen">
										<h5 class="mb-2 py-1 pl-2">Agrega un nuevo examen</h5>
										<form method="post" action="{{route('teacher.courses.exams.create')}}">
                                            {!! csrf_field() !!}
                                            <input type="hidden" name="course_id" value="{{request()->route('id')}}">
											<input type="text" name="nombre_examen" placeholder="Título del examen" id="name_material" class="w-100">
                                            <button class="btn btn-secondary">Agregar preguntas</button>
										</form>
									</div>
								</div>
							</div>
						</div>

					</div>

				</div>

				@foreach($exams as $exam)
				<div class="modal fade" id="popup_listado_{{ $exam->id }}" tabindex="-1" role="dialog" aria-labelledby="popup_listado_{{ $exam->id }}" aria-hidden="true">
                        <!-- Para los tamaños del modal
                             .modal-lg : Grande
                             .modal.sm : Pequeño
                          -->
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="modal-title">Listado de alumnos del examen: <span class="font-weight-bold">{{ $exam->name }}</span></h6>
                                    <button class="close" data-dismiss="modal" aria-label="Cerrar">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="container-fluid">
                                        <div class="row no-gutters">
                                        	<table class="table table-hover table-stripped w-100 text-center">
                                        		<thead class="bg-dark text-white">
                                        			<tr>
                                        				<th scope="col" width="100%" class="font-weight-bold px-0" style="font-size: 16.5px;">Alumno</th>
                                        				<th scope="col" width="100%" class="font-weight-bold" style="font-size: 16.5px;">Status</th>
                                        			</tr>
                                        		</thead>
                                        		<tbody>
                                        			@foreach($exam->course->product->students as $student)
				                        			<tr data-id="{{$student->id}}">
				                        				<td class="text-left pr-0 pl-2" style="font-size: 15px;">{{$student->full_name}}</td>
				                        				<td style="font-size: 15px;">
																					<a href="{{route('teacher.questions.review', ['entity_name' => ENTITY_COURSE_EXAM, 'entity_id' => $exam->id, 'student_id' => $student->id])}}" title="Corregir" class="text-{{in_array(($student->id.'-'.$exam->id),$grade_course_exam)?'success':'danger'}}"><i class="fas fa-clipboard"></i></a>
																				</td>
				                        			</tr>
				                					@endforeach
				                					<!--tr>
				                						<td class="text-left pr-0 pl-2" style="font-size: 15px;">ESTO SOLO ES UNA PRUEBA</td>
				                						<td style="font-size: 15px;"><i class="fas fa-clipboard-check text-success" title="Corregido"></i></td>
				                					</tr-->
                                        		</tbody>
                                        	</table>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
					@endforeach

				<!--////////////////////////////////// TAB DE ACTIVIDADES /////////////////////////////////-->
				<!--///////////////////////////////////////////////////////////////////////////////////////-->
			<div class="tab-pane fade" id="actividades" role="tabpanel" aria-labelledby="actividades-tab">
					<div class="container_actividades py-2 px-3" style="max-height: 423px;">

						<div class="row">
							<div class="col-sm-6 col-md-6 pl-1 added_actividad">
								<h5 class="mb-2 py-1 pl-2">Actividades Agregadas</h5>
								<div class="container-fluid" style="max-height: 337px; overflow-y: auto;">
								@foreach($activities as $activity)
								<!-- Inicio de Examen agregado 1 -->

								<div class="row my-1">
									<div class="col-sm-7 align-self-center pr-0 title_actividad">
										<a href="{{route('teacher.questions.create', ['entity_name' => ENTITY_ACTIVITY, 'entity_id' => $activity->id])}}" title="Ver" style="text-decoration: none;"><span class="fas fa-file-alt text-dark mr-1"></span> <span class="text-primary">{{$activity->name}}</span></a>
									</div>
									<div class="col sm-6 text-left pl-0 col-md-4 align-self-center">
										<span>Listado de Alumnos</span><i class="fas fa-table text-success ml-2" data-target="#popup_listado_actividad_{{ $activity->id }}" data-toggle="modal"></i>
									</div>
									<div class="col-sm-1 pr-2 align-self-center pt-0 delete_actividad">
	                                    <a href="{{route('teacher.courses.activities.delete' ,$activity->id)}}" class="text-danger" title="Borrar actividad">
	                                        <span class="fas fa-trash-alt"></span>
	                                    </a>
									</div>
								</div>
								<!-- Fin de Examen agregado 1 -->
								@endforeach
								</div>
							</div>

							<div class="col-sm-6 col-md-6 container_add">
								<div class="row">
									<div class="col-sm-12 col-md-12 new_actividad">
										<h5 class="mb-2 py-1 pl-2">Agrega una nueva Actividad</h5>
										<form method="post" action="{{route('teacher.courses.activities.create')}}">
                                            {!! csrf_field() !!}
                                            <input type="hidden" name="course_id" value="{{request()->route('id')}}">
											<input type="text" name="nombre_actividad" placeholder="Título de la actividad" id="name_material" class="w-100">
                                            <button class="btn btn-secondary">Agregar preguntas</button>
										</form>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
					@foreach($activities as $activity)
				<div class="modal fade" id="popup_listado_actividad_{{ $activity->id }}" tabindex="-1" role="dialog" aria-labelledby="popup_listado_actividad_{{ $activity->id }}" aria-hidden="true">
												<!-- Para los tamaños del modal
														 .modal-lg : Grande
														 .modal.sm : Pequeño
													-->
												<div class="modal-dialog modal-md">
														<div class="modal-content">
																<div class="modal-header">
																		<h6 class="modal-title">Listado de alumnos de la Actividad: <span class="font-weight-bold">{{ $activity->name }}</span></h6>
																		<button class="close" data-dismiss="modal" aria-label="Cerrar">
																				<span aria-hidden="true">&times;</span>
																		</button>
																</div>
																<div class="modal-body">
																		<div class="container-fluid">
																				<div class="row no-gutters">
																					<table class="table table-hover table-stripped w-100 text-center">
																						<thead class="bg-dark text-white">
																							<tr>
																								<th scope="col" width="100%" class="font-weight-bold px-0" style="font-size: 16.5px;">Alumno</th>
																								<th scope="col" width="100%" class="font-weight-bold" style="font-size: 16.5px;">Status</th>
																							</tr>
																						</thead>
																						<tbody>
																							@foreach($activity->course->product->students as $student)
																			<tr data-id="{{$student->id}}">
																				<td class="text-left pr-0 pl-2" style="font-size: 15px;">{{$student->full_name}}</td>
																				<td style="font-size: 15px;"><a href="{{route('teacher.questions.review', ['entity_name' => ENTITY_ACTIVITY, 'entity_id' => $activity->id, 'student_id' => $student->id])}}" title="Corregir" class="text-{{in_array(($student->id.'-'.$activity->id),$grade_course_activity)?'success':'danger'}}"><i class="fas fa-clipboard"></i></a></td>
																			</tr>
																	@endforeach
																	<tr>
																		<td class="text-left pr-0 pl-2" style="font-size: 15px;">ESTO SOLO ES UNA PRUEBA</td>
																		<td style="font-size: 15px;"><i class="fas fa-clipboard-check text-success" title="Corregido"></i></td>
																	</tr>
																						</tbody>
																					</table>
																				</div>
																		</div>
																</div>
																<div class="modal-footer">
																		<button class="btn btn-danger" data-dismiss="modal">Cerrar</button>
																</div>
														</div>
												</div>
										</div>
					@endforeach
				<!--//////////////////////////////////// TAB DE NOTAS /////////////////////////////////////-->
				<!--///////////////////////////////////////////////////////////////////////////////////////-->
				<div class="tab-pane fade" id="notas" role="tabpanel" aria-labelledby="notas-tab">
					<div class="container-fluid px-2 m-auto">
						<div class="row no-gutters d-flex justify-content-between mt-3 mb-3">
							<div class="col-md-1 align-self-center">
								<a href="" class="btn btn-success" title="Descargar reporte"><i class="fas fa-file-excel"></i></a>
							</div>
							<div class="col-md-10 align-self-center">
								<div class="row no-gutters d-flex justify-content-between">
									<div class="col-3">
										<i class="fas fa-circle text-info"></i><span class="pl-3">Sesiones</span>
									</div>
									<div class="col-3">
										<i class="fas fa-circle text-warning"></i><span class="pl-3">Actividades</span>
									</div>
									<div class="col-3">
										<i class="fas fa-circle text-danger"></i><span class="pl-3">Exámenes</span>
									</div>
								</div>
							</div>
						</div>
						<div class="container_tablas justify-content-center">
							<table class="table table-responsive table-bordered text-center table-hover table-striped w100" style="width:100%; max-width: 100%;max-height: 360px;">
								<thead class="thead-dark">
								    <tr>
								    	<th scope="col" class="font-weight-bold px-0" style="font-size: 14px; min-width: 170px; vertical-align: middle;">Nombre Completo</th>
								        <th scope="col" class="font-weight-bold" style="font-size: 14px; min-width: 105px; vertical-align: middle;">DNI</th>
								        @foreach($course->sessions as $session)
								        	<!--<th data-toggle="tooltip" data-placement="top" title="{{$session->name}}" scope="col">Sesion&nbsp;{{$loop->iteration}}</th>-->
								        	<th scope="col" class="font-weight-bold text-info w-100" style="font-size: 14px; min-width: 150px; max-width: 170px; vertical-align: middle;">{{ $session->name }}</th>
								        @endforeach
								        @foreach($course->activities as $activitie)
								        	<!--<th data-toggle="tooltip" data-placement="top" title="{{$activitie->name}}" scope="col">Actividad&nbsp;{{$loop->iteration }}</th>-->
											<th scope="col" class="font-weight-bold text-warning w-100" style="font-size: 14px; min-width: 150px; max-width: 170px; vertical-align: middle;">{{ $activitie->name }}</th>
								        @endforeach
								        @foreach($course->exams as $exam)
								        	<!--<th data-toggle="tooltip" data-placement="top" title="{{$exam->name}}" scope="col">Examen&nbsp;{{$loop->iteration }}</th>-->
								        	<th scope="col" class="font-weight-bold text-danger w-100" style="font-size: 14px; min-width: 150px; max-width: 170px; vertical-align: middle;">{{ $exam->name }}</th>
								        @endforeach
								    </tr>
								</thead>
								<tbody>
									<!-- Inicio de primer colaborador -->
									@foreach($course->product->students as $student)
									<tr>
										<td class="text-left pr-0 pl-2" style="font-size: 13.5px; vertical-align: middle;">{{$student->full_name}}</td>
										<td style="font-size: 13.5px;">{{$student->dni}}</td>
										@foreach($course->sessions as $session)
								        	<td scope="col" style="font-size: 13.5px; vertical-align: middle;">Sesion&nbsp;{{$loop->iteration}}</td>
								        @endforeach
								        @foreach($course->activities as $activitie)
								        	<td scope="col" style="font-size: 13.5px; vertical-align: middle;">Actividad&nbsp;{{$loop->iteration }}</td>
								        @endforeach
								        @foreach($course->exams as $exam)
								        	<td scope="col" style="font-size: 13.5px; vertical-align: middle;">Examen&nbsp;{{$loop->iteration }}</td>
								        @endforeach
									</tr>
									@endforeach
								    <!-- Fin de primer colaborador -->
								</tbody>
							</table>
						</div>
					</div>
				</div>



				<!--/////////////////////////////////// TAB DE ASISTENCIA /////////////////////////////////-->
				<!--///////////////////////////////////////////////////////////////////////////////////////-->







				<div class="tab-pane fade" id="asistencia" role="tabpanel" aria-labelledby="asistencia-tab">
					<div class="container-fluid px-2 m-auto">
						<div class="row no-gutters d-flex justify-content-between mt-3 mb-3">
							<div class="col-md-1 align-self-center">
								<a href="" class="btn btn-success" title="Descargar reporte"><i class="fas fa-file-excel"></i></a>
							</div>
							<div class="col-md-10 align-self-center">
								<div class="row no-gutters d-flex justify-content-around">
									<div class="col-2">
										<i class="fas fa-clipboard-check text-success"></i><span class="pl-2">Asistió</span>
									</div>
									<div class="col-3">
										<i class="fas fa-calendar-times text-danger"></i><span class="pl-2">No Asistió</span>
									</div>
									<div class="col-2">
										<i class="fas fa-desktop text-primary"></i><span class="pl-2">Virtual</span>
									</div>
									<div class="col-4">
										<i class="fas fa-user-clock text-secondary"></i><span class="pl-2">Falta tomar asistencia</span>
									</div>
								</div>
							</div>
						</div>
						<div class="container_tablas">
							<table class="table table-responsive table-bordered text-center table-hover table-striped" style="width:100%; max-width: 100%;max-height: 360px;">
								<thead class="thead-dark">
								    <tr>
								    	<th scope="col" class="font-weight-bold px-0" style="font-size: 14px; min-width: 170px; vertical-align: middle;">Nombre Completo</th>
								        <th scope="col" class="font-weight-bold" style="font-size: 14px; min-width: 105px; vertical-align: middle;">DNI</th>
   								        @foreach($course->sessions as $session)
								        	<!--<th data-toggle="tooltip" data-placement="top" title="{{$session->name}}" scope="col">Sesion&nbsp;{{$loop->iteration}}</th>-->
								        	<th scope="col" class="font-weight-bold w-100" style="font-size: 14px; min-width: 150px; max-width: 170px; vertical-align: middle;">{{ $session->name }}</th>
								        @endforeach
								        <!--<th scope="col" width="25%">% completado</th>-->
								    </tr>
								</thead>
								<tbody>

									<!-- Inicio de primer colaborador -->
									@foreach($course->product->students as $student)
									<tr>
										<td class="text-left pr-0 pl-2" style="font-size: 13.5px; vertical-align: middle;">{{$student->full_name}}</td>
										<td style="font-size: 13.5px;">{{$student->dni}}</td>
										@foreach($course->sessions as $session)
								        	<td scope="col" style="font-size: 13.5px; vertical-align: middle;">
								        	@if($session->session_type_id == SESSION_FACE)
									        	@if($session->assistances()->whereHas('student', function($query) use ($student){
									        		$query->where('id', $student->id)->where('value', 1);
									        	})->count())
									        	<i class="fas fa-calendar-check text-success" style="font-size: 14px;" title="Asistió"></i>
									        	@elseif($session->assistances()->whereHas('student', function($query) use ($student){
									        		$query->where('id', $student->id)->where('value', 0);
									        	})->count())
									        	<i class="fas fa-calendar-times text-danger" style="font-size: 14px;" title="No asistió"></i>
									        	@else
									        	<i class="fas fa-user-clock text-secondary" style="font-size: 14px;" title="Falta tomar asistencia"></i>
									        	@endif
								        	@elseif($session->session_type_id == SESSION_VIRTUAL)
								        		<i class="fas fa-desktop text-primary" style="font-size: 14px;" title="Virtual"></i>
								        	@endif
								        	</td>
								        @endforeach
										<!--<td></td>-->
									</tr>
									@endforeach
								    <!-- Fin de primer colaborador -->

								</tbody>
							</table>
						</div>
					</div>
				</div>










			</div>
		</div>
	</div>
</div>

@foreach($course->sessions as $session)
<div class="modal" id="sesion_{{$session->id}}" data-id="{{$session->id}}">
	<div class="modal-dialog modal-lg">
		<div class="modal-content px-0" style="overflow-x: hidden;">
					<div class="modal-header" style="min-height: 60px;">
						<h4 class="modal-title">Lista de Asistencia - Sesión {{$loop->iteration}}</h4>
						<button class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body px-1" style="height: 400px; overflow-y: auto; overflow-x: hidden;">
				<form method="post" class="mb-0" action="{{route('teacher.courses.save-assistances')}}">
					{!! csrf_field() !!}
					<input type="hidden" name="session_id" value="{{$session->id}}">
					<div class="form-group row no-gutters" style="overflow-y: auto; overflow-x: hidden;>
						<div class="row">
							<div class="col-sm-6 text-uppercase font-weight-bold align-self-center text-center col-nombre" style="font-size: 15px;">
								Nombre del Estudiante
							</div>
							<div class="col-sm-3 align-self-center text-center col-asistio">
								<span class="badge badge-primary p-2 ml-2" title="Asistió" style="cursor: pointer;"><i class="fas fa-calendar-check" style="font-size: 13px;"></i></span>
							</div>
							<div class="col-sm-3 align-self-center text-center col-falto">
								<span class="badge badge-danger p-2 ml-4" title="No asistió" style="cursor: pointer;"><i class="fas fa-calendar-times" style="font-size: 13px;"></i></span>
							</div>
						</div>
						<div>
						@foreach($course->product->students as $student)
						<!--*********  Inicio de Primer Estudiante  *********** -->
						<div class="row">
							<div class="col-sm-6 align-self-center text-left">
								<span class="ml-4">{{$student->full_name}}</span>
							</div>
							<div class="col-sm-3 align-self-center text-center col-asistio">
								<input type="radio" style="cursor: pointer;" name="alumnos[{{$student->id}}]" value="1" {{$student->assistance_by_session($session->id) ? ($student->assistance_by_session($session->id)->value ? 'checked' : '') : ''}}>
							</div>
							<div class="col-sm-3 align-self-center col-falto text-center">
								<input type="radio" style="cursor: pointer;" name="alumnos[{{$student->id}}]" value="0" {{$student->assistance_by_session($session->id) ? (!$student->assistance_by_session($session->id)->value ? 'checked' : '') : ''}}>
							</div>
						</div>
						<hr class="my-2">
						<!--*********  Fin de Primer Estudiante  *********** -->
						@endforeach
						</div>
					</div>
					<div class="modal-footer pb-3 mb-2">
						<button class="btn btn-danger button_cerrar" data-dismiss="modal">Cerrar</button>
						<button class="btn btn-primary button_guardar" type="submit">Guardar</button>
					</div>
				</form>
			</div>
		</div>
	</div>

</div>
@endforeach

<div class="container-fluid">
	<div class="row-no-gutters">
		<div class="col-md-12">
			<!-- *********************** IMAGEN INTRODUCCTORIA (SI EXISTE) ************************* -->

<div class="modal fade" id="img-introducctorio" tabindex="-1" role="dialog" aria-labelledby="img-introducctorio" aria-hidden="true">
	<div class="modal-dialog modal-sm">
    	<div class="modal-content">
        	<div class="modal-header">
            	<h5 class="modal-title font-weight-bold">Imagen introducctoria</h5>
            	<button class="close" data-dismiss="modal" aria-label="Cerrar">
                	<span aria-hidden="true">&times;</span>
            	</button>
        	</div>
        	<div class="modal-body">
            	<div class="container-fluid px-0">
                	<img src="{{$course->video_intro}}" class="img-fluid rounded" alt="Imagen introductoria">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- *********************** FIN DE POP-UP IMAGEN INTRODUCCTORIA (SI EXISTE) ************************* -->
		</div>
		<div class="col-md-12">
			<!-- *********************** INSTRUCCIONES PARA SUBIR VIDEO ************************* -->

			<div class="modal fade" id="instrucciones_subir_video" tabindex="-1" role="dialog" aria-labelledby="instrucciones_subir_video" aria-hidden="true">
				<div class="modal-dialog modal-lg">
			    	<div class="modal-content">
			        	<div class="modal-header">
			            	<h5 class="modal-title font-weight-bold">Indicaciones para subir un video</h5>
			            	<button class="close" data-dismiss="modal" aria-label="Cerrar">
			                	<span aria-hidden="true">&times;</span>
			            	</button>
			        	</div>
			        	<div class="modal-body">
			            	<div class="container-fluid px-0">
			                	<ol class="pl-4">
			                		<li>
			                			Ir a Youtube y seleccionar el video que se desea integrar.</li>
			                		<li>Ir al botón de compartir o 'SHARE'(en inglés) o 'COMPARTIR'(en español), que se encuentra al costado de los links y dislikes.</li>
			                		<li>Seleccionar la opción de <kbd><code>&lt; &gt;</code>'Embed'</kbd>.</li>
			                		<li>Inmediatamente, observamos del lado derecho el video seleccionado y del lado izquierdo un texto que comienza con la etiqueta <code>&lt;iframe&gt;</code> y termina con la etiqueta <code>&lt;/iframe&gt;</code>.</li>
			                		<li>Copiamos todo el texto y lo pegamos en nuestro casillero que nos dice 'Ingresa el link del video'</li>
			                		<li>Recuerda que solo se desea el link; es decir, debemos quedarnos con la parte que comienza con el <code>src="</code>(contenido que queremos)<code>"</code>.</li>
			                		<li>Ejemplo de como debería ser un link: <code>https://www.youtube.com/embed/yxwdKX7ErJ4</code></li>
			                	</ol>
			                </div>
			            </div>
			            <div class="modal-footer">
			                <button class="btn btn-danger" data-dismiss="modal">Cerrar</button>
			            </div>
			        </div>
			    </div>
			</div>
			<!-- *********************** FIN DE POP-UP INSTRUCCIONES PARA SUBIR VIDEO************************* -->
		</div>
	</div>
</div>


@stop

@section('extra_scripts')
<script>

function type_selection(that) {

	if (that.value == "{{MULTIMEDIA_TYPE_VIDEO_EMBED}}") {
		$('#add_video').show();
		document.getElementById("add_imagen").style.display = "none";
	} else if (that.value == "{{MULTIMEDIA_TYPE_IMAGE}}"){
		$('#add_imagen').show();
		document.getElementById("add_video").style.display = "none";

	}
}

$('.delete_sesion').click(function(e){
    e.preventDefault();
    var this_el = $(this);
    $.ajax({
        url: "{{route('teacher.sessions.delete', '@')}}".replace('@', this_el.data('id')),
        type: "GET"
    }).done(function(data){
        this_el.parents('.container_sesion').remove();
    });
});


$(document).ready(function(){
	$('{{$target}}').click();

    $('#name, #code, #description').keyup(function(){
        delay(function(){
            var name = $('#name').val();
            var code = $('#code').val();
            var description = $('#description').val();

            $.ajax({
                url: "{{route('teacher.courses.edit', request()->route('id'))}}",
                type: "POST",
                data: {
                    "name": name,
                    "code" : code,
                    "description" : description,
                    "_token" : "{{csrf_token()}}"
                }
            });
        }, 1500 );
    });

    var delay = (function(){
        var timer = 0;
        return function(callback, ms){
            clearTimeout (timer);
            timer = setTimeout(callback, ms);
        };
    })();

	$('.button_guardar, .button_cerrar').click(function(){
		var id = $(this).parents('.modal').data('id');
	});
});
</script>

@stop
