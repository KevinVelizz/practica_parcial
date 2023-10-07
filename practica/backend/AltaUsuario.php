<?php
require_once("C:/xampp/htdocs/prog_3/practica/backend/clases/Usuario.php");

$correo = $_POST["correo"];
$clave = $_POST["clave"];
$nombre = $_POST["nombre"];
$id_perfil = $_POST["id_perfil"];

$usuario = new Usuario(1,$nombre,$correo,$clave,$id_perfil,"a");

if ($usuario->Agregar())
{
    echo true . " - Se agregó";
}
else
{
    echo false . " - No se agregó";
}
