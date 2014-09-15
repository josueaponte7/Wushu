<?php

if (!isset($_POST['accion'])) {
    header('Location:../');
}
require_once '../modelo/Conexion.php';
$obj_conexion = new Conexion();
$accion       = $_POST['accion'];

if (isset($_POST['id_tecnica'])) {
    $id_tecnica = $_POST['id_tecnica'];
}

if (isset($_POST['nombre_tecnica'])) {
    $nombre_tecnica = $_POST['nombre_tecnica'];
}

switch ($accion) {
    case 'Registrar':
        $sql_b       = "SELECT 1 FROM tecnica WHERE id_tecnica = '$id_tecnica';";
        $total_filas = $obj_conexion->totalFilas($sql_b);
        if ($total_filas == 0) {
         $sql = "INSERT INTO tecnica(id_tecnica, nombre_tecnica) VALUES ('$id_tecnica', '$nombre_tecnica');";

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
     $sql = "UPDATE tecnica
                SET nombre_tecnica = '$nombre_tecnica'
                WHERE id_tecnica = '$id_tecnica';";

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
        $sql       = "SELECT nombre_tecnica FROM tecnica WHERE id_tecnica = '$id_tecnica';";
       
        $registros = $obj_conexion->RetornarRegistros($sql);
        echo $registros[0]['nombre_tecnica'];
        break;
}

