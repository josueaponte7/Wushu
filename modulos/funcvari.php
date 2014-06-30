<?php
function CalEstSolSegFre($NRegSol){	
	include("bd.php");
	
	$result2 = $link->query("SELECT * FROM detsolicitudfrecuencias WHERE NRegSol = ".$NRegSol);
	for ($TabQRY2 = array();$tmp2 = $result2->fetch_array(MYSQLI_BOTH);){$TabQRY2[] = $tmp2;}
	
	if ($TabQRY2[$n]["Estatus"] == "Culminada"){return;}
	
	$EstMen = "EFECTIVA";
	for ($n = 0; $n <= (count($TabQRY2) -1); $n++){
		switch($TabQRY2[$n]["Estatus"]){
			case "":
				switch($EstMen){
					case "":
						$EstMen = "";
					break;			
					case "ASIGNADA":
						$EstMen = "";					
					break;
					case "EN EL SITIO":
						$EstMen = "";
					break;
					case "SIN DESPACHO":
						$EstMen = "";
					break;					
					case "SIN EFECTO":
						$EstMen = "";
					break;					
					case "EFECTIVA":
						$EstMen = "";
					break;
				}
			break;			
			
			case "ASIGNADA": 
				switch($EstMen){
					case "":
						$EstMen = "";
					break;			
					case "ASIGNADA":
						$EstMen = "ASIGNADA";
					break;
					case "EN EL SITIO":
						$EstMen = "ASIGNADA";
					break;
					case "SIN DESPACHO":
						$EstMen = "ASIGNADA";
					break;					
					case "SIN EFECTO":
						$EstMen = "ASIGNADA";
					break;					
					case "EFECTIVA":
						$EstMen = "ASIGNADA";
					break;
				}
			break;
			
			case "EN EL SITIO":
				switch($EstMen){
					case "":
						$EstMen = "";
					break;			
					case "ASIGNADA":
						$EstMen = "ASIGNADA";
					break;
					case "EN EL SITIO":
						$EstMen = "EN EL SITIO";			
					break;
					case "SIN DESPACHO":
						$EstMen = "EN EL SITIO";
					break;					
					case "SIN EFECTO":
						$EstMen = "EN EL SITIO";
					break;					
					case "EFECTIVA":
						$EstMen = "EN EL SITIO";
					break;
				}
			break;
			
			case "SIN DESPACHO":
				switch($EstMen){
					case "":
						$EstMen = "";
					break;			
					case "ASIGNADA":
						$EstMen = "ASIGNADA";
					break;
					case "EN EL SITIO":
						$EstMen = "EN EL SITIO";			
					break;
					case "SIN DESPACHO":
						$EstMen = "SIN DESPACHO";
					break;					
					case "SIN EFECTO":
						$EstMen = "SIN DESPACHO";
					break;					
					case "EFECTIVA":
						$EstMen = "SIN DESPACHO";
					break;
				}
			break;
			
			case "SIN EFECTO":
				switch($EstMen){
					case "":
						$EstMen = "";
					break;			
					case "ASIGNADA":
						$EstMen = "ASIGNADA";
					break;
					case "EN EL SITIO":
						$EstMen = "EN EL SITIO";			
					break;
					case "SIN DESPACHO":
						$EstMen = "SIN DESPACHO";
					break;					
					case "SIN EFECTO":
						$EstMen = "SIN EFECTO";
					break;					
					case "EFECTIVA":
						$EstMen = "SIN EFECTO";
					break;
				}
			break;
			
			case "EFECTIVA":
				switch($EstMen){
					case "":
						$EstMen = "";
					break;			
					case "ASIGNADA":
						$EstMen = "ASIGNADA";
					break;
					case "EN EL SITIO":
						$EstMen = "EN EL SITIO";			
					break;
					case "SIN DESPACHO":
						$EstMen = "SIN DESPACHO";
					break;					
					case "SIN EFECTO":
						$EstMen = "SIN EFECTO";
					break;					
					case "EFECTIVA":
						$EstMen = "EFECTIVA";
					break;
				}
			break;
		}	
	}
	
	switch($EstMen){
		case "":
			$EstMen = "POR ATENDER";
		break;			
		case "ASIGNADA":
			$EstMen = "EN CAMINO";
		break;
		case "EN EL SITIO":
			$EstMen = "EN EL SITIO";		
		break;		
		case "SIN DESPACHO":
			$EstMen = "SIN DESPACHO";
		break;					
		case "SIN EFECTO":
			$EstMen = "SIN EFECTO";
		break;					
		case "EFECTIVA":
			$EstMen = "EFECTIVA";
		break;
	}
	
	$result = $link->query("UPDATE solicitudes SET Estatus = '".$EstMen."', HoraFin = '".date("H:i:s",time() - 16200)."', FechaFin = '".date("Y-m-d",time() - 16200)."' WHERE NRegistro = ".$NRegSol);
}

function CargaLista($WID,$Accion,$ValorIndice){
	session_start();
	include("bd.php");
	
	$WC = $_SESSION["Form"]["Widgets"][$WID]["Contenido"];
	
	$trPF = "#FFFFFF";//Color tr Primera Fila
	$trSF = "#DEDEDE";//Color tr Segunda Fila
	$TitCam = split(",",$WC["TitCam"]);					
	
	if ($WC["Tipo"] != "Lista"){
		$result = $link->query("SELECT * FROM trabajo WHERE NRegUsu = ".$_SESSION["CodUsuAct"]." AND NRegMod = ".$_SESSION["Form"]["Modulo"]["IDMenu"]." AND Widget = '".$WC["ID"]."' AND Form = 'form".$WC["ID"]."' AND Accion = '".$Accion."' ".$WC["Donde"]." ORDER BY NRegistro");
	}else{
		if ($WC["SinEst"] == "Si"){
			$result = $link->query("SELECT ".$WC["Campos"]." FROM ".$WC["Tabla"]." ".$WC["Donde"]." ORDER BY ".$WC["Orden"]);		
		}else{
			$result = $link->query("SELECT ".$WC["Campos"].",Estatus FROM ".$WC["Tabla"]." ".$WC["Donde"]." ORDER BY ".$WC["Orden"]);		
		}		
	}
	
	$NFilas = $result->num_rows;
	for ($TabQRY = array();$tmp = $result->fetch_array(MYSQLI_BOTH);){$TabQRY[] = $tmp;}
	//for ($CmpQRY = array();$tmp2 = $result->fetch_field();){$CmpQRY[] = $tmp2;}
	
	if ($WC["SinTC"]["Hacer"] == "Si"){
		$result = $link->query("SELECT ".$WC["Campos"]." FROM ".$WC["Tabla"]." ".$WC["Donde"]." ORDER BY ".$WC["Orden"]);
		for ($CmpQRY = array();$tmp2 = $result->fetch_field();){$CmpQRY[] = $tmp2;}
	}else{
		$result = $link->query("SELECT ".$WC["Campos"]." FROM ".$WC["Tabla"]." LIMIT 1");
		for ($CmpQRY = array();$tmp2 = $result->fetch_field();){$CmpQRY[] = $tmp2;}
	}
	
	//Alineacion td
	for ($n = 0; $n <= (count($CmpQRY) -1); $n++){
		if ($WC["CmpSel"]["Cmp"][$n]["Tipo"] == "Select"){
			$Alineacion[]="left";
		}elseif ($WC["CmpEsp"]["Cmp"][$n]["Esp"] == "Si"){
			$Alineacion[]="center";
		}else{		
			switch($CmpQRY[$n]->type){
				case 1: $Alineacion[]="center"; break; //boleano				
				case 3: $Alineacion[]="right"; break; //integer				
				case 5: $Alineacion[]="right"; break; //double				
				case 10: $Alineacion[]="center"; break; //date				
				case 11: $Alineacion[]="center"; break; //time				
				case 252: $Alineacion[]="center"; break; //text				
				case 253: $Alineacion[]="left"; break; //varchar
				default: $Alineacion[]="center"; break; //default
			}
		}
	}
	
	echo "<input id='".$WID."NRO' type='hidden' value=''/>";
	echo "<input id='".$WID."NRR' type='hidden' value=''/>";
	echo "<input id='".$WID."TRS' type='hidden' value=''/>";
	//echo "<table class='EncTabModFor' style='margin-top:0px;'>";
	echo "<table class='EncTabModFor' style='margin-top:0px;border-collapse:!important;'>";
		echo "<tr>";
			echo "<td align='center' class='tdEncTabMod' style='font-size:10px;'>&nbsp;</td>";
			for ($n = 0; $n <= count($TitCam) - 1; $n++){
				echo "<td align='".$Alineacion[$n]."' class='tdEncTabMod' style='font-size:10px;cursor:default;'>".$TitCam[$n]."</td>";
			}						
		echo "</tr>";
		if ($NFilas == 0){
			$CanCol = (count($TitCam) + 1);
			echo "<tr bgcolor='".$trPF."'><td class='tdNERWCL' colspan='".$CanCol."'>No existen registros</td></tr>";
		}else{
			$Campos = split(",",$WC["Campos"]);
			for ($n = 0; $n <= ($NFilas - 1); $n++){
				if ($Par != $trPF){$Par = $trPF;}else{$Par = $trSF;}
				if ($WC["Tipo"] == "Lista"){
					if ($_SESSION["Form"]["Modulo"]["Titulo"] == "SUPERVISOR OPERADOR" and $WC["SinEst"] == "Si"){
						$resultES = $link->query("SELECT IPLog 
													FROM usuarios WHERE NRegistro=".$TabQRY[$n]["NRegistro"]);
						for ($TabQRYES = array();$tmpES = $resultES->fetch_array(MYSQLI_BOTH);){
							$TabQRYES[] = $tmpES;
						}						
						$IPUsu = $TabQRYES[0]["IPLog"];						
						//$IPUsu = "10.0.0.55";						
						$linkESE = mysql_pconnect($IPUsu,$IPUsu,"passinvdeffw");						
						mysql_select_db("invdeffw", $linkESE);						
						$resultCCA = mysql_query("SELECT * FROM ccatable WHERE IP='".$TabQRYES[0]["IPLog"]."'");
						
						$EstOpe = mysql_result($resultCCA,0,"Estatus");						
						$HoraReady = mysql_result($resultCCA,0,"HoraReady");
						$HoraNoReady = mysql_result($resultCCA,0,"HoraNoReady");
						$Ready = mysql_result($resultCCA,0,"Ready");
						$NoReady = mysql_result($resultCCA,0,"NoReady");
						
						$TabQRY[$n]["Estatus"] = $EstOpe;
						$TabQRY[$n][7] = $EstOpe;
												
						/*
						$resultCCAT = $link->query("SELECT * FROM ccatable WHERE IP='".$TabQRYES[0]["IPLog"]."'");
						for ($TabQRYCCAT = array();$tmpCCAT = $resultCCAT->fetch_array(MYSQLI_BOTH);){
							$TabQRYCCAT[] = $tmpCCAT;
						}
						
						$EstOpe = $TabQRYCCAT[0]["Estatus"];
						$HoraReady = $TabQRYCCAT[0]["HoraReady"];
						$HoraNoReady = $TabQRYCCAT[0]["HoraNoReady"];
						$Ready = $TabQRYCCAT[0]["Ready"];
						$NoReady = $TabQRYCCAT[0]["NoReady"];
												
						$TabQRY[$n]["Estatus"] = $EstOpe;
						$TabQRY[$n][7] = $EstOpe;
						*/
					}				
					
					foreach ($WC["ColorEstatus"] as $CE){
						if ($TabQRY[$n]["Estatus"] == $CE["Estatus"]){$Par = $CE["Color"];}
					}
					
					if ($WC["MensajeFila"]["Hacer"] == "Si"){
						$TexMF = "";
						$resultMF = $link->query("SELECT ".$WC["MensajeFila"]["Cmp"]." FROM ".$WC["Tabla"]." WHERE ".$WC["Indice"]."=".$TabQRY[$n][0]);	
						for ($TabQRYMF = array();$tmpMF = $resultMF->fetch_array(MYSQLI_BOTH);){$TabQRYMF[] = $tmpMF;}						
						$TMF = split(",",$WC["MensajeFila"]["Tit"]);
						for ($nMF = 0; $nMF <= count($TMF) -1; $nMF++){
							$TexMF = $TexMF." | ".$TMF[$nMF].": <em>".$TabQRYMF[0][$nMF]."</em>";							
						}
						
						$IntAct = "style='cursor:pointer;'";
						$IntAct = $IntAct." "."onclick='javascript:
						MensajeEmergente(\"".$TexMF."\",\"Derecha\",\"trLis".$WC["ID"].$n."\",0,0,\"#00F\");'";
					}
					
					if ($WC["BordeFilaSel"]["Hacer"] == "Si"){
						if ($TabQRY[$n][0] == $ValorIndice){							
							$StyBorFil = "style='border:".$WC["BordeFilaSel"]["Esp"]." inset ".$WC["BordeFilaSel"]["Col"].";font-weight:bold; font-size:10px;font-style:italic;'";
							$HacVisID = "trLis".$WC["ID"].$n;
							
						}else{
							$StyBorFil = "";
							//$HacVisID = "";
						}
					}
				}else{
					$resultCE = $link->query("SELECT Estatus FROM ".$WC["Tabla"]." WHERE NRegistro = ".$TabQRY[$n]["NRegReg"]);
					for ($TabQRYCE = array();$tmpCE = $resultCE->fetch_array(MYSQLI_BOTH);){$TabQRYCE[] = $tmpCE;}
					$EstRegAct = $TabQRYCE[0][0];						
					
					if ($WC["ColorEstatus"] != ""){						
						foreach ($WC["ColorEstatus"] as $CE){						
							if ($EstRegAct == $CE["Estatus"]){$Par = $CE["Color"];}
						}
					}
				}				
				echo "<tr id='trLis".$WC["ID"].$n."' bgcolor='".$Par."' ".$IntAct.">";
					echo "<td class='tdDetTabMod' align='center' ".$StyBorFil.">";
						if ($Accion == "Agregar" or $Accion == "Modificar" or $Accion == "Dinamico"){
							//Boton Seleccionar							
							if ($WC["Tipo"] != "Lista"){								
								if (strpos($_SESSION["Form"]["Modulo"]["Titulo"],"DESPACHO") !== false){
									$resultFA = $link->query("SELECT NRegFre FROM detturnofrecuencias 
									WHERE NRegUsu = ".$_SESSION["CodUsuAct"]."
									AND NRegFre = ".$TabQRY[$n]["Cmp1"]."
									AND NRegTur IN (SELECT NRegistro 
													FROM turnos 
													WHERE Estatus = 'ABIERTO' 
													ORDER BY NRegistro DESC)");
									
									if ($resultFA->num_rows == 0){$PerFre = "No";}else{$PerFre = "";}
								}																
								
								echo "<input id='ResET".$WC["ID"].$TabQRY[$n][0].$n."' type='hidden' value='".$TabQRY[$n]["NRegReg"]."'>";
								echo "<input id='NRegReg".$WC["ID"].$TabQRY[$n][0]."' type='hidden' value='".$TabQRY[$n]["NRegReg"]."'>";
								
								if ($PerFre == ""){								
									echo "<img id='ImgSel".$WC["ID"].$n."' src='img/Seleccionar.png' class='BotFil' 
									title='Seleccionar' alt='Seleccionar'
									onmouseover='javascript:CambiarImagen(\"ImgSel".$WC["ID"].$n."\",\"img/SeleccionarB.png\");' 
									onmouseout='javascript:CambiarImagen(\"ImgSel".$WC["ID"].$n."\",\"img/Seleccionar.png\");'
									onclick='javascript:";
									echo "document.getElementById(\"".$WID."NRO\").value = \"".$TabQRY[$n][0]."\";";
									echo "document.getElementById(\"".$WID."NRR\").value = \"".$TabQRY[$n]["NRegReg"]."\";";					
									for ($n2 = 0; $n2 <= count($Campos)-1; $n2++){
										$nC = $n2 + 10;
										switch($CmpQRY[$n2]->type){
											case 1://boleano 
												echo "document.getElementById(\"".$WID.$n2."\").value = \"".$TabQRY[$n][$nC]."\";";
											break;								
											case 3://integer							
												echo "document.getElementById(\"".$WID.$n2."\").value = \"".number_format($TabQRY[$n][$nC], 0, ',', '.')."\";";
											break; 
											case 5://double 
												echo "document.getElementById(\"".$WID.$n2."\").value = \"".number_format($TabQRY[$n][$nC], 2, ',', '.')."\";";
											break; 
											case 10://date												
												echo "document.getElementById(\"".$WID.$n2."\").value = \"".$TabQRY[$n][$nC]."\";";
											break; 
											case 11://time
												echo "document.getElementById(\"".$WID.$n2."\").value = \"".$TabQRY[$n][$nC]."\";";
											break; 
											case 252://text
												echo "document.getElementById(\"".$WID.$n2."\").value = \"".$TabQRY[$n][$nC]."\";";
											break; 
											case 253://varchar
												echo "document.getElementById(\"".$WID.$n2."\").value = \"".$TabQRY[$n][$nC]."\";";
											break;
										}
									}													
									echo "'/>";
								
																
									if ($TabQRY[$n]["Cmp2"] != ""){
										if ($WC["BotonFila"]["Hacer"] == "Si"){										
											if ($EstRegAct == "ASIGNADA"){
												echo "&nbsp;";
												$WCBF = $WC["BotonFila"];
												echo "<input id='NRegReg".$WC["ID"].$TabQRY[$n][0]."2' type='hidden' value='".$TabQRY[$n]["NRegReg"]."'>";
												
												echo "<img id='ImgSel".$WC["ID"].$n."2' src='img/".$WCBF["Img"].".png' class='BotFil' 
												title='".$WCBF["Tit"]."' alt='".$WCBF["Tit"]."'
												onmouseover='javascript:CambiarImagen(\"ImgSel".$WC["ID"].$n."2\",\"img/".$WCBF["Img"]."B.png\");' 
												onmouseout='javascript:CambiarImagen(\"ImgSel".$WC["ID"].$n."2\",\"img/".$WCBF["Img"].".png\");'
												onclick='javascript:";									
												if ($WCBF["Eje"] == "ActEst"){											
													echo "ActEstatusUnidad(\"".$TabQRY[$n]["NRegReg"]."\",\"EN EL SITIO\")";
													
													echo "
													document.getElementById(\"ImgSel".$WC["ID"].$n."2\").style.visibility=\"hidden\";
													MensajeEmergente(\"Cargando\",\"Izquierda\",\"trLis".$WC["ID"].$n."\",0,0,\"#00F\");										
													EjecutaTrabajo(\"Ninguno\",\"\",\"Ejecutar=Completar&Accion=Modificar\");									 											
													setTimeout(VerProCS".$n.",500);
													function VerProCS".$n."(){											
														BusSinPro(\"ResET".$WC["ID"].$TabQRY[$n][0].$n."\",".$TabQRY[$n]["ValorIndice"].");
														setTimeout(VerProBSP".$n.",300);
														function VerProBSP".$n."(){												
															if (document.getElementById(\"ResET".$WC["ID"].$TabQRY[$n][0].$n."\").value != \"0\"){																																									EjecutaTrabajo(\"Ninguna\",\"\",\"Ejecutar=Cargar&Accion=Modificar&ValorIndice=".$TabQRY[$n]["ValorIndice"]."\");												
																CargaPagina(\"modulos/formulario.php\",\"Modificar Registro de ".$_SESSION["Form"]["Modulo"]["Titulo"]."\",\"Accion=Modificar&ValorIndice=".$TabQRY[$n]["ValorIndice"]."\");
															}else{													
																BusPriPen(\"ResET".$WC["ID"].$TabQRY[$n][0].$n."\",\"".$TabQRY[$n]["ValorIndice"]."\");
																setTimeout(VerProBPP".$n.",300);
																function VerProBPP".$n."(){														
																	if (document.getElementById(\"ResET".$WC["ID"].$TabQRY[$n][0].$n."\").value == 0){
																		CargaPagina(\"modulos/formulario.php\",\"Agregar Registro de ".$_SESSION["Form"]["Modulo"]["Titulo"]."\",\"Accion=Agregar&ValorIndice=\");
																	}else{														EjecutaTrabajo(\"Ninguna\",\"\",\"Ejecutar=Cargar&Accion=Modificar&ValorIndice=\" + document.getElementById(\"ResET".$WC["ID"].$TabQRY[$n][0].$n."\").value);
																		CargaPagina(\"modulos/formulario.php\",\"Modificar Registro de ".$_SESSION["Form"]["Modulo"]["Titulo"]."\",\"Accion=Modificar&ValorIndice=\" + document.getElementById(\"ResET".$WC["ID"].$TabQRY[$n][0].$n."\").value);
																	}
																}
															}
														}											
													}";
												
												}									
												echo "'/>";
											}
										}
									}
									
									if ($TabQRY[$n]["Cmp4"] != ""){
										//if ($WC["BotonSD"]["Hacer"] == "Si" and $EstRegAct == ""){																				
										if ($WC["BotonSD"]["Hacer"] == "Si"){
											if ($EstRegAct == "" or $EstRegAct == "ASIGNADA" or $EstRegAct == "EN EL SITIO"){										
												echo "<br />";
												$WCBF = $WC["BotonSD"];
												echo "<input id='NRegReg".$WC["ID"].$TabQRY[$n][0]."2' type='hidden' value='".$TabQRY[$n]["NRegReg"]."'>";
												
												echo "<img id='ImgSelSD".$WC["ID"].$n."2' src='img/".$WCBF["Img"].".png' class='BotFilAcc' 
												title='".$WCBF["Tit"]."' alt='".$WCBF["Tit"]."'
												onmouseover='javascript:CambiarImagen(\"ImgSelSD".$WC["ID"].$n."2\",\"img/".$WCBF["Img"]."B.png\");' 
												onmouseout='javascript:CambiarImagen(\"ImgSelSD".$WC["ID"].$n."2\",\"img/".$WCBF["Img"].".png\");'
												onclick='javascript:";									
												if ($WCBF["Eje"] == "SinDes"){											
													echo "ActEstatusUnidad(\"".$TabQRY[$n]["NRegReg"]."\",\"SIN DESPACHO\")";
	
													echo "
													document.getElementById(\"ImgSelSD".$WC["ID"].$n."2\").style.visibility=\"hidden\";
													MensajeEmergente(\"Cargando\",\"Izquierda\",\"trLis".$WC["ID"].$n."\",0,0,\"#00F\");										
													EjecutaTrabajo(\"Ninguno\",\"\",\"Ejecutar=Completar&Accion=Modificar\");									 											
													setTimeout(VerProCSSD".$n.",500);
													function VerProCSSD".$n."(){											
														BusSinPro(\"ResET".$WC["ID"].$TabQRY[$n][0].$n."\",".$TabQRY[$n]["ValorIndice"].");
														setTimeout(VerProBSPSD".$n.",300);
														function VerProBSPSD".$n."(){												
															if (document.getElementById(\"ResET".$WC["ID"].$TabQRY[$n][0].$n."\").value != \"0\"){																																									EjecutaTrabajo(\"Ninguna\",\"\",\"Ejecutar=Cargar&Accion=Modificar&ValorIndice=".$TabQRY[$n]["ValorIndice"]."\");												
																CargaPagina(\"modulos/formulario.php\",\"Modificar Registro de ".$_SESSION["Form"]["Modulo"]["Titulo"]."\",\"Accion=Modificar&ValorIndice=".$TabQRY[$n]["ValorIndice"]."\");
															}else{													
																BusPriPen(\"ResET".$WC["ID"].$TabQRY[$n][0].$n."\",\"".$TabQRY[$n]["ValorIndice"]."\");
																setTimeout(VerProBPPSD".$n.",300);
																function VerProBPPSD".$n."(){														
																	if (document.getElementById(\"ResET".$WC["ID"].$TabQRY[$n][0].$n."\").value == 0){
																		CargaPagina(\"modulos/formulario.php\",\"Agregar Registro de ".$_SESSION["Form"]["Modulo"]["Titulo"]."\",\"Accion=Agregar&ValorIndice=\");
																	}else{														EjecutaTrabajo(\"Ninguna\",\"\",\"Ejecutar=Cargar&Accion=Modificar&ValorIndice=\" + document.getElementById(\"ResET".$WC["ID"].$TabQRY[$n][0].$n."\").value);
																		CargaPagina(\"modulos/formulario.php\",\"Modificar Registro de ".$_SESSION["Form"]["Modulo"]["Titulo"]."\",\"Accion=Modificar&ValorIndice=\" + document.getElementById(\"ResET".$WC["ID"].$TabQRY[$n][0].$n."\").value);
																	}
																}
															}
														}											
													}";
												}									
												echo "'/>";
											}
										}
									}
									
									if ($TabQRY[$n]["Cmp4"] != ""){
										if ($WC["BotonSE"]["Hacer"] == "Si"){										
											if ($EstRegAct == "EN EL SITIO"){
												echo "<br />";
												$WCBF = $WC["BotonSE"];
												echo "<input id='NRegReg".$WC["ID"].$TabQRY[$n][0]."2' type='hidden' value='".$TabQRY[$n]["NRegReg"]."'>";
												
												echo "<img id='ImgSelSE".$WC["ID"].$n."2' src='img/".$WCBF["Img"].".png' class='BotFilAcc' 
												title='".$WCBF["Tit"]."' alt='".$WCBF["Tit"]."'
												onmouseover='javascript:CambiarImagen(\"ImgSelSE".$WC["ID"].$n."2\",\"img/".$WCBF["Img"]."B.png\");' 
												onmouseout='javascript:CambiarImagen(\"ImgSelSE".$WC["ID"].$n."2\",\"img/".$WCBF["Img"].".png\");'
												onclick='javascript:";									
												if ($WCBF["Eje"] == "SinEfe"){											
													echo "ActEstatusUnidad(\"".$TabQRY[$n]["NRegReg"]."\",\"SIN EFECTO\")";
	
													echo "
													document.getElementById(\"ImgSelSE".$WC["ID"].$n."2\").style.visibility=\"hidden\";
													MensajeEmergente(\"Cargando\",\"Izquierda\",\"trLis".$WC["ID"].$n."\",0,0,\"#00F\");										
													EjecutaTrabajo(\"Ninguno\",\"\",\"Ejecutar=Completar&Accion=Modificar\");									 											
													setTimeout(VerProCSSE".$n.",500);
													function VerProCSSE".$n."(){											
														BusSinPro(\"ResET".$WC["ID"].$TabQRY[$n][0].$n."\",".$TabQRY[$n]["ValorIndice"].");
														setTimeout(VerProBSPSE".$n.",300);
														function VerProBSPSE".$n."(){												
															if (document.getElementById(\"ResET".$WC["ID"].$TabQRY[$n][0].$n."\").value != \"0\"){																																									EjecutaTrabajo(\"Ninguna\",\"\",\"Ejecutar=Cargar&Accion=Modificar&ValorIndice=".$TabQRY[$n]["ValorIndice"]."\");												
																CargaPagina(\"modulos/formulario.php\",\"Modificar Registro de ".$_SESSION["Form"]["Modulo"]["Titulo"]."\",\"Accion=Modificar&ValorIndice=".$TabQRY[$n]["ValorIndice"]."\");
															}else{													
																BusPriPen(\"ResET".$WC["ID"].$TabQRY[$n][0].$n."\",\"".$TabQRY[$n]["ValorIndice"]."\");
																setTimeout(VerProBPPSE".$n.",300);
																function VerProBPPSE".$n."(){														
																	if (document.getElementById(\"ResET".$WC["ID"].$TabQRY[$n][0].$n."\").value == 0){
																		CargaPagina(\"modulos/formulario.php\",\"Agregar Registro de ".$_SESSION["Form"]["Modulo"]["Titulo"]."\",\"Accion=Agregar&ValorIndice=\");
																	}else{														EjecutaTrabajo(\"Ninguna\",\"\",\"Ejecutar=Cargar&Accion=Modificar&ValorIndice=\" + document.getElementById(\"ResET".$WC["ID"].$TabQRY[$n][0].$n."\").value);
																		CargaPagina(\"modulos/formulario.php\",\"Modificar Registro de ".$_SESSION["Form"]["Modulo"]["Titulo"]."\",\"Accion=Modificar&ValorIndice=\" + document.getElementById(\"ResET".$WC["ID"].$TabQRY[$n][0].$n."\").value);
																	}
																}
															}
														}											
													}";
												}									
												echo "'/>";
											}
										}
									}
									
									if ($TabQRY[$n]["Cmp4"] != ""){
										if ($WC["BotonEF"]["Hacer"] == "Si"){										
											if ($EstRegAct == "EN EL SITIO"){
												echo "<br />";
												$WCBF = $WC["BotonEF"];
												echo "<input id='NRegReg".$WC["ID"].$TabQRY[$n][0]."2' type='hidden' value='".$TabQRY[$n]["NRegReg"]."'>";
												
												echo "<img id='ImgSelEF".$WC["ID"].$n."2' src='img/".$WCBF["Img"].".png' class='BotFilAcc' 
												title='".$WCBF["Tit"]."' alt='".$WCBF["Tit"]."'
												onmouseover='javascript:CambiarImagen(\"ImgSelEF".$WC["ID"].$n."2\",\"img/".$WCBF["Img"]."B.png\");' 
												onmouseout='javascript:CambiarImagen(\"ImgSelEF".$WC["ID"].$n."2\",\"img/".$WCBF["Img"].".png\");'
												onclick='javascript:";									
												if ($WCBF["Eje"] == "Efe"){											
													echo "ActEstatusUnidad(\"".$TabQRY[$n]["NRegReg"]."\",\"EFECTIVA\")";
	
													echo "
													document.getElementById(\"ImgSelEF".$WC["ID"].$n."2\").style.visibility=\"hidden\";
													MensajeEmergente(\"Cargando\",\"Izquierda\",\"trLis".$WC["ID"].$n."\",0,0,\"#00F\");										
													EjecutaTrabajo(\"Ninguno\",\"\",\"Ejecutar=Completar&Accion=Modificar\");									 											
													setTimeout(VerProCSEF".$n.",500);
													function VerProCSEF".$n."(){											
														BusSinPro(\"ResET".$WC["ID"].$TabQRY[$n][0].$n."\",".$TabQRY[$n]["ValorIndice"].");
														setTimeout(VerProBSPEF".$n.",300);
														function VerProBSPEF".$n."(){												
															if (document.getElementById(\"ResET".$WC["ID"].$TabQRY[$n][0].$n."\").value != \"0\"){																																									EjecutaTrabajo(\"Ninguna\",\"\",\"Ejecutar=Cargar&Accion=Modificar&ValorIndice=".$TabQRY[$n]["ValorIndice"]."\");												
																CargaPagina(\"modulos/formulario.php\",\"Modificar Registro de ".$_SESSION["Form"]["Modulo"]["Titulo"]."\",\"Accion=Modificar&ValorIndice=".$TabQRY[$n]["ValorIndice"]."\");
															}else{													
																BusPriPen(\"ResET".$WC["ID"].$TabQRY[$n][0].$n."\",\"".$TabQRY[$n]["ValorIndice"]."\");
																setTimeout(VerProBPPEF".$n.",300);
																function VerProBPPEF".$n."(){														
																	if (document.getElementById(\"ResET".$WC["ID"].$TabQRY[$n][0].$n."\").value == 0){
																		CargaPagina(\"modulos/formulario.php\",\"Agregar Registro de ".$_SESSION["Form"]["Modulo"]["Titulo"]."\",\"Accion=Agregar&ValorIndice=\");
																	}else{														EjecutaTrabajo(\"Ninguna\",\"\",\"Ejecutar=Cargar&Accion=Modificar&ValorIndice=\" + document.getElementById(\"ResET".$WC["ID"].$TabQRY[$n][0].$n."\").value);
																		CargaPagina(\"modulos/formulario.php\",\"Modificar Registro de ".$_SESSION["Form"]["Modulo"]["Titulo"]."\",\"Accion=Modificar&ValorIndice=\" + document.getElementById(\"ResET".$WC["ID"].$TabQRY[$n][0].$n."\").value);
																	}
																}
															}
														}											
													}";
												}									
												echo "'/>";
											}
										}
									}
								}
							}else{
								if ($WC["BotonFila"]["Hacer"] == "Si"){
									$WCBF = $WC["BotonFila"];
									echo "<input id='NRegReg".$WC["ID"].$TabQRY[$n][0]."' type='hidden' value='".$TabQRY[$n]["NRegReg"]."'>";
									echo "<input id='ResET".$WC["ID"].$TabQRY[$n][0]."' type='hidden' value='".$TabQRY[$n]["NRegReg"]."'>";
									echo "<input id='ResET".$WC["ID"].$TabQRY[$n][0].$n."' type='hidden' value='".$TabQRY[$n]["NRegReg"]."'>";
									echo "<img id='ImgSel".$WC["ID"].$n."' src='img/".$WCBF["Img"].".png' class='BotFil' 
									title='".$WCBF["Tit"]."' alt='".$WCBF["Tit"]."'
									onmouseover='javascript:CambiarImagen(\"ImgSel".$WC["ID"].$n."\",\"img/".$WCBF["Img"]."B.png\");' 
									onmouseout='javascript:CambiarImagen(\"ImgSel".$WC["ID"].$n."\",\"img/".$WCBF["Img"].".png\");'
									onclick='javascript:";							
									
									if ($WCBF["Eje"] == "CerSes"){
										echo "Logout(\"".$TabQRY[$n]["NRegistro"]."\",\"".$TabQRY[$n]["Nombre"]."\");";
									}
									
									if ($WCBF["Eje"] == "CarMod"){
										echo "
										document.getElementById(\"ImgSel".$WC["ID"].$n."\").style.visibility=\"hidden\";
										document.getElementById(\"".$WC["ID"]."TRS\").value = \"trLis".$WC["ID"].$n."\";
										
										MensajeEmergente(\"Cargando\",\"Derecha\",\"trLis".$WC["ID"].$n."\",0,0,\"#00F\");										
										EjecutaTrabajo(\"Ninguno\",\"\",\"Ejecutar=Completar&Accion=Modificar\");									 											
										setTimeout(VerProCS".$n.",500);
										function VerProCS".$n."(){											
											BusSinPro(\"ResET".$WC["ID"].$TabQRY[$n][0].$n."\",".$TabQRY[$n][0].");
											setTimeout(VerProBSP".$n.",300);
											function VerProBSP".$n."(){												
												if (document.getElementById(\"ResET".$WC["ID"].$TabQRY[$n][0].$n."\").value != \"0\"){																																									EjecutaTrabajo(\"Ninguna\",\"\",\"Ejecutar=Cargar&Accion=Modificar&ValorIndice=".$TabQRY[$n][0]."\");												
													CargaPagina(\"modulos/formulario.php\",\"SOLICITUD No: ".number_format($TabQRY[$n][0], 0, ',', '.')."\",\"Accion=Modificar&ValorIndice=".$TabQRY[$n][0]."\");
												}else{													
													BusPriPen(\"ResET".$WC["ID"].$TabQRY[$n][0].$n."\",\"".$ValorIndice."\");
													setTimeout(VerProBPP".$n.",300);
													function VerProBPP".$n."(){														
														if (document.getElementById(\"ResET".$WC["ID"].$TabQRY[$n][0].$n."\").value == 0){
															CargaPagina(\"modulos/formulario.php\",\"Agregar Registro de ".$_SESSION["Form"]["Modulo"]["Titulo"]."\",\"Accion=Agregar&ValorIndice=\");
														}else{														EjecutaTrabajo(\"Ninguna\",\"\",\"Ejecutar=Cargar&Accion=Modificar&ValorIndice=\" + document.getElementById(\"ResET".$WC["ID"].$TabQRY[$n][0].$n."\").value);
															CargaPagina(\"modulos/formulario.php\",\"Modificar Registro de ".$_SESSION["Form"]["Modulo"]["Titulo"]."\",\"Accion=Modificar&ValorIndice=\" + document.getElementById(\"ResET".$WC["ID"].$TabQRY[$n][0].$n."\").value);
														}
													}
												}
											}											
										}";										
									}									
									echo "'/>";
								}
							}
						}
					echo "</td>";				
					for ($n2 = 0; $n2 <= count($Campos)-1; $n2++){
						if ($WC["Tipo"] != "Lista"){$nCA = $n2+10;}else{$nCA = $n2;}
						switch($CmpQRY[$n2]->type){
							case 1://boleano 
								if ($TabQRY[$n][$nCA] == true){$Valor = "Si";}else{$Valor = "No";} 
							break;								
							case 3://integer							
								$Valor = number_format($TabQRY[$n][$nCA], 0, ',', '.');
							break; 
							case 5://double 
								$Valor = number_format($TabQRY[$n][$nCA], 2, ',', '.');
							break; 
							case 10://date												
								$Valor = $TabQRY[$n][$nCA];
							break; 
							case 11://time
								$Valor = $TabQRY[$n][$nCA]; 
							break; 
							case 252://text
								$Valor = $TabQRY[$n][$nCA]; 
							break; 
							case 253://varchar
								$Valor = $TabQRY[$n][$nCA]; 
							break;
						}
						
						if ($WC["CmpEsp"]["Cmp"][$n2]["Esp"] == "Si"){
							echo "<td id='tdDetTabMod".$n.$n2."' class='tdDetTabMod' align='".$Alineacion[$n2]."' style='background-color:".$WC["CmpEsp"]["Cmp"][$n2]["Color"]."'>";
						}else{
							echo "<td id='tdDetTabMod".$n.$n2."' class='tdDetTabMod' align='".$Alineacion[$n2]."' ".$StyBorFil.">";
							
						}						
							if ($WC["CmpSel"]["Cmp"][$n2]["Tipo"] == "Select"){
								$CmpSel = $WC["CmpSel"]["Cmp"][$n2];
								$resultCS = $link->query("SELECT ".$CmpSel["Campos"]." FROM ".$CmpSel["Tablas"]." WHERE ".$CmpSel["Compara"]."='".$Valor."'");
								for ($TabQRYCS = array();$tmpCS = $resultCS->fetch_array(MYSQLI_BOTH);){
									$TabQRYCS[] = $tmpCS;
								}
								if ($resultCS->num_rows > 0){
									//echo $Valor." - ".$TabQRYCS[0][1];
									echo $Valor." - ";										
									$CmpVI = split(",",$CmpSel["Campos"]);										
									for ($nCmpVI = 1; $nCmpVI <= (count($CmpVI) -1); $nCmpVI++){
										if ($nCmpVI < 2){
											echo $TabQRYCS[0][$CmpVI[$nCmpVI]];
										}else{
											echo " - ".substr($TabQRYCS[0][$CmpVI[$nCmpVI]],0,30);
										}								
									}
								}else{
									echo $Valor." - ???";
								}
							}elseif ($WC["CmpEsp"]["Cmp"][$n2]["Esp"] == "Si"){
								if ($WC["CmpEsp"]["Cmp"][$n2]["Tipo"] == "Ext"){
									switch($TabQRYES[0]["IPLog"]){
										case "10.0.0.11": echo "201"; break;
										case "10.0.0.12": echo "202"; break;
										case "10.0.0.13": echo "203"; break;
										case "10.0.0.14": echo "204"; break;
										case "10.0.0.15": echo "205"; break;
										case "10.0.0.16": echo "206"; break;
										case "10.0.0.17": echo "207"; break;
										case "10.0.0.18": echo "208"; break;
										case "10.0.0.19": echo "209"; break;
										case "10.0.0.20": echo "210"; break;									
									}
								}
								if ($WC["CmpEsp"]["Cmp"][$n2]["Tipo"] == "TmpLog"){									
									$resultTL = $link->query("SELECT FechaHoraIni FROM usuarios WHERE NRegistro=".$TabQRY[$n]["NRegistro"]);
									for ($TabQRYTL = array();$tmpTL = $resultTL->fetch_array(MYSQLI_BOTH);){
										$TabQRYTL[] = $tmpTL;
									}									
									echo date("H:i:s",time() - strtotime($TabQRYTL[0]["FechaHoraIni"]) - 16200);									
								}
								
								if ($WC["CmpEsp"]["Cmp"][$n2]["Tipo"] == "TmpEstAct"){									
									if ($EstOpe == "Ready"){
										$HoraRef = $HoraReady;
									}else{
										$HoraRef = $HoraNoReady;										
									}									
									echo date("H:i:s",(time() - 16200) - strtotime($HoraRef));									
								}
								
								if ($WC["CmpEsp"]["Cmp"][$n2]["Tipo"] == "TmpRdy"){									
									$STA = $Ready / 5;																	
									echo date("H:i:s",$STA);
								}
								
								if ($WC["CmpEsp"]["Cmp"][$n2]["Tipo"] == "TmpNoRdy"){
									$STA = $NoReady / 5;																	
									echo date("H:i:s",$STA);
								}
								
								if ($WC["CmpEsp"]["Cmp"][$n2]["Tipo"] == "Est"){									
									echo $EstOpe;									
								}
								
								if ($WC["CmpEsp"]["Cmp"][$n2]["Tipo"] == "TotPA"){									
									$resultTPA = $link->query("SELECT COUNT(*) FROM Solicitudes
									WHERE Categoria != 12 AND Estatus ='POR ATENDER'
									AND NRegistro IN (SELECT NRegSol 
														FROM detsolicitudfrecuencias 
														WHERE Estatus = ''
													AND NRegFre IN
													(SELECT NRegFre 
														FROM detturnofrecuencias 
														WHERE NRegTur IN 
													(SELECT NRegistro 
														FROM turnos 
														WHERE Estatus = 'ABIERTO' ORDER BY NRegistro DESC) 
													AND NRegUsu = ".$TabQRY[$n]["NRegistro"].")) 
													AND NRegistro NOT IN (SELECT NRegSolRep 
																			FROM detsolicitudrepetida)");
									
									for ($TabQRYTPA = array();$tmpTPA = $resultTPA->fetch_array(MYSQLI_BOTH);){
										$TabQRYTPA[] = $tmpTPA;
									}																									
									echo $TabQRYTPA[0][0];									
								}
								
								if ($WC["CmpEsp"]["Cmp"][$n2]["Tipo"] == "TotA"){									
									$resultTA = $link->query("SELECT COUNT(*) 
									FROM detsolicitudfrecuencias 
									WHERE NRegDes=".$TabQRY[$n]["NRegistro"]." 
									AND Estatus = 'ASIGNADA'
									AND NRegSol > ".$WC["SIT"]."
									AND NRegFre IN
													(SELECT NRegFre 
														FROM detturnofrecuencias 
														WHERE NRegTur IN 
													(SELECT NRegistro 
														FROM turnos 
														WHERE Estatus = 'ABIERTO' ORDER BY NRegistro DESC) 
													AND NRegUsu = ".$TabQRY[$n]["NRegistro"].")");
									for ($TabQRYTA = array();$tmpTA = $resultTA->fetch_array(MYSQLI_BOTH);){
										$TabQRYTA[] = $tmpTA;
									}																									
									echo $TabQRYTA[0][0];
								}
								
								if ($WC["CmpEsp"]["Cmp"][$n2]["Tipo"] == "TotEES"){									
									$resultTA = $link->query("SELECT COUNT(*) 
									FROM detsolicitudfrecuencias 
									WHERE NRegDes=".$TabQRY[$n]["NRegistro"]." 
									AND Estatus = 'EN EL SITIO'
									AND NRegSol > ".$WC["SIT"]."
									AND NRegFre IN
													(SELECT NRegFre 
														FROM detturnofrecuencias 
														WHERE NRegTur IN 
													(SELECT NRegistro 
														FROM turnos 
														WHERE Estatus = 'ABIERTO' ORDER BY NRegistro DESC) 
													AND NRegUsu = ".$TabQRY[$n]["NRegistro"].")");
									for ($TabQRYTA = array();$tmpTA = $resultTA->fetch_array(MYSQLI_BOTH);){
										$TabQRYTA[] = $tmpTA;
									}																									
									echo $TabQRYTA[0][0];
								}
								
								if ($WC["CmpEsp"]["Cmp"][$n2]["Tipo"] == "TotSD"){									
									$resultTSD = $link->query("SELECT COUNT(*) 
									FROM detsolicitudfrecuencias 
									WHERE NRegDes=".$TabQRY[$n]["NRegistro"]." 
									AND Estatus = 'SIN DESPACHO'
									AND NRegSol > ".$WC["SIT"]."
									AND NRegFre IN
													(SELECT NRegFre 
														FROM detturnofrecuencias 
														WHERE NRegTur IN 
													(SELECT NRegistro 
														FROM turnos 
														WHERE Estatus = 'ABIERTO' ORDER BY NRegistro DESC) 
													AND NRegUsu = ".$TabQRY[$n]["NRegistro"].")");
									for ($TabQRYTSD = array();$tmpTSD = $resultTSD->fetch_array(MYSQLI_BOTH);){
										$TabQRYTSD[] = $tmpTSD;
									}																									
									echo $TabQRYTSD[0][0];
								}
								
								if ($WC["CmpEsp"]["Cmp"][$n2]["Tipo"] == "TotSE"){									
									$resultTSE = $link->query("SELECT COUNT(*) 
									FROM detsolicitudfrecuencias 
									WHERE NRegDes=".$TabQRY[$n]["NRegistro"]." 
									AND Estatus = 'SIN EFECTO'
									AND NRegSol > ".$WC["SIT"]."
									AND NRegFre IN
													(SELECT NRegFre 
														FROM detturnofrecuencias 
														WHERE NRegTur IN 
													(SELECT NRegistro 
														FROM turnos 
														WHERE Estatus = 'ABIERTO' ORDER BY NRegistro DESC) 
													AND NRegUsu = ".$TabQRY[$n]["NRegistro"].")");
									for ($TabQRYTSE = array();$tmpTSE = $resultTSE->fetch_array(MYSQLI_BOTH);){
										$TabQRYTSE[] = $tmpTSE;
									}																									
									echo $TabQRYTSE[0][0];
								}
								
								if ($WC["CmpEsp"]["Cmp"][$n2]["Tipo"] == "TotE"){									
									$resultTE = $link->query("SELECT COUNT(*) 
									FROM detsolicitudfrecuencias 
									WHERE NRegDes=".$TabQRY[$n]["NRegistro"]." 
									AND Estatus = 'EFECTIVA'
									AND NRegSol > ".$WC["SIT"]."
									AND NRegFre IN
													(SELECT NRegFre 
														FROM detturnofrecuencias 
														WHERE NRegTur IN 
													(SELECT NRegistro 
														FROM turnos 
														WHERE Estatus = 'ABIERTO' ORDER BY NRegistro DESC) 
													AND NRegUsu = ".$TabQRY[$n]["NRegistro"].")");
									for ($TabQRYTE = array();$tmpTE = $resultTE->fetch_array(MYSQLI_BOTH);){
										$TabQRYTE[] = $tmpTE;
									}																									
									echo $TabQRYTE[0][0];
								}								
							}else{
								echo $Valor;
							}
						echo "</td>";
					}
				echo "<tr>";
			}
		}
	echo "</table>";
	
	if ($HacVisID != ""){
		//echo $HacVisID."***";
	}	
}
$link->close;
?>