<?php
require_once("C:/xampp/htdocs/prog_3/practica/backend/clases/Usuario.php");

$usuario = new Usuario(1,"Juan", "Juan@admin.com", "2asd2", 1, "vendedor");
$usuarios_json = json_encode($usuario->TraerTodosJSON());
var_dump($usuarios_json);


