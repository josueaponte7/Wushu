<?php
session_start();
include("bd.php");

if ($_POST["Funcion"] == "Login"){
        $sql = "SELECT * FROM usuarios WHERE Usuario='".$_POST["Usuario"]."' AND Clave=MD5('".$_POST["Clave"]."')";
	$result = $link->query($sql);
	if ($result->num_rows > 0){
		//for ($TabQRY = array(); $tmp = $result->fetch_array(MYSQLI_NUM);){$TabQRY[] = $tmp;}
		//for ($TabQRY = array(); $tmp = $result->fetch_array(MYSQLI_ASSOC);){$TabQRY[] = $tmp;}
		for ($TabQRY = array(); $tmp = $result->fetch_array(MYSQLI_BOTH);){$TabQRY[] = $tmp;}
		
		$_SESSION["CodUsuAct"] = $TabQRY[0]["NRegistro"];
		$_SESSION["NomUsuAct"] = $TabQRY[0]["Nombre"];
		$_SESSION["RifUsuAct"] = $TabQRY[0]["Cedula"];
		$_SESSION["EmaUsuAct"] = $TabQRY[0]["EMail"];
		$_SESSION["TipUsuAct"] = $TabQRY[0]["Tipo"];
		$_SESSION["FotUsuAct"] = $TabQRY[0]["Foto"];
		$_SESSION["EstUsuAct"] = $TabQRY[0]["Estatus"];
		
		if (!empty($_SERVER['HTTP_CLIENT_IP'])){
			$IP = $_SERVER['HTTP_CLIENT_IP'];
		}elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$IP = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}else{   
			$IP = $_SERVER['REMOTE_ADDR'];
		}
		
		$result = $link->query("UPDATE usuarios SET Log = 'IN', IPLog='".$IP."', FechaHoraIni = '".date("Y-m-d H:i:s",time() - 16200)."' WHERE NRegistro = ".$TabQRY[0]["NRegistro"]);
												
		$result2 = $link->query("INSERT INTO auditoria (Usuario, Accion, Hora, Fecha) VALUES('".$_SESSION["NomUsuAct"]."','Inicio de Sistema','".date("H:i:s",time() - 16200)."','".date("Y-m-d",time() - 16200)."')");
		
		if ($_SESSION["EstUsuAct"]=="NUEVO"){
			echo "NUEVO";
		}elseif($_SESSION["EstUsuAct"]=="RECHAZADO"){
			echo "RECHAZADO";
		}elseif($_SESSION["EstUsuAct"]=="INACTIVO"){
			echo "INACTIVO";
		}elseif($_SESSION["EstUsuAct"]=="ACTIVO"){					
			echo "Paso";
		}
	}else{
		echo "No Paso";
	}
}
?>