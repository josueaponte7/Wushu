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
if (isset($_POST['cedula'])) {
    $cedula = $_POST['cedula'];
}
if (isset($_POST['direccion'])) {
    $direccion = $_POST['direccion'];
}
if (isset($_POST['email'])) {
    $email = $_POST['email'];
}
if (isset($_POST['fechanac'])) {
    $fechanac = $_POST['fechanac'];
}
if (isset($_POST['tel_rep'])) {
    $tel_rep = $_POST['telefono'];
}
if (isset($_POST['email'])) {
    $email = $_POST['email'];
}
if (isset($_POST['sexo'])) {
    $sexo = $_POST['sexo'];
}
if (isset($_POST['estatus'])) {
    $estatus = $_POST['estatus'];
}


switch ($accion) {
    case 'Registrar':
        $sql_b       = "SELECT 1 FROM atletas WHERE cedula = '$cedula';";
        $total_filas = $obj_conexion->totalFilas($sql_b);
        if ($total_filas == 0) {
            $sql       = "INSERT INTO atletas(Nombre,Telefono,Email,Direccion,Representante,TelRep,EmailRep, Estatus)
                VALUES ('$nombre','$telefono','$email','$direccion','$representante','$tel_rep','$email_rep','$estatus');";
            $resultado = $obj_conexion->_query($sql);
            if ($resultado == TRUE) {
                echo 'Registro con exito';
            } else {
                echo 'error';
            }
        }else{
            echo 'Regitro existe';
        }
        break;

    case 'BuscarDatos':
        $sql          = "SELECT  Email,  Direccion, EmailRep, Estatus  FROM atletas WHERE Nombre='$nombre'";
        $resgistros   = $obj_conexion->RetornarRegistros($sql);
        echo $resgistros[0]['Email'].';'.$resgistros[0]['Direccion'].';'.$resgistros[0]['EmailRep'].';'.$resgistros[0]['Estatus'];
    break;
}
