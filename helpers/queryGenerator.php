<?php

class SQLQuery{
    private $tabla;
    private $order;
    private $sortby;
    private $page;
    private $limit;
    private $condition;

    public function __construct($tabla=null, $order=null, $sortby=null, $page=null, $limit=null, $condition=null){
        $this->tabla = $tabla;
        $this->order = $order;
        $this->sortby = $sortby;
        $this->page = $page;
        $this->limit = $limit;
        $this->condition = $condition;
    }

    public function generarQuery(){
        $query = "SELECT * FROM $this->tabla";
        foreach($this->condition as $clave => $valor){
            if(empty($valor))
                unset($this->condition[$clave]);
        }
        if(!empty($this->condition)){
            $query.= " WHERE";
            foreach($this->condition as $clave => $valor){
                if(isset($valor))
                    $query.= " $clave = :$clave AND";
            }
            $query = substr($query, 0, -4);
        }
        if(isset($this->order))
            $query.= isset($this->sortby) ? " ORDER BY :order :sortby" : " ORDER BY :order ASC";
        if(isset($this->limit))
            $query.= isset($this->page) ? " LIMIT :limit OFFSET :page" : " LIMIT :limit";
        return $query;
    }
}