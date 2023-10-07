<?php

require_once("C:/xampp/htdocs/prog_3/practica/backend/clases/Usuario.php");

$id = $_POST["id"];
$nombre = $_POST["nombre"];
$correo = $_POST["correo"];
$clave = $_POST["clave"];
$id_perfil = $_POST["id_perfil"];
$array_retorno = array();

$usuario = new Usuario($id, $nombre, $correo, $clave, $id_perfil, "bob el constructor");

if($usuario->Modificar())
{
    $array_retorno["exito"] = true;
    $array_retorno["mensaje"] = "Se modificó correctamente el usuario.";
}
else
{
    $array_retorno["exito"] = true;
    $array_retorno["mensaje"] = "No se modificó correctamente el usuario.";
}
var_dump($array_retorno);

?>