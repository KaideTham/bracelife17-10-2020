@extends('admin/layout')

@section('contenido')
<h3>Modificar Víctima/Victimario</h3>
<br>
@endsection('contenido')
@section('detalle')
<p>Todos los campos deben estar completados.</p>
@endsection('detalle')
@section('info')
<br>
<div>
	@if (!empty($persona))
	@foreach ($persona as $persona)
		<form action="{{ route('updateusuario') }}" name="registrouser" method="POST">
		{{csrf_field()}}
	            <div class="input-group mb-3">
				  <div class="input-group-prepend">
				    <span class="input-group-text" id="">Rut</span>
				  </div> 
				  <input type="text" name="rut" class="form-control" id="rut" readonly value="{{ $persona->rut }}">
				</div>
	            <div class="input-group mb-3">
				  <div class="input-group-prepend">
				    <span class="input-group-text" id="nombres">Nombres</span>
				  </div>
				  <input type="text" name="nombre" id="nombre" class="form-control" minlength="3" maxlength="30" pattern="[a-zA-Z]{3,30}" required  value="{{ $persona->nombre }}">
				  <input type="text" name="seg_nombre" id="seg_nombre" class="form-control" minlength="3" maxlength="30" pattern="[a-zA-Z]{3,30}" required  value="{{ $persona->seg_nombre }}">
				</div>
				<div class="input-group mb-3">
				  <div class="input-group-prepend">
				    <span class="input-group-text" id="apellidos">Apellidos</span>
				  </div>
				  <input type="text" name="apellido_paterno" id="apellido_paterno" class="form-control" minlength="3" maxlength="30" pattern="[a-zA-Z]{3,30}" required value="{{ $persona->apellido_paterno }}">
				  <input type="text" name="apellido_materno" id="apellido_materno" class="form-control" minlength="3" maxlength="30" pattern="[a-zA-Z]{3,30}" required value="{{ $persona->apellido_materno }}">
				</div>
				<div class="input-group mb-3">
				  <div class="input-group-prepend">
				    <span class="input-group-text" id="telefono">Teléfono de Contacto</span>
				  </div>
				  <input type="text" name="telefono" pattern="[0-9]{11}" class="form-control" minlength="11" maxlength="11" required value="{{ $persona->telefono }}">
				</div>
				<div class="input-group mb-3">
				  <div class="input-group-prepend">
				    <span class="input-group-text" id="fecha_nacimiento">Fecha de Nacimiento</span>
				  </div>
				  @php
                    $hoy=date("Y-m-d"); 
                  @endphp
				  <input type="date" name="fecha_nacimiento" max="{{$hoy}}" value="{{ $persona->fecha_nacimiento }}" required class="form-control">
				</div>
				<div class="input-group mb-3">
				  <div class="input-group-prepend">
				    <span class="input-group-text" id="sexo_persona">Sexo</span>
				  </div>
				  <select class="form-control" required name="sexo_persona">				  
				  @foreach ($sexo as $sexo)
				  @if ($persona->sexo_persona == $sexo->idsexo)
				  	<option value="{{ $sexo->idsexo }}" selected>{{ $sexo->desc_sexo }}</option>
				  @else
				  	<option value="{{ $sexo->idsexo }}">{{ $sexo->desc_sexo }}</option>
				  @endif
				  @endforeach
				</select>
				</div>
				<div class="input-group mb-3">
				  <div class="input-group-prepend">
				    <span class="input-group-text" id="domicilio">Domicilio Actual</span>
				  </div>
				  <input type="text" name="domicilio" minlength="3" maxlength="100" required class="form-control" value="{{ $persona->domicilio }}">
				</div>
				<div class="input-group mb-3">
				  <div class="input-group-prepend">
				    <span class="input-group-text" id="estado_civil">Estado Civil</span>
				  </div>
				  <select class="form-control" required="" name="estado_civil">
				  @foreach ($estado_civil as $estado_civil)
				  @if ($persona->estado_civil == $estado_civil->idestado_civil)
				  	<option value="{{ $estado_civil->idestado_civil }}" selected>{{ $estado_civil->desc_estadocivil }}</option>
				  @else
				  	<option value="{{ $estado_civil->idestado_civil }}">{{ $estado_civil->desc_estadocivil }}</option>
				  @endif
				  @endforeach
				</select>
				</div>
				<div class="input-group mb-3">
				  <div class="input-group-prepend">
				    <span class="input-group-text" id="nacionalidad">Nacionalidad</span>
				  </div>
				  <select class="form-control" required name="nacionalidad">
				  @foreach ($nacionalidad as $nacionalidad)
				  @if ($persona->nacionalidad == $nacionalidad->idnacionalidad)
				  	<option value="{{ $nacionalidad->idnacionalidad }}" selected>{{ $nacionalidad->desc_nacionalidad }}</option>
				  @else
				  	<option value="{{ $nacionalidad->idnacionalidad }}">{{ $nacionalidad->desc_nacionalidad }}</option>
				  @endif
				  @endforeach
				</select>
				</div>
				<div class="input-group mb-3">
				  <div class="input-group-prepend">
				    <span class="input-group-text" id="nivel_educacional">Nivel Educacional</span>
				  </div>
				  <select class="form-control" required name="nivel_educacional">
				  @foreach ($nivel_educacional as $nivel_educacional)
				  @if ($persona->nivel_educacional == $nivel_educacional->idnivel_educacional)
				  	<option value="{{ $nivel_educacional->idnivel_educacional }}" selected>{{ $nivel_educacional->desc_niveleducacional }}</option>
				  @else
				  	<option value="{{ $nivel_educacional->idnivel_educacional }}">{{ $nivel_educacional->desc_niveleducacional }}</option>
				  @endif
				  @endforeach
				</select>
				</div>
				<div class="input-group mb-3">
				  <div class="input-group-prepend">
				    <span class="input-group-text" id="">Ocupación</span>
				  </div>
				  <input type="text" minlength="3" class="form-control" maxlength="30" name="ocupacion" pattern="[a-zA-Z]{3,30}" id="ocupacion" required value="{{ $persona->ocupacion }}">
				</div>
				<div class="input-group mb-3">
				  <div class="input-group-prepend">
				    <span class="input-group-text" id="">Comuna de Residencia</span>
				  </div>
				  <select class="form-control" required name="comuna">
				  @foreach ($comunas as $comuna)
				  @if ($persona->comuna == $comuna->idcomuna)
				  	<option value="{{ $comuna->idcomuna }}" selected>{{ $comuna->nombre_comuna }}</option>
				  @else
				  	<option value="{{ $comuna->idcomuna }}">{{ $comuna->nombre_comuna }}</option>
				  @endif
				  @endforeach
				</select>
				</div>
				<div class="input-group mb-3">
				  <div class="input-group-prepend">
				    <span class="input-group-text" id="tipo_perfil">Tipo de Perfil</span>
				  </div>
				  <select class="form-control" required name="tipo_perfil">
				  @foreach ($tipo_perfil as $tipo_perfil)
				  @if ($persona->tipo_perfil == $tipo_perfil->idtipo_perfil)
				  	<option value="{{ $tipo_perfil->idtipo_perfil }}" selected>{{ $tipo_perfil->desc_tipoperfil }}</option>
				  @else
				  	<option value="{{ $tipo_perfil->idtipo_perfil }}">{{ $tipo_perfil->desc_tipoperfil }}</option>
				  @endif
				  @endforeach
				</select>
				</div>
				<div class="row">
					<div class="col-lg-12 text-center">
					<button type="button" class="btn btn-warning">Cancelar</button>	
					<button type="submit" class="btn btn-success">Modificar Registro</button>	
				</div>
	</form>
	@endforeach    
	@else
		{{-- expr --}}
	@endif
	
</div>
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