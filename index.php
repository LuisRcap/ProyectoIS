<?php
session_start();

require_once "conexion.php";

$correo_diferente = false;
$ingresoExitoso = false;

$conexion = new Conexion();
$conexion->conectar();

if( $_SERVER["REQUEST_METHOD"] == "POST" ){
    
    $correo     = $conexion->getConexion()->real_escape_string( $_POST["correo"] );
    $correoRep  = $conexion->getConexion()->real_escape_string( $_POST["correoRep"] );

    if( $correo === $correoRep ){
        $nombre     = $conexion->getConexion()->real_escape_string( $_POST["nombre"] );
        $apellidoP  = $conexion->getConexion()->real_escape_string( $_POST["apellidoP"] );
        $apellidoM  = $conexion->getConexion()->real_escape_string( $_POST["apellidoM"] );
        $sexo       = $conexion->getConexion()->real_escape_string( $_POST["sexo"] );
        $telefono   = $conexion->getConexion()->real_escape_string( $_POST["telefono"] );
        $celular    = $conexion->getConexion()->real_escape_string( $_POST["celular"] );
        $edad       = intval( $conexion->getConexion()->real_escape_string( $_POST["edad"] ) );

        $calle      = $conexion->getConexion()->real_escape_string( $_POST["calle"] );
        $colonia    = $conexion->getConexion()->real_escape_string( $_POST["colonia"] );
        $delegación = $conexion->getConexion()->real_escape_string( $_POST["delegacion"] );
        $codigoPostal = intval( $conexion->getConexion()->real_escape_string( $_POST["codigoPostal"] ) );
        $fecha = date( "Y-m-d" );
        $hora = date( "G:i:s" );

        $sql = 'INSERT INTO Ciudadano ( correo, nombre, apellidoP, apellidoM, sexo, telefono, celular, edad )
                VALUES ( "'.$correo.'", "'.$nombre.'", "'.$apellidoP.'", "'.$apellidoM.'", "'.$sexo.'", "'.$telefono.'", "'.$celular.'", '.$edad.' )';
        $conexion->getConexion()->query( $sql );

        /*if( $conexion->getConexion()->query( $sql ) ){
            echo "Se inserto al ciudadano\n";
        }else{
            echo "No se inserto al ciudadano\n";
            echo "Error: ", $conexion->getConexion()->error;
        }*/

        $sql = 'INSERT INTO Notificacion ( calle, colonia, delegacion, codigoPostal, fecha, hora, estadoActual, correoCiudadano )
                VALUES ( "'.$calle.'", "'.$colonia.'", "'.$delegación.'", "'.$codigoPostal.'", "'.$fecha.'", "'.$hora.'", "Por verificar", "'.$correo.'" )';
        $conexion->getConexion()->query( $sql );

        /*if($conexion->getConexion()->query( $sql )){
            echo "Se inserto la notificacion\n";
        }else{
            echo "No se inserto la notificacion\n";
            echo "Error: ", $conexion->getConexion()->error;
        }*/

        $ingresoExitoso = true;
    }else{
        $correo_diferente = true;
    }
    
    $conexion->getConexion()->close();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <title>Reportar bache</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="stylesheet" type="text/css" href="css/responsive.css">
</head>

<body>
    <div id="contenedor" class="container col-12">

        <!-- CABECERA -->
        <div id="contCabecera" class="row justify-content-center">
            <header id="header" class="col-11 justify-content-center">
                <div id="logo" class="col-12">
                    <img src="images/bachent_alpha_back.png">
                </div>
            </header>
        </div>

        <?php
            if( $correo_diferente ){
                echo '<div class="alert alert-danger" role="alert" style="text-align: center; margin-top: 25px">
                        Los email no coinciden
                    </div>';
            }else if( $ingresoExitoso ){
                echo '<div class="alert alert-success" role="alert" style="text-align: center; margin-top: 25px">
                        Se ha reportado con exito ¡Gracias por su ayuda!
                    </div>';
            }
        ?>
        

        <!-- CONTENIDO -->
        <div id="mapa" class="row justify-content-center">
            <h2 class="col-11 text-center mb-3 mt-3">Indique en dónde ubicó el bache</h2>
            <iframe class="col-11 mt-3 mb-3"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d30101.028264427783!2d-99.13357705313935!3d19.42844956073063!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85d1f92b75aa014d%3A0x17d810d20da6e8cf!2sPalacio%20de%20Bellas%20Artes!5e0!3m2!1ses-419!2smx!4v1596420530063!5m2!1ses-419!2smx"
                width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false"
                tabindex="0"></iframe>
        </div>

        <!-- FORMULARIO -->
        <div id="formUbicacion" class="row justify-content-center">
            <h2 class="col-11 text-center">Ubicación</h2>
            <form id="formularioCalles" class="col-11" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="form-group col-11">
                    <label>Calle</label>
                    <input name="calle" type="text" class="form-control" placeholder="Calle" require />
                </div>

                <div class="form-group col-11">
                    <label>Colonia</label>
                    <input name="colonia" type="text" class="form-control" placeholder="Colonia" require />
                </div>

                <div class="form-group col-11">
                    <label>Código postal</label>
                    <input name="codigoPostal" type="tel" class="form-control" placeholder="CP" maxlength="5" require />
                </div>

                <div class="form-group col-11">
                    <label>Delegación</label>
                    <input name="delegacion" type="text" class="form-control" placeholder="Del." require />
                </div>
                

                <h2 class="col-11 text-center mt-4 mb-3">Datos del solicitante</h2>
                <div id="nombre" class="form-group col-11">
                    <label>Nombre(s)</label>
                    <input name="nombre" type="text" class="form-control" placeholder="Nombre(s)" />
                </div>

                <div id="ap-paterno" class="form-group col-11">
                    <label>Apellido paterno</label>
                    <input name="apellidoP" type="text" class="form-control" placeholder="Apellido paterno" />
                </div>

                <div id="ap-materno" class="form-group col-11">
                    <label>Apellido materno</label>
                    <input name="apellidoM" type="text" class="form-control" placeholder="Apellido materno" />
                </div>

                <div id="email" class="form-group col-11" require>
                    <label>Email*</label>
                    <input name="correo" type="email" class="form-control" placeholder="email" />
                </div>

                <div id="r-email" class="form-group col-11" require>
                    <label>Repetir email*</label>
                    <input name="correoRep" type="email" class="form-control" placeholder="email" />
                </div>

                <div id="sexo" class="form-group col-11">
                    <label>Sexo</label>
                    <select name="sexo" class="form-control">
                        <option value="">Seleccione su sexo</option>
                        <option>Hombre</option>
                        <option>Mujer</option>
                    </select>
                </div>

                <div id="telefono" class="form-group col-11">
                    <label>Teléfono</label>
                    <input name="telefono" type="tel" class="form-control" placeholder="Tel." maxlength="8" />
                </div>

                <div id="celular" class="form-group col-11">
                    <label>Celular</label>
                    <input name="celular" type="tel" class="form-control" placeholder="5512345678" maxlength="10" />
                </div>

                <div id="edad" class="form-group col-11">
                    <label>Edad</label>
                    <input name="edad" type="number" class="form-control" placeholder="18" min="18" max="120" />
                </div>

                <div id="imagen" class="custom-file">
                    <input name="foto" type="file" class="custom-file-input" id="customFileLang" lang="es">
                    <label class="custom-file-label" for="customFileLang">Seleccionar imagen</label>
                  </div>

                <input id="btnEnviar" type="submit" class="btn btn-success" value="Enviar" />
                
            </form>

            
            
        </div>
        
        


    </div>


    <script type="text/javascript" src="jquery/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="jquery/popper.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
</body>

</html>