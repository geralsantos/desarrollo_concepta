@extends('alumnos.templates.base_alumnos')
@section('extra_css')
	<link rel="stylesheet" type="text/css" href="{{asset('css/alumnos/style_cursos.css')}}">
@stop

@section('titulo')
	CERTIFICADOS
@stop

@section('home_url')
{{route('user.courses.index')}}
@stop

@section('logout_url')
	{{route('user.auth.logout')}}
@stop

@section('contenido')

<div class="container container_certificados">
	@foreach($certificates as $certificate)
	<!-- Inicio del primer certificado -->
	<div class="row">
		<div class="col-sm-6 col-md-6">
			<span class="fas fa-certificate"></span> {{$certificate->name}} ({{$certificate->course->name}}: {{$certificate->course->product->code}})
		</div>
		<div class="col-sm-6 col-md-6">
			<a href="{{asset($certificate->attachment)}}" download><span class="fas fa-download"></span></a>
		</div>
	</div>
	<br>
	<!-- Fin del primer certificado -->
	@endforeach
</div>

@stop

@section('extra_scripts')

@stop
