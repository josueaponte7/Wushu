<?php

if (!isset($_POST['accion'])) {
    header('Location:../');
}
require_once '../modelo/Conexion.php';
$obj_conexion = new Conexion();
$accion       = $_POST['accion'];

if (isset($_POST['id_tipousuario'])) {
    $id_tipousuario = $_POST['id_tipousuario'];
}

if (isset($_POST['tipo_usuario'])) {
    $tipo_usuario = $_POST['tipo_usuario'];
}

switch ($accion) {
    case 'Registrar':
        $sql_b       = "SELECT 1 FROM tipo_usuario WHERE id_tipousuario = '$id_tipousuario';";
        $total_filas = $obj_conexion->totalFilas($sql_b);
        if ($total_filas == 0) {
            $sql = "INSERT INTO tipo_usuario(id_tipousuario, tipo_usuario) VALUES ('$id_tipousuario', '$tipo_usuario');";

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
       $sql = "UPDATE tipo_usuario
                SET tipo_usuario = '$tipo_usuario'
                WHERE id_tipousuario = '$id_tipousuario';";

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
        $sql       = "SELECT tipo_usuario FROM tipo_usuario WHERE id_tipousuario = '$id_tipousuario';";
       
        $registros = $obj_conexion->RetornarRegistros($sql);
        echo $registros[0]['tipo_usuario'];
        break;
}

