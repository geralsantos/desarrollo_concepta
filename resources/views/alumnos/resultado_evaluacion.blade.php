@extends('main.base_main')
@section('extra_css')
    <link rel="stylesheet" type="text/css" href="{{asset('css/alumnos/style_formulario.css')}}">
@stop

@section('titulo')
    FORMULARIO
@stop

@section('home_url')
{{route('user.courses.index')}}
@stop

@section('logout_url')
{{route('user.auth.logout')}}
@stop

@section('contenido_web')

<div class="container container_main">
    <div class="container_added_preguntas">
        <h5>
            <div class="row">
                <div class="col-md-6">
                    {{$entity->name}}
                </div>
                <div class="col-md-6 text_final_score">
                    Nota: <span id="var_note"></span><span id="total_score"> / {{$questions->sum('pivot.score')}} puntos</span> <!-- esta parte es solo informativa -->
                </div>
                
            </div>
        </h5>
        Alumno: {{$form->student->full_name}}
        <form method="post" action="" id="questions_form">
            {!! csrf_field() !!}
            <input type="hidden" name="entity_name" value="{{$entity_name}}">
            <input type="hidden" name="entity_id" value="{{$entity_id}}">
            <input type="hidden" name="student_id" value="{{$form->student->id}}">
            <div id="pulled_questions">
                @foreach($form->answers->groupBy('question_id') as $answer)
                    @if($answer->first()->question->type_id == TYPE_SINGLE_RESPONSE)
                        <!-- Preguntas (opcion multiple - una respuesta) -->
                        <div class="row">
                            <div class="col-md-9">
                                <div class="text">
                                    {{$loop->iteration . '. ' . $answer->first()->question->text}}
                                </div>
                                @if($answer->first()->question->attachment_type_id == MULTIMEDIA_TYPE_VIDEO_EMBED)
                                <!-- video -->
                                <div class="video_pregunta">
                                    <iframe src="{{$answer->first()->question->attachment}}" allowfullscreen></iframe>
                                </div>
                                <br>
                                <!-- video -->
                                @elseif($answer->first()->question->attachment_type_id == MULTIMEDIA_TYPE_IMAGE)
                                <!-- imagen --> 
                                <div class="imagen_pregunta">
                                    <img src="{{asset($answer->first()->question->attachment)}}">
                                </div>
                                <br>
                                <!-- imagen --> 
                                @endif
                                @foreach($answer->first()->question->response_templates as $option)
                                <div class="options-questions">
                                    
                                    <div>
                                        <input type="radio" id="" value="{{$option->value}}" {{$answer->first()->value == $option->value ? 'checked' : ''}} readonly disabled>{{$option->value}}
                                        <br>
                                    </div>
                                    &nbsp;
                                    <div class="option-answer" style="{{$answer->first()->question->correct_responses->first()->value == $option->value ? 'display:block':''}}">
                                        <span data-value="{{$option->value}}" class="badge badge-success">Respuesta</span>&nbsp;
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="col-md-3 text_score">
                                Puntaje posible:<span> {{$questions->where('id', $answer->first()->question->id)->first()->pivot->score}} puntos</span><br>
                                Puntaje otorgado:<span> <input class="assigned_score" type="text" name="answer[{{$answer->first()->id}}][score]" value="{{$answer->first()->value == $answer->first()->question->correct_responses()->first()->value ? $questions->where('id', $answer->first()->question->id)->first()->pivot->score : 0}}" readonly> puntos</span>
                            </div>
                        </div>
                    @elseif($answer->first()->question->type_id == TYPE_MULTIPLE_RESPONSE)
                        <!-- Preguntas (opcion multiple - multiples respuestas) -->
                        <div class="row">
                            <div class="col-md-9">
                                <div class="text">
                                    {{$loop->iteration . '. ' . $answer->first()->question->text}}
                                </div>
                                @if($answer->first()->question->attachment_type_id == MULTIMEDIA_TYPE_VIDEO_EMBED)
                                <!-- video -->
                                <div class="video_pregunta">
                                    <iframe src="{{$answer->first()->question->attachment}}" allowfullscreen></iframe>
                                </div>
                                <br>
                                <!-- video -->
                                @elseif($answer->first()->question->attachment_type_id == MULTIMEDIA_TYPE_IMAGE)
                                <!-- imagen --> 
                                <div class="imagen_pregunta">
                                    <img src="{{asset($answer->first()->question->attachment)}}">
                                </div>
                                <br>
                                <!-- imagen --> 
                                @endif
                                @foreach($answer->first()->question->response_templates as $option)
                                <input type="checkbox" value="{{$option->value}}" {{$answer->contains('value', $option->value) ? 'checked' : ''}} readonly disabled>{{$option->value}}<br>
                                @endforeach
                            </div>
                            <div class="col-md-3 text_score">
                                Puntaje posible:<span> {{$questions->where('id', $answer->first()->question->id)->first()->pivot->score}} puntos</span><br>
                                Puntaje otorgado:<span> <input class="assigned_score" type="text" name="answer[{{$answer->first()->id}}][score]" value="{{!array_diff($answer->pluck('value')->toArray(),$answer->first()->question->correct_responses->pluck('value')->toArray()) && count($answer->pluck('value')->toArray()) == count($answer->first()->question->correct_responses->pluck('value')->toArray()) ? $questions->where('id', $answer->first()->question->id)->first()->pivot->score : 0}}" readonly> puntos</span>
                            </div>
                        </div>
                    @elseif($answer->first()->question->type_id == TYPE_OPEN_RESPONSE)
                        <!-- Preguntas (respuesta abierta) -->
                        <div class="row">
                            <div class="col-md-9">  
                                <div class="text">
                                    {{$loop->iteration . '. ' . $answer->first()->question->text}}
                                </div>
                                <br>
                                @if($answer->first()->question->attachment_type_id == MULTIMEDIA_TYPE_VIDEO_EMBED)
                                <!-- video -->
                                <div class="video_pregunta">
                                    <iframe src="{{$answer->first()->question->attachment}}" allowfullscreen></iframe>
                                </div>
                                <br>
                                <!-- video -->
                                @elseif($answer->first()->question->attachment_type_id == MULTIMEDIA_TYPE_IMAGE)
                                <!-- imagen --> 
                                <div class="imagen_pregunta">
                                    <img src="{{asset($answer->first()->question->attachment)}}">
                                </div>
                                <br>
                                <!-- imagen --> 
                                @endif
                                <p>{{$answer->first()->value}}</p>
                                <textarea name="answer[{{$answer->first()->id}}][obs]" readonly>Observaciones: {{$answer->first()->observation or ''}}</textarea>
                            </div>
                            <div class="col-md-3 text_score">
                                Puntaje posible:<span data-score="{{$questions->where('id', $answer->first()->question->id)->first()->pivot->score}}"> {{$questions->where('id', $answer->first()->question->id)->first()->pivot->score}} puntos</span><br>
                                Puntaje otorgado:<span><input class="assigned_score" type="text" name="answer[{{$answer->first()->id}}][score]" value="{{$answer->first()->final_score or 0}}" readonly> puntos</span>
                            </div>
                        </div>
                    @elseif($answer->first()->question->type_id == TYPE_FILE_RESPONSE)
                        <!-- Preguntas (respuesta abierta - subir archivo) -->
                        <div class="row">
                            <div class="col-md-9">
                                <div class="text">
                                    {{$loop->iteration . '. ' . $answer->first()->question->text}}
                                </div>
                                <br>
                                @if($answer->first()->question->attachment_type_id == MULTIMEDIA_TYPE_VIDEO_EMBED)
                                <!-- video -->
                                <div class="video_pregunta">
                                    <iframe src="{{$answer->first()->question->attachment}}" allowfullscreen></iframe>
                                </div>
                                <br>
                                <!-- video -->
                                @elseif($answer->first()->question->attachment_type_id == MULTIMEDIA_TYPE_IMAGE)
                                <!-- imagen --> 
                                <div class="imagen_pregunta">
                                    <img src="{{asset($answer->first()->question->attachment)}}">
                                </div>
                                <br>
                                <!-- imagen --> 
                                @endif
                                <p>{{$answer->first()->value}}</p>
                                <a href="{{asset($answer->first()->name)}}" download>Archivo adjunto</a>
                                <textarea name="answer[{{$answer->first()->id}}][obs]" readonly>Observaciones: {{$answer->first()->observation or ''}}</textarea>
                            </div>
                            <div class="col-md-3 text_score">
                                Puntaje posible:<span data-score="{{$questions->where('id', $answer->first()->question->id)->first()->pivot->score}}"> {{$questions->where('id', $answer->first()->question->id)->first()->pivot->score}} puntos</span><br>
                                Puntaje otorgado:<span><input class="assigned_score" type="text" name="answer[{{$answer->first()->id}}][score]" value="{{$answer->first()->final_score or 0}}" readonly> puntos</span>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </form>
        <a href="{{route('user.questions.back-review', ['entity_name' => $entity_name, 'entity_id' => $entity_id])}}" class="btn btn-info">Volver</a>
    </div>
</div>
@stop


@section('extra_scripts')
<script type="text/javascript">

calculate_total_qualification();

function calculate_total_qualification() {
    var scores   = $('.assigned_score');
    var total    = 0.0;

    $.each(scores, function(key, val){
        total += parseFloat(val.value ? val.value : 0.0);
    });

    $('#var_note').text(total);

    return total;
}

</script>
@stop