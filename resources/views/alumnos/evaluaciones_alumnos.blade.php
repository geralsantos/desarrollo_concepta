@extends('alumnos.templates.base_alumnos')

@section('extra_css')
	<link rel="stylesheet" type="text/css" href="{{asset('css/alumnos/style_evaluaciones.css')}}">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<style>
		.footer{
			position: absolute;
			bottom: 0;
		}
		.nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link {
    color: #495057;
    background-color: #fff;
    border-color: #dee2e6 #dee2e6 #fff;
}
.active[data-toggle="tab"] {
    background-color: #295120 !important;
    color: white !important;
}

.container_tabs .nav-item:hover {
    background-color: #295120 !important;
    border: medium none;
    border-radius: 0;
    color: white;
}

.nav-item {
    border: medium none;
    color: #295120;
}
	</style>
@stop

@section('titulo')
	EVALUACIONES
@stop

@section('home_url')
{{route('user.courses.index')}}
@stop

@section('logout_url')
	{{route('user.auth.logout')}}
@stop

@section('contenido')

<!--////////////////////////////////////INICIO DE EVALUACIÓN 1///////////////////////////////////////// -->
<div class="container parent">

<div style="max-height: 440px; overflow-y: auto;">
@foreach($exams as $exam)
	<!-- Este es el cuadro que contiene toda la información -->
	<div class = "container_evaluacion mb-3">
		<!-- Div que solo hace referencia al texto -->
		<div class="row">
			<div class="col-md-6">
				<span>{{$exam->instance->name}}</span>
			</div>
		</div>
		<!-- Div que contiene el titulo e información del desempeño -->
		<div class="row">
			<div class ="col-sm-4 col-md-8 align-self-center titulo_evaluacion mb-2">
				{{$exam->instance->id}}	{{$exam->instance->title}}
			</div>
			<div class = "col-sm-4 col-md-2 text-left float-left container_desempeno mb-2">
				<div class ="nota_obtenida d-inline-block float-left mt-1" style="width: auto;">
					Nota:
				</div>
				<div class ="desempeno_nota d-inline-block float-left" style="border: none;">
					<span class="badge badge-info" style="font-size: 1em; height: 33px; width: 33px; border: 1.5px solid black;">
					<span style="position: relative; top: 3px;">{{\App\SubmittedForm::where('entity_name', ENTITY_EXAM)->where('entity_id', $exam->instance->id)->where('student_id', auth()->guard('web')->user()->id)->first() ? \App\SubmittedForm::where('entity_name', ENTITY_EXAM)->where('entity_id', $exam->instance->id)->where('student_id', auth()->guard('web')->user()->id)->first()->answers->sum('final_score') : 0}}</span></span>
				</div>
			</div>
			<div class="col-md-2 text-center align-self-center mb-2">
				<!--<a href="#">
				<button class ="button_demo_evaluacion"> Realizar demo </button>-->
				<div class="row no-gutters">
				@if($form = \App\SubmittedForm::where('entity_name', ENTITY_EXAM)->where('entity_id', $exam->instance->id)->where('student_id', auth()->guard('web')->user()->id)->first())
                @if(!$form->evaluated)
								<div class="button_container_examen col-md-2 align-self-center text-right pr-3">
										<button class="btn btn-primary btn-sm roudend" title="Esperando resultados">
											<i class="fas fa-pause-circle"></i>
										</button>
								</div>
				        <!--div class="col-sm-6 col-md-6 students_evaluacion">
									<a href="#"><button class ="button_tomar_examen btn btn-dark"> Tomar Examen </button></a>
				        </div-->
                @else

                <div class="col-md-6 order-1 text-right align-self-center">
									<a href="{{route('user.questions.result-review', ['entity_name' => ENTITY_EXAM, 'entity_id' => $exam->instance->id])}}" class="btn btn-success btn-sm rounded" title="Ver resultados"><i class="fas fa-eye"></i></a>
                	<!--a href="{{route('user.questions.result-review', ['entity_name' => ENTITY_EXAM, 'entity_id' => $exam->instance->id])}}" style="text-decoration: none;">Ver nota</a-->
                </div>
                @endif
            @else

	            <div class="col-md-6 order-2 align-self-center">
								<a href="{{route('user.questions.form', ['entity_name' => ENTITY_EXAM, 'entity_id' => $exam->instance->id])}}" class="btn btn-secondary button_examen btn-sm rounded" title="Realizar examen">
									<i class="fas fa-pen-square"></i>
								</a>
	            	<!--a href="{{route('user.questions.form', ['entity_name' => ENTITY_EXAM, 'entity_id' => $exam->instance->id])}}"><button class ="button_tomar_examen btn btn-dark"> Tomar Examen </button></a-->
	            </div>
	            <!--div class="col-md-6 order-1 text-right align-self-center">
	            	<a href="#" style="text-decoration: none;">Ver nota</a>
	            </div-->
            @endif
            </div>
			</div>

			<div class="col-sm-12 col-md-12 code_evaluacion">
			 <i class="fas fa-code-branch mr-1"></i> Código: <span> {{$exam->instance->product->code}}</span>
			</div>
			<div class="col-sm-12 col-md-12 time_evaluacion">
			 <i class="fas fa-clock mr-1"></i> Tiempo: <span>{{$exam->instance->duration_in_minutes}}  minutos</span>
			</div>
			<div class="col-sm-12 col-md-12 time_evaluacion">
			 <i class="far fa-file-alt mr-1"></i> Descripción:<br>
			 {{$exam->instance->description}}
			</div>
		</div>
		<!-- ******************************TABS*********************************************-->

		<div class="container_tabs" style="display:none;">
			<!-- ************************** TITULOS DE TABS ********************************-->
			<nav>
			  <div class="nav nav-tabs" id="nav-tab" role="tablist">
			    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home-{{$exam->id}}" role="tab" aria-controls="nav-home" aria-selected="true">Descripción</a>
			    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile-{{$exam->id}}" role="tab" aria-controls="nav-profile" aria-selected="false">Materiales</a>
			  </div>
			</nav>
			<!-- ************************** CONTENIDO DE TABS ******************************-->
			<div class="tab-content" id="nav-tabContent">
				<!-- **********************Contenido de "DESCRIPCIÓN"*********************-->
				<div class="tab-pane fade show active" id="nav-home-{{$exam->id}}" role="tabpanel" aria-labelledby="nav-home-tab">
					@if($exam->instance->description == "")
					<div class="alert alert-secondary text-center mt-3 mb-0" role="alert">
  					Esta evaluación no tiene descripción !!!
					</div>
			  		@else
			  		<div class ="content_descripcion mt-3">
			  			{{$exam->instance->description}}
			  		</div>
			  		@endif
				</div>
				<!-- ********************** Contenido de Tab "MATERIALES"*********************-->
			  	<div class="tab-pane fade" id="nav-profile-{{$exam->id}}" role="tabpanel" aria-labelledby="nav-profile-tab">
			  		<br>
			  		<!-- ************************** INICIO del Material 1 ************************-->
			  		@foreach($exam->instance->attachments as $attachment)
			  		<div class ="content_materiales">
			  			<div class="material">
							<img src="{{asset('images/alumnos/evaluaciones/material_icon.png')}}" class="icon_material">
						<div class="text_material">
							{{$attachment->name}}
						</div>
							<a href="{{asset($attachment->url)}}" target="_blank">
								<img src="{{asset('images/alumnos/evaluaciones/download_icon.png')}}" class="icon_download">
							</a>
						</div>
			  		</div>
			  		@endforeach
			  		<!-- ************************** FIN del Material 1 ************************-->
			  	</div>
			</div>
		</div>
	</div>
@endforeach
</div>
</div>
<!--//////////////////////////////////////FIN DE EVALUACIÓN 1//////////////////////////////////////// -->
@stop

@section('extra_scripts')

@stop
