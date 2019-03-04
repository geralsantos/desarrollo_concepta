@extends('main.base_main')
@section('extra_css')
	<link rel="stylesheet" type="text/css" href="{{asset('css/coordinador_empresa/style_evaluacion_ejemplo.css')}}">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
	<style>
		.footer{
			display: none;
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

@section('contenido_web')

<div class="container-fluid container_crear_evaluacion">
	<div class="row info_evaluacion">
		<div class="col-sm-12 col-md-12 text_add pt-0 py-2 text-center align-self-center text-uppercase font-weight-bold">	
			{{$exam->name}}
		</div>
	</div>

	
	<div class="row">
		<div class="col-sm-12 col-md-12 content_evaluacion">
				
			<i class="fas fa-clock mr-2"></i>Tiempo: <span> {{$exam->duration}} minutos</span> 
			<br><br>
			<i class="far fa-file-alt mr-2"></i>Descripción de la evaluacion: <br>
			<span>{{$exam->description}}</span>
				
		</div>


		<div class="col-sm-12 col-md-12 people_evaluacion py-3">
			<!-- ********************************************** ALUMNOS **************************************************-->
			<div class="option_alumno">
				<div class="row justify-content-center">
					<div class="col-md-6 add_alumno text-right">
						<button class="btn btn-success" data-target="#popup_add_alumno" data-toggle="modal">
							<span class="fas fa-user-plus mr-2"></span>
							<span>Crear nuevo alumno</span>
						</button>
					</div>
					<div class="col-md-6 select_alumno">
						<button class="btn btn-primary" data-target="#popup_select_alumno" data-toggle="modal">
							<span class="fas fa-mouse-pointer mr-2"></span>
							<span>Seleccionar alumnos</span>
						</button>
					</div>
				</div>
				<div class="row text_alumnos text-center font-weight-bold text-uppercase">
					<div class="col-md-12 mt-3">
						ALUMNOS INSCRITOS EN LA EVALUACION
					</div>
				</div>
				<div class="row added_alumnos justify-content-center" style="margin: 0 auto;">
					<div class="col-md-8">
                        <table class="table mt-1 table-hover w-100 table-stripped table-responsive text-center">
						    <thead class="bg-dark text-white">
						    	<tr>
							        <th scope="col" width="100%" class="font-weight-bold px-0" style="font-size: 16.5px;">Nombre Completo</th>
							        <th scope="col" width="100%" class="font-weight-bold" style="font-size: 16.5px;">DNI</th>
							        <th scope="col" width="100%" class="font-weight-bold" style="font-size: 16.5px;">E-mail</th>
							        <!--<th>¿Evaluación finalizada?</th>-->
						    	</tr>
						    </thead>
						    <tbody>
						    	@if($students->count()>0)
							    @foreach($students as $student)
							        <tr>
								        <td class="text-left pr-0 pl-2" style="font-size: 15px; vertical-align: middle;">{{$student->full_name}}</td>
								        <td style="font-size: 15px;">{{$student->dni}}</td>
								        <td style="font-size: 15px;">{{$student->email}}</td>
							    	</tr>
							    @endforeach
							    @else
							    <tr>
							    	<td colspan="3">
							    		<div class="alert alert-info mt-1 text-center text-uppercase" role="alert">
								  		No hay alumnos matriculados para esta evaluación !!!
										</div>
							    	</td>
							    </tr>
							    @endif
						    </tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- *********************** INICIO POP-UP SELECT ALUMNO ************************* -->
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
					<div class="highlightbox_alumno {{$exam->product->students->contains('id', $student->id) ? 'highlight_alumno' : ''}}">
			  			<input type="checkbox" value="{{$student->id}}" name="checkbox_alumno[]" id="alumno{{$student->id}}" data-id="{{$student->id}}" {{$exam->product->students->contains('id', $student->id) ? 'checked' : ''}}><br>
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

    


		$('.add-students').click(function(){
			$(this).parents('.card-header').removeAttr('data-toggle');
			var form = $('#form_create_student');
			var simulator_id = $(this).parents('.card').data('id');
			var action_form = form.prop('action').replace("@", simulator_id);
			form.prop('action', action_form);
			$('#popup_add_alumno').modal('show');

		});
  </script>

@stop
