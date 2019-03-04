@extends('main.base_main')
@section('extra_css')
    <link rel="stylesheet" type="text/css" href="{{asset('css/admin/style_crear_sesion.css')}}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <style>
        .footer{
            position: absolute;
            bottom: 0;
        }
    </style>
@stop

@section('titulo')
    CREAR SESION
@stop

@section('home_url')
{{route('teacher.courses.index')}}
@stop

@section('logout_url')
{{route('teacher.auth.logout')}}
@stop

@section('contenido_web')

<div class="container-fluid container_crear_sesion">
    <div class="row info_sesion">
        <div class="col-sm-12 col-md-12 input_sesion">
        <form>
            <input type="text" name="nombre_sesion" placeholder="NOMBRE DE LA SESIÓN" value="{{$session->name}}" id="name">
            <select name="type" id="type">
                <option value="" disabled selected>¿Presencial o virtual?</option>
                @foreach($session_types as $session_type)
                <option value="{{$session_type->id}}" {{$session->type ? ($session_type->id == $session->type->id ? 'selected' : '') : ''}}>{{$session_type->name}}</option>
                @endforeach
            </select>
        </form> 
        </div>
    </div>

    
    <div class="row">
        <div class="col-sm-12 col-md-12 temas_sesion">
            <!-- ********* CREAR TEMAS DE LA SESION **********-->
            <a href="{{route('teacher.themes.create', ['session_id' => request()->route('id')])}}">
                <div class="container-fluid add_tema">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 text_crear_tema">
                            <span class="fas fa-plus-circle fa-2x"></span> <p>Agregar tema</p>
                        </div>
                    </div>
                </div>
            </a>
            <br>
            <div class="container-fluid" style="max-height: 325px; overflow-y: auto;">
                <div class="row justify-content-between">
                @foreach($session->themes as $theme)
                <!-- ********* INICIO DE TEMA 1 (YA CREADO) **********-->
                <div class="col-6 container_tema pl-3 mb-3 rounded" style="max-width: 49.3%;">
                    <div class="row">
                        <div class="col-sm-6 col-md-8 align-self-center">
                            <span class="font-weight-bold">Tema {{$loop->iteration}} :</span><br>
                            {{$theme->name}} <br>
                            <!--Tiempo: {{$theme->duration_in_minutes}} minutos <br>-->
                        </div>
                        <div class="col-sm-3 text-center pr-0 col-md-3 align-self-center">
                            <a href="{{route('teacher.themes.edit', $theme->id)}}" title="Ingresar al tema" class="btn btn-secondary mt-0">Ingresar</a>
                        </div>
                        <div class="col-sm-3 text-center p-0 col-md-1 align-self-center delete_column">
                            <a href="#" title="Eliminar tema" class="delete_theme" data-id="{{$theme->id}}"><span class="fas fa-trash-alt delete_tema text-danger"></span></a>
                        </div>  
                    </div>
                </div>
                <!-- ********* FIN DE TEMA 1 (YA CREADO) **********-->
                @endforeach
                </div>
            </div>
        </div>

    </div>
</div>




@stop


@section('extra_scripts')
<script>
$('#name').keyup(function(){
    delay(function(){
        var name = $('#name').val();

        $.ajax({
            url: "{{route('teacher.sessions.edit', request()->route('id'))}}",
            type: "POST",
            data: {
                "name": name,
                "_token" : "{{csrf_token()}}"
            }
        });
    }, 1500 );
});

$('#type').change(function(){
    var type = $(this).val();

    $.ajax({
        url: "{{route('teacher.sessions.edit', request()->route('id'))}}",
        type: "POST",
        data: {
            "type": type,
            "_token" : "{{csrf_token()}}"
        }
    });
});

var delay = (function(){
    var timer = 0;
    return function(callback, ms){
        clearTimeout (timer);
        timer = setTimeout(callback, ms);
    };
})();

$('.delete_theme').click(function(e){
    e.preventDefault();
    var this_el = $(this);

    $.ajax({
        url: "{{route('teacher.themes.delete', '@')}}".replace('@', this_el.data('id')),
        type: "GET"
    }).done(function(data){
        this_el.parents('.container_tema').remove();
    });
});
</script>

@stop