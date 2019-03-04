@extends('main.base_main')

@section('home_url')
{{route('teacher.courses.index')}}
@stop

@section('logout_url')
    {{route('teacher.auth.logout')}}
@stop

@section('contenido_web')


	<!-- //////////////////////BARRA DE NAVEGACION DE PRODUCTOS /////////////////// -->

<div class="navegacion_docente">
<!-- Listado de los títulos -->

	<a class="navbar-brand tab_cursos" href="{{route('teacher.courses.index')}}">Cursos</a>
</div>

	@yield('contenido')



@stop