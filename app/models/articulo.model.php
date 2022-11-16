<?php

class ModeloArticulo {

    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;'.'dbname=remate;charset=utf8', 'root', '');
    }

    public function obtenerArticulos() {
        $query = $this->db->prepare("SELECT * FROM articulo");
        $query->execute();
        $articulos = $query->fetchAll(PDO::FETCH_OBJ);
        return $articulos;
    }

    public function obtenerArticuloPorID($id) {
        $query = $this->db->prepare("SELECT * FROM articulo WHERE id_articulo = ?");
        $query->execute([$id]);
        $articulo = $query->fetch(PDO::FETCH_OBJ);
        return $articulo;
    }

    public function obtenerArticulosPorCliente($id){
        $query = $this->db->prepare("SELECT * FROM articulo a JOIN cliente c ON c.id_cliente = a.id_cliente AND c.id_cliente = ?");
        $query->execute([$id]);
        $articulos = $query->fetchAll(PDO::FETCH_OBJ);
        return $articulos;
    }

    public function insertar($nombre, $cantidad=null, $valorB=null, $idCliente, $imagen, $descripcion=null) {
        $query = $this->db->prepare("INSERT INTO articulo (imagen, nombre_art, cantidad, valor_base, id_cliente, descripcion) VALUES ('$imagen', :nomb, :cant, :val, :idC, :des)");
        try{
            $query->execute([":nomb"=>$nombre, ":cant"=>$cantidad, ":val"=>$valorB, ":idC"=>$idCliente, ":des"=>$descripcion]);
        }
        catch (PDOException $e){
            var_dump($e);
        }
        return $this->db->lastInsertId();
    }

    public function borrar($id) {
        $query = $this->db->prepare('DELETE FROM articulo WHERE id_articulo = ?');
        $query->execute([$id]);
    }
    
    public function editar($id, $nombre, $cantidad=null, $valorB=null, $idCliente, $imagen, $descripcion=null){
        $query = $this->db->prepare("UPDATE articulo SET imagen='$imagen', nombre_art=?, cantidad=?, valor_base=?, id_cliente=?, descripcion=? WHERE id_articulo=?");
        try{
            $query->execute([$nombre, $cantidad, $valorB, $idCliente, $descripcion, $id]);
        }
        catch (PDOException $e){
            var_dump($e);
        }
        return $this->db->lastInsertId();
    }
}
?>