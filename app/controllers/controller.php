<?php

require_once "./app/views/api.view.php";

abstract class Controller{
    protected ApiView $view;
    private $data;

    public function __construct(){
        $this->view = new ApiView();
        $this->data = file_get_contents("php://input");
    }

    protected function obtenerDatos(){
        return json_decode($this->data);
    }

    abstract public function get($params = null);
    abstract public function getPorId($params = null);

    abstract public function put($params = null);
    abstract public function post($params = null);
    //abstract public function delete($params = null);

    
}


?>