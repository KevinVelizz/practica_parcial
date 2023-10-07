<?php
require_once("C:/xampp/htdocs/prog_3/practica/backend/clases/Empleado.php");

$correo = $_POST["correo"];
$clave = $_POST["clave"];
$nombre = $_POST["nombre"];
$id_perfil = (int) $_POST["id_perfil"];
$foto = $_FILES["foto"];
$sueldo = (double)$_POST["sueldo"];

$empleado = new Empleado(1, $nombre, $correo, $clave, $id_perfil, "cantante", $foto, $sueldo);
if($empleado->Agregar())
{
    $array_retorno["exito"] = true;
    $array_retorno["mensaje"] = "Se agregó correctamente el usuario.";
}
else
{
    $array_retorno["exito"] = false;
    $array_retorno["mensaje"] = "No se agregó correctamente el usuario.";
}
var_dump($array_retorno);
?>