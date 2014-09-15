<?php

if (!isset($_POST['accion'])) {
    header('Location:../');
}
require_once '../modelo/Conexion.php';
$obj_conexion = new Conexion();
$accion       = $_POST['accion'];

if (isset($_POST['id_codigo'])) {
    $id_codigo = $_POST['id_codigo'];
}

if (isset($_POST['cod_area'])) {
    $cod_area = $_POST['cod_area'];
}

if (isset($_POST['tipo_codigo'])) {
    $tipo_codigo = $_POST['tipo_codigo'];
}

switch ($accion) {
    case 'Registrar':
        $sql_b       = "SELECT 1 FROM codigo_telefono WHERE codigo = '$cod_area' AND tipo=$tipo_codigo;";
        $total_filas = $obj_conexion->totalFilas($sql_b);
        if ($total_filas == 0) {
          $sql = "INSERT INTO codigo_telefono (id, codigo, tipo)VALUES ('$id_codigo', '$cod_area', '$tipo_codigo');";

            $resultado = $obj_conexion->_query($sql);
            if ($resultado == TRUE) {
                echo 'exito';
            } else {
                echo 'error';
            }
        } else {
            echo 'existe';
        }
        break;

    case 'Modificar':
     $sql = "UPDATE codigo_telefono
            SET codigo = '$cod_area',
              tipo = '$tipo_codigo'
            WHERE id = '$id_codigo';";
        
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


