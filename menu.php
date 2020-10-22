<?php
session_start();

if( !isset($_SESSION["loggedin"]) ){
    header("location: login.php");
    exit;
}

require_once "conexion.php";

$conexion = new Conexion();
$conexion->conectar();

$sinRegistros = false;
$registrosNotificacion = null;
$registroDatos = null;

$sql = 'SELECT calle, colonia, delegacion, codigoPostal, fecha, hora, estadoActual, correoCiudadano FROM Notificacion';

$resultado = $conexion->getConexion()->query( $sql );
if( $resultado->num_rows == 0 ){
    $sinRegistros = true;
}else if( $resultado->num_rows > 0 ){
    $registrosNotificacion = $resultado->fetch_all( MYSQLI_ASSOC );
    $resultado->free_result();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Reportes de baches</title>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/menu.css">
    </head>
    <body>
        <header>
            <div class="navegacion">
                <div class="categoria">
                    <p>Reportes</p>
                </div>
                <div class="logo">
                    <img src="images/bachent_alpha_back.png">
                </div>
                <div id="boton-cerrar-sesion" class="cerrar-sesion">
                    <p>Cerrar sesión</p>
                    <img src="images/icon-off.png" class="icono-salir">
                </div>
            </div>
        </header>

        <section class="principal">

            <?php
                if( !$sinRegistros ){
                    foreach( $registrosNotificacion as $registro ){
                        echo '<div class="notificacion">';
                        echo    '<img src="images/Bache.png" class="foto">';
                        echo    '<div class="datos-prin">';
                        echo        '<h4 class="situacion"><span class="campo">Situación actual:</span> <span class="reparado">'.$registro["estadoActual"].'</span></h4>';
                        echo        '<h5><span class="campo">Fecha de notificación:</span> '.$registro["fecha"].' a las '.$registro["hora"].' horas</h5>';
                        echo        '<p><span class="campo">Dirección:</span> '.$registro["delegacion"].', '.$registro["colonia"].', '.$registro["calle"].' - CP: '.$registro["codigoPostal"].'</p>';
                        
                        $sql = 'SELECT nombre, apellidoP, apellidoM, telefono, celular FROM Ciudadano WHERE correo = "'.$registro["correoCiudadano"].'"';
                        $resultado = $conexion->getConexion()->query( $sql );
                        $registroDatos = $resultado->fetch_all( MYSQLI_ASSOC );

                        echo        '<div class="datos-pers">';
                        echo            '<p><span class="campo">Reportado por:</span> '.$registroDatos[0]["nombre"].' '.$registroDatos[0]["apellidoP"].' '.$registroDatos[0]["apellidoM"].'</p>';
                        echo            '<p><span class="campo">Correo:</span> '.$registro["correoCiudadano"].'</p>';
                        echo            '<p><span class="campo">Teléfono:</span> '.$registroDatos[0]["telefono"].'</p>';
                        echo            '<p><span class="campo">Celular:</span> '.$registroDatos[0]["celular"].'</p>';
                        echo        '</div>';
                        echo    '</div>';
                        echo    '<img src="images/icon-menu.svg" class="icono-ver">';
                        echo '</div>';

                        $resultado->free_result();
                    }
                }
            
                $conexion->getConexion()->close();
            ?>

        </section>

        <script>

            function cerrarSesion(){
                window.location = "logout.php";
            }

            function load(){
                let elemento = document.getElementById("boton-cerrar-sesion");
                elemento.addEventListener( "click", cerrarSesion, false );
            }

            document.addEventListener( "DOMContentLoaded", load, false );

        </script>
    </body>
</html>