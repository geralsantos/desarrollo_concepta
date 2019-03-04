@extends('main.base_main')

@section('home_url')
{{route('admin.courses.index')}}
@stop

@section('logout_url')
	{{route('admin.auth.logout')}}
@stop

@section('contenido_web')
<html>


<body>
	<!-- //////////////////////BARRA DE NAVEGACION DE PRODUCTOS /////////////////// -->

<div class="container-fluid navegacion_admin">
<!-- Listado de los títulos -->
	<div class="row">
		<div class="col-sm-12 col-md-12 tabs">
			<a class="navbar-brand tab_cursos" href="{{route('admin.courses.index')}}">Cursos</a>
			<a class="navbar-brand tab_simuladores" href="{{route('admin.simulators.index')}}">Simuladores</a>
			<a class="navbar-brand tab_evaluaciones" href="{{route('admin.exams.index')}}">Evaluaciones</a>
			<a class="navbar-brand tab_empresas" href="{{route('admin.businesses.index')}}">Empresas</a>
			<a class="navbar-brand tab_cuentas" href="{{route('admin.accounts.index')}}">Cuentas</a>
			<a class="navbar-brand tab_filtros" href="{{route('admin.filters.index')}}">Filtros de preguntas</a>
		</div>
	</div>
</div>


@yield('contenido')

</body>
</html>

@stop