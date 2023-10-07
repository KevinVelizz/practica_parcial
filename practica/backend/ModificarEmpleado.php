<?php
require_once("C:/xampp/htdocs/prog_3/practica/backend/clases/empleado.php");

$id = $_POST["id"];
$correo = $_POST["correo"];
$clave = $_POST["clave"];
$nombre = $_POST["nombre"];
$id_perfil = $_POST["id_perfil"];
$foto = isset($_FILES["foto"]) ? $_FILES["foto"] : array();
$sueldo =(double)$_POST["sueldo"];

$empleado = new Empleado($id,$nombre, $correo, $clave, $id_perfil, "obrero", $foto, $sueldo);    

if($empleado->Modificar())
{
    $array_retorno["exito"] = true;
    $array_retorno["mensaje"] = "Se modificó correctamente el usuario.";
}
else
{
    $array_retorno["exito"] = false;
    $array_retorno["mensaje"] = "No se modificó correctamente el usuario.";
}
var_dump($array_retorno);

?>