@extends('coordinador_empresa.templates.base_coordinador_empresas')
@section('extra_css')
	<link rel="stylesheet" type="text/css" href="{{asset('css/coordinador_empresa/style_cursos.css')}}">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
	<style>
		.footer{
			position: absolute;
			bottom: 0;
		}
		body{
			overflow-y: auto;
		}
	</style>
@stop

@section('titulo')
	CURSOS
@stop

@section('home_url')
{{route('company.courses.index')}}
@stop

@section('logout_url')
	{{route('company.auth.logout')}}
@stop

@section('contenido')

<div class="container container_cursos">
	<div class="container-fluid px-0" style="max-height: 430px; overflow-y: auto; overflow-x: hidden;">
	@foreach($courses as $course)
	<!-- ****************************   INICIO DEL PRIMER CURSO   ********************** -->
	<div id="accordion_{{$course->id}}" class="mb-3 row no-gutters">
		<div class="card col-12" data-id="{{$course->id}}">
		    <div class="card-header" id="headingOne" data-toggle="collapse" data-target="#collapse_{{$course->id}}" aria-expanded="true" aria-controls="collapseOne">
		    	<div class="row">
		    		<div class="col-sm-6 col-md-6 title_curso">
		    			{{$course->instance->name}}
		    		</div>
		    		<div class="col-sm-6 col-md-6 button_curso" data-id="{{$course->instance->id}}">
		    			<a class="btn btn-secondary boton_para_ingresar" href="{{route('company.courses.detail', $course->instance->id)}}">Ingresar</a>
		    		</div>
		    	</div>
		    	<div class="row">
		    		<div class="col-sm-6 col-md-5 add_colaboradores">
		    			<!--Tiempo: {{$course->instance->duration_in_minutes}} minutos--><i class="fas fa-user-graduate mr-2"></i>Alumnos registrados: <span class="badge badge-info" style="font-size: 1em; height: 33px; width: 33px; border: 1.5px solid black;"><span style="position: relative; top: 3px;">{{$course->instance->product->students->where('company_id', $company->id)->count()}}</span></span>
		    		</div>
		    		<div class="col-sm-6 col-md-4 add_colaboradores">
		    			<!--Tiempo: {{$course->instance->duration_in_minutes}} minutos-->
		    			@for ($i = 0; $i < $courses->count() ; $i++)
				     
						
						@if($business->products[$i]['pivot']['product_id'] == $course->id)
							
							@if(($business->getCoursesAttribute()[$i]['pivot']['max_students'] - $course->instance->product->students()->count()) > 1)
							<i class="fas fa-plus-circle mr-2"></i>Cupos disponibles: <span class="badge badge-success" style="font-size: 1em; height: 33px; width: 33px; border: 1.5px solid black;"><span style="position: relative; top: 3px;">{{$business->getCoursesAttribute()[$i]['pivot']['max_students'] - $course->instance->product->students()->count()}}</span></span>
							@elseif(($business->getCoursesAttribute()[$i]['pivot']['max_students'] - $course->instance->product->students()->count()) == 1)
							<i class="fas fa-plus-circle mr-2"></i>Cupos disponibles: <span class="badge badge-warning" style="font-size: 1em; height: 33px; width: 33px; border: 1.5px solid black;"><span style="position: relative; top: 3px;">{{$business->getCoursesAttribute()[$i]['pivot']['max_students'] - $course->instance->product->students()->count()}}</span></span>
							@else
							<i class="fas fa-minus-circle mr-2"></i></i>Sin cupos disponibles: <span class="badge badge-danger" style="font-size: 1em; height: 33px; width: 33px; border: 1.5px solid black;"><span style="position: relative; top: 3px;">{{$business->getCoursesAttribute()[$i]['pivot']['max_students'] - $course->instance->product->students()->count()}}</span></span>
							@endif
						@endif
				        
				    
				@endfor
		    		</div>
		    		<div class="col-sm-6 col-md-3 triangle_curso">
		    			<div class="icono_triangulo fas fa-caret-down fa-3x">
						</div>
		    		</div>
		    	</div>
		    </div>
	 		<!-- Todo lo que sale una vez que se habra el despegable -->
		    <div id="collapse_{{$course->id}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion_{{$course->id}}">
		      <div class="card-body">
		        <div class="row">
		    		<div class="col-sm-12 col-md-12 text_descripcion">
		    			<i class="far fa-file-alt mr-1"></i> Descripción :
		    		</div>
		    		<div class="col-sm-12 col-md-12 description_curso">
		    			{{$course->instance->description}}
		    		</div>
		    		<div class="col-sm-12 col-md-12 text_docente mb-3">
		    			<i class="fas fa-chalkboard-teacher mr-2"></i> Docente
		    		</div>
		    	</div>
		    	@if($course->instance->teacher)
			    <div class="row ml-2">
			    	<div class="col-sm-3 col-md-1 container_foto">
			    		@if($course->instance->teacher->photo == "")
			    		<div class="docente_foto" style="border: none;">
			    			<img src="/images/default/user.png" class="photo_docente">
			    		</div>
			    		@else
			    		<div class="docente_foto">
			    			<img src="{{asset($course->instance->teacher->photo)}}" class="photo_docente img-fluid">
			    		</div>
			    		@endif
			    	</div>
			    	<div class="col-sm-9 col-md-11 info_docente mt-1">
			   			<span class="text-capitalize font-weight-bold" style="font-size: 21px;">{{$course->instance->teacher->full_name}}</span>
			   			<br>
			   			<span>{{$course->instance->teacher->description}}</span>
			    	</div>
			    </div>
			    @endif
		    	
		      </div>
		    </div>
		</div>
	</div>
	<!-- ****************************   FINAL DEL PRIMER CURSO   ********************** -->
	@endforeach
	</div>
</div>

@stop

@section('extra_scripts')
	<script type="text/javascript">
	 	$('.collapse').on('show.bs.collapse', function () {
    		$(this).siblings('.card-header').find('.icono_triangulo').removeClass('fa-caret-down').addClass('fa-caret-up');
  		});

  		$('.collapse').on('hide.bs.collapse', function () {
  			$(this).siblings('.card-header').find('.icono_triangulo').removeClass('fa-caret-up').addClass('fa-caret-down');
  		});

		$('.add-students').click(function(){
			$(this).parents('.card-header').removeAttr('data-toggle');
			var form = $('#form_create_student');
			var course_id = $(this).parents('.card').data('id');
			var action_form = form.prop('action').replace("@", course_id);
			form.prop('action', action_form);
			$('#popup_add_alumno').modal('show');

		});
  </script>

@stop
