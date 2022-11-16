<?php

class ModeloUsuario {

    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;'.'dbname=remate;charset=utf8', 'root', '');
    }

    public function obtenerUsuarioPorEmail($email){
        $query = $this->db->prepare("SELECT * FROM usuario WHERE email=?");
        $query->execute([$email]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function insertar($email, $pass){
        $query = $this->db->prepare("INSERT INTO usuario (email, pass) VALUES (?, ?)");
        $query->execute([$email, $pass]);
        return $this->db->lastInsertId();
    }

}

?>