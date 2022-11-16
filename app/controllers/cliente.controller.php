<?php
require_once "controller.php";
require_once "./app/models/cliente.model.php";
require_once "./helpers/queryGenerator.php";

class ControllerCliente extends Controller{
    private ModeloCliente $model;

    public function __construct(){
        parent::__construct();
        $this->model = new ModeloCliente();
    }

    public function get($params = null){
        if(count($_GET)>1){
            $parametros = [
                "resource" => null,
                "order" => null,
                "sortby" => null,
                "page" => null,
                "limit" => null,
                "condition" => [
                    "nombre" => null,
                    "apellido" => null,
                    "email" => null,
                    "telefono" => null,
                ],
            ];
            $arregloDeValores = [];
            foreach($_GET as $clave => $valor){
                $claveLowercase = strtolower($clave);
                if(array_key_exists($claveLowercase, $parametros)){
                    $parametros[$claveLowercase] = $valor;
                }
                else{
                    if(array_key_exists($claveLowercase, $parametros["condition"]))
                        $parametros["condition"][$claveLowercase] = $valor;
                    else{
                        $this->view->response("La clave $claveLowercase no existe", 404);
                        return;
                    }
                }
                $claveLowercase=="page" ? $arregloDeValores[":".$claveLowercase] = $valor*$parametros["limit"] : $arregloDeValores[":".$claveLowercase] = $valor;
            }
            if($parametros["page"]<0 || $parametros["limit"]<0){
                $this->view->response("Limites de paginacion mal definidos", 400);
                return;
            }
            $query = new SQLQuery("cliente", $parametros["order"], $parametros["sortby"], $parametros["page"], $parametros["limit"], $parametros["condition"]);
            if($query==-1){
                $this->view->response("Limites de paginacion mal definidos", 400);
                return;
            }
            unset($arregloDeValores[":resource"]);
            $clientes = $this->model->queryGenerica($query->generarQuery(), $arregloDeValores);
        }
        else
            $clientes = $this->model->obtenerClientes();
        $this->view->response($clientes, 200);
    }

    public function getPorId($params = null){
        $id = $params[':id'];
        $cliente = $this->model->obtenerClientePorID($id);
        if ($cliente)
            $this->view->response($cliente, 200);
        else 
            $this->view->response("El cliente con el id=$id no existe", 404);
    }

    public function post($params = null) {
        $cliente = $this->obtenerDatos();
        if (empty($cliente->nombre) || empty($cliente->apellido) || empty($cliente->telefono)) {
            $this->view->response("Complete los datos", 400);
        } else {
            $id = $this->model->insertar($cliente->nombre, $cliente->apellido, $cliente->telefono, $cliente->email);
            $cliente = $this->model->obtenerClientePorID($id);
            $this->view->response($cliente, 201);
        }
    }

    public function put($params = null){
        $id = $params[':id'];
        $cliente = $this->obtenerDatos();
        if (empty($cliente->nombre) || empty($cliente->apellido) || empty($cliente->telefono)) {
            $this->view->response("Complete los datos", 400);
        }
        else {
            $id = $this->model->editar($id, $cliente->nombre, $cliente->apellido, $cliente->telefono, $cliente->email);
            $cliente = $this->model->obtenerClientePorID($id);
            $this->view->response($cliente, 201);
        }
    }

}