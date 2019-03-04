@extends('main.base_main')
@section('extra_css')
	<link rel="stylesheet" type="text/css" href="{{asset('css/admin/style_crear_simulador.css')}}">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
@stop

@section('titulo')
	CREAR SIMULADOR
@stop

@section('home_url')
{{route('admin.courses.index')}}
@stop

@section('logout_url')
{{route('admin.auth.logout')}}
@stop

@section('contenido_web')

<div class="container-fluid container_crear_simulador">
	<div class="row info_simulador">
		<div class="col-sm-6 col-md-8 input_simulador">
		<form>
			<input type="text" name="nombre_simulador" placeholder="NOMBRE DEL SIMULADOR" id="name" value="{{$simulator->name or ''}}">
			<input type="text" name="codigo_simulador" placeholder="CÓDIGO DEL SIMULADOR" id="code" value="{{$simulator->product->code or ''}}">
		</form>
		</div>
		<div class="col-sm-6 col-md-4 text_add">
			Agrega a los alumnos
		</div>
	</div>

	
	<div class="row">
		<div class="col-sm-6 col-md-7 content_simulador">
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item">
			    	<a class="nav-link active" id="descripcion-tab" data-toggle="tab" href="#descripcion" role="tab" aria-controls="descripcion" aria-selected="true">Descripción</a>
			    </li>
			    <li class="nav-item">
			    	<a class="nav-link" id="materiales-tab" data-toggle="tab" href="#materiales" role="tab" aria-controls="materiales" aria-selected="false">Materiales</a>
			    </li>
			    <li class="nav-item">
			    	<a class="nav-link" id="examenes-tab" data-toggle="tab" href="#examenes" role="tab" aria-controls="examenes" aria-selected="false">Exámenes</a>
			    </li>
			    <li class="nav-item">
			    	<a class="nav-link" id="notas-tab" data-toggle="tab" href="#notas" role="tab" aria-controls="notas" aria-selected="false">Notas</a>
			    </li>
			</ul>
			<div class="tab-content" id="myTabContent">


				<!--///////////////////////////////////// TAB DE DESCRIPCION /////////////////////////////////-->
				<!--///////////////////////////////////////////////////////////////////////////////////////-->
				<div class="tab-pane fade show active" id="descripcion" role="tabpanel" aria-labelledby="descripcion-tab">
					<div class="container_descripcion">
						<form>
							<textarea id="description" placeholder="Ingresa la descripción del simulador" class="p-2">{{$simulator->description}}</textarea>
						</form>
					</div>
				</div>


				<!--///////////////////////////////////// TAB DE MATERIALES /////////////////////////////////-->
				<!--///////////////////////////////////////////////////////////////////////////////////////-->
				<div class="tab-pane fade" id="materiales" role="tabpanel" aria-labelledby="materiales-tab">
					<div class="container_materiales py-2 px-3" style="max-height: 423px;">
						
						<div class="row">
							
							<div class="col-sm-6 col-md-6 pl-1 container_attachments">				
								<h5 class="mb-2 py-1 pl-2">Material Agregado</h5>
								<div class="container-fluid contenedor_de_materiales" style="max-height: 340px; overflow-y: auto;">
                                @foreach($simulator->attachments as $attachment)
								<!-- INICIO DE MATERIAL AGREGADO 1 -->
								<div class="row my-1 added_material">
									<div class="col-sm-6 col-md-10 align-self-center pr-0 title_material">
										<a href="{{$attachment->url}}" download class="material_primero_href"><i class="fas fa-file-alt mr-2 text-dark"></i><span class="text-primary">{{$attachment->name}}</span></a>
									</div>
									<div class="col-sm-6 col-md-2 align-self-center pt-0  delete_material">
                                        <a href="{{route('admin.simulators.delete-attachment', [$simulator->id, $attachment->id])}}" class="text-danger" title="Borrar material"><i class="fas fa-trash-alt"></i></a>
									</div>
								</div>
								<!-- FIN DE MATERIAL AGREGADO 1 -->
                                @endforeach
                            	</div>
								
							</div>
							
							<div class="col-sm-6 col-md-6 container_add">
								<div class="row">
									<div class="col-sm-12 col-md-12 new_material">
										<h5 class="mb-2 py-1 pl-2">Agrega un nuevo material</h5>
										<form id="add_attachment_form" enctype="multipart/form-data">
                                            {!! csrf_field() !!}
											<input type="text" name="nombre_material" placeholder="Título del material" class="w-100">
											<input type="file" name="file_material">
										</form>
										<button class="btn btn-secondary mb-2 mt-1" id="add_attachment_button">Agregar material</button>
									</div>
								</div>	
							</div>
						</div>
						
					</div>
			       
				</div>

				<!--///////////////////////////////////// TAB DE EXAMENES /////////////////////////////////-->
				<!--///////////////////////////////////////////////////////////////////////////////////////-->
				<div class="tab-pane fade" id="examenes" role="tabpanel" aria-labelledby="examenes-tab">
					<div class="container_examenes py-2 px-3" style="max-height: 423px;">
						
						<div class="row">
							
							<div class="col-sm-6 col-md-6 pl-1 container_temas" style="max-height: 380px; overflow-y: auto;">
                                @foreach($exam_groups as $category_id => $group)
								<div class="added_tema" idTema = "{{ \App\SimulatorCategory::find($category_id)->id }}">
									<h5 class="titulo_area_examenes mb-2 py-1 pl-2"><i class="fas fa-sitemap text-dark mr-2" style="font-size: 12px; position: relative; top: -2px;"></i><span class="text-uppercase font-weight-bold" style="font-size: 16px;">{{\App\SimulatorCategory::find($category_id)->name}}</span></h5>
									<div class="container-fluid contenedor_de_examenes">
                                    @foreach($group as $exam)
									<div class="row my-1 added_examen">
										<div class="col-sm-6 col-md-10 align-self-center pr-0 title_examen">
											<i class="fas fa-file-alt text-dark mr-2"></i>
											<a href="{{route('admin.simulators.exams.edit', $exam->id)}}" class="text-primary titulo_row_exam">{{$exam->name}}</a>
										</div>
										<div class="col-sm-6 col-md-2 align-self-center pt-0  delete_examen">
                                            <a href="{{route('admin.simulators.exams.delete', $exam->id)}}" class="text-danger" title="Borrar examen">
                                                <span class="fas fa-trash-alt"></span>
                                            </a>
										</div>
									</div>
                                    @endforeach
                                    </div>
								</div>
                                @endforeach
							</div>
							
							<div class="col-sm-6 col-md-6 container_add">
								<div class="row">
									<div class="col-sm-12 col-md-12 new_tema">
										<h5 class="mb-2 py-1 pl-2">Agrega un nuevo tema</h5>
										<form id="category_form" class="mb-2">
                                            {!! csrf_field() !!}
											<input type="text" name="nombre_tema" placeholder="Título del tema" id="name_tema" class="w-100 mt-2">
										</form>
										<button class="btn btn-secondary mt-2" id="category_button">Agregar tema</button>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12 col-md-12 new_examen">
										<h5 class="mb-2 py-1 pl-2">Agrega un nuevo examen</h5>
										<!--<form method="post" action="{{route('admin.simulators.exams.create')}}" >-->
										<form id="add_preguntas_simulador_form" class="mb-2">
                                            {!! csrf_field() !!}
                                            <input type="hidden" name="simulator_id" id="simulator_id" value="{{request()->route('id')}}">
											<select name="category_id" id="category_select">
												<option value="" selected="true" disabled="disabled">Selecciona el tema</option>
                                                @foreach($categories as $category)
                                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                                @endforeach
											</select>
											<input type="text" name="nombre_examen" placeholder="Título del examen" id="name_material" class="mt-3 mb-2 w-100">
											<!--<button class="btn btn-secondary btn-add-questions mt-2">Agregar preguntas</button>-->
										</form>
										<button class="btn btn-secondary btn-add-questions mt-2">Agregar preguntas</button>
									</div>
								</div>	
							</div>
						</div>
						
					</div>
					
					
				</div>

				<!--//////////////////////////////////// TAB DE NOTAS //////////////////////////////////-->
				<!--///////////////////////////////////////////////////////////////////////////////////////-->
				<div class="tab-pane fade" id="notas" role="tabpanel" aria-labelledby="notas-tab">
					<div class="row no-gutters d-flex justify-content-between mt-3 mb-3">
							<div class="col-md-2 align-self-center">
								<a href="" class="btn btn-success" title="Descargar reporte"><i class="fas fa-file-excel"></i></a>
							</div>
							<div class="col-md-10 align-self-center">
								<div class="row no-gutters d-flex justify-content-around">
									<div class="col-3">
										<i class="fas fa-sitemap text-info"></i><span class="pl-2">Categorías</span>
									</div>
									<div class="col-3">
										<i class="fas fa-balance-scale text-danger"></i><span class="pl-2">Promedio</span>
									</div>
								</div>
							</div>
						</div>

					<div class="container-fluid px-0 mt-3">
						<div class="row no-gutters">
							<div class="col-12">
								<table class="table table-responsive table-hover table-bordered table-striped w-100 text-center">
									<thead class="thead-dark w-100">
										<tr>
											<th scope="col" class="font-weight-bold px-0" style="font-size: 14px; min-width: 170px; vertical-align: middle;">Nombre Completo</th>
											<th scope="col" class="font-weight-bold" style="font-size: 14px; min-width: 105px; vertical-align: middle;">DNI</th>
											@foreach($categories as $category)
								        	<th scope="col" class="font-weight-bold text-info w-100" style="font-size: 14px; min-width: 150px; max-width: 170px; vertical-align: middle;">{{$category->name}}</th>
								        	@endforeach
											<th scope="col" class="font-weight-bold text-danger" style="font-size: 14px; min-width: 105px; vertical-align: middle;">Promedio</th>
										</tr>
									</thead>
									<tbody>
                                        @foreach($simulator->product->students as $student)
										<tr>
											<td class="text-left pr-0 pl-2" style="font-size: 13.5px; vertical-align: middle;">{{$student->full_name}}</td>
											<td style="font-size: 13.5px;">{{$student->dni}}</td>
											@foreach($categories as $category)
								        	<td scope="col" class="font-weight-bold w-100" style="font-size: 14px; min-width: 150px; max-width: 170px; vertical-align: middle;">{{$category->name}}</td>
								        	@endforeach
								        	<td scope="col" class="font-weight-bold" style="font-size: 14px; min-width: 105px; vertical-align: middle;">Promedio</td>
											<!--<td></td>-->
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-5 people_simulador">
			<!-- ********************************************** ALUMNOS **************************************************-->
			<div class="option_alumno">
				<div class="row text_alumnos justify-content-center mt-3">
					ALUMNOS
				</div>
				<div class="row justify-content-between">
					<div class="col-md-6 add_alumno">
						<button class="btn btn-success" data-target="#popup_add_alumno" data-toggle="modal"><span class="fas fa-user-plus mr-2"></span><span>Crear nuevo alumno</span></button>
					</div>
					<div class="col-md-6 select_alumno">
						<button class="btn btn-primary" data-target="#popup_select_alumno" data-toggle="modal"><span class="fas fa-mouse-pointer mr-2"></span><span>Seleccionar alumnos</span></button>
					</div>
				</div>
				<div class="row added_alumnos">
					<table class="table table-responsive w-100 text-center mb-2" style="max-height: 350px;">
						<thead>
							<tr class="w-100">
								<th scope="col" width="33%" class="font-weight-bold px-0" style="font-size: 14px;">Nombre Completo</th>
								<th scope="col" width="33%" class="font-weight-bold px-0" style="font-size: 14px;">DNI</th>
								<th scope="col" width="33%" class="font-weight-bold px-0" style="font-size: 14px;">E-mail</th>
							</tr>
						</thead>
						<tbody>
							@foreach($simulator->product->students as $student)
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
</div>


<!-- *********************** INICIO POP-UP AGREGAR ALUMNO ************************* -->
<div class="modal fade" id="popup_add_alumno" tabindex="-1" role="dialog" aria-labelledby="popup_alumnoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="height: 450px;">
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
	      			<input type="file" id="file_new_alumno" name="image" class="img-fluid ml-4 mt-4">
	      		</div>
	      		<div class="col-sm-6 col-md-8 info_new_alumno">
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
<script>

/* Validar nuevo estudiante */

$("#file_new_alumno").change(function(){

	var imagen = this.files[0];

	if(imagen["type"] != "image/jpeg" && imagen["type"] != "image/png"){

		$("#file_new_alumno").val("");

		swal({
			type: "error",
			title: "Error al subir la imagen",
			text: "¡La imagen debe ser formato JPG o PNG!",
			confirmButtonText: "Cerrar"
		});

	}else if(imagen["size"] > 2000000){

		$("#file_new_alumno").val("");

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
	$('{{$target}}').click();
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

    //$('#category_select').change(function() {

    	//$('#descripcion').val($(e).val());(
    	//alert($(this).val());
    	//var valor_select_categoria = $(this).val();
    	//$("input[name='simulator_id']").val(valor_select_categoria);
    	//alert($('input#simulator_id').val());

    //});

    $('.btn-add-questions').on('click',function(ev){
    	ev.preventDefault();
    	//console.log($('#category_select').val())
    	if ($('#category_select').val()===null) {
    		swal("Debe seleccionar una categoría.", "", "info");
    	}else{
//console.log($(".container_temas .added_tema").size());
    		var fd = new FormData($('#add_preguntas_simulador_form')[0]);

	        $.ajax({
	            type: "POST",
	            url: "{{route('admin.simulators.exams.create')}}",
	            data: fd,
	            processData: false,
	            contentType: false,
	            success: function (data) {
	                var template = $('<div class="row my-1 added_examen"><div class="col-sm-6 col-md-10 align-self-center pr-0 title_examen"><i class="fas fa-file-alt text-dark mr-2"></i><a href="" class="text-primary titulo_row_exam"></a></div><div class="col-sm-6 col-md-2 align-self-center pt-0  delete_examen"><a href="" class="text-danger" title="Borrar examen"><span class="fas fa-trash-alt"></span></a></div></div>');
	                //var option_template = $('<option></option>');
	                template.find('a.titulo_row_exam').text(data.name);
	                //option_template.val(data.id);
	                //option_template.text(data.name);
	                //$(".container_temas .added_tema").each(function(){
		       		//    alert($(this).attr('idTema'));
		       		//});
		       		//console.log($(".container_temas .added_tema").attr("idTema"));
		       		//console.log($(".container_temas .added_tema").length);
	                //$('.container_temas').append(template);

	                var elementos_bloque = $(".added_tema");
	                //alert(elementos_bloque.length);
	                $(".added_tema").each(function(){
		        	    var atributo_idTema = $(this).attr('idTema');
		        	    if(atributo_idTema == data.category_id){
		        	    	$(this).find('.contenedor_de_examenes').append(template);
		        	    }
		        	});
	                //for(var i=0; i < elementos_bloque.length; i++){

	                	//alert($(this).attr('idTema'));
	                	//if($(this).attr('idTema') == data.category_id){
	                		//$(this).children('.contenedor_de_examenes').append(template);
	                	//}

	                //}
	                //alert(elementos_bloque.size());

	                $('input[name="nombre_examen"]').val('');
	                window.location.href = window.location.pathname + window.location.search + window.location.hash;
	                //$('#category_select').append(option_template);
	            }
	        });
    		//$('form').submit();
    	}
    });

    

    function limpiarAlumno(){

		$(".circle_photo").attr('src', '{{ asset("css/admin/docente_default.png")}}');
    	$("#file_new_alumno").val("");
        $("#dni_alumno").val("");
        $("#nombres_alumno").val("");
        $("#apellidos_alumno").val("");
        $("#telefono_alumno").val("");
        $("#email_empresarial_alumno").val("");
        $("#email_personal_alumno").val("");

   }


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
                limpiarAlumno();
                window.location.href = window.location.pathname + window.location.search + window.location.hash;
            }
        });

    });

    $('#name, #code, #description').keyup(function(){
        delay(function(){
            var name        = $('#name').val();
            var code        = $('#code').val();
            var description = $('#description').val();

            $.ajax({
                url: "{{route('admin.simulators.edit', request()->route('id'))}}",
                type: "POST",
                data: {
                    "name": name,
                    "code" : code,
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

    $('#assign_students').click(function(e){
        e.preventDefault();
        var students = $('input[name="checkbox_alumno[]"]:checked').val();

        $.ajax({
            url: "{{route('admin.simulators.edit', request()->route('id'))}}",
            type: "POST",
            data: {
                "students": added_students,
                "_token" : "{{csrf_token()}}"
            },
            success: function(){
            	window.location.href = window.location.pathname + window.location.search + window.location.hash;
            }
        }).done(function(data){
            $('#popup_select_alumno').modal('toggle');
        });
    });

    $('#add_attachment_button').click(function(){
        var fd = new FormData($('#add_attachment_form')[0]);
        $.ajax({
            type: "POST",
            url: "{{route('admin.simulators.add-attachment', $simulator->id)}}",
            data: fd,
            processData: false,
            contentType: false,
            success: function (data) {
                var template = $('<div class="row my-1 added_material"><div class="col-sm-6 col-md-10 align-self-center pr-0 title_material"><a href="" download class="material_primero_href"><i class="fas fa-file-alt mr-2 text-dark"></i><span class="text-primary"></span></a></div><div class="col-sm-6 col-md-2 align-self-center pt-0 delete_material"><a class="text-danger" title="Borrar material"><i class="fas fa-trash-alt"></i></a></div></div>');
                template.find('a.material_primero_href').attr('href', data.url);
                template.find('a.material_primero_href span').text(data.name);
                $('.contenedor_de_materiales').append(template);
                $('input[name="nombre_material"]').val('');
                $('input[name="file_material"]').val(null);

                window.location.href = window.location.pathname + window.location.search + window.location.hash;
            }
        });
    });

    $('#category_button').click(function(){
        var fd = new FormData($('#category_form')[0]);
        $.ajax({
            type: "POST",
            url: "{{route('admin.simulators.categories.create')}}",
            data: fd,
            processData: false,
            contentType: false,
            success: function (data) {
                var template = $('<div class="added_tema" idTema="'+data.id+'"><h5 class="titulo_area_examenes mb-2 py-1 pl-2"><i class="fas fa-sitemap text-dark mr-2" style="font-size: 12px; position: relative; top: -2px;"></i><span class="text-uppercase font-weight-bold" style="font-size: 16px;"></span></h5></div>');
                var option_template = $('<option></option>');
                template.find('h5.titulo_area_examenes span').text(data.name);
                //template.find('.added_tema').$(this).attr('idTema', data.id);
                option_template.val(data.id);
                option_template.text(data.name);
                $('.container_temas').append(template);
                $('input[name="nombre_tema"]').val('');
                $('#category_select').append(option_template);
            }
        });
    });
});
</script>

@stop