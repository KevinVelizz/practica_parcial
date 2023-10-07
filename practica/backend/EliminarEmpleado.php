<?php
require_once("./clases/empleado.php");

$id = $_POST["id"];

if(Empleado::Eliminar($id))
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
?>