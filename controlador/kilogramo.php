<?php

if (!isset($_POST['accion'])) {
    header('Location:../');
}
require_once '../modelo/Conexion.php';
$obj_conexion = new Conexion();
$accion       = $_POST['accion'];

if (isset($_POST['id_kilos'])) {
    $id_kilos = $_POST['id_kilos'];
}

if (isset($_POST['kilos'])) {
    $kilos = $_POST['kilos'];
}

switch ($accion) {
    case 'Registrar':
        $sql_b       = "SELECT 1 FROM kilogramos WHERE id_kilos = '$id_kilos';";
        $total_filas = $obj_conexion->totalFilas($sql_b);
        if ($total_filas == 0) {
          $sql = "INSERT INTO kilogramos(id_kilos, kilos) VALUES ('$id_kilos', '$kilos');";

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
     $sql = "UPDATE kilogramos
                SET kilos = '$kilos'
                WHERE id_kilos = '$id_kilos';";

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
        $sql       = "SELECT  kilos FROM kilogramos WHERE id_kilos = $id_kilos;";
     
        $registros = $obj_conexion->RetornarRegistros($sql);
        echo $registros[0]['kilos'];
        break;
}

