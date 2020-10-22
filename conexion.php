<?php

class Conexion{
    private $servidor;
    private $usuario;
    private $contrasena;
    private $baseDatos;
    private $conexion;

    public function Conexion(){
        $this->ervidor = "localhost";
        $this->usuario = "root";
        $this->contrasena = "";
        $this->baseDatos = "Baches";
    }

    /*public function Conexion( $ip, $usuario, $contrasena, $baseDatos ){
        $this->$ip = $ip;
        $this->$usuario = $usuario;
        $this->$contrasena = $contrasena;
        $this->$baseDatos = $baseDatos;
    }*/

    public function conectar(){
        $this->conexion = new mysqli( $this->servidor, $this->usuario, $this->contrasena, $this->baseDatos );
        
        if( $this->conexion->connect_errno ){
            die( "Connection failed: ".$this->conexion->connect_error );
        }
    }

    public function getConexion(){
        return $this->conexion;
    }
}

?>