<?php
function CreaModulo($Conf,$Cont,$link){	
	$TitCam = split(",",$Cont["TitCam"]);
	$Campos = split(",",$Cont["Campos"]);
	
	$trPF = "#FFFFFF";//Color tr Primera Fila
	$trSF = "#DEDEDE";//Color tr Segunda Fila
	
	$OpcDefMod = split("-",$Cont["OpcDef"]);
	
	//Buscar Permisos
	//Descripcion contenido campo permisos = s/n-s/n-s/n-s/n-s/n-s/n-s/n-s/n = 0,1,2,3,4,5,6,7
	//$OpcDef[0] = s/n (Controles Edicion)
	//$OpcDef[1] = s/n (Puede Agregar)
	//$OpcDef[2] = s/n (Puede Modificar)
	//$OpcDef[3] = s/n (Puede Eliminar)
	//$OpcDef[4] = s/n (Puede Ver Detalles)
	//$OpcDef[5] = s/n (Puede Imprimir)
	//$OpcDef[6] = s/n (Puede Exportar)
	//$OpcDef[7] = s/n (Puede Buscar)
	
	$resultAcc = $link->query("SELECT NRegPer FROM detusuario WHERE NRegUsu = ".$_SESSION["CodUsuAct"]." AND Estatus = 'ACTIVO'");
	for ($AccQRY = array();$AccTmp = $resultAcc->fetch_array(MYSQLI_BOTH);){$AccQRY[] = $AccTmp;}
	for ($n = 0; $n <= (count($AccQRY) -1); $n++){
		$resultAcc2 = $link->query("SELECT Opciones FROM acceso WHERE NRegPer = ".$AccQRY[$n][0]." AND NRegMen = ".$_POST["idm"]." AND Estatus = 'ACTIVO'");
		for ($AccQRY2 = array();$AccTmp2 = $resultAcc2->fetch_array(MYSQLI_BOTH);){$AccQRY2[] = $AccTmp2;}
		for ($n2 = 0; $n2 <= (count($AccQRY2) - 1); $n2++){
			$Opc[] = $AccQRY2[$n][0];
			if ($n2 == 0){
				$OpcDef = split("-",$Opc[$n2]);
			}elseif ($n2 > 0){
				$ComOpcA = split("-",$Opc[($n2 - 1)]);
				$ComOpcB = split("-",$Opc[$n2]);
				for ($n3 = 0; $n3 <= (count($ComOpcA) - 1); $n3++){
					if ($ComOpcA[$n3] == "N" and $ComOpcB[$n3] == "N"){
						$OpcDef[] = "N";
					}else{
						$OpcDef[] = "S";
					}
				}
			}
		}
	}
	
	if (count($OpcDefMod) > 1){
		for ($n = 0; $n <= (count($OpcDefMod) - 1); $n++){
			$OpcDef[$n] = $OpcDefMod[$n];			
		}
	}
	
	//Query Buscar	
	$resultBus = $link->query("SELECT * FROM buscar WHERE NRegUsu = ".$_SESSION["CodUsuAct"]." AND Modulo = '".$_POST["mod"]."'");	
	if ($resultBus->num_rows > 0){
		$Filtros = "";
		for ($BusQRY = array();$tmpBus = $resultBus->fetch_array(MYSQLI_BOTH);){$BusQRY[] = $tmpBus;}
		for ($n = 0; $n <= (count($BusQRY) -1); $n++){
			if ($n > 0){
				if($n < count($BusQRY)){
					$Filtros = $Filtros." AND ";
				}
			}
			
			list($dd,$mm,$yy) = explode("-",$BusQRY[$n]["Valor"]); 
			if (is_numeric($yy) && is_numeric($mm) && is_numeric($dd)){ 
				if (checkdate($mm,$dd,$yy)){$BusQRY[$n]["Valor"] = $yy."-".$mm."-".$dd;}
			}
			
			switch($BusQRY[$n]["Compa"]){
				case "Semejante":
					$Filtros = $Filtros.$BusQRY[$n]["Campo"]." LIKE '%".$BusQRY[$n]["Valor"]."%'";
				break;
				case "Igual":
					$Filtros = $Filtros.$BusQRY[$n]["Campo"]." = '".$BusQRY[$n]["Valor"]."'";
				break;
				case "Mayor":
					$Filtros = $Filtros.$BusQRY[$n]["Campo"]." > '".$BusQRY[$n]["Valor"]."'";
				break;
				case "Menor":
					$Filtros = $Filtros.$BusQRY[$n]["Campo"]." < '".$BusQRY[$n]["Valor"]."'";
				break;
			}
		}		
	}
	

	//Query Principal Modulo
	if ($_POST["Orden"] != ""){$Orden = "ORDER BY ".$_POST["Orden"];}else{$Orden = $Cont["Orden"];}
	if ($Filtros != ""){
		if ($Cont["Donde"] == ""){
			$Cont["Donde"] = "WHERE ".$Filtros;
		}else{
			$Cont["Donde"] = $Cont["Donde"]." AND ".$Filtros;		
		}
	}
	$QryPri = "SELECT ".$Cont["Campos"]." FROM ".$Cont["Tabla"]." ".$Cont["Donde"]." ".$Orden." ".$Cont["Limit"];
	
	$result = $link->query($QryPri);
	$NFilas = $result->num_rows;
	//$NFilas=0;
	
	for ($TabQRY = array();$tmp = $result->fetch_array(MYSQLI_BOTH);){$TabQRY[] = $tmp;}
	for ($CmpQRY = array();$tmp2 = $result->fetch_field();){$CmpQRY[] = $tmp2;}
	
	$CmpPas = split(",",$_SESSION["Form"]["Widgets"]["W0"]["Contenido"]["CmpPas"]);
	
	//Alineacion td
	$CmpSel = $_SESSION["Form"]["Widgets"]["W0"]["Contenido"]["CmpSel"]["Cmp"];
	for ($n = 0; $n <= (count($CmpQRY) -1); $n++){		
		if ($CmpSel[$n-1]["Tipo"] == "Select"){
			$Alineacion[]="left";
		}else{
			switch($CmpQRY[$n]->type){
				case 1: $Alineacion[]="center"; break; //boleano				
				case 3: $Alineacion[]="right"; break; //integer				
				case 5: $Alineacion[]="right"; break; //double				
				case 10: $Alineacion[]="center"; break; //date				
				case 11: $Alineacion[]="center"; break; //time				
				case 252: $Alineacion[]="center"; break; //text				
				case 253: $Alineacion[]="left"; break; //varchar				
			}
		}
	}	
	//DIV para la Tabla del Modulo
	echo "<div id='TabMod' class='TabMod'>";		
		echo "<table id='EncTabMod' class='EncTabMod'>";
			echo "<tr>";
				if ($OpcDef[0] == "S"){
					echo "<td id='tdEncTabMod' title='Acciones' class='tdEncTabMod' align='center' style='cursor:default'></td>";
				}
				for ($n = 0; $n <= count($TitCam)-1; $n++){
					if ($_POST["Orden"] == $Campos[$n]){
						$TexCol = "[<em>".$TitCam[$n]."</em>]";
					}else{
						$TexCol = $TitCam[$n];
					}
					echo "<td id='tdEncTabMod".$n."' title='Ordenar por ".$TitCam[$n]."' 
					onclick='CargaPagina(\"modulos/".$_POST["mod"]."\", \"".$_POST["tit"]."\",\"idm=".$_POST["idm"]."&mod=".$_POST["mod"]."&tit=".$_POST["tit"]."&Orden=".$Campos[$n]."\");' 
					class='tdEncTabMod' align='".$Alineacion[$n]."'>".$TexCol."</td>";
				}
			echo "</tr>";
		
			if ($NFilas == 0){
				if ($OpcDef[0] == "S"){$CanCol = (count($TitCam) + 1);}else{$CanCol = count($TitCam);}
				echo "<tr bgcolor='".$trPF."'><td id='tdNER' class='tdNER' colspan='".$CanCol."'>No existen registros</td></tr>";
			}else{
				for ($n = 0; $n <= ($NFilas - 1); $n++){
					if ($Par != $trPF){$Par = $trPF;}else{$Par = $trSF;}
					echo "<tr bgcolor='".$Par."'>";
						if ($OpcDef[0] == "S"){
							echo "<td id='tdDetTabMod' class='tdDetTabMod' align='center'>";
								//Boton Detalles
								if ($OpcDef[4] == "S"){
									echo "<img id='ImgDet".$n."' src='img/Detalles.png' class='BotFil' 
									title='Detalles' alt='Detalles'
									onmouseover='javascript:CambiarImagen(\"ImgDet".$n."\",\"img/DetallesB.png\");'
									onmouseout='javascript:CambiarImagen(\"ImgDet".$n."\",\"img/Detalles.png\");'
									onclick='
									EjecutaTrabajo(\"Ninguna\",\"\",\"Ejecutar=Cargar&Accion=Detalles&ValorIndice=".$TabQRY[$n][0]."\");
									CargaPagina(\"modulos/formulario.php\",\"Detalles de Registro en ".$Conf["Titulo"]."\",\"Accion=Detalles&ValorIndice=".$TabQRY[$n][0]."&Orden=".$_POST["Orden"]."\");' 
									/>";
									echo "<br />";
								}
								
								//Boton Modificar
								if ($OpcDef[2] == "S"){
									echo "<img id='ImgMod".$n."' src='img/Modificar.png' class='BotFil' 
									title='Modificar' alt='Modificar'
									onmouseover='javascript:CambiarImagen(\"ImgMod".$n."\",\"img/ModificarB.png\");' 
									onmouseout='javascript:CambiarImagen(\"ImgMod".$n."\",\"img/Modificar.png\");'
									onclick='
									EjecutaTrabajo(\"Ninguna\",\"\",\"Ejecutar=Cargar&Accion=Modificar&ValorIndice=".$TabQRY[$n][0]."\");
									CargaPagina(\"modulos/formulario.php\",\"Modificar Registro de ".$Conf["Titulo"]."\",\"Accion=Modificar&ValorIndice=".$TabQRY[$n][0]."&Orden=".$_POST["Orden"]."\");' 
								/>";
								echo "<br />";
								}
								//Boton Eliminar
								if ($OpcDef[3] == "S"){
									echo "<img id='ImgEli".$n."' src='img/Eliminar.png' class='BotFil' 
									title='Eliminar' alt='Eliminar'
									onmouseover='javascript:CambiarImagen(\"ImgEli".$n."\",\"img/EliminarB.png\");' 
									onmouseout='javascript:CambiarImagen(\"ImgEli".$n."\",\"img/Eliminar.png\");'
									onclick='
									EjecutaTrabajo(\"Ninguna\",\"\",\"Ejecutar=Cargar&Accion=Eliminar&ValorIndice=".$TabQRY[$n][0]."\");
									CargaPagina(\"modulos/formulario.php\",\"Eliminar Registro de ".$Conf["Titulo"]."\",\"Accion=Eliminar&ValorIndice=".$TabQRY[$n][0]."&Orden=".$_POST["Orden"]."\");' 
									/>";
								}
							echo "</td>";
						}
												
						for ($n2 = 0; $n2 <= count($Campos)-1; $n2++){
							switch($CmpQRY[$n2]->type){
								case 1://boleano 
									if ($TabQRY[$n][$n2] == true){$Valor = "Si";}else{$Valor = "No";} 
								break;								
								case 3://integer
									$Valor = number_format($TabQRY[$n][$n2], 0, ',', '.'); 
								break; 
								case 5://double 
									$Valor = number_format($TabQRY[$n][$n2], 2, ',', '.'); 
								break; 
								case 10://date
									$FT = split("-",$TabQRY[$n][$n2]);
									$Valor = $FT[2]."-".$FT[1]."-".$FT[0];
								break; 
								case 11://time
									$Valor = $TabQRY[$n][$n2]; 
								break; 
								case 252://text
									$Valor = $TabQRY[$n][$n2]; 
								break; 
								case 253://varchar
									$Valor = $TabQRY[$n][$n2]; 
								break;
							}
							
							if ($CmpPas[$n2-1] == "s"){$Valor = "****";}
							
							echo "<td id='tdDetTabMod".$n.$n2."' class='tdDetTabMod' align='".$Alineacion[$n2]."'>";

								if ($CmpSel[$n2-1]["Tipo"] == "Select"){									
									$resultCS = $link->query("SELECT ".$CmpSel[$n2-1]["Campos"]." FROM ".$CmpSel[$n2-1]["Tablas"]." WHERE ".$CmpSel[$n2-1]["Compara"]."='".$TabQRY[$n][$n2]."'");
									for ($TabQRYCS = array();$tmpCS = $resultCS->fetch_array(MYSQLI_BOTH);){
										$TabQRYCS[] = $tmpCS;
									}
									if ($resultCS->num_rows > 0){
										//echo $TabQRY[$n][$n2]." - ".$TabQRYCS[0][1];
										echo $TabQRY[$n][$n2]." - ";										
										$CmpVI = split(",",$CmpSel[$n2-1]["Campos"]);										
										for ($nCmpVI = 1; $nCmpVI <= (count($CmpVI) -1); $nCmpVI++){
											if ($nCmpVI < 2){
												echo $TabQRYCS[0][$CmpVI[$nCmpVI]];
											}else{
												echo " - ".substr($TabQRYCS[0][$CmpVI[$nCmpVI]],0,30);
											}								
										}
									}else{
										echo $TabQRY[$n][$n2]." - ???";
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
	echo "</div>";
	
	//DIV para las Opciones del Modulo
	echo "<div id='OpcMod' class='OpcMod'>";
		echo "<table id='TabOpcMod' class='TabOpcMod'>";
			echo "<tr>";				
				echo "<td id='Op1' class='tdTabOpcMod'>";
					echo $NFilas." Registros";
				echo "</td>";
				echo "<td id='Op2' class='tdTabOpcMod'>";
				echo "</td>";
				echo "<td id='Op3' class='tdTabOpcMod'>";
				echo "</td>";
				echo "<td id='Op4' class='tdTabOpcMod'>";
					if ($OpcDef[0] == "S"){
						if ($OpcDef[1] == "S"){
							echo "<img id='ImgOpc9' src='img/Agregar.png' class='BotOpc' 
							title='Agregar' alt='Agregar'
							onmouseover='javascript:CambiarImagen(\"ImgOpc9\",\"img/AgregarB.png\");' 
							onmouseout='javascript:CambiarImagen(\"ImgOpc9\",\"img/Agregar.png\");'
							onclick='javascript:
							EjecutaTrabajo(\"Ninguna\",\"\",\"Ejecutar=Limpiar&Nivel=Modulo&NRegUsu=".$_SESSION["CodUsuAct"]."&NRegMod=".$_SESSION["Form"]["Modulo"]["IDMenu"]."\");
							CargaPagina(\"modulos/formulario.php\",\"Agregar Registro en ".$Conf["Titulo"]."\",\"Accion=Agregar&Orden=".$_POST["Orden"]."\");";
							
							switch ($Conf["Titulo"]){
								case "SOLICITUDES":
									echo "AutoCargaLista(\"W4\",4987,\"A\");";
									echo "RepiteRevNumEnt();";
								break;
								case "DESPACHOS":
									echo "AutoCargaLista(\"W4\",4987,\"A\");";
								break;
								case "DESPACHOS AMBULANCIAS":
									echo "AutoCargaLista(\"W4\",4987,\"A\");";
								break;					
							}							
							echo "'/>";							
						}
					}
				echo "</td>";
				echo "<td id='Op5' class='tdTabOpcMod'>";
					if ($Filtros != ""){
						$_SESSION["BuscarMod"] = $_POST["mod"];
						$_SESSION["BuscarNomCam"] = $Cont["Campos"];
						$_SESSION["BuscarTitCam"] = $Cont["TitCam"];
						echo "<a href='#' onclick='javascript:BorBuscar(\"".$_POST["idm"]."\",\"".$_POST["mod"]."\",\"".$_POST["tit"]."\");'>Eliminar Filtros</a>";
					}
				echo "</td>";
				echo "<td id='Op6' class='tdTabOpcMod'>";
					if ($OpcDef[7] == "S"){
						
						$ProCampos = split(",",$Cont["Campos"]);
						$ProTitulos = split(",",$Cont["TitCam"]);
						for ($n = 0; $n < count($ProCampos); $n++){
							if (stripos($ProCampos[$n], " AS ") == true){
								$X = split(" AS ",$ProCampos[$n]);
								$ProCampos[$n] = $X[1];
							}else{
								if ($n == 0){
									$CamposLimpios = $ProCampos[$n];
									$TitulosLimpios = $ProTitulos[$n];
								}else{
									$CamposLimpios = $CamposLimpios.",".$ProCampos[$n];
									$TitulosLimpios = $TitulosLimpios.",".$ProTitulos[$n];
								}							
							}							
						}						
						
						$_SESSION["BuscarMod"] = $_POST["mod"];
						$_SESSION["BuscarNomCam"] = $Cont["Campos"];
						$_SESSION["BuscarTitCam"] = $Cont["TitCam"];						
												//onclick='javascript:IniBuscar(\"".$Cont["TitCam"]."\",\"".$Cont["Campos"]."\",\"".$_POST["idm"]."\",\"".$_POST["mod"]."\",\"".$_POST["tit"]."\");'
						
						echo "<img id='ImgOpc6' src='img/Buscar.png' class='BotOpc' 
						title='Buscar' alt='Buscar'
						onmouseover='javascript:CambiarImagen(\"ImgOpc6\",\"img/BuscarB.png\");' 
						onmouseout='javascript:CambiarImagen(\"ImgOpc6\",\"img/Buscar.png\");'
						onclick='javascript:IniBuscar(\"".$TitulosLimpios."\",\"".$CamposLimpios."\",\"".$_POST["idm"]."\",\"".$_POST["mod"]."\",\"".$_POST["tit"]."\");'
						/>";
					}
				echo "</td>";
				echo "<td id='Op7' class='tdTabOpcMod'>";
					if ($OpcDef[6] == "S"){
						
						$_SESSION["QryPri"] = $QryPri;
						//onclick='javascript:IniExportar(\"".str_replace("'",":",$QryPri)."\",\"".$Cont["TitCam"]."\",\"".$Conf["Titulo"]."\",\"".$_SESSION["NomUsuAct"]."\");' 
						echo "<img id='ImgOpc7' src='img/Exportar.png' class='BotOpc' 
						title='Exportar' alt='Exportar'
						onmouseover='javascript:CambiarImagen(\"ImgOpc7\",\"img/ExportarB.png\");' 
						onmouseout='javascript:CambiarImagen(\"ImgOpc7\",\"img/Exportar.png\");'
						onclick='javascript:IniExportar(\"\",\"".$Cont["TitCam"]."\",\"".$Conf["Titulo"]."\",\"".$_SESSION["NomUsuAct"]."\");' 
						/>";	
					}
				echo "</td>";
				echo "<td id='Op8' class='tdTabOpcMod'>";
					if ($OpcDef[5] == "S"){
						
						$_SESSION["QryPri"] = $QryPri;
						
						//echo "IniImprimir(\"".str_replace ("'",":",$QryPri)."\",\"".$Cont["TitCam"]."\",\"".$Conf["Titulo"]."\",\"".$_SESSION["NomUsuAct"]."\",\"".$Conf["TipPap"]."\",\"".$Conf["OriPap"]."\",LisAncCol);'/>";						
												
						echo "<img id='ImgOpc8' src='img/Imprimir.png' class='BotOpc' 
						title='Imprimir' alt='Imprimir'
						onmouseover='javascript:CambiarImagen(\"ImgOpc8\",\"img/ImprimirB.png\");' 
						onmouseout='javascript:CambiarImagen(\"ImgOpc8\",\"img/Imprimir.png\");'
						onclick='javascript:
						var LisAncCol = \"\";";						
						for ($n = 0; $n <= count($TitCam)-1; $n++){
							if ($n == 0){
								echo "LisAncCol = document.getElementById(\"tdEncTabMod".$n."\").offsetWidth;";
							}else{
								echo "LisAncCol = LisAncCol + \",\" + document.getElementById(\"tdEncTabMod".$n."\").offsetWidth;";
							}
						}						
						echo "IniImprimir(\"\",\"".$Cont["TitCam"]."\",\"".$Conf["Titulo"]."\",\"".$_SESSION["NomUsuAct"]."\",\"".$Conf["TipPap"]."\",\"".$Conf["OriPap"]."\",LisAncCol);'/>";						
					}
				echo "</td>";
				echo "<td id='Op9' class='tdTabOpcMod'>";
					
				echo "</td>";
				echo "<td id='Op10' class='tdTabOpcMod'>";
					echo "<img id='ImgOpc10' src='img/Regresar.png' class='BotOpc' 
					title='Regresar' alt='Regresar'
					onmouseover='javascript:CambiarImagen(\"ImgOpc10\",\"img/RegresarB.png\");' 
					onmouseout='javascript:CambiarImagen(\"ImgOpc10\",\"img/Regresar.png\");'
					onclick='CargaPagina(\"modulos/mp.php\", \"Menú Principal\",\"\");' 
					/>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	echo "</div>";
}
?>