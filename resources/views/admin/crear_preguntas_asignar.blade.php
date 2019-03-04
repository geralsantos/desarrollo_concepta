@extends('main.base_main')
@section('extra_css')
    <link rel="stylesheet" type="text/css" href="{{asset('bootstrap-tagsinput-latest/dist/bootstrap-tagsinput.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('bootstrap-tagsinput-latest/examples/assets/app.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/admin/style_crear_preguntas.css')}}">
@stop

@section('titulo')
    FORMULARIO
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

        <div class="container_crear_ejercicio mt-3 mb-2 rounded">
            <div class="row buscar_pregunta">
                <div class="col-sm-12 col-md-12">
                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#search_preguntas">Buscar pregunta en la base de datos</button>
                </div>
            </div>
            <div class="container_nueva_pregunta">
                <div class="row nueva_pregunta">
                    <div class="col-sm-12 col-md-12">
                        <h5>CREAR UNA NUEVA PREGUNTA</h5>
                        <select id="product">
                            <option val="" selected>Selecciona el producto</option>
                            @foreach($products as $product)
                            <option value="{{$product->id}}">{{$product->name}}</option>
                            @endforeach
                        </select>
                        <select id="category">
                            <option val="" selected>Selecciona el tipo</option>
                            @foreach($categories as $category)
                            <option value="{{$category->id}}" data-parent="{{$category->product_type_id}}">{{$category->name}}</option>
                            @endforeach
                        </select>

                        <select id="group">
                            <option val="" selected>Selecciona el grupo</option>
                            @foreach($groups as $group)
                            <option value="{{$group->id}}" data-parent="{{$group->category_id}}">{{$group->name}}</option>
                            @endforeach
                        </select>
                        <select id="sub_group">
                            <option val="" selected>Selecciona el sub-grupo</option>
                            @foreach($sub_groups as $sub_group)
                            <option value="{{$sub_group->id}}" data-parent="{{$sub_group->group_id}}">{{$sub_group->name}}</option>
                            @endforeach
                        </select>

                        <select name="subject_id" id="subject">
                            <option val="" selected>Selecciona el tema</option>
                            @foreach($subjects as $subject)
                            <option value="{{$subject->id}}" data-parent="{{$subject->sub_group_id}}">{{$subject->name}}</option>
                            @endforeach
                        </select>
                        <select name="complexity_id" id="complexity">
                            <option selected disabled>Selecciona la complejidad</option>
                            @foreach($complexities as $complexity)
                            <option value="{{$complexity->id}}">{{$complexity->name}}</option>
                            @endforeach
                        </select>
                        <select name="type_id" id="type" onchange="mySelectionFunction()">
                            <option selected disabled>Selecciona el tipo de respuesta</option>
                            @foreach($types as $type)
                            <option value="{{$type->id}}">{{$type->name}}</option>
                            @endforeach
                        </select>
                        <br>
                        <br>
                        <input type="text" name="keywords"  id="keywords"  placeholder="Ingresar palabras claves">
                    </div>
                </div>

                <!-- ********** RESPUESTA OPCION MULTIPLE (UNA SOLA RESPUESTA)********** -->
                <div class="tipo_respuesta" data-case="{{TYPE_SINGLE_RESPONSE}}" style="display: none;">
                    <div class="row answer_type1">
                        <div class="question">
                            Opción múltiple - Una Sola Respuesta
                        </div>
                        <div class="col-sm-12 col-md-12 list_answer px-4">
                            <form>
                                {!! csrf_field()!!}
                                <textarea placeholder="Ingresa la pregunta e instrucciones" name="text" class="w-100 p-2"></textarea><br>
                                <div class="upload_question">
                                    <!-- Seleccionar video o imagen -->
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 select_type">
                                            <h5>Contenido introductorio del curso</h5>
                                            <select onchange="mySelectionFunction()" id="selection_one" name="select_video_imagen">
                                                <option selected="true" value="">Selecciona el tipo de contenido</option>
                                                @foreach($multimedia_types as $type)
                                                    <option value="{{$type->id}}">{{$type->name}}</option>

                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Guardar video o imagen -->
                                    <input class="upload_video" type="url" id="upload_video_one" name="link_video_one" placeholder="Ingresa el link del video" style="display: none">
                                    <input class="upload_image" type="file" id="upload_image_one" name="uploaded_image_one" style="display: none">
                                </div>
                                <div id="response_templates_multiple px-2" class="opt_repository">
                                    <div class="opt opt_single row mb-2">
                                        <div class="col-10">
                                             <span data-number="0"><input type="radio" name="respuesta" value=""> </span><input type="text" name="opcion[]" data-number="0" placeholder="Opción" class="option_pregunta" style="width: 95%; display: inline-block;">
                                        </div>
                                        <div class="col-2">
                                            <span class="d-inline-block delete-single-opt fas fa-trash-alt"></span>
                                        </div>

                                    </div>
                                    <div class="opt opt_single row mb-2">
                                        <div class="col-10">
                                             <span data-number="1"><input type="radio" name="respuesta" value=""> </span><input type="text" name="opcion[]" data-number="1" placeholder="Opción" class="option_pregunta" style="width: 95%; display: inline-block;">
                                        </div>
                                        <div class="col-2">
                                            <span class="d-inline-block delete-single-opt fas fa-trash-alt"></span>
                                        </div>
                                    </div>
                                </div>
                                <!-- ****Boton para agregar pregunta**** -->
                                <br>
                                <a class="btn btn-secondary add-opt-single" href="#" role="button">Agregar opción</a>
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
                        <div class="col-sm-12 col-md-12 list_answer px-4">
                            <form>
                                {!! csrf_field()!!}
                                <textarea placeholder="Ingresa la pregunta e instrucciones" name="text" class="w-100 p-2"></textarea><br>
                                <div class="upload_question">
                                    <!-- Seleccionar video o imagen -->
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 select_type">
                                            <h5>Contenido introductorio del curso</h5>
                                            <select onchange="mySelectionFunction()" id="selection_two" name="select_video_imagen">
                                                <option selected="true" value="">Selecciona el tipo de contenido</option>
                                                @foreach($multimedia_types as $type)
                                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Guardar video o imagen -->
                                    <input class="upload_video" type="text" id="upload_video_two" name="link_video_two" placeholder="Ingresa el link del video" style="display: none">
                                    <input class="upload_image" type="file" id="upload_image_two" name="uploaded_image_two" style="display: none">
                                </div>
                                <div id="response_templates_multiple" class="opt_repository">
                                    <div class="opt opt_multiple row mb-2">
                                        <div class="col-10">
                                             <span data-number="0"><input type="checkbox" name="respuesta[]" value=""> </span><input type="text" name="opcion[]" data-number="0" placeholder="Opción" class="option_pregunta" style="width: 95%; display: inline-block;">
                                        </div>
                                        <div class="col-2">
                                            <span class="d-inline-block delete-single-opt fas fa-trash-alt"></span>
                                        </div>
                                    </div>
                                    <div class="opt opt_multiple row mb-2">
                                        <div class="col-10">
                                             <span data-number="1"><input type="checkbox" name="respuesta[]"> </span><input type="text" name="opcion[]" data-number="1" placeholder="Opción" class="option_pregunta" style="width: 95%; display: inline-block;">
                                        </div>
                                        <div class="col-2">
                                            <span class="d-inline-block delete-single-opt fas fa-trash-alt"></span>
                                        </div>
                                    </div>
                                </div>
                                <!-- ****Boton para agregar pregunta**** -->
                                <br>
                                <a class="btn btn-secondary add-opt-multiple" href="#" role="button">Agregar opción</a>
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
                        <div class="col-sm-12 col-md-12 list_answer px-4">

                            <form enctype="multipart/form-data">
                                {!! csrf_field()!!}
                                <textarea placeholder="Ingresa la pregunta e instrucciones" name="text" class="w-100 p-2"></textarea><br>
                                <div class="upload_question">
                                    <!-- Seleccionar video o imagen -->
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 select_type">
                                            <h5>Contenido introductorio del curso</h5>
                                            <select onchange="mySelectionFunction()" id="selection_three" name="select_video_imagen" required>
                                                <option selected="true" value="">Selecciona el tipo de contenido</option>
                                                @foreach($multimedia_types as $type)
                                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Guardar video o imagen -->
                                    <input class="upload_video" type="text" id="upload_video_three" name="link_video_three" placeholder="Ingresa el link del video" style="display: none">
                                    <input class="upload_image" type="file" id="upload_image_three" name="uploaded_image_three" style="display: none">
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
                        <div class="col-sm-12 col-md-12 list_answer px-4">
                            <form>
                                {!! csrf_field()!!}
                                <textarea placeholder="Ingresa la pregunta e instrucciones" name="text" class="w-100 p-2"></textarea><br>
                                <div class="upload_question">
                                    <!-- Seleccionar video o imagen -->
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 select_type">
                                            <h5>Contenido introductorio del curso</h5>
                                            <select onchange="mySelectionFunction()" id="selection_four" name="select_video_imagen">
                                                <option selected="true" value="">Selecciona el tipo de contenido</option>
                                                @foreach($multimedia_types as $type)
                                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Guardar video o imagen -->
                                    <input class="upload_video" type="text" id="upload_video_four" name="link_video_four" placeholder="Ingresa el link del video" style="display: none">
                                    <input class="upload_image" type="file" id="upload_image_four" name="uploaded_image_four" style="display: none">
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
    </div>

    <!--///////////////////////////// PREGUNTAS AGREGADAS A LA DERECHA ///////////////////////////////////-->
    <div class="col-sm-12 col-md-6 added_preguntas">
        <div class="container_added_preguntas mt-3 rounded mb-2">
            <form method="post" action="{{route('admin.questions.sync')}}" id="questions_form">
            {!! csrf_field() !!}
                <h5>
                    <div class="row">
                        <div class="col-md-6">
                            PREGUNTAS AGREGADAS
                        </div>
                        <div class="col-md-3 text_time">
                            @if(request('entity_name') == ENTITY_EXERCISE)
                            Tiempo:<span><input type="number" name="duration" class="time text-center rounded" value="{{\App\Exercise::find(request('entity_id'))->duration}}"></span>
                            @elseif(request('entity_name') == ENTITY_COURSE_EXAM)
                            Tiempo:<span><input type="number" name="duration" class="time text-center rounded" value="{{\App\CourseExam::find(request('entity_id'))->duration}}"></span>
                            @elseif(request('entity_name') == ENTITY_ACTIVITY)
                            Tiempo:<span><input type="number" name="duration" class="time text-center rounded" value="{{\App\Activity::find(request('entity_id'))->duration}}"></span>
                            @elseif(request('entity_name') == ENTITY_SIMULATOR_EXAM)
                            Tiempo:<span><input type="number" name="duration" class="time text-center rounded" value="{{\App\SimulatorExam::find(request('entity_id'))->duration}}"></span>
                            @endif
                        </div>
                        <div class="col-md-3 text_final_score">
                            Puntaje total:<span><input type="number" name="final_score" class="final_score text-center rounded"></span>
                        </div>

                    </div>
                </h5>
                <input type="hidden" name="entity_name" value="{{request()->get('entity_name')}}">
                <input type="hidden" name="entity_id" value="{{request()->get('entity_id')}}">
                <div id="pulled_questions" class="mt-4">
                    @foreach($entity->questions()->withPivot('score')->get() as $question)
                        @if($question->type_id == TYPE_SINGLE_RESPONSE)
                            <div class="row pulled_questions">
                                <div class="col-md-7 text-left">
                                    <div class="text">
                                       {{$loop->iteration}}. {{$question->text}} (opcion multiple - una respuesta)
                                    </div>
                                    @if($question->attachment_type_id == MULTIMEDIA_TYPE_VIDEO_EMBED)
                                    <!-- Esto se muestra en caso de que sea un video -->
                                    <div class="video_pregunta">
                                        <iframe src="{{asset($question->attachment)}}" allowfullscreen></iframe>
                                    </div>
                                    <br>
                                    <!-- Esto se muestra en caso de que sea un video -->
                                    @elseif($question->attachment_type_id == MULTIMEDIA_TYPE_IMAGE)
                                    <!-- Esto se muestra en caso de que sea una imagen -->
                                    <div class="imagen_pregunta">
                                        <img src="{{asset($question->attachment)}}" class="img-fluid imagen_de_preguntas text-center">
                                    </div>
                                    <br>
                                    <!-- Esto se muestra en caso de que sea una imagen -->
                                    @endif
                                    @foreach($question->response_templates as $option)
                                    <input type="radio" class="mr-2" value='{{$option->value}}' + {{($question->correct_responses()->pluck('value')->contains($option->value) ? 'checked' : '')}} disabled> {{$option->value}} <br>
                                    @endforeach
                                </div>
                                <div class="col-md-3 text-center text_score">
                                    Puntaje:<span><input type="number" name="questions[{{$question->id}}][score]" class="score text-center rounded" value="{{$question->pivot->score}}" required></span>
                                </div>
                                <div class="col-md-2 text-center question_delete">
                                    <a href="{{route('admin.questions.detach', ['entity_name' => request('entity_name'), 'entity_id' => request('entity_id'), 'question_id' => $question->id])}}" class="text-danger" title="Eliminar pregunta"><span class="fas fa-trash-alt mt-4"></span></a>
                                </div>
                            </div>
                        @elseif($question->type_id == TYPE_MULTIPLE_RESPONSE)
                            <div class="row pulled_questions">
                                <div class="col-md-7 text-left">
                                    <div class="text">
                                        {{$loop->iteration}}. {{$question->text}} (opcion multiple - multiples respuestas)
                                    </div>
                                    <br>
                                    @if($question->attachment_type_id == MULTIMEDIA_TYPE_VIDEO_EMBED)
                                    <!-- Esto se muestra en caso de que sea un video -->
                                    <div class="video_pregunta">
                                        <iframe src="{{asset($question->attachment)}}" allowfullscreen></iframe>
                                    </div>
                                    <br>
                                    <!-- Esto se muestra en caso de que sea un video -->
                                    @elseif($question->attachment_type_id == MULTIMEDIA_TYPE_IMAGE)
                                    <!-- Esto se muestra en caso de que sea una imagen -->
                                    <div class="imagen_pregunta">
                                        <img src="{{asset($question->attachment)}}" class="img-fluid imagen_de_preguntas text-center">
                                    </div>
                                    <br>
                                    <!-- Esto se muestra en caso de que sea una imagen -->
                                    @endif
                                    @foreach($question->response_templates as $option)
                                    <input type="checkbox" class="mr-2" value='{{$option->value}}' + {{($question->correct_responses()->pluck('value')->contains($option->value) ? 'checked' : '')}} disabled> {{$option->value}} <br>
                                    @endforeach
                                </div>
                                <div class="col-md-3 text-center text_score">
                                    Puntaje:<span><input type="number" name="questions[{{$question->id}}][score]" class="score text-center rounded" value="{{$question->pivot->score}}" required></span>
                                </div>
                                <div class="col-md-2 text-center question_delete">
                                    <a href="{{route('admin.questions.detach', ['entity_name' => request('entity_name'), 'entity_id' => request('entity_id'), 'question_id' => $question->id])}}" class="text-danger" title="Eliminar pregunta"><span class="fas fa-trash-alt mt-4"></span></a>
                                </div>
                            </div>
                        @elseif($question->type_id == TYPE_OPEN_RESPONSE)
                            <div class="row pulled_questions">
                                <div class="col-md-7 text-left">
                                    <div class="text">
                                    {{$loop->iteration}}. {{$question->text}} (respuesta abierta)
                                    </div>
                                    @if($question->attachment_type_id == MULTIMEDIA_TYPE_VIDEO_EMBED)
                                    <!-- Esto se muestra en caso de que sea un video -->
                                    <div class="video_pregunta">
                                        <iframe src="{{asset($question->attachment)}}" allowfullscreen></iframe>
                                    </div>
                                    <br>

                                    <!-- Esto se muestra en caso de que sea un video -->
                                    @elseif($question->attachment_type_id == MULTIMEDIA_TYPE_IMAGE)
                                    <!-- Esto se muestra en caso de que sea una imagen -->
                                    <div class="imagen_pregunta">
                                        <img src="{{asset($question->attachment)}}" class="img-fluid imagen_de_preguntas text-center">
                                    </div>
                                    <br>
                                    <!-- Esto se muestra en caso de que sea una imagen -->
                                    @endif
                                    <textarea disabled class="mt-3"></textarea>
                                </div>
                                <div class="col-md-3 text-center text_score">
                                    Puntaje:<span><input type="number" name="questions[{{$question->id}}][score]" class="score text-center rounded" value="{{$question->pivot->score}}" required></span>
                                </div>
                                <div class="col-md-2 text-center question_delete">
                                    <a href="{{route('admin.questions.detach', ['entity_name' => request('entity_name'), 'entity_id' => request('entity_id'), 'question_id' => $question->id])}}" class="text-danger" title="Eliminar pregunta"><span class="fas fa-trash-alt mt-4"></span></a>
                                </div>
                            </div>
                        @elseif($question->type_id == TYPE_FILE_RESPONSE)
                            <div class="row pulled_questions">
                                <div class="col-md-7 text-left">
                                    <div class="text">
                                    {{$loop->iteration}}. {{$question->text}} (respuesta abierta - subir archivo)
                                    </div>
                                    @if($question->attachment_type_id == MULTIMEDIA_TYPE_VIDEO_EMBED)
                                    <!-- Esto se muestra en caso de que sea un video -->
                                    <div class="video_pregunta">
                                        <iframe src="{{asset($question->attachment)}}" allowfullscreen></iframe>
                                    </div>
                                    <br>
                                    <!-- Esto se muestra en caso de que sea un video -->
                                    @elseif($question->attachment_type_id == MULTIMEDIA_TYPE_IMAGE)
                                    <!-- Esto se muestra en caso de que sea una imagen -->
                                    <div class="imagen_pregunta">
                                        <img src="{{asset($question->attachment)}}" class="img-fluid imagen_de_preguntas text-center">
                                    </div>
                                    <br>
                                    <!-- Esto se muestra en caso de que sea una imagen -->
                                    @endif
                                    <input type="file" disabled>
                                    <textarea disabled class="mt-3"></textarea>
                                </div>
                                <div class="col-md-3 text-center text_score">
                                    Puntaje: <span><input type="number" name="questions[{{$question->id}}][score]" class="score text-center rounded" value="{{$question->pivot->score}}" required></span>
                                </div>
                                <div class="col-md-2 text-center question_delete">
                                    <a href="{{route('admin.questions.detach', ['entity_name' => request('entity_name'), 'entity_id' => request('entity_id'), 'question_id' => $question->id])}}" class="text-danger" title="Eliminar pregunta"><span class="fas fa-trash-alt mt-4"></span></a>
                                </div>
                            </div>
                        @endif
                    @endforeach

                    <!-- Pregunta agregada - opcion multiple - una respuesta -->
                    <div class="row added_template added_single" style="display: none;">
                        <div class="col-md-7 text-left">
                            <div class="text"></div>
                            <div class="response_templates_container"></div>
                        </div>
                        <div class="col-md-3 text-centers text_score">
                            Puntaje: <span><input type="number" name="score" class="score text-center rounded" value="0"></span>
                        </div>
                        <div class="col-md-2 text-center question_delete">
                            <a class="delete-dynamic text-danger" href="#" title="Eliminar pregunta"><span class="fas fa-trash-alt mt-4"></span></a>
                        </div>
                    </div>
                    <!-- Pregunta agregada - opcion multiple - multiples respuestas -->
                    <div class="row added_template added_multiple" style="display: none;">
                        <div class="col-md-7 text-left">
                            <div class="text"></div>
                            <div class="response_templates_container"></div>
                        </div>
                        <div class="col-md-3 text-center text_score">
                            Puntaje: <span><input type="number" name="score" class="score text-center rounded" value="0"></span>
                        </div>
                        <div class="col-md-2 text-center question_delete">
                            <a class="delete-dynamic text-danger" href="#" title="Eliminar pregunta"><span class="fas fa-trash-alt mt-4"></span></a>
                        </div>
                    </div>

                    <!-- Pregunta agregada - respuesta abierta -->
                    <div class="row added_template added_open" style="display: none;">
                        <div class="col-md-7 text-left">
                            <div class="text"></div>
                            <div class="response_templates_container"></div>
                        </div>
                        <div class="col-md-3 text-center text_score">
                            Puntaje: <span><input type="number" name="score" class="score text-center rounded" value="0"></span>
                        </div>
                        <div class="col-md-2 text-center question_delete">
                            <a class="delete-dynamic text-danger" href="#" title="Eliminar pregunta"><span class="fas fa-trash-alt mt-4"></span></a>
                        </div>
                    </div>
                    <div class="row added_template added_file" style="display: none;">
                        <div class="col-md-7 text-left">
                            <!-- Pregunta agregada - respuesta abierta (subir archivo) -->
                            <div class="text"></div>
                            <div class="response_templates_container"></div>
                        </div>
                        <div class="col-md-3 text-center text_score">
                            Puntaje: <span><input type="number" name="score" class="score text-center rounded" value="0"></span>
                        </div>
                        <div class="col-md-2 text-center question_delete">
                            <a class="delete-dynamic text-danger" href="#" title="Eliminar pregunta"><span class="fas fa-trash-alt mt-4"></span></a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- ********************************     POP-UP PARA BUSCAR PREGUNTAS **********************************-->
<div class="modal fade" id="search_preguntas" tabindex="-1" role="dialog" aria-labelledby="search_preguntasLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header row no-gutters" id="header_search_preguntas">
                <div class="col-11">
                    <h5 class="modal-title w-100" id="search_preguntas_title">
                        BÚSQUEDA DE PREGUNTAS<br>
                        <form>
                            {!! csrf_field() !!}
                            <select name="product_type_id">
                                <option selected disabled>Selecciona el producto</option>
                                @foreach($products as $product)
                                <option value="{{$product->id}}">{{$product->name}}</option>
                                @endforeach
                            </select>
                            <select name="category_id">
                                <option selected disabled>Selecciona el tipo</option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                            <select>
                                <option selected disabled>Selecciona el grupo</option>
                                @foreach($groups as $group)
                                <option value="{{$group->id}}">{{$group->name}}</option>
                                @endforeach
                            </select>
                            <select>
                                <option selected disabled>Selecciona el sub-grupo</option>
                                @foreach($sub_groups as $sub_group)
                                <option value="{{$sub_group->id}}">{{$sub_group->name}}</option>
                                @endforeach
                            </select>
                            <select name="subject_id">
                                <option selected disabled>Selecciona el tema</option>
                                @foreach($subjects as $subject)
                                <option value="{{$subject->id}}">{{$subject->name}}</option>
                                @endforeach
                            </select>
                            <select name="complexity_id">
                                <option selected disabled>Selecciona la complejidad</option>
                                @foreach($complexities as $complexity)
                                <option value="{{$complexity->id}}">{{$complexity->name}}</option>
                                @endforeach
                            </select>

                            <select name="type_id">
                                <option selected disabled>Selecciona el tipo de respuesta</option>
                                @foreach($types as $type)
                                <option value="{{$type->id}}">{{$type->name}}</option>
                                @endforeach
                            </select>
                            <br>
                            <button class="btn btn-secondary" id="filter">
                                <span class="fas fa-search"></span> Buscar preguntas</button>
                        </form>
                    </h5>
                </div>
                <div class="col-1">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <input type="text" name="keywords" placeholder="Ingresar palabras claves">
                <!--
                <div class="col-9">
                    <input type="text" name="" placeholder="Buscar por palabras clave ..." value="  ">
                </div>
                <div class="col-3">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </div>
                -->
            </div>
            <div class="modal-body" id="search_content">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="pull_selected">Agregar</button>
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


// function type_selection(that) {

//     if (that.value == "{{MULTIMEDIA_TYPE_VIDEO_EMBED}}") {
//         $('#upload_video').show();
//         document.getElementById("upload_image").style.display = "none";
//     } else if (that.value == "{{MULTIMEDIA_TYPE_IMAGE}}"){
//         $('#upload_image').show();
//         document.getElementById("upload_video").style.display = "none";
//     }
// }

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
var container = $('#pulled_questions');
var result_repository = [];
var total_questions = {{$entity->questions()->count()}};
var count_single_opt = 2;
var count_multiple_opt = 2;

labelnames.initialize();
calculateTotalScore();

$('input[name="keywords"]').tagsinput({
    typeaheadjs: {
        name: 'labelnames',
        displayKey: 'name',
        valueKey: 'name',
        source: labelnames.ttAdapter()
    }
});
function validForm(e){
  e.preventDefault();
  let tiempo = $('#questions_form .time').val(), p_total=$('#questions_form .final_score').val(), puntajes=$('#questions_form .row.pulled_questions,#questions_form .row.added_template');
  let inputs = [tiempo, p_total];
  var response = true;
    for (var i = 0; i < inputs.length; i++) {
      if (inputs[i]==0 || inputs[i]=="") {
        swal({
            icon: 'warning',
            title: 'Error',
            text: 'El formulario debe tener: Tiempo y/o Puntaje Total'
        });
        response=false;
        return false;
      }
    }
    let x = 0,xx=0;
  puntajes.each(function(e,i){
    if ($(this).css('display')!='none')
    {
      puntaje = $(this).children('.text_score').children('span').children('.score').val();
      if (puntaje==0 || puntaje=="")
      {
        swal({
            icon: 'warning',
            title: 'Error',
            text: 'El formulario debe tener: Preguntas con su puntaje'
        });
        x++;
        response=false;
        return false;
      }
      xx++;
    }
  });
  if (response && xx==0) {
    swal({
        icon: 'warning',
        title: 'Error',
        text: 'El formulario debe tener Preguntas'
    });
    response=false;
    return false;
  }
  if (response) {
    $('#questions_form').submit();
  }
}
    $('#questions_form').append('<button type="button" onclick="validForm(event)" id="save" class="mb-4">Guardar</button>');



// function selectedTypeOne() {
//     var selectOne = document.getElementById("selection_one").value;
//     if (selectOne = "{{MULTIMEDIA_TYPE_VIDEO_EMBED}}") {
//         $('#upload_video').show();
//         document.getElementById("upload_image").style.display = "none";
//         document.write(selectOne);

//     } else if (selectOne = "{{MULTIMEDIA_TYPE_IMAGE}}"){
//         $('#upload_image').show();
//         document.getElementById("upload_video").style.display = "none";
//         document.write(selectOne);
//     }
// }


function mySelectionFunction(){
    var value = document.getElementById("type").value;

    switch(value){
        case "{{TYPE_SINGLE_RESPONSE}}":
            $('div.tipo_respuesta').css('display', 'none');
            $('div[data-case="{{TYPE_SINGLE_RESPONSE}}"]').css('display', 'block');


            var selectOne = document.getElementById("selection_one").value;

            switch(selectOne){
                case "{{MULTIMEDIA_TYPE_VIDEO_EMBED}}":
                    $('#upload_video_one').show();
                    document.getElementById("upload_image_one").style.display = "none";
                    break;

                case "{{MULTIMEDIA_TYPE_IMAGE}}":
                    $('#upload_image_one').show();
                    document.getElementById("upload_video_one").style.display = "none";
                    break;
                 }
            break;

        case "{{TYPE_MULTIPLE_RESPONSE}}":
            $('div.tipo_respuesta').css('display', 'none');
            $('div[data-case="{{TYPE_MULTIPLE_RESPONSE}}"]').css('display', 'block');

            var selectOne = document.getElementById("selection_two").value;

            switch(selectOne){
                case "{{MULTIMEDIA_TYPE_VIDEO_EMBED}}":
                    $('#upload_video_two').show();
                    document.getElementById("upload_image_two").style.display = "none";
                    break;

                case "{{MULTIMEDIA_TYPE_IMAGE}}":
                    $('#upload_image_two').show();
                    document.getElementById("upload_video_two").style.display = "none";
                    break;
                 }
            break;

        case "{{TYPE_OPEN_RESPONSE}}":
            $('div.tipo_respuesta').css('display', 'none');
            $('div[data-case="{{TYPE_OPEN_RESPONSE}}"]').css('display', 'block');

            var selectOne = document.getElementById("selection_three").value;

            switch(selectOne){
                case "{{MULTIMEDIA_TYPE_VIDEO_EMBED}}":
                    $('#upload_video_three').show();
                    document.getElementById("upload_image_three").style.display = "none";
                    break;

                case "{{MULTIMEDIA_TYPE_IMAGE}}":
                    $('#upload_image_three').show();
                    document.getElementById("upload_video_three").style.display = "none";
                    break;
                 }
            break;

        case "{{TYPE_FILE_RESPONSE}}":
            $('div.tipo_respuesta').css('display', 'none');
            $('div[data-case="{{TYPE_FILE_RESPONSE}}"]').css('display', 'block');

            var selectOne = document.getElementById("selection_four").value;

            switch(selectOne){
                case "{{MULTIMEDIA_TYPE_VIDEO_EMBED}}":
                    $('#upload_video_four').show();
                    document.getElementById("upload_image_four").style.display = "none";
                    break;

                case "{{MULTIMEDIA_TYPE_IMAGE}}":
                    $('#upload_image_four').show();
                    document.getElementById("upload_video_four").style.display = "none";
                    break;
                 }
            break;
    }
}

// $('#type').change(function(){
//     var value = $(this).val();

//     switch(value){
//         case "{{TYPE_SINGLE_RESPONSE}}": {
//             $('div.tipo_respuesta').css('display', 'none');
//             $('div[data-case="{{TYPE_SINGLE_RESPONSE}}"]').css('display', 'block');
//             break;
//         }
//         case "{{TYPE_MULTIPLE_RESPONSE}}": {
//             $('div.tipo_respuesta').css('display', 'none');
//             $('div[data-case="{{TYPE_MULTIPLE_RESPONSE}}"]').css('display', 'block');
//             break;
//         }
//         case "{{TYPE_OPEN_RESPONSE}}": {
//             $('div.tipo_respuesta').css('display', 'none');
//             $('div[data-case="{{TYPE_OPEN_RESPONSE}}"]').css('display', 'block');
//             break;
//         }
//         case "{{TYPE_FILE_RESPONSE}}": {
//             $('div.tipo_respuesta').css('display', 'none');
//             $('div[data-case="{{TYPE_FILE_RESPONSE}}"]').css('display', 'block');
//             break;
//         }
//     }
// });
var isempty = function (str){
  return str === '' || str === undefined || str === null || typeof str === undefined || typeof str == undefined || typeof str === null || str.length === 0;
}
$('.add-question').click(function(e){
    e.preventDefault();
    var fd = new FormData($(this).parent()[0]);
    fd.append($('#category').attr('name'), $('#category').val());
    fd.append($('#subject').attr('name'), $('#subject').val());
    fd.append($('#keywords').attr('name'), $('#keywords').val());
    fd.append($('#complexity').attr('name'), $('#complexity').val());
    fd.append($('#type').attr('name'), $('#type').val());
    /*if ($('#type').val()==3) {
      if (isempty($('#selection_three').val())) {
        swal({
            icon: 'warning',
            title: 'Error',
            text: 'Seleccione el Tipo de Contenido'
        });
        return false;
      }
    }*/
    $.ajax({
        type: "POST",
        url: "{{route('admin.questions.create')}}",
        data: fd,
        processData: false,
        contentType: false,
        success: function(){
            swal({
                icon: 'success',
                title: 'Nueva pregunta',
                text: 'La pregunta fue creada correctamente'
            });

            $("#save").removeAttr('disabled');
            $("#save").css({'cursor':'pointer'});
        }
    }).done(function (data) {
        fillQuestion(data);
    }).fail(function(data){
        alert('error, datos incompletos');
    });
});

$('.container_crear_ejercicio').on('change', '.option_pregunta', function(){
    var val = $(this).val();
    $(this).siblings("span[data-number=" + $(this).data('number') + "]").find('input').val(val);
});

function calculateTotalScore(){
    var total = 0;
    $('.score').each(function() {
    total += parseFloat($(this).val());
    });

    $('.final_score').val(total);
}

function fillQuestion(data){
    total_questions++;

    if(!$('#pulled_questions').find('input[name="questions['+ data.type_id +'][score]"]').length) {
        switch(String(data.type_id)){
            case "{{TYPE_SINGLE_RESPONSE}}":
                var duplicated = template_added_single.clone();
                console.log(duplicated);
                var correct = data.correct_responses_names[0];
                duplicated.find('.text').text(total_questions + '. ' + data.text +  ' (opcion multiple - una respuesta)');
                for(var i = 0; i< data.response_templates.length ; i++) {
                    var res_template = data.response_templates[i];
                    duplicated.find('.response_templates_container').append('<input type="radio" class="mr-2" name="respuesta" value="' + res_template.value + '"' + (correct == res_template.value ? 'checked' : '') + ' disabled>' + res_template.value + '<br>')
                }
                duplicated.find('.score').prop('name', 'questions[' + data.id+ '][score]');
                duplicated.find('.score').prop('required', true);
                duplicated.show();
                container.append(duplicated);
                break;

            case "{{TYPE_MULTIPLE_RESPONSE}}":
                var duplicated = template_added_multiple.clone();
                var correct = data.correct_responses_names;
                duplicated.find('.text').text(total_questions + '. ' + data.text +  ' (opcion multiple - multiples respuestas)');
                for(var i = 0; i< data.response_templates.length ; i++) {
                    var res_template = data.response_templates[i];
                    duplicated.find('.response_templates_container').append('<input type="checkbox" class="mr-2" name="respuesta" value="' + res_template.value + '"' + (correct.includes(res_template.value) ? 'checked' : '') + ' disabled>' + res_template.value + '<br>')
                }
                duplicated.find('.score').prop('name', 'questions[' + data.id+ '][score]');
                duplicated.find('.score').prop('required', true);
                duplicated.show();
                container.append(duplicated);
                break;

            case "{{TYPE_OPEN_RESPONSE}}":
                var duplicated = template_added_open.clone();
                duplicated.find('.text').text(total_questions + '. ' + data.text +  ' (respuesta abierta)');
                duplicated.find('.response_templates_container').append('<textarea disabled></textarea>');
                duplicated.find('.score').prop('name', 'questions[' + data.id+ '][score]');
                duplicated.find('.score').prop('required', true);
                duplicated.show();
                container.append(duplicated);
                break;

            case "{{TYPE_FILE_RESPONSE}}":
                var duplicated = template_added_file.clone();
                duplicated.find('.text').text(total_questions + '. ' + data.text +  ' (respuesta abierta - subir archivo)');
                duplicated.find('.response_templates_container').append('<input type="file" name="uploaded_answer" disabled>');
                duplicated.find('.response_templates_container').append('<textarea disabled></textarea>');
                duplicated.find('.score').prop('name', 'questions[' + data.id+ '][score]');
                duplicated.find('.score').prop('required', true);
                duplicated.show();
                container.append(duplicated);
                break;

        }
    }
}

$('#pulled_questions').on('keyup', '.score', function(){
    calculateTotalScore();
});

$('#filter').click(function(e){
    e.preventDefault();

    $(".searched_question").remove();

    var fd = new FormData($(this).parent()[0]);

    $.ajax({
        type: "POST",
        url: "{{route('admin.questions.filter')}}",
        data: fd,
        processData: false,
        contentType: false,
        success: function (data) {
            result_repository = data;
            for (var i = 0; i < data.length; i++) {
                var tmp = $('<div class="row searched_question py-2 mx-2"><div class="col-md-6 result_name align-self-center"></div><div class="col-md-3 align-self-center result_type font-weight-bold text-uppercase" style="font-size:13.5px;"></div><div class="col-md-1 align-self-center pr-0 text-right"><input type="checkbox" class="mr-0" name="select_question" data-id="' + data[i].id + '"></div><div class="col-md-1 delete_question align-self-center pr-0 text-right"><a href="#" data-id="' + data[i].id + '" class="delete_question_href" title="Eliminar pregunta"><span class="fas mx-0 fa-trash-alt text-danger"></a></div>  </div>');
                tmp.find('.result_name').text(data[i].text);
                tmp.find('.result_type').text(data[i].type.name);
                $('.modal-body').append(tmp);
            }
            $('.delete_question').click(function(e){
                e.preventDefault();
                var this_el = $(this);
                swal({
                  title: "¿Está seguro de borrar esta pregunta?",
                  text: "¡Al eliminarla no se podrá recuperar!",
                  icon: "warning",
                  buttons: true,
                  dangerMode: true,
                })
                .then((willDelete) => {
                  if (willDelete) {
                    $.ajax({
                        url: "{{route('admin.questions.delete','@')}}".replace('@',this_el.find('a.delete_question_href').data('id')),
                        type: "GET"
                    }).done(function(data){
                        //console.log(data)
                        swal("La pregunta ha sido borrada con correctamente!", {
                          icon: "success",
                        });
                        this_el.parents('.searched_question').fadeOut('fast');
                        setTimeout(function(){
                        this_el.parents('.searched_question').remove();

                        },300);
                        //this_el.parents('.container_sesion').remove();
                    }).fail(function(err) {
                        swal("Ha habido un problema al eliminar!", {
                      icon: "error",
                    });
                    });

                  }
                });

            });
        }

    });
});

$('.modal-dialog').on('click', '#pull_selected', function(){
    var checked = $(this).parent().siblings('.modal-body').find('input[type="checkbox"]:checked');

    for (var i = 0; i < checked.length; i++) {
        var id = checked[i].dataset.id;
        var obj = result_repository.find(item => item.id === parseInt(id));
        fillQuestion(obj);
    }

    $('.modal-body').empty();
    $('#search_preguntas').modal('toggle');
    $("#save").removeAttr('disabled');
    $("#save").css({'cursor':'pointer'});

});

function reset_filters() {
    $('#category').children().hide();
    $('#group').children().hide();
    $('#sub_group').children().hide();
    $('#subject').children().hide();
}

reset_filters();

$('#product').change(function(){
    $('#category').children().hide();
    $('#category').children().first().show();
    $('#category').children().first().prop('selected', true).change();
    $('#category').children('[data-parent="'+ $(this).val() +'"]').show();
});

$('#category').change(function(){
    $('#group').children().hide();
    $('#group').children().first().show();
    $('#group').children().first().prop('selected', true).change();
    $('#group').children('[data-parent="'+ $(this).val() +'"]').show();
});

$('#group').change(function(){
    $('#sub_group').children().hide();
    $('#sub_group').children().first().show();
    $('#sub_group').children().first().prop('selected', true).change();
    $('#sub_group').children('[data-parent="'+ $(this).val() +'"]').show();
});

$('#sub_group').change(function(){
    $('#subject').children().hide();
    $('#subject').children().first().show();
    $('#subject').children().first().prop('selected', true).change();
    $('#subject').children('[data-parent="'+ $(this).val() +'"]').show();
});

$('#questions_form').on('click', '.delete-dynamic', function(){
    $(this).parents('.added_template').remove();
    window.location.href = window.location.pathname + window.location.search + window.location.hash;
});

$('.container_crear_ejercicio').on('click', '.delete-single-opt', function(){
    $(this).parents('.opt_single').remove();
});

$('.container_crear_ejercicio').on('click', '.delete-multiple-opt', function(){
    $(this).parents('.opt_multiple').remove();
});

$('.add-opt-single').click(function(){
    var repository = $(this).siblings('.opt_repository');
    var tmp = repository.children('.opt').first().clone();
    console.log(tmp);
    tmp.find('span').first().prop('data-number', count_single_opt);
    tmp.find('input').prop('data-number', count_single_opt).val('');
    repository.append(tmp);
    count_single_opt++;
});

$('.add-opt-multiple').click(function(){
    var repository = $(this).siblings('.opt_repository');
    var tmp = repository.children('.opt').first().clone();
    tmp.find('span').first().prop('data-number', count_multiple_opt);
    tmp.find('input').prop('data-number', count_multiple_opt).val('');
    repository.append(tmp);
    count_multiple_opt++;
});


</script>

@stop
