<?php

if (!isset($_POST['accion'])) {
    header('Location:../');
}
require_once '../modelo/Conexion.php';
$obj_conexion = new Conexion();
$accion       = $_POST['accion'];

if (isset($_POST['id_submenu'])) {
    $id_submenu= $_POST['id_submenu'];
}

if (isset($_POST['menu'])) {
    $id_menu = $_POST['menu'];
}

if (isset($_POST['sub_menu'])) {
    $sub_menu = $_POST['sub_menu'];
}

if (isset($_POST['url'])) {
    $url = $_POST['url'];
}

if (isset($_POST['estatus'])) {
    $estatus = $_POST['estatus'];
}

switch ($accion) {
    case 'Registrar':
        $sql_b       = "SELECT 1 FROM sub_menu WHERE id_submenu = '$id_submenu';";
        $total_filas = $obj_conexion->totalFilas($sql_b);
        if ($total_filas == 0) {
            
        $sql   = "INSERT INTO sub_menu(id_submenu, sub_menu, id_menu, url, estatus) VALUES ('$id_submenu', '$sub_menu', '$id_menu', '$url', '$estatus');";

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
       $sql   = "UPDATE wushu.sub_menu
                    SET id_submenu = '$id_submenu',
                      sub_menu = '$sub_menu',
                      id_menu = '$id_menu',
                      url = '$url',
                      estatus = '$estatus'
                    WHERE id_submenu = '$id_submenu';";

        $resultado = $obj_conexion->_query($sql);
        if ($resultado == TRUE) {
            echo 'exito';
        } else {
            echo 'error';
        }
        break;

    case 'BuscarDatos':        
        $sql       = "SELECT  sub_menu,  id_menu,  url,  estatus FROM sub_menu WHERE id_submenu = $id_submenu";
        $registros = $obj_conexion->RetornarRegistros($sql);
        echo $registros[0]['id_menu']. ';' .
        $registros[0]['sub_menu']. ';' .
        $registros[0]['url']. ';' .
        $registros[0]['estatus'];      
        break;
}
