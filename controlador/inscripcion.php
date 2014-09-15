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
if (isset($_POST['categorias'])) {
    $categoria = $_POST['categorias'];
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

if(isset($_POST['id'])){
    $id = $_POST['id'];
}



switch ($accion) {
    case 'Inscribir':

        $sql = "INSERT INTO inscripcion(cedula_atleta,id_categoria)VALUES($cedula,$categoria);";
        
        $resultado = $obj_conexion->_query($sql);
        if ($resultado == TRUE) {
            echo 'exito';
        } else {
            echo 'error';
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
        case 'BuscarCategoria':
    
                $sql   = "SELECT 
                            c.edad,
                            c.sexo,
                            m.descripcion AS modalidad,
                            IF (c.id_estilo = 0,'',(SELECT nombre_estilo FROM estilo WHERE id_estilo = c.id_estilo)) AS estilo,
                            IF (c.id_region = 0,'',(SELECT nombre_region FROM region WHERE id_region = c.id_region)) AS region,
                            IF (c.id_tecnica = 0,'',(SELECT nombre_tecnica FROM tecnica WHERE id_tecnica = c.id_tecnica)) AS tecnica,
                            IF (c.id_kilos = 0,'',(SELECT kilos FROM kilogramos WHERE id_kilos = c.id_kilos)) AS kilos
                        FROM categorias AS c
                        INNER JOIN modalidades AS m ON c.modalidad=m.num_registro
                        WHERE c.num_registro=$id";
                $resgistros = $obj_conexion->RetornarRegistros($sql);
           
                echo $resgistros[0]['edad'].';'.$resgistros[0]['sexo'].';'.$resgistros[0]['modalidad'].';'.$resgistros[0]['estilo'].';'.$resgistros[0]['tecnica'].';'.$resgistros[0]['region'].';'.$resgistros[0]['kilos'];
        break;
}