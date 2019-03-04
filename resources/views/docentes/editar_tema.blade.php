@extends('main.base_main')
@section('extra_css')
	<link rel="stylesheet" type="text/css" href="{{asset('css/admin/style_crear_tema.css')}}">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
	<style>
		
	</style>
@stop

@section('titulo')
	CREAR TEMA
@stop

@section('home_url')
{{route('teacher.courses.index')}}
@stop

@section('logout_url')
{{route('teacher.auth.logout')}}
@stop

@section('contenido_web')

<div class="row">
	<div class="col-sm-2 col-md-2 bar_navegacion">
		<a href="{{route('teacher.courses.edit', [$theme->session->course->id, 'target' => urlencode('#sesion-tab')])}}" class="btn btn-return">Regresar a sesiones</a>
		<h5>Sesion: {{$theme->session->name}}</h5>
		@foreach($theme->session->themes as $theme_item)
		<a href="{{route('teacher.themes.edit', $theme_item->id)}}" class="btn btn-tema" title="{{$theme_item->name}}">Tema {{$loop->iteration}}</a>
		@endforeach
	</div>

	<div class="col-sm-10 col-md-10 container_crear_tema">
		<div class="row info_tema">
			<div class="col-sm-12 col-md-12 input_tema">
				<h5>Nombre del tema</h5>	
				<form>
					<input type="text" name="nombre_tema" id="nombre_tema" placeholder="INGRESAR NOMBRE DEL TEMA" value="{{$theme->name}}" class="w-100">
				</form>
			</div>
		</div>
		<div>
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item">
			    	<a class="nav-link active" id="clase-tab" data-toggle="tab" href="#clase" role="tab" aria-controls="clase" aria-selected="true">Clase</a>
			    </li>
			    <li class="nav-item">
			    	<a class="nav-link" id="materiales-tab" data-toggle="tab" href="#materiales" role="tab" aria-controls="materiales" aria-selected="false">Materiales</a>
			    </li>
			    <li class="nav-item">
			    	<a class="nav-link" id="ejercicios-tab" data-toggle="tab" href="#ejercicios" role="tab" aria-controls="ejercicios" aria-selected="false">Ejercicios</a>
			    </li>
			</ul>
		</div>

		<div class="tab-content px-1" id="myTabContent">

			<!--/////////////////////////////////////// TAB DE CLASES /////////////////////////////////-->
			<!--///////////////////////////////////////////////////////////////////////////////////////-->
			
			<div class="tab-pane fade show active" id="clase" role="tabpanel" aria-labelledby="clase-tab">
				<div class="row">
					<div class="col-sm-6 col-md-6">
						<form method="post" enctype="multipart/form-data" action="{{route('teacher.themes.add-multimedia', $theme->id)}}">
						{!! csrf_field() !!}
							<!-- //////////////   SELECCIONAR VIDEO O IMAGEN   //////////////// -->
							<div class="row">
								<div class="col-sm-12 col-md-12 select_type">
									<select onchange="type_selection(this)" id="selection_made" name="type">
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
													<div class="col-sm-12 col-md-9 title_tema">
														<input type="text" name="name_video" placeholder="Ingresa el título del video" class="w-100">
													</div>
													<div class="col-sm-12 col-md-3 pr-0 upload_button_video">
														<button type="submit" class="btn btn-secondary">Guardar</button>
													</div>
													<div class="col-md-12 align-self-center pr-0 title_tema">
														<div class="row no-gutters">
															<div class="col-11 align-self-center">
																<input type="url" name="uploaded_file" placeholder="Ingresa el link del video" class="w-100 mt-3">
															</div>
															<div class="col-1 pl-2 mt-3 align-self-center">
																<a data-toggle="modal" data-target="#instrucciones_subir_video" class="text-dark" title="Instrucciones" style="cursor: pointer; font-size: 20px;"><i class="fas fa-info-circle"></i></a>
															</div>
														</div>
													</div>
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
												<div  class="row upload_text">
													<div class="col-sm-12 col-md-12 pr-0 title_tema">
														<input type="text" name="name_image" placeholder="Ingresa el título de la imagen" class="w-100">
													</div>
													<div class="col-sm-12 col-md-12 upload_button_video mt-3 text-left pr-0">
														<input type="file" id="video-image-ppt" name="uploaded_file">
														<button type="submit" class="btn btn-secondary float-right">Guardar</button>
													</div>
												</div>
											</div>
									</div>
								</div>
							</div>
							<!-- //////////////   FIN DE GUARDAR IMAGEN   //////////////// -->
						</form>
				
						<div class="container_upload_content">
							@foreach($theme->multimedia as $file)
							<div class="row uploaded_material">
								<div class="col-sm-12 col-md-12 ">
									<div  class="row upload_text_material">
										<div class="col-sm-6 col-md-10 title_material pr-0 align-self-center">
											<!--<span class="fas fa-file"></span>-->
											@if($file->multimedia_type_id == '1')
											<i class="fas fa-image mr-2 text-dark"></i><span>{{$file->name}}</span>
											@else
											<i class="fab fa-youtube text-danger mr-2"></i><span>{{$file->name}}</span>
											@endif
										</div>
										<div class="col-sm-3 col-md-2 align-self-center save_button_material">
											<!--<a href="{{$file->url}}" target="_blank"><span class="fas fa-download"></span></a>-->
											<a href="{{route('teacher.themes.delete-multimedia', [$theme->id, $file->id])}}" class="ml-1 align-self-center text-danger" title="Eliminar clase"><span class="fas fa-trash-alt"></span></a>
										</div>				
									</div>
								</div>
							</div>
							@endforeach
							<a class="btn btn-secondary mt-2 mb-3" href="{{route('teacher.themes.student-view', $theme->id)}}" title="Ver como alumno">Ver como alumno</a>
						</div>

					</div>

					<div class="col-sm-6 col-md-6">
						<div class="row description_archivo">
							<div class="col-sm-12 col-md-12">
								<br>
								<textarea name="description_file" id="description_file" placeholder="Agregue una reseña o explicación breve">{{$theme->description}}</textarea>
							</div>
						</div>
					</div>
				</div>	
			</div>
			<!--/////////////////////////////////// TAB DE MATERIALES /////////////////////////////////-->
			<!--///////////////////////////////////////////////////////////////////////////////////////-->
			<div class="tab-pane fade" id="materiales" role="tabpanel" aria-labelledby="materiales-tab">
				<div class="main_container_material">
					<div class="container_list_material py-2">
						<!-- //////////////   INICIO DE GUARDAR MATERIAL   //////////////// -->
						<div class="row upload_material">
								<div class="col-sm-12 col-md-12 ">
									<form method="post" action="{{route('teacher.themes.add-attachment', $theme->id)}}" enctype="multipart/form-data">
									{!! csrf_field() !!}
									<div  class="row upload_text_material">
										<div class="col-sm-6 col-md-6 title_material">
											<input type="text" name="title_material" placeholder="Título del material">
										</div>
										<div class="col-sm-6 col-md-6 save_button_material">
											<span><input type="file" id="material" name="uploaded_material"></span>
											<button type="submit" class="btn btn-secondary">Guardar</button>
										</div>				
									</div>
									</form>
								</div>
						</div>
						<!-- //////////////   FIN DE GUARDAR MATERIAL   //////////////// -->

						@foreach($theme->attachments as $attachment)
						<div class="row uploaded_material">
							<div class="col-sm-12 col-md-12 ">
								<div  class="row upload_text_material">
									<div class="col-sm-6 col-md-6 title_material">
										<i class="fas fa-file-alt mr-1 text-dark"></i> <span>{{$attachment->name}}</span>
									</div>
									<div class="col-sm-6 col-md-6 save_button_material">
										<a href="{{$attachment->url}}" download class="text-primary" title="Descargar material"><span class="fas fa-download"></span></a>
										<a href="{{route('teacher.themes.delete-attachment', [$theme->id, $attachment->id])}}" class="text-danger" title="Eliminar material"><span class="fas fa-trash-alt"></span></a>
									</div>
								</div>
							</div>
						</div>
						@endforeach
					</div>
				</div>
				
			</div>

			<!--/////////////////////////////////// TAB DE EJERCICIOS /////////////////////////////////-->
			<!--///////////////////////////////////////////////////////////////////////////////////////-->
			<div class="tab-pane fade" id="ejercicios" role="tabpanel" aria-labelledby="ejercicios-tab">
				<div class="main_container_ejercicio py-2">
					<div class="container_list_ejercicio">

						<!-- //////////////   INICIO DE GUARDAR EJERCICIOS   //////////////// -->
						<div class="row upload_ejercicio">
							<div class="col-sm-12 col-md-12 ">
									<div  class="row upload_text_ejercicio">
										
										<div class="col-sm-6 col-md-10 align-self-center title_ejercicio">
											<input type="text" name="title_ejercicio" placeholder="Título de ejercicio" class="w-100">
										</div>
										
										<div class="col-sm-6 col-md-2 align-self-center save_button_ejercicio">
											<a id="add_exercise_link" href="{{route('teacher.themes.add-exercise', request()->route('id'))}}" class="btn btn-secondary">Añadir Preguntas</a>
										</div>				
									</div>
								
							</div>
						</div>
						<!-- ////////////////   FIN DE GUARDAR EJERCICIO   ////////////////// -->

						@foreach($theme->exercises as $exercise)
						<!-- //////////////   INICIO DE EJERCICIO GUARDADO   //////////////// -->
						<div class="row uploaded_ejercicio">
							<div class="col-sm-12 col-md-12 ">
								<div  class="row upload_text_ejercicio">
									<div class="col-sm-6 col-md-6 title_ejercicio">
										<i class="fas fa-file-signature mr-1 text-dark"></i> {{$exercise->name}}
									</div>
									<div class="col-sm-6 col-md-6 options_ejercicio">
										<a href="{{route('teacher.questions.create', ['entity_name' => ENTITY_EXERCISE, 'entity_id' => $exercise->id])}}" class="text-primary" title="Ver ejercicios"><span class="fas fa-search"></span></a>
										<a href="{{route('teacher.themes.delete-exercise', [$theme->id, $exercise->id])}}" class="text-danger" title="Eliminar ejercicios"><span class="fas fa-trash-alt"></span></a>
									</div>				
								</div>
							</div>
						</div>
						@endforeach
						<!-- //////////////   FIN DE EJERCICIO GUARDADO   //////////////// -->

					</div>
				</div>
			</div>
		</div>	
	</div>

</div>


<div class="container-fluid">
	<div class="row no-gutters">
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


$('{{$target}}').click();

$('#description_file, #nombre_tema').keyup(function(){
    delay(function(){
        var description = $('#description_file').val();
        var name = $('#nombre_tema').val();

        $.ajax({
            url: "{{route('teacher.themes.edit', request()->route('id'))}}",
            type: "POST",
            data: {
                "name" : name,
                "description": description,
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

var href = $('#add_exercise_link').attr('href');

$('input[name="title_ejercicio"]').keyup(function(){
	var composite = href + "?title=" + encodeURIComponent($(this).val());
	$('#add_exercise_link').prop('href', composite);
});
</script>
@stop