<?php

if (!isset($_POST['accion'])) {
    header('Location:../');
}
require_once '../modelo/Conexion.php';
$obj_conexion = new Conexion();
$accion       = $_POST['accion'];

if (isset($_POST['nacionalidad'])) {
    $nacionalidad = $_POST['nacionalidad'];
}

if (isset($_POST['cedula'])) {
    $cedula = $_POST['cedula'];
}

if (isset($_POST['pasaporte'])) {
    $pasaporte = $_POST['pasaporte'];
}

if (isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
}

if (isset($_POST['fechnac'])) {
    $fechnac = $_POST['fechnac'];
}

if (isset($_POST['sexo'])) {
    $sexo = $_POST['sexo'];
}

if (isset($_POST['cod_telefono'])) {
    $cod_telefono = $_POST['cod_telefono'];
}

if (isset($_POST['telefono'])) {
    $telefono = $_POST['telefono'];
}

if (isset($_POST['email'])) {
    $email = $_POST['email'];
}

if (isset($_POST['direccion'])) {
    $direccion = $_POST['direccion'];
}

if (isset($_POST['nivel_academico'])) {
    $id_nivel = $_POST['nivel_academico'];
}

if (isset($_POST['ocupacion'])) {
    $ocupacion = $_POST['ocupacion'];
}

if (isset($_POST['asociacion'])) {
    $id_asociacion = $_POST['asociacion'];
}

if (isset($_POST['patologias'])) {
    $patologias = $_POST['patologias'];
}

if (isset($_POST['alergias'])) {
    $alergias = $_POST['alergias'];
}

if (isset($_POST['tipo_sangre'])) {
    $id_tipo = $_POST['tipo_sangre'];
}

if (isset($_POST['peso'])) {
    $peso = $_POST['peso'];
}

if (isset($_POST['tal_zap'])) {
    $tal_zap = $_POST['tal_zap'];
}

if (isset($_POST['tal_pan'])) {
    $tal_pan = $_POST['tal_pan'];
}

if (isset($_POST['tal_cam'])) {
    $tal_cam = $_POST['tal_cam'];
}

if (isset($_POST['tal_pet'])) {
    $tal_pet = $_POST['tal_pet'];
}

if (isset($_POST['padre'])) {
    $padre = $_POST['padre'];
}

if (isset($_POST['cod_telpadre'])) {
    $cod_telpadre = $_POST['cod_telpadre'];
}

if (isset($_POST['tel_padre'])) {
    $tel_padre = $_POST['tel_padre'];
}

if (isset($_POST['madre'])) {
    $madre = $_POST['madre'];
}

if (isset($_POST['cod_telmadre'])) {
    $cod_telmadre = $_POST['cod_telmadre'];
}

if (isset($_POST['tel_madre'])) {
    $tel_madre = $_POST['tel_madre'];
}

if (isset($_POST['estatus'])) {
    $estatus = $_POST['estatus'];
}

//$dat_cedula   = explode('-', $cedula);
//$cedula       = $dat_cedula[1];
//$nacionalidad = $dat_cedula[0];

switch ($accion) {
    case 'Registrar':
        $sql_b       = "SELECT 1 FROM atletas WHERE cedula = '$cedula';";
        $total_filas = $obj_conexion->totalFilas($sql_b);
        if ($total_filas == 0) {
            $fechnac   = $obj_conexion->formateaBD($fechnac);
             $sql       = "INSERT INTO atletas (nacionalidad, cedula, pasaporte, nombre, fechnac, sexo, cod_telefono,telefono, email, direccion, id_nivel,  ocupacion, id_asociacion, patologias,
                                         alergias, id_tipo, peso, tal_zap, tal_pan, tal_cam, tal_pet,  padre, cod_telpadre, tel_padre, madre, cod_telmadre, tel_madre, estatus)
                                 VALUES ('$nacionalidad', '$cedula', '$pasaporte', '$nombre', '$fechnac', '$sexo', '$cod_telefono', '$telefono', '$email', '$direccion', '$id_nivel', '$ocupacion', '$id_asociacion',
                                         '$patologias', '$alergias', '$id_tipo', '$peso', '$tal_zap', '$tal_pan', '$tal_cam', '$tal_pet', '$padre', '$cod_telpadre', '$tel_padre', '$madre', '$cod_telmadre', '$tel_madre', '$estatus');";
            
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
        $fechnac = $obj_conexion->formateaBD($fechnac);

        $sql = "UPDATE atletas
                    SET
                        nacionalidad = '$nacionalidad',
                        pasaporte = '$pasaporte',
                        nombre = '$nombre',
                        fechnac = '$fechnac',
                        sexo = '$sexo',
                        cod_telefono = '$cod_telefono',
                        telefono = '$telefono',
                        email = '$email',
                        direccion = '$direccion',
                        id_nivel = '$id_nivel',
                        ocupacion = '$ocupacion',
                        id_asociacion = '$id_asociacion',
                        patologias = '$patologias',
                        alergias = '$alergias',
                        id_tipo = '$id_tipo',
                        peso = '$peso',
                        tal_zap = '$tal_zap',
                        tal_pan = '$tal_pan',
                        tal_cam = '$tal_cam',
                        tal_pet = '$tal_pet',
                        padre = '$padre',
                        cod_telpadre = '$cod_telpadre',
                        tel_padre = '$tel_padre',
                        madre = '$madre',
                        cod_telmadre = '$cod_telmadre',
                        tel_madre = '$tel_madre',
                        estatus = '$estatus'
                      WHERE cedula = $cedula;";

        $resultado = $obj_conexion->_query($sql);
        if ($resultado == TRUE) {
            echo 'exito';
        } else {
            echo 'error';
        }
        break;

    case 'BuscarDatos':
        $sql       = "SELECT
                            nacionalidad,
                            pasaporte,
                            nombre,
                            DATE_FORMAT(fechnac,'%d/%m/%Y') AS fechnac,
                            sexo,
                            cod_telefono,
                            telefono,
                            email,
                            direccion,
                            id_nivel,
                            ocupacion,
                            id_asociacion,
                            patologias,
                            alergias,
                            id_tipo,
                            peso,
                            tal_zap,
                            tal_pan,
                            tal_cam,
                            tal_pet,
                            padre,
                            cod_telpadre,
                            tel_padre,
                            madre,
                            cod_telmadre,
                            tel_madre,
                            estatus
                          FROM atletas WHERE cedula=$cedula";
        
        $registros = $obj_conexion->RetornarRegistros($sql);
        echo $registros[0]['nacionalidad']. ';' .
        $registros[0]['pasaporte'].';'.
        $registros[0]['nombre'].';'.
        $registros[0]['fechnac'] . ';' .
        $registros[0]['sexo'] . ';' .
        $registros[0]['cod_telefono'] . ';' .
        $registros[0]['telefono'] . ';' .
        $registros[0]['email']. ';' .                
        $registros[0]['direccion']. ';' .  
        $registros[0]['id_nivel'] . ';' .
        $registros[0]['ocupacion'] . ';' .
        $registros[0]['id_asociacion'] . ';' .
        $registros[0]['patologias'] . ';' .
        $registros[0]['alergias'] . ';' .
        $registros[0]['id_tipo'] . ';' .
        $registros[0]['peso'] . ';' .
        $registros[0]['tal_zap'] . ';' .
        $registros[0]['tal_pan'] . ';' .
        $registros[0]['tal_cam'] . ';' .
        $registros[0]['tal_pet']. ';' .
        $registros[0]['padre'] . ';' .
        $registros[0]['cod_telpadre'] . ';' .
        $registros[0]['tel_padre'] . ';' .
        $registros[0]['madre'] . ';' .
        $registros[0]['cod_telmadre']. ';' .
        $registros[0]['tel_madre']. ';' .
        $registros[0]['estatus'];
        break;
}
