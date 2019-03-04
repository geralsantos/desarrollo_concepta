@extends('admin.templates.base_admin')
@section('extra_css')
	<link rel="stylesheet" type="text/css" href="{{asset('css/admin/style_cursos.css')}}">
@stop

@section('titulo')
	CURSOS
@stop

@section('contenido')

<div class="container container_cursos">
	<a href="#">
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



	<!-- ****************************   INICIO DEL PRIMER CURSO   ********************** -->
	<div id="accordion_1">
		<div class="card">
		    <div class="card-header" id="headingOne" data-toggle="collapse" data-target="#collapse_1" aria-expanded="true" aria-controls="collapseOne">
		    	<div class="row">
		    		<div class="col-sm-4 col-md-3 title_curso">
		    			Nombre de curso 1
		    		</div>
		    		
		    		<div class="col-sm-4 col-md-1 button_curso" data-id="#">
		    			<button>Ingresar</button>
		    		</div>
		    		<div class="col-sm-4 col-md-8 average_curso">
		    			Alumnos registrados: <span>20</span>
		    		</div>
		    	</div>
		    	<div class="row">
		    		<div class="col-sm-6 col-md-6 code_curso">
		    			Código: <span>FG1254</span>
		    		</div>
		    		<div class="col-sm-6 col-md-6 triangle_curso">
		    				<div class="icono_triangulo fas fa-caret-down fa-3x">
							</div>
		    		</div>
		    	</div>
		    	<div class="row">
		    		<div class="col-sm-12 col-md-12 time_curso">
		    			Tiempo: 50 minutos
		    		</div>
		    	</div>

		    </div>
	 		<!-- Todo lo que sale una vez que se habra el despegable -->
		    <div id="collapse_1" class="collapse" aria-labelledby="headingOne" data-parent="#accordion_1">
		      <div class="card-body">
		        <div class="row">
		    		<div class="col-sm-12 col-md-12 text_descripcion">
		    			Descripción
		    		</div>
		    		<div class="col-sm-12 col-md-12 description_curso">
		    			asdfasdfasdfasdfasfasdf
		    		</div>
		    		<div class="col-sm-12 col-md-12 text_docente">
		    			Docente
		    		</div>
		    	</div>
		    	<div class="row">
		    		<div class="col-sm-3 col-md-1 container_foto">
		    			<div class="docente_foto">
		    				<img src="{{asset('images/docentes/julio_cesar.png')}}" class="photo_docente">
		    			</div>
		    		</div>
		    		<div class="col-sm-9 col-md-11 info_docente">
		   				Nombre Apellido Apellido<br>
		   				<span>asjf alskjdf a alsjdf asd falsjdf asdjflkajsdk</span>
		    		</div>
		    	</div>
		      </div>
		    </div>
		</div>
	</div>
	<br>
	<!-- ****************************   FINAL DEL PRIMER CURSO   ********************** -->
		<!-- ****************************   INICIO DEL SEGUNDO CURSO   ********************** -->
	<div id="accordion_2">
		<div class="card">
		    <div class="card-header" id="headingOne" data-toggle="collapse" data-target="#collapse_2" aria-expanded="true" aria-controls="collapseOne">
		    	<div class="row">
		    		<div class="col-sm-4 col-md-3 title_curso">
		    			Nombre de curso 2
		    		</div>
		    		
		    		<div class="col-sm-4 col-md-1 button_curso" data-id="#">
		    			<button>Ingresar</button>
		    		</div>
		    		<div class="col-sm-4 col-md-8 average_curso">
		    			Alumnos registrados: <span>20</span>
		    		</div>
		    	</div>
		    	<div class="row">
		    		<div class="col-sm-6 col-md-6 code_curso">
		    			Código: <span>FG1254</span>
		    		</div>
		    		<div class="col-sm-6 col-md-6 triangle_curso">
		    				<div class="icono_triangulo fas fa-caret-down fa-3x">
							</div>
		    		</div>
		    	</div>
		    	<div class="row">
		    		<div class="col-sm-12 col-md-12 time_curso">
		    			Tiempo: 50 minutos
		    		</div>
		    	</div>

		    </div>
	 		<!-- Todo lo que sale una vez que se habra el despegable -->
		    <div id="collapse_2" class="collapse" aria-labelledby="headingOne" data-parent="#accordion_2">
		      <div class="card-body">
		        <div class="row">
		    		<div class="col-sm-12 col-md-12 text_descripcion">
		    			Descripción
		    		</div>
		    		<div class="col-sm-12 col-md-12 description_curso">
		    			asdfasdfasdfasdfasfasdf
		    		</div>
		    		<div class="col-sm-12 col-md-12 text_docente">
		    			Docente
		    		</div>
		    	</div>
		    	<div class="row">
		    		<div class="col-sm-3 col-md-1 container_foto">
		    			<div class="docente_foto">
		    				<img src="{{asset('images/docentes/julio_cesar.png')}}" class="photo_docente">
		    			</div>
		    		</div>
		    		<div class="col-sm-9 col-md-11 info_docente">
		   				Nombre Apellido Apellido<br>
		   				<span>asjf alskjdf a alsjdf asd falsjdf asdjflkajsdk</span>
		    		</div>
		    	</div>
		      </div>
		    </div>
		</div>
	</div>
	<br>
	<!-- ****************************   FINAL DEL SEGUNDO CURSO   ********************** -->
</div>
<br>
<br>
<br>
<br>
<br>
<br>

@stop

@section('extra_scripts')
	<script type="text/javascript">
		$('.button_curso').click(function(){
			$(this).parents('.card-header').removeAttr('data-toggle');
			location.href="{{env('APP_URL')}}" + "alumnos/cursos/" + $(this).data('id') + "/detalle";
		});
	
	 	$('.collapse').on('show.bs.collapse', function () {
    		$(this).siblings('.card-header').find('.icono_triangulo').removeClass('fa-caret-down').addClass('fa-caret-up');
  		});

  		$('.collapse').on('hide.bs.collapse', function () {
  			$(this).siblings('.card-header').find('.icono_triangulo').removeClass('fa-caret-up').addClass('fa-caret-down');
  		});
  </script>

@stop
