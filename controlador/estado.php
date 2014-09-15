<?php

if (!isset($_POST['accion'])) {
    header('Location:../');
}
require_once '../modelo/Conexion.php';
$obj_conexion = new Conexion();
$accion       = $_POST['accion'];

if (isset($_POST['id_estado'])) {
    $id_estado = $_POST['id_estado'];
}

if (isset($_POST['estado'])) {
    $estado = $_POST['estado'];
}

if (isset($_POST['cod_telefono'])) {
    $cod_telefono = $_POST['cod_telefono'];
}

switch ($accion) {
    case 'Registrar':
        $sql_b       = "SELECT 1 FROM estado WHERE id_estado = '$id_estado';";
        $total_filas = $obj_conexion->totalFilas($sql_b);
        if ($total_filas == 0) {
          $sql = "INSERT INTO estado (id_estado, estado, cod_telefono)VALUES ('$id_estado', '$estado', '$cod_telefono');";

            $resultado = $obj_conexion->_query($sql);
            if ($resultado == TRUE) {
                echo 'exito';
            } else {
                echo 'error';
            }
        } else {
            echo 'Regitro existe';
        }
        break;

    case 'Modificar':
     $sql = "UPDATE estado
            SET id_estado = '$id_estado',
              estado = '$estado',
              cod_telefono = '$cod_telefono'
            WHERE id_estado = '$id_estado';";

        $resultado = $obj_conexion->_query($sql);
        if ($resultado == TRUE) {
            echo 'exito';
        } else {
            echo 'error';
        }
        break;

//    case 'Eliminar':
//        
//         $sql = "UPDATE asociaciones SET  condicion = 0 WHERE nombre = $nombre;";
//
//        $resultado = $obj_conexion->_query($sql);
//        return $resultado;        
//        break;

    case 'BuscarDatos':
        $sql       = "SELECT estado,  cod_telefono FROM estado WHERE id_estado = $id_estado;";
       
        $registros = $obj_conexion->RetornarRegistros($sql);
        echo $registros[0]['estado']. ';' . $registros[0]['cod_telefono'];
        break;
}

