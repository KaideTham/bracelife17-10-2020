@extends('admin/layout')

@section('contenido')
<br>
<div class="row">
	<div class="col-lg-12">
		<h3>Gestor de Órdenes de Alejamiento</h3>
	</div>
</div>
<br>
@endsection('contenido')

@section('detalle')
@if (Session::has('error'))
        <div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>{{ Session::get('error') }}</div>
@elseif (Session::has('success'))
        <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>{{ Session::get('success') }}</div>
@endif()
@endsection('detalle')

<div class="modal fade" id="agregarOrden" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Agregar nueva orden</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('saveorden') }}" method="POST" name="registroorden">
      	{{csrf_field()}}
      <div class="modal-body">
			<div class="input-group mb-3">
				  <div class="input-group-prepend">
				    <span class="input-group-text" id="">Nro Orden</span>
				  </div>
				  <input type="text" class="form-control" required minlength="5" maxlength="11" name="idorden">
				</div>
				<div class="input-group mb-3">
					<div class="input-group-prepend">
					  <span class="input-group-text" id="">Distancia permitida (metros)</span>
					</div>
					<input type="number" class="form-control" required min="1" max="1000" name="distancia">
				  </div>
				  <div class="input-group mb-3">
					<div class="input-group-prepend">
					  <span class="input-group-text" id="">Fecha de Inicio</span>
					</div>
					<input type="date" class="form-control" required name="fechainicio">
				  </div>
				  <div class="input-group mb-3">
					<div class="input-group-prepend">
					  <span class="input-group-text" id="">Fecha de Término</span>
					</div>
					<input type="date" class="form-control" required name="fechatermino">
				  </div>
			<div class="input-group mb-3">
				  <div class="input-group-prepend">
				    <span class="input-group-text" id="">Usuario/Víctima</span>
				  </div>
				  <select class="form-control" required="" name="rutvictima">
				  	<option value="" selected>Seleccione...</option>
				  	@foreach ($victimas as $victima)
				  	<option value="{{ $victima->rut }}">{{ $victima->rut }} - {{ $victima->nombre }} {{ $victima->apellido_paterno }} {{ $victima->apellido_materno }}</option>
				  	@endforeach
				</select>
				</div>
				<div class="input-group mb-3">
					<div class="input-group-prepend">
					  <span class="input-group-text" id="">Brazalete Usuario/Víctima</span>
					</div>
					<select class="form-control" required="" name="brazaletevictima">
						<option value="" selected>Seleccione...</option>
						@foreach ($brazaletesdisp1 as $brazalete)
					<option value="{{ $brazalete->idbrazalete }}">{{ $brazalete->idbrazalete}}</option>
						@endforeach
				  </select>
				  </div>
				<div class="input-group mb-3">
					<div class="input-group-prepend">
					  <span class="input-group-text" id="">Usuario/Victimario</span>
					</div>
					<select class="form-control" required="" name="rutvictimario">
						<option value="" selected>Seleccione...</option>
						@foreach ($victimarios as $victimario)
						<option value="{{ $victimario->rut }}">{{ $victimario->rut }} - {{ $victimario->nombre }} {{ $victimario->apellido_paterno }} {{ $victimario->apellido_materno }}</option>
						@endforeach
				  </select>
				  </div>
				  <div class="input-group mb-3">
					<div class="input-group-prepend">
					  <span class="input-group-text" id="">Brazalete Usuario/Victimario</span>
					</div>
					<select class="form-control" required="" name="brazaletevictimario">
						<option value="" selected>Seleccione...</option>
						@foreach ($brazaletesdisp2 as $brazalete)
					<option value="{{ $brazalete->idbrazalete }}">{{ $brazalete->idbrazalete}}</option>
						@endforeach
				  </select>
				  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Enlazar</button>
      </div>
      </form>
    </div>
  </div>
</div>

@section('info')
		<div class="card mb-4">
			<div class="card-header">
				<i class="fas fa-table mr-1"></i>
				Total de Registros
			</div>
			<div class="card-body">
				<form class="">
					<div class="input-group">
						<input class="form-control" type="text" placeholder="Buscar Orden..." aria-label="Search"
							aria-describedby="basic-addon2" />
						<div class="input-group-append">
							<button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
						</div>
					</div>
				</form>
				<button type="button" class="btn btn-link" data-toggle="modal" data-target="#agregarOrden">
					Agregar nueva orden 
				  </button>
				  <br>
		<table class="table table-hover">
			<thead>
			    <tr>
			      <th scope="col">Nro Orden</th>
				  <th scope="col">Rut Víctima</th>
				  <th scole="col">Rut Victimario</th>
			      <th scope="col" colspan="3" width="40%">Acciones</th>
			    </tr>
			  </thead>
			  <tbody> 
			  	@foreach ($ordenes as $orden)
			  	<tr>
					  <td>{{ $orden->idorden}}</td>
					  <td>{{ $orden->rutvictima}}</td>
					  <td>{{ $orden->rutvictimario}}</td>
			      <td><button type="button" data-toggle="modal"  data-target="#eliminarOrden{{ $loop->iteration }}" class="btn btn-danger">Eliminar</button></td>
			        <td><button type="button" data-toggle="modal"  data-target="#verOrden{{ $loop->iteration }}" class="btn btn-info">Ver</button></td>
					<td><button type="button" data-toggle="modal"  data-target="#modificarOrden{{ $loop->iteration }}" class="btn btn-warning">Modificar</button></td>
			  	</tr>
			  	@endforeach
			  </tbody>
			</table>

	</div>
</div>
@php
	$arrayObject = new ArrayObject($ordenes);
	$copiaOrdenes = $arrayObject->getArrayCopy();
@endphp
@foreach ($copiaOrdenes as $ordenes)
	{{-- VER --}}
	<div class="modal fade" id="verOrden{{ $loop->iteration }}" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
		  <div class="modal-content">
			<div class="modal-header">
			  <h5 class="modal-title" id="staticBackdropLabel">Ver Orden de Alejamiento</h5>
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			  </button>
			</div>
			<div class="modal-body">
				  <div class="row">
					 Hola
				  </div>
			</div>
		  </div>
		</div>
	  </div>
	  {{-- eliminar --}}
	  <div class="modal fade" id="eliminarOrden{{ $loop->iteration }}" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
		  <div class="modal-content">
			<div class="modal-header">
			  <h5 class="modal-title" id="staticBackdropLabel">Eliminar orden</h5>
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			  </button>
			</div>
			<div class="modal-body">
				  ¿Estás seguro de querer eliminar esta orden?
			</div>
			<div class="modal-footer">
			  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
			  <a href="{{ action('AdminController@delete_orden', ['id' => $ordenes->idorden]) }}" class="btn btn-danger">Eliminar</a>
			</div>
		  </div>
		</div>
	  </div> 
	  {{-- Modificar --}}
	  <div class="modal fade" id="modificarOrden{{ $loop->iteration }}" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
		  <div class="modal-content">
			<form action="{{ route('modificarorden') }}" method="POST">
			<div class="modal-header">
			  <h5 class="modal-title" id="staticBackdropLabel">Modificar orden</h5>
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			  </button>
			</div>
			<div class="modal-body">
				  Hola....
			</div>
			<div class="modal-footer">
			  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
			  <button type="submit" class="btn btn-warning" data-dismiss="modal">Modificar orden</button>
			</div>
		</form>
		  </div>
		</div>
	  </div> 
@endforeach

@endsection('info')
@section('js')


@endsection('js')