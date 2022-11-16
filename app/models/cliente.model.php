<?php

class ModeloCliente {

    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;'.'dbname=remate;charset=utf8', 'root', '');
    }

    public function obtenerClientes() {
        $query = $this->db->prepare("SELECT * FROM cliente");
        $query->execute();
        $clientes = $query->fetchAll(PDO::FETCH_OBJ);
        return $clientes;
    }

    public function obtenerClientePorID($id) {
        $query = $this->db->prepare("SELECT * FROM cliente WHERE id_cliente = ?");
        $query->execute([$id]);
        $cliente = $query->fetch(PDO::FETCH_OBJ);
        return $cliente;
    }

    public function insertar($nombre, $apellido, $telefono, $email=null) {
        $query = $this->db->prepare("INSERT INTO cliente (nombre, apellido, telefono, email) VALUES (?, ?, ?, ?)");
        $query->execute([$nombre, $apellido, $telefono, $email]);
        return $this->db->lastInsertId();
    }

    public function borrar($id) {
        $query = $this->db->prepare("DELETE FROM cliente WHERE id_cliente = ?");
        try {$query->execute([$id]);} 
        catch (PDOException $e){}
        return $query->errorCode();
    }

    public function editar($id, $nombre, $apellido, $telefono, $email){
        $query = $this->db->prepare("UPDATE cliente SET nombre=?, apellido=?, telefono=?, email=? WHERE id_cliente=?");
        $query->execute([$nombre, $apellido, $telefono, $email, $id]);
        return $this->db->lastInsertId();
    }

    public function queryGenerica($peticion, $arreglo){
        $query = $this->db->prepare($peticion);
        foreach($arreglo as $clave => $valor){
            $query->bindValue($clave, $valor, ($clave==":limit" || $clave==":page" || $clave==":telefono") ? PDO::PARAM_INT : PDO::PARAM_STR);
        }
/*        
        $clave1 = ":nombre";
        $clave2 = ":apellido";
        $clave3 = ":order";
        $clave4 = ":limit";
        $clave5 = ":page";
        $query->bindParam(':nombre', $arreglo[":nombre"], $clave1==":limit"||$clave1==":page"||$clave1==":telefono" ? PDO::PARAM_INT : PDO::PARAM_STR);
        $query->bindParam(':apellido', $arreglo[":apellido"], $clave2==":limit"||$clave2==":page"||$clave2==":telefono" ? PDO::PARAM_INT : PDO::PARAM_STR);
        $query->bindParam(':order', $arreglo[":order"], $clave3==":limit"||$clave3==":page"||$clave3==":telefono" ? PDO::PARAM_INT : PDO::PARAM_STR);
        $query->bindParam(':limit', $arreglo[":limit"], $clave4==":limit"||$clave4==":page"||$clave4==":telefono" ? PDO::PARAM_INT : PDO::PARAM_STR);
        $query->bindParam(':page', $arreglo[":page"], $clave5==":limit"||$clave5==":page"||$clave5==":telefono" ? PDO::PARAM_INT : PDO::PARAM_STR);
*/      
        $query->execute() or die(print_r($query->errorInfo()));
        $clientes = $query->fetchAll(PDO::FETCH_OBJ);
        return $clientes;
    }
}
?>