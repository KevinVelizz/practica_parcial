<?php
require_once("C:/xampp/htdocs/prog_3/practica/backend/clases/Empleado.php");

$array_empleados = Empleado::TraerTodos();

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
                            <th> foto          </th>
                            <th> sueldo        </th>
                        </tr>
                    </thead>';

foreach ($array_empleados as $user)
{
    $empleados = array();
    $empleados["id"] = $user->id;
    $empleados["correo"] = $user->correo;
    $empleados["clave"] = $user->clave;
    $empleados["nombre"] = $user->nombre;
    $empleados["id_perfil"] = $user->id_perfil;
    $empleados["foto"] = $user->foto;
    $empleados["sueldo"] = $user->sueldo;

    $grilla .= "    <tr>
                        <td>".$user->id."</td>
                        <td>".$user->correo."</td>
                        <td>".$user->clave."</td>
                        <td>".$user->nombre."</td>
                        <td>".$user->id_perfil."</td>
                        <td>".$user->foto."</td>
                        <td>".$user->sueldo."</td>
                    </tr>";
}
$grilla .= '    </table>
            </body>';
echo $grilla;
?>