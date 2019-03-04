@extends('admin.templates.base_admin')
@section('extra_css')
	<link rel="stylesheet" type="text/css" href="{{asset('css/admin/style_filtros.css')}}">
@stop

@section('titulo')
	CREAR FILTROS
@stop

@section('home_url')
{{route('admin.courses.index')}}
@stop

@section('logout_url')
{{route('admin.auth.logout')}}
@stop

@section('contenido')

<div class="container_filtros">
	<!-- *********************** INICIO POP-UP ELIMINAR TIPO,GRUPOS,SUBGRUPOS Y RELACIONES ************************* -->
<div class="modal_eliminar_relacion"></div>
<!-- *********************** FIN DE POP-UP ELIMINAR TIPO,GRUPOS,SUBGRUPOS Y RELACIONES ************************* -->

	<ul class="nav nav-tabs" id="myTab" role="tablist">
		<li class="nav-item">
	    	<a class="nav-link active" id="productos-tab" data-toggle="tab" href="#productos" role="tab" aria-controls="productos" aria-selected="true">Productos</a>
	    </li>
	    <li class="nav-item">
	    	<a class="nav-link" id="tipos-tab" data-toggle="tab" href="#tipos" role="tab" aria-controls="tipos" aria-selected="false">Tipos</a>
	    </li>
	    <li class="nav-item">
	    	<a class="nav-link" id="grupos-tab" data-toggle="tab" href="#grupos" role="tab" aria-controls="grupos" aria-selected="false">Grupos</a>
	    </li>
	    <li class="nav-item">
	    	<a class="nav-link" id="subgrupos-tab" data-toggle="tab" href="#subgrupos" role="tab" aria-controls="subgrupos" aria-selected="false">Sub-Grupos</a>
	    </li>
	    <li class="nav-item">
	    	<a class="nav-link" id="temas-tab" data-toggle="tab" href="#temas" role="tab" aria-controls="temas" aria-selected="false">Temas</a>
	    </li>
	    <li class="nav-item">
	    	<a class="nav-link" id="complejidad-tab" data-toggle="tab" href="#complejidad" role="tab" aria-controls="complejidad" aria-selected="false">Complejidad</a>
	    </li>
	</ul>
	<div class="tab-content" id="myTabContent">


		<!--///////////////////////////////////// TAB DE PRODUCTOS /////////////////////////////////-->
		<!--///////////////////////////////////////////////////////////////////////////////////////-->
		<div class="tab-pane fade show active" id="productos" role="tabpanel" aria-labelledby="productos-tab">
			<div class="container container_grupos">
				<div class="row">
					<div class="col-sm-12 col-md-12 align-self-center container_grupos_agregados px-1" style="border: none;">
						<h5 class="mb-2 py-1 pl-2 font-weight-bold">Productos agregados</h5>
						<div class="mt-3">
							@foreach($products as $product)
							<!-- INICIO DE GRUPO AGREGADO 1 -->
							<div class="row added_grupo">
								<div class="col-sm-6 col-md-6 align-self-center my-1 title_grupo">
									<span class="fab fa-product-hunt mr-1"></span> {{$product->name}}<br>
								</div>
							</div>
							<!-- FIN DE GRUPO AGREGADO 1 -->
	                        @endforeach
						</div>
					</div>
				</div>		
			</div>
		</div>


		<!--///////////////////////////////////// TAB DE TIPOS /////////////////////////////////-->
		<!--/////////////////////////////////////////////////////////////////////////////////////-->
		<div class="tab-pane fade" id="tipos" role="tabpanel" aria-labelledby="tipos-tab">
			<div class="container container_grupos">
				<div class="row">
					<div class="col-sm-6 col-md-6 container_grupos_agregados px-1">
						<h5 class="mb-2 py-1 pl-2 font-weight-bold">Tipos agregados por producto</h5>
                        <form class="filter-form mt-3 mb-2" method="get" action="{{route('admin.filters.index')}}">
                            <input type="hidden" name="target" value="{{urlencode('#tipos-tab')}}">
                            <select class="product" name="types_product_type_id">
                            	<option value="">Seleccionar producto</option>
                                @foreach($products as $product)
                            	<option value="{{$product->id}}" {{request('types_product_type_id') == $product->id ? 'selected' : ''}}>{{$product->name}}</option>
                                @endforeach
                            </select>
                            <span><button type="submit" class="btn btn-secondary ml-5">Buscar</button></span>
                        </form>
                        <div class="container-fluid" style="max-height: 260px; overflow-y: auto;">
                        	@foreach($types as $type)
							<!-- INICIO DE GRUPO AGREGADO 1 -->
							<div class="row added_grupo my-1">
								<div class="col-sm-6 col-md-10 align-self-center title_grupo">
									<span class="fas fa-list-ul mr-3"></span>{{$type->name}}<br>
								</div>
								<div class="col-sm-6 col-md-2 pt-0 text-center align-self-center delete_grupo">
	                                <a data-id="{{$type->id}}" data-namebd="{{$type->name}}" data-title="el Tipo: {{$type->name}}" data-name="category" href="{{route('admin.filters.delete-category', $type->id)}}" class="text-danger" title="Borrar tipo"><span class="fas fa-trash-alt"></span></a>
								</div>
							</div>
							<!-- FIN DE GRUPO AGREGADO 1 -->
	                        @endforeach
                        </div>
					</div>
					
					<div class="col-sm-6 col-md-6 container_add">
						<div class="row">
							<div class="col-sm-12 col-md-12 new_grupo">
								<h5 class="mb-2 py-1 pl-2 font-weight-bold">Agregar un nuevo tipo por producto</h5>
								<form id="add_attachment_form" enctype="multipart/form-data" method="post" action="{{route('admin.filters.create-category')}}" class="mb-2 mt-3">
                                    {!! csrf_field() !!}
                                    <select name="product_type_id" required="">
                                    	<option value="">Seleccionar producto</option>
				                    	@foreach($products as $product)
                                        <option value="{{$product->id}}">{{$product->name}}</option>
                                        @endforeach
				                    </select>
									<input type="text" name="name" placeholder="Título del grupo" class="w-100">
                                    <button class="btn mt-2 btn-secondary" id="add_attachment_button">Agregar Tipo</button>
								</form>
							</div>
						</div>	
					</div>
				</div>		
			</div>
		</div>

		<!--///////////////////////////////////// TAB DE GRUPOS /////////////////////////////////-->
		<!--/////////////////////////////////////////////////////////////////////////////////////-->
		<div class="tab-pane fade" id="grupos" role="tabpanel" aria-labelledby="grupos-tab">
			<div class="container container_grupos">
				<div class="row">
					<div class="col-sm-6 col-md-6 container_grupos_agregados px-1">
						<h5 class="mb-2 py-1 pl-2 font-weight-bold">Grupos agregados por producto y tipo</h5>
                        <form class="filter-form mt-3 mb-2" method="get" action="{{route('admin.filters.index')}}">
                            <input type="hidden" name="target" value="{{urlencode('#grupos-tab')}}">
                            <select class="product" name="groups_product_type_id">
                            	<option value="">Seleccionar producto</option>
                                @foreach($products as $product)
                            	<option value="{{$product->id}}" {{request('groups_product_type_id') == $product->id ? 'selected' : ''}}>{{$product->name}}</option>
                                @endforeach
                            </select>
                            <select class="type" name="groups_category_id">
                            	<option value="">Seleccionar tipo</option>
                            	@foreach($types as $type)
                                <option value="{{$type->id}}" data-parent="{{$type->product_type_id}}" {{request('groups_category_id') == $type->id ? 'selected' : ''}}>{{$type->name}}</option>
                                @endforeach
                            </select>
                            <span><button type="submit" class="ml-3 btn btn-secondary">Buscar</button></span>
                        </form>
                        <div class="container-fluid" style="max-height: 260px; overflow-y: auto;">
                        	@foreach($groups as $group)
							<!-- INICIO DE GRUPO AGREGADO 1 -->
							<div class="row added_grupo my-1">
								<div class="col-sm-6 col-md-10 align-self-center title_grupo">
									<span class="fas fa-list-ul mr-3"></span> {{$group->name}}<br>
								</div>
								<div class="col-sm-6 col-md-2 pt-0 align-self-center text-center delete_grupo">
	                                <a data-id="{{$group->id}}" data-namebd="{{$group->name}}" data-title="el Grupo: {{$group->name}}" data-name="group" href="{{route('admin.filters.delete-group', $group->id)}}" class="text-danger" title="Borrar grupo"><span class="fas fa-trash-alt"></span></a>
								</div>
							</div>
							<!-- FIN DE GRUPO AGREGADO 1 -->
	                        @endforeach
                        </div>
					</div>
					
					<div class="col-sm-6 col-md-6 container_add">
						<div class="row">
							<div class="col-sm-12 col-md-12 new_grupo">
								<h5 class="mb-2 py-1 pl-2 font-weight-bold">Agregar un nuevo grupo por producto y tipo</h5>
								<form class="mb-2 mt-3" id="add_attachment_form" enctype="multipart/form-data" method="post" action="{{route('admin.filters.create-group')}}">
                                    {!! csrf_field() !!}
                                    <select class="product" required>
                                    	<option value="">Seleccionar producto</option>
                                        @foreach($products as $product)
				                    	<option value="{{$product->id}}">{{$product->name}}</option>
                                        @endforeach
				                    </select>
				                    <select class="type" name="category_id" required>
                                    	<option value="">Seleccionar tipo</option>
                                        @foreach($types as $type)
				                    	<option value="{{$type->id}}" data-parent="{{$type->product_type_id}}">{{$type->name}}</option>
                                        @endforeach
				                    </select>
				                    <br>
									<input type="text" name="name" placeholder="Título de grupo" class="w-100">
                                    <button class="btn mt-2 btn-secondary" id="add_attachment_button">Agregar grupo</button>
								</form>
							</div>
						</div>	
					</div>
				</div>		
			</div>
		</div>

		<!--////////////////////////////////// TAB DE SUB-GRUPOS //////////////////////////////////-->
		<!--///////////////////////////////////////////////////////////////////////////////////////-->
		<div class="tab-pane fade" id="subgrupos" role="tabpanel" aria-labelledby="subgrupos-tab">
			<div class="container container_grupos">
				<div class="row">
					<div class="col-sm-6 col-md-6 container_grupos_agregados px-1">
						<h5 class="mb-2 py-1 pl-2 font-weight-bold">Sub-grupos agregados por producto, tipo y grupo</h5>
                        <form class="filter-form mt-3 mb-2" method="get" action="{{route('admin.filters.index')}}">
                            <input type="hidden" name="target" value="{{urlencode('#subgrupos-tab')}}">
                            <select class="product" name="sub_groups_product_type_id">
                            	<option value="">Seleccionar producto</option>
                            	@foreach($products as $product)
                                <option value="{{$product->id}}" {{request('sub_groups_product_type_id') == $product->id ? 'selected' : ''}}>{{$product->name}}</option>
                                @endforeach
                            </select>
                            <select class="type" name="sub_groups_category_id">
                            	<option value="">Seleccionar tipo</option>
                                @foreach($types as $type)
                            	<option value="{{$type->id}}" data-parent="{{$type->product_type_id}}" {{request('sub_groups_category_id') == $type->id ? 'selected' : ''}}>{{$type->name}}</option>
                                @endforeach
                            </select>
                            <select class="group" name="sub_groups_group_id">
                            	<option value="">Seleccionar grupo</option>
                                @foreach($groups as $group)
                            	<option value="{{$group->id}}" data-parent="{{$group->category_id}}" {{request('sub_groups_group_id') == $group->id ? 'selected' : ''}}>{{$group->name}}</option>
                                @endforeach
                            </select>
                            <span><button type="submit" class="btn btn-secondary">Buscar</button></span>
                        </form>
                        <div class="container-fluid" style="max-height: 228px; overflow-y: auto;">
                        	@foreach($sub_groups as $sub_group)
							<!-- INICIO DE GRUPO AGREGADO 1 -->
							<div class="row added_grupo my-1">
								<div class="col-sm-6 col-md-10 align-self-center title_grupo">
									<span class="fas fa-list-ul mr-3"></span>{{$sub_group->name}}<br>
								</div>
								<div class="col-sm-6 col-md-2 align-self-center pt-0 text-center delete_grupo">
	                                <a data-id="{{$sub_group->id}}" data-namebd="{{$sub_group->name}}" data-title="el Sub-Grupo: {{$sub_group->name}}" data-name="sub-group" href="{{route('admin.filters.delete-sub-group', $sub_group->id)}}" class="text-danger" title="Borrar sub-grupo"><span class="fas fa-trash-alt"></span></a>
								</div>
							</div>
							<!-- FIN DE GRUPO AGREGADO 1 -->
	                        @endforeach
                        </div>
					</div>
					
					<div class="col-sm-6 col-md-6 container_add">
						<div class="row">
							<div class="col-sm-12 col-md-12 new_grupo">
								<h5 class="mb-2 py-1 pl-2 font-weight-bold">Agregar un nuevo sub-grupo por producto, tipo y grupo</h5>
								<form id="add_attachment_form" enctype="multipart/form-data" method="post" action="{{route('admin.filters.create-sub-group')}}" class="mb-2 mt-3">
                                    {!! csrf_field() !!}
                                    <select class="product" required>
                                    	<option value="">Seleccionar producto</option>
				                    	@foreach($products as $product)
                                        <option value="{{$product->id}}">{{$product->name}}</option>
                                        @endforeach
				                    </select>
				                    <select class="type" required>
                                    	<option value="">Seleccionar tipo</option>
                                        @foreach($types as $type)
				                    	<option value="{{$type->id}}" data-parent="{{$type->product_type_id}}">{{$type->name}}</option>
                                        @endforeach
				                    </select>
				                    <select class="group" name="group_id" required>
                                    	<option value="">Seleccionar grupo</option>
                                        @foreach($groups as $group)
				                    	<option value="{{$group->id}}" data-parent="{{$group->category_id}}">{{$group->name}}</option>
                                        @endforeach
				                    </select>
				                    <br>
									<input type="text" name="name" placeholder="Título del sub-grupo" class="w-100">
                                    <button class="btn btn-secondary mt-2" id="add_attachment_button">Agregar sub-grupo</button>
								</form>
							</div>
						</div>	
					</div>
				</div>		
			</div>

		</div>


		<!--//////////////////////////////////// TAB DE TEMAS /////////////////////////////////////-->
		<!--///////////////////////////////////////////////////////////////////////////////////////-->
		<div class="tab-pane fade" id="temas" role="tabpanel" aria-labelledby="temas-tab">
			<div class="container container_grupos">
				<div class="row">
					<div class="col-sm-6 col-md-6 container_grupos_agregados px-1">
						<h5 class="mb-2 py-1 pl-2 font-weight-bold">Temas agregados por producto, tipo, grupo y sub-grupo</h5>
                        <form class="filter-form mt-3 mb-2" method="get" action="{{route('admin.filters.index')}}">
                            <input type="hidden" name="target" value="{{urlencode('#temas-tab')}}">
                            <select class="product" name="themes_product_type_id">
                            	<option value="">Seleccionar producto</option>
                                @foreach($products as $product)
                            	<option value="{{$product->id}}" {{request('themes_product_type_id') == $product->id ? 'selected' : ''}}>{{$product->name}}</option>
                                @endforeach
                            </select>
                            <select class="type" name="themes_category_id">
                            	<option value="">Seleccionar tipo</option>
                                @foreach($types as $type)
                            	<option value="{{$type->id}}" data-parent="{{$type->product_type_id}}" {{request('themes_category_id') == $type->id ? 'selected' : ''}}>{{$type->name}}</option>
                                @endforeach
                            </select>
                            <select class="group" name="themes_group_id">
                            	<option value="">Seleccionar grupo</option>
                                @foreach($groups as $group)
                            	<option value="{{$group->id}}" data-parent="{{$group->category_id}}" {{request('themes_group_id') == $group->id ? 'selected' : ''}}>{{$group->name}}</option>
                                @endforeach
                            </select>
                            <select class="sub_group" name="themes_sub_group_id">
                            	<option value="">Seleccionar sub-grupo</option>
                                @foreach($sub_groups as $sub_group)
                            	<option value="{{$sub_group->id}}" data-parent="{{$sub_group->group_id}}" {{request('themes_sub_group_id') == $sub_group->id ? 'selected' : ''}}>{{$sub_group->name}}</option>
                                @endforeach
                            </select>
                            <span><button type="submit" class="ml-3 btn btn-secondary">Buscar</button></span>
                        </form>
                        <div class="container-fluid" style="overflow-y: auto; max-height: 228px;">
                        	@foreach($themes as $theme)
							<!-- INICIO DE GRUPO AGREGADO 1 -->
							<div class="row added_grupo my-1">
								<div class="col-sm-6 col-md-10 align-self-center title_grupo">
									<span class="fas fa-list-ul mr-3"></span>{{$theme->name}}<br>
								</div>
								<div class="col-sm-6 col-md-2 align-self-center text-center pt-0 delete_grupo">
	                                <a data-id="{{$theme->id}}" data-namebd="{{$theme->name}}" data-title="el Tema: {{$theme->name}}" data-name="theme" href="{{route('admin.filters.delete-theme', $theme->id)}}" class="text-danger" title="Borrar tema"><span class="fas fa-trash-alt"></span></a>
								</div>
							</div>
							<!-- FIN DE GRUPO AGREGADO 1 -->
	                        @endforeach
                        </div>
					</div>
					
					<div class="col-sm-6 col-md-6 container_add">
						<div class="row">
							<div class="col-sm-12 col-md-12 new_grupo">
								<h5 class="mb-2 py-1 pl-2 font-weight-bold">Agregar un nuevo tema por producto, tipo, grupo y sub-grupo</h5>
								<form id="add_attachment_form" enctype="multipart/form-data" method="post" action="{{route('admin.filters.create-theme')}}" class="mb-2 mt-3">
                                    {!! csrf_field() !!}
                                    <select class="product" required>
                                    	<option value="">Seleccionar producto</option>
                                        @foreach($products as $product)
				                    	<option value="{{$product->id}}">{{$product->name}}</option>
                                        @endforeach
				                    </select>
				                    <select class="type" required>
                                    	<option value="">Seleccionar tipo</option>
                                        @foreach($types as $type)
				                    	<option value="{{$type->id}}" data-parent="{{$type->product_type_id}}">{{$type->name}}</option>
                                        @endforeach
				                    </select>
				                    <select class="group" required>
                                    	<option value="">Seleccionar grupo</option>
                                        @foreach($groups as $group)
				                    	<option value="{{$group->id}}" data-parent="{{$group->category_id}}">{{$group->name}}</option>
                                        @endforeach
				                    </select>
				                    <select class="sub_group" name="sub_group_id" required>
			                        	<option value="">Seleccionar sub-grupo</option>
                                        @foreach($sub_groups as $sub_group)
                                        <option value="{{$sub_group->id}}" data-parent="{{$sub_group->group_id}}">{{$sub_group->name}}</option>
                                        @endforeach
			                        </select>
				                    <br>
									<input type="text" name="name" placeholder="Título del tema" class="w-100">
                                    <button class="btn btn-secondary mt-2" id="add_attachment_button">Agregar tema</button>
								</form>
							</div>
						</div>	
					</div>
				</div>		
			</div>
		</div>


		<!--//////////////////////////////// TAB DE COMPLEJIDAD /////////////////////////////////-->
		<!--/////////////////////////////////////////////////////////////////////////////////////-->
		<div class="tab-pane fade" id="complejidad" role="tabpanel" aria-labelledby="tipos-tab">
			<div class="container container_grupos">
				<div class="row">
					<div class="col-sm-6 col-md-6 container_grupos_agregados px-1">
						<h5 class="mb-2 py-1 pl-2 font-weight-bold">Complejidad de preguntas agregadas</h5>
                        <div class="container-fluid" style="overflow-y: auto; max-height: 314px;">
                        	@foreach($complexities as $complexity)
							<!-- INICIO DE COMPLEJIDAD AGREGADO 1 -->
							<div class="row added_grupo my-1">
								<div class="col-sm-6 col-md-10 align-self-center title_grupo">
									<span class="fas fa-list-ul mr-3"></span> {{$complexity->name}}<br>
								</div>
								<div class="col-sm-6 col-md-2 pt-0 align-self-center text-center delete_grupo">
	                                <a href="{{route('admin.filters.delete-complexity', $complexity->id)}}" class="text-danger" title="Borrar complejidad"><span class="fas fa-trash-alt"></span></a>
								</div>
							</div>
							<!-- FIN DE COMPLEJIDAD AGREGADO 1 -->
	                        @endforeach
                        </div>
					</div>
					
					<div class="col-sm-6 col-md-6 container_add">
						<div class="row">
							<div class="col-sm-12 col-md-12 new_grupo">
								<h5 class="mb-2 py-1 pl-2 font-weight-bold">Agregar un nueva complejidad</h5>
								<form id="add_attachment_form" enctype="multipart/form-data" method="post" action="{{route('admin.filters.create-complexity')}}" class="mb-2 mt-3">
                                    {!! csrf_field() !!}
									<input type="text" name="name" placeholder="Título de la complejidad" class="w-100">
                                    <button class="btn btn-secondary mt-2" id="add_attachment_button">Agregar Tipo</button>
								</form>
							</div>
						</div>	
					</div>
				</div>		
			</div>
		</div>








	</div>



</div>



@stop


@section('extra_scripts')
<script>
	console.log('{{$target}}')
$('{{$target}}').click();
function reset_filters() {
    $('.type').children().hide();
    $('.type').children().first().show();
    $('.group').children().hide();
    $('.group').children().first().show();
    $('.sub_group').children().hide();
    $('.sub_group').children().first().show();
}

$('.product').change(function(){
    $(this).siblings('.type').children().hide();
    $(this).siblings('.type').children().first().show();
    $(this).siblings('.type').children().first().prop('selected', true).change();
    $(this).siblings('.type').children('[data-parent="'+ $(this).val() +'"]').show();
});

$('.type').change(function(){
    $(this).siblings('.group').children().hide();
    $(this).siblings('.group').children().first().show();
    $(this).siblings('.group').children().first().prop('selected', true).change();
    $(this).siblings('.group').children('[data-parent="'+ $(this).val() +'"]').show();
});

$('.group').change(function(){
    $(this).siblings('.sub_group').children().hide();
    $(this).siblings('.sub_group').children().first().show();
    $(this).siblings('.sub_group').children().first().prop('selected', true).change();
    $(this).siblings('.sub_group').children('[data-parent="'+ $(this).val() +'"]').show();
});

$('.sub_group').change(function(){
    $(this).siblings('.theme').children().hide();
    $(this).siblings('.theme').children().first().show();
    $(this).siblings('.theme').children().first().prop('selected', true).change();
    $(this).siblings('.theme').children('[data-parent="'+ $(this).val() +'"]').show();
});
var xhr = "";
$('.delete_grupo').on('click',function(e){
	e.preventDefault();
	let this_el = $(this).find('a'),dataid=this_el.data('id'),dataname=this_el.data('name'),datatitle=this_el.data('title'),datanamebd=this_el.data('namebd'),url='',message='';
	/*switch(dataname)
	{
		case 'category':
			url = '{{route("admin.filters.find-category","@")}}'.replace("@",dataid);
		break;
		case 'group':
			url = '{{route("admin.filters.find-group","@")}}'.replace("@",dataid);
		break;	
		case 'sub-group':
			url = '{{route("admin.filters.find-sub-group","@")}}'.replace("@",dataid);
		break;
		case 'theme':
			url = '{{route("admin.filters.find-theme","@")}}'.replace("@",dataid);
		break;
		default:
		break;
	}*/
	switch(dataname)
	{
		case 'category':
			message = 'Grupos, sub-grupos, temas y preguntas';
		break;
		case 'group':
			message = 'Sub-Grupos, temas y preguntas';
		break;	
		case 'sub-group':
			message = 'temas y preguntas';
		break;
		case 'theme':
			message = 'preguntas';
		break;
		default:
			datatitle = 'complejidad';
			message = 'elementos';
		break;
	}
	swal({
	  title: "¿Estás seguro que deseas eliminar "+datatitle+"?",
	  text: "Esta acción puede borrar: "+message+" relacionados.",
	  icon: "warning",
	  buttons: true,
	  dangerMode: true,
	})
	.then((willDelete) => {
	  if (willDelete) {
	  	location.href = this_el.attr('href');
	  	/*if(xhr !="") {
			xhr.abort();
		}
		xhr = $.ajax({
	        type: "GET",
	        url: url,
	        success: function (data) {
	        	console.log(data)
	            create_modal(this_el);
	        	create_tree(data,datanamebd);
				$('#popup_eliminar_relacion').modal('toggle');
	        },error:function(err){

	        }
	    });*/
	   
	  }
	});
		
	
	
});
function create_tree(data,datanamebd){
	data = data['success'];
	let html = "";
	console.log(data.length)
	for (var i = 0; i < data; i++) {
		console.log(data[i])
	  }
	let ul = `<ul>
  <li class="root_tree">
    <i class="fa fa-folder" aria-hidden="true"></i> `+datanamebd+`
  </li>
  <li>
    Lorem ipsum
        
    <ul>
  <li>Adipiscing elit.</li>
  <li>Tincidunt mauris eu risus.</li>
  <li>Vestibulum </li>
</ul>  
  </li>
  <li>Aliquam</li>
  <li>
    Dapibus
<ul>
  <li>Aliquam tincidunt mauris eu risus.</li>
  <li>Vestibulum auctor dapibus neque.</li>
</ul>  
  </li>
</ul>`;
$('#popup_eliminar_relacion .modal-body').html(ul);
}

function create_modal(this_el) {
	let dataid=this_el.data('id'),dataname=this_el.data('name'),datatitle=this_el.data('title');
	let html = `<div class="modal fade" id="popup_eliminar_relacion" tabindex="-1" role="dialog" aria-labelledby="popup_eliminarLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Se ha encontrado relación en `+datatitle+` </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
  	<div class="modal-body">
      	<div class="">
	      	<div class="row">
                
      		</div>
      	</div>
    </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="save_teacher">Guardar</button>
      </div>
    </div>
  </div>`;
  $('.modal_eliminar_relacion').html(html);
}
function confirm_delete(){
	swal({
	  title: "Estás seguro que deseas eliminar "+datatitle+" ?",
	  text: "A continuación se muestra lo que las relaciones las cuales se van a borrar.!",
	  icon: "warning",
	  buttons: true,
	  dangerMode: true,
	})
	.then((willDelete) => {
	  if (willDelete) {
	  	$.ajax({
            type: "POST",
            url: this_el.attr('href'),
            success: function (data) {
                swal("Poof! Your imaginary file has been deleted!", {
			      icon: "success",
			    });
            },error:function(err){

            }
        });
	   
	  } else {
	    swal("Your imaginary file is safe!");
	  }
	});
}

</script>

@stop