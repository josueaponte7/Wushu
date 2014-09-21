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

if (isset($_POST['asociacion'])) {
    $id_asociacion = $_POST['asociacion'];
}

if (isset($_POST['fechnac'])) {
    $fechnac = $_POST['fechnac'];
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
        $sql_b       = "SELECT 1 FROM entrenadores WHERE cedula = '$cedula';";
        $total_filas = $obj_conexion->totalFilas($sql_b);
        if ($total_filas == 0) {
            $fechnac = $obj_conexion->formateaBD($fechnac);
        $sql   = "INSERT INTO entrenadores (nacionalidad, cedula, nombre, sexo, cod_telefono, telefono, email, direccion, id_asociacion, fechnac, estatus)
                                            VALUES ('$nacionalidad', '$cedula', '$nombre', '$sexo', '$cod_telefono', '$telefono', '$email', '$direccion', '$id_asociacion', '$fechnac', '$estatus');";

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
       $sql   = " UPDATE entrenadores
                    SET 
                      nacionalidad = '$nacionalidad',
                      nombre = '$nombre',
                      sexo = '$sexo',
                      cod_telefono = '$cod_telefono',
                      telefono = '$telefono',
                      email = '$email',
                      direccion = '$direccion',
                      id_asociacion = '$id_asociacion',
                      fechnac = '$fechnac',
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
                        id_asociacion,
                        DATE_FORMAT(fechnac,'%d/%m/%Y') AS fechnac,
                        estatus
                      FROM entrenadores WHERE cedula = '$cedula'";
        $registros = $obj_conexion->RetornarRegistros($sql);
        $es_array = is_array($registros) ? TRUE : FALSE;
        if($es_array){
            echo $registros[0]['nacionalidad']. ';' .
            $registros[0]['nombre']. ';' .
            $registros[0]['sexo']. ';' .
            $registros[0]['email'] . ';' .
            $registros[0]['cod_telefono'] . ';' .       
            $registros[0]['telefono'] . ';' .   
            $registros[0]['id_asociacion'] . ';' .  
            $registros[0]['fechnac'] .';'.
            $registros[0]['estatus'].';'.
            $registros[0]['direccion']; 
        }else{
            echo 0;
        }
                    

        break;
}
