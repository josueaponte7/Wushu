<?php

if (!isset($_POST['accion'])) {
    header('Location:../');
}
require_once '../modelo/Conexion.php';
$obj_conexion = new Conexion();
$accion       = $_POST['accion'];

if (isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
}
if (isset($_POST['telefono'])) {
    $telefono = $_POST['telefono'];
}
if (isset($_POST['direccion'])) {
    $direccion = $_POST['direccion'];
}
if (isset($_POST['email'])) {
    $email = $_POST['email'];
}
if (isset($_POST['representante'])) {
    $representante = $_POST['representante'];
}
if (isset($_POST['tel_rep'])) {
    $tel_rep = $_POST['tel_rep'];
}
if (isset($_POST['email_rep'])) {
    $email_rep = $_POST['email_rep'];
}
if (isset($_POST['estatus'])) {
    $estatus = $_POST['estatus'];
}



switch ($accion) {
    case 'Registrar':
        $sql_b       = "SELECT 1 FROM entrenadores WHERE Nombre = '$nombre';";
        $total_filas = $obj_conexion->totalFilas($sql_b);
        if ($total_filas == 0) {
            $sql       = "INSERT INTO entrenadores(Nombre,Telefono,Email,Direccion,Representante,TelRep,EmailRep, Estatus)
                VALUES ('$nombre','$telefono','$email','$direccion','$representante','$tel_rep','$email_rep','$estatus');";
            $resultado = $obj_conexion->_query($sql);
            if ($resultado == TRUE) {
                echo 'exito';
            } else {
                echo 'error';
            }
        }else{
            echo 'existe';
        }
        break;

    case 'BuscarDatos':
        $sql          = "SELECT  Email,  Direccion, EmailRep, Estatus  FROM entrenadores WHERE Nombre='$nombre'";
        $resgistros   = $obj_conexion->RetornarRegistros($sql);
        echo $resgistros[0]['Email'].';'.$resgistros[0]['Direccion'].';'.$resgistros[0]['EmailRep'].';'.$resgistros[0]['Estatus'];
    break;
}



//cambiar los campos a procesar