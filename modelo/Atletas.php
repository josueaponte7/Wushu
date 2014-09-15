<?php
require_once './Conexion.php';

class Atletas extends Conexion {
    
    public function __construct() {
    }
    
    
     public function  getNivel($where = 1) {
        $where = ' WHERE ' . $where;
        $sql   = "SELECT  id_nivel,  nivel FROM nivel_academico" . $where;

        $resultado = $this->RetornarRegistros($sql);
        return $resultado;
    }
    
    
    
}
