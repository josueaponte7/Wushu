<?php
session_start();
include("bd.php");

$UsuAct = $_POST["UsuAct"];
$NomUsuAct = $_POST["NomUsuAct"];

$result2 = $link->query("INSERT INTO auditoria (Usuario, Accion, Hora, Fecha) VALUES('".$NomUsuAct."','Salir de Sistema','".date("H:i:s",time() - 16200)."','".date("Y-m-d",time() - 16200)."')");

$result = $link->query("UPDATE usuarios SET Log = 'OUT', IPLog='', FechaHoraFin = '".date("Y-m-d H:i:s",time() - 16200)."' WHERE NRegistro = ".$UsuAct);		
?>