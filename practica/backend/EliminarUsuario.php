<?php
require_once("C:/xampp/htdocs/prog_3/practica/backend/clases/Usuario.php");

$accion = $_POST["accion"];
$id = $_POST["id"];

switch($accion)
{
    case "borrar":
        if(Usuario::Eliminar($id))
        {
            $array_retorno["exito"] = true;
            $array_retorno["mensaje"] = "Se eliminó correctamente el usuario.";
        }
        else
        {
            $array_retorno["exito"] = false;
            $array_retorno["mensaje"] = "No se eliminó correctamente el usuario.";
        }
        var_dump($array_retorno);
        break;
}

?>