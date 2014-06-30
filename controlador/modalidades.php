<?php

if (!isset($_POST['accion'])) {
    header('Location:../');
}
require_once '../modelo/Conexion.php';
$obj_conexion = new Conexion();
$accion       = $_POST['accion'];

if (isset($_POST['descripcion'])) {
    $descripcion = $_POST['descripcion'];
}

if (isset($_POST['estatus'])) {
    $estatus = $_POST['estatus'];
}

switch ($accion) {
    case 'Registrar':
        $sql_b       = "SELECT 1 FROM modalidades WHERE descripcion = '$descripcion';";
        $total_filas = $obj_conexion->totalFilas($sql_b);
        if ($total_filas == 0) {
            $sql = "INSERT INTO modalidades(descripcion,estatus) VALUES ('$descripcion','$estatus');";

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
        $sql = "UPDATE modalidades
                SET 
                  descripcion = '$descripcion',
                  estatus = '$estatus'
                WHERE descripcion = '$descripcion';";

        $resultado = $obj_conexion->_query($sql);
        if ($resultado == TRUE) {
            echo 'exito';
        } else {
            echo 'error';
        }
        break;

    case 'BuscarDatos':
        $sql       = "SELECT  descripcion,   estatus  FROM modalidades WHERE descripcion='$descripcion'";
        $registros = $obj_conexion->RetornarRegistros($sql);
        echo $registros[0]['descripcion'] . ';' .
        $registros[0]['estatus'];
        break;
}