<?php
session_start();
include("bd.php");
include("funcvari.php");
$NRegUsu = $_SESSION["CodUsuAct"];
$NRegMod = $_SESSION["Form"]["Modulo"]["IDMenu"];
$TW = $_POST["TW"];
$Hacer = $_POST["Hacer"];
$NRTT = $_POST["NRTT"];
$WID = $_POST["WID"];
$FID = $_POST["FID"];
$Accion = $_POST["Accion"];
$Tabla = $_POST["Tabla"];
$Indice = $_POST["Indice"];
$ValorIndice = $_POST["ValorIndice"];
$Campos = $_POST["Campos"];
$Valores = str_replace("\'","'",$_POST["Valores"]);

$NRegReg = $_POST["NRegReg"];

$MatCampos = split(",",$Campos);
$MatValores = split("','",$Valores);

switch ($TW){
	case "Campos":
		switch($Hacer){
			case "Verificar":
				for ($n = 0; $n < count($MatCampos); $n++){
					if ($n == 0){$Cmp = "Cmp".($n + 1);}else{$Cmp = $Cmp.","."Cmp".($n + 1);}
				}
				$result = $link->query("DELETE FROM trabajo WHERE NRegUsu=".$NRegUsu." AND NRegMod=".$NRegMod." AND Widget='".$WID."' AND Form='".$FID."' AND Accion='".$Accion."'");
		
				$result = $link->query("INSERT INTO trabajo (NRegUsu,NRegMod,Widget,Form,Accion,Tabla,Indice,ValorIndice,Campos,".$Cmp.",NRegReg) VALUES (".$NRegUsu.",".$NRegMod.",'".$WID."','".$FID."','".$Accion."','".$Tabla."','".$Indice."','".$ValorIndice."','".$Campos."',".$Valores.",'".$NRegReg."')");		
			break;			
		}
	break;
	case "CamposLista":
		switch($Hacer){
			case "Agregar":
				for ($n = 0; $n < count($MatCampos); $n++){
					if ($n == 0){$Cmp = "Cmp".($n + 1);}else{$Cmp = $Cmp.","."Cmp".($n + 1);}
				}		
				$result = $link->query("INSERT INTO trabajo (NRegUsu,NRegMod,Widget,Form,Accion,Tabla,Indice,ValorIndice,Campos,".$Cmp.") VALUES (".$NRegUsu.",".$NRegMod.",'".$WID."','".$FID."','".$Accion."','".$Tabla."','".$Indice."','".$ValorIndice."','".$Campos."',".$Valores.")");
			break;
			case "Modificar":
				for ($n = 0; $n < count($MatCampos); $n++){
					if ($n == 0){
						$Cmp = "Cmp".($n + 1)."=".$MatValores[$n]."'";
					}elseif($n == (count($MatCampos)-1)){
						$Cmp = $Cmp.","."Cmp".($n + 1)."='".$MatValores[$n];
					}else{
						$Cmp = $Cmp.","."Cmp".($n + 1)."='".$MatValores[$n]."'";
					}
				}
										
				$result = $link->query("UPDATE trabajo SET ".$Cmp." WHERE NRegistro=".$NRTT);				
			break;
			case "Eliminar":
				$result = $link->query("DELETE FROM trabajo WHERE NRegistro=".$NRTT);
			break;
			case "Consultar": 
			break;
		}
		CargaLista($WID,$Accion,$ValorIndice);
	break;	
	case "Lista":
		CargaLista($WID,$Accion,$ValorIndice);
	break;
}
$link->close;
?>