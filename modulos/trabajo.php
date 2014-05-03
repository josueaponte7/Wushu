<?php
session_start();
include("bd.php");

$Ejecutar = $_POST["Ejecutar"];

$NRegUsu = $_SESSION["CodUsuAct"];
$NRegMod = $_SESSION["Form"]["Modulo"]["IDMenu"];

switch($Ejecutar){
	case "Limpiar":
		$Nivel = $_POST["Nivel"];
		$WID = $_POST["WID"];
		$FID = $_POST["FID"];
		$ValEsp = $_POST["ValEsp"];
		
		switch($Nivel){
			case "Usuario":
				$result = $link->query("DELETE FROM trabajo WHERE NRegUsu=".$NRegUsu);
			break;
			case "Modulo":
				$result = $link->query("DELETE FROM trabajo WHERE NRegUsu=".$NRegUsu." AND NRegMod=".$NRegMod);
			break;
			case "Widget":
				$result = $link->query("DELETE FROM trabajo WHERE NRegUsu=".$NRegUsu." AND NRegMod=".$NRegMod." AND Widget='".$WID."'");
			break;
			case "Form":
				$result = $link->query("DELETE FROM trabajo WHERE NRegUsu=".$NRegUsu." AND NRegMod=".$NRegMod." AND Widget='".$WID."' AND Form='".$FID."'");
			break;
			case "Especifico":
				$result = $link->query("DELETE FROM trabajo WHERE ".$ValEsp);
			break;
		}
	break;
	
	
	
	case "Cargar":		
		$result = $link->query("DELETE FROM trabajo WHERE NRegUsu=".$NRegUsu." AND NRegMod=".$NRegMod);
	
		$Accion = $_POST["Accion"];
		$ValorIndice = $_POST["ValorIndice"];
		
		foreach ($_SESSION["Form"]["Widgets"] as $Widget){			
			$WC = $Widget["Contenido"];
			
			$MatCampos = split(",",$WC["Campos"]);			
			for ($n = 0; $n < count($MatCampos); $n++){
				if ($n == 0){$Cmp = "Cmp".($n + 1);}else{$Cmp = $Cmp.","."Cmp".($n + 1);}
			}
			
			if ($Widget["Modo"] == "Principal"){
				$result = $link->query("SELECT ".$WC["Campos"].",NRegistro FROM ".$WC["Tabla"]." WHERE ".$WC["Indice"]."='".$ValorIndice."'");
				$NFilas = $result->num_rows;
				
				for ($TabQRY = array();$tmp = $result->fetch_array(MYSQLI_BOTH);){$TabQRY[] = $tmp;}				
				for ($CmpQRY = array();$tmp2 = $result->fetch_field();){$CmpQRY[] = $tmp2;}
				
				for ($n = 0; $n <= ($NFilas - 1); $n++){
					for ($n2 = 0; $n2 < count($MatCampos); $n2++){
						if ($n2 == 0){
							if ($CmpQRY[$n2]->type != 10){
								$Valores = "'".$TabQRY[$n][$n2]."'";
							}else{
								$FFE = split("-",$TabQRY[$n][$n2]);
								$Valores = "'".$FFE[2]."-".$FFE[1]."-".$FFE[0]."'";
							}
						}else{
							if ($CmpQRY[$n2]->type != 10){
								$Valores = $Valores.",'".$TabQRY[$n][$n2]."'";
							}else{
								$FFE = split("-",$TabQRY[$n][$n2]);
								$Valores = $Valores.",'".$FFE[2]."-".$FFE[1]."-".$FFE[0]."'";
							}
						}
					}					
					$Valores = $Valores.",'".$TabQRY[$n]["NRegistro"]."'";
					
					$result2 = $link->query("INSERT INTO trabajo (NRegUsu,NRegMod,Widget,Form,Accion,Tabla,Indice,ValorIndice,Campos,".$Cmp.",NRegReg) VALUES (".$NRegUsu.",".$NRegMod.",'".$Widget["ID"]."','form".$WC["ID"]."','".$Accion."','".$WC["Tabla"]."','".$WC["Indice"]."','".$ValorIndice."','".$WC["Campos"]."',".$Valores.")");
				}				
			}elseif ($Widget["Modo"] == "Secundario"){
				$result = $link->query("SELECT ".$WC["Campos"].",NRegistro FROM ".$WC["Tabla"]." WHERE ".$WC["Relacion"]."='".$ValorIndice."'");
												
				$NFilas = $result->num_rows;
				for ($TabQRY = array();$tmp = $result->fetch_array(MYSQLI_BOTH);){$TabQRY[] = $tmp;}
				for ($CmpQRY = array();$tmp2 = $result->fetch_field();){$CmpQRY[] = $tmp2;}
				for ($n = 0; $n <= ($NFilas - 1); $n++){
					for ($n2 = 0; $n2 < count($MatCampos); $n2++){
						if ($n2 == 0){
							if ($CmpQRY[$n2]->type != 10){
								$Valores = "'".$TabQRY[$n][$n2]."'";
							}else{
								$FFE = split("-",$TabQRY[$n][$n2]);
								$Valores = "'".$FFE[2]."-".$FFE[1]."-".$FFE[0]."'";
							}
						}else{
							if ($CmpQRY[$n2]->type != 10){
								$Valores = $Valores.",'".$TabQRY[$n][$n2]."'";
							}else{
								$FFE = split("-",$TabQRY[$n][$n2]);
								$Valores = $Valores.",'".$FFE[2]."-".$FFE[1]."-".$FFE[0]."'";
							}
						}
					}
					$Valores = $Valores.",'".$TabQRY[$n]["NRegistro"]."'";
										
					$result2 = $link->query("INSERT INTO trabajo (NRegUsu,NRegMod,Widget,Form,Accion,Tabla,Indice,ValorIndice,Campos,".$Cmp.",NRegReg) VALUES (".$NRegUsu.",".$NRegMod.",'".$Widget["ID"]."','form".$WC["ID"]."','".$Accion."','".$WC["Tabla"]."','".$WC["Indice"]."','".$ValorIndice."','".$WC["Campos"]."',".$Valores.")");
				}				
			}elseif ($Widget["Modo"] == "Independiente"){			
			}
			
		}		
	break;
	
	
	
	case "Completar":		
		$Accion = $_POST["Accion"];		
		foreach ($_SESSION["Form"]["Widgets"] as $Widget){
			if ($Widget["Requerido"] == "s"){
				$result = $link->query("SELECT NRegistro FROM trabajo WHERE NRegUsu=".$NRegUsu." AND NRegMod=".$NRegMod." AND Widget='".$Widget["ID"]."' AND Accion='".$Accion."'");
				if ($result->num_rows == 0){
					if ($Faltan == ""){$Faltan = $Widget["ID"];}else{$Faltan = $Faltan.",".$Widget["ID"];}
				}
			}
		}
		if ($Faltan != ""){
			$FaltanMat = split(",",$Faltan); echo $FaltanMat[0];			
		}else{
			foreach ($_SESSION["Form"]["Widgets"] as $Widget){
				if ($Widget["Contenido"]["Tipo"] != "Lista"){
					$result = $link->query("SELECT * FROM trabajo WHERE NRegUsu=".$NRegUsu." AND NRegMod=".$NRegMod." AND Accion='".$Accion."' AND Widget='".$Widget["ID"]."'");			
					$NFilas = $result->num_rows;
					for ($TabQRY = array();$tmp = $result->fetch_array(MYSQLI_BOTH);){$TabQRY[] = $tmp;}
					for ($n = 0; $n <= ($NFilas - 1); $n++){				
						$resultX = $link->query("SELECT ".$TabQRY[$n]["Campos"]." FROM ".$TabQRY[$n]["Tabla"]." LIMIT 1");					
						for ($CmpQRY = array();$tmp2 = $resultX->fetch_field();){$CmpQRY[] = $tmp2;}				
						$Campos = split(",",$TabQRY[$n]["Campos"]);
						for ($n2 = 0; $n2 <= count($Campos) - 1; $n2++){
							if ($n2 == 0){
								if ($CmpQRY[$n2]->type != 10){
									$Valores = "'".strtoupper($TabQRY[$n][$n2+10])."'";
								}else{
									$FFE = split("-",$TabQRY[$n][$n2+10]);
									$Valores = "'".$FFE[2]."-".$FFE[1]."-".$FFE[0]."'";
								}
							}else{
								if ($CmpQRY[$n2]->type != 10){
									$Valores = $Valores.",'".strtoupper($TabQRY[$n][$n2+10])."'";
								}else{
									$FFE = split("-",$TabQRY[$n][$n2+10]);
									$Valores = $Valores.",'".$FFE[2]."-".$FFE[1]."-".$FFE[0]."'";
								}
							}
						}
						
						if ($Widget["Contenido"]["AutoUsu"]["Hacer"] == "s"){
							$CmpUsu = ",".$Widget["Contenido"]["AutoUsu"]["CmpUsu"];
							$ValUsu = ",'".$_SESSION["CodUsuAct"]."'";
						}else{
							$CmpUsu = "";
							$ValUsu = "";
						}
						
						if ($Widget["Contenido"]["AutoHora"]["Hacer"] == "s"){
							$CmpHora = ",".$Widget["Contenido"]["AutoHora"]["CmpHora"];
							$ValHora = ",'".date("H:i:s",time() - 16200)."'";
						}else{
							$CmpHora = "";
							$ValHora = "";
						}
						
						if ($Widget["Contenido"]["AutoFecha"]["Hacer"] == "s"){
							$CmpFecha = ",".$Widget["Contenido"]["AutoFecha"]["CmpFecha"];
							$ValFecha = ",'".date("Y-m-d",time() - 16200)."'";
						}else{
							$CmpFecha = "";
							$ValFecha = "";
						}
						if ($Widget["Contenido"]["AutoEstatus"]["Hacer"] == "s"){
							$CmpEstatus = ",".$Widget["Contenido"]["AutoEstatus"]["CmpEstatus"];
							$ValEstatus = ",'".$Widget["Contenido"]["AutoEstatus"]["ValEstatus"]."'";
						}else{
							$CmpEstatus = "";
							$ValEstatus = "";
						}
						
						switch($TabQRY[$n]["Accion"]){
							case "Agregar":												
								if ($Widget["Modo"] == "Secundario"){
									$CmpRel = ",".$Widget["Contenido"]["Relacion"];
									$ValRel = ",'".$ValInd."'";
								}else{
									$CmpRel = "";
									$ValRel = "";
								}
								$resultINS = $link->query("INSERT INTO ".$TabQRY[$n]["Tabla"]." (".$TabQRY[$n]["Campos"].$CmpRel.$CmpHora.$CmpFecha.$CmpUsu.$CmpEstatus.") VALUES (".$Valores.$ValRel.$ValHora.$ValFecha.$ValUsu.$ValEstatus.")");
								if ($Widget["Modo"] == "Principal"){$ValInd = $link->insert_id;}
								//echo "INSERT INTO ".$TabQRY[$n]["Tabla"]." (".$TabQRY[$n]["Campos"].$CmpRel.$CmpHora.$CmpFecha.$CmpUsu.$CmpEstatus.") VALUES (".$Valores.$ValRel.$ValHora.$ValFecha.$ValUsu.$ValEstatus.")";
								
							break;
							case "Modificar":								
								$ValoresMat = split("','",$Valores);
								for ($n2 = 0; $n2 < count($Campos); $n2++){
									if ($n2 == 0){
										$CmpVal = $Campos[$n2]."=".$ValoresMat[$n2]."'";
									}elseif($n2 == count($Campos) - 1){
										$CmpVal = $CmpVal.",".$Campos[$n2]."='".$ValoresMat[$n2];
									}else{
										$CmpVal = $CmpVal.",".$Campos[$n2]."='".$ValoresMat[$n2]."'";
									}
								}
								$resultUPD = $link->query("UPDATE ".$TabQRY[$n]["Tabla"]." SET ".$CmpVal." WHERE NRegistro = ".$TabQRY[$n]["NRegReg"]);
																								
								//if ($Widget["Modo"] == "Principal"){$ValInd = $TabQRY[$n]["NRegReg"];}
								
								if ($Widget["Modo"] == "Secundario"){
									$resultUPD = $link->query("DELETE FROM ".$TabQRY[$n]["Tabla"]." WHERE ".$Widget["Contenido"]["Relacion"]." = ".$TabQRY[$n]["ValorIndice"]." AND NRegistro NOT IN (SELECT NRegReg FROM Trabajo WHERE NRegUsu=".$NRegUsu." AND NRegMod=".$NRegMod." AND Accion='".$Accion."' AND Widget='".$Widget["ID"]."')");								
									
									if ($TabQRY[$n]["NRegReg"] == "0"){
										$CmpRel = ",".$Widget["Contenido"]["Relacion"];
										$ValRel = ",'".$TabQRY[$n]["ValorIndice"]."'";								
										$resultINS = $link->query("INSERT INTO ".$TabQRY[$n]["Tabla"]." (".$TabQRY[$n]["Campos"].$CmpRel.$CmpHora.$CmpFecha.$CmpUsu.$CmpEstatus.") VALUES (".$Valores.$ValRel.$ValHora.$ValFecha.$ValUsu.$ValEstatus.")");									
										$NueNRegReg = $link->insert_id;									
										$resultINS = $link->query("UPDATE trabajo SET NRegReg='".$NueNRegReg."' WHERE NRegistro=".$TabQRY[$n]["NRegistro"]);									
									}
								}							
							break;
							case "Eliminar":
								if ($Widget["Modo"] == "Principal"){
									$resultUPD = $link->query("DELETE FROM ".$TabQRY[$n]["Tabla"]." WHERE NRegistro = ".$TabQRY[$n]["NRegReg"]);
									//$ValInd = $TabQRY[$n]["NRegReg"];
								}elseif ($Widget["Modo"] == "Secundario"){
									$resultUPD = $link->query("DELETE FROM ".$TabQRY[$n]["Tabla"]." WHERE ".$Widget["Contenido"]["Relacion"]." = ".$TabQRY[$n]["ValorIndice"]);
								}
							break;
						}
					}
				}
			}
			$result = $link->query("DELETE FROM trabajo WHERE NRegUsu=".$NRegUsu." AND NRegMod=".$NRegMod);
			echo "OK".",".$ValInd;
		}
	break;
}
$link->close;
?>