<!-- Vínculo al archivo css -->
<link rel="stylesheet" type="text/css" href="{{asset('css/main/style_base_main.css')}}">

<!DOCTYPE html>

<!--/////////////////////////////////// PRIMERA BARRA //////////////////////////////////////-->

<div class ="nav_main">
	<nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-between">
	  <a class="navbar-brand" href="@yield('home_url')">
	  	<img src="{{asset('images/logo/logo.png')}}" class="logo_main">
	  </a>
		@if(auth()->guard('web')->check())
		@if($company = auth()->guard('web')->user()->company)
	  	<img src="{{asset($company->business->logo)}}" class="logo ml-3">
	  	@endif
	  	@endif
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent_1" aria-controls="navbarSupportedContent_1" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>

	  <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent_1">
	  	<div>
	  	</div>
	  	<div class="dropdown_usuario col-12">
	  		<div class="row no-gutters float-right">
	  			<div class="container_icon">
		  			<img src="{{asset(auth()->user()->photo)}}" class="icono_usuario p-1" width="50px" height="50px" onerror="this.onerror=null;this.src='/images/login/login_icon.png';">
		  		</div>
		  		<div class="container_dropdown pl-2">
				    <ul class="navbar-nav mr-auto">
				      <li class="nav-item dropdown">
				        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				          <span class="text-capitalize font-weight-bold" style="font-size: 18px;">{{ auth()->user()->name.' '.auth()->user()->last_name }}</span>
				        </a>
				        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
				        	@if(auth()->guard('web')->check())
				        	<a class="dropdown-item" href="{{route('user.config.user',\Illuminate\Support\Facades\Auth::user()->id)}}">Configuración</a>
				        	<div class="dropdown-divider"></div>
				        	@elseif(auth()->guard('admin')->check())
				        	<a class="dropdown-item" href="{{route('admin.config.user',\Illuminate\Support\Facades\Auth::user()->id)}}">Configuración</a>
				        	<div class="dropdown-divider"></div>
				        	@elseif(auth()->guard('teacher')->check())
				        	<a class="dropdown-item" href="{{route('teacher.config.user',\Illuminate\Support\Facades\Auth::user()->id)}}">Configuración</a>
				        	<div class="dropdown-divider"></div>
				        	@else
				        	<a class="dropdown-item" href="{{route('company.config.user',\Illuminate\Support\Facades\Auth::user()->id)}}">Configuración</a>
				        	<div class="dropdown-divider"></div>
				        	@endif
				        	
				          <a class="dropdown-item" href="@yield('logout_url')">Cerrar Sesión</a>
				        </div>
				      </li>
				    </ul>
			    </div>
	  		</div>
	    </div>
	  </div>
	</nav>
</div>



<title>@yield('titulo')</title> <!-- Se va poder configurar el titulo -->

<!-- Vínculo al archivo css -->
<link rel="stylesheet" type="text/css" href="{{asset('css/alumnos/style_inicio_alumnos.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/jquery/jquery-ui.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('fonts/font-awesome/css/fontawesome-all.min.css')}}">
@yield('extra_css')


<body class="body" style="overflow-y: scroll; max-height: auto;">

	@yield('contenido_web')
	<footer class="footer py-2">
		<p class="mb-0">Copyright &copy; 2018 | Todos los derechos reservados por <b class="text-uppercase">concepta consulting</b></p>
	</footer>
</body>

	

<!--/////////////////////////////////// FOOTER //////////////////////////////////////-->


<script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('js/jquery-ui.min.js')}}"></script>
<script src="{{asset('js/bootstrap.js')}}"></script>
<script src="{{asset('js/sweetalert.min.js')}}"></script>
<script type="text/javascript">
	$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>

@yield('extra_scripts')


