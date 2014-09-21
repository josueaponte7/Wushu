<?php
session_start();
require_once '../modelo/Conexion.php';
$obj_conexion = new Conexion();

$usuario = $_POST['usuario'];
$clave   = $_POST['clave'];

$sql    = "SELECT usuario, id_tipousuario FROM usuarios WHERE usuario='$usuario' AND clave=MD5('$clave');";
$tot = $obj_conexion->totalFilas($sql);

if($tot > 0){
    $resgistros = $obj_conexion->RetornarRegistros($sql);
    $_SESSION['usuario']      = $resgistros[0]['usuario'];
    $_SESSION['tipo_usuario'] = $resgistros[0]['id_tipousuario'];
    echo 'acceder';
}else{
    echo 'negado';
}