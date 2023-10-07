<?php
interface ICRUD
{
    public static function TraerTodos():array;
    public function Agregar():bool;
    public function Modificar():bool;
    public static function Eliminar($id):bool;
}
?>