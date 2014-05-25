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

if (isset($_POST['pasaporte'])) {
    $pasaporte = $_POST['pasaporte'];
}

if (isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
}

if (isset($_POST['fechnac'])) {
    $fechnac = $_POST['fechnac'];
}

if (isset($_POST['sexo'])) {
    $sexo = $_POST['sexo'];
}

if (isset($_POST['telefono'])) {
    $telefono = $_POST['telefono'];
}

if (isset($_POST['email'])) {
    $email = $_POST['email'];
}

if (isset($_POST['direccion'])) {
    $direccion = $_POST['direccion'];
}

if (isset($_POST['nivel_academico'])) {
    $id_nivel = $_POST['nivel_academico'];
}

if (isset($_POST['ocupacion'])) {
    $ocupacion = $_POST['ocupacion'];
}

if (isset($_POST['asociacion'])) {
    $id_asociacion = $_POST['asociacion'];
}

if (isset($_POST['patologias'])) {
    $patologias = $_POST['patologias'];
}

if (isset($_POST['alergias'])) {
    $alergias = $_POST['alergias'];
}

if (isset($_POST['tipo_sangre'])) {
    $id_tipo = $_POST['tipo_sangre'];
}

if (isset($_POST['peso'])) {
    $peso = $_POST['peso'];
}

if (isset($_POST['tal_zap'])) {
    $tal_zap = $_POST['tal_zap'];
}

if (isset($_POST['tal_pan'])) {
    $tal_pan = $_POST['tal_pan'];
}

if (isset($_POST['tal_cam'])) {
    $tal_cam = $_POST['tal_cam'];
}

if (isset($_POST['tal_pet'])) {
    $tal_pet = $_POST['tal_pet'];
}

if (isset($_POST['padre'])) {
    $padre = $_POST['padre'];
}

if (isset($_POST['tel_padre'])) {
    $tel_padre = $_POST['tel_padre'];
}

if (isset($_POST['madre'])) {
    $madre = $_POST['madre'];
}

if (isset($_POST['tel_madre'])) {
    $tel_madre = $_POST['tel_madre'];
}

if (isset($_POST['estatus'])) {
    $estatus = $_POST['estatus'];
}

$fechnac = $obj_conexion->formateaBD($fechnac);

$dat_cedula   = explode('-', $cedula);
$cedula       = $dat_cedula[1];
$nacionalidad = $dat_cedula[0];


switch ($accion) {
    case 'Registrar':
        $sql_b       = "SELECT 1 FROM atletas WHERE cedula = '$cedula';";
        $total_filas = $obj_conexion->totalFilas($sql_b);
        if ($total_filas == 0) {

            $sql = "INSERT INTO atletas (nacionalidad, cedula, rif, pasaporte, nombre, fechnac, sexo, telefono, email, direccion, id_nivel,  ocupacion, id_asociacion, patologias,
                                         alergias, id_tipo, peso, tal_zap, tal_pan, tal_cam, tal_pet,  padre, tel_padre, madre, tel_madre, estatus)
                                 VALUES ('$nacionalidad', '$cedula', '$rif', '$pasaporte', '$nombre', '$fechnac', '$sexo', '$telefono', '$email', '$direccion', '$id_nivel', '$ocupacion', '$id_asociacion',
                                         '$patologias', '$alergias', '$id_tipo', '$peso', '$tal_zap', '$tal_pan', '$tal_cam', '$tal_pet', '$padre', '$tel_padre', '$madre', '$tel_madre', '$estatus');";

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

    case 'BuscarDatos':
        $sql        = "SELECT  Email,  Direccion, EmailRep, Estatus  FROM atletas WHERE Nombre='$nombre'";
        $resgistros = $obj_conexion->RetornarRegistros($sql);
        echo $resgistros[0]['Email'] . ';' . $resgistros[0]['Direccion'] . ';' . $resgistros[0]['EmailRep'] . ';' . $resgistros[0]['Estatus'];
        break;
}
