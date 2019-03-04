@extends('main.base_main')
@section('extra_css')
	<link rel="stylesheet" type="text/css" href="{{asset('bootstrap-tagsinput-latest/dist/bootstrap-tagsinput.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('bootstrap-tagsinput-latest/examples/assets/app.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('css/admin/style_crear_ejercicio.css')}}">
@stop

@section('titulo')
	CREAR TEMA
@stop

@section('home_url')
{{route('admin.courses.index')}}
@stop

@section('logout_url')
{{route('admin.auth.logout')}}
@stop

@section('contenido_web')

<div class="row">
	<div class="col-sm-12 col-md-6">

		<div class="container_crear_ejercicio">
			<div class="row buscar_pregunta">
				<div class="col-sm-12 col-md-12">
					<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#search_preguntas">Buscar pregunta en la base de datos</a>
				</div>
			</div>
			<div class="container_nueva_pregunta">
				<div class="row nueva_pregunta">
					<div class="col-sm-12 col-md-12">
						CREAR UNA NUEVA PREGUNTA<br><br>
						<select name="category_id" id="category">
							<option selected disabled>Selecciona el tipo</option>
							@foreach($categories as $category)
							<option value="{{$category->id}}">{{$category->name}}</option>
							@endforeach
						</select>

						<select id="group">
							<option selected disabled>Selecciona el grupo</option>
							@foreach($groups as $group)
							<option value="{{$group->id}}">{{$group->name}}</option>
							@endforeach
						</select>
						<br>
						<br>
						<select id="sub_group">
							<option selected disabled>Selecciona el sub-grupo</option>
							@foreach($sub_groups as $sub_group)
							<option value="{{$sub_group->id}}">{{$sub_group->name}}</option>
							@endforeach
						</select>
						
						<select name="subject_id" id="subject">
							<option selected disabled>Selecciona el tema</option>
							@foreach($subjects as $subject)
							<option value="{{$subject->id}}">{{$subject->name}}</option>
							@endforeach
						</select>
						<br>
						<br>
						<input type="text" name="keywords" data-role="tagsinput" id="keywords"  placeholder="Ingresar palabras claves">

						<select name="complexity_id" id="complexity">
							<option selected disabled>Selecciona la complejidad</option>
							@foreach($complexities as $complexity)
							<option value="{{$complexity->id}}">{{$complexity->name}}</option>
							@endforeach
						</select>
						<br>
						<br>
						<select name="type_id" id="type">
							<option selected disabled>Selecciona el tipo de respuesta</option>
							@foreach($types as $type)
							<option value="{{$type->id}}">{{$type->name}}</option>
							@endforeach
						</select>
					</div>
				</div>

				<!-- ********** RESPUESTA OPCION MULTIPLE (UNA SOLA RESPUESTA)********** -->
				<div class="tipo_respuesta" data-case="{{TYPE_SINGLE_RESPONSE}}" style="display: none;">
					<div class="row answer_type1">
						<div class="question">
							Opción múltiple - Una Sola Respuesta
						</div>
						<div class="col-sm-12 col-md-12 list_answer">
							<form>
								{!! csrf_field()!!}
								<textarea placeholder="Ingresa la pregunta e instrucciones" name="text"></textarea><br>
								<div class="upload_question">
									<input type="file" id="video-image" name="uploaded_question">
								</div>
								<span data-number="0"><input type="radio" name="respuesta" value=""> </span><input type="text" name="opcion[]" data-number="0" placeholder="Opción 1" class="option_pregunta"><span class="fas fa-trash-alt"></span><br>
								<span data-number="1"><input type="radio" name="respuesta" value=""> </span><input type="text" name="opcion[]" data-number="1" placeholder="Opción 2" class="option_pregunta"><span class="fas fa-trash-alt"></span><br>
								<!-- ****Boton para agregar pregunta**** -->
								<br>
								<button class="btn btn-secondary add-question">Agregar pregunta</button>
							</form>
						</div>
					</div>
				</div>
				<!-- ********** RESPUESTA OPCION MULTIPLE (MAS DE UNA RESPUESTA)********** -->
				<div class="tipo_respuesta" data-case="{{TYPE_MULTIPLE_RESPONSE}}" style="display: none;">
					<div class="row answer_type1">
						<div class="question">
							Opción múltiple - Más de una Respuesta
						</div>
						<div class="col-sm-12 col-md-12 list_answer">
							<form>
								{!! csrf_field()!!}
								<textarea placeholder="Ingresa la pregunta e instrucciones" name="text"></textarea><br>
								<div class="upload_question">
									<input type="file" id="video-image" name="uploaded_question">
									<span>
										<button class="btn btn-secondary">Agregar opción</button>
									</span>
								</div>
								<span data-number="0"><input type="checkbox" name="respuesta[]"> </span><input type="text" name="opcion[]" data-number="0" placeholder="Opción" class="option_pregunta"><span class="fas fa-trash-alt"></span><br>
								<span data-number="1"><input type="checkbox" name="respuesta[]"> </span><input type="text" name="opcion[]" data-number="1" placeholder="Opción" class="option_pregunta"><span class="fas fa-trash-alt"></span><br>
								<!-- ****Boton para agregar pregunta**** -->
								<br>
								<button class="btn btn-secondary add-question">Agregar pregunta</button>
							</form>
						</div>
					</div>
				</div>
				<!-- ********** RESPUESTA ABIERTA ********** -->
				<div class="tipo_respuesta" data-case="{{TYPE_OPEN_RESPONSE}}" style="display: none;">
					<div class="row answer_type1">
						<div class="question">
							Respuesta Abierta
						</div>
						<div class="col-sm-12 col-md-12 list_answer">
							<form enctype="multipart/form-data">
								{!! csrf_field()!!}
								<textarea placeholder="Ingresa la pregunta e instrucciones" name="text"></textarea><br>
								<div class="upload_question">
									<input type="file" id="video-image" name="uploaded_question">
								</div>
								<!-- ****Boton para agregar pregunta**** -->
								<br>
								<button class="btn btn-secondary add-question">Agregar pregunta</button>
							</form>
						</div>
					</div>
				</div>
				<!-- ********** RESPUESTA ABIERTA PARA SUBIR ARCHIVO ********** -->
				<div class="tipo_respuesta" data-case="{{TYPE_FILE_RESPONSE}}" style="display: none;">
					<div class="row answer_type1">
						<div class="question">
							Respuesta Abierta Para Subir Archivo
						</div>
						<div class="col-sm-12 col-md-12 list_answer">
							<form>
								{!! csrf_field()!!}
								<textarea placeholder="Ingresa la pregunta e instrucciones" name="text"></textarea><br>
								<div class="upload_question">
									<input type="file" id="video-image" name="uploaded_question">
								</div>
								<!-- ****Boton para agregar pregunta**** -->
								<br>
								<button class="btn btn-secondary add-question">Agregar pregunta</button>
							</form>
						</div>
					</div>
				</div>

				
			</div>

		</div>
		<br>
		<br>
	</div>

	<div class="col-sm-12 col-md-6 added_preguntas">
		<div class="container_added_preguntas">
			<h5>
				<div class="row">
					<div class="col-md-6">
						PREGUNTAS AGREGADAS
					</div>
					<div class="col-md-6 text_final_score">
						Puntaje total:<span><input type="number" name="final_score" class="final_score"></span>
					</div>
					
				</div>
			</h5>

			<!-- Pregunta agregada - opcion multiple - una respuesta -->
			<div class="row added_single" style="display: none;">
				<div class="col-md-9">
					<div class="text"></div>
					<br>
					<form>
					</form>
				</div>
				<div class="col-md-3 text_score">
					Puntaje:<span><input type="number" name="score" class="score"></span>
				</div>
			</div>
			<!-- Pregunta agregada - opcion multiple - multiples respuestas -->
			<div class="row added_multiple" style="display: none;">
				<div class="col-md-9">
					<div class="text"></div>
					<br>
					<form>
					</form>
				</div>
				<div class="col-md-3 text_score">
					Puntaje:<span><input type="number" name="score" class="score"></span>
				</div>
			</div>

			<!-- Pregunta agregada - respuesta abierta -->
			<div class="row added_open" style="display: none;">
				<div class="col-md-9">	
					<div class="text"></div>
					<br>
					<form>
					</form>
				</div>
				<div class="col-md-3 text_score">
					Puntaje:<span><input type="number" name="score" class="score"></span>
				</div>
			</div>
			<div class="row added_file" style="display: none;">
				<div class="col-md-9">
					<!-- Pregunta agregada - respuesta abierta (subir archivo) -->
					[text] (respuesta abierta - subir archivo)
					<br>
					<form>
					</form>
				</div>
				<div class="col-md-3 text_score">
					Puntaje:<span><input type="number" name="score" class="score"></span>
				</div>
			</div>

		</div>
	</div>
</div>


<!-- ********************************     POP-UP PARA BUSCAR PREGUNTAS **********************************-->
<div class="modal fade" id="search_preguntas" tabindex="-1" role="dialog" aria-labelledby="search_preguntasLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
    	<div class="modal-content">
    		<div class="modal-header">
        		<h5 class="modal-title" id="search_preguntas_title">
        			BUSQUEDA DE PREGUNTAS<br>

        		<form>
	        		<select>
						<option selected disabled>Selecciona el tipo</option>
						<option value="curso">Cursos</option>
						<option value="simuladores">Simuladores</option>
						<option value="evaluacion-habilidades">Evaluación de habilidades</option>
						<option value="homologacion">Homologación</option>
						<option value="crear-nuevo-tipo">...Crear nuevo</option>
					</select>

					<select>
						<option selected disabled>Selecciona el grupo</option>
						<option value="grupo1">Grupo 1</option>
						<option value="grupo2">Grupo 2</option>
						<option value="grupo3">Grupo 3</option>
						<option value="grupo4">Grupo 4</option>
						<option value="crear-nuevo-grupo">...Crear nuevo</option>
					</select>
					<select>
						<option selected disabled>Selecciona el sub-grupo</option>
						<option value="sub-grupo1">Sub-grupo 1</option>
						<option value="sub-grupo2">Sub-grupo 2</option>
						<option value="sub-grupo3">Sub-grupo 3</option>
						<option value="sub-grupo4">Sub-grupo 4</option>
						<option value="crear-nuevo-sub-grupo">...Crear nuevo</option>
					</select>
					<select>
						<option selected disabled>Selecciona el tema</option>
						<option value="tema1">Tema 1</option>
						<option value="tema2">Tema 2</option>
						<option value="tema3">Tema 3</option>
						<option value="tema4">Tema 4</option>
						<option value="crear-nuevo-tema">...Crear nuevo</option>
					</select>

					<select>
						<option selected disabled>Selecciona la complejidad</option>
						<option value="complejidad1">Complejidad 1</option>
						<option value="complejidad2">Complejidad 2</option>
						<option value="complejidad3">Complejidad 3</option>
						<option value="complejidad4">Complejidad 4</option>
						<option value="crear-nuevo-complejidad">...Crear nuevo</option>
					</select>
					
					<select>
						<option selected disabled>Selecciona el tipo de respuesta</option>
						<option value="complejidad1">Tema 1</option>
						<option value="complejidad2">Tema 2</option>
						<option value="complejidad3">Tema 3</option>
						<option value="complejidad4">Tema 4</option>
						<option value="crear-nuevo-complejidad">...Crear nuevo</option>
					</select>

					<input type="text" name="keywords" placeholder="Ingresar palabras claves">

					<button class="btn btn-secondary"><span class="fas fa-search"></span></button>
				</form>
        		</h5>
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          		<span aria-hidden="true">&times;</span>
        		</button>
      		</div>
      		<div class="modal-body">

      			<!-- PRIMERA PREGUNTA -->

      			<div class="row searched_question">
      				<div class="col-md-6">
      					Texto de pregunta
      				</div>
      				<div class="col-md-3">
      					Tipo de respuesta
      				</div>
      				<div class="col-md-3">
      					<input type="checkbox" name="select_question">
      				</div>
      			</div>

      			<!-- SEGUNDA PREGUNTA -->
      			<div class="row searched_question">
      				<div class="col-md-6">
      					Texto de pregunta
      				</div>
      				<div class="col-md-3">
      					Tipo de respuesta
      				</div>
      				<div class="col-md-3">
      					<input type="checkbox" name="select_question">
      				</div>
      			</div>
        		



      		</div>
      		<div class="modal-footer">
        		<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
       			<button type="button" class="btn btn-primary">Save changes</button>
    		</div>
    	</div>
	</div>
</div>








@stop


@section('extra_scripts')
<script type="text/javascript" src="{{asset('bootstrap-tagsinput-latest/dist/bootstrap-tagsinput.js')}}"></script>
<script type="text/javascript" src="{{asset('js/typehead.js')}}"></script>
<script type="text/javascript" src="{{asset('bootstrap-tagsinput-latest/examples/assets/app.js')}}"></script>
<script>

var labelnames = new Bloodhound({
	datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
	queryTokenizer: Bloodhound.tokenizers.whitespace,
	prefetch: {
		url: "{{route('admin.keywords.json-all')}}",
		filter: function(list) {
			return $.map(list, function(tagname) {
				return { name: tagname }; });
		}
	}
});

var template_added_single   = $('.added_single');
var template_added_multiple = $('.added_multiple');
var template_added_open     = $('.added_open');
var template_added_file     = $('.added_file');

labelnames.initialize();

$('input[name="keywords"]').tagsinput({
	typeaheadjs: {
		name: 'labelnames',
		displayKey: 'name',
		valueKey: 'name',
		source: labelnames.ttAdapter()
	}
});

$('#type').change(function(){
	var value = $(this).val();

	switch(value){
		case "{{TYPE_SINGLE_RESPONSE}}": {
			$('div.tipo_respuesta').css('display', 'none');
			$('div[data-case="{{TYPE_SINGLE_RESPONSE}}"]').css('display', 'block');
			break;
		}
		case "{{TYPE_MULTIPLE_RESPONSE}}": {
			$('div.tipo_respuesta').css('display', 'none');
			$('div[data-case="{{TYPE_MULTIPLE_RESPONSE}}"]').css('display', 'block');
			break;
		}
		case "{{TYPE_OPEN_RESPONSE}}": {
			$('div.tipo_respuesta').css('display', 'none');
			$('div[data-case="{{TYPE_OPEN_RESPONSE}}"]').css('display', 'block');
			break;
		}
		case "{{TYPE_FILE_RESPONSE}}": {
			$('div.tipo_respuesta').css('display', 'none');
			$('div[data-case="{{TYPE_FILE_RESPONSE}}"]').css('display', 'block');
			break;
		}
	}
});

$('.add-question').click(function(e){
	e.preventDefault();
    var fd = new FormData($(this).parent()[0]);
    fd.append($('#category').attr('name'), $('#category').val());
    fd.append($('#subject').attr('name'), $('#subject').val());
    fd.append($('#keywords').attr('name'), $('#keywords').val());
    fd.append($('#complexity').attr('name'), $('#complexity').val());
    fd.append($('#type').attr('name'), $('#type').val());

    $.ajax({
        type: "POST",
        url: "{{route('admin.questions.create')}}",
        data: fd,
        processData: false,
        contentType: false,
        success: function (data) {
        	var type = data.type_id;
        	var container = $('.container_added_preguntas');
        	switch(type){
        		case "{{TYPE_SINGLE_RESPONSE}}": {
        			var duplicated = template_added_single.clone();
        			var correct = data.correct_responses_names[0];
        			duplicated.find('.text').text(data.text +  ' (opcion multiple - una respuesta)');
        			for(var i = 0; i< data.response_templates.length ; i++) {
        				var res_template = data.response_templates[i];
        				duplicated.find('form').append('<input type="radio" name="respuesta" value="' + res_template.value + '"' + (correct == res_template.value ? 'checked' : '') + ' disabled>' + res_template.value + '<br>')
        			}

        			duplicated.show();
        			container.append(duplicated);
        			break;
        		}
        		case "{{TYPE_MULTIPLE_RESPONSE}}": {
        			var duplicated = template_added_multiple.clone();
        			var correct = data.correct_responses_names;
        			duplicated.find('.text').text(data.text +  ' (opcion multiple - multiples respuestas)');
        			for(var i = 0; i< data.response_templates.length ; i++) {
        				var res_template = data.response_templates[i];
        				duplicated.find('form').append('<input type="checkbox" name="respuesta" value="' + res_template.value + '"' + (correct.includes(res_template.value) ? 'checked' : '') + ' disabled>' + res_template.value + '<br>')
        			}

        			duplicated.show();
        			container.append(duplicated);
        			break;
        		}
        		case "{{TYPE_OPEN_RESPONSE}}": {
        			var duplicated = template_added_open.clone();
        			duplicated.find('.text').text(data.text +  ' (respuesta abierta)');
        			duplicated.find('form').append('<textarea disabled></textarea>');
        			duplicated.show();
        			container.append(duplicated);
        			break;
        		}
        		case "{{TYPE_FILE_RESPONSE}}": {
        			var duplicated = template_added_file.clone();
        			duplicated.find('.text').text(data.text +  ' (respuesta abierta - subir archivo)');
        			duplicated.find('form').append('<input type="file" name="uploaded_answer" disabled>');
        			duplicated.find('form').append('<textarea disabled></textarea>');
        			duplicated.show();
        			container.append(duplicated);
        			break;
        		}
        	}
        }
    });
});

$('.option_pregunta').change(function(){
	var val = $(this).val();
	$(this).siblings("span[data-number=" + $(this).data('number') + "]").find('input').val(val);
});
</script>

@stop