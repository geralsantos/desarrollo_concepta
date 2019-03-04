@extends('alumnos.templates.base_alumnos')
@section('extra_css')
    <link rel="stylesheet" type="text/css" href="{{asset('css/alumnos/style_cursos.css')}}">
@stop

@section('titulo')
    DESEMPEÑO
@stop

@section('home_url')
{{route('user.courses.index')}}
@stop

@section('logout_url')
    {{route('user.auth.logout')}}
@stop

@section('contenido')

<div class="container container_progreso">
    <div class="row">
        <div class="col-md-6">
        <table class="table table-bordered">
            <thead>
              <tr>
                <th>Cursos</th>
                <th>Exámenes</th>
                <th>Simuladores</th>
              </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                    <ul>
                        @foreach($courses as $course)
                        <li>
                            <h6>{{$course->instance->name}}</h6>
                            <label>Exámenes completados: {{$user->forms()->where('evaluated', 1)->where('entity_name', ENTITY_COURSE_EXAM)->count()}}/{{$course->instance->exams()->count()}}</label>
                        </li>
                        @endforeach
                    </ul>
                    </td>
                    <td>
                    <ul>
                        <li>
                            <label>Exámenes completados: {{$user->forms()->where('evaluated', 1)->where('entity_name', ENTITY_EXAM)->count()}}/{{$exams->count()}}</label>
                        </li>
                    </ul>
                    </td>
                    <td>
                    <ul>
                        @foreach($simulators as $simulator)
                        <li>
                            <h6>{{$simulator->instance->name}}</h6>
                            <label>Exámenes completados: {{$user->forms()->where('evaluated', 1)->where('entity_name', ENTITY_SIMULATOR_EXAM)->count()}}/{{$simulator->instance->exams()->count()}}</label>
                        </li>
                        @endforeach
                    </ul>
                    </td>
                </tr>
            </tbody>
        </table>
        </div>
    </div>
</div>

@stop

@section('extra_scripts')

@stop
