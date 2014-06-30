<?php

if (!isset($_POST['accion'])) {
    header('Location:../');
}
require_once '../modelo/Conexion.php';
$obj_conexion = new Conexion();
$accion       = $_POST['accion'];

if (isset($_POST['descripcion'])) {
    $descripcion = $_POST['descripcion'];
}

if (isset($_POST['estatus'])) {
    $estatus = $_POST['estatus'];
}



switch ($accion) {
    case 'Registrar':
        $sql_b       = "SELECT 1 FROM modalidades WHERE Descripcion = '$Descripcion';";
        $total_filas = $obj_conexion->totalFilas($sql_b);
        if ($total_filas == 0) {
            $sql       = "INSERT INTO modalidades(Descripcion,Estatus)
                VALUES ('$Descripcion','$estatus');";
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
        $sql          = "SELECT  Descripcion,   Estatus  FROM modalidades WHERE Descripcion='$Descripcion'";
        $resgistros   = $obj_conexion->RetornarRegistros($sql);
        echo $resgistros[0]['Estatus'];
    break;
}