@extends('admin/layout')

@section('contenido')
<div class="row">
	<div class="col-lg-12">
		<h3>Gestor de Brazaletes</h3>
	</div>
</div>
@endsection('contenido')

@section('detalle')
@if (Session::has('error'))
        <div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>{{ Session::get('error') }}</div>
@elseif (Session::has('success'))
        <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>{{ Session::get('success') }}</div>
@endif()
<button type="button" class="btn btn-link" data-toggle="modal" data-target="#agregarBrazalete">
  Agregar nuevo brazalete
</button>
<br>
@endsection('detalle')

<div class="modal fade" id="agregarBrazalete" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Agregar nuevo brazalete</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('savebrazalete') }}" method="POST" name="registrobrazalete">
      	{{csrf_field()}}
      <div class="modal-body">
        	<div class="input-group mb-3">
				  <div class="input-group-prepend">
				    <span class="input-group-text" id="">Nro. brazalete</span>
				  </div> 
				  <input type="text" name="idbrazalete" class="form-control" id="idbrazalete" placeholder="1425639" maxlength="10" minlength="1" required aria-label="idbrazalete" aria-describedby="idbrazalete">
			</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Registrar</button>
      </div>
      </form>
    </div>
  </div>
</div>

@php
$arrayObject = new ArrayObject($brazaletes);
$copiaBrazaletes = $arrayObject->getArrayCopy();
@endphp

@section('info')
<div class="card mb-4">
	<div class="card-header">
		<i class="fas fa-table mr-1"></i>
		Total de Registros
	</div>
	<div class="card-body">
		<form class="">
			<div class="input-group">
				<input class="form-control" type="text" placeholder="Buscar brazalete..." aria-label="Search"
					aria-describedby="basic-addon2" />
				<div class="input-group-append">
					<button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
				</div>
			</div>
			<br>
			<button type="button" class="btn btn-link" data-toggle="modal" data-target="#agregarBrazalete">
				Nuevo brazalete
			  </button>
			<div class="table-responsive">
				<table class="table table-hover">
			<thead>
			    <tr>
			      <th scope="col">ID</th>
			      <th scope="col">Estado</th>
			      <th scope="col">Acciones</th>
			    </tr>
			  </thead>
			  <tbody> 
			  	@foreach ($brazaletes as $brazaletes)
			  	<tr>
			      <td>{{ $brazaletes->idbrazalete }}</td>
			      <td>{{ $brazaletes->desc_estado }}</td>
			      <td><button type="button" data-toggle="modal" data-target="#eliminarBrazalete{{ $loop->iteration }}" class="btn btn-danger">Eliminar</button></td>
			  	</tr>
			  	@endforeach
			  </tbody>
			</table>

	</div>
</div>
</div>
</div>
@foreach ($copiaBrazaletes as $br)
	{{-- eliminar --}}

	<div class="modal fade" id="eliminarBrazalete{{ $loop->iteration }}" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
		  <div class="modal-content">
			<div class="modal-header">
			  <h5 class="modal-title" id="staticBackdropLabel">Eliminar brazalete</h5>
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			  </button>
			</div>
			<div class="modal-body">
				  ¿Estás seguro de querer eliminar este dispositivo?
			</div>
			<div class="modal-footer">
			  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
			  <a href="{{ action('AdminController@delete_brazalete', ['id' => $br->idbrazalete ]) }}" class="btn btn-danger">Eliminar</a>
			</div>
		  </div>
		</div>
	  </div>
@endforeach

@endsection('info')
@section('js')
<script>
	registrobrazalete.idbrazalete.addEventListener("keypress", soloNumeros, false);
	function soloNumeros(e){
  var key = window.event ? e.which : e.keyCode;
  if (key < 48 || key > 57) {
    e.preventDefault();
  }
}
</script>
@endsection('js')