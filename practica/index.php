<?php
require_once("./backend/clases/Usuario.php");
$opcion = $_POST["opcion"];
$usuario = new Usuario(1,"Juan", "Juan@admin.com", "2asd2", 1, "vendedor");
switch($opcion)
{
    case "agregar":
        $mensaje = json_decode($usuario->GuardarEnArchivo());
        echo $mensaje->exito . " - " . $mensaje->mensaje;
        break;

    case "listar":
        $usuarios = $usuario->TraerTodosJSON();
        foreach($usuarios as $usuario)
        {
            echo $usuario->id . " - " . $usuario->nombre . " - " . $usuario->correo . "\n";
        }
        break;

    case "agregar_db":
        
        $retorno = $usuario->Agregar();
        if($retorno)
        {
            echo "Se agregó correctamente a la base de datos.";
        }
        else
        {
            echo "No se agregó correctamente a la base de datos. Verifique.";
        }
        break;

    case "traer_db":
        $usuarios = Usuario::TraerTodos();
        foreach($usuarios as $usaurio_db)
        {
            echo $usaurio_db->id . " - " . $usaurio_db->nombre . " - " . $usaurio_db->perfil . "\n";
        }
        break;
    case "TraerUno_db":
        $correo = $_POST["correo"];
        $clave = $_POST["clave"];

        $params = array();
        $params["correo"] = $correo;
        $params["clave"] = $clave;
        
        $usuario_nuevo = Usuario::TraerUno($params);
        echo $usuario_nuevo->id . " - " . $usuario_nuevo->nombre . " - " . $usuario_nuevo->perfil;
        break;
}
?>