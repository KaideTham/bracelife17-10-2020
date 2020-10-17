@extends('admin/layout')

@section('contenido')
<div class="row">
	<div class="col-lg-12">
		<h3>Gestor de Nacionalidades</h3>
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
  Agregar nueva nacionalidad
</button>
<br>
@endsection('detalle')

<div class="modal fade" id="agregarBrazalete" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Agregar nueva nacionalidad</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('savenacionalidad') }}" method="POST" name="registronacionalidad">
      	{{csrf_field()}}
      <div class="modal-body">
        <div class="input-group mb-3">
		  <div class="input-group-prepend">
		    <span class="input-group-text" id="">Nacionalidad</span>
		  </div> 
		  <input type="text" name="desc_nacionalidad" class="form-control" id="desc_nacionalidad" placeholder="Chileno/a" maxlength="20" minlength="3" required>
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
			      <th scope="col">Nacionalidad</th>
			      <th scope="col" colspan="2" width="40%">Acciones</th>
			    </tr>
			  </thead>
			  <tbody> 
			  	@foreach ($nacionalidades as $nacionalidades)
			  	<tr>
			      <th>{{ $nacionalidades->idnacionalidad }}</th>
			      <th>{{ $nacionalidades->desc_nacionalidad }}</th>
			      <th><button type="button" data-toggle="modal" data-backdrop="false" data-target="#eliminarNacionalidad{{ $loop->iteration }}" class="btn btn-danger">Eliminar</button></th>
			      <th><button type="button" data-toggle="modal" data-backdrop="false" data-target="#modificarNacionalidad{{ $loop->iteration }}" class="btn btn-warning">Modificar</button></th>
			  	</tr>
			  	 {{-- eliminar --}}
			      <div class="modal fade" id="eliminarNacionalidad{{ $loop->iteration }}" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="staticBackdropLabel">Eliminar Nacionalidad</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			        	¿Estás seguro de querer eliminar esta Nacionalidad?
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
			        <a href="{{ action('AdminController@delete_nacionalidad', ['id' => $nacionalidades->idnacionalidad]) }}" class="btn btn-danger">Eliminar</a>
			      </div>
			    </div>
			  </div>
			</div> 
			{{-- modificar --}}
			<div class="modal fade" id="modificarNacionalidad{{ $loop->iteration }}" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="staticBackdropLabel">Modificar Nacionalidad</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <form method="POST" action="{{ route('modificarnacionalidad') }}">
			      	{{csrf_field()}}
				      <div class="modal-body">
				        	<div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="">Nro. Nacionalidad</span>
							  </div> 
							  <input type="text" name="idnacionalidad" class="form-control" id="idnacionalidad" readonly value="{{ $nacionalidades->idnacionalidad }}">
							</div>
							<div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="">Nacionalidad</span>

							  </div>
								<input type="text" name="desc_nacionalidad" minlength="3" maxlength="20" required class="form-control" id="desc_nacionalidad" value="{{ $nacionalidades->desc_nacionalidad }}">
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
$("#desc_nacionalidad").keyup(function(){              
        var ta      =   $("#desc_nacionalidad");
        letras      =   ta.val().replace(/ /g, "");
        ta.val(letras)
}); 
	registronacionalidad.idnacionalidad.addEventListener("keypress", soloNumeros, false);
	function soloNumeros(e){
  var key = window.event ? e.which : e.keyCode;
  if (key < 48 || key > 57) {
    e.preventDefault();
  }
}
</script>
@endsection('js')