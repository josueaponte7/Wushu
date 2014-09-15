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

if (isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
}

if (isset($_POST['sexo'])) {
    $sexo = $_POST['sexo'];
}

if (isset($_POST['email'])) {
    $email = $_POST['email'];
}

if (isset($_POST['cod_telefono'])) {
    $cod_telefono = $_POST['cod_telefono'];
}

if (isset($_POST['telefono'])) {
    $telefono = $_POST['telefono'];
}

if (isset($_POST['estatus'])) {
    $estatus = $_POST['estatus'];
}

if (isset($_POST['direccion'])) {
    $direccion = $_POST['direccion'];
}

//$dat_cedula   = explode('-', $cedula);
//$cedula       = $dat_cedula[1];
//$nacionalidad = $dat_cedula[0];


switch ($accion) {
    case 'Registrar':
        $sql_b       = "SELECT 1 FROM representante WHERE cedula = '$cedula';";
        $total_filas = $obj_conexion->totalFilas($sql_b);
        if ($total_filas == 0) {
            $fechnac = $obj_conexion->formateaBD($fechnac);
        $sql   = "INSERT INTO representante (nacionalidad, cedula, nombre, sexo, cod_telefono, telefono, email, direccion, estatus)
                                            VALUES ('$nacionalidad', '$cedula', '$nombre', '$sexo', '$cod_telefono', '$telefono', '$email', '$direccion', '$estatus');";

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
        $fechnac = $obj_conexion->formateaBD($fechnac);
       $sql   = " UPDATE representante
                    SET 
                      nacionalidad = '$nacionalidad',
                      nombre = '$nombre',
                      sexo = '$sexo',
                      cod_telefono = '$cod_telefono',
                      telefono = '$telefono',
                      email = '$email',
                      direccion = '$direccion',
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
        $sql       = "SELECT
                        nacionalidad,
                        nombre,
                        sexo,
                        cod_telefono,
                        telefono,
                        email,
                        direccion,
                        estatus
                      FROM representante WHERE cedula = '$cedula'";
        $registros = $obj_conexion->RetornarRegistros($sql);
        $es_array = is_array($registros) ? TRUE : FALSE;
        
        if($es_array){
            echo $registros[0]['nacionalidad']. ';' .
            $registros[0]['nombre']. ';' .
            $registros[0]['sexo']. ';' .
            $registros[0]['email'] . ';' .
            $registros[0]['cod_telefono'] . ';' .       
            $registros[0]['telefono'] . ';' .   
            $registros[0]['estatus'].';'.
            $registros[0]['direccion']; 
        }else{
            echo 0;
        }
        
        break;
}
