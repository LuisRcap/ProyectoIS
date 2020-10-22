<?php
session_start();

if( isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true ){
    header("location: menu.php");
    exit;
}

require_once "conexion.php";

$mensaje_error = false;

$conexion = new Conexion();
$conexion->conectar();

if( $_SERVER["REQUEST_METHOD"] == "POST" ){
    $usuario = $conexion->getConexion()->real_escape_string( $_POST["matricula"] );
    $contrasena = $conexion->getConexion()->real_escape_string( $_POST["contrasena"] );

    $sql = 'SELECT matricula, contrasena FROM Usuario WHERE matricula = "'.$usuario.'" AND contrasena = "'.$contrasena.'"';

    if( $resultado = $conexion->getConexion()->query( $sql ) ){
        if( $resultado->num_rows == 1 ){
            $_SESSION["loggedin"] = true;
            header( "location: menu.php" );
        }else{
            $mensaje_error = true;
        }
        $resultado->close();
    }else{
        /*echo "No se encontro un usuario y una contraseña que coinciden\n";
        echo "Error: ", $conexion->getConexion()->error;*/
        $mensaje_error = true;
    }

    $conexion->getConexion()->close();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/login.css">
    </head>
    <body class="login">
        <div class="logo">
            <img src="images/bachent_alpha_white.png">
        </div>
        <div class="content">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="formulario" method="post">
                <?php
                    if( !$mensaje_error ){
                        echo '<h1 class="display-4">Iniciar Sesión</h1>';
                        
                    }else{
                        echo '<h1 class="display-4" style="margin-bottom: 10px">Iniciar Sesión</h1>'.
                            '<div class="alert alert-danger" role="alert" style="text-align: center">'.
                                'Usuario y/o contraseña erroneos'.
                            '</div>';
                    }
                ?>
                <div class="campo">
                    <label>Usuario</label>
                    <input type="text" name="matricula" class="form-control" placeholder="Ingrese su usuario">
                </div>
                <div class="campo">
                    <label>Contraseña</label>
                    <input type="password" name="contrasena" class="form-control" placeholder="Ingrese su contraseña">
                </div>
    
                <button type="submit" class="btn btn-light boton">Ingresar</button>
            </form>
        </div>
    </body>
</html>