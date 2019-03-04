@extends('main.base_main')

@section('home_url')
{{route('company.courses.index')}}
@stop

@section('logout_url')
    {{route('company.auth.logout')}}
@stop

@section('contenido_web')


	<!-- //////////////////////BARRA DE NAVEGACION DE PRODUCTOS /////////////////// -->

<div class="navegacion_coordinador_empresa">
<!-- Listado de los títulos -->
	<a class="navbar-brand tab_cursos" href="{{route('company.courses.index')}}">Cursos</a>
	<a class="navbar-brand tab_simuladores" href="{{route('company.simulators.index')}}">Simuladores</a>
	<a class="navbar-brand tab_evaluaciones" href="{{route('company.exams.index')}}">Evaluaciones</a>
	<a class="navbar-brand tab_colaboradores" href="{{route('company.students.index')}}">Colaboradores</a>
</div>

@yield('contenido')



@stop