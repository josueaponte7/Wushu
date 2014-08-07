<?php

if (!isset($_POST['accion'])) {
    header('Location:../');
}
require_once '../modelo/Conexion.php';
$obj_conexion = new Conexion();
$accion       = $_POST['accion'];

if (isset($_POST['id_asociacion'])) {
    $id_asociacion = $_POST['id_asociacion'];
}

if (isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
}
if (isset($_POST['cod_telefono'])) {
    $cod_telefono = $_POST['cod_telefono'];
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
if (isset($_POST['cod_telrep'])) {
    $cod_telrep = $_POST['cod_telrep'];
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
//        $condicion = "nombre = '$nombre'";
//        $total     = $this->totalFilas('asociaciones', 'nombre', $condicion);
        $sql_b       = "SELECT 1 FROM asociaciones WHERE id_asociacion = '$id_asociacion';";
        $total_filas = $obj_conexion->totalFilas($sql_b);
        if ($total_filas == 0) {
            $sql = "INSERT INTO asociaciones (id_asociacion, nombre, cod_telefono, telefono, email, direccion, representante, cod_telrep, tel_rep, email_rep, estatus)
                                            VALUES ('$id_asociacion','$nombre', '$cod_telefono', '$telefono','$email', '$direccion','$representante', '$cod_telrep', '$tel_rep', '$email_rep', '$estatus');";

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
        $sql = "UPDATE asociaciones
                SET 
                  nombre = '$nombre',
                  cod_telefono = '$cod_telefono',
                  telefono = '$telefono',
                  email = '$email',
                  direccion = '$direccion',
                  representante = '$representante',
                  cod_telrep = '$cod_telrep',
                  tel_rep = '$tel_rep',
                  email_rep = '$email_rep',
                  estatus = '$estatus'
                WHERE id_asociacion= '$id_asociacion';";

        $resultado = $obj_conexion->_query($sql);
        if ($resultado == TRUE) {
            echo 'exito';
        } else {
            echo 'error';
        }
        break;

//    case 'Eliminar':
//        
//         $sql = "UPDATE asociaciones SET  condicion = 0 WHERE nombre = $nombre;";
//
//        $resultado = $obj_conexion->_query($sql);
//        return $resultado;        
//        break;

    case 'BuscarDatos':
        $sql       = "SELECT * FROM asociaciones WHERE id_asociacion='$id_asociacion'";
        $registros = $obj_conexion->RetornarRegistros($sql);
        echo $registros[0]['nombre'] . ';' . $registros[0]['cod_telefono'] . ';' . $registros[0]['telefono'] . ';' . $registros[0]['email'] . ';' . $registros[0]['direccion'] . ';' .
        $registros[0]['representante'] . ';' . $registros[0]['cod_telrep'] . ';' . $registros[0]['tel_rep'] . ';' . $registros[0]['email_rep'] . ';' . $registros[0]['estatus'];
        break;
}

