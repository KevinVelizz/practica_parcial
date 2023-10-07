<?php
require_once("C:/xampp/htdocs/prog_3/practica/backend/clases/Usuario.php");

$opcion = $_POST["opcion"];

switch($opcion)
{
    case "GuardarEnArchivo":
        $nombre = $_POST["nombre"];
        $correo = $_POST["correo"];
        $clave = $_POST["clave"];
        $usuario = new Usuario(4,$nombre,$correo,$clave,3,"albañil");
        $mensaje = json_decode($usuario->GuardarEnArchivo());
        echo $mensaje->exito . " - " . $mensaje->mensaje;
        break;
}





