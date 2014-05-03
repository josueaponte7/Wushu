<?php
session_start();
require_once '../modelo/Conexion.php';
$obj_conexion = new Conexion();

$usuario = $_POST['usuario'];
$clave   = $_POST['clave'];

$sql    = "SELECT usuario,tipo_usuario FROM usuarios WHERE Usuario='$usuario' AND Clave=MD5('$clave');";
$tot = $obj_conexion->totalFilas($sql);

if($tot > 0){
    $resgistros = $obj_conexion->RetornarRegistros($sql);
    $_SESSION['usuario']      = $resgistros[0]['usuario'];
    $_SESSION['tipo_usuario'] = $resgistros[0]['tipo_usuario'];
    echo 'acceder';
}else{
    echo 'negado';
}