<?php

class Conexion
{
    private static $_server   = 'localhost';
    private static $_user     = 'root';
    private static $_password = '123456';
    protected $bd             = 'wushu';
    public function __construct() {
        
    }

    private function __wakeup() {
        
    }

    public static function crear() {
        if (!(self::$_instancia instanceof self)) {
            self::$_instancia = new self();
        }
        return self::$_instancia;
    }

    private function _abrir_conn() {
        // conectarse a mysql
        $this->_conn = new mysqli(self::$_server, self::$_user, self::$_password, $this->bd);
        // verificar error
        if ((int) $this->_conn->connect_errno == 0) {
            $this->_state_conn = TRUE;
            $this->_conn->set_charset('utf8');
            return $this->_conn;
        }
    }

    public function _query($sql) {
        $this->_abrir_conn();
        if ($this->_state_conn === TRUE) {
            $resultado = $this->_conn->query($sql);
            if($resultado){
                return $resultado;
            }else{
                return FALSE;
            }
        }
        $this->_cerrar_conn(); 
    }
    
    public function totalFilas($sql) {
        $result = $this->_query($sql);
        if ($this->_state_conn === TRUE) {
            $total = $result->num_rows;
            return $total;
        }
    }
    public function RetornarRegistros($sql) {
        $result = $this->_query($sql);
        if ($this->_state_conn === TRUE) {
            
             $count = $result->num_rows;
            if($count > 0){
            while ($row =$result->fetch_array()) {
                $rows[] = $row;
            }
            return $rows;
            }else{
                return FALSE;
            }
        }
    }
    private function _cerrar_conn() {
        $this->_conn->close();
    }   
    
     public function formateaBD($fecha)
    {
        $fechaesp      = preg_split('/[\/-]+/', $fecha);
        $revertirfecha = array_reverse($fechaesp);
        $fechabd       = implode('-', $revertirfecha);
        return $fechabd;
    }
    
}
