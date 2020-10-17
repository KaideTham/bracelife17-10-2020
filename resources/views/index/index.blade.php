<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=gb18030">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="_token" content="{{ csrf_token() }}" />

    <title>Bracelife</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous">
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@200;300;400&display=swap"
        rel="stylesheet">
    <link href="{{ URL::asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css">
    <script src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.esm.min.js"
        integrity="sha384-sKZy8g2KJhBTFCD6cIg8d4EifJxaa8c/iYIERdeKorHWhAgZgQOfqOKMe3xBqye1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.bundle.min.js"
        integrity="sha384-DBjhmceckmzwrnMMrjI7BvG2FmRuxQVaTfFYHgfnrdfqMhxKt445b7j3KBQLolRl" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css"
        integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"
        integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous">
    </script>
    <style>
        .preloader {
   position: absolute;
   top: 0;
   left: 0;
   width: 100%;
   height: 100%;
   z-index: 9999;
   background-image: url('img/preloader.gif');
   background-repeat: no-repeat; 
   background-color: #FFF;
   background-position: center;
}
    </style>
</head>

<body class="container">
    <div class="preloader"></div>
    <div class="container text-center">
        <div class="mt-3">
            <img src="{{ URL::asset('img/logosmall.png') }}" width="200px">
        </div>
        <br>
        <h3 class="m-3"></h3>
        <div class="row justify-content-center">
            <div class="col-sm-12 col-md-12 col-xl-6 text-left">
                <div>
                    @if (Session::has('error'))
                        <div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>{{ Session::get('error') }}</div>
                    @elseif (Session::has('success'))
                        <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>{{ Session::get('success') }}</div>
                    @endif
                </div>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center">Iniciar Sesión</h5>
                        <form method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label>Rut</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><span class="fa fa-user"
                                                aria-hidden="true"></span></span>
                                    </div>
                                    <input type="text" class="form-control" name="rut" placeholder="12345678-9"
                                        maxlength="10" id="rut" required minlength="9" aria-label="RUT"
                                        oninput="checkRut(this);">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Contraseña</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><span class="fa fa-lock"
                                                aria-hidden="true"></span></span>
                                    </div>
                                    <input type="password" class="form-control" name="pass" placeholder="********"
                                        required minlength="6" aria-label="password">
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" name="login" class="btn "
                                    style="background-color: #e15d7d; color: white">Ingresar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="mt-3 text-center">
                    <p>¿Olvidó su contraseña? Recupérela <a href="">aquí</a></p>
                    <!--
                <a data-toggle="modal" href="#AgregarUsuario">+ Usuario</a>
                    
                <div class="modal fade" id="AgregarUsuario" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Agregar Usuario</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                    <form action="{{route('registropersonal')}}" method="POST">
                            {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon1">Rut</span>
                                </div>
                                <input type="text" class="form-control" name="rutpersonal" placeholder="12345678-9"
                                        maxlength="10" id="rutpersonal" required minlength="9" aria-label="RUT"
                                        oninput="checkRut(this);">
                              </div>
                              <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon1">Nombre</span>
                                </div>
                                <input class="form-control" type="text" minlength="3" required name="nombre">
                              </div>
                              <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon1">Apellidos</span>
                                </div>
                                <input class="form-control" type="text" minlength="3" required name="apellido_paterno">
                                <input class="form-control" type="text" minlength="3" required name="apellido_materno">
                              </div>
                              <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon1">Mail</span>
                                </div>
                                <input class="form-control" type="email" minlength="3" required name="mail">
                              </div>
                              <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon1">Ocupación</span>
                                </div>
                                <input class="form-control" type="text" minlength="3" required name="ocupacion">
                              </div>
                              <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon1">Institución</span>
                                </div>
                                <select  class="form-control" required name="rutinstitucion" id="">
                                    <option value="">Seleccione...</option>
                                    @if (!empty($institucion))
                                    @foreach ($institucion as $inst)
                                <option value="{{$inst->rutinstitucion}}">{{$inst->nombre_institucion}}</option>
                                    @endforeach
                                        
                                    @endif
                                </select>
                              </div>
                              <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon1">Tipo de Perfil</span>
                                </div>
                                <select  class="form-control" required name="tipo_perfil" id="">
                                    <option value="">Seleccione...</option>
                                    @if (!empty($tipo_perfil))
                                    @foreach ($tipo_perfil as $tipo)
                                <option value="{{$tipo->idtipo_perfil}}">{{$tipo->desc_tipoperfil}}</option>
                                    @endforeach
                                        
                                    @endif
                                </select>
                              </div>
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-primary">Registrar Personal</button>
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                      </div>
                    </div>
                  </div>
                </div>
            -->
            </div>
        </div>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script>
        function checkRut(rut) {
            // Despejar Puntos
            var valor = rut.value.replace('.', '');
            // Despejar Guión
            valor = valor.replace('-', '');

            // Aislar Cuerpo y Dígito Verificador
            cuerpo = valor.slice(0, -1);
            dv = valor.slice(-1).toUpperCase();

            // Formatear RUN
            rut.value = cuerpo + '-' + dv


            // Calcular Dígito Verificador
            suma = 0;
            multiplo = 2;

            // Para cada dígito del Cuerpo
            for (i = 1; i <= cuerpo.length; i++) {

                // Obtener su Producto con el Múltiplo Correspondiente
                index = multiplo * valor.charAt(cuerpo.length - i);

                // Sumar al Contador General
                suma = suma + index;

                // Consolidar Múltiplo dentro del rango [2,7]
                if (multiplo < 7) {
                    multiplo = multiplo + 1;
                } else {
                    multiplo = 2;
                }

            }

            // Calcular Dígito Verificador en base al Módulo 11
            dvEsperado = 11 - (suma % 11);

            // Casos Especiales (0 y K)
            dv = (dv == 'K') ? 10 : dv;
            dv = (dv == 0) ? 11 : dv;

            // Validar que el Cuerpo coincide con su Dígito Verificador
            if (dvEsperado != dv) {
                rut.setCustomValidity("RUT Inválido");
                return false;
            } else {
                // Si todo sale bien, eliminar errores (decretar que es válido)
                rut.setCustomValidity('')
            };
        }

    </script>
    <script>
        $(window).load(function() {
           setTimeout(function(){ 
               $('.preloader').fadeOut('slow');
           }, 1000);
      
   });
   $(window).ready(function() {
           setTimeout(function(){ 
               $('.titlee').fadeOut('slow');
           }, 2000);
      
   });
     </script>
</body>

</html>
