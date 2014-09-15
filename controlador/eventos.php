<?php

if (!isset($_POST['accion'])) {
    header('Location:../');
}
require_once '../modelo/Conexion.php';
$obj_conexion = new Conexion();
$accion       = $_POST['accion'];

if (isset($_POST['num_registro'])) {
    $num_registro = $_POST['num_registro'];
}
if (isset($_POST['descripcion'])) {
    $descripcion = $_POST['descripcion'];
}
if (isset($_POST['lugar'])) {
    $lugar = $_POST['lugar'];
}
if (isset($_POST['fecha_inicio'])) {
    $fecha_inicio = $_POST['fecha_inicio'];
}
if (isset($_POST['fecha_fin'])) {
    $fecha_fin = $_POST['fecha_fin'];
}
if (isset($_POST['organizadores'])) {
    $organizadores = $_POST['organizadores'];
}
if (isset($_POST['estatus'])) {
    $id_estatus = $_POST['estatus'];
}

switch ($accion) {
    case 'Registrar':
        $sql_b       = "SELECT 1 FROM eventos WHERE descripcion = '$descripcion';";
        $total_filas = $obj_conexion->totalFilas($sql_b);
        if ($total_filas == 0) {
            $fecha_inicio = $obj_conexion->formateaBD($fecha_inicio);
            $fecha_fin    = $obj_conexion->formateaBD($fecha_fin);

            $sql = "INSERT INTO eventos (num_registro, descripcion, lugar, fecha_inicio,  fecha_fin, organizadores, id_estatus)
                                       VALUES ('$num_registro', '$descripcion','$lugar', '$fecha_inicio', '$fecha_fin',  '$organizadores', '$id_estatus');";

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
        $fecha_inicio = $obj_conexion->formateaBD($fecha_inicio);
        $fecha_fin    = $obj_conexion->formateaBD($fecha_fin);

        $sql = "UPDATE eventos
                    SET 
                      descripcion = '$descripcion',
                      lugar = '$lugar',
                      fecha_inicio = '$fecha_inicio',
                      fecha_fin = '$fecha_fin',
                      organizadores = '$organizadores',
                      id_estatus = '$id_estatus'
                    WHERE num_registro = '$num_registro';";

        $resultado = $obj_conexion->_query($sql);
        if ($resultado == TRUE) {
            echo 'exito';
        } else {
            echo 'error';
        }
        break;

    case 'BuscarDatos':
        $sql       = "SELECT
                        descripcion,
                        lugar,
                        DATE_FORMAT(fecha_inicio,'%d/%m/%Y') AS fecha_inicio,
                        DATE_FORMAT(fecha_fin,'%d/%m/%Y') AS fecha_fin,
                        organizadores,
                        id_estatus
                      FROM eventos WHERE num_registro = '$num_registro';";
        $registros = $obj_conexion->RetornarRegistros($sql);
        echo $registros[0]['descripcion'] . ';' .
        $registros[0]['lugar'] . ';' .
        $registros[0]['fecha_inicio'] . ';' .
        $registros[0]['fecha_fin'] . ';' .
        $registros[0]['organizadores'] . ';' .
        $registros[0]['id_estatus'];
        break;
}

