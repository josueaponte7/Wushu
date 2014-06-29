<?php

if (!isset($_POST['accion'])) {
    header('Location:../');
}
require_once '../modelo/Conexion.php';
$obj_conexion = new Conexion();
$accion       = $_POST['accion'];

if (isset($_POST['cedula'])) {
    $cedula = $_POST['cedula'];
}
if (isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
}
if (isset($_POST['edad'])) {
    $edad = $_POST['edad'];
}
if (isset($_POST['sexo'])) {
    $sexo = $_POST['sexo'];
}
if (isset($_POST['peso'])) {
    $peso = $_POST['peso'];
}
if (isset($_POST['categoria'])) {
    $categoria = $_POST['categoria'];
}
if (isset($_POST['modalidad'])) {
    $modalidad = $_POST['modalidad'];
}
if (isset($_POST['estilo'])) {
    $id_estilo = $_POST['estilo'];
}
if (isset($_POST['region'])) {
    $id_region = $_POST['region'];
}


switch ($accion) {
    case 'Registrar':
        $sql_b       = "SELECT 1 FROM categorias WHERE descripcion = '$descripcion';";
        $total_filas = $obj_conexion->totalFilas($sql_b);
        if ($total_filas == 0) {
  echo          $sql = "INSERT INTO categorias (descripcion, edad, sexo,  modalidad,  id_estilo, id_region, id_tecnica,  estatus)
                                          VALUES ('$descripcion', '$edad',  '$sexo', '$modalidad', '$id_estilo',  '$id_region', '$id_tecnica', '$estatus');";
exit;
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
        $sql = "UPDATE categorias
                        SET 
                          descripcion = '$descripcion',
                          edad = '$edad',
                          sexo = '$sexo',
                          modalidad = '$modalidad',
                          id_estilo = '$id_estilo',
                          id_region = '$id_region',
                          id_tecnica = '$id_tecnica',
                          estatus = '$estatus'
                        WHERE descripcion = '$descripcion';";

        $resultado = $obj_conexion->_query($sql);
        if ($resultado == TRUE) {
            echo 'exito';
        } else {
            echo 'error';
        }
        break;

     case 'Buscar':
            $sql   = "SELECT nombre,(YEAR(CURDATE())-YEAR(fechnac)) - (RIGHT(CURDATE(),5)<RIGHT(fechnac,5)) AS edad, sexo, peso FROM atletas WHERE cedula = $cedula";
       //   $sql   = "SELECT nombre,(YEAR(CURDATE())-YEAR(fechnac)) - (RIGHT(CURDATE(),5)<RIGHT(fechnac,5)) AS edad, sexo, peso FROM atletas WHERE cedula = $cedula ORDER BY 1";
//            $data['condicion'] = "num_registro, CONCAT_WS('-', nacionalidad, cedula, nombre) AS datos'";
//            $data['limite']    = "1";
//            $resultado         = $obj_conexion->RetornarRegistros($data);
            $resgistros = $obj_conexion->RetornarRegistros($sql);
           
                echo $resgistros[0]['nombre'].';'.$resgistros[0]['edad'].';'.$resgistros[0]['sexo'].';'.$resgistros[0]['peso'];
           
            break;
}