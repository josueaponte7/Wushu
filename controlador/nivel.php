<?php

if (!isset($_POST['accion'])) {
    header('Location:../');
}
require_once '../modelo/Conexion.php';
$obj_conexion = new Conexion();
$accion       = $_POST['accion'];

if (isset($_POST['id_nivel'])) {
    $id_nivel = $_POST['id_nivel'];
}

if (isset($_POST['nombre_nivel'])) {
    $nombre_nivel = $_POST['nombre_nivel'];
}

switch ($accion) {
    case 'Registrar':
        $sql_b       = "SELECT 1 FROM nivel WHERE id_nivel = '$id_nivel';";
        $total_filas = $obj_conexion->totalFilas($sql_b);
        if ($total_filas == 0) {
          $sql = "INSERT INTO nivel(id_nivel,nivel) VALUES ('$id_nivel', '$nombre_nivel');";

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
     $sql = "UPDATE nivel
                SET nivel = '$nombre_nivel'
                WHERE id_nivel = '$id_nivel';";

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
        $sql       = "SELECT nivel FROM nivel WHERE id_nivel = '$id_nivel';";
       
        $registros = $obj_conexion->RetornarRegistros($sql);
        echo $registros[0]['nivel'];
        break;
}

