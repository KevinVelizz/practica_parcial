<?php
require_once("C:/xampp/htdocs/prog_3/practica/backend/clases/Usuario.php");

$array_usuarios = Usuario::TraerTodos();

$grilla = '
            <html>
            <head>
                <title>Listado de Usuarios</title>
            </head>
            <body>
                <table class="table" border="1" align="center">
                    <thead>
                        <tr>
                            <th> id            </th>
                            <th> correo        </th>
                            <th> clave         </th>
                            <th> nombre        </th>
                            <th> id_perfil     </th>
                        </tr>
                    </thead>';

foreach ($array_usuarios as $user)
{
    $usuario = array();
    $usuario["id"] = $user->id;
    $usuario["correo"] = $user->correo;
    $usuario["clave"] = $user->clave;
    $usuario["nombre"] = $user->nombre;
    $usuario["id_perfil"] = $user->id_perfil;

    $grilla .= "    <tr>
                        <td>".$user->id."</td>
                        <td>".$user->correo."</td>
                        <td>".$user->clave."</td>
                        <td>".$user->nombre."</td>
                        <td>".$user->id_perfil."</td>
                    </tr>";
}

$grilla .= '    </table>
            </body>';
echo $grilla;
?>