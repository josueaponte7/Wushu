<?php

if (!isset($_POST['accion'])) {
    header('Location:../');
}
require_once '../modelo/Conexion.php';
$obj_conexion = new Conexion();
$accion       = $_POST['accion'];

if (isset($_POST['id_estilo'])) {
    $id_estilo = $_POST['id_estilo'];
}

if (isset($_POST['nombre_estilo'])) {
    $nombre_estilo = $_POST['nombre_estilo'];
}

switch ($accion) {
    case 'Registrar':
        $sql_b       = "SELECT 1 FROM estilo WHERE id_estilo = '$id_estilo';";
        $total_filas = $obj_conexion->totalFilas($sql_b);
        if ($total_filas == 0) {
          $sql = "INSERT INTO estilo(id_estilo, nombre_estilo) VALUES ('$id_estilo', '$nombre_estilo');";

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
     $sql = "UPDATE estilo
                SET nombre_estilo = '$nombre_estilo'
                WHERE id_estilo = '$id_estilo';";

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
        $sql       = "SELECT nombre_estilo FROM estilo WHERE id_estilo = '$id_estilo';";
       
        $registros = $obj_conexion->RetornarRegistros($sql);
        echo $registros[0]['nombre_estilo'];
        break;
}

