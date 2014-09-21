<?php

require_once '../modelo/Conexion.php';
$obj_conexion = new Conexion();

$cedula = $_GET['cedula'];
$repre  = $_GET['repre'];
switch ($_GET['accion']) {
    case 'BuscarTodos':
        if ($cedula == '') {
            $sql = "SELECT cedula,CONCAT(nacionalidad,'-',cedula,' ',nombre,' (',representado,')') AS nombre FROM atletas";
        } else {
            if ($repre > 0) {
                $sql = "SELECT cedula,CONCAT(nacionalidad,'-',cedula,' ',nombre,' (',representado,')') AS nombre FROM atletas WHERE cedula LIKE  '%$cedula%'  AND representado > 0;";
            } else {
                $sql = "SELECT cedula,CONCAT(nacionalidad,'-',cedula,' ',nombre,' (',representado,')') AS nombre FROM atletas WHERE cedula LIKE  '%$cedula%' AND representado = 0;";
            }
        }

        $resgistros = $obj_conexion->RetornarRegistros($sql);

        for ($i = 0; $i < count($resgistros); $i++) {
            $data[] = $resgistros[$i]['nombre'];
        }

        echo json_encode($data);

    break;

    case 'BuscarNuevo':
        $sql = "SELECT representado FROM atletas WHERE cedula = $cedula ORDER BY representado DESC LIMIT 1";
        $resgistros = $obj_conexion->RetornarRegistros($sql);
        $represe = $resgistros[0]['representado'] +1;
        echo  $cedula.'-'.$represe;
    break;
}
