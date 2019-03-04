@extends('main.base_main')
@section('extra_css')
<link rel="stylesheet" type="text/css" href="{{asset('css/admin/style_crear_cursos.css')}}">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
@stop

@section('titulo')
CREAR CURSO
@stop

@section('home_url')
{{route('admin.courses.index')}}
@stop

@section('logout_url')
    {{route('admin.auth.logout')}}
@stop

@section('contenido_web')


<div class="container-fluid container_crear_curso">
<div class="row info_curso">
 <div class="col-sm-6 col-md-7 input_curso">
 <form class="row justify-content-center">
  <input type="text" class="col-5" name="nombre_curso" placeholder="NOMBRE DEL CURSO" id="name" value="{{$course->name or ''}}">
  <input type="text" class="col-5" name="codigo_curso" placeholder="CÓDIGO DEL CURSO" id="code" value="{{$course->product->code}}">
 </form>
 </div>
 <div class="col-sm-6 col-md-5 text_add">
  Agrega a los miembros del curso
 </div>
</div>


<div class="row">
 <div class="col-sm-6 col-md-7 content_curso">
  <ul class="nav nav-tabs" id="myTab" role="tablist">
   <li class="nav-item">
       <a class="nav-link active" id="intro-tab" data-toggle="tab" href="#intro" role="tab" aria-controls="intro" aria-selected="true">Introducción</a>
      </li>
   <li class="nav-item">
       <a class="nav-link" id="sesion-tab" data-toggle="tab" href="#sesion" role="tab" aria-controls="sesion" aria-selected="true">Sesiones</a>
      </li>
      <li class="nav-item">
       <a class="nav-link" id="examenes-tab" data-toggle="tab" href="#examenes" role="tab" aria-controls="examenes" aria-selected="false">Exámenes</a>
      </li>
      <li class="nav-item">
       <a class="nav-link" id="actividades-tab" data-toggle="tab" href="#actividades" role="tab" aria-controls="actividades" aria-selected="false">Actividades</a>
      </li>
      <li class="nav-item">
       <a class="nav-link" id="notas-tab" data-toggle="tab" href="#notas" role="tab" aria-controls="notas" aria-selected="false">Notas</a>
      </li>
      <li class="nav-item">
       <a class="nav-link" id="asistencia-tab" data-toggle="tab" href="#asistencia" role="tab" aria-controls="asistencia" aria-selected="false">Asistencia</a>
      </li>
      <li class="nav-item">
       <a class="nav-link" id="certificados-tab" data-toggle="tab" href="#certificados" role="tab" aria-controls="certificados" aria-selected="false">Certificados</a>
      </li>
  </ul>
  <div class="tab-content px-2" id="myTabContent">

   <!--///////////////////////////////// TAB DE INTRODUCIÓN //////////////////////////////////-->
   <!--///////////////////////////////////////////////////////////////////////////////////////-->
   <div class="tab-pane fade show active" id="intro" role="tabpanel" aria-labelledby="intro-tab">
    <div class="container_introduccion mx-0">
     <div class="upload_intro">
     <form method="post" enctype="multipart/form-data" action="{{route('admin.courses.edit', request()->route('id'))}}">
     {!! csrf_field() !!}
      <!-- //////////////   SELECCIONAR VIDEO O IMAGEN   //////////////// -->
      <div class="row">
       <div class="col-sm-12 col-md-12 select_type">
        <h5>Contenido introductorio del curso</h5>
        <select onchange="type_selection(this)" id="selection_made" name="type">
         <option selected="true" disabled="disabled">Selecciona el tipo de contenido</option>
         @foreach($multimedia_types as $type)
         <option value="{{$type->id}}">{{$type->name}}</option>
         @endforeach
        </select>
       </div>
      </div>
      <!-- //////////////   INICIO DE GUARDAR VIDEO   //////////////// -->
      <div class="row" style="display: none" id="add_video">
       <div class="col-sm-12 col-md-12">
        <div class="row upload_archivo">
          <div class="col-sm-12 col-md-12 ">
           <div  class="row upload_text">
            <div class="col-sm-6 col-md-12 title_intro">
             <div class="row no-gutters">
              <div class="col-md-9 align-self-center">
               <input type="text" name="title_video" placeholder="Ingresa el título del video" value="{{$course->title_intro}}">
              </div>
              <div class="col-md-3 align-self-center">
               <button type="submit" class="btn btn-secondary mt-0 float-left">Guardar</button>
              </div>
             </div>
             <div class="row mt-3 no-gutters">
              <div class="col-9 align-self-center">
              @if($course->intro_type_id == '2')
              <input type="url" class="w-100" name="link_video" placeholder="Ingresa el link del video" value="{{$course->video_intro}}">
              @else
              <input type="url" class="w-100" name="link_video" placeholder="Ingresa el link del video">
              @endif
              </div>
              <div class="col-md-3 pl-3 align-self-center">
               <a data-toggle="modal" data-target="#instrucciones_subir_video" class="text-dark" title="Instrucciones" style="cursor: pointer; font-size: 20px;"><i class="fas fa-info-circle"></i></a>
              </div>
             </div>
            </div>
            <!--<div class="col-sm-6 col-md-6 upload_button_video">
             <button type="submit" class="btn btn-secondary float-right">Guardar</button>
            </div>-->
           </div>
          </div>
        </div>
       </div>
      </div>
      <!-- //////////////   FIN DE GUARDAR ARCHIVO   //////////////// -->
      <!-- //////////////   INICIO DE GUARDAR IMAGEN   //////////////// -->
      <div class="row" style="display: none" id="add_imagen">
       <div class="col-sm-12 col-md-12">
        <div class="row upload_archivo">
          <div class="col-sm-12 col-md-12 ">
           <form method="post" enctype="multipart/form-data" action="">
           {!! csrf_field() !!}
           <div  class="row upload_text">
            <div class="col-sm-6 col-md-9 align-self-center title_intro">
             <input type="text" name="title_imagen" placeholder="Ingresa el título de la imagen" value="{{$course->title_intro}}" class="w-100">
            </div>
            <div class="col-sm-6 col-md-9 align-self-center upload_button_video mt-2">
             @if($course->intro_type_id == '1')
             <div class="row no-gutters">
              <div class="col-6 align-self-center">
               <input type="file" id="video-image-ppt" name="uploaded_file" value="{{$course->video_intro}}">
              </div>
              <div class="col-6 align-self-center">
               <a data-toggle="modal" data-target="#img-introducctorio" class="text-success" title="Ver imagen"><i class="fas fa-check-circle mr-2"></i>Ya hay una imagen subida.</a>
              </div>
             </div>
             @else
             <input type="file" id="video-image-ppt" name="uploaded_file">
             @endif
            </div>
            <div class="col-sm-6 col-md-3 align-self-center mt-2">
             <button type="submit" class="btn btn-secondary mt-0">Guardar</button>
            </div>
           </div>
           </form>
          </div>
        </div>
       </div>
      </div>

      <div class="row no-gutters my-4">
       <div class="col-md-12">
        <h5>Pesos del curso :</h5>
        <div class="row no-gutters">
         <div class="col-4">
          <div class="row no-gutters justify-content-start">
           <div class="col-auto mr-2 align-self-center">
            <span>Sesiones :</span>
           </div>
           <div class="col-auto text-center align-self-center">
            <input type="number" min="0" max="100" class="form-control d-inline-block mr-0" id="weight_sessions" name="weight_sessions" value="{{ $gradeCourse->weight_sessions or 0 }}" style="width: 82px;"><span class="ml-1">%</span>
           </div>
          </div>
         </div>
         <div class="col-4">
          <div class="row no-gutters justify-content-start">
           <div class="col-auto mr-2 align-self-center">
            <span>Exámenes :</span>
           </div>
           <div class="col-auto text-center align-self-center">
            <input type="number" min="0" max="100" class="form-control d-inline-block mr-0" id="weight_exams" name="weight_exams" value="{{ $gradeCourse->weight_exams or 0 }}" style="width: 82px;"><span class="ml-1">%</span>
           </div>
          </div>
         </div>
         <div class="col-4">
          <div class="row no-gutters justify-content-start">
           <div class="col-auto mr-2 align-self-center">
            <span>Actividades :</span>
           </div>
           <div class="col-auto text-center align-self-center">
            <input type="number" min="0" max="100" class="form-control d-inline-block mr-0" id="weight_activities" name="weight_activities" value="{{ $gradeCourse->weight_activities or 0 }}"  style="width: 82px;"><span class="ml-1">%</span>
           </div>
          </div>
         </div>
        </div>
       </div>
      </div>

      </form>
     </div>
     <!-- //////////////   FIN DE GUARDAR IMAGEN   //////////////// -->


     <!-- //////////////   DESCRIPCION DEL CURSO   //////////////// -->
     <h5>Descripción del curso</h5>
     <div class="row">
      <div class="col-sm-12 col-md-12 description_curso">
       <form>
        <textarea id="description" class="p-2" placeholder="Ingresa la descripción del curso" style="resize: none; min-height: 100px; max-height: 100px;">{{$course->description}}</textarea>
       </form>
      </div>
     </div>

    </div>

   </div>


   <!--///////////////////////////////////// TAB DE SESIONES /////////////////////////////////-->
   <!--///////////////////////////////////////////////////////////////////////////////////////-->
   <div class="tab-pane fade" id="sesion" role="tabpanel" aria-labelledby="sesion-tab">

    <!-- ********* CREAR SESIONES DEL CURSO **********-->
    <a href="{{route('admin.sessions.create', ['course_id' => request()->route('id')])}}">
     <div class="container-fluid add_sesion">
      <div class="row">
       <div class="col-sm-12 col-md-12 text_crear_sesion">
        <span class="fas fa-plus-circle fa-2x"></span> <p>Agregar sesión</p>
       </div>
      </div>
     </div>
    </a>
    <br>
    <!-- ********* SESIONES YA CREADAS DEL CURSO **********-->
    <div class="container-fluid" style="max-height: 450px; overflow-y: auto;">
          @foreach($course->sessions as $session)
    <div class="container_sesion mb-3">
     <div class="row">
      <div class="col-sm-8 align-self-center">
       Sesión {{$loop->iteration}} | <span>
        @if($session->type->name == "Presencial")
        {{ $session->type->name }} <i class="fas fa-user-circle ml-1 text-success" style="font-size: 16px;" title="Presencial"></i>
        @elseif($session->type->name == "Virtual")
        {{ $session->type->name }} <i class="fas fa-desktop text-primary ml-1" style="font-size: 16px;" title="Virtual"></i>
        @else
        {{ '' }}
        @endif
       </span><br>
       {{$session->name}}
      </div>
      <div class="col-sm-3 align-self-center text-right">
       <a href="{{route('admin.sessions.edit', $session->id)}}" class="btn btn-secondary" title="Ingresar a sesión">Ingresar</a>
      </div>
      <div class="col-sm-1 pt-0 mt-1 text-center delete_column align-self-center">
       <a href="#" data-id="{{$session->id}}" class="delete_session text-danger mt-1" title="Eliminar sesión"><span class="fas fa-trash-alt delete_tema"></a>
      </div>
     </div>
    </div>
          @endforeach
       </div>
   </div>


   <!--///////////////////////////////////// TAB DE EXAMENES /////////////////////////////////-->
   <!--///////////////////////////////////////////////////////////////////////////////////////-->
   <div class="tab-pane fade" id="examenes" role="tabpanel" aria-labelledby="examenes-tab">
    <div class="container_examenes py-2 px-3" style="max-height: 423px;">

     <div class="row">
      <div class="col-sm-6 col-md-6 pl-1 added_examen">
       <h5 class="mb-2 py-1 pl-2">Exámenes Agregados</h5>
       <div class="container-fluid" style="max-height: 371px; overflow-y: auto;">
       @foreach($exams as $exam)
       <!-- Inicio de Examen agregado 1 -->
       <div class="row my-1">
        <div class="col-sm-10 align-self-center pr-0 title_examen">
         <a href="{{route('admin.courses.exams.edit', $exam->id)}}" title="Ver examen" style="text-decoration: none;"><span class="fas fa-file-alt text-dark mr-1"></span> <span class="text-primary">{{$exam->name}}</span></a>
        </div>
        <div class="col-sm-2 pr-1 align-self-center pt-0 delete_examen">
                                    <a href="{{route('admin.courses.exams.delete', $exam->id)}}" class="text-danger" title="Eliminar examen">
                                        <span class="fas fa-trash-alt"></span>
                                    </a>
        </div>
       </div>
       <!-- Fin de Examen agregado 1 -->
       @endforeach
       </div>
      </div>

      <div class="col-sm-6 col-md-6 container_add">
       <div class="row">
        <div class="col-sm-12 col-md-12 a new_examen">
         <h5 class="mb-2 py-1 pl-2">Agrega un nuevo examen</h5>
         <form method="post" action="{{route('admin.courses.exams.create')}}">
                                            {!! csrf_field() !!}
                                            <input type="hidden" name="course_id" value="{{request()->route('id')}}">
          <input type="text" name="nombre_examen" placeholder="Título del examen" id="name_material" class="w-100">
                                            <button class="btn btn-secondary">Agregar preguntas</button>
         </form>
        </div>
       </div>
      </div>
     </div>

    </div>

   </div>

   <!--////////////////////////////////// TAB DE ACTIVIDADES /////////////////////////////////-->
   <!--///////////////////////////////////////////////////////////////////////////////////////-->
   <div class="tab-pane fade" id="actividades" role="tabpanel" aria-labelledby="actividades-tab">
    <div class="container_actividades py-2 px-3" style="max-height: 423px;">

     <div class="row">
      <div class="col-sm-6 col-md-6 pl-1 added_actividad">
       <h5 class="mb-2 py-1 pl-2">Actividades Agregadas</h5>
       <div class="container-fluid" style="max-height: 371px; overflow-y: auto;">
       @foreach($activities as $activity)
       <!-- Inicio de Examen agregado 1 -->
       <div class="row my-1">
        <div class="col-sm-10 align-self-center pr-0 title_actividad">
         <a href="{{route('admin.courses.activities.edit', $activity->id)}}" title="Ver" style="text-decoration: none;"><span class="fas fa-file-alt text-dark mr-1"></span> <span class="text-primary">{{$activity->name}}</span></a>
        </div>
        <div class="col-sm-2 pr-1 align-self-center pt-0 delete_actividad">
                                    <a href="{{route('admin.courses.activities.delete', $activity->id)}}" class="text-danger" title="Borrar actividad">
                                        <span class="fas fa-trash-alt"></span>
                                    </a>
        </div>
       </div>
       <!-- Fin de Examen agregado 1 -->
       @endforeach
       </div>
      </div>

      <div class="col-sm-6 col-md-6 container_add">
       <div class="row">
        <div class="col-sm-12 col-md-12 new_actividad">
         <h5 class="mb-2 py-1 pl-2">Agrega una nueva Actividad</h5>
         <form method="post" action="{{route('admin.courses.activities.create')}}">
                                            {!! csrf_field() !!}
                                            <input type="hidden" name="course_id" value="{{request()->route('id')}}">
          <input type="text" name="nombre_actividad" placeholder="Título de la actividad" id="name_material" class="w-100">
                                            <button class="btn btn-secondary">Agregar preguntas</button>
         </form>
        </div>
       </div>
      </div>
     </div>

    </div>
   </div>

   <!--//////////////////////////////////// TAB DE Notas /////////////////////////////////////-->
   <!--///////////////////////////////////////////////////////////////////////////////////////-->
   <div class="tab-pane fade" id="notas" role="tabpanel" aria-labelledby="notas-tab">
    <div class="container px-1">
     <div class="row no-gutters d-flex justify-content-between mt-3 mb-3">
      <div class="col-md-1 align-self-center">
       <a href="" class="btn btn-success" title="Descargar reporte"><i class="fas fa-file-excel"></i></a>
      </div>
      <div class="col-md-10 align-self-center">
       <div class="row no-gutters d-flex justify-content-between">
        <div class="col-3">
         <i class="fas fa-circle text-info"></i><span class="pl-3">Sesiones</span>
        </div>
        <div class="col-3">
         <i class="fas fa-circle text-warning"></i><span class="pl-3">Actividades</span>
        </div>
        <div class="col-3">
         <i class="fas fa-circle text-danger"></i><span class="pl-3">Exámenes</span>
        </div>
       </div>
      </div>
     </div>
     <div class="container_tablas justify-content-center">
      <table class="table table-responsive table-bordered text-center table-hover table-striped w100" style="width:100%; max-width: 100%;max-height: 395px;">
       <thead class="thead-dark">
           <tr>
            <th scope="col" class="font-weight-bold px-0" style="font-size: 14px; min-width: 170px; vertical-align: middle;">Nombre Completo</th>
               <th scope="col" class="font-weight-bold" style="font-size: 14px; min-width: 105px; vertical-align: middle;">DNI</th>
               @foreach($course->sessions as $session)
                <!--<th data-toggle="tooltip" data-placement="top" title="{{$session->name}}" scope="col">Sesion&nbsp;{{$loop->iteration}}</th>-->
                <th scope="col" class="font-weight-bold text-info w-100" style="font-size: 14px; min-width: 150px; max-width: 170px; vertical-align: middle;">{{ $session->name }}</th>
               @endforeach
               @foreach($course->activities as $activitie)
                <!--<th data-toggle="tooltip" data-placement="top" title="{{$activitie->name}}" scope="col">Actividad&nbsp;{{$loop->iteration }}</th>-->
          <th scope="col" class="font-weight-bold text-warning w-100" style="font-size: 14px; min-width: 150px; max-width: 170px; vertical-align: middle;">{{ $activitie->name }}</th>
               @endforeach
               @foreach($course->exams as $exam)
                <!--<th data-toggle="tooltip" data-placement="top" title="{{$exam->name}}" scope="col">Examen&nbsp;{{$loop->iteration }}</th>-->
                <th scope="col" class="font-weight-bold text-danger w-100" style="font-size: 14px; min-width: 150px; max-width: 170px; vertical-align: middle;">{{ $exam->name }}</th>
               @endforeach
           </tr>
       </thead>
       <tbody>
        <!-- Inicio de primer colaborador -->
        @foreach($course->product->students as $student)
        <tr>
         <td class="text-left pr-0 pl-2" style="font-size: 13.5px; vertical-align: middle;">{{$student->full_name}}</td>
         <td style="font-size: 13.5px;">{{$student->dni}}</td>
         @foreach($course->sessions as $session)
                <td scope="col" style="font-size: 13.5px; vertical-align: middle;">
                 <!--
           @for($i=0; $i < $ejercicios->count(); $i++)
                  @if($ejercicios[$i]->id == 17)
                  @if($gradeXcadaSesion->where('student_id', $student->id)->count() > 1)
                  {{$session->id}}
                  @endif
                  @endif
                 @endfor
                  -->
                </td>
               @endforeach
               @foreach($course->activities as $activitie)
                <td scope="col" style="font-size: 13.5px; vertical-align: middle;">Actividad&nbsp;{{$loop->iteration }}</td>
               @endforeach
               @foreach($course->exams as $exam)
                <td scope="col" style="font-size: 13.5px; vertical-align: middle;">Examen&nbsp;{{$loop->iteration }}</td>
               @endforeach
        </tr>
        @endforeach
           <!-- Fin de primer colaborador -->
       </tbody>
      </table>
     </div>
    </div>
   </div>


   <!--/////////////////////////////////// TAB DE ASISTENCIA /////////////////////////////////-->
   <!--///////////////////////////////////////////////////////////////////////////////////////-->
   <div class="tab-pane fade" id="asistencia" role="tabpanel" aria-labelledby="asistencia-tab">
    <div class="container px-1">
     <div class="row no-gutters d-flex justify-content-between mt-3 mb-3">
      <div class="col-md-1 align-self-center">
       <a href="" class="btn btn-success" title="Descargar reporte"><i class="fas fa-file-excel"></i></a>
      </div>
      <div class="col-md-10 align-self-center">
       <div class="row no-gutters d-flex justify-content-around">
        <div class="col-2">
         <i class="fas fa-clipboard-check text-success"></i><span class="pl-2">Asistió</span>
        </div>
        <div class="col-3">
         <i class="fas fa-calendar-times text-danger"></i><span class="pl-2">No Asistió</span>
        </div>
        <div class="col-2">
         <i class="fas fa-desktop text-primary"></i><span class="pl-2">Virtual</span>
        </div>
        <div class="col-4">
         <i class="fas fa-user-clock text-secondary"></i><span class="pl-2">Falta tomar asistencia</span>
        </div>
       </div>
      </div>
     </div>
     <div class="container_tablas">
      <table class="table table-responsive table-bordered text-center table-hover table-striped" style="width:100%; max-width: 100%;max-height: 395px;">
       <thead class="thead-dark">
           <tr>
            <th scope="col" class="font-weight-bold px-0" style="font-size: 14px; min-width: 170px; vertical-align: middle;">Nombre Completo</th>
               <th scope="col" class="font-weight-bold" style="font-size: 14px; min-width: 105px; vertical-align: middle;">DNI</th>
                   @foreach($course->sessions as $session)
                <!--<th data-toggle="tooltip" data-placement="top" title="{{$session->name}}" scope="col">Sesion&nbsp;{{$loop->iteration}}</th>-->
                <th scope="col" class="font-weight-bold w-100" style="font-size: 14px; min-width: 150px; max-width: 170px; vertical-align: middle;">{{ $session->name }}</th>
               @endforeach
               <!--<th scope="col" width="25%">% completado</th>-->
           </tr>
       </thead>
       <tbody>

        <!-- Inicio de primer colaborador -->
        @foreach($course->product->students as $student)
        <tr>
         <td class="text-left pr-0 pl-2" style="font-size: 13.5px; vertical-align: middle;">{{$student->full_name}}</td>
         <td style="font-size: 13.5px;">{{$student->dni}}</td>
         @foreach($course->sessions as $session)
                <td scope="col" style="font-size: 13.5px; vertical-align: middle;">
                @if($session->session_type_id == SESSION_FACE)
                 @if($session->assistances()->whereHas('student', function($query) use ($student){
                  $query->where('id', $student->id)->where('value', 1);
                 })->count())
                 <i class="fas fa-calendar-check text-success" style="font-size: 14px;" title="Asistió"></i>
                 @elseif($session->assistances()->whereHas('student', function($query) use ($student){
                  $query->where('id', $student->id)->where('value', 0);
                 })->count())
                 <i class="fas fa-calendar-times text-danger" style="font-size: 14px;" title="No asistió"></i>
                 @else
                 <i class="fas fa-user-clock text-secondary" style="font-size: 14px;" title="Falta tomar asistencia"></i>
                 @endif
                @elseif($session->session_type_id == SESSION_VIRTUAL)
                 <i class="fas fa-desktop text-primary" style="font-size: 14px;" title="Virtual"></i>
                @endif
                </td>
               @endforeach
         <!--<td></td>-->
        </tr>
        @endforeach
           <!-- Fin de primer colaborador -->

       </tbody>
      </table>
     </div>
    </div>
   </div>

   <!--/////////////////////////////////// TAB DE CERTIFICADOS ///////////////////////////////-->
   <!--///////////////////////////////////////////////////////////////////////////////////////-->
   <div class="tab-pane fade" id="certificados" role="tabpanel" aria-labelledby="certificados-tab">
    <div class="main_container_certificado pb-2 mx-2 mb-0 mt-3" style="min-height: 405px;">
     <div class="container_list_certificado">
      <!-- //////////////   INICIO DE GUARDAR certificado   //////////////// -->
      <div class="row upload_certificado">
        <div class="col-sm-12 col-md-12 ">
         <form method="post" action="{{route('admin.courses.certificates.create')}}" enctype="multipart/form-data">
         {!! csrf_field() !!}
         <input type="hidden" name="course_id" value="{{request()->route('id')}}">
         <div  class="row upload_text_certificado">
          <div class="col-sm-8 align-self-center title_certificado">
           <input type="text" name="name" placeholder="Título de certificado" class="w-100">
          </div>
          <div class="col-sm-4 align-self-center">
           <input type="file" id="certificado" name="uploaded_certificado">
          </div>
         </div>
         <div class="row upload_text_certificado">
          <div class="save_button_certificado col-6 align-self-center float-left text-left">
           <span>
            <select name="student_id">
             <option selected="true" disabled="disabled">Selecciona el estudiante</option>
             @foreach($course->product->students as $student)
             <option value="{{$student->id}}">{{$student->full_name}}</option>
             @endforeach
            </select>
           </span>
          </div>
          <div class="col-6 text-center">
           <button type="submit" class="btn btn-secondary">Guardar</button>
          </div>
         </div>
         </form>
        </div>
      </div>
      <!-- //////////////   FIN DE GUARDAR certificado   //////////////// -->
      <div class="row uploaded_certificado">
       <div class="col-sm-12 col-md-12 ">
        <div  class="row no-gutters header_certificado mx-3">
         <div class="col-sm-4 col-md-4">
          <i class="fas fa-certificate text-warning mr-2"></i><span>Título del certificado</span>
         </div>
         <div class="col-sm-3 col-md-4">
          <i class="fas fa-male mr-2"></i><span> Nombre Completo</span>
         </div>
         <div class="col-sm-3 col-md-2">
          <i class="fas fa-id-card mr-2"></i><span>DNI</span>
         </div>
         <div class="col-sm-2 col-md-2 pl-0 options_certificado">
          <i class="fas fa-filter mr-2"></i><span>Opciones</span>
         </div>
        </div>
       </div>
      </div>


      <div style="max-height: 245px; overflow-y: auto;">
      @foreach($certificates as $certificate)

      <div class="row no-gutters uploaded_certificado mx-3">
       <div class="col-sm-12 col-md-12 ">
        <div  class="row no-gutters upload_text_certificado mx-0 my-1">
         <div class="col-sm-4 col-md-4">
          {{$certificate->name}}
         </div>
         @foreach($course->product->students as $student)
          @if ($certificate->student_id==$student->id)
         <div class="col-sm-3 col-md-4" action="">
          {{$student->full_name}}
         </div>

         <div class="col-sm-3 col-md-2">
          {{$student->dni}}
         </div>
          @endif
          @endforeach
         <div class="col-sm-2 text-center col-md-2 options_certificado">
          <a href="{{asset($certificate->attachment)}}" download class="d-inline-block m-0 mr-2 text-primary" title="Descargar certificado"><span class="fas fa-download"></span></a>
          <a href="{{route('admin.courses.certificates.delete', [$certificate->id, 'course_id' => request()->route('id')])}}" class="d-inline-block m-0 ml-2 text-danger" title="Eliminar certificado"><span class="fas fa-trash-alt"></span></a>
         </div>
        </div>
       </div>
      </div>
      @endforeach
      </div>
     </div>
    </div>

   </div>
  </div>






 </div>
 <div class="col-sm-6 col-md-5 people_curso" style="min-height: 461px;">
  <!-- ********************************** DOCENTE *************************************************-->
  <div class="option_docente">
   <div class="row">
    <div class="col-sm-12 col-md-12 text_docente">
     DOCENTE
    </div>
   </div>
   <div class="row justify-content-between">
    <div class="col-md-6 add_docente ">
     <button class="btn btn-success" data-target="#popup_add_docente" data-toggle="modal"><span class="fas fa-user-plus mr-1"></span><span> Crear nuevo docente</span></button>
    </div>
    <div class="col-md-6 select_docente">
     <button class="btn btn-primary" data-target="#popup_select_docente" data-toggle="modal"><span class="fas fa-mouse-pointer mr-1"></span><span> Seleccionar docente</span></button>
    </div>
   </div>
   <table class="table table-responsive text-center w-100" style="max-height: 200px; overflow-y: auto;">
    <thead>
     <tr>
      <th scope="col" width="33%" class="font-weight-bold px-0" style="font-size: 14px;">Nombre Completo</th>
      <th scope="col" width="33%" class="font-weight-bold" style="font-size: 14px;">DNI</th>
      <th scope="col" width="33%" class="font-weight-bold" style="font-size: 14px;">E-mail</th>
     </tr>
    </thead>
    <tbody>
     @if($course->teacher)
     <tr>
      <td class="text-left pr-0 pl-2" style="font-size: 13.5px;">{{$course->teacher->full_name}}</td>
      <td style="font-size: 13.5px;">{{$course->teacher->dni}}</td>
      <td style="font-size: 13.5px;">{{$course->teacher->personal_email}}</td>
     </tr>
     @endif
    </tbody>
   </table>
  </div>
  <hr>
  <!-- *********************************** ALUMNOS **************************************************-->
  <div class="option_alumno">
   <div class="row">
    <div class="col-sm-12 col-md-12 text_alumnos">
     ALUMNOS
    </div>
   </div>
   <div class="row justify-content-between">
    <div class="col-md-6 add_alumno">
     <button class="btn btn-success" data-target="#popup_add_alumno" data-toggle="modal"><span class="fas fa-user-plus mr-2"></span><span>Crear nuevo alumno</span></button>
    </div>
    <div class="col-md-6 select_alumno">
     <button class="btn btn-primary" data-target="#popup_select_alumno" data-toggle="modal"><span class="fas fa-mouse-pointer mr-2"></span><span>Seleccionar alumnos</span></button>
    </div>
   </div>
   <table class="table table-responsive text-center w-100 mb-2" style="max-height: 200px;">
    <thead>
     <tr>
      <th scope="col" width="33%" class="font-weight-bold px-0" style="font-size: 14px;">Nombre Completo</th>
      <th scope="col" width="33%" class="font-weight-bold" style="font-size: 14px;">DNI</th>
      <th scope="col" width="33%" class="font-weight-bold" style="font-size: 14px;">E-mail</th>
     </tr>
    </thead>
    <tbody>
     @foreach($course->product->students as $student)
     <tr>
      <td class="text-left pr-0 pl-2" style="font-size: 13.5px;">{{$student->full_name}}</td>
      <td style="font-size: 13.5px;">{{$student->dni}}</td>
      <td style="font-size: 13.5px;">{{$student->personal_email}}</td>
     </tr>
     @endforeach
    </tbody>
   </table>
  </div>
 </div>
</div>
</div>

<!-- *********************** INICIO POP-UP AGREGAR DOCENTE ************************* -->
<div class="modal fade" id="popup_add_docente" tabindex="-1" role="dialog" aria-labelledby="popup_docenteLabel1" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="height: 450px; overflow-y: auto">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar Docente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body body_add_docente" style="overflow-y: auto;">
       <div class="container_agregar_docente">
       <div class="row new_docente">
        <div class="col-sm-6 col-md-4 photo_new_docente">
         <img class="circle_photo img-fluid" src="/images/default/user.png" width="100">
          <!-- SE TIENE QUE ACTIVAR PARA QUE LA FOTO SE PUEDA VER UNA VEZ ESTA HAYA SIDO SELECCIONADA -->
         <br>
                <form id="form_create_teacher" role="form" enctype="multipart/form-data" method="post">
                    {!! csrf_field() !!}
         <input type="file" class="file_new_docente ml-4 mt-4" id="file_new_docente" name="image">
        </div>
        <div class="col-sm-6 col-md-8 info_new_docente">
        DNI: <input type="text" name="dni_docente" id="dni_docente"><hr>
          NOMBRE(S): <input type="text" name="nombres_docente" id="nombres_docente"><hr>
          APELLIDO(S): <input type="text" name="apellidos_docente" id="apellidos_docente"><hr>
          TELÉFONO: <input type="text" name="telefono_docente" id="telefono_docente"><hr>
          EMPRESA: <input type="text" name="empresa_docente" id="empresa_docente"><hr>
          E-MAIL EMPRESARIAL: <input type="text" name="email_empresarial_docente" id="email_empresarial_docente"><hr>
          E-MAIL PERSONAL: <input type="text" name="email_personal_docente" id="email_personal_docente"><hr>
          RESUMEN DE CV: <input type="text" name="descripcion_docente" class="description_docente" id="descripcion_docente"><hr>
         </form>
        </div>
       </div>
    </div>



      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="save_teacher">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- *********************** FIN DE POP-UP AGREGAR docente ************************* -->



<!-- *********************** INICIO POP-UP SELECCIONAR DOCENTE ************************* -->
<div class="modal fade" id="popup_select_docente" tabindex="-1" role="dialog" aria-labelledby="popup_docenteLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="max-height: 550px">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Seleccionar Docente</h5>
        <button type="button" class="close btn-close-modal" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body body_select_docente" style="overflow-y: auto;">
       <div class="container-fluid container_docentes">
  <div class="row row_docentes">
   @foreach($teachers as $teacher)
   <!-- ********  Inicio de Docente 1   **********-->
   <div class="col-sm-6 col-md-3 col-docente">
    <div class="highlightbox_docente {{$course->teacher_id == $teacher->id ? 'highlight_docente' : ''}}">
       <input type="radio" value="{{$teacher->id}}" name="radio_docente" id="docente{{$teacher->id}}"><br>
       <label for="docente{{$teacher->id}}" data-full_name="{{$teacher->full_name}}">
        <div class="box_docente">
         <div class="box_docente_top">
           <img src="{{asset($teacher->photo)}}" class="photo_docente my-2" alt="image not available" onerror="this.onerror=null;this.src='/images/default/user.png';">
         </div>
         <div class="box_docente_bottom">
          <p>{{$teacher->full_name}}<br>
           DNI: {{$teacher->dni}}
          </p>
         </div>
        </div>
       </label>
      </div>
     </div>
   <!-- ********  Fin de Docente 1  **********-->
   @endforeach
  </div>
 </div>
      </div>
      <div class="modal-footer">
       <button type="button" class="btn btn-secondary btn-close-modal" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="assign_teacher">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- *********************** FIN DE POP-UP AGREGAR DOCENTE ************************* -->

<!-- *********************** INICIO POP-UP AGREGAR ALUMNO ************************* -->
<div class="modal fade" id="popup_add_alumno" tabindex="-1" role="dialog" aria-labelledby="popup_alumnoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="height: 450px">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar Alumno</h5>
        <button type="button" class="close btn-close-modal" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body body_add_alumnos" style="overflow-y: auto;">
       <div class="container_agregar_alumno">
       <div class="row new_alumno">
        <div class="col-sm-6 col-md-4 photo_new_alumno">
         <img class="circle_photo img-fluid" src="/images/default/user.png" width="100">
          <!-- SE TIENE QUE ACTIVAR PARA QUE LA FOTO SE PUEDA VER UNA VEZ ESTA HAYA SIDO SELECCIONADA -->
         <br>
                <form id="form_create_student" role="form" enctype="multipart/form-data" method="post">
         <input type="file" class="file_new_alumno ml-4 mt-4" id="file_new_alumno" name="image">

        </div>
        <div class="col-sm-6 col-md-8 info_new_alumno">
                        {!! csrf_field() !!}
        DNI: <input type="text" name="dni_alumno" id="dni_alumno"><hr>
          NOMBRE(S): <input type="text" name="nombres_alumno" id="nombres_alumno"><hr>
          APELLIDO(S): <input type="text" name="apellidos_alumno" id="apellidos_alumno"><hr>
          TELÉFONO: <input type="text" name="telefono_alumno" id="telefono_alumno"><hr>
          EMPRESA: <input type="text" name="empresa_name" id="empresa_name"><hr>
          ASIGNAR EMPRESA A CLIENTE: <select name="empresa_alumno" id="empresa_alumno">
            <option value="">Ninguna</option>
           @foreach($businesses as $business)
           <option value="{{$business->company->id}}">{{ $business->social_reason }}</option>
           @endforeach
          </select><hr>
          E-MAIL EMPRESARIAL: <input type="text" name="email_empresarial_alumno" id="email_empresarial_alumno"><hr>
          E-MAIL PERSONAL: <input type="text" name="email_personal_alumno" id="email_personal_alumno"><hr>
         </form>
        </div>
       </div>
    </div>




      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-close-modal" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="save_student">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- *********************** FIN DE POP-UP AGREGAR ALUMNO ************************* -->

<!-- *********************** INICIO POP-UP SELECT ALUMNO ************************* -->
<div class="modal fade" id="popup_select_alumno" tabindex="-1" role="dialog" aria-labelledby="popup_alumnoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="max-height: 550px">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Seleccionar Alumno</h5>
        <button type="button" class="close btn-close-modal" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body body_select_alumnos" style="overflow-y: auto;">
       <div class="container-fluid container_alumnos">
  <div class="row row_alumnos">
   @foreach($businesses as $business)
    <div>{{ $business -> max_students }}</div>
   @endforeach
   @foreach($students as $student)
   <!-- ********  Inicio de Alumno 1   **********-->
   <div class="col-sm-6 col-md-3 col-alumno">
    <div class="highlightbox_alumno {{$course->product->students->contains('id', $student->id) ? 'highlight_alumno' : ''}}">
       <input type="checkbox" value="{{$student->id}}" name="checkbox_alumno[]" id="alumno{{$student->id}}" data-id="{{$student->id}}" {{$course->product->students->contains('id', $student->id) ? 'checked' : ''}}><br>
       <label for="alumno{{$student->id}}" data-full_name="{{$student->full_name}}">
        <div class="box_alumno">
         <div class="box_alumno_top">
           <img src="{{asset($student->photo)}}" class="photo_docente my-2" alt="image not available" onerror="this.onerror=null;this.src='/images/default/user.png';">
         </div>
         <div class="box_alumno_bottom">
          <p>{{$student->full_name}}<br>
           DNI: {{$student->dni}}
          </p>
         </div>
        </div>
       </label>
      </div>
     </div>
   <!-- ********  Fin de Alumno 1  **********-->
   @endforeach
  </div>
 </div>
      </div>
      <div class="modal-footer">
       <button type="button" class="btn btn-secondary btn-close-modal" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="assign_students">Guardar</button>
      </div>
    </div>
  </div>
</div>

<!-- *********************** FIN DE POP-UP SELECCIONAR ALUMNO ************************* -->

<!-- *********************** IMAGEN INTRODUCCTORIA (SI EXISTE) ************************* -->

<div class="modal fade" id="img-introducctorio" tabindex="-1" role="dialog" aria-labelledby="img-introducctorio" aria-hidden="true">
<div class="modal-dialog modal-sm">
     <div class="modal-content">
         <div class="modal-header">
             <h5 class="modal-title font-weight-bold">Imagen introducctoria</h5>
             <button class="close" data-dismiss="modal" aria-label="Cerrar">
                 <span aria-hidden="true">&times;</span>
             </button>
         </div>
         <div class="modal-body">
             <div class="container-fluid px-0">
                 <img src="{{$course->video_intro}}" class="img-fluid rounded" alt="Imagen introductoria">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- *********************** FIN DE POP-UP IMAGEN INTRODUCCTORIA (SI EXISTE) ************************* -->


<div class="container-fluid">
<div class="row no-gutters">
 <div class="col-md-12">
  <!-- *********************** INSTRUCCIONES PARA SUBIR VIDEO ************************* -->

  <div class="modal fade" id="instrucciones_subir_video" tabindex="-1" role="dialog" aria-labelledby="instrucciones_subir_video" aria-hidden="true">
   <div class="modal-dialog modal-lg">
       <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title font-weight-bold">Indicaciones para subir un video</h5>
               <button class="close" data-dismiss="modal" aria-label="Cerrar">
                   <span aria-hidden="true">&times;</span>
               </button>
           </div>
           <div class="modal-body">
               <div class="container-fluid px-0">
                   <ol class="pl-4">
                    <li>
                     Ir a Youtube y seleccionar el video que se desea integrar.</li>
                    <li>Ir al botón de compartir o 'SHARE'(en inglés) o 'COMPARTIR'(en español), que se encuentra al costado de los links y dislikes.</li>
                    <li>Seleccionar la opción de <kbd><code>&lt; &gt;</code>'Embed'</kbd>.</li>
                    <li>Inmediatamente, observamos del lado derecho el video seleccionado y del lado izquierdo un texto que comienza con la etiqueta <code>&lt;iframe&gt;</code> y termina con la etiqueta <code>&lt;/iframe&gt;</code>.</li>
                    <li>Copiamos todo el texto y lo pegamos en nuestro casillero que nos dice 'Ingresa el link del video'</li>
                    <li>Recuerda que solo se desea el link; es decir, debemos quedarnos con la parte que comienza con el <code>src="</code>(contenido que queremos)<code>"</code>.</li>
                    <li>Ejemplo de como debería ser un link: <code>https://www.youtube.com/embed/yxwdKX7ErJ4</code></li>
                   </ol>
                  </div>
              </div>
              <div class="modal-footer">
                  <button class="btn btn-danger" data-dismiss="modal">Cerrar</button>
              </div>
          </div>
      </div>
  </div>
  <!-- *********************** FIN DE POP-UP INSTRUCCIONES PARA SUBIR VIDEO************************* -->
 </div>
</div>
</div>




@stop


@section('extra_scripts')
<script>

$(document).ready(function(){

$(".body").css({"overflow-y":"auto"});

});

/* Validar nuevo docente */

$(".file_new_docente").change(function(){

var imagen = this.files[0];

if(imagen["type"] != "image/jpeg" && imagen["type"] != "image/png"){

 $(".file_new_docente").val("");

 swal({
  type: "error",
  title: "Error al subir la imagen",
  text: "¡La imagen debe ser formato JPG o PNG!",
  confirmButtonText: "Cerrar"
 });

}else if(imagen["size"] > 2000000){

 $(".file_new_docente").val("");

 swal({
  type: "error",
  title: "Error al subir la imagen",
  type: "¡La imagen no debe pesar más de 2MB",
  confirmButtonText: "Cerrar"
 });

}else{

 var datosImagen = new FileReader;
 datosImagen.readAsDataURL(imagen);

 $(datosImagen).on("load", function(){

  var rutaImagen = event.target.result;
  $(".circle_photo").attr("src", rutaImagen);

 });

}

});

/* Fin de validar nuevo docente */


/* Validar nuevo estudiante */

$(".file_new_alumno").change(function(){

var imagen = this.files[0];

if(imagen["type"] != "image/jpeg" && imagen["type"] != "image/png"){

 $(".file_new_alumno").val("");

 swal({
  type: "error",
  title: "Error al subir la imagen",
  text: "¡La imagen debe ser formato JPG o PNG!",
  confirmButtonText: "Cerrar"
 });

}else if(imagen["size"] > 2000000){

 $(".file_new_alumno").val("");

 swal({
  type: "error",
  title: "Error al subir la imagen",
  type: "¡La imagen no debe pesar más de 2MB",
  confirmButtonText: "Cerrar"
 });

}else{

 var datosImagen = new FileReader;
 datosImagen.readAsDataURL(imagen);

 $(datosImagen).on("load", function(){

  var rutaImagen = event.target.result;
  $(".circle_photo").attr("src", rutaImagen);

 });

}

});


/* FIN de validar nuevo estudiante */

function type_selection(that) {

if (that.value == "{{MULTIMEDIA_TYPE_VIDEO_EMBED}}") {
 $('#add_video').show();
 document.getElementById("add_imagen").style.display = "none";
} else if (that.value == "{{MULTIMEDIA_TYPE_IMAGE}}"){
 $('#add_imagen').show();
 document.getElementById("add_video").style.display = "none";

}
}

function limpiarAlumno(){

 $(".circle_photo").attr('src', '{{ asset("css/admin/docente_default.png")}}');
     $("#file_new_alumno").val("");
        $("#dni_alumno").val("");
        $("#nombres_alumno").val("");
        $("#apellidos_alumno").val("");
        $("#telefono_alumno").val("");
        $("#email_empresarial_alumno").val("");
        $("#email_personal_alumno").val("");

   }


   function limpiarDocente(){

     $(".circle_photo").attr('src', '{{ asset("css/admin/docente_default.png")}}');
     $("#file_new_docente").val("");
        $("#dni_docente").val("");
        $("#nombres_docente").val("");
        $("#apellidos_docente").val("");
        $("#empresa_docente").val("");
        $("#telefono_docente").val("");
        $("#email_empresarial_docente").val("");
        $("#email_personal_docente").val("");
        $("#descripcion_docente").val("");

   }


$(document).ready(function(){
$('{{$target}}').click();
    var added_students = [];
    var add_highlight_alumno = 'highlight_alumno';
    var add_highlight_docente = 'highlight_docente';

    $('input[name="checkbox_alumno[]"]:checked').map(function(){
        added_students.push(parseInt($(this).val()));
    });

    $(document).on('click', '.highlightbox_docente', function(e) {
        $('.highlightbox_docente').removeClass(add_highlight_docente);
        $(this).addClass(add_highlight_docente);
        $('.added_docente').empty();
        $('.added_docente').append('<span class="fas fa-user"></span>').append($(this).find('label').data('full_name'));
    });

    $('.row_alumnos').on('click', '.highlightbox_alumno', function(evt){
            evt.preventDefault();
            var id = $(this).find('input').data('id');

            if (!$(this).find('input').is(':checked')) {
                $(this).find('input').prop('checked', true);
                $(this).addClass(add_highlight_alumno);
                added_students.push(id);
                $('.added_alumnos').append('<div data-id="' + id + '"></div>');
                $('.added_alumnos').children().last().append('<span class="fas fa-user"></span>').append($(this).find('input').siblings('label').data('full_name'));
            } else {
                var i = added_students.indexOf(id);
                $(this).find('input').prop('checked', false);
                $(this).removeClass(add_highlight_alumno);
                added_students.splice(i,1);
                $('.added_alumnos').find('div[data-id="' + id + '"]').remove();
            }
    });

    $('#save_student').click(function(){
        var fd = new FormData($('#form_create_student')[0]);
        $.ajax({
            type: "POST",
            url: "{{route('admin.students.json-create')}}",
            data: fd,
            processData: false,
            contentType: false,
            success: function (data) {
                var template = $('<div class="col-sm-6 col-md-3 col-alumno"><div class="highlightbox_alumno"><input type="checkbox" value="x" name="checkbox_alumno[]" id="alumnox" data-id="x"><br><label for="alumnox" data-full_name="x"><div class="box_alumno"><div class="box_alumno_top"><img src="x" class="photo_docente"></div><div class="box_alumno_bottom"><p>x<br>DNI: x</p></div></div></label></div></div>');
                template.find('input').attr('value', data.id)
                                      .attr('id', 'alumno' + data.id)
                                      .attr('data-id', data.id);
                template.find('label').attr('for', 'alumno' + data.id)
                                      .attr('data-full_name', data.full_name);
                template.find('img').attr('src', '{{env("APP_URL")}}' + data.photo);
                template.find('.box_alumno_bottom').html('<p>' + data.full_name + '<br>DNI: ' + data.dni + '</p>');

                $('.row_alumnos').append(template);
                $('#popup_add_alumno').modal('toggle');
                limpiarAlumno();
                window.location.href = window.location.pathname + window.location.search + window.location.hash;
            }
        });

    });
    $('.btn-close-modal').click(function(){
      window.location.href = window.location.pathname + window.location.search + window.location.hash;
    })
    $('#save_teacher').click(function(){
        var fd = new FormData($('#form_create_teacher')[0]);
        $.ajax({
            type: "POST",
            url: "{{route('admin.teachers.json-create')}}",
            data: fd,
            processData: false,
            contentType: false,
            success: function (data) {
                var template = $('<div class="col-sm-6 col-md-3 col-docente"><div class="highlightbox_docente"><input type="radio" value="x" name="radio_docente" id="docentex"><br><label for="docentex" data-full_name="x"><div class="box_docente"><div class="box_docente_top"><img src="x" class="photo_docente"></div><div class="box_docente_bottom"><p>x<br>DNI: x</p></div></div></label></div></div>').clone();
                template.find('input').attr('value', data.id)
                                      .attr('id', 'docente' + data.id);
                template.find('label').attr('for', 'docente' + data.id)
                                      .attr('data-full_name', data.full_name);
                template.find('img').attr('src', '{{env("APP_URL")}}' + data.photo);
                template.find('.box_docente_bottom').html('<p>' + data.full_name + '<br>DNI: ' + data.dni + '</p>');

                $('.row_docentes').append(template);
                $('#popup_add_docente').modal('toggle');
                limpiarDocente();
                window.location.href = window.location.pathname + window.location.search + window.location.hash;
            }
        });

    });

    $('#name, #code, #description , #weight_sessions, #weight_exams, #weight_activities').keyup(function(){
        delay(function(){
            var name = $('#name').val();
            var code = $('#code').val();
            var description = $('#description').val();
            var weight_sessions = $('#weight_sessions').val();
            var weight_exams = $('#weight_exams').val();
            var weight_activities = $('#weight_activities').val();

            if(name != "" && code != "" && description != "" && weight_sessions != "" && weight_exams != "" && weight_activities != ""){

             $.ajax({
                url: "{{route('admin.courses.edit', request()->route('id'))}}",
                type: "POST",
                data: {
                    "name": name,
                    "code" : code,
                    "students": added_students,
                    "description" : description,
                    "weight_sessions" : weight_sessions,
                    "weight_exams" : weight_exams,
                    "weight_activities" : weight_activities,
                    "_token" : "{{csrf_token()}}"
                }
            });

            }

        }, 1500 );
    });

    //  VALIDAR QUE POR LO MENOS EL NOMBRE, CÓDIGO Y DESCRIPCIÓN DE UN CURSO ANTES DE SER CREADO:

    /*$(".btnCrearNuevoCurso").click(function(){

     var nombre_curso = $("#name").val();
     var codigo_curso = $("#code").val();
     var description_curso = $("#description").val();
     var inputNombre = false;
     var inputCode = false;
     var inputDescripcion = false;

     if(nombre_curso == ""){
      $("#name").css({"border-bottom":"1.3px solid red"});
      $("#name").css({"border-top":"1.3px solid red"});
      $("#name").css({"border-right":"1.3px solid red"});
      $("#name").attr("placeholder", "campo obligatorio");
      document.querySelector(".campo_obligatorio_text").className = "d-inline-block text-danger campo_obligatorio_text";
      inputNombre = false;

     }else{

      inputNombre = true;

     }

     if(codigo_curso == ""){

      $("#code").css({"border-bottom":"1.3px solid red"});
      $("#code").css({"border-top":"1.3px solid red"});
      $("#code").css({"border-right":"1.3px solid red"});
      $("#code").attr("placeholder", "campo obligatorio");
      document.querySelector(".campo_obligatorio_text").className = "d-inline-block text-danger campo_obligatorio_text";
      inputCode = false;

     }else{

      inputCode = true;

     }

     if(description_curso == ""){

      $("#description").css({"border":"1.3px solid red"});
      $("#description").attr("placeholder", "campo obligatorio");
      document.querySelector(".campo_obligatorio_text").className = "d-inline-block text-danger campo_obligatorio_text";

      inputDescripcion = false;

     }else{
      inputDescripcion = true;

     }

     if(inputNombre && inputCode &&inputDescripcion){

      $.ajax({
                url: "{{route('admin.courses.edit', request()->route('id'))}}",
                type: "POST",
                data: {
                    "name": nombre_curso,
                    "code" : codigo_curso,
                    "description" : description_curso,
                    "_token" : "{{csrf_token()}}"
                },
                success: function(){

                 swal({
                  title: "¡Nuevo Curso!",
                  text: "Se ha agregado el curso "+nombre_curso+" correctamente"
                 }).then((result)=>{
                  if(result.value){
                   location.href= "http://localhost:8000/admin/cursos";
                  }
                 });

                }
            });

     }

    });*/


    var delay = (function(){
        var timer = 0;
        return function(callback, ms){
            clearTimeout (timer);
            timer = setTimeout(callback, ms);
        };
    })();

    $('#assign_teacher').click(function(e){
        e.preventDefault();
        var teacher = $('input[name="radio_docente"]:checked').val();

        $.ajax({
            url: "{{route('admin.courses.edit', request()->route('id'))}}",
            type: "POST",
            data: {
                "teacher": teacher,
                "_token" : "{{csrf_token()}}"
            }
        }).done(function(data){
            $('#popup_select_docente').modal('toggle');
        }).always(function() {
          window.location.reload();
        });
        //window.location.href = window.location.pathname + window.location.search + window.location.hash;
    });

    $('#assign_students').click(function(e){
        e.preventDefault();
        var students = $('input[name="checkbox_alumno[]"]:checked').val();
      //var cantidadStudents = $('input[name="checkbox_alumno[]"]:checked').length;
      //alert(cantidadStudents);
      var weight_sessions = $('#weight_sessions').val();
        var weight_exams = $('#weight_exams').val();
        var weight_activities = $('#weight_activities').val();
        $(this).attr('disabled','disabled');
        $.ajax({
            url: "{{route('admin.courses.edit', request()->route('id'))}}",
            type: "POST",
            cache:false,
            data: {
                "students": added_students,
                "_token" : "{{csrf_token()}}",
                "weight_sessions" : weight_sessions,
                    "weight_exams" : weight_exams,
                    "weight_activities" : weight_activities,
            }
        }).done(function(data){
            $('#popup_select_alumno').modal('toggle');
        }).always(function() {
          window.location.reload();
        });
    });
    $('#popup_add_docente,#popup_add_alumno,#popup_select_alumno,#popup_select_docente').keyup(function(e) {
      if (e.keyCode === 27) window.location.reload();  // esc
    });
    $('.delete_session').click(function(e){
        e.preventDefault();
        var this_el = $(this);

        $.ajax({
            url: "{{route('admin.sessions.delete', '@')}}".replace('@', this_el.data('id')),
            type: "GET"
        }).done(function(data){
            this_el.parents('.container_sesion').remove();
        });
    });
});
</script>

@stop
