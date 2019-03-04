@extends('admin.templates.base_admin')
@section('extra_css')
<link rel="stylesheet" type="text/css" href="{{asset('css/admin/style_evaluaciones.css')}}">
@stop

@section('titulo')
EVALUACIONES
@stop

@section('home_url')
{{route('admin.courses.index')}}
@stop

@section('logout_url')
{{route('admin.auth.logout')}}
@stop

@section('contenido')

<div class="container-fluid container_evaluaciones">
<div class="row">
 <div class="col-sm-6 col-md-9 added_evaluaciones">
  <!-- Filtro para los temas -->
  <label for="filter_categories_select" class="ml-2">Seleccione un tema :</label>

  <select id="filter_categories_select" onchange="location=this.value;" class="mb-3 ml-1">
   <option value="?" selected>Todos los temas</option>
   @foreach($categories as $category)
   <option value="?category={{$category->id}}" {{request()->has('category') ? (request('category') == $category->id ? 'selected' : '') : ''}}>{{$category->name}}</option>
   @endforeach
  </select>
  <i class="fas fa-mouse-pointer ml-2 text-info"></i>

  <div class="mt-2" style="max-height: 550px; overflow-y: auto;">
  @foreach($exams as $exam)
  <!-- ****************************   INICIO DEL PRIMER EVALUACION   ********************** -->
     <div class="evaluacion py-3 mb-3">
      <div class="row box_evaluacion">
       <div class="col-sm-4 col-md-5 title_evaluacion">
        {{$exam->title}}
       </div>
       
       <div class="col-sm-4 col-md-3 text-center button_evaluacion" data-id="{{$exam->id}}">
        <button class="btn btn-secondary button_evaluacion button_ingreso" data-id="{{$exam->id}}">Ingresar</button>
       </div>
       <div class="col-sm-4 col-md-4 students_evaluacion">
        Alumnos registrados: <span class="badge badge-info" style="font-size: 1em; height: 31px; width: 27px;"> {{$exam->product->students()->count()}}</span>
        <span class="btn btn-danger fa fa-trash-alt button_evaluacion_delete" data-id="{{$exam->id}}"></span>
       </div>
      </div>
      <div class="row">
       <div class="col-sm-12 col-md-12 code_evaluacion">
        <i class="fas fa-code-branch mr-1"></i> Código: <span> {{$exam->product->code}}</span>
       </div>
      </div>
      <div class="row">
       <div class="col-sm-12 col-md-12 time_evaluacion">
        <i class="fas fa-clock mr-1"></i> Tiempo: <span> {{$exam->duration_in_minutes}} minutos</span>
       </div>
      </div>
      <div class="row">
       <div class="col-sm-12 col-md-12 time_evaluacion">
        <i class="far fa-file-alt mr-1"></i> Descripción:<br>
     {{$exam->description}}
       </div>
      </div>
                <!--<div class="row">
                    <div class="col-sm-12 col-md-12 time_evaluacion">
                        Alumnos:<br>
                        @foreach($exam->product->students as $student)
                            Estudiante 1
                            <div  class="row students_examenes">
                                <div class="col-sm-6 col-md-3">
                                    <span class="fas fa-check-circle"></span> {{$student->full_name}}<br>
                                </div>
                            </div>
                            Estudiante 1
                        @endforeach
                    </div>
                </div>-->
     </div>
  <!-- ****************************   FINAL DEL PRIMER EVALUACION   ********************** -->
  @endforeach
  </div>
 </div>
 
 <div class="col-sm-6 col-md-3 add_content" style="min-height: 600px;">
  <!-- ACA SE AGREGAN LOS TEMAS -->
  <div class="row">
   <div class="col-sm-12 col-md-12 new_tema px-2" style="border-bottom: 2px dashed black">
    <h5 class="font-weight-bold">Agrega un nuevo tema</h5>
    <form id="category_form" class="mb-2">
     {!! csrf_field() !!}
     <input type="text" name="nombre_tema" placeholder="Título del tema" id="name_tema" class="w-100 mt-2">
    </form>
    <button class="btn btn-secondary mt-2" id="category_button"><span class="fas fa-plus-circle"></span> Agregar tema</button>
   </div>
  </div>
  <!-- AQUI SE AGREGAN LAS EVALUACIONES -->
  <div class="row mt-3">
   <div class="col-sm-12 col-md-12 new_evaluacion">
    <form method="post" action="{{route('admin.exams.create')}}">
                    {!! csrf_field() !!}
     <select id="category_select" name="category_id">
      <option selected="true" disabled="disabled">Selecciona el tema</option>
      @foreach($categories as $category)
      <option value="{{$category->id}}">{{$category->name}}</option>
      @endforeach
     </select>
     <br>
     <button class="btn btn-secondary mt-4" id="category_button"><span class="fas fa-plus-circle"></span> Agregar Evaluación</button>
    </form>
   </div>
  </div>
  
 </div>
 
</div>
</div>

@stop

@section('extra_scripts')
<script type="text/javascript">
$('.button_evaluacion').click(function(){
 $(this).parents('.card-header').removeAttr('data-toggle');
 location.href="{{env('APP_URL')}}" + "admin/evaluaciones/" + $(this).data('id') + "/edit";
});

$('.button_evaluacion_delete').click(function(){
  swal('dawda');
  swal({
    title: "¿Está seguro de eliminar la evaluación?",
    text: "Al eliminarla no podrá recuperarla.",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
     let id_exam = $(this).attr('data-id');
   let this_=this;
   $.ajax({
             url: "{{route('admin.exams.delete')}}",
             type: "POST",
             data: {id:id_exam,"_token" : "{{csrf_token()}}"}
         }).done(function(data){
          console.log(data)
             $(this_).parents('.box_evaluacion').parent('div').fadeOut('fast');
    setTimeout(function(){
     $(this_).parents('.box_evaluacion').parent('div').remove()
    },300);
    
         }).fail(function(err){
          console.log(err)
          swal("Ha ocurrido un problema al eliminar el registro", {
         icon: "danger",
       });
         });
    }
  });
 });


$('.collapse').on('show.bs.collapse', function () {
     $(this).siblings('.card-header').find('.icono_triangulo').removeClass('fa-caret-down').addClass('fa-caret-up');
   });

   $('.collapse').on('hide.bs.collapse', function () {
    $(this).siblings('.card-header').find('.icono_triangulo').removeClass('fa-caret-up').addClass('fa-caret-down');
   });

    $('.sidebar-header').on('click', function () {
        $('#sidebar').toggleClass('active');
    });

    $('#category_button').click(function(){
        var fd = new FormData($('#category_form')[0]);
        $.ajax({
            type: "POST",
            url: "{{route('admin.exams.categories.create')}}",
            data: fd,
            processData: false,
            contentType: false,
            success: function (data) {
                var template = $('<div class="added_tema"><h5></h5></div>');
                var option_template = $('<option></option>');
                var filter_option_template = $('<option></option>');
                option_template.val(data.id);
                option_template.text(data.name);
                filter_option_template.val('?category=' + data.id);
                filter_option_template.text(data.name);
                $('input[name="nombre_tema"]').val('');
                $('#category_select').append(option_template);
                $('#filter_categories_select').append(filter_option_template);
            }
        });
    });
</script>

@stop