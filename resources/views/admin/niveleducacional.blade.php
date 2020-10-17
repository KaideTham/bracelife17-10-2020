@extends('admin/layout')

@section('contenido')
<div class="row">
	<div class="col-lg-12">
		<h3>Gestor de Niveles Educacionales</h3>
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
<button type="button" class="btn btn-link" data-toggle="modal" data-target="#agregarNivel">
  Agregar nuevo nivel educacional
</button>
<br>
@endsection('detalle')

<div class="modal fade" id="agregarNivel" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Agregar nuevo nivel educacional</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('saveniveleducacional') }}" method="POST" name="registronivel">
      	{{csrf_field()}}
      <div class="modal-body">
        <div class="input-group mb-3">
		  <div class="input-group-prepend">
		    <span class="input-group-text" id="">Descripción de nivel educacional</span>
		  </div> 
		  <input type="text" name="desc_niveleducacional" class="form-control" id="desc_niveleducacional" placeholder="Básica" maxlength="50" minlength="3" required>
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
			      <th scope="col">Descripción del Nivel Educacional</th>
			      <th scope="col" colspan="2" width="40%">Acciones</th>
			    </tr>
			  </thead>
			  <tbody> 
			  	@foreach ($niveleducacional as $niveleducacional)
			  	<tr>
			      <th>{{ $niveleducacional->idnivel_educacional }}</th>
			      <th>{{ $niveleducacional->desc_niveleducacional }}</th>
			      <th><button type="button" data-toggle="modal" data-backdrop="false" data-target="#eliminarNivel{{ $loop->iteration }}" class="btn btn-danger">Eliminar</button></th>
			      <th><button type="button" data-toggle="modal" data-backdrop="false" data-target="#modificarNivel{{ $loop->iteration }}" class="btn btn-warning">Modificar</button></th>
			  	</tr>
			  	 {{-- eliminar --}}
			      <div class="modal fade" id="eliminarNivel{{ $loop->iteration }}" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="staticBackdropLabel">Eliminar nivel educacional</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			        	¿Estás seguro de querer eliminar este nivel educacional?
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
			        <a href="{{ action('AdminController@delete_niveleducacional', ['id' => $niveleducacional->idnivel_educacional]) }}" class="btn btn-danger">Eliminar</a>
			      </div>
			    </div>
			  </div>
			</div> 
			{{-- modificar --}}
			<div class="modal fade" id="modificarNivel{{ $loop->iteration }}" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="staticBackdropLabel">Modificar nivel educacional</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <form method="POST" action="{{ route('modificarniveleducacional') }}">
			      	{{csrf_field()}}
				      <div class="modal-body">
				        	<div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="">Nro. Nivel Educacional</span>
							  </div> 
							  <input type="text" name="idnivel_educacional" class="form-control" id="idnivel_educacional" readonly value="{{ $niveleducacional->idnivel_educacional }}">
							</div>
							<div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="">Descripción del Nivel Educacional</span>

							  </div>
								<input type="text" name="desc_niveleducacional" minlength="3" maxlength="50" required class="form-control" id="desc_niveleducacional" value="{{ $niveleducacional->desc_niveleducacional }}">
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

	registronivel.idnivel_educacional.addEventListener("keypress", soloNumeros, false);
	function soloNumeros(e){
  var key = window.event ? e.which : e.keyCode;
  if (key < 48 || key > 57) {
    e.preventDefault();
  }
}
</script>
@endsection('js')