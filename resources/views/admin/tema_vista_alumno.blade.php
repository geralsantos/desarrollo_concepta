@extends('main.base_main')

@section('extra_css')
    <link rel="stylesheet" type="text/css" href="{{asset('css/alumnos/style_sesion_ejemplo.css')}}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
@stop

@section('home_url')
{{route('teacher.courses.index')}}
@stop

@section('logout_url')
    {{route('teacher.auth.logout')}}
@stop

@section('contenido_web')



        <div class="wrapper">
            <!--*******************************INICIO DE SIDEBAR **************************************-->
            <nav id="sidebar" class="active">
                <div class="sidebar-header">
                    <div id="sidebarCollapse">
                        <h3>
                            <div class="title_curso">
                                {{$course->name}} <span class="fas fa-angle-left" aria-hidden="true"></span>
                            </div>

                        </h3>

                        <strong>MENU<span class="fas fa-angle-right" aria-hidden="true"></span></strong>
                    </div>

                </div>

                <ul class="container_sesion">
                    @foreach($theme_groups as $key => $group)
                    <!-- ***************Inicio de Contenido de la primera sesión******************-->
                    <li class="title_sesion">
                        <a href="{{route('user.courses.detail', $course->id)}}">
                            {{\App\Session::find($key)->name}}
                        </a>
                        <strong>
                            <div class=number_sesion>S{{$loop->iteration}}</div>
                        </strong>
                        <li class="list_temas">
                            @foreach($group as $theme)
                            <a class="{{$theme->id == request()->route('id') ? 'hovered' : ''}}" href="{{route('user.courses.theme-detail', $theme->id)}}">{{$theme->name}}</a>
                            @endforeach
                            @foreach($group as $theme)
                            <strong class="list_temas_active">
                                <a class="{{$theme->id == request()->route('id') ? 'hovered' : ''}}" href="{{route('user.courses.theme-detail', $theme->id)}}"><span>T{{$loop->iteration}}</span></a>
                             </strong>
                             @endforeach
                        </li>
                    </li>
                    <!-- ************Final de Contenido de la primera sesión*******************-->
                    @endforeach
                    <li class="mt-3">
                        <a href="{{route('admin.themes.edit', request()->route('id'))}}">Volver a admin</a>
                    </li>
                </ul>
            </nav>

            <!--*******************************FIN DE SIDEBAR **************************************-->
            <!--***************************** INICIO DE CONTENIDO **********************************-->


            <div id="content" style="overflow-y: hidden;">
                <div class="container_principal">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 title_tema text-uppercase mt-3">
                            {{$specific_theme->name}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-7 container_left">
                            <!-- ///////////////////////////     VIDEO E IMAGENES    //////////////////////////////-->
                            @foreach($specific_theme->multimedia as $multimedia)
                                @if($multimedia->multimedia_type_id == MULTIMEDIA_TYPE_VIDEO_EMBED)
                                <!-- Esto se muestra en caso de que sea un video -->
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 container_video">
                                        <div class="video_tema">
                                            <span class="text-uppercase font-weight-bold d-block text-center">{{ $multimedia->name }}</span>
                                            <iframe src="{{$multimedia->url}}" class="mx-auto" allowfullscreen></iframe>
                                        </div>
                                    </div>
                                </div>
                                <hr style="border: 1px solid black;">
                                <!-- Esto se muestra en caso de que sea un video -->
                                @elseif($multimedia->multimedia_type_id == MULTIMEDIA_TYPE_IMAGE)
                                <!-- Esto se muestra en caso de que sea una inagen -->
                                <div class="row justify-content-center">
                                    <div class="col-sm-12 col-md-12 container_imagen text-center">
                                        <div class="imagen_tema">
                                            <span class="text-uppercase font-weight-bold d-block">{{ $multimedia->name }}</span>
                                            <img src="{{asset($multimedia->url)}}" class="rounded img-fluid">
                                        </div>
                                    </div>
                                </div>
                                <hr style="border: 1px solid black;">
                                <!-- Esto se muestra en caso de que sea una imagen -->
                                @endif
                            @endforeach
                        </div>
                        <div class="col-sm-12 col-md-5 container_right">
                             <!-- ///////////////////////////     TABS     //////////////////////////////-->

                            <div class="container_tabs">
                                <!-- ///////////////////   TITULOS DE TABS   ///////////////////////////-->
                                <nav>
                                  <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-descripcion-tab" data-toggle="tab" href="#nav-descripcion" role="tab" aria-controls="nav-descripcion" aria-selected="false">Descripción</a>
                                    <a class="nav-item nav-link" id="nav-materiales-tab" data-toggle="tab" href="#nav-materiales" role="tab" aria-controls="nav-materiales" aria-selected="false">Materiales</a>
                                    <a class="nav-item nav-link" id="nav-ejercicios-tab" data-toggle="tab" href="#nav-ejercicios" role="tab" aria-controls="nav-ejercicios" aria-selected="false">Ejercicios</a>
                                  </div>
                                </nav>
                                <!-- //////////////// CONTENIDO DE TABS//////////////////-->
                                <div class="tab-content p-3" id="nav-tabContent">
                                    <!-- **********************Contenido de "DESCRIPCIÓN"*********************-->
                                    <div class="tab-pane fade show active" id="nav-descripcion" role="tabpanel" aria-labelledby="nav-descripcion-tab">
                                        <div class ="content_descripcion">
                                         <p>{{$specific_theme->description}}</p>
                                        </div>
                                    </div>
                                    <!-- **********************Contenido de "MATERIALES"*********************-->
                                    <div class="tab-pane fade" id="nav-materiales" role="tabpanel" aria-labelledby="nav-materiales-tab">
                                        <div class ="content_materiales">
                                            @foreach($specific_theme->attachments as $attachment)
                                            <!-- Inicio de Material 1-->
                                            <div class="material">
                                                <i class="fas fa-file-signature text-dark mr-2" style="font-size: 15px;"></i>{{$attachment->name}}
                                                <a class="text-primary float-right text-right" href="{{asset($attachment->url)}}" target="_blank" title="Descargar material">
                                                    <span class="fas fa-download"></span>
                                                </a>
                                            </div>
                                            <!-- Fin de Material 1-->
                                            @endforeach
                                        </div>

                                    </div>
                                    <!-- **********************Contenido de "EJERCICIOS"*********************-->
                                    <div class="tab-pane fade" id="nav-ejercicios" role="tabpanel" aria-labelledby="nav-ejercicios-tab">
                                        <div class ="content_ejercicios">
                                            @foreach($specific_theme->exercises as $exercise)
                                            <!-- Inicio de Ejercicio 1-->
                                            <div class="ejercicio">
                                                <a href="#">
                                                    <span class="fas fa-file-alt mr-2"></span> {{$exercise->name}}
                                                </a>
                                            </div>
                                            <!-- Fin de Ejercicio 1-->
                                            @endforeach
                                        </div>
                                        <br>
                                    </div>
                                </div>

                            </div>
                        </div>


                    </div>


                </div>



            </div>

        </div>
            <!--***************************** FIN DE CONTENIDO **********************************-->




@stop

@section('extra_scripts')


@stop
