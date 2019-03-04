@extends('admin.templates.base_admin')
@section('extra_css')
	<link rel="stylesheet" type="text/css" href="{{asset('css/admin/style_cursos.css')}}">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
@stop

@section('titulo')
	CURSOS
@stop

@section('home_url')
{{route('admin.courses.index')}}
@stop

@section('logout_url')
{{route('admin.auth.logout')}}
@stop

@section('contenido')

<div class="container container_cursos" style="min-height: 458px;">
	<div class="row">
		<div class="col col-sm-12">
	<a href="{{route('admin.courses.create')}}">
		<div class="container-fluid add_curso">
			<div class="row">
				<div class="col-sm-12 col-md-12 text_crear_curso">
					Crear un nuevo curso
				</div>
			</div>
			<div class="row image_agregar">
				<div class="col-sm-12 col-md-12 text_crear_curso">
					<span class="fas fa-plus-circle fa-2x"></span>
				</div>
			</div>
		</div>
	</a>
	<br>

	<div class="container-fluid px-0" style="max-height: 319px; overflow-y: auto; overflow-x: hidden;">
	@foreach($courses as $course)
		<!-- ****************************   INICIO DEL PRIMER CURSO   ********************** -->
		<div id="accordion_{{$course->id}}" class="row no-gutters" style="margin-bottom: 20px; border-radius: 5px;">
			<div class="card col-12">
			    <div class="card-header" id="headingOne" data-toggle="collapse" data-target="#collapse_{{$course->id}}" aria-expanded="true" aria-controls="collapseOne">
			    	<div class="row">
			    		<div class="col-sm-4 col-md-5 align-self-center title_curso">
			    			{{$course->name}}
			    		</div>
			    		
			    		<div class="col-sm-4 col-md-3 align-self-center" data-id="{{$course->id}}">
			    			<button class="btn btn-secondary button_curso" data-id="{{$course->id}}">Ingresar</button>
			    			&nbsp;

			    		</div>
			    		<div class="col-sm-4 col-md-4 align-self-center average_curso">
			    			Alumnos registrados: <span class="badge badge-info" style="font-size: 1em; height: 33px; width: 33px;">{{$course->product->students()->count()}}</span>			    			<span class="btn btn-danger mt-1 fa fa-trash-alt button_curso_delete" data-id="{{$course->id}}" style="font-size: 1em; height: 33px; width: 33px;"></span>
			    		</div>
			    	</div>
			    	<div class="row mt-1">
			    		<div class="col-sm-6 col-md-6 align-self-start code_curso">
			    			<i class="fas fa-code-branch mr-1"></i> Código: <span>{{$course->product->code}}</span>
			    		</div>
			    		<div class="col-sm-6 col-md-6 align-self-start triangle_curso" style="height: 24px;">
			    			
							<i class="icono_triangulo fas fa-caret-down fa-3x" style="position: relative; top: -13.5px;"></i>
			    		</div>
			    	</div>
			    	<!--<div class="row">
			    		<div class="col-sm-12 col-md-12 time_curso">
			    			Tiempo: {{$course->duration_in_minutes}} minutos
			    		</div>
			    	</div>-->

			    </div>
		 		<!-- Todo lo que sale una vez que se habra el despegable -->
			    <div id="collapse_{{$course->id}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion_{{$course->id}}">
			      <div class="card-body">
			        <div class="row">
			    		<div class="col-sm-12 col-md-12 text_descripcion">
			    			<i class="far fa-file-alt mr-1"></i> Descripción :
			    		</div>
			    		<div class="col-sm-12 col-md-12 description_curso">
			    			{{$course->description}}
			    		</div>
			    		<div class="col-sm-12 col-md-12 text_docente mb-3">
			    			<i class="fas fa-chalkboard-teacher mr-2"></i>Docente
			    		</div>
			    	</div>
			    	@if($course->teacher)
			    	<div class="row ml-2">
			    		<div class="col-sm-3 col-md-1 container_foto">
			    			@if($course->teacher->photo == "")
			    			<div class="docente_foto" style="border: none;">
			    				<img src="/images/default/user.png" class="photo_docente">
			    			</div>
			    			@else
			    			<div class="docente_foto">
			    				<img src="{{asset($course->teacher->photo)}}" class="photo_docente img-fluid">
			    			</div>
			    			@endif
			    		</div>
			    		<div class="col-sm-9 col-md-11 info_docente mt-1">
			   				<span class="text-capitalize font-weight-bold" style="font-size: 21px;">{{$course->teacher->full_name}}</span><br>
			   				<span>{{$course->teacher->description}}</span>
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
</div>
</div>

@stop

@section('extra_scripts')
	<script type="text/javascript">
		$('.button_curso').click(function(){
			$(this).parents('.card-header').removeAttr('data-toggle');
			location.href="{{env('APP_URL')}}" + "admin/cursos/" + $(this).data('id') + "/edit";
		});
		$('.button_curso_delete').click(function(){
			swal('dawda');
			swal({
			  title: "¿Está seguro de eliminar el curso?",
			  text: "Al eliminarlo no podrá recuperarlo.",
			  icon: "warning",
			  buttons: true,
			  dangerMode: true,
			})
			.then((willDelete) => {
			  if (willDelete) {
			  	let id_course = $(this).attr('data-id');
				let this_=this;
				$.ajax({
		            url: "{{route('admin.courses.delete')}}",
		            type: "POST",
		            data: {id:id_course,"_token" : "{{csrf_token()}}"}
		        }).done(function(data){
		        	console.log(data)
		            $(this_).parents('.card').parent('div').fadeOut('fast');
					setTimeout(function(){
						$(this_).parents('.card').parent('div').remove()
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
  </script>

@stop
