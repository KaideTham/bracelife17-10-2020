@extends('admin/layout')

@section('contenido')
<div class="row">
	<div class="col-lg-12 mt-3">
		<h3>Gestor de Víctimas/Victimarios</h3>
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
<br>
@endsection('detalle')
<div class="modal fade" id="agregarUsuario" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Nuevo Registro</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('saveuser') }}" name="registrouser" method="POST">
		{{csrf_field()}}
      <div class="modal-body">
	            <div class="input-group mb-3">
				  <div class="input-group-prepend">
				    <span class="input-group-text" id="">Rut</span>
				  </div> 
				  <input type="text" name="rut" class="form-control" id="rut" placeholder="12345678-9" maxlength="10" minlength="9" required oninput="checkRut(this)" aria-label="Rut" aria-describedby="rut">
				</div>
	            <div class="input-group mb-3">
				  <div class="input-group-prepend">
				    <span class="input-group-text" id="nombres">Nombres</span>
				  </div>
				  <input type="text" name="nombre" id="nombre" class="form-control" minlength="3" maxlength="30" pattern="[a-zA-Z]{3,30}" required placeholder="María" aria-label="Nombre" aria-describedby="nombre">
				  <input type="text" name="seg_nombre" id="seg_nombre" class="form-control" minlength="3" maxlength="30" pattern="[a-zA-Z]{3,30}" required placeholder="José" aria-label="seg_nombre" aria-describedby="nombre">
				</div>
				<div class="input-group mb-3">
				  <div class="input-group-prepend">
				    <span class="input-group-text" id="apellidos">Apellidos</span>
				  </div>
				  <input type="text" name="apellido_paterno" id="apellido_paterno" class="form-control" minlength="3" maxlength="30" pattern="[a-zA-Z]{3,30}" required placeholder="Pérez" aria-label="Apellido" aria-describedby="apellido">
				  <input type="text" name="apellido_materno" id="apellido_materno" class="form-control" minlength="3" maxlength="30" pattern="[a-zA-Z]{3,30}" required placeholder="Rojas" aria-label="apellido_materno" aria-describedby="apellido">
				</div>
				<div class="input-group mb-3">
				  <div class="input-group-prepend">
				    <span class="input-group-text" id="telefono">Teléfono de Contacto</span>
				  </div>
				  <input type="text" name="telefono" pattern="[0-9]{11}" class="form-control" minlength="11" maxlength="11" required placeholder="56912345678" aria-label="telefono" aria-describedby="telefono">
				</div>
				<div class="input-group mb-3">
				  <div class="input-group-prepend">
				    <span class="input-group-text" id="fecha_nacimiento">Fecha de Nacimiento</span>
				  </div>
				  @php
                    $hoy=date("Y-m-d"); 
                  @endphp
				  <input type="date" name="fecha_nacimiento" max="{{$hoy}}" required class="form-control">
				</div>
				<div class="input-group mb-3">
				  <div class="input-group-prepend">
				    <span class="input-group-text" id="sexo_persona">Sexo</span>
				  </div>
				  <select class="form-control" required name="sexo_persona">
				  	<option value="" selected>Seleccione...</option>
				  @if (!empty($sexo))
				  @foreach ($sexo as $sexo)
				  	<option value="{{ $sexo->idsexo }}">{{ $sexo->desc_sexo }}</option>
				  @endforeach
				  @endif
				</select>
				</div>
				<div class="input-group mb-3">
				  <div class="input-group-prepend">
				    <span class="input-group-text" id="">Domicilio Actual</span>
				  </div>
				  <input type="text" name="domicilio" id="domicilio" minlength="3" maxlength="100" required class="form-control" placeholder="Psje Uno #123">
				</div>
				<div class="input-group mb-3">
				  <div class="input-group-prepend">
				    <span class="input-group-text" id="estado_civil">Estado Civil</span>
				  </div>
				  <select class="form-control" required="" name="estado_civil">
				  	<option value="" selected>Seleccione...</option>
				  @if (!empty($estado_civil))
				  @foreach ($estado_civil as $estado_civil)
				  	<option value="{{ $estado_civil->idestado_civil }}">{{ $estado_civil->desc_estadocivil }}</option>
				  @endforeach
				  @endif
				</select>
				</div>
				<div class="input-group mb-3">
				  <div class="input-group-prepend">
				    <span class="input-group-text" id="nacionalidad">Nacionalidad</span>
				  </div>
				  <select class="form-control" required name="nacionalidad">
				  	<option value="" selected>Seleccione...</option>
				  @if (!empty($nacionalidad))
				  @foreach ($nacionalidad as $nacionalidad)
				  	<option value="{{ $nacionalidad->idnacionalidad }}">{{ $nacionalidad->desc_nacionalidad }}</option>
				  @endforeach
				  @endif
				</select>
				</div>
				<div class="input-group mb-3">
				  <div class="input-group-prepend">
				    <span class="input-group-text" id="nivel_educacional">Nivel Educacional</span>
				  </div>
				  <select class="form-control" required name="nivel_educacional">
				  	<option value="" selected>Seleccione...</option>
				  @if (!empty($nivel_educacional))
				  @foreach ($nivel_educacional as $nivel_educacional)
				  	<option value="{{ $nivel_educacional->idnivel_educacional }}">{{ $nivel_educacional->desc_niveleducacional }}</option>
				  @endforeach
				  @endif
				</select>
				</div>
				<div class="input-group mb-3">
				  <div class="input-group-prepend">
				    <span class="input-group-text" id="">Ocupación</span>
				  </div>
				  <input type="text" minlength="3" maxlength="30" pattern="[a-zA-Z]{3,30}" id="ocupacion" required name="ocupacion" class="form-control" placeholder="Vendedor/a">
				</div>
				<div class="input-group mb-3">
				  <div class="input-group-prepend">
				    <span class="input-group-text" id="">Comuna de Residencia</span>
				  </div>
				  <select class="form-control" required name="comuna">
				  	<option value="" selected>Seleccione...</option>
				  @if (!empty($comunas))
				  @foreach ($comunas as $comuna)
				  	<option value="{{ $comuna->idcomuna }}">{{ $comuna->nombre_comuna }}</option>
				  @endforeach
				  @endif
				</select>
				</div>
				<div class="input-group mb-3">
				  <div class="input-group-prepend">
				    <span class="input-group-text" id="tipo_perfil">Tipo de Perfil</span>
				  </div>
				  <select class="form-control" required name="tipo_perfil">
				  	<option value="" selected>Seleccione...</option>
				  @if (!empty($tipo_perfil))
				  @foreach ($tipo_perfil as $tipo_perfil)
				  	<option value="{{ $tipo_perfil->idtipo_perfil }}">{{ $tipo_perfil->desc_tipoperfil }}</option>
				  @endforeach
				  @endif
				</select>
				</div>
      <div class="modal-footer">
					<button type="reset" class="btn btn-info">Limpiar</button>	
					<button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>	
					<button type="submit" class="btn btn-success">Guardar Registro</button>	
      </div>
  </form>
    </div>
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
				<input class="form-control" type="text" placeholder="Buscar Usuario..." aria-label="Search"
					aria-describedby="basic-addon2" />
				<div class="input-group-append">
					<button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
				</div>
			</div>
		</form>
		@php
			  $arrayObject = new ArrayObject($personas);
			  $copiaPersona = $arrayObject->getArrayCopy();
		  @endphp
		<button type="button" class="btn btn-link" data-toggle="modal" data-target="#agregarUsuario">
			Nuevo Registro
		  </button>
		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
				  <tr>
					<th scope="col">Rut</th>
					<th scope="col">Nombre Completo</th>
					<th scope="col">Comuna</th>
					<th scope="col">Perfil de Usuario</th>
					<th scope="col" colspan="3">Acciones</th>
				  </tr>
				</thead>
				<tbody>
				@foreach ($personas as $personas)
				  <tr>
					<td>{{ $personas->rut }}</td>
					<td>{{ $personas->nombre }} {{ $personas->seg_nombre }} {{ $personas->apellido_paterno }} {{ $personas->apellido_materno }}</td>
					<td>{{ $personas->nombre_comuna }}</td>
					<td>{{ $personas->desc_tipoperfil }}</td>
					<td><button type="button" data-toggle="modal"  data-target="#eliminarUsuario{{ $loop->iteration }}" class="btn btn-danger">Eliminar</button></td>
					<td>
						<form method="POST" action="{{ route('modificarusuario') }}">
							{{csrf_field()}}
							<input type="hidden" value="{{ $personas->rut }}" name="rut">
							<button type="submit" class="btn btn-warning">Modificar</button>
						</form>
					</td>
					<td><button type="button" data-toggle="modal"  data-target="#verUsuario{{ $loop->iteration }}" class="btn btn-info">Ver</button></td>
				  </tr>
				@endforeach
				</tbody>
			  </table>
		</div>
	</div>
</div>
@foreach ($copiaPersona as $personas)
	{{-- VER --}}
	<div class="modal fade" id="verUsuario{{ $loop->iteration }}" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
		  <div class="modal-content">
			<div class="modal-header">
			  <h5 class="modal-title" id="staticBackdropLabel">Ver Información del Usuario</h5>
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			  </button>
			</div>
			<div class="modal-body">
				  <div class="row">
					  <div class="col-lg-4">
						  <label><b>Rut: </b></label>
					  </div>
					  <div class="col-lg-8">
						  {{ $personas->rut }}
					  </div>
					  <div class="col-lg-4">
						  <label><b>Nombre Completo: </b></label>
					  </div>
					  <div class="col-lg-8">
						  {{ $personas->nombre }} {{ $personas->seg_nombre }} {{ $personas->apellido_paterno }} {{ $personas->apellido_materno }}
					  </div>
					  <div class="col-lg-4">
						  <label><b>Teléfono: </b></label>
					  </div>
					  <div class="col-lg-8">
						  {{ $personas->telefono }}
					  </div>
					  <div class="col-lg-4">
						  <label><b>Fecha de Nacimiento: </b></label>
					  </div>
					  <div class="col-lg-8">
						  @php
						  list($anio,$mes,$dia) = explode('-',$personas->fecha_nacimiento);
						  echo $dia."-".$mes."-".$anio;
						  @endphp
					  </div>
					  <div class="col-lg-4">
						  <label><b>Sexo: </b></label>
					  </div>
					  <div class="col-lg-8">
						  {{ $personas->desc_sexo }}
					  </div>
					  <div class="col-lg-4">
						  <label><b>Domicilio Actual: </b></label>
					  </div>
					  <div class="col-lg-8">
						  {{ $personas->domicilio }}
					  </div>
					  <div class="col-lg-4">
						  <label><b>Comuna de Residencia: </b></label>
					  </div>
					  <div class="col-lg-8">
						  {{ $personas->nombre_comuna }}
					  </div>
					  <div class="col-lg-4">
						  <label><b>Nacionalidad: </b></label>
					  </div>
					  <div class="col-lg-8">
						  {{ $personas->desc_nacionalidad }}
					  </div>
					  <div class="col-lg-4">
						  <label><b>Estado Civil: </b></label>
					  </div>
					  <div class="col-lg-8">
						  {{ $personas->desc_estadocivil }}
					  </div>
					  <div class="col-lg-4">
						  <label><b>Nivel Educacional: </b></label>
					  </div>
					  <div class="col-lg-8">
						  {{ $personas->desc_niveleducacional }}
					  </div>
					  <div class="col-lg-4">
						  <label><b>Ocupación: </b></label>
					  </div>
					  <div class="col-lg-8">
						  {{ $personas->ocupacion }}
					  </div>
					  <div class="col-lg-4">
						  <label><b>Tipo de Perfil: </b></label>
					  </div>
					  <div class="col-lg-8">
						  {{ $personas->desc_tipoperfil }}
					  </div>
					  <!-- 
					  <div class="col-lg-4">
						  <label><b>Brazalete que utiliza: </b></label>
					  </div>
					  <div class="col-lg-8">
					  </div>
					-->
				  </div>
			</div>
		  </div>
		</div>
	  </div>
	  {{-- eliminar --}}
	  <div class="modal fade" id="eliminarUsuario{{ $loop->iteration }}" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
		  <div class="modal-content">
			<div class="modal-header">
			  <h5 class="modal-title" id="staticBackdropLabel">Eliminar Usuario</h5>
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			  </button>
			</div>
			<div class="modal-body">
				  ¿Estás seguro de querer eliminar este Usuario?
			</div>
			<div class="modal-footer">
			  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
			  <a href="{{ action('AdminController@delete_usuario', ['rut' => $personas->rut]) }}" class="btn btn-danger">Eliminar</a>
			</div>
		  </div>
		</div>
	  </div> 
@endforeach



@endsection('info')

@section('js')
<script>
function checkRut(rut) {
    // Despejar Puntos
    var valor = rut.value.replace('.','');
    // Despejar Guión
    valor = valor.replace('-','');
    
    // Aislar Cuerpo y Dígito Verificador
    cuerpo = valor.slice(0,-1);
    dv = valor.slice(-1).toUpperCase();
    
    // Formatear RUN
    rut.value = cuerpo + '-'+ dv
    
    
    // Calcular Dígito Verificador
    suma = 0;
    multiplo = 2;
    
    // Para cada dígito del Cuerpo
    for(i=1;i<=cuerpo.length;i++){
    
        // Obtener su Producto con el Múltiplo Correspondiente
        index = multiplo * valor.charAt(cuerpo.length - i);
        
        // Sumar al Contador General
        suma = suma + index;
        
        // Consolidar Múltiplo dentro del rango [2,7]
        if(multiplo < 7) { multiplo = multiplo + 1; } else { multiplo = 2; }
    
    }
    
    // Calcular Dígito Verificador en base al Módulo 11
    dvEsperado = 11 - (suma % 11);
    
    // Casos Especiales (0 y K)
    dv = (dv == 'K')?10:dv;
    dv = (dv == 0)?11:dv;
    
    // Validar que el Cuerpo coincide con su Dígito Verificador
    if(dvEsperado != dv) { rut.setCustomValidity("RUT Inválido"); return false; }
    else {
    // Si todo sale bien, eliminar errores (decretar que es válido)
    rut.setCustomValidity('')};
}
</script>
<script>
	registrouser.telefono.addEventListener("keypress", soloNumeros, false);
	function soloNumeros(e){
  var key = window.event ? e.which : e.keyCode;
  if (key < 48 || key > 57) {
    e.preventDefault();
  }
}
</script>
<script>
$("#nombre").keyup(function(){              
        var ta      =   $("#nombre");
        letras      =   ta.val().replace(/ /g, "");
        ta.val(letras)
}); 
$("#seg_nombre").keyup(function(){              
        var ta      =   $("#seg_nombre");
        letras      =   ta.val().replace(/ /g, "");
        ta.val(letras)
}); 
$("#apellido_paterno").keyup(function(){              
        var ta      =   $("#apellido_paterno");
        letras      =   ta.val().replace(/ /g, "");
        ta.val(letras)
}); 	
$("#apellido_materno").keyup(function(){              
        var ta      =   $("#apellido_materno");
        letras      =   ta.val().replace(/ /g, "");
        ta.val(letras)
}); 
$("#ocupacion").keyup(function(){              
        var ta      =   $("#ocupacion");
        letras      =   ta.val().replace(/ /g, "");
        ta.val(letras)
}); 
$("#rut").keyup(function(){              
        var ta      =   $("#rut");
        letras      =   ta.val().replace(/ /g, "");
        ta.val(letras)
}); 
</script>
@endsection('js')