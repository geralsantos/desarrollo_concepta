@extends('admin.templates.base_admin')
@section('extra_css')
	<link rel="stylesheet" type="text/css" href="{{asset('css/admin/style_simuladores.css')}}">
@stop

@section('titulo')
	SIMULADORES
@stop

@section('home_url')
{{route('admin.courses.index')}}
@stop

@section('logout_url')
{{route('admin.auth.logout')}}
@stop

@section('contenido')

<div class="container container_simuladores">
	<div class="row">
		<div class="col col-sm-12">
	<a href="{{route('admin.simulators.create')}}">
		<div class="container-fluid add_simulador">
			<div class="row">
				<div class="col-sm-12 col-md-12 text_crear_simulador">
					Crear un nuevo simulador
				</div>
			</div>
			<div class="row image_agregar">
				<div class="col-sm-12 col-md-12 text_crear_simulador">
					<span class="fas fa-plus-circle fa-2x"></span>
				</div>
			</div>
		</div>
	</a>
	<br>
		<div class="container-fluid px-0" style="max-height: 320px; overflow-y: auto;">
		@foreach($simulators as $simulator)
	    <div class="simulador" style="margin-bottom: 20px;">
	    	<div class="row box_simulador">
	    		<div class="col-sm-5 title_simulador">
	    			{{$simulator->name}}
	    		</div>
	    		
	    		<div class="col-sm-3 button_simulador" data-id="{{$simulator->id}}">
	    			<button class="btn btn-secondary button_simulador">Ingresar</button>
	    		</div>
	    		<div class="col-sm-4 average_simulador align-self-center pr-4">
	    			Alumnos registrados: <span class="badge badge-info" style="font-size: 1em; height: 31px; width: 27px;"> {{$simulator->product->students()->count()}}</span>
	    			<span class="btn btn-danger fa fa-trash-alt button_simulador_delete" data-id="{{$simulator->id}}"></span>
	    		</div>
	    	</div>
	    	<div class="row">
	    		<div class="col-sm-12 col-md-12 code_simulador">
	    			<i class="fas fa-code-branch mr-1"></i> Código: <span> {{$simulator->product->code}}</span>
	    		</div>
	    	</div>
	    	<div class="row">
	    		<div class="col-sm-12 col-md-12 time_simulador">
	    			<i class="far fa-file-alt mr-1"></i> Descripción:<br>
	    			{{$simulator->description}}
	    		</div>
	    	</div>
	    </div>
		@endforeach
		</div>
		<!-- ****************************   FINAL DEL PRIMER simulador   ********************** -->
</div>
</div>
</div>

@stop

@section('extra_scripts')
	<script type="text/javascript">
		$('.button_simulador').click(function(){
			$(this).parents('.card-header').removeAttr('data-toggle');
			location.href="{{env('APP_URL')}}" + "admin/simuladores/" + $(this).data('id') + "/edit";
		});

		$('.button_simulador_delete').click(function(){
			swal('dawda');
			swal({
			  title: "¿Está seguro de eliminar el simulador?",
			  text: "Al eliminarlo no podrá recuperarlo.",
			  icon: "warning",
			  buttons: true,
			  dangerMode: true,
			})
			.then((willDelete) => {
			  if (willDelete) {
			  	let id_simulador = $(this).attr('data-id');
				let this_=this;
				$.ajax({
		            url: "{{route('admin.simulators.delete')}}",
		            type: "POST",
		            data: {id:id_simulador,"_token" : "{{csrf_token()}}"}
		        }).done(function(data){
		        	console.log(data)
		            $(this_).parents('.box_simulador').parent('div').fadeOut('fast');
					setTimeout(function(){
						$(this_).parents('.box_simulador').parent('div').remove()
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
