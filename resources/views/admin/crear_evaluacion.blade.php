@extends('main.base_main')
@section('extra_css')
	<link rel="stylesheet" type="text/css" href="{{asset('css/admin/style_crear_evaluacion.css')}}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
@stop

@section('titulo')
	CREAR EVALUACION
@stop

@section('home_url')
{{route('admin.courses.index')}}
@stop

@section('logout_url')
{{route('admin.auth.logout')}}
@stop

@section('contenido_web')

<div class="container-fluid container_crear_evaluacion">
	<div class="row info_evaluacion">
		<div class="col-sm-6 col-md-8 input_evaluacion">
		<form>
			<input type="text" name="nombre_evaluacion" placeholder="NOMBRE DE LA EVALUACIÓN" id="title" value="{{$exam->title or ''}}">
			<input type="text" name="codigo_evaluacion" placeholder="CÓDIGO DE LA EVALUACIÓN" id="code" value="{{$exam->product->code}}">
		</form>
		</div>
		<div class="col-sm-6 col-md-4 text_add">
			Agrega a los alumnos
		</div>
	</div>


	<div class="row">
		<div class="col-sm-6 col-md-7 content_evaluacion">
				<form>
					<div class="row">
						<div class="col-md-6">
							Tiempo: <span class="mx-2"><input type="number" name="duration" class="rounded text-center" id="duration" value="{{$exam->duration_in_minutes}}" class="text-center" style="width:60px;"></span> minutos
						</div>
						<div class="col-md-6 my-1">
							<div class="row">
								<div class="col-sm-9 text-left pl-0 col-md-9 align-self-center">
									<span>Listado de Alumnos</span><i class="fas fa-table text-success ml-2" style="cursor:pointer;" data-target="#popup_listado_{{ $exam->id }}" data-toggle="modal"></i>
									<a href="{{route('admin.courses.exams.delete' ,$exam->id)}}" class="text-danger" title="Eliminar examen">
											<span class="fas fa-trash-alt"></span>
									</a>
								</div>

							</div>
						</div>
					</div>
					<br><br>
					Descripción de la evaluacion:

					<textarea id="description" name="description" class="p-2">{{$exam->description}}</textarea>
					<br><br>
					<a class="btn btn-secondary align-self-center" href="{{route('admin.questions.create', ['entity_name' => ENTITY_EXAM, 'entity_id' => request()->route('id')])}}" role="button">Agregar Preguntas</a>
				</form>


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
                                        			@foreach($exam->product->students as $student)
				                        			<tr data-id="{{$student->id}}">
				                        				<td class="text-left pr-0 pl-2" style="font-size: 15px;">{{$student->full_name}}</td>
				                        				<td style="font-size: 15px;">
																					<a href="{{route('admin.questions.review', ['entity_name' => ENTITY_EXAM, 'entity_id' => $exam->id, 'student_id' => $student->id])}}" title="Corregir" class="text-danger"><i class="fas fa-clipboard"></i></a>
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
		</div>


		<div class="col-sm-6 col-md-5 people_evaluacion">
			<!-- ********************************************** ALUMNOS **************************************************-->
			<div class="option_alumno mt-4">
				<!--<div class="row text_alumnos mt-3">
					ALUMNOS
				</div>-->
                <div class="row">
                    <div class="col-sm-12 col-md-12 text-center text_alumnos">
                        ALUMNOS
                    </div>
                </div>
				<!--<div class="row add_alumno">
					<a href="#" data-target="#popup_add_alumno" data-toggle="modal"><span class="fas fa-user-plus mr-2"></span><span>Crear nuevo alumno</span></a>
				</div>
				<div class="row select_alumno">
					<a href="#" data-target="#popup_select_alumno" data-toggle="modal"><span class="fas fa-user-plus mr-2"></span><span>Seleccionar alumnos</span></a>
				</div>-->
                <div class="row justify-content-between">
                    <div class="col-md-6 add_alumno">
                        <button class="btn btn-success" data-target="#popup_add_alumno" data-toggle="modal"><span class="fas fa-user-plus mr-2"></span><span>Crear nuevo alumno</span></button>
                    </div>
                    <div class="col-md-6 select_alumno">
                        <button class="btn btn-primary" data-target="#popup_select_alumno" data-toggle="modal"><span class="fas fa-mouse-pointer mr-2"></span><span>Seleccionar alumnos</span></button>
                    </div>
                </div>
				<!--<div class="row added_alumnos">
                    @foreach($exam->product->students as $student)
                        <div data-id="{{$student->id}}">
                            <span class="fas fa-user">{{$student->full_name}}</span>
                            <a href="{{route('admin.questions.review', ['entity_name' => ENTITY_EXAM, 'entity_id' => $exam->id, 'student_id' => $student->id])}}"><span class="fas fa-clipboard-check" title="Corregir"></span></a>
                        </div>
                    @endforeach
				</div>-->

                <table class="table table-responsive text-center w-100" style="max-height: 200px;">
                    <thead>
                        <tr>
                            <th scope="col" width="33%" class="font-weight-bold px-0" style="font-size: 14px;">Nombre Completo</th>
                            <th scope="col" width="33%" class="font-weight-bold" style="font-size: 14px;">DNI</th>
                            <th scope="col" width="33%" class="font-weight-bold" style="font-size: 14px;">E-mail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($exam->product->students as $student)
                        <tr>
                            <td class="text-left pr-0 pl-2" style="font-size: 13.5px;">{{$student->full_name}}</td>
                            <td style="font-size: 13.5px;">{{$student->dni}}</td>
                            <td style="font-size: 13.5px;">{{$student->personal_email}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

			</div>
		</div>
	</div>
</div>


<!-- *********************** INICIO POP-UP AGREGAR ALUMNO ************************* -->
<div class="modal fade" id="popup_add_alumno" tabindex="-1" role="dialog" aria-labelledby="popup_alumnoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="height: 450px; overflow-y: auto">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar Alumno</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body body_add_alumnos" style="overflow-y: auto;">
      	<div class="container_agregar_alumno">
	      	<div class="row new_alumno">
	      		<div class="col-sm-6 col-md-4 photo_new_alumno">
	      			<img class="circle_photo img-fluid" src="/images/default/user.png" width="100">
	      				<!-- SE TIENE QUE ACTIVAR PARA QUE LA FOTO SE PUEDA VER UNA VEZ ESTA HAYA SIDO SELECCIONADA -->
	      			<br>
                <form id="form_create_student" role="form" enctype="multipart/form-data" method="post">
                    {!! csrf_field() !!}
	      			<input type="file" class="file_new_alumno ml-4 mt-4" id="file_new_alumno" name="image">
	      		</div>
	      		<div class="col-sm-6 col-md-8 info_new_alumno">

					    <!--DNI: <input type="text" name="dni_alumno"><hr>
				      	NOMBRE(S): <input type="text" name="nombres_alumno"><hr>
				      	APELLIDO(S): <input type="text" name="apellidos_alumno"><hr>
				      	TELÉFONO: <input type="text" name="phone"><hr>
				      	EMPRESA: <input type="text" name="company"><hr>
				      	E-MAIL EMPRESARIAL: <input type="text" name="email_empresarial_alumno"><hr>
				      	E-MAIL PERSONAL: <input type="text" name="email_personal_alumno"><hr>-->

                        {!! csrf_field() !!}
                        DNI: <input type="text" name="dni_alumno" id="dni_alumno"><hr>
                        NOMBRE(S): <input type="text" name="nombres_alumno" id="nombres_alumno"><hr>
                        APELLIDO(S): <input type="text" name="apellidos_alumno" id="apellidos_alumno"><hr>
                        TELÉFONO: <input type="text" name="telefono_alumno" id="telefono_alumno"><hr>
                        EMPRESA: <select name="empresa_alumno" id="empresa_alumno">
                            @foreach($businesses as $business)
                            <option value="{{$business->company->id}}">{{ $business->social_reason }}</option>
                            @endforeach
                            </select><hr>
                        E-MAIL EMPRESARIAL: <input type="text" name="email_empresarial_alumno" id="email_empresarial_alumno"><hr>
                        E-MAIL PERSONAL: <input type="text" name="email_personal_alumno" id="email_personal_alumno"><hr>
			      	</form>
	      		</div>
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

<!-- *********************** INICIO POP-UP SELECT ALUMNO ************************* -->
<div class="modal fade" id="popup_select_alumno" tabindex="-1" role="dialog" aria-labelledby="popup_alumnoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="max-height: 550px">
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
					<div class="highlightbox_alumno {{$exam->product->students->contains('id', $student->id) ? 'highlight_alumno' : ''}}">
			  			<input type="checkbox" value="{{$student->id}}" name="checkbox_alumno[]" id="alumno{{$student->id}}" data-id="{{$student->id}}" class="prueba" {{$exam->product->students->contains('id', $student->id) ? 'checked' : ''}}><br>
			  			<label for="alumno" data-full_name="{{$student->full_name}}">
				  			<div class="box_alumno">
				  				<div class="box_alumno_top">
		    						<!--<img src="{{asset($student->photo)}}"" class="photo_docente my-2">-->
                                    <img src="{{asset($student->photo)}}" class="photo_docente my-2" alt="image not available" onerror="this.onerror=null;this.src='/images/default/user.png';" width="70" height="70">
				  				</div>
				  				<div class="box_alumno_bottom">
					  				<p>{{$student->full_name}}<br>
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="assign_students">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- *********************** FIN DE POP-UP SELECCIONAR ALUMNO ************************* -->


@stop


@section('extra_scripts')
<script>

/* Validar nuevo estudiante */

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


/* FIN de validar nuevo estudiante */

$(document).ready(function(){
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
            url: "{{route('admin.students.json-create')}}",
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

    $('#title, #code, #duration, #description').keyup(function(){
        delay(function(){
            var title = $('#title').val();
            var code = $('#code').val();
            var duration = $('#duration').val();
            var description = $('#description').val();

            $.ajax({
                url: "{{route('admin.exams.edit', request()->route('id'))}}",
                type: "POST",
                data: {
                    "title": title,
                    "code" : code,
                    "duration": duration,
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

    $('#assign_students').click(function(e){
        e.preventDefault();
        var students = $('input[name="checkbox_alumno[]"]:checked').val();

        $.ajax({
            url: "{{route('admin.exams.edit', request()->route('id'))}}",
            type: "POST",
						cache:false,
            data: {
                "students": added_students,
                "_token" : "{{csrf_token()}}"
            }
        }).done(function(data){
            $('#popup_select_alumno').modal('toggle');
						  window.location.reload();
        });
        //window.location.href = window.location.pathname + window.location.search + window.location.hash;
    });


});
</script>

@stop
