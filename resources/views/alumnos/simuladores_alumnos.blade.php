@extends('alumnos.templates.base_alumnos')

@section('extra_css')
	<link rel="stylesheet" type="text/css" href="{{asset('css/alumnos/style_simuladores.css')}}">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
@stop

@section('titulo')
	SIMULADORES
@stop

@section('home_url')
{{route('user.courses.index')}}
@stop

@section('logout_url')
	{{route('user.auth.logout')}}
@stop

@section('contenido')

<!--////////////////////////////////////INICIO DE SIMULADOR///////////////////////////////////////// -->

<div class = "container parent">
	<div style="max-height: 440px; overflow-y: auto;">
	@foreach($simulators as $simulator)
	<!-- Este es el cuadro que contiene toda la información -->
	<div class = "container_simulador mb-3">
		<!-- Div que contiene el titulo -->
		<div class="row">
			<div class="col-sm-12 col-md-12 titulo_simulador">
				{{$simulator->instance->name}}
			</div>
		</div>
		<!-- /////////////////////////////TABS/////////////////////////-->

		<div class="container_tabs">
			<!-- //////////////// TITULOS DE TABS//////////////////-->
			<nav>
			  <div class="nav nav-tabs" id="nav-tab-{{$simulator->id}}" role="tablist">
			    <a class="nav-item nav-link active" id="nav-home-tab-{{$simulator->id}}" data-toggle="tab" href="#nav-home-{{$simulator->id}}" role="tab" aria-controls="nav-home-{{$simulator->id}}" aria-selected="true">Descripción</a>
			    <a class="nav-item nav-link" id="nav-profile-tab-{{$simulator->id}}" data-toggle="tab" href="#nav-profile-{{$simulator->id}}" role="tab" aria-controls="nav-profile-{{$simulator->id}}" aria-selected="false">Materiales</a>
			    <a class="nav-item nav-link" id="nav-contact-tab-{{$simulator->id}}" data-toggle="tab" href="#nav-contact-{{$simulator->id}}" role="tab" aria-controls="nav-contact-{{$simulator->id}}" aria-selected="false">Exámenes</a>
			  </div>
			</nav>
			<!-- //////////////// CONTENIDO DE TABS//////////////////-->
			<div class="tab-content px-0" id="nav-tabContent">
				<!-- **********************Contenido de "DESCRIPCIÓN"*********************-->
				<div class="tab-pane fade show active" id="nav-home-{{$simulator->id}}" role="tabpanel" aria-labelledby="nav-home-tab-{{$simulator->id}}">
					@if($simulator->instance->description == "")
					<div class="alert alert-dark mb-0 mt-3 text-uppercase text-center" role="alert">
					  Este simulador no tiene descripción !!!
					</div>
					@else
			  		<div class ="content_descripcion p-3">
			  		{{$simulator->instance->description}}
			  		</div>
			  		@endif
				</div>
				<!-- **********************Contenido de "MATERIALES"*********************-->
			  	<div class="tab-pane fade" id="nav-profile-{{$simulator->id}}" role="tabpanel" aria-labelledby="nav-profile-tab-{{$simulator->id}}">
			  		<!-- Material 1-->
			  		@if($simulator->instance->attachments->count() > 0)
			  		<div class="container-fluid py-3" style="min-height: auto";>
				  		<div class ="row content_materiales mb-2">
				  			@foreach($simulator->instance->attachments as $attachment)
				  			<div class="col-sm-12 my-1 align-self-center">
								<div class="row no-gutters justify-content-start">
									<div class="col-md-4">
										<i class="fas fa-file-alt mr-2 text-dark" style="position: relative; top: 2px;"></i> <span>{{$attachment->name}}</span>
									</div>
									<div class="col-md-1">
										<a href="{{asset($attachment->url)}}" target="_blank" class="text-primary" title="Descargar material">
										<span class="fas fa-download" style="position: relative; top: 2px;">
										</span>
										</a>
									</div>
								</div>
							</div>
							@endforeach
				  		</div>
			  		</div>
			  		@else
			  		<div class="alert alert-dark mb-0 mt-3 text-uppercase text-center" role="alert">
					  Este simulador no tiene materiales disponibles !!!
					</div>
			  		@endif
			  	</div>
			  	<!-- **********************Contenido de "EXÁMENES"*********************-->
			  	<div class="tab-pane fade" id="nav-contact-{{$simulator->id}}" role="tabpanel" aria-labelledby="nav-contact-tab-{{$simulator->id}}">
			  		@if($simulator->instance->grouped_exams->count() > 0)
			  		<div class ="container-fluid content_examenes mt-3" style="min-height: auto;">
			  			@foreach($simulator->instance->grouped_exams as $exams)
			  			<!-- *********** Categoría 1 ***************-->
			  			<div class ="row categoria_examen">
			  				<div class="col-sm-12 col-md-12 mb-2 py-2">
				  			@foreach($exams as $exam)
				  				@if($loop->first)
				  				<div class ="row titulo_categoria">
				  					<div class="col-sm-12 col-md-auto" style="border-bottom: 1px solid black;">
				  						<i class="fas fa-sitemap text-dark mr-2" style="font-size: 12px; position: relative; top: -2px;"></i>
				  						<span class="text-uppercase font-weight-bold" style="font-size: 16px;">{{$exams->first()->category->name}}</span>
				  					</div>
				  				</div>
				  				@endif
				  				<!-- Examen 1-->
				  				<div class ="row examen mb-2"> 
				  					<div class ="col-sm-3 col-md-4 align-self-center titulo_examen">
				  						<i class="fas fa-file-alt text-dark mr-2"></i><span>{{$exam->name}}</span>
				  					</div>
									<!--@if($form = \App\SubmittedForm::where('entity_name', ENTITY_SIMULATOR_EXAM)->where('entity_id', $exam->id)->where('student_id', auth()->guard('web')->user()->id)->first())
										@if(!$form->evaluated)
										<div class="col-sm-3 col-md-3 align-self-center">
											<a href="#" class="btn button_examen">
												Realizar Examen
											</a>
										</div>
										<div class="col-sm-3 col-md-3 align-self-center">
											<a href="#">Ver nota</a>
										</div>
										@else
										<div class="col-sm-3 col-md-3 align-self-center">
											<a href="#" class="btn button_examen">
												Realizar Examen
											</a>
										</div>
										<div class="col-sm-3 col-md-3 align-self-center">
											<a href="{{route('user.questions.result-review', ['entity_name' => ENTITY_SIMULATOR_EXAM, 'entity_id' => $exam->id])}}">Ver nota</a>
										</div>
										@endif
										@else
										<div class="col-sm-3 col-md-3 align-self-center">
											<a href="{{route('user.questions.form', ['entity_name' => ENTITY_SIMULATOR_EXAM, 'entity_id' => $exam->id])}}" class="btn button_examen">
										</div>
											Realizar Examen
										</a>
										<a href="#" style="text-decoration: none;">Ver nota</a>
									@endif-->
				  					<div class ="col-sm-3 col-md-3 text-center align-self-center titulo_intento">
				  						Intento Nro: <span class="badge badge-info p-2"><span style="font-size: 14px;">{{$simulator->pivot->attempts}}</span></span>
				  					</div>
				  					<div class="col-sm-3 col-md-3 text-center align-self-center">
				  						<span>Nota promedio :</span>
				  						<span class="badge badge-success p-2"><span style="font-size: 15px;"><b>14/20</b></span></span>
				  					</div>
				  					<div class="col-sm-3 col-md-2 text-center align-self-center">
				  						<button class="btn btn-sm btn-dark">Dar examen</button>
				  					</div>
				  				</div>
				  				<hr class="my-0">
				  				@endforeach
				  			</div>
			  			</div>
			  			@endforeach
			  		</div>
			  		@else
			  		<div class="alert alert-dark mb-0 mt-3 text-uppercase text-center" role="alert">
					  Este simulador no tiene exámenes disponibles !!!
					</div>
			  		@endif
			  	</div>
			</div>			

		</div>
	</div>
	@endforeach
	</div>
</div>

<!--//////////////////////////////////////FIN DE DESPEGABLE////////////////////////////////////////// --> 


@stop

@section('extra_scripts')


@stop