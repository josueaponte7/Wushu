<?php

if (!isset($_POST['accion'])) {
    header('Location:../');
}
require_once '../modelo/Conexion.php';
$obj_conexion = new Conexion();
$accion       = $_POST['accion'];

if (isset($_POST['nacionalidad'])) {
    $nacionalidad = $_POST['nacionalidad'];
}

if (isset($_POST['cedula'])) {
    $cedula = $_POST['cedula'];
}

if (isset($_POST['rif'])) {
    $rif = $_POST['rif'];
}

if (isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
}

if (isset($_POST['sexo'])) {
    $sexo = $_POST['sexo'];
}

if (isset($_POST['email'])) {
    $email = $_POST['email'];
}

if (isset($_POST['telefono'])) {
    $telefono = $_POST['telefono'];
}

if (isset($_POST['asociacion'])) {
    $id_asociacion = $_POST['asociacion'];
}

if (isset($_POST['fecha'])) {
    $fecha = $_POST['fecha'];
}

if (isset($_POST['estatus'])) {
    $estatus = $_POST['estatus'];
}

if (isset($_POST['direccion'])) {
    $direccion = $_POST['direccion'];
}

$dat_cedula   = explode('-', $cedula);
$cedula       = $dat_cedula[1];
$nacionalidad = $dat_cedula[0];


switch ($accion) {
    case 'Registrar':
        $sql_b       = "SELECT 1 FROM entrenadores WHERE cedula = '$cedula';";
        $total_filas = $obj_conexion->totalFilas($sql_b);
        if ($total_filas == 0) {
            $fecha = $obj_conexion->formateaBD($fecha);
            $sql   = "INSERT INTO entrenadores (nacionalidad,cedula, rif, nombre, sexo, telefono, email, direccion, id_asociacion, fecha, estatus)
                                            VALUES ('$nacionalidad','$cedula','$rif', '$nombre', '$sexo', '$telefono', '$email', '$direccion', '$id_asociacion', '$fecha', '$estatus');";

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
        $fecha = $obj_conexion->formateaBD($fecha);
        $sql   = " UPDATE entrenadores
                    SET 
                      nacionalidad = '$nacionalidad',
                      rif = '$rif',
                      nombre = '$nombre',
                      sexo = '$sexo',
                      telefono = '$telefono',
                      email = '$email',
                      direccion = '$direccion',
                      id_asociacion = '$id_asociacion',
                      fecha = '$fecha',
                      estatus = '$estatus'
                    WHERE cedula= $cedula;";

        $resultado = $obj_conexion->_query($sql);
        if ($resultado == TRUE) {
            echo 'exito';
        } else {
            echo 'error';
        }
        break;

    case 'BuscarDatos':
        $sql       = "SELECT  * FROM entrenadores WHERE cedula='$cedula'";
        $registros = $obj_conexion->RetornarRegistros($sql);
        echo $registros[0]['nacionalidad'] . ';' .
        $registros[0]['rif'] . ';' .
        $registros[0]['email'] . ';' .
        $registros[0]['id_asociacion'] . ';' .
        $registros[0]['fecha'] . ';' .
        $registros[0]['estatus'] . ';' .
        $registros[0]['direccion'];
        break;
}
