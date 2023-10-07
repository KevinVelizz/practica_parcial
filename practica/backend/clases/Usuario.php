<?php
require_once('C:/xampp/htdocs/prog_3/practica/backend/clases/IBM.php');

class Usuario implements IBM
{
    public int $id;
    public string $nombre;
    public string $correo;
    public string $clave;
    public int $id_perfil;
    public string $perfil;

    public function __construct(int $id, string $nombre, string $correo, string $clave, int $id_perfil, string $perfil) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->clave = $clave;
        $this->id_perfil = $id_perfil;
        $this->perfil = $perfil;
    }

    public function toJSON()
    {
        $datosUsuario = array();
        $datosUsuario["id"] = $this->id;
        $datosUsuario["nombre"] = $this->nombre;
        $datosUsuario["correo"] = $this->correo;
        $datosUsuario["clave"] = $this->clave;
        $datosUsuario["id_perfil"] = $this->id_perfil;
        $datosUsuario["perfil"] = $this->perfil;
        return json_encode($datosUsuario);
    }

    public function GuardarEnArchivo() : string | false
    {
        $usuarios_obtenidos = [];
        $array_retorno = [];
        if (file_exists('C:/xampp/htdocs/prog_3/practica/backend/archivos/usuarios.json')) {
            $usuarios_obtenidos = json_decode(file_get_contents('C:/xampp/htdocs/prog_3/practica/backend/archivos/usuarios.json'), true);
        }

        $usuarioNuevo = $this->toJSON(); 
        $usuarios_obtenidos[] = json_decode($usuarioNuevo, true); 
        $usuariosJSON = json_encode($usuarios_obtenidos);

        if (file_put_contents('C:/xampp/htdocs/prog_3/practica/backend/archivos/usuarios.json', $usuariosJSON)) {
            $array_retorno["exito"] = true;
            $array_retorno["mensaje"] = "Se agregó correctamente el usuario.";
        } else {
            $array_retorno["exito"] = false;
            $array_retorno["mensaje"] = "No se agregó correctamente el usuario. Verificar";
        }
        return json_encode($array_retorno);
    }

    public function TraerTodosJSON() : array
    {
        $usuarios_obtenidos = [];
        $array_retorno = array();
        if (file_exists("C:/xampp/htdocs/prog_3/practica/backend/archivos/usuarios.json"))
        {
            $usuarios_obtenidos = json_decode((file_get_contents("C:/xampp/htdocs/prog_3/practica/backend/archivos/usuarios.json")), true);
            foreach ($usuarios_obtenidos as $usuarioData) 
            {
                $usuario = new Usuario($usuarioData['id'], $usuarioData['nombre'], $usuarioData['correo'], $usuarioData["clave"], $usuarioData["id_perfil"], $usuarioData["perfil"]);
                $array_retorno[] = $usuario;
            }
        }
        return $array_retorno;
    }

    public function Agregar() : bool
    {
        try
        {
            $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test","root","");
            
            $correo = $this->correo;
            $clave = $this->clave;
            $nombre = $this->nombre;
            $id_perfil = $this->id_perfil;

            $sql = $pdo->prepare("INSERT INTO `usuarios`(`correo`, `clave`, `nombre`, `id_perfil`) VALUES (:correo, :clave, :nombre, :id_perfil)");
            $sql->bindParam(':correo', $correo, PDO::PARAM_STR,50); // Vincular el valor entre la variable y el parametro :id 
            $sql->bindParam(':clave', $clave, PDO::PARAM_STR,8);
            $sql->bindParam(':nombre', $nombre, PDO::PARAM_STR,30);
            $sql->bindParam(':id_perfil', $id_perfil, PDO::PARAM_INT,10);
            $sql->execute();
            echo "Se agregó";
            return true;

        }catch(PDOException $e)
        {
            echo $e->getMessage();
            return false;
        }
    }
    public static function TraerTodos() : array
    {
        try
        {
            $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test","root","");
            $array_usuarios = array();
            $sql = $pdo->query("SELECT * FROM usuarios 
                                INNER JOIN perfiles ON usuarios.id_perfil = perfiles.id");
            if ($sql != false)
            {
                $resultado = $sql->fetchAll();
                foreach($resultado as $value)
                {
                    $usuario = new Usuario($value["id"], $value["nombre"], $value["correo"], $value["clave"], $value["id_perfil"], $value['descripcion']);
                    $array_usuarios[] = $usuario;
                }
            }
        }catch(PDOException $e)
        {
            echo $e->getMessage();
        }
        return $array_usuarios;
    }

    public static function TraerUno($params) : Usuario
    {
        try
        {
            $params = json_decode($params);
            $correo = $params[0];
            $clave = $params[1];
            $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test","root","");
            $sql = $pdo->prepare("SELECT * FROM usuarios 
            INNER JOIN perfiles ON usuarios.id_perfil = perfiles.id WHERE correo = :correo AND clave = :clave");
            $sql->bindParam(':correo', $correo, PDO::PARAM_STR,50); 
            $sql->bindParam(':clave', $clave, PDO::PARAM_STR,8); 
            $sql->execute();
            $fila = $sql->fetch();
            
            if ($fila !== false)
            {
                $usuario = new Usuario($fila["id"], $fila["nombre"], $fila["correo"], $fila["clave"], $fila["id_perfil"], $fila["descripcion"]);
            }
        }catch(PDOException $e)
        {
            echo $e->getMessage();
        }
        return $usuario;
    }

    public function Modificar() : bool {
        $retorno = false;
        try
        {
            $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test","root","");
            $sql = $pdo->prepare("UPDATE usuarios SET correo = :correo, clave = :clave, nombre = :nombre, id_perfil = :id_perfil WHERE id = :id");
            $sql->bindParam(':id', $this->id, PDO::PARAM_INT);
            $sql->bindParam(':correo', $this->correo, PDO::PARAM_STR,50); 
            $sql->bindParam(':clave', $this->clave, PDO::PARAM_STR,8); 
            $sql->bindParam(':nombre', $this->nombre, PDO::PARAM_STR,30);
            $sql->bindParam(':id_perfil', $this->id_perfil, PDO::PARAM_INT,10);
            $sql->execute(); 
            $retorno = true;

        }catch(PDOException $e)
        {
            echo $e->getMessage();
        }
        return $retorno;
    }

    public static function Eliminar($id) : bool {
        $retorno = false;
        try
        {
            $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test","root","");
            $sql = $pdo->prepare("DELETE FROM usuarios WHERE id = :id");
            $sql->bindParam(':id', $id, PDO::PARAM_INT);
            $sql->execute(); // Internamente dentro de la variable sql el valor de la petición.
            $retorno = true;
        }catch(PDOException $e)
        {
            echo $e->getMessage();
        }
        return $retorno;
    }
}
?>