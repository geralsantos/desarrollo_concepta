@extends('main.base_main')
@section('extra_css')
	<link rel="stylesheet" type="text/css" href="{{asset('css/admin/style_crear_sesion.css')}}">
@stop

@section('titulo')
	CREAR SESION
@stop

@section('home_url')
{{route('admin.courses.index')}}
@stop

@section('logout_url')
{{route('admin.auth.logout')}}
@stop

@section('contenido_web')

<div class="container-fluid container_crear_sesion" style="min-height: 528px; max-height: 528px;">
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
			<a href="{{route('admin.themes.create', ['session_id' => request()->route('id')])}}">
				<div class="container-fluid add_tema">
					<div class="row">
						<div class="col-sm-12 col-md-12 text_crear_tema">
							<span class="fas fa-plus-circle fa-2x"></span> <p>Agregar tema</p>
						</div>
					</div>
				</div>
			</a>
			<br>
			<div class="container-fluid px-0">
			<!-- ********* INICIO DE TEMA 1 (YA CREADO) **********-->
			<div class="row no-gutters mb-3" style="max-height: 330px; overflow-y: auto;">
				<div class="w-100 d-flex justify-content-between">
				@foreach($session->themes as $theme)
				<div class="col-6 mb-3 mx-0 container container_tema px-3 align-sefl-center rounded" style="max-width: 49.3%">
					<div class="row">
						<div class="col-sm-6 col-md-8 pr-0 align-sefl-center">
						<span class="font-weight-bold">Tema {{$loop->iteration}} :</span> <br>
						{{$theme->name}} <br>
						<!--Tiempo: {{$theme->duration_in_minutes}} minutos
						Documentación : {{$themeClases->where('theme_id', '$theme->id')}}<br>
						{{$theme->id}}-->
						</div>
						<div class="col-sm-3 col-md-3 pr-0 align-sefl-center text-center">
							<a href="{{route('admin.themes.edit', $theme->id)}}" class="btn btn-secondary" title="Ingresar al tema">Ingresar</a>
						</div>
						<div class="col-sm-3 col-md-1 align-sefl-center delete_column">
						<br>
							<a href="#" class="delete_theme text-danger" title="Eliminar tema" data-id="{{$theme->id}}" title="Eliminar tema"><span class="fas fa-trash-alt delete_tema"></span></a>
						</div>	
					</div>
				</div>
				@endforeach
				</div>
			</div>
			<!-- ********* FIN DE TEMA 1 (YA CREADO) **********-->
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
            url: "{{route('admin.sessions.edit', request()->route('id'))}}",
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
        url: "{{route('admin.sessions.edit', request()->route('id'))}}",
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
        url: "{{route('admin.themes.delete', '@')}}".replace('@', this_el.data('id')),
        type: "GET"
    }).done(function(data){
        this_el.parents('.container_tema').remove();
    });
});
</script>

@stop