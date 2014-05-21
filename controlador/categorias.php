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
if (isset($_POST['edad'])) {
    $edad = $_POST['edad'];
}
if (isset($_POST['sexo'])) {
    $sexo = $_POST['sexo'];
}
if (isset($_POST['modalidad'])) {
    $modalidad = $_POST['modalidad'];
}
if (isset($_POST['estilo'])) {
    $id_estilo = $_POST['estilo'];
}
if (isset($_POST['region'])) {
    $id_region = $_POST['region'];
}
if (isset($_POST['tecnica'])) {
    $id_tecnica = $_POST['tecnica'];
}
if (isset($_POST['estatus'])) {
    $estatus = $_POST['estatus'];
}

switch ($accion) {
    case 'Registrar':
        $sql_b       = "SELECT 1 FROM categorias WHERE descripcion = '$descripcion';";
        $total_filas = $obj_conexion->totalFilas($sql_b);
        if ($total_filas == 0) {
            $sql = "INSERT INTO categorias (descripcion, edad, sexo,  modalidad,  id_estilo, id_region, id_tecnica,  estatus)
                                          VALUES ('$descripcion', '$edad',  '$sexo', '$modalidad', '$id_estilo',  '$id_region', '$id_tecnica', '$estatus');";

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
        $sql = "UPDATE categorias
                        SET 
                          descripcion = '$descripcion',
                          edad = '$edad',
                          sexo = '$sexo',
                          modalidad = '$modalidad',
                          id_estilo = '$id_estilo',
                          id_region = '$id_region',
                          id_tecnica = '$id_tecnica',
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
        $sql        = "SELECT * FROM categorias WHERE descripcion='$descripcion'";
        $resgistros = $obj_conexion->RetornarRegistros($sql);

        echo $resgistros[0]['edad'] . ';' .
        $resgistros[0]['modalidad'] . ';' .
        $resgistros[0]['id_estilo'] . ';' .
        $resgistros[0]['id_region'] . ';' .
        $resgistros[0]['id_tecnica'] . ';' .
        $resgistros[0]['estatus'];
        break;
}