<?php

if (!isset($_POST['accion'])) {
    header('Location:../');
}
require_once '../modelo/Conexion.php';
$obj_conexion = new Conexion();
$accion       = $_POST['accion'];

if (isset($_POST['id_usuario'])) {
    $id_usuario = $_POST['id_usuario'];
}

if (isset($_POST['usuario'])) {
    $usuario = $_POST['usuario'];
}
if (isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
}
if (isset($_POST['apellido'])) {
    $apellido = $_POST['apellido'];
}
if (isset($_POST['tipo_usuario'])) {
    $id_tipousuario = $_POST['tipo_usuario'];
}
if (isset($_POST['clave'])) {
    $clave = $_POST['clave'];
}
if (isset($_POST['confir_clave'])) {
    $confir_clave = $_POST['confir_clave'];
}

if (isset($_POST['estatus'])) {
    $estatus = $_POST['estatus'];
}

switch ($accion) {
    case 'Registrar':
        
        $sql_b       = "SELECT 1 FROM usuarios WHERE id_usuario = '$id_usuario';";
        $total_filas = $obj_conexion->totalFilas($sql_b);
        if ($total_filas == 0) {
          $sql = "INSERT INTO usuarios (id_usuario, usuario, nombre, apellido,  clave,  estatus, id_tipousuario)
                                  VALUES ('$id_usuario', '$usuario', '$nombre', '$apellido', MD5('$clave'), '$estatus', '$id_tipousuario');";

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
        $sql = "UPDATE usuarios
                SET 
                  usuario = '$usuario',
                  nombre = '$nombre',
                  apellido = '$apellido',
                  estatus = '$estatus',
                  id_tipousuario = '$id_tipousuario'
                WHERE id_usuario = '$id_usuario';";

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
        $sql       = "SELECT * FROM usuarios WHERE id_usuario='$id_usuario'";
        $registros = $obj_conexion->RetornarRegistros($sql);
        echo $registros[0]['usuario'] . ';' . $registros[0]['nombre'] . ';' . $registros[0]['apellido'] . ';' . $registros[0]['id_tipousuario'] . ';' . $registros[0]['estatus'];
        break;
}

