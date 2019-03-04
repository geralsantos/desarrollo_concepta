@extends('main.base_main')

@section('home_url')
{{route('user.courses.index')}}
@stop

@section('logout_url')
	{{route('user.auth.logout')}}
@stop

@section('contenido_web')
<html>


<body>
	<!-- //////////////////////BARRA DE NAVEGACION DE PRODUCTOS /////////////////// -->

<div class="container-fluid navegacion_alumnos">
<!-- Listado de los títulos -->
	<div class="row">
		<div class="col-sm-12 col-md-6 tabs">
			<a class="navbar-brand tab_cursos" href="{{route('user.courses.index')}}">Cursos</a>
			<a class="navbar-brand tab_simuladores" href="{{route('user.simulators.index')}}">Simuladores</a>
			<a class="navbar-brand tab_evaluaciones" href="{{route('user.exams.index')}}">Evaluaciones</a>
			<!--<a class="navbar-brand tab_desempeno" href="{{route('user.progress.index')}}">Ver desempeño</a>
			<a class="navbar-brand tab_certificados" href="{{route('user.certificates.index')}}">Certificados</a>-->
		</div>
		<div class="col-sm-12 col-md-6 banner_publicidad">
			<img src="{{asset('images/alumnos/publicidad.png')}}" class="image_publicidad">
		</div>
	</div>

</div>





@yield('contenido')

</body>
</html>

@stop