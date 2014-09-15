<?php

if (!isset($_POST['accion'])) {
    header('Location:../');
}
require_once '../modelo/Conexion.php';
$obj_conexion = new Conexion();
$accion       = $_POST['accion'];

if (isset($_POST['id_region'])) {
    $id_region = $_POST['id_region'];
}

if (isset($_POST['nombre_region'])) {
    $nombre_region = $_POST['nombre_region'];
}

switch ($accion) {
    case 'Registrar':
        $sql_b       = "SELECT 1 FROM region WHERE id_region = '$id_region';";
        $total_filas = $obj_conexion->totalFilas($sql_b);
        if ($total_filas == 0) {
          $sql = "INSERT INTO region(id_region, nombre_region) VALUES ('$id_region', '$nombre_region');";

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
     $sql = "UPDATE region
                SET nombre_region = '$nombre_region'
                WHERE id_region = '$id_region';";

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
        $sql       = "SELECT nombre_region FROM region WHERE id_region = '$id_region';";
       
        $registros = $obj_conexion->RetornarRegistros($sql);
        echo $registros[0]['nombre_region'];
        break;
}

