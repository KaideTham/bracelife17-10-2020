@extends('admin/layout')

@section('contenido')
<div class="row">
	<div class="col-lg-12">
		<h3>Gestor de Provincias</h3>
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
<button type="button" class="btn btn-link" data-toggle="modal" data-target="#agregarProvincia">
  Agregar nueva Provincia
</button>
<br>
@endsection('detalle')

<div class="modal fade" id="agregarProvincia" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Agregar nueva Provincia</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('saveprovincia') }}" method="POST" name="registroprovincia">
      	{{csrf_field()}}
      <div class="modal-body">
      	<div class="input-group mb-3">
		  <div class="input-group-prepend">
		    <span class="input-group-text" id="">Región</span>
		  </div> 
		  <select class="form-control" required name="provincia_region">
			  	<option value="" selected>Seleccione...</option>
			  @if (!empty($regiones))
			  @foreach ($regiones as $regiones)
			  	<option value="{{ $regiones->idregion }}">{{ $regiones->nombre_region }}</option>
			  @endforeach
			  @endif
			</select>
		</div>
        <div class="input-group mb-3">
		  <div class="input-group-prepend">
		    <span class="input-group-text" id="">Provincia</span>
		  </div> 
		  <input type="text" name="nombre_provincia" class="form-control" id="nombre_provincia" placeholder="Arica" maxlength="50" minlength="3" required>
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
			      <th scope="col">Provincia</th>
			      <th scope="col">Región</th>
			      <th scope="col" colspan="2" width="40%">Acciones</th>
			    </tr>
			  </thead>
			  <tbody> 
			  	@foreach ($provincias as $provincias)
			  	<tr>
			      <th>{{ $provincias->idprovincia }}</th>
			      <th>{{ $provincias->nombre_provincia }}</th>
			      <th>{{ $provincias->nombre_region }}</th>
			      <th><button type="button" data-toggle="modal" data-backdrop="false" data-target="#eliminarProvincia{{ $loop->iteration }}" class="btn btn-danger">Eliminar</button></th>
			      <th><button type="button" data-toggle="modal" data-backdrop="false" data-target="#modificarProvincia{{ $loop->iteration }}" class="btn btn-warning">Modificar</button></th>
			  	</tr>
			  	 {{-- eliminar --}}
			      <div class="modal fade" id="eliminarProvincia{{ $loop->iteration }}" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="staticBackdropLabel">Eliminar Provincia</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			        	¿Estás seguro de querer eliminar esta Provincia?
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
			        <a href="{{ action('AdminController@delete_provincia', ['id' => $provincias->idprovincia]) }}" class="btn btn-danger">Eliminar</a>
			      </div>
			    </div>
			  </div>
			</div> 
			{{-- modificar --}}
			<div class="modal fade" id="modificarProvincia{{ $loop->iteration }}" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="staticBackdropLabel">Modificar Provincia</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <form method="POST" action="{{ route('modificarprovincia') }}">
			      	{{csrf_field()}}
				      <div class="modal-body">
				        	<div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="">Nro. Provincia</span>
							  </div> 
							  <input type="text" name="idprovincia" class="form-control" id="idprovincia" readonly value="{{ $provincias->idprovincia }}">
							</div>
							<div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="">Región de</span>
							  </div> 
							  <input type="text" name="nombre_region" class="form-control" id="nombre_region" readonly value="{{ $provincias->nombre_region }}">
							</div>
							<div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="">Provincia</span>

							  </div>
								<input type="text" name="nombre_provincia" minlength="3" maxlength="50" required class="form-control" id="nombre_provincia" value="{{ $provincias->nombre_provincia }}">
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

	registroprovincia.idprovincia.addEventListener("keypress", soloNumeros, false);
	function soloNumeros(e){
  var key = window.event ? e.which : e.keyCode;
  if (key < 48 || key > 57) {
    e.preventDefault();
  }
}
</script>
@endsection('js')