@extends('main.base_main')
@section('extra_css')
	<link rel="stylesheet" type="text/css" href="{{asset('css/coordinador_empresa/style_simulador_ejemplo.css')}}">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<style>
		.footer{
			display: none;
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

@section('contenido_web')

<div class="container-fluid container_crear_simulador">
	<div class="row info_simulador">
		<div class="col-sm-12 col-md-12 align-self-center text-center pt-0 py-3 text_add">	
			{{$simulator->name}}
		</div>
	</div>

	
	<div class="row">
		<div class="col-sm-12 col-md-12 content_simulador">
			<i class="far fa-file-alt mr-1"></i>	
			Descripción del simulador: <br>
			<span>{{$simulator->description}}</span>
			<h5 class="text-left text-uppercase mt-3 font-weight-bold">Materiales</h5>
			@if($simulator->attachments->count() > 0)
			<div class="container-fluid p-0" style="min-height: auto";>
				<div class ="row content_materiales mb-2">
					@foreach($simulator->attachments as $attachment)
					<div class="col-sm-12 my-1 align-self-center">
						<div class="row no-gutters justify-content-start">
							<div class="col-md-3">
								<i class="fas fa-file-alt mr-2 text-dark" style="position: relative; top: 2px;"></i>
								<span>{{$attachment->name}}</span>
							</div>
							<div class="col-md-1">
								<a href="{{asset($attachment->url)}}" target="_blank" class="text-primary" title="Descargar material">
								<span class="fas fa-download" style="position: relative; top: 2px;"></span>
								</a>
							</div>
						</div>
					</div>
					@endforeach
				</div>
			</div>
			@else
			<div class="alert alert-dark my-3 text-uppercase text-center" role="alert">
			Este simulador no tiene materiales disponibles !!!
			</div>
			@endif
			
			<h5 class="text-left text-uppercase font-weight-bold mt-4">Exámenes</h5>
			@if($simulator->grouped_exams->count() > 0)
			<div class ="container-fluid p-0 content_examenes mt-3 ml-3" style="min-height: auto;">
				@foreach($simulator->grouped_exams as $exams)
				<!-- *********** Categoría 1 ***************-->
			  	<div class ="row categoria_examen">
			  		<div class="col-sm-12 col-md-12 mb-2 py-2">
				  		@foreach($exams as $exam)
				  		@if($loop->first)
				  		<div class ="row titulo_categoria">
				  			<div class="col-sm-12 col-md-auto" style="border-bottom: 1px solid black;">
				  				<i class="fas fa-sitemap text-dark mr-2" style="font-size: 12px; position: relative; top: -2px;"></i>
				  				<span class="text-uppercase font-weight-bold" style="font-size: 16px;">{{$exams->first()->category->name}}</span>
				  			</div>
				  		</div>
				  		@endif
				  		<!-- Examen 1-->
				  		<div class ="row examen mb-2"> 
				  			<div class ="col-sm-3 col-md-4 align-self-center titulo_examen">
				  				<i class="fas fa-file-alt text-dark mr-2"></i>
				  				<span>{{$exam->name}}</span>
				  			</div>
				  		</div>
				  		<hr class="my-0">
				  		@endforeach
				  	</div>
			  	</div>
			  	@endforeach
			</div>
			@else
			<div class="alert alert-dark my-3 text-uppercase text-center" role="alert">
			Este simulador no tiene exámenes disponibles !!!
			</div>
			@endif
		</div>
	</div>


		<div class="col-sm-12 col-md-12 mb-4 people_simulador">
			<!-- ********************************************** ALUMNOS **************************************************-->
			<div class="option_alumno">
				<div class="row justify-content-center pt-4">
					<div class="col-md-6 add_alumno text-right">
						<button class="btn btn-success" data-target="#popup_add_alumno" data-toggle="modal"><span class="fas fa-user-plus mr-2"></span><span>Crear nuevo alumno</span></button>
					</div>
					<div class="col-md-6 select_alumno">
						<button class="btn btn-primary" data-target="#popup_select_alumno" data-toggle="modal"><span class="fas fa-mouse-pointer mr-2"></span><span>Seleccionar alumnos</span></button>
					</div>
				</div>
				<div class="row text_alumnos">
					ALUMNOS INSCRITOS EN EL SIMULADOR
				</div>
				<div class="row added_alumnos">
                    
                        <table class="table table-responsive text-center mb-2 table-hover table-striped mr-3">
						    <thead class="bg-dark text-white">
						    	<tr>
							        <th scope="col" width=33%" class="font-weight-bold px-0" style="font-size: 16.5px;">Nombre Completo</th>
							        <th scope="col" width="33%" class="font-weight-bold" style="font-size: 16.5px;">DNI</th>
							        <th scope="col" width="33%" class="font-weight-bold" style="font-size: 16.5px;">E-mail</th>
							        <th scope="col" width="33%" class="font-weight-bold" style="font-size: 16.5px;">¿Evaluación finalizada?</th>
						    	</tr>
						    </thead>
						    <tbody>
						    	@foreach($added_students as $student)
						    	<tr>
							        <td class="text-left pr-0 pl-2" style="font-size: 15px;">{{$student->full_name}}</td>
							        <td style="font-size: 15px;">{{$student->dni}}</td>
							        <td style="font-size: 15px;">{{$student->email}}</td>
							        <td style="font-size: 15px;"><div class="badge badge-info">por comenzar</div></td>
						    	</tr>
						    	@endforeach
						    </tbody>
						</table>
				</div>
			</div>
		</div>
	</div>
</div>



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
					<div class="highlightbox_alumno {{$simulator->product->students->contains('id', $student->id) ? 'highlight_alumno' : ''}}">
			  			<input type="checkbox" value="{{$student->id}}" name="checkbox_alumno[]" id="alumno{{$student->id}}" data-id="{{$student->id}}" {{$simulator->product->students->contains('id', $student->id) ? 'checked' : ''}}><br>
			  			<label for="alumno{{$student->full_name}}" data-full_name="{{$student->full_name}}">
				  			<div class="box_alumno">
				  				<div class="box_alumno_top">
		    						<img src="{{$student->photo}}" class="photo_alumno my-1" alt="image not available" onerror="this.onerror=null;this.src='/images/default/user.png';">
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

		var added_students = [];
	    var add_highlight_alumno = 'highlight_alumno';

	    $('input[name="checkbox_alumno[]"]:checked').map(function(){
	        added_students.push(parseInt($(this).val()));
	    });

		/*$('.add-students').click(function(){
			$(this).parents('.card-header').removeAttr('data-toggle');
			var form = $('#form_create_student');
			var simulator_id = $(this).parents('.card').data('id');
			var action_form = form.prop('action').replace("@", simulator_id);
			form.prop('action', action_form);
			$('#popup_add_alumno').modal('show');

		});*/

    $('.row_alumnos').on('click', '.highlightbox_alumno', function(evt){
            evt.preventDefault();
            var id = $(this).find('input').data('id');

            if (!$(this).find('input').is(':checked')) {
                $(this).find('input').prop('checked', true);
                $(this).addClass(add_highlight_alumno);
                added_students.push(id);
                /*$('.added_alumnos').append('<div data-id="' + id + '"></div>');
                $('.added_alumnos').children().last().append('<span class="fas fa-user"></span>').append($(this).find('input').siblings('label').data('full_name'));*/
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
            url: "{{route('company.simulators.edit', request()->route('id'))}}",
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
