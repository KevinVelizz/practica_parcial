<?php
require_once("C:/xampp/htdocs/prog_3/practica/backend/clases/Usuario.php");

$correo = $_POST["correo"];
$clave = $_POST["clave"];

$usuario_json = json_encode([$correo,$clave]);
$usuario = Usuario::TraerUno($usuario_json);

echo $usuario->nombre;
