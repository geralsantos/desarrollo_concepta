@extends('main.base_main')
@section('extra_css')
    <link rel="stylesheet" type="text/css" href="{{asset('css/alumnos/style_formulario.css')}}">
@stop

@section('titulo')
    FORMULARIO
@stop

@section('home_url')

@stop

@section('logout_url')

@stop

@section('contenido_web')


<!--///////////////////////////// PREGUNTAS AGREGADAS A LA DERECHA ///////////////////////////////////-->
<div class="container container_main">
    <div class="container_added_preguntas">
        <h5>
            <div class="row">
                <div class="col-md-6">
                    PREGUNTAS AGREGADAS
                </div>
                <div class="col-md-3 text_time">
                    Tiempo: <span id="chronometer"><span id="hour">{{str_pad((int)($entity->duration /60), 2, 0, STR_PAD_LEFT)}}</span>:<span id="minute">{{str_pad($entity->duration % 60, 2, 0, STR_PAD_LEFT)}}</span>:<span id="second">00</span></span> <!-- aqui se deberia dar el conteo de los minutos (reloj)-->
                </div>
                <div class="col-md-3 text_final_score">
                    Puntaje total:<span id="total_time"> {{$questions->sum('pivot.score')}} puntos</span> <!-- esta parte es solo informativa -->
                </div>
                
            </div>
        </h5>
        <form method="post" action="{{route('user.questions.form')}}" id="questions_form" enctype="multipart/form-data">
            {!! csrf_field() !!}
            <input type="hidden" name="entity_name" value="{{$entity_name}}">
            <input type="hidden" name="entity_id" value="{{$entity_id}}">
            <div id="pulled_questions">
                @foreach($questions as $question)
                    @if($question->type_id == TYPE_SINGLE_RESPONSE)
                    <!-- Preguntas (opcion multiple - una respuesta) -->
                    <div class="row">
                        <div class="col-md-9" class="question-div" data-question="{{$question->id}}">
                            <div class="text">
                                {{$loop->iteration . '. ' . $question->text}}
                            </div>
                            @if($question->attachment_type_id == MULTIMEDIA_TYPE_VIDEO_EMBED)
                            <!-- video -->
                            <div class="video_pregunta">
                                <iframe src="https://www.youtube.com/embed/zpOULjyy-n8?rel=0" allowfullscreen></iframe>
                            </div>
                            <br>
                            <!-- video -->
                            @elseif($question->attachment_type_id == MULTIMEDIA_TYPE_IMAGE)
                            <!-- imagen --> 
                            <div class="imagen_pregunta">
                                <img src="{{asset($question->attachment)}}">
                            </div>
                            <br>
                            <!-- imagen --> 
                            @endif
                            @foreach($question->response_templates as $option)
                            
                                    <input type="radio" value="{{$option->value}}" name="questions[{{$question->id}}][response]"> {{$option->value}} <br>
                                
                            @endforeach
                        </div>
                        <div class="col-md-3 text_score">
                            Puntaje:<span>{{$question->pivot->score}} puntos</span>
                        </div>
                    </div>
                    @elseif($question->type_id == TYPE_MULTIPLE_RESPONSE)
                    <!-- Preguntas (opcion multiple - multiples respuestas) -->
                    <div class="row">
                        <div class="col-md-9">
                            <div class="text">
                                {{$loop->iteration . '. ' . $question->text}}
                            </div>
                            <br>
                            @if($question->attachment_type_id == MULTIMEDIA_TYPE_VIDEO_EMBED)
                            <!-- video -->
                            <div class="video_pregunta">
                                <iframe src="https://www.youtube.com/embed/zpOULjyy-n8?rel=0" allowfullscreen></iframe>
                            </div>
                            <br>
                            <!-- video -->
                            @elseif($question->attachment_type_id == MULTIMEDIA_TYPE_IMAGE)
                            <!-- imagen --> 
                            <div class="imagen_pregunta">
                                <img src="{{asset($question->attachment)}}">
                            </div>
                            <br>
                            <!-- imagen --> 
                            @endif
                            @foreach($question->response_templates as $option)
                            <input type="checkbox" value="{{$option->value}}" name="questions[{{$question->id}}][response][]"> {{$option->value}} <br>
                            @endforeach
                        </div>
                        <div class="col-md-3 text_score">
                            Puntaje:<span>{{$question->pivot->score}} puntos</span>
                        </div>
                    </div>
                    @elseif($question->type_id == TYPE_OPEN_RESPONSE)
                    <!-- Preguntas (respuesta abierta) -->
                    <div class="row">
                        <div class="col-md-9">  
                            <div class="text">
                            {{$loop->iteration . '. ' . $question->text}}
                            </div>
                            <br>
                            @if($question->attachment_type_id == MULTIMEDIA_TYPE_VIDEO_EMBED)
                            <!-- video -->
                            <div class="video_pregunta">
                                <iframe src="https://www.youtube.com/embed/zpOULjyy-n8?rel=0" allowfullscreen></iframe>
                            </div>
                            <br>
                            <!-- video -->
                            @elseif($question->attachment_type_id == MULTIMEDIA_TYPE_IMAGE)
                            <!-- imagen --> 
                            <div class="imagen_pregunta">
                                <img src="{{asset($question->attachment)}}">
                            </div>
                            <br>
                            <!-- imagen --> 
                            @endif
                            <!-- imagen --> 
                            <textarea name="questions[{{$question->id}}][response]"></textarea>
                        </div>
                        <div class="col-md-3 text_score">
                            Puntaje:<span>{{$question->pivot->score}} puntos</span>
                        </div>
                    </div>
                    @elseif($question->type_id == TYPE_FILE_RESPONSE)
                    <!-- Preguntas (respuesta abierta - subir archivo) -->
                    <div class="row">
                        <div class="col-md-9">
                            <div class="text">
                            {{$loop->iteration . '. ' . $question->text}}
                            </div>
                            <br>
                            @if($question->attachment_type_id == MULTIMEDIA_TYPE_VIDEO_EMBED)
                            <!-- video -->
                            <div class="video_pregunta">
                                <iframe src="https://www.youtube.com/embed/zpOULjyy-n8?rel=0" allowfullscreen></iframe>
                            </div>
                            <br>
                            <!-- video -->
                            @elseif($question->attachment_type_id == MULTIMEDIA_TYPE_IMAGE)
                            <!-- imagen --> 
                            <div class="imagen_pregunta">
                                <img src="{{asset($question->attachment)}}">
                            </div>
                            <br>
                            <!-- imagen --> 
                            @endif
                            <input type="file" name="questions[{{$question->id}}][file]">
                            <textarea name="questions[{{$question->id}}][response]"></textarea>
                        </div>
                        <div class="col-md-3 text_score">
                            Puntaje:<span>{{$question->pivot->score}} puntos</span>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
            <input type="hidden" name="checkAnswer" id="checkAnswer" value=""><br>
            <button id="btn-submitform" class="btn btn-primary" type="submit">Finalizar</button>
        </form>
    </div>
</div>
@stop


@section('extra_scripts')
<script type="text/javascript">
$('#btn-submitform').on('click',function(e){
    e.preventDefault();
    swal({
      title: "¿ Desea terminar su evaluación ?",
      text: "No podrá volver a realizar la actividad si le dá click en finalizar",
      icon: "warning",
      buttons: ["Cancelar","Finalizar"],
      dangerMode: true,
    })
    .then((willDelete) => {
        console.log(willDelete)
      if (willDelete) {
        
      
        $('#questions_form').submit();
      }
    });
   
})
function isArray (value) {
return value && typeof value === 'object' && value.constructor === Array;
}
var time = {
    hour: {{(int)($entity->duration / 60)}},
    minute: {{$entity->duration % 60}},
    second: 0
};

var time_running = null;
time_running = setInterval(function(){
    time.second--;
    if (time.second < 0) {
        time.second = 59;
        time.minute--;
    }

    if (time.minute < 0) {
        time.minute = 59;
        time.hour--;
    }

    if (time.hour == 0 && time.minute == 0 && time.second == 0) {
        $('#questions_form').submit();
    }

    $("#hour").text(time.hour < 10 ? '0' + time.hour : time.hour);
    $("#minute").text(time.minute < 10 ? '0' + time.minute : time.minute);
    $("#second").text(time.second < 10 ? '0' + time.second : time.second);
}, 1000);
</script>
@stop