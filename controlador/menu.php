<?php

if (!isset($_POST['accion'])) {
    header('Location:../');
}
require_once '../modelo/Conexion.php';
$obj_conexion = new Conexion();
$accion       = $_POST['accion'];

if (isset($_POST['id_menu'])) {
    $id_menu = $_POST['id_menu'];
}

if (isset($_POST['menu'])) {
    $menu = $_POST['menu'];
}

switch ($accion) {
    case 'Registrar':
        $sql_b       = "SELECT 1 FROM menu WHERE id_menu = '$id_menu';";
        $total_filas = $obj_conexion->totalFilas($sql_b);
        if ($total_filas == 0) {
           $sql = "INSERT INTO menu(id_menu, menu) VALUES ('$id_menu', '$menu');";

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
       $sql = "UPDATE menu
                SET menu = '$menu'
                WHERE id_menu = '$id_menu';";

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
        $sql       = "SELECT menu FROM menu WHERE id_menu = '$id_menu';";
       
        $registros = $obj_conexion->RetornarRegistros($sql);
        echo $registros[0]['menu'];
        break;
}

