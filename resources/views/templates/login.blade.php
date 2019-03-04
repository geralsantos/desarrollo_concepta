
<html>
<head>

<!-- Cabezera de la página -->
<title>Aula Virtual</title>

	<!-- Vínculo al archivo css de la parte del login -->
	<link rel="stylesheet" type="text/css" href="{{ asset('css/login/style_login.css' )}}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap/bootstrap.min.css') }}">

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
	<script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
	<script src="{{ asset('css/jquery.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('css/bootstrap.min.js') }}"></script>

</head>
<body id="login_concepta">
	<div class="login_user">
 
	 	<!-- Icono del login -->
		<img src="{{asset('images/logo/logo.png')}}" class="concepta_logo">
		<!-- Seleccion del tipo de usuario -->
		<form method="post" id="form_selection" action="@yield('login_url')">
		<div class="row select-profile">
			<div class="col-sm-12 col-md-12 select_user">
				<select id="perfil" required>
					<option value="" selected disabled>Selecciona el tipo de usuario</option>
					<option value="estudiante">Estudiante</option>
					<option value="docente">Docente</option>
					<option value="empresa">Empresa</option>
				</select>
			</div>
		</div>
			<!-- Ingresar información del usuario -->
				{!! csrf_field() !!}
				<p>Usuario: <input type="text" id="username" placeholder="Ingresar Usuario" name="username" class="validate" required autofocus></p>
				<hr>
				<p>Contraseña: <input type="password" id="password" placeholder="Ingresar Contraseña" name="password" class="validate" required></p>
				<hr>
				<p><button type="submit"class="text-uppercase btn-block mb-2 btn btn-success">Login</button></p>
				@if (count($errors) > 0)
			    <div class="alert alert-danger p-2 pb-1">
			        <ul class="p-0 mb-1">
			            @foreach ($errors->all() as $error)
			            <li>{{ $error }}</li>
			            @endforeach
			        </ul>
			    </div>
			    @endif

				<!-- Si el usuario se olvidó su contraseña -->
				<a href="#" data-toggle="modal" data-target="#modalForgetPass">¿Olvidaste tu contraseña?</a>
			</form>
		
	</div>

	<!-- Ventana Modal de ¿Olvidaste tu contraseña? -->
	<div class="container-fluid">
		<div class="row no-gutters">
			<div class="col-12">
				<div class="modal fade" id="modalForgetPass" tabindex="-1" role="dialog" aria-labellebdy="modalForgetPass" aria-hidden="true">
					<div class="modal-dialog modal-md">
						<div class="modal-content">
							<form role="form" method="get">
								<div class="modal-header">
									<h5 class="modal-title">Recupera tu contraseña</h5>
								</div>
								<div class="modal-body">
									<div class="box-body">
										<div class="form-group row mb-3">
											<label for="forgetEmail" class="ml-3"></label>
											<div class="inner-addon right-addon w-100 mx-3">
												<i class="concepta_icons fas fa-envelope"></i>
												<input type="email" class="form-control" name="forgetEmail" id="forgetEmail"  placeholder="Ingrese su Email" required>
												<small class="form-text text-danger px-2 campo-obligatorio d-none" id="forgetEmail">* campo obligatorio *</small>
											</div>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button class="btn btn-primary rounded btn-sm" type="submit" id="btnForgetPass">Recuperar</button>
									<button class="btn btn-danger rounded btn-sm" data-dismiss="modal">Cerrar</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">

		var propLoginAdmin = {

			inputsValidar: document.querySelectorAll("input.validate"),
			inputUser: document.querySelector("input[name='username']"),
			inputPass: document.querySelector("input[name='password']"),
			buttonSubmit: document.querySelector(".login_user button[type='submit']"),
			inputForgetEmail: document.querySelector("input[name='forgetEmail']"),
			buttonForget: document.querySelector("#modalForgetPass button[type='submit']"),
			fieldEmail: false,
			fieldUser: false,
			fieldPass: false,
			valor: null,
			valorForget: null,
			expresionRegular: ""

		}

		var metLoginAdmin = {

			inicioLogin: function(){

				propLoginAdmin.buttonSubmit.disabled = true;
				propLoginAdmin.buttonSubmit.setAttribute('title', 'Deshabilitado');
				propLoginAdmin.buttonSubmit.style.cursor = "not-allowed";

				propLoginAdmin.buttonForget.disabled = true;
				propLoginAdmin.buttonForget.setAttribute('title', 'Deshabilitado');
				propLoginAdmin.buttonForget.style.cursor = "not-allowed";


				for(var a = 0; a < propLoginAdmin.inputsValidar.length; a++){

					propLoginAdmin.inputsValidar[a].addEventListener("change", metLoginAdmin.cambioInputs);

				}

				propLoginAdmin.inputForgetEmail.addEventListener("focus", metLoginAdmin.enFoco);
				propLoginAdmin.inputForgetEmail.addEventListener("blur", metLoginAdmin.fueraFoco)
				propLoginAdmin.inputForgetEmail.addEventListener("change", metLoginAdmin.cambioInputForget);

			},
			cambioInputs: function(input){

				propLoginAdmin.valor = input.target.value;

				if(propLoginAdmin.valor != ""){

					switch(input.target.id){

						case("username"):

							propLoginAdmin.fieldUser = true;
							break;

						case("password"):
							propLoginAdmin.fieldPass = true;
							break;

					}

				}else{

					if(propLoginAdmin.inputUser.value == ""){

						propLoginAdmin.fieldUser = false;

					}

					if(propLoginAdmin.inputPass.value == ""){

						propLoginAdmin.fieldPass = false;

					}

				}

				if(!propLoginAdmin.fieldUser || !propLoginAdmin.fieldPass){

					propLoginAdmin.buttonSubmit.disabled = true;
					propLoginAdmin.buttonSubmit.setAttribute('title', 'Deshabilitado');
					propLoginAdmin.buttonSubmit.style.cursor = "not-allowed";

				}else{

					propLoginAdmin.buttonSubmit.disabled = false;
					propLoginAdmin.buttonSubmit.removeAttribute('title');
					propLoginAdmin.buttonSubmit.style.cursor = "pointer";

				}

			},
			enFoco: function(enFoquito){

				propLoginAdmin.valorForget = enFoquito.target.value;

				if(propLoginAdmin.valorForget == ""){

					document.querySelector("#modalForgetPass small#"+enFoquito.target.id).className = "form-text text-danger px-2 campo-obligatorio d-inline-block";

				}

				document.querySelector("[for="+enFoquito.target.id+"]").appendChild(document.createElement("SPAN")).setAttribute("class", "error_validacion");

			},
			fueraFoco: function(fueraFoquito){

				document.querySelector("#modalForgetPass small#"+fueraFoquito.target.id).className = "form-text text-danger px-2 campo-obligatorio d-none";

			},
			cambioInputForget: function(inputF){

				propLoginAdmin.valorForget = inputF.target.value;

				if(propLoginAdmin.valorForget != ""){

					propLoginAdmin.expresionRegular = /^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_-]+([.][a-zA-Z0-9_-]+)*[.][a-zA-Z]{2,4}$/;

					if(!propLoginAdmin.expresionRegular.test(propLoginAdmin.valorForget)){

						document.querySelector("[for="+inputF.target.id+"] .error_validacion").innerHTML = '<small class="form-text text-warning">* El email debe seguir un patrón implícito *</small>';

						propLoginAdmin.fieldEmail = false;

					}else{

						propLoginAdmin.fieldEmail = true;

					}

				}else{

					if(propLoginAdmin.inputForgetEmail.value == ""){

						propLoginAdmin.fieldEmail = false;

					}

				}

				if(!propLoginAdmin.fieldEmail){

					propLoginAdmin.buttonForget.disabled = true;
					propLoginAdmin.buttonForget.setAttribute('title', 'Deshabilitado');
					propLoginAdmin.buttonForget.style.cursor = "not-allowed";

				}else{


					propLoginAdmin.buttonForget.disabled = false;
					propLoginAdmin.buttonForget.removeAttribute('title');
					propLoginAdmin.buttonForget.style.cursor = "pointer";

				}

			}

		}

		metLoginAdmin.inicioLogin();

		var seleccion = $('#form_selection');

		if(seleccion.attr('action').length) {
			$('.select-profile').remove();
		}
		$('select').on('change', function () {
		    switch ($(this).val()) {
		        case 'estudiante':

		            seleccion.attr("action","{{route('user.auth.login')}}");
		            break;

		        case 'docente':
		            seleccion.attr("action","{{route('teacher.auth.login')}}");
		            break;

		        case 'empresa':
		            seleccion.attr("action","{{route('company.auth.login')}}");
		            break;
			}
		});
	</script>
</body>



</html>
