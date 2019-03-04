@extends('main.base_main')

@section('extra_css')
    <link rel="stylesheet" type="text/css" href="{{asset('css/coordinador_empresa/style_sesion_ejemplo.css')}}">
@stop

@section('home_url')
{{route('user.courses.index')}}
@stop

@section('logout_url')
    {{route('user.auth.logout')}}
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
                </ul>         
            </nav>
       
            <!--*******************************FIN DE SIDEBAR **************************************-->
            <!--***************************** INICIO DE CONTENIDO **********************************-->
           
            
            <div id="content">
                <div class="container_principal">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 title_tema">
                            {{$specific_theme->name}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-8 container_left">
                            <!-- ///////////////////////////     VIDEO E IMAGENES    //////////////////////////////-->
                            @foreach($specific_theme->multimedia as $multimedia)
                                @if($multimedia->multimedia_type_id == MULTIMEDIA_TYPE_VIDEO_EMBED)
                                <!-- Esto se muestra en caso de que sea un video -->
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 container_video">
                                        <div class="video_tema">
                                            <iframe src="{{$multimedia->url}}" allowfullscreen></iframe>
                                           Titulo del video
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <!-- Esto se muestra en caso de que sea un video -->
                                @elseif($multimedia->multimedia_type_id == MULTIMEDIA_TYPE_IMAGE)
                                <!-- Esto se muestra en caso de que sea una inagen -->
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 container_imagen">
                                        <div class="imagen_tema">
                                            <img src="{{asset($multimedia->url)}}">
                                            Titulo del video
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                        <div class="col-sm-12 col-md-4 container_right">
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
                                <div class="tab-content" id="nav-tabContent">
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
                                                <span class="fas fa-info-circle"></span> {{$attachment->name}} 
                                                <a href="{{asset($attachment->url)}}" target="_blank">
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
                                                    <span class="fas fa-file"></span> {{$exercise->name}}
                                                </a>
                                                <a href="#">Ver nota</a>
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

<script type="text/javascript">
 $(document).ready(function () {

    $('.sidebar-header').on('click', function () {
        $('#sidebar').toggleClass('active');
    });

    $('#annotation').keyup(function(){
        delay(function(){
            var text = $('#annotation').val();
            $.ajax({
                url: "{{route('user.courses.save-annotation')}}",
                type: "POST",
                data: {
                    "course": "{{$course->id}}",
                    "text" : text,
                    "_token" : "{{csrf_token()}}"
                }
            });
        }, 2000 );
    });

    var delay = (function(){
        var timer = 0;
        return function(callback, ms){
            clearTimeout (timer);
            timer = setTimeout(callback, ms);
        };
        })();
    });
</script>

@stop