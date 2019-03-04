@extends('admin.templates.base_admin')
@section('extra_css')
	<link rel="stylesheet" type="text/css" href="{{asset('css/admin/style_cursos.css')}}">
@stop

@section('titulo')
	EMPRESAS
@stop

@section('home_url')
{{route('admin.courses.index')}}
@stop

@section('logout_url')
{{route('admin.auth.logout')}}
@stop

@section('contenido')

<div class="container container_empresas">

	<div class="row">
		<div class="col-md-12">
			<table class="table">
				<thead>
			    	<tr>
			      		<th scope="col">#</th>
					    <th scope="col">First</th>
				      	<th scope="col">Last</th>
				      	<th scope="col">Handle</th>
			    	</tr>
			  	</thead>
			  <tbody>
			    	<tr>
			      		<th scope="row">1</th>
			      		<td>Mark</td>
			      		<td>Otto</td>
			      		<td>@mdo</td>
			    	</tr>
			    	<tr>
			      		<th scope="row">2</th>
					    <td>Jacob</td>
					    <td>Thornton</td>
					    <td>@fat</td>
			   		</tr>
			    	<tr>
					    <th scope="row">3</th>
					    <td>Larry</td>
					    <td>the Bird</td>
					    <td>@twitter</td>
			   		</tr>
			  </tbody>
			</table>
			
		</div>
		
	</div>





</div>

	

@stop

@section('extra_scripts')
	

@stop
