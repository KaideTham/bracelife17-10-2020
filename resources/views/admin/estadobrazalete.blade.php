@extends('admin/layout')

@section('contenido')
<div class="row">
	<div class="col-lg-12">
		<h3>Gestor de Estados del Brazalete</h3>
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
<button type="button" class="btn btn-link" data-toggle="modal" data-target="#agregarEstado">
  Agregar nuevo estado
</button>
<br>
@endsection('detalle')

<div class="modal fade" id="agregarEstado" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Agregar nuevo estado</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('saveestadobrazalete') }}" method="POST" name="registroestado">
      	{{csrf_field()}}
      <div class="modal-body">
        <div class="input-group mb-3">
		  <div class="input-group-prepend">
		    <span class="input-group-text" id="">Estado del Brazalete</span>
		  </div> 
		  <input type="text" name="desc_estado" class="form-control" id="desc_estado" placeholder="Coquimbo" maxlength="50" minlength="3" required>
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

@section('info')
<div class="row">
	<div class="col p-3" style="background-color: #ffffff">
		<table class="table table-hover">
			<thead>
			    <tr>
			      <th scope="col">Nro.</th>
			      <th scope="col">Descripción del Estado</th>
			      <th scope="col" colspan="2" width="40%">Acciones</th>
			    </tr>
			  </thead>
			  <tbody> 
			  	@foreach ($estadobrazalete as $estadobrazalete)
			  	<tr>
			      <th>{{ $estadobrazalete->idestado_brazalete }}</th>
			      <th>{{ $estadobrazalete->desc_estado }}</th>
			      <th><button type="button" data-toggle="modal" data-backdrop="false" data-target="#eliminarEstado{{ $loop->iteration }}" class="btn btn-danger">Eliminar</button></th>
			      <th><button type="button" data-toggle="modal" data-backdrop="false" data-target="#modificarEstado{{ $loop->iteration }}" class="btn btn-warning">Modificar</button></th>
			  	</tr>
			  	 {{-- eliminar --}}
			      <div class="modal fade" id="eliminarEstado{{ $loop->iteration }}" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="staticBackdropLabel">Eliminar estado</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			        	¿Estás seguro de querer eliminar este estado?
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
			        <a href="{{ action('AdminController@delete_estadobrazalete', ['id' => $estadobrazalete->idestado_brazalete]) }}" class="btn btn-danger">Eliminar</a>
			      </div>
			    </div>
			  </div>
			</div> 
			{{-- modificar --}}
			<div class="modal fade" id="modificarEstado{{ $loop->iteration }}" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="staticBackdropLabel">Modificar Estado del brazalete</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <form method="POST" action="{{ route('modificarestadobrazalete') }}">
			      	{{csrf_field()}}
				      <div class="modal-body">
				        	<div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="">Nro. Estado</span>
							  </div> 
							  <input type="text" name="idestado_brazalete" class="form-control" id="idestado_brazalete" readonly value="{{ $estadobrazalete->idestado_brazalete }}">
							</div>
							<div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="">Descripción del Estado</span>

							  </div>
								<input type="text" name="desc_estado" minlength="3" maxlength="50" required class="form-control" id="desc_estado" value="{{ $estadobrazalete->desc_estado }}">
							</div>
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
				        <button type="submit"  class="btn btn-warning">Modificar</a>
				      </div>			      	
			      </form>
			    </div>
			  </div>
			</div> 
			{{-- ver --}}
			  	@endforeach
			  </tbody>
			</table>

	</div>
</div>

@endsection('info')
@section('js')
<script>

	registroestado.idestado_brazalete.addEventListener("keypress", soloNumeros, false);
	function soloNumeros(e){
  var key = window.event ? e.which : e.keyCode;
  if (key < 48 || key > 57) {
    e.preventDefault();
  }
}
</script>
@endsection('js')