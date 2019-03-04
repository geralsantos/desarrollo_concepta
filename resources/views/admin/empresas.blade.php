@extends('admin.templates.base_admin')
@section('extra_css')
    <link rel="stylesheet" type="text/css" href="{{asset('css/admin/style_empresas.css')}}">
@stop

@section('titulo')
    CUENTAS
@stop

@section('home_url')
{{route('admin.courses.index')}}
@stop

@section('logout_url')
{{route('admin.auth.logout')}}
@stop

@section('contenido')
<!-- ********  CONTAINER DE TODAS LAS CUENTAS  **********-->
<div class="container-fluid container_empresas mx-auto mt-4 mx-2 py-3" id="empresas" style="max-width: 1250px; max-height: 430px; overflow-y: auto;">

    <div class="row no-gutters justify-content-center mt-0">
        <div class="col-md-12 p-0">
            <table class="table table-bordered text-center mb-1">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Razon Social</th>
                        <th scope="col">RUC</th>
                        <th scope="col">Logo</th>
                        <th scope="col">Cursos</th>
                        <th scope="col">Simuladores</th>
                        <th scope="col">Evaluaciones</th>
                        <th scope="col">Opciones</th>
                    </tr>
                </thead>
              <tbody>

                    @foreach($businesses  as $business)
                    <tr>
                        <form method="post" action="{{route('admin.businesses.update-products', $business->id)}}">
                        {!! csrf_field() !!}
                            <!-- ID -->
                            <td scope="row">{{$business->id}}</td>

                            <!-- Razon social -->
                            <td>
                                {{$business->social_reason}}
                            </td>
                            <!-- RUC -->
                            <td>
                               {{$business->ruc}}
                            </td>
                            <!-- Logo -->
                            <td>
                                <img src="{{asset($business->logo)}}" class="photo_cuenta p-1" alt="{{$business->logo ? '' : 'image not available'}}" width="115px" height="115px" onerror="this.onerror=null;this.src='/images/default/enterprise.svg';">
                            </td>
                            <!-- Cursos -->
                            <td class="input_product">
                                @foreach($business->courses as $product)
                                <div class="form-group">
                                    <label>{{$product->instance->name}}</label><br>
                                    <span>N° de alumnos: </span><input type="number" class="text-center rounded" name="products[{{$product->id}}][max_students]" value="{{$product->pivot->max_students}}">
                                </div>
                                @endforeach
                            </td>

                            <!-- Simuladores -->
                            <td class="input_product">
                                @foreach($business->simulators as $product)
                                <div class="form-group">
                                    <label>{{$product->instance->name}}</label><br>
                                    <span>N° de alumnos: </span><input type="number" name="products[{{$product->id}}][max_students]" class="text-center rounded" value="{{$product->pivot->max_students}}">
                                </div>
                                @endforeach
                            </td>

                            <!-- Evaluaciones -->
                            <td class="input_product">
                                @foreach($business->exams as $product)
                                <div class="form-group">
                                    <label>{{$product->instance->title}}</label><br>
                                    <span>N° de alumnos: </span><input type="number" class="text-center rounded" name="products[{{$product->id}}][max_students]" value="{{$product->pivot->max_students}}">
                                </div>
                                @endforeach
                            </td>
                            <!-- Agregar -->
                            <td>
                                <div class="btn-group">
                                    <a href="#" class="btn btn-primary d-inline-block float-left mr-1 p-2 rounded" data-toggle="modal" data-target="#modal_{{$business->id}}_add" title="Agregar nuevo producto"><i class="fas fa-cart-plus"></i></a>
                                    <button class="btn btn-success d-inline-block float-right ml-1 rounded p-2" type="submit" title="Guardar cambios"><i class="fas fa-save"></i></button>
                                </div>
                                
                            </td>
                        </form>
                    </tr>

                    <!-- Modal cuando se agrega un producto -->
                    <div id="modal_{{$business->id}}_add" class="modal fade" role="dialog">
                      <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">¿Qué producto desea agregar?</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                          </div>
                          <form method="post" action="{{route('admin.businesses.add-products', $business->id)}}">
                              {!! csrf_field() !!}
                              <div class="modal-body">
                                    <select name="product_type_id" class="select-product mb-3">
                                        <option value="">Seleccione un producto</option>
                                        @foreach($product_types as $product_type)
                                            <option value="{{$product_type->id}}">{{$product_type->name}}</option>
                                        @endforeach
                                    </select>
                                    <div class="check-courses">
                                        @foreach($courses as $course)
                                            <input type="checkbox" name="courses[]" value="{{$course->id}}"> {{$course->name}}
                                            <br/>
                                        @endforeach
                                    </div>
                                    <div class="check-exams">
                                        @foreach($exams as $exam)
                                            <input type="checkbox" name="exams[]" value="{{$exam->id}}"> {{$exam->title}} 
                                            <br/>
                                        @endforeach
                                    </div>
                                    <div class="check-simulators">
                                        @foreach($simulators as $simulator)
                                            <input type="checkbox" name="simulators[]" value="{{$simulator->id}}"> {{$simulator->name}}
                                            <br/>
                                        @endforeach
                                    </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Guardar</button>
                              </div>
                          </form>
                        </div>

                      </div>
                    </div>
                    @endforeach

              </tbody>
            </table>
            
        </div>
        
    </div>
</div>

@stop

@section('extra_scripts')
<script type="text/javascript">
    $('.check-courses').hide();
    $('.check-simulators').hide();
    $('.check-exams').hide();

    $('.select-product').change(function(){
        $(this).siblings('div').hide();

        switch($(this).val()){
            case "{{PRODUCT_COURSE}}":{
                $(this).siblings('.check-courses').show();
                break;
            }
            case "{{PRODUCT_SIMULATOR}}":{
                $(this).siblings('.check-simulators').show();
                break;
            }
            case "{{PRODUCT_EXAM}}":{
                $(this).siblings('.check-exams').show();
                break;
            }
        }
    });
</script>
@stop
