<?php
require_once("C:/xampp/htdocs/prog_3/practica/backend/clases/Usuario.php");
require_once('C:/xampp/htdocs/prog_3/practica/backend/clases/ICRUD.php');

class Empleado extends Usuario implements ICRUD
{
    public array $foto;
    public float $sueldo;
    
    public function __construct($id, $nombre, $correo, $clave, $id_perfil, $perfil, $foto, $sueldo)
    {
        parent::__construct($id, $nombre, $correo, $clave, $id_perfil, $perfil);
        $this->foto = $foto;
        $this->sueldo = $sueldo;
    }

    public static function TraerTodos(): array
    {

        try
        {
            $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test","root","");
            $array_usuarios = array();
            $sql = $pdo->query("SELECT * FROM empleados 
                                INNER JOIN perfiles ON empleados.id_perfil = perfiles.id");
            if ($sql != false)
            {
                $resultado = $sql->fetchAll();
                foreach($resultado as $value)
                {
                    $usuario = new Empleado($value["id"], $value["nombre"], $value["correo"], $value["clave"], $value["id_perfil"], $value['descripcion'], $value["foto"], $value["sueldo"]);
                    $array_usuarios[] = $usuario;
                }
            }
        }catch(PDOException $e)
        {
            echo $e->getMessage();
        }
        return $array_usuarios;
    }

    public function Agregar() : bool
    {
        $retorno = false;   
        $destinoCarpeta = "./empleados/fotos/";
        $pathImage = $this->foto["name"];
        $destino = $destinoCarpeta . $pathImage;
        $hora_actual = date("His");
        $tipoArchivo = pathinfo($destino, PATHINFO_EXTENSION);
        $destino = $destinoCarpeta . "{$this->nombre}.{$hora_actual}.{$tipoArchivo}";
        move_uploaded_file($this->foto["tmp_name"] , $destino);
        try
        {
            $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test","root","");
            $correo = $this->correo;
            $clave = $this->clave;
            $nombre = $this->nombre;
            $id_perfil = $this->id_perfil;
            $sueldo = $this->sueldo;
            $sql = $pdo->prepare("INSERT INTO empleados(correo, clave, nombre, id_perfil, foto, sueldo) VALUES (:correo, :clave, :nombre, :id_perfil, :foto, :sueldo)");
            $sql->bindParam(':correo', $correo, PDO::PARAM_STR,50);
            $sql->bindParam(':clave', $clave, PDO::PARAM_STR,8);
            $sql->bindParam(':nombre', $nombre, PDO::PARAM_STR,30);
            $sql->bindParam(':id_perfil', $id_perfil, PDO::PARAM_INT,10);
            $sql->bindParam(':foto', $destino, PDO::PARAM_STR,50);
            $sql->bindParam(':sueldo', $sueldo, PDO::PARAM_INT);
            $sql->execute();
            $retorno = true;

        }catch(PDOException $e)
        {
            echo $e->getMessage();
            $retorno = false;
        }
        return $retorno;

    }

    public function Modificar(): bool
    {
        $retorno = false;
        if (count($this->foto) > 0)
        {
            $destinoCarpeta = "./empleados/fotos/";
            $pathImage = $this->foto["name"];
            $destino = $destinoCarpeta . $pathImage;
            $hora_actual = date("His");
            $tipoArchivo = pathinfo($destino, PATHINFO_EXTENSION);
            $destino = $destinoCarpeta . "{$this->nombre}.{$hora_actual}.{$tipoArchivo}";
            move_uploaded_file($this->foto["tmp_name"] , $destino);
        }
        else
        {
            $destino = "";
        }
        try
        {
            $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test","root","");
            $sql = $pdo->prepare("UPDATE empleados SET correo = :correo, clave = :clave, nombre = :nombre, id_perfil = :id_perfil, foto = :foto, sueldo = :sueldo WHERE id = :id");
            $sql->bindParam(':id', $id, PDO::PARAM_INT);
            $sql->bindParam(':correo', $correo, PDO::PARAM_STR,50); 
            $sql->bindParam(':clave', $clave, PDO::PARAM_STR,8); 
            $sql->bindParam(':nombre', $nombre, PDO::PARAM_STR,30);
            $sql->bindParam(':id_perfil', $id_perfil, PDO::PARAM_INT,10);
            $sql->bindParam(':foto', $destino, PDO::PARAM_STR,50);
            $sql->bindParam(':sueldo', $sueldo, PDO::PARAM_INT);
            $sql->execute(); 
            $retorno = true;
        }catch(PDOException $e)
        {
            echo $e->getMessage();
        }
        return $retorno;
        return true;
    }

    public static function Eliminar($id): bool
    {
        $retorno = false;
        try
        {
            $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test","root","");
            $sql = $pdo->prepare("DELETE FROM empleados WHERE id = :id");
            $sql->bindParam(':id', $id, PDO::PARAM_INT, 10);
            $sql->execute(); 
            $retorno = true;
        }catch(PDOException $e)
        {
            echo $e->getMessage();
        }
        return $retorno;
    }

}


?>