<?php 
session_start(); 
include("bd.php");
include("funcvari.php");
$Form = $_SESSION["Form"];
$Accion = $_POST["Accion"];
$ValorIndice = $_POST["ValorIndice"];

?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<STYLE TYPE="text/css">

</STYLE>

</head>
<body>
<?php
$TabIndCmp = 1;
foreach ($Form["Widgets"] as $Widget){	
	echo "<div class='divWidget' id='".$Widget["ID"]."' style='top:".$Widget["Apariencia"]["PosSup"].";bottom:".$Widget["Apariencia"]["PosInf"].";right:".$Widget["Apariencia"]["PosDer"].";left:".$Widget["Apariencia"]["PosIzq"].";height:".$Widget["Apariencia"]["Alto"].";width:".$Widget["Apariencia"]["Ancho"].";'>";	
	$AncTit = substr($Widget["Apariencia"]["Ancho"], 0, -2);
	$AncTit = $AncTit - 8;	
	echo "<div class='divTitWidget' id='divTit".$Widget["ID"]."' style='width:".$AncTit."px;'>".$Widget["Titulo"]."</div>";		
		
		$WC = $Widget["Contenido"];
		switch($WC["Tipo"]){
			case "Campos":
				$AltTab = substr($Widget["Apariencia"]["Alto"], 0, -2);
				$AltTab = $AltTab - 60;
				echo "<form name='form".$WC["ID"]."' id='form".$WC["ID"]."' method='post' action='' enctype = 'multipart/form-data'>";				
				$nCA = 0;
				$Campos = split(",",$WC["Campos"]);
				$CmpCol = split(",",$WC["CmpCol"]);
				$CmpFil = split(",",$WC["CmpFil"]);				
				echo "<table cellspacing='".$WC["DisTab"]["CSp"]."' cellpadding='".$WC["DisTab"]["CPa"]."' border='".$WC["DisTab"]["Brd"]."' style='width:".$AncTit."px;height:".$AltTab."px;'>";
				for ($n = 1; $n <= $WC["DisTab"]["Fil"]; $n++){
					if ($CmpFil[$nCA] !=""){$CmpFil[$nCA] = "rowspan='".$CmpFil[$nCA]."'";}
					echo "<tr ".$CmpFil[$nCA].">";
					for ($n2 = 1; $n2 <= $WC["DisTab"]["Col"]; $n2++){
						if ($CmpCol[$nCA] !=""){
							$n2 = $n2 + ($CmpCol[$nCA] - 1);
							$CmpCol[$nCA] = "colspan='".$CmpCol[$nCA]."'";
						}
						echo "<td class='tdWidgetCampos' ".$CmpCol[$nCA].">";
							$TipCam = CreaCampo($nCA,$Widget,$Accion,$ValorIndice,$TabIndCmp,$link);						
						echo "</td>";						
						if ($nCA < count($Campos)){
							if ($nCA == 0){$IDs = $WC["ID"].$nCA;}else{$IDs = $IDs.",".$WC["ID"].$nCA;}
							if ($nCA == 0){$TipCams = $TipCam;}else{$TipCams = $TipCams.",".$TipCam;}
						}
						$nCA++;
						$TabIndCmp++;						
					}					
					echo "</tr>";
				}				
				echo "</table>";
				
				$resultNRR = $link->query("SELECT NRegReg FROM trabajo WHERE NRegUsu = ".$_SESSION["CodUsuAct"]." AND NRegMod = ".$_SESSION["Form"]["Modulo"]["IDMenu"]." AND Widget = '".$WC["ID"]."' AND Form = 'form".$WC["ID"]."' AND Accion = '".$Accion."' ORDER BY NRegistro");
				for ($TabQRYNRR = array();$tmp = $resultNRR->fetch_array(MYSQLI_BOTH);){$TabQRYNRR[] = $tmp;}				
				echo "<input id='NRegReg".$WC["ID"]."0' type='hidden' value='".$TabQRYNRR[0][0]."'>";
				echo "<input id='NueReg".$WC["ID"]."0' type='hidden' value=''>";
				echo "<input id='ValorIndice".$WC["ID"]."' type='hidden' value='".$ValorIndice."'>";
				echo "<input id='Accion".$WC["ID"]."' type='hidden' value='".$Accion."'>";
				
				echo "<input id='Res".$WC["ID"]."0' type='hidden' value=''>";
				echo "</form>";
				
				if ($WC["Accion"] != "Ninguna"){
					echo "<div class='divPieWidgetCampos' style='width:".$AncTit."px;'>";
						if ($Accion == "Agregar" or $Accion == "Modificar" or $Accion == "Dinamico"){
							if ($WC["Accion"]["Verificar"]["Hacer"] == "Si"){
								$Hacer = "Verificar";
								echo "<img id='ImgVer".$WC["ID"]."' src='img/Verificar.png' class='BotCmpLis' 
									title='Verificar' alt='Verificar'
									onmouseover='
									javascript:CambiarImagen(\"ImgVer".$WC["ID"]."\",\"img/VerificarB.png\");' 
									onmouseout='
									javascript:CambiarImagen(\"ImgVer".$WC["ID"]."\",\"img/Verificar.png\");'
									onclick='
									javascript:ProcesaWidget(\"".$IDs."\",\"".$TipCams."\",\"".$WC["CmpReq"]."\",\"".$WC["Tipo"]."\",\"".$Hacer."\",\"\",\"".$WC["ID"]."\",\"form".$WC["ID"]."\",\"".$Accion."\",\"".$WC["Tabla"]."\",\"".$WC["Indice"]."\",\"".$ValorIndice."\",\"".$WC["Campos"]."\",document.getElementById(\"NRegReg".$WC["ID"]."0\").value,\"ImgVer".$WC["ID"]."\",\"Ninguna\",\"\");'
								/>";
								echo "";
							}
							
							if ($WC["Accion"]["MostrarFrecuencias"]["Hacer"] == "Si"){
								$Hacer = "MostrarFrecuencias";
								
								$resFA = $link->query("SELECT 
															(SELECT Descripcion 
																FROM Frecuencias 
																WHERE NRegistro = A.NRegFre) AS Frecuencia
														FROM detturnofrecuencias A
														WHERE NRegTur IN (SELECT NRegistro 
																			FROM Turnos 
																			WHERE Estatus = 'ABIERTO' 
																			ORDER BY NRegistro DESC)
														AND NRegUsu = ".$_SESSION["CodUsuAct"]);
								for ($TabQRYFA = array();$tmp = $resFA->fetch_array(MYSQLI_BOTH);){
									$TabQRYFA[] = $tmp;
								}								
								
								for ($nFA = 0; $nFA < $resFA->num_rows; $nFA++){
									if ($nFA == 0){
										$MFA = $TabQRYFA[$nFA][0];
									}else{
										$MFA = $MFA." - ".$TabQRYFA[$nFA][0];
									}									
								}
								
								echo "<img id='ImgMF".$WC["ID"]."' src='img/Antena.png' class='BotWidSol2' 
									title='Frecuencias Asignadas' alt='Frecuencias Asignadas'
									onmouseover='
									javascript:CambiarImagen(\"ImgMF".$WC["ID"]."\",\"img/AntenaB.png\");' 
									onmouseout='
									javascript:CambiarImagen(\"ImgMF".$WC["ID"]."\",\"img/Antena.png\");'
									onclick='MensajeEmergente(\"".$MFA."\",\"Abajo\",\"ImgMF".$WC["ID"]."\",0,0,\"#00F\");'
								/>";
							}
							
							if ($WC["Accion"]["BuscarRepetidas"]["Hacer"] == "Si"){
								$Hacer = "BuscarRepetidas";
								echo "<img id='ImgBR".$WC["ID"]."' src='img/Repetida.png' class='BotWidSol2' 
									title='Buscar Repetidas' alt='Buscar Repetidas'
									onmouseover='
									javascript:CambiarImagen(\"ImgBR".$WC["ID"]."\",\"img/RepetidaB.png\");' 
									onmouseout='
									javascript:CambiarImagen(\"ImgBR".$WC["ID"]."\",\"img/Repetida.png\");'
									onclick='javascript:IniBuscarRep();'
								/>";
							}
							
							if ($WC["Accion"]["BuscarSectores"]["Hacer"] == "Si"){
								$Hacer = "BuscarSectores";
								echo "<img id='ImgBS".$WC["ID"]."' src='img/Binocular.png' class='BotWidSol2' 
									title='Buscar Sectores' alt='Buscar Sectores'
									onmouseover='
									javascript:CambiarImagen(\"ImgBS".$WC["ID"]."\",\"img/BinocularB.png\");' 
									onmouseout='
									javascript:CambiarImagen(\"ImgBS".$WC["ID"]."\",\"img/Binocular.png\");'
									onclick='javascript:IniBuscarSec();'
								/>";
							}
							
							if ($WC["Accion"]["ModificarDespacho"]["Hacer"] == "Si" and $Accion == "Modificar"){
								$Hacer = "Verificar";
								echo "<img id='ImgMD".$WC["ID"]."' src='img/ModificarDespacho.png' class='BotWidSol' 
									title='Modificar Despacho' alt='Modificar Despacho'
									onmouseover='
									javascript:CambiarImagen(\"ImgMD".$WC["ID"]."\",\"img/ModificarDespachoB.png\");' 
									onmouseout='
									javascript:CambiarImagen(\"ImgMD".$WC["ID"]."\",\"img/ModificarDespacho.png\");'
									onclick='
									javascript:ProcesaWidget(\"".$IDs."\",\"".$TipCams."\",\"".$WC["CmpReq"]."\",\"".$WC["Tipo"]."\",\"".$Hacer."\",\"\",\"".$WC["ID"]."\",\"form".$WC["ID"]."\",\"".$Accion."\",\"".$WC["Tabla"]."\",\"".$WC["Indice"]."\",\"".$ValorIndice."\",\"".$WC["Campos"]."\",document.getElementById(\"NRegReg".$WC["ID"]."0\").value,\"ImgMD".$WC["ID"]."\",\"Ninguna\",\"\");'
								/>";
								echo "";
							}
							
							if ($WC["Accion"]["SIN DESPACHO"]["Hacer"] == "Si" and $Accion == "Modificar"){
								$Hacer = "Verificar";								
								echo "<img id='ImgSD".$WC["ID"]."' src='img/SinDespacho.png' class='BotWidSol' 
									title='SIN DESPACHO' alt='SIN DESPACHO'
									onmouseover='
									javascript:CambiarImagen(\"ImgSD".$WC["ID"]."\",\"img/SinDespachoB.png\");' 
									onmouseout='
									javascript:CambiarImagen(\"ImgSD".$WC["ID"]."\",\"img/SinDespacho.png\");'
									onclick='
									javascript:
									var Res = ProcesaWidget(\"".$IDs."\",\"".$TipCams."\",\"".$WC["CmpReq"]."\",\"".$WC["Tipo"]."\",\"".$Hacer."\",\"\",\"".$WC["ID"]."\",\"form".$WC["ID"]."\",\"".$Accion."\",\"".$WC["Tabla"]."\",\"".$WC["Indice"]."\",\"".$ValorIndice."\",\"".$WC["Campos"]."\",document.getElementById(\"NRegReg".$WC["ID"]."0\").value,\"ImgSD".$WC["ID"]."\",\"Ninguna\",\"\");
									if (Res == true){
										VerProCom(\"Res".$WC["ID"]."0\",\"".$ValorIndice."\");
										setTimeout(VerProSD,500);
										function VerProSD(){
											if (document.getElementById(\"Res".$WC["ID"]."0\").value == 0){
												ActEstatusSolicitud(\"".$ValorIndice."\",\"SIN DESPACHO\");												EjecutaTrabajo(\"Ninguna\",\"\",\"Ejecutar=Completar&Accion=Modificar\");
												setTimeout(VerPro2,500);
												function VerPro2(){
													BusPriPen(\"Res".$WC["ID"]."0\",\"".$ValorIndice."\");
													setTimeout(VerPro3,500);
													function VerPro3(){														
														EjecutaTrabajo(\"Ninguna\",\"\",\"Ejecutar=Cargar&Accion=Modificar&ValorIndice=\" + document.getElementById(\"Res".$WC["ID"]."0\").value);
														CargaPagina(\"modulos/formulario.php\",\"Modificar Registro de ".$_SESSION["Form"]["Modulo"]["Titulo"]."\",\"Accion=Modificar&ValorIndice=\" + document.getElementById(\"Res".$WC["ID"]."0\").value);
													}
												}
											}else{
												MensajeEmergente(\"Primero debe cargar todos los procedimientos\",\"Arriba\",\"W3\",0,0,\"#F80\");												
											}
										}
									}
									' />";
								echo "";
							}
							
							if ($WC["Accion"]["SIN EFECTO"]["Hacer"] == "Si" and $Accion == "Modificar"){
								$Hacer = "Verificar";								
								echo "<img id='ImgSE".$WC["ID"]."' src='img/SinEfecto.png' class='BotWidSol' 
									title='SIN EFECTO' alt='SIN EFECTO'
									onmouseover='
									javascript:CambiarImagen(\"ImgSE".$WC["ID"]."\",\"img/SinEfectoB.png\");' 
									onmouseout='
									javascript:CambiarImagen(\"ImgSE".$WC["ID"]."\",\"img/SinEfecto.png\");'
									onclick='
									javascript:
									var Res = ProcesaWidget(\"".$IDs."\",\"".$TipCams."\",\"".$WC["CmpReq"]."\",\"".$WC["Tipo"]."\",\"".$Hacer."\",\"\",\"".$WC["ID"]."\",\"form".$WC["ID"]."\",\"".$Accion."\",\"".$WC["Tabla"]."\",\"".$WC["Indice"]."\",\"".$ValorIndice."\",\"".$WC["Campos"]."\",document.getElementById(\"NRegReg".$WC["ID"]."0\").value,\"ImgSE".$WC["ID"]."\",\"Ninguna\",\"\");
									if (Res == true){
										VerProCom(\"Res".$WC["ID"]."0\",\"".$ValorIndice."\");
										setTimeout(VerProSE,500);
										function VerProSE(){
											if (document.getElementById(\"Res".$WC["ID"]."0\").value == 0){																				
												ActEstatusSolicitud(\"".$ValorIndice."\",\"SIN EFECTO\");												EjecutaTrabajo(\"Ninguna\",\"\",\"Ejecutar=Completar&Accion=Modificar\");
												setTimeout(VerPro2,500);
												function VerPro2(){
													BusPriPen(\"Res".$WC["ID"]."0\",\"".$ValorIndice."\");
													setTimeout(VerPro3,500);
													function VerPro3(){														
													EjecutaTrabajo(\"Ninguna\",\"\",\"Ejecutar=Cargar&Accion=Modificar&ValorIndice=\" + document.getElementById(\"Res".$WC["ID"]."0\").value);
														CargaPagina(\"modulos/formulario.php\",\"Modificar Registro de ".$_SESSION["Form"]["Modulo"]["Titulo"]."\",\"Accion=Modificar&ValorIndice=\" + document.getElementById(\"Res".$WC["ID"]."0\").value);
													}
												}
											}else{
												MensajeEmergente(\"Primero debe cargar todos los procedimientos\",\"Arriba\",\"W3\",0,0,\"#F80\");												
											}										
										}
									}
									' />";
								echo "";
							}
							
							if ($WC["Accion"]["Efectivo"]["Hacer"] == "Si" and $Accion == "Modificar"){
								$Hacer = "Verificar";								
								echo "<img id='ImgEF".$WC["ID"]."' src='img/EFECTIVA.png' class='BotWidSol' 
									title='EFECTIVA' alt='EFECTIVA'
									onmouseover='
									javascript:CambiarImagen(\"ImgEF".$WC["ID"]."\",\"img/EFECTIVAB.png\");' 
									onmouseout='
									javascript:CambiarImagen(\"ImgEF".$WC["ID"]."\",\"img/EFECTIVA.png\");'
									onclick='
									javascript:
									var Res = ProcesaWidget(\"".$IDs."\",\"".$TipCams."\",\"".$WC["CmpReq"]."\",\"".$WC["Tipo"]."\",\"".$Hacer."\",\"\",\"".$WC["ID"]."\",\"form".$WC["ID"]."\",\"".$Accion."\",\"".$WC["Tabla"]."\",\"".$WC["Indice"]."\",\"".$ValorIndice."\",\"".$WC["Campos"]."\",document.getElementById(\"NRegReg".$WC["ID"]."0\").value,\"ImgEF".$WC["ID"]."\",\"Ninguna\",\"\");
									if (Res == true){
										VerProCom(\"Res".$WC["ID"]."0\",\"".$ValorIndice."\");
										setTimeout(VerPro,1500);
										function VerPro(){
											if (document.getElementById(\"Res".$WC["ID"]."0\").value == 0){
												ActEstatusSolicitud(\"".$ValorIndice."\",\"EFECTIVA\");												EjecutaTrabajo(\"Ninguna\",\"\",\"Ejecutar=Completar&Accion=Modificar\");
												setTimeout(VerPro2,500);
												function VerPro2(){
													BusPriPen(\"Res".$WC["ID"]."0\",\"".$ValorIndice."\");
													setTimeout(VerPro3,500);
													function VerPro3(){
														if (document.getElementById(\"Res".$WC["ID"]."0\").value == 0){
															CargaPagina(\"modulos/formulario.php\",\"Agregar Registro de ".$_SESSION["Form"]["Modulo"]["Titulo"]."\",\"Accion=Agregar&ValorIndice=\");
														}else{														EjecutaTrabajo(\"Ninguna\",\"\",\"Ejecutar=Cargar&Accion=Modificar&ValorIndice=\" + document.getElementById(\"Res".$WC["ID"]."0\").value);
															CargaPagina(\"modulos/formulario.php\",\"Modificar Registro de ".$_SESSION["Form"]["Modulo"]["Titulo"]."\",\"Accion=Modificar&ValorIndice=\" + document.getElementById(\"Res".$WC["ID"]."0\").value);
														}
													}
												}												
											}else{
												MensajeEmergente(\"Primero debe cargar todos los procedimientos\",\"Arriba\",\"W3\",0,0,\"#F80\");												
											}
										}
									}
									' />";
								echo "";
							}
							
														
							if ($WC["Accion"]["CambiarTurno"]["Hacer"] == "Si"){
								$Hacer = "Verificar";
								echo "<img id='ImgCT".$WC["ID"]."' src='img/CambiarTurno.png' class='BotWidSol' 
									title='Cambiar Turno' alt='Cambiar Turno'
									onmouseover='
									javascript:CambiarImagen(\"ImgCT".$WC["ID"]."\",\"img/CambiarTurnoB.png\");' 
									onmouseout='
									javascript:CambiarImagen(\"ImgCT".$WC["ID"]."\",\"img/CambiarTurno.png\");'
									onclick='javascript:
									document.getElementById(\"".$WC["ID"]."2\").value = \"".date("d-m-Y",time() - 16200)."\";
									document.getElementById(\"".$WC["ID"]."3\").value = \"".date("H:i:s",time() - 16200)."\";
									document.getElementById(\"".$WC["ID"]."7\").value = \"CERRADO\";
									var Res = ProcesaWidget(\"".$IDs."\",\"".$TipCams."\",\"".$WC["CmpReq"]."\",\"".$WC["Tipo"]."\",\"".$Hacer."\",\"\",\"".$WC["ID"]."\",\"form".$WC["ID"]."\",\"".$Accion."\",\"".$WC["Tabla"]."\",\"".$WC["Indice"]."\",\"".$ValorIndice."\",\"".$WC["Campos"]."\",document.getElementById(\"NRegReg".$WC["ID"]."0\").value,\"ImgCT".$WC["ID"]."\",\"Ninguna\",\"\");
									if (Res == true){
										EjecutaTrabajo(\"Valor\",\"NueReg".$WC["ID"]."0\",\"Ejecutar=Completar&Accion=".$Accion."\");
										setTimeout(VerPro1,1500);
										function VerPro1(){											EjecutaTrabajo(\"Ninguna\",\"\",\"Ejecutar=Limpiar&Nivel=Modulo&NRegUsu=".$_SESSION["CodUsuAct"]."&NRegMod=".$_SESSION["Form"]["Modulo"]["IDMenu"]."\");
																				
											document.getElementById(\"".$WC["ID"]."0\").value = \"".date("d-m-Y",time() - 16200)."\";
											document.getElementById(\"".$WC["ID"]."1\").value = \"".date("H:i:s",time() - 16200)."\";
											document.getElementById(\"".$WC["ID"]."2\").value = \"\";
											document.getElementById(\"".$WC["ID"]."3\").value = \"\";										
											document.getElementById(\"".$WC["ID"]."4\").value = \"\";
											document.getElementById(\"".$WC["ID"]."5\").value = \"\";
											document.getElementById(\"".$WC["ID"]."6\").value = \"\";										
											document.getElementById(\"".$WC["ID"]."7\").value = \"ABIERTO\";
											
											
											var Res2 = ProcesaWidget(\"".$IDs."\",\"".$TipCams."\",\"".$WC["CmpReq"]."\",\"".$WC["Tipo"]."\",\"".$Hacer."\",\"\",\"".$WC["ID"]."\",\"form".$WC["ID"]."\",\"Agregar\",\"".$WC["Tabla"]."\",\"".$WC["Indice"]."\",\"\",\"".$WC["Campos"]."\",\"\",\"ImgCT".$WC["ID"]."\",\"Ninguna\",\"\");											
											if (Res2 == true){
												//return;
												EjecutaTrabajo(\"Valor\",\"NueReg".$WC["ID"]."0\",\"Ejecutar=Completar&Accion=Agregar\");
												setTimeout(VerPro,1500);
												function VerPro(){																								EjecutaTrabajo(\"Ninguna\",\"\",\"Ejecutar=Cargar&Accion=Modificar&ValorIndice=\" + document.getElementById(\"NueReg".$WC["ID"]."0\").value);
													
													setTimeout(VerProB,500);
													function VerProB(){
														CargaPagina(\"modulos/formulario.php\",\"Modificar Registro de ".$_SESSION["Form"]["Modulo"]["Titulo"]."\",\"Accion=Modificar&ValorIndice=\" + document.getElementById(\"NueReg".$WC["ID"]."0\").value);
													}
												}
											}
										}
										
									}'/>";
								echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
							}
							
							if ($WC["Accion"]["ModificarTurno"]["Hacer"] == "Si"){
								$Hacer = "Verificar";
								echo "<img id='ImgMT".$WC["ID"]."' src='img/ModificarTurno.png' class='BotWidSol' 
									title='Modificar Turno' alt='Modificar Turno'
									onmouseover='
									javascript:CambiarImagen(\"ImgMT".$WC["ID"]."\",\"img/ModificarTurnoB.png\");' 
									onmouseout='
									javascript:CambiarImagen(\"ImgMT".$WC["ID"]."\",\"img/ModificarTurno.png\");'
									onclick='
									javascript:ProcesaWidget(\"".$IDs."\",\"".$TipCams."\",\"".$WC["CmpReq"]."\",\"".$WC["Tipo"]."\",\"".$Hacer."\",\"\",\"".$WC["ID"]."\",\"form".$WC["ID"]."\",\"".$Accion."\",\"".$WC["Tabla"]."\",\"".$WC["Indice"]."\",\"".$ValorIndice."\",\"".$WC["Campos"]."\",document.getElementById(\"NRegReg".$WC["ID"]."0\").value,\"ImgMT".$WC["ID"]."\",\"Ninguna\",\"\");'
								/>";
								//echo "<br/>";
							}
							
							if ($WC["Accion"]["Sabotaje"]["Hacer"] == "Si"){
								if ($Accion == "Agregar"){
									$Hacer = "Verificar";
									echo "<img id='ImgSab".$WC["ID"]."' src='img/Sabotaje.png' class='BotWidSol' 
										title='Sabotaje' alt='Sabotaje'
										onmouseover='
										javascript:CambiarImagen(\"ImgSab".$WC["ID"]."\",\"img/SabotajeB.png\");' 
										onmouseout='
										javascript:CambiarImagen(\"ImgSab".$WC["ID"]."\",\"img/Sabotaje.png\");'
										onclick='javascript:										
										if (document.getElementById(\"".$WC["ID"]."0\").value != \"\"){
											document.getElementById(\"".$WC["ID"]."1\").value = \"SABOTAJE\";
											document.getElementById(\"".$WC["ID"]."2\").value = \"12\";
											CargaSelect(\"W02\",\"W03\",\"SELECT NRegistro,Descripcion FROM detmotivos WHERE NRegMot=\",\"Descripcion\",\"No\");
											document.getElementById(\"".$WC["ID"]."4\").value = \"SABOTAJE\";
											document.getElementById(\"".$WC["ID"]."5\").value = \"SABOTAJE\";										
											document.getElementById(\"".$WC["ID"]."6\").value = \"0\";
											document.getElementById(\"".$WC["ID"]."7\").value = \"0\";
											document.getElementById(\"".$WC["ID"]."8\").value = \"0\";
											document.getElementById(\"".$WC["ID"]."9\").value = \"0\";
											setTimeout(TOSab,200);
											function TOSab(){
												document.getElementById(\"".$WC["ID"]."3\").value = \"137\";
												
												var Res = ProcesaWidget(\"".$IDs."\",\"".$TipCams."\",\"".$WC["CmpReq"]."\",\"".$WC["Tipo"]."\",\"".$Hacer."\",\"\",\"".$WC["ID"]."\",\"form".$WC["ID"]."\",\"".$Accion."\",\"".$WC["Tabla"]."\",\"".$WC["Indice"]."\",\"".$ValorIndice."\",\"".$WC["Campos"]."\",document.getElementById(\"NRegReg".$WC["ID"]."0\").value,\"ImgSab".$WC["ID"]."\",\"Ninguna\",\"\");
												if (Res == true){																						
													EjecutaTrabajo(\"Valor\",\"NueReg".$WC["ID"]."0\",\"Ejecutar=Completar&Accion=".$Accion."\");												
													setTimeout(VerPro,250);
													function VerPro(){												
														ActEstatusSolicitud(document.getElementById(\"NueReg".$WC["ID"]."0\").value,\"SABOTAJE\");												
														CargaPagina(\"modulos/formulario.php\",\"Agregar Registro en ".$_SESSION["Form"]["Modulo"]["Titulo"]."\",\"Accion=Agregar\");
													}
													
												}
											}
										}
										'/>";
								}
							}
							
							if ($WC["Accion"]["Abandono"]["Hacer"] == "Si"){
								if ($Accion == "Agregar"){
									$Hacer = "Verificar";
									echo "<img id='ImgAba".$WC["ID"]."' src='img/Abandono.png' class='BotWidSol' 
										title='Abandono' alt='Abandono'
										onmouseover='
										javascript:CambiarImagen(\"ImgAba".$WC["ID"]."\",\"img/AbandonoB.png\");' 
										onmouseout='
										javascript:CambiarImagen(\"ImgAba".$WC["ID"]."\",\"img/Abandono.png\");'
										onclick='javascript:
										if (document.getElementById(\"".$WC["ID"]."0\").value != \"\"){
											document.getElementById(\"".$WC["ID"]."1\").value = \"ABANDONO\";
											document.getElementById(\"".$WC["ID"]."2\").value = \"12\";
											CargaSelect(\"W02\",\"W03\",\"SELECT NRegistro,Descripcion FROM detmotivos WHERE NRegMot=\",\"Descripcion\",\"No\");
											document.getElementById(\"".$WC["ID"]."4\").value = \"ABANDONO\";
											document.getElementById(\"".$WC["ID"]."5\").value = \"ABANDONO\";
											document.getElementById(\"".$WC["ID"]."6\").value = \"0\";
											document.getElementById(\"".$WC["ID"]."7\").value = \"0\";
											document.getElementById(\"".$WC["ID"]."8\").value = \"0\";
											document.getElementById(\"".$WC["ID"]."9\").value = \"0\";
											setTimeout(TOAba,200);
											function TOAba(){
												document.getElementById(\"".$WC["ID"]."3\").value = \"138\";
												
												var Res = ProcesaWidget(\"".$IDs."\",\"".$TipCams."\",\"".$WC["CmpReq"]."\",\"".$WC["Tipo"]."\",\"".$Hacer."\",\"\",\"".$WC["ID"]."\",\"form".$WC["ID"]."\",\"".$Accion."\",\"".$WC["Tabla"]."\",\"".$WC["Indice"]."\",\"".$ValorIndice."\",\"".$WC["Campos"]."\",document.getElementById(\"NRegReg".$WC["ID"]."0\").value,\"ImgAba".$WC["ID"]."\",\"Ninguna\",\"\");
												if (Res == true){										
													EjecutaTrabajo(\"Valor\",\"NueReg".$WC["ID"]."0\",\"Ejecutar=Completar&Accion=".$Accion."\");
													setTimeout(VerPro,250);
													function VerPro(NueReg){
														ActEstatusSolicitud(document.getElementById(\"NueReg".$WC["ID"]."0\").value,\"ABANDONO\");											
														CargaPagina(\"modulos/formulario.php\",\"Agregar Registro en ".$_SESSION["Form"]["Modulo"]["Titulo"]."\",\"Accion=Agregar\");
													}
													
												}
											}
										}
										'/>";
								}
							}
							
							if ($WC["Accion"]["Gracias"]["Hacer"] == "Si"){
								if ($Accion == "Agregar"){
									$Hacer = "Verificar";
									echo "<img id='ImgGra".$WC["ID"]."' src='img/Gracias.png' class='BotWidSol' 
										title='Gratitud' alt='Gratitud'
										onmouseover='
										javascript:CambiarImagen(\"ImgGra".$WC["ID"]."\",\"img/GraciasB.png\");' 
										onmouseout='
										javascript:CambiarImagen(\"ImgGra".$WC["ID"]."\",\"img/Gracias.png\");'
										onclick='javascript:
										if (document.getElementById(\"".$WC["ID"]."0\").value != \"\"){
											document.getElementById(\"".$WC["ID"]."1\").value = \"GRACIAS\";
											document.getElementById(\"".$WC["ID"]."2\").value = \"12\";
											CargaSelect(\"W02\",\"W03\",\"SELECT NRegistro,Descripcion FROM detmotivos WHERE NRegMot=\",\"Descripcion\",\"No\");
											document.getElementById(\"".$WC["ID"]."4\").value = \"GRACIAS\";
											document.getElementById(\"".$WC["ID"]."5\").value = \"GRACIAS\";
											document.getElementById(\"".$WC["ID"]."6\").value = \"0\";
											document.getElementById(\"".$WC["ID"]."7\").value = \"0\";
											document.getElementById(\"".$WC["ID"]."8\").value = \"0\";
											document.getElementById(\"".$WC["ID"]."9\").value = \"0\";
											setTimeout(TOGra,200);
											function TOGra(){
												document.getElementById(\"".$WC["ID"]."3\").value = \"139\";
												
												var Res = ProcesaWidget(\"".$IDs."\",\"".$TipCams."\",\"".$WC["CmpReq"]."\",\"".$WC["Tipo"]."\",\"".$Hacer."\",\"\",\"".$WC["ID"]."\",\"form".$WC["ID"]."\",\"".$Accion."\",\"".$WC["Tabla"]."\",\"".$WC["Indice"]."\",\"".$ValorIndice."\",\"".$WC["Campos"]."\",document.getElementById(\"NRegReg".$WC["ID"]."0\").value,\"ImgGra".$WC["ID"]."\",\"Ninguna\",\"\");
												if (Res == true){										
													EjecutaTrabajo(\"Valor\",\"NueReg".$WC["ID"]."0\",\"Ejecutar=Completar&Accion=".$Accion."\");
													setTimeout(VerPro,250);
													function VerPro(NueReg){
														ActEstatusSolicitud(document.getElementById(\"NueReg".$WC["ID"]."0\").value,\"GRACIAS\");											
														CargaPagina(\"modulos/formulario.php\",\"Agregar Registro en ".$_SESSION["Form"]["Modulo"]["Titulo"]."\",\"Accion=Agregar\");
													}
													
												}
											}
										}
										'/>";
								}
							}
							
							if ($WC["Accion"]["Info"]["Hacer"] == "Si"){
								if ($Accion == "Agregar"){
									$Hacer = "Verificar";
									echo "<img id='ImgInf".$WC["ID"]."' src='img/Info.png' class='BotWidSol' 
										title='Informativa' alt='Informativa'
										onmouseover='
										javascript:CambiarImagen(\"ImgInf".$WC["ID"]."\",\"img/InfoB.png\");' 
										onmouseout='
										javascript:CambiarImagen(\"ImgInf".$WC["ID"]."\",\"img/Info.png\");'
										onclick='javascript:
										if (document.getElementById(\"".$WC["ID"]."0\").value != \"\"){
											document.getElementById(\"".$WC["ID"]."1\").value = \"INFORMACION\";
											document.getElementById(\"".$WC["ID"]."2\").value = \"12\";
											CargaSelect(\"W02\",\"W03\",\"SELECT NRegistro,Descripcion FROM detmotivos WHERE NRegMot=\",\"Descripcion\",\"No\");
											if (document.getElementById(\"".$WC["ID"]."4\").value == \"\"){
												document.getElementById(\"".$WC["ID"]."4\").value = \"INFORMACION\";
											}
											document.getElementById(\"".$WC["ID"]."5\").value = \"INFORMACION\";
											document.getElementById(\"".$WC["ID"]."6\").value = \"0\";
											document.getElementById(\"".$WC["ID"]."7\").value = \"0\";
											document.getElementById(\"".$WC["ID"]."8\").value = \"0\";
											document.getElementById(\"".$WC["ID"]."9\").value = \"0\";
											setTimeout(TOInf,200);
											function TOInf(){
												document.getElementById(\"".$WC["ID"]."3\").value = \"141\";
												
												var Res = ProcesaWidget(\"".$IDs."\",\"".$TipCams."\",\"".$WC["CmpReq"]."\",\"".$WC["Tipo"]."\",\"".$Hacer."\",\"\",\"".$WC["ID"]."\",\"form".$WC["ID"]."\",\"".$Accion."\",\"".$WC["Tabla"]."\",\"".$WC["Indice"]."\",\"".$ValorIndice."\",\"".$WC["Campos"]."\",document.getElementById(\"NRegReg".$WC["ID"]."0\").value,\"ImgInf".$WC["ID"]."\",\"Ninguna\",\"\");
												if (Res == true){										
													EjecutaTrabajo(\"Valor\",\"NueReg".$WC["ID"]."0\",\"Ejecutar=Completar&Accion=".$Accion."\");
													setTimeout(VerPro,250);
													function VerPro(NueReg){
														ActEstatusSolicitud(document.getElementById(\"NueReg".$WC["ID"]."0\").value,\"INFORMACION\");											
														CargaPagina(\"modulos/formulario.php\",\"Agregar Registro en ".$_SESSION["Form"]["Modulo"]["Titulo"]."\",\"Accion=Agregar\");
													}
													
												}
											}
										}
										'/>";
								}
							}
							
							if ($WC["Accion"]["Interna"]["Hacer"] == "Si"){
								if ($Accion == "Agregar"){
									$Hacer = "Verificar";
									echo "<img id='ImgInt".$WC["ID"]."' src='img/Interna.png' class='BotWidSol' 
										title='Interna' alt='Interna'
										onmouseover='
										javascript:CambiarImagen(\"ImgInt".$WC["ID"]."\",\"img/InternaB.png\");' 
										onmouseout='
										javascript:CambiarImagen(\"ImgInt".$WC["ID"]."\",\"img/Interna.png\");'
										onclick='javascript:
										if (document.getElementById(\"".$WC["ID"]."0\").value != \"\"){
											document.getElementById(\"".$WC["ID"]."1\").value = \"INTERNA\";
											document.getElementById(\"".$WC["ID"]."2\").value = \"12\";
											CargaSelect(\"W02\",\"W03\",\"SELECT NRegistro,Descripcion FROM detmotivos WHERE NRegMot=\",\"Descripcion\",\"No\");
											document.getElementById(\"".$WC["ID"]."4\").value = \"INTERNA\";
											document.getElementById(\"".$WC["ID"]."5\").value = \"INTERNA\";
											document.getElementById(\"".$WC["ID"]."6\").value = \"0\";
											document.getElementById(\"".$WC["ID"]."7\").value = \"0\";
											document.getElementById(\"".$WC["ID"]."8\").value = \"0\";
											document.getElementById(\"".$WC["ID"]."9\").value = \"0\";
											setTimeout(TOInt,200);
											function TOInt(){
												document.getElementById(\"".$WC["ID"]."3\").value = \"140\";
												
												var Res = ProcesaWidget(\"".$IDs."\",\"".$TipCams."\",\"".$WC["CmpReq"]."\",\"".$WC["Tipo"]."\",\"".$Hacer."\",\"\",\"".$WC["ID"]."\",\"form".$WC["ID"]."\",\"".$Accion."\",\"".$WC["Tabla"]."\",\"".$WC["Indice"]."\",\"".$ValorIndice."\",\"".$WC["Campos"]."\",document.getElementById(\"NRegReg".$WC["ID"]."0\").value,\"ImgInt".$WC["ID"]."\",\"Ninguna\",\"\");
												if (Res == true){										
													EjecutaTrabajo(\"Valor\",\"NueReg".$WC["ID"]."0\",\"Ejecutar=Completar&Accion=".$Accion."\");
													setTimeout(VerPro,250);
													function VerPro(NueReg){
														ActEstatusSolicitud(document.getElementById(\"NueReg".$WC["ID"]."0\").value,\"INTERNA\");
														CargaPagina(\"modulos/formulario.php\",\"Agregar Registro en ".$_SESSION["Form"]["Modulo"]["Titulo"]."\",\"Accion=Agregar\");
													}
													
												}
											}
										}
										'/>";
								}
							}
							
							if ($WC["Accion"]["Adelantar"]["Hacer"] == "Si"){
								if ($Accion == "Agregar"){
									$Hacer = "Verificar";
									echo "<img id='ImgAde".$WC["ID"]."' src='img/Adelantar.png' class='BotWidSol' 
										title='Enviar' alt='Enviar'
										onmouseover='
										javascript:CambiarImagen(\"ImgAde".$WC["ID"]."\",\"img/AdelantarB.png\");' 
										onmouseout='
										javascript:CambiarImagen(\"ImgAde".$WC["ID"]."\",\"img/Adelantar.png\");'
										onclick='
										javascript:
										var Res = ProcesaWidget(\"".$IDs."\",\"".$TipCams."\",\"".$WC["CmpReq"]."\",\"".$WC["Tipo"]."\",\"".$Hacer."\",\"\",\"".$WC["ID"]."\",\"form".$WC["ID"]."\",\"".$Accion."\",\"".$WC["Tabla"]."\",\"".$WC["Indice"]."\",\"".$ValorIndice."\",\"".$WC["Campos"]."\",document.getElementById(\"NRegReg".$WC["ID"]."0\").value,\"ImgAde".$WC["ID"]."\",\"Ninguna\",\"\");
										if (Res == true){
											var ResTras = false;
											var ResVehi = false;
											
											if (document.getElementById(\"W10\").value != \"\"){
												ResTras = ProcesaWidget(\"W10,W11,W12,W13,W14\",\"varchar,varchar,varchar,varchar,varchar\",\"s,s,s,s,s\",\"Campos\",\"".$Hacer."\",\"\",\"W1\",\"formW1\",\"Agregar\",\"detsolicitudtraslado\",\"NRegistro\",\"ValorIndice".$WC["ID"]."\",\"Paciente,Acompanante,Diagnostico,Desde,Hasta\",document.getElementById(\"NRegReg".$WC["ID"]."0\").value,\"ImgAde".$WC["ID"]."\",\"Ninguna\",\"\");											
											}else{
												ResTras = true;
											}
																						
											if (document.getElementById(\"W20\").value != \"\"){
												var ResVehi = ProcesaWidget(\"W20,W21,W22,W23\",\"varchar,varchar,varchar,int4\",\"s,s,s\",\"Campos\",\"".$Hacer."\",\"\",\"W2\",\"formW2\",\"Agregar\",\"detsolicitudvehiculos\",\"NRegistro\",\"ValorIndice".$WC["ID"]."\",\"Placa,MarcaModelo,Color,Ano\",document.getElementById(\"NRegReg".$WC["ID"]."0\").value,\"ImgAde".$WC["ID"]."\",\"Ninguna\",\"\");											
											}else{
												ResVehi = true;
											}
											
											if (ResTras == true && ResVehi == true){											
												EjecutaTrabajo(\"Valor\",\"NueReg".$WC["ID"]."0\",\"Ejecutar=Completar&Accion=".$Accion."\");
												setTimeout(VerPro,1000);
												function VerPro(){
													if (!isNaN(document.getElementById(\"NueReg".$WC["ID"]."0\").value)){
														ActEstatusSolicitud(document.getElementById(\"NueReg".$WC["ID"]."0\").value,\"REPETIDA\");
																									EjecutaTrabajo(\"Ninguna\",\"\",\"Ejecutar=Limpiar&Nivel=Modulo&NRegUsu=".$_SESSION["CodUsuAct"]."&NRegMod=".$_SESSION["Form"]["Modulo"]["IDMenu"]."\");
												CargaPagina(\"modulos/formulario.php\",\"Agregar Registro en ".$_SESSION["Form"]["Modulo"]["Titulo"]."\",\"Accion=Agregar\");
												
													}else{
														MensajeEmergente(\"Debe completar los datos de este Formulario\",\"Arriba\",\"W3\",0,0,\"#FF0\");
													}
												}
											}											
										}'
									/>";
								}elseif ($Accion == "Modificar"){
									$Hacer = "Verificar";
									echo "<img id='ImgCom".$WC["ID"]."' src='img/Completar.png' class='BotWidSol' 
										title='Completar' alt='Completar'
										onmouseover='
										javascript:CambiarImagen(\"ImgCom".$WC["ID"]."\",\"img/CompletarB.png\");' 
										onmouseout='
										javascript:CambiarImagen(\"ImgCom".$WC["ID"]."\",\"img/Completar.png\");'
										onclick='
										javascript:
										var Res = ProcesaWidget(\"".$IDs."\",\"".$TipCams."\",\"".$WC["CmpReq"]."\",\"".$WC["Tipo"]."\",\"".$Hacer."\",\"\",\"".$WC["ID"]."\",\"form".$WC["ID"]."\",\"".$Accion."\",\"".$WC["Tabla"]."\",\"".$WC["Indice"]."\",\"".$ValorIndice."\",\"".$WC["Campos"]."\",document.getElementById(\"NRegReg".$WC["ID"]."0\").value,\"ImgCom".$WC["ID"]."\",\"Ninguna\",\"\");
										if (Res == true){										
											EjecutaTrabajo(\"Valor\",\"NueReg".$WC["ID"]."0\",\"Ejecutar=Completar&Accion=".$Accion."\");
											setTimeout(VerPro,1500);
											function VerPro(){
												EjecutaTrabajo(\"Ninguna\",\"\",\"Ejecutar=Limpiar&Nivel=Modulo&NRegUsu=".$_SESSION["CodUsuAct"]."&NRegMod=".$_SESSION["Form"]["Modulo"]["IDMenu"]."\");
												CargaPagina(\"modulos/formulario.php\",\"Agregar Registro en ".$_SESSION["Form"]["Modulo"]["Titulo"]."\",\"Accion=Agregar\");
											}
											
										}'
									/>";
								}
								echo "<br/>";
							}
							
							if ($WC["Accion"]["Traslado"]["Hacer"] == "Si"){
								if ($Accion == "Modificar"){
									$Hacer = "Verificar";
									echo "<img id='ImgVer".$WC["ID"]."' src='img/Verificar.png' class='BotCmpLis' 
										title='Verificar' alt='Verificar'
										onmouseover='
										javascript:CambiarImagen(\"ImgVer".$WC["ID"]."\",\"img/VerificarB.png\");' 
										onmouseout='
										javascript:CambiarImagen(\"ImgVer".$WC["ID"]."\",\"img/Verificar.png\");'
										onclick='
										javascript:ProcesaWidget(\"".$IDs."\",\"".$TipCams."\",\"".$WC["CmpReq"]."\",\"".$WC["Tipo"]."\",\"".$Hacer."\",\"\",\"".$WC["ID"]."\",\"form".$WC["ID"]."\",\"".$Accion."\",\"".$WC["Tabla"]."\",\"".$WC["Indice"]."\",\"".$ValorIndice."\",\"".$WC["Campos"]."\",document.getElementById(\"NRegReg".$WC["ID"]."0\").value,\"ImgVer".$WC["ID"]."\",\"Ninguna\",\"\");'
									/>";
									echo "<br/>";
								}
							}
							
							if ($WC["Accion"]["Vehiculo"]["Hacer"] == "Si"){
								if ($Accion == "Modificar"){
									$Hacer = "Verificar";
									echo "<img id='ImgVer".$WC["ID"]."' src='img/Verificar.png' class='BotCmpLis' 
										title='Verificar' alt='Verificar'
										onmouseover='
										javascript:CambiarImagen(\"ImgVer".$WC["ID"]."\",\"img/VerificarB.png\");' 
										onmouseout='
										javascript:CambiarImagen(\"ImgVer".$WC["ID"]."\",\"img/Verificar.png\");'
										onclick='
										javascript:ProcesaWidget(\"".$IDs."\",\"".$TipCams."\",\"".$WC["CmpReq"]."\",\"".$WC["Tipo"]."\",\"".$Hacer."\",\"\",\"".$WC["ID"]."\",\"form".$WC["ID"]."\",\"".$Accion."\",\"".$WC["Tabla"]."\",\"".$WC["Indice"]."\",\"".$ValorIndice."\",\"".$WC["Campos"]."\",document.getElementById(\"NRegReg".$WC["ID"]."0\").value,\"ImgVer".$WC["ID"]."\",\"Ninguna\",\"\");'
									/>";
									echo "<br/>";
								}
							}						
						}
					echo "</div>";
				}
			break;
			
			case "CamposLista":
				if ($Accion == "Agregar" or $Accion == "Modificar" or $Accion == "Dinamico"){					
					$AltTab = substr($Widget["Apariencia"]["Alto"], 0, -2) / 3;
					$AltLis = substr($Widget["Apariencia"]["Alto"], 0, -2);
					$AltLis = $AltLis - 70;
					$AltLis = $AltLis - ($WC["DisTab"]["Fil"] * 40);					
				}else{
					$AltLis = substr($Widget["Apariencia"]["Alto"], 0, -2) * (85 / 100);
				}
				echo "<form name='form".$WC["ID"]."' id='form".$WC["ID"]."' method='post' action='' enctype = 'multipart/form-data'>";				
				$nCA = 0;
				$Campos = split(",",$WC["Campos"]);
				$CmpCol = split(",",$WC["CmpCol"]);
				$CmpFil = split(",",$WC["CmpFil"]);
				if ($Accion == "Agregar" or $Accion == "Modificar" or $Accion == "Dinamico"){
					echo "<table cellspacing='".$WC["DisTab"]["CSp"]."' cellpadding='".$WC["DisTab"]["CPa"]."' border='".$WC["DisTab"]["Brd"]."' style='width:".$AncTit."px;'>";
					for ($n = 1; $n <= $WC["DisTab"]["Fil"]; $n++){
						echo "<tr>";
						for ($n2 = 1; $n2 <= $WC["DisTab"]["Col"]; $n2++){
							if ($CmpCol[$nCA] !=""){
								$n2 = $n2 + ($CmpCol[$nCA] - 1);
								$CmpCol[$nCA] = "colspan='".$CmpCol[$nCA]."'";
							}							
							echo "<td class='tdWidgetCamposLista' ".$CmpCol[$nCA].">";
								$TipCam = CreaCampo($nCA,$Widget,$Accion,"",$TabIndCmp,$link);						
							echo "</td>";
							if ($nCA < count($Campos)){
								if ($nCA == 0){$IDs = $WC["ID"].$nCA;}else{$IDs = $IDs.",".$WC["ID"].$nCA;}
								if ($nCA == 0){$TipCams = $TipCam;}else{$TipCams = $TipCams.",".$TipCam;}
							}
							$nCA++;
							$TabIndCmp++;
						}					
						echo "</tr>";
					}				
					echo "</table>";
				}
				if ($WC["Accion"] != "Ninguna"){
					if ($Accion == "Agregar" or $Accion == "Modificar" or $Accion == "Dinamico"){
						echo "<div class='divPieWidgetCamposLista' style='width:".$AncTit."px;'>";						
							if ($WC["Accion"]["Agregar"]["Hacer"] == "Si"){
								$Hacer = "Agregar";
								echo "<img id='ImgAgr".$WC["ID"]."' src='img/Agregar2.png' class='BotCmpLis' 
									title='Agregar' alt='Agregar'
									onmouseover='
									javascript:CambiarImagen(\"ImgAgr".$WC["ID"]."\",\"img/Agregar2B.png\");' 
									onmouseout='
									javascript:CambiarImagen(\"ImgAgr".$WC["ID"]."\",\"img/Agregar2.png\");'
									onclick='javascript:ProcesaWidget(\"".$IDs."\",\"".$TipCams."\",\"".$WC["CmpReq"]."\",\"".$WC["Tipo"]."\",\"".$Hacer."\",document.getElementById(\"".$WC["ID"]."NRO\").value,\"".$WC["ID"]."\",\"form".$WC["ID"]."\",\"".$Accion."\",\"".$WC["Tabla"]."\",\"".$WC["Indice"]."\",\"".$ValorIndice."\",\"".$WC["Campos"]."\",\"\",\"ImgAgr".$WC["ID"]."\",\"innerHTML\",\"div".$WC["ID"]."\");'
								/>";
								echo "&nbsp;&nbsp;&nbsp;";
							}
							if ($WC["Accion"]["Modificar"]["Hacer"] == "Si"){
								$Hacer = "Modificar";
								echo "<img id='ImgMod".$WC["ID"]."' src='img/Modificar.png' class='BotCmpLis' 
									title='Modificar' alt='Modificar'
									onmouseover='
									javascript:CambiarImagen(\"ImgMod".$WC["ID"]."\",\"img/ModificarB.png\");' 
									onmouseout='
									javascript:CambiarImagen(\"ImgMod".$WC["ID"]."\",\"img/Modificar.png\");'
									onclick='javascript:ProcesaWidget(\"".$IDs."\",\"".$TipCams."\",\"".$WC["CmpReq"]."\",\"".$WC["Tipo"]."\",\"".$Hacer."\",document.getElementById(\"".$WC["ID"]."NRO\").value,\"".$WC["ID"]."\",\"form".$WC["ID"]."\",\"".$Accion."\",\"".$WC["Tabla"]."\",\"".$WC["Indice"]."\",\"".$ValorIndice."\",\"".$WC["Campos"]."\",\"\",\"ImgMod".$WC["ID"]."\",\"innerHTML\",\"div".$WC["ID"]."\");'
								/>";
								echo "&nbsp;&nbsp;&nbsp;";
							}
							if ($WC["Accion"]["Eliminar"]["Hacer"] == "Si"){
								$Hacer = "Eliminar";
								echo "<img id='ImgEli".$WC["ID"]."' src='img/Eliminar.png' class='BotCmpLis' 
									title='Eliminar' alt='Eliminar'
									onmouseover='
									javascript:CambiarImagen(\"ImgEli".$WC["ID"]."\",\"img/EliminarB.png\");' 
									onmouseout='
									javascript:CambiarImagen(\"ImgEli".$WC["ID"]."\",\"img/Eliminar.png\");'
									onclick='javascript:ProcesaWidget(\"".$IDs."\",\"".$TipCams."\",\"".$WC["CmpReq"]."\",\"".$WC["Tipo"]."\",\"".$Hacer."\",document.getElementById(\"".$WC["ID"]."NRO\").value,\"".$WC["ID"]."\",\"form".$WC["ID"]."\",\"".$Accion."\",\"".$WC["Tabla"]."\",\"".$WC["Indice"]."\",\"".$ValorIndice."\",\"".$WC["Campos"]."\",\"\",\"ImgEli".$WC["ID"]."\",\"innerHTML\",\"div".$WC["ID"]."\");'
								/>";
							}
							
							if ($WC["Accion"]["AgregarUnidad"]["Hacer"] == "Si"){
								$Hacer = "Agregar";
								echo "<img id='ImgAgr".$WC["ID"]."' src='img/ApoyoDespacho.png' class='BotCmpLis2' 
									title='Apoyo' alt='Apoyo'
									onmouseover='
									javascript:CambiarImagen(\"ImgAgr".$WC["ID"]."\",\"img/ApoyoDespachoB.png\");' 
									onmouseout='
									javascript:CambiarImagen(\"ImgAgr".$WC["ID"]."\",\"img/ApoyoDespacho.png\");'
									onclick='javascript:									
									var Res = ProcesaWidget(\"".$IDs."\",\"".$TipCams."\",\"".$WC["CmpReq"]."\",\"".$WC["Tipo"]."\",\"".$Hacer."\",document.getElementById(\"".$WC["ID"]."NRO\").value,\"".$WC["ID"]."\",\"form".$WC["ID"]."\",\"".$Accion."\",\"".$WC["Tabla"]."\",\"".$WC["Indice"]."\",\"".$ValorIndice."\",\"".$WC["Campos"]."\",\"\",\"ImgAgr".$WC["ID"]."\",\"innerHTML\",\"div".$WC["ID"]."\");									
									if (Res == true){
										setTimeout(EjeAA".$WC["ID"].",100);
										function EjeAA".$WC["ID"]."(){
											EjecutaTrabajo(\"Ninguno\",\"\",\"Ejecutar=Completar&Accion=Modificar\");
											setTimeout(EjeAA2".$WC["ID"].",100);
											function EjeAA2".$WC["ID"]."(){
												EjecutaTrabajo(\"Ninguna\",\"\",\"Ejecutar=Cargar&Accion=Modificar&ValorIndice=".$ValorIndice."\");	
																											setTimeout(function(){CargaPagina(\"modulos/formulario.php\",\"SOLICITUD No: ".number_format($ValorIndice, 0, ',', '.')."\",\"Accion=Modificar&ValorIndice=".$ValorIndice."\");},200);												
											}
										}
									}
									'/>";
								echo "&nbsp;&nbsp;&nbsp;";
							}
							if ($WC["Accion"]["ModificarUnidad"]["Hacer"] == "Si"){
								$Hacer = "Modificar";
								echo "<img id='ImgMod".$WC["ID"]."' src='img/ModificarDespacho.png' class='BotCmpLis2' 
									title='Modificar' alt='Modificar'
									onmouseover='
									javascript:CambiarImagen(\"ImgMod".$WC["ID"]."\",\"img/ModificarDespachoB.png\");' 
									onmouseout='
									javascript:CambiarImagen(\"ImgMod".$WC["ID"]."\",\"img/ModificarDespacho.png\");'
									onclick='javascript:																					
									var Und = document.getElementById(\"".$WC["ID"]."1\").value;
									var AM = document.getElementById(\"".$WC["ID"]."2\").value;
									var Pro = document.getElementById(\"".$WC["ID"]."3\").value;
									
									var Res = ProcesaWidget(\"".$IDs."\",\"".$TipCams."\",\"".$WC["CmpReq"]."\",\"".$WC["Tipo"]."\",\"".$Hacer."\",document.getElementById(\"".$WC["ID"]."NRO\").value,\"".$WC["ID"]."\",\"form".$WC["ID"]."\",\"".$Accion."\",\"".$WC["Tabla"]."\",\"".$WC["Indice"]."\",\"".$ValorIndice."\",\"".$WC["Campos"]."\",\"\",\"ImgMod".$WC["ID"]."\",\"innerHTML\",\"div".$WC["ID"]."\");																											
									//setTimeout(EjeProWig".$WC["ID"].",250);
									//function EjeProWig".$WC["ID"]."(){									
										if (Res == true){
											//alert(document.getElementById(\"".$WC["ID"]."NRO\").value);															
											//setTimeout(ActEstFre".$WC["ID"].",100);
											//function ActEstFre".$WC["ID"]."(){												
												var NRegFre = document.getElementById(\"".$WC["ID"]."NRO\").value;
												var NRegDes = ".$_SESSION["CodUsuAct"].";
												
												ActEstatusFrecuencia(NRegFre,NRegDes,Und,AM,Pro);
																																		
												setTimeout(EjeBSP".$WC["ID"].",100);
												function EjeBSP".$WC["ID"]."(){
													EjecutaTrabajo(\"Ninguno\",\"\",\"Ejecutar=Completar&Accion=Modificar\");
													BusSinPro(\"Res".$WC["ID"]."\",".$ValorIndice.");
													setTimeout(VerProBSP".$WC["ID"].",250);													
													function VerProBSP".$WC["ID"]."(){
														//alert(document.getElementById(\"Res".$WC["ID"]."\").value);												
														if (document.getElementById(\"Res".$WC["ID"]."\").value != \"0\"){													EjecutaTrabajo(\"Ninguna\",\"\",\"Ejecutar=Cargar&Accion=Modificar&ValorIndice=".$ValorIndice."\");	
																											setTimeout(function(){CargaPagina(\"modulos/formulario.php\",\"SOLICITUD No: ".number_format($ValorIndice, 0, ',', '.')."\",\"Accion=Modificar&ValorIndice=".$ValorIndice."\");},200);														
														}else{													
															BusPriPen(\"Res".$WC["ID"]."2\",\"".$ValorIndice."\");
															setTimeout(VerProBPP".$WC["ID"].",250);
															function VerProBPP".$WC["ID"]."(){
																//alert(\"2-\"+document.getElementById(\"Res".$WC["ID"]."2\").value);														
																if (document.getElementById(\"Res".$WC["ID"]."2\").value == 0){
																	CargaPagina(\"modulos/formulario.php\",\"Agregar Registro de ".$Form["Modulo"]["Titulo"]."\",\"Accion=Agregar&ValorIndice=\");
																}else{														EjecutaTrabajo(\"Ninguna\",\"\",\"Ejecutar=Cargar&Accion=Modificar&ValorIndice=\" + document.getElementById(\"Res".$WC["ID"]."2\").value);
																	setTimeout(function(){CargaPagina(\"modulos/formulario.php\",\"SOLICITUD No: ".number_format($ValorIndice, 0, ',', '.')."\",\"Accion=Modificar&ValorIndice=\" + document.getElementById(\"Res".$WC["ID"]."\").value);},200);
																}
															}
														}
													}
												}
											//}
										}
									//}
									'/>";
								echo "&nbsp;&nbsp;&nbsp;";
								
							}
							if ($WC["Accion"]["EliminarUnidad"]["Hacer"] == "Si"){
								$Hacer = "Eliminar";
								echo "<img id='ImgEli".$WC["ID"]."' src='img/Eliminar.png' class='BotCmpLis' 
									title='Eliminar' alt='Eliminar'
									onmouseover='
									javascript:CambiarImagen(\"ImgEli".$WC["ID"]."\",\"img/EliminarB.png\");' 
									onmouseout='
									javascript:CambiarImagen(\"ImgEli".$WC["ID"]."\",\"img/Eliminar.png\");'
									onclick='javascript:ProcesaWidget(\"".$IDs."\",\"".$TipCams."\",\"".$WC["CmpReq"]."\",\"".$WC["Tipo"]."\",\"".$Hacer."\",document.getElementById(\"".$WC["ID"]."NRO\").value,\"".$WC["ID"]."\",\"form".$WC["ID"]."\",\"".$Accion."\",\"".$WC["Tabla"]."\",\"".$WC["Indice"]."\",\"".$ValorIndice."\",\"".$WC["Campos"]."\",\"\",\"ImgEli".$WC["ID"]."\",\"innerHTML\",\"div".$WC["ID"]."\");'
								/>";
							}
						echo "</div>";
					}					
				}
				//$AltTab
				echo "<div id='div".$WC["ID"]."' style='overflow:auto;height:".$AltLis."px;'>";
					CargaLista($WC["ID"],$Accion,$ValorIndice);
				echo "</div>";
				echo "<input id='ValorIndice".$WC["ID"]."' type='hidden' value='".$ValorIndice."'>";
				echo "<input id='Accion".$WC["ID"]."' type='hidden' value='".$Accion."'>";				
				echo "<input id='Res".$WC["ID"]."' type='hidden' value=''>";
				echo "<input id='Res".$WC["ID"]."2' type='hidden' value=''>";
				echo "</form>";
			break;

			case "Lista":
				echo "<form name='form".$WC["ID"]."' id='form".$WC["ID"]."' method='post' action='' enctype = 'multipart/form-data'>";
				if ($WC["Accion"] != "Ninguna"){
					if ($Accion == "Agregar" or $Accion == "Modificar" or $Accion == "Dinamico"){
						echo "<div class='divPieWidgetLista' style='width:".$AncTit."px;'>";
						echo "<table style='width:".$AncTit."px;'><tr>";
						echo "<td id='tdE".$WC["ID"]."' style='text-align:center;'></td>";
							if ($WC["Accion"]["ActAutoCarga"]["Hacer"] == "Si"){
								echo "<td style='width:20px;text-align:center;'>";
								$Hacer = "ActAutoCarga";
								echo "<img id='ImgAA".$WC["ID"]."' src='img/Reciclaje2.png' class='BotCmpLis' 
									title='Activar AutoCarga' alt='Activar AutoCarga'
									onmouseover='
									javascript:CambiarImagen(\"ImgAA".$WC["ID"]."\",\"img/Reciclaje2B.png\");' 
									onmouseout='
									javascript:CambiarImagen(\"ImgAA".$WC["ID"]."\",\"img/Reciclaje2.png\");'
									onclick='javascript:AutoCargaLista(\"".$WC["ID"]."\",".$WC["Accion"]["ActAutoCarga"]["RitAct"].",\"A\");";									
									
									if ($Form["Modulo"]["Titulo"] == "SOLICITUDES"){
										echo "RepiteRevNumEnt();";
									}									
									echo "'/>";									
								echo "</td>";
							}
							if ($WC["Accion"]["DesAutoCarga"]["Hacer"] == "Si"){
								echo "<td style='width:20px;text-align:center;'>";
								$Hacer = "DesAutoCarga";
								echo "<img id='ImgDA".$WC["ID"]."' src='img/Stop.png' class='BotCmpLis'
									style='visibility:hidden;'
									title='Desactivar AutoCarga' alt='Desactivar AutoCarga'
									onmouseover='
									javascript:CambiarImagen(\"ImgDA".$WC["ID"]."\",\"img/StopB.png\");' 
									onmouseout='
									javascript:CambiarImagen(\"ImgDA".$WC["ID"]."\",\"img/Stop.png\");'
									onclick='javascript:AutoCargaLista(\"".$WC["ID"]."\",0,\"D\");'
								/>";
								echo "</td>";
							}
							if ($WC["Accion"]["ActAutoCargaSO"]["Hacer"] == "Si"){
								echo "<td style='width:20px;text-align:center;'>";
								$Hacer = "ActAutoCargaSO";
								echo "<img id='ImgAASO".$WC["ID"]."' src='img/Reciclaje2.png' class='BotCmpLis' 
									title='Activar AutoCarga' alt='Activar AutoCarga'
									onmouseover='
									javascript:CambiarImagen(\"ImgAASO".$WC["ID"]."\",\"img/Reciclaje2B.png\");' 
									onmouseout='
									javascript:CambiarImagen(\"ImgAASO".$WC["ID"]."\",\"img/Reciclaje2.png\");'
									onclick='javascript:
									AutoCargaListaSO(\"".$WC["ID"]."\",".$WC["Accion"]["ActAutoCargaSO"]["RitAct"].",\"A\");";									
																										
									echo "'/>";									
								echo "</td>";
							}
							if ($WC["Accion"]["DesAutoCargaSO"]["Hacer"] == "Si"){
								echo "<td style='width:20px;text-align:center;'>";
								$Hacer = "DesAutoCargaSO";
								echo "<img id='ImgDASO".$WC["ID"]."' src='img/Stop.png' class='BotCmpLis'
									style='visibility:hidden;'
									title='Desactivar AutoCarga' alt='Desactivar AutoCarga'
									onmouseover='
									javascript:CambiarImagen(\"ImgDASO".$WC["ID"]."\",\"img/StopB.png\");' 
									onmouseout='
									javascript:CambiarImagen(\"ImgDASO".$WC["ID"]."\",\"img/Stop.png\");'
									onclick='javascript:AutoCargaListaSO(\"".$WC["ID"]."\",0,\"D\");'
								/>";
								echo "</td>";
							}
						echo "</tr></table>";
						echo "</div>";
					}					
				}				
				$AltLis = substr($Widget["Apariencia"]["Alto"], 0, -2) * (85 / 100);				
				echo "<div id='div".$WC["ID"]."' style='overflow:auto;height:".$AltLis."px;'>";
					CargaLista($WC["ID"],$Accion,$ValorIndice);
				echo "</div>";
				echo "<input id='ValorIndice".$WC["ID"]."' type='hidden' value='".$ValorIndice."'>";
				echo "<input id='Accion".$WC["ID"]."' type='hidden' value='".$Accion."'>";
				echo "</form>";
			break;
		}
	echo "</div>";
}

//DIV para las Opciones del Formulario
	echo "<div id='OpcFor' class='OpcFor'>";
		echo "<table id='TabOpcFor' class='TabOpcFor'>";
			echo "<tr>";				
				echo "<td id='Op1' class='tdTabOpcFor'>";
					echo "<font size='-2' color='#FF0000'><strong>(*) Campo Requerido</strong></font>";
				echo "</td>";
				echo "<td id='Op2' class='tdTabOpcFor'>";
					if ($Form["OpcionesFormulario"]["Op2"]){
						$Imagen = $Form["OpcionesFormulario"]["Op2"]["Imagen"];
						$Texto = $Form["OpcionesFormulario"]["Op2"]["Texto"];
						$Funcion = $Form["OpcionesFormulario"]["Op2"]["Funcion"];
						echo "<img id='ImgOpcFor2' src='img/".$Imagen.".png' class='BotOpc' 
							title='".$Texto."' alt='".$Texto."'
							onmouseover='javascript:CambiarImagen(\"ImgOpcFor2\",\"img/".$Imagen."B.png\");' 
							onmouseout='javascript:CambiarImagen(\"ImgOpcFor2\",\"img/".$Imagen.".png\");'
							onclick='javascript:".$Funcion."'
							/>";
					}else{
						echo "&nbsp;";
					}
				echo "</td>";
				echo "<td id='Op3' class='tdTabOpcFor'>";
					if ($Form["OpcionesFormulario"]["Op3"]){
						$Imagen = $Form["OpcionesFormulario"]["Op3"]["Imagen"];
						$Texto = $Form["OpcionesFormulario"]["Op3"]["Texto"];
						$Funcion = $Form["OpcionesFormulario"]["Op3"]["Funcion"];
						echo "<img id='ImgOpcFor3' src='img/".$Imagen.".png' class='BotOpc' 
							title='".$Texto."' alt='".$Texto."'
							onmouseover='javascript:CambiarImagen(\"ImgOpcFor3\",\"img/".$Imagen."B.png\");' 
							onmouseout='javascript:CambiarImagen(\"ImgOpcFor3\",\"img/".$Imagen.".png\");'
							onclick='javascript:".$Funcion."'
							/>";
					}else{
						echo "&nbsp;";
					}
				echo "</td>";
				echo "<td id='Op4' class='tdTabOpcFor'>";
					if ($Form["OpcionesFormulario"]["Op4"]){
						$Imagen = $Form["OpcionesFormulario"]["Op4"]["Imagen"];
						$Texto = $Form["OpcionesFormulario"]["Op4"]["Texto"];
						$Funcion = $Form["OpcionesFormulario"]["Op4"]["Funcion"];
						echo "<img id='ImgOpcFor4' src='img/".$Imagen.".png' class='BotOpc' 
							title='".$Texto."' alt='".$Texto."'
							onmouseover='javascript:CambiarImagen(\"ImgOpcFor4\",\"img/".$Imagen."B.png\");' 
							onmouseout='javascript:CambiarImagen(\"ImgOpcFor4\",\"img/".$Imagen.".png\");'
							onclick='javascript:".$Funcion."'
							/>";
					}else{
						echo "&nbsp;";
					}
				echo "</td>";
				echo "<td id='Op5' class='tdTabOpcFor'>";
					if ($Form["OpcionesFormulario"]["Op5"]){
						$Imagen = $Form["OpcionesFormulario"]["Op5"]["Imagen"];
						$Texto = $Form["OpcionesFormulario"]["Op5"]["Texto"];
						$Funcion = $Form["OpcionesFormulario"]["Op5"]["Funcion"];
						echo "<img id='ImgOpcFor5' src='img/".$Imagen.".png' class='BotOpc' 
							title='".$Texto."' alt='".$Texto."'
							onmouseover='javascript:CambiarImagen(\"ImgOpcFor5\",\"img/".$Imagen."B.png\");' 
							onmouseout='javascript:CambiarImagen(\"ImgOpcFor5\",\"img/".$Imagen.".png\");'
							onclick='javascript:".$Funcion."'
							/>";
					}else{
						echo "&nbsp;";
					}
				echo "</td>";
				echo "<td id='Op6' class='tdTabOpcFor'>";
					if ($Form["OpcionesFormulario"]["Op6"]){
						$Imagen = $Form["OpcionesFormulario"]["Op6"]["Imagen"];
						$Texto = $Form["OpcionesFormulario"]["Op6"]["Texto"];
						$Funcion = $Form["OpcionesFormulario"]["Op6"]["Funcion"];
						echo "<img id='ImgOpcFor6' src='img/".$Imagen.".png' class='BotOpc' 
							title='".$Texto."' alt='".$Texto."'
							onmouseover='javascript:CambiarImagen(\"ImgOpcFor6\",\"img/".$Imagen."B.png\");' 
							onmouseout='javascript:CambiarImagen(\"ImgOpcFor6\",\"img/".$Imagen.".png\");'
							onclick='javascript:".$Funcion."'
							/>";
					}else{
						echo "&nbsp;";
					}
				echo "</td>";
				echo "<td id='Op7' class='tdTabOpcFor'>";
					if ($Form["OpcionesFormulario"]["Op7"]){
						$Imagen = $Form["OpcionesFormulario"]["Op7"]["Imagen"];
						$Texto = $Form["OpcionesFormulario"]["Op7"]["Texto"];
						$Funcion = $Form["OpcionesFormulario"]["Op7"]["Funcion"];
						echo "<img id='ImgOpcFor7' src='img/".$Imagen.".png' class='BotOpc' 
							title='".$Texto."' alt='".$Texto."'
							onmouseover='javascript:CambiarImagen(\"ImgOpcFor7\",\"img/".$Imagen."B.png\");' 
							onmouseout='javascript:CambiarImagen(\"ImgOpcFor7\",\"img/".$Imagen.".png\");'
							onclick='javascript:".$Funcion."'
							/>";
					}else{
						echo "&nbsp;";
					}
				echo "</td>";
				echo "<td id='Op8' class='tdTabOpcFor'>";
					if ($Form["OpcionesFormulario"]["Op8"]){
						$Imagen = $Form["OpcionesFormulario"]["Op8"]["Imagen"];
						$Texto = $Form["OpcionesFormulario"]["Op8"]["Texto"];
						$Funcion = $Form["OpcionesFormulario"]["Op8"]["Funcion"];
						echo "<img id='ImgOpcFor8' src='img/".$Imagen.".png' class='BotOpc' 
							title='".$Texto."' alt='".$Texto."'
							onmouseover='javascript:CambiarImagen(\"ImgOpcFor8\",\"img/".$Imagen."B.png\");' 
							onmouseout='javascript:CambiarImagen(\"ImgOpcFor8\",\"img/".$Imagen.".png\");'
							onclick='javascript:".$Funcion."'
							/>";
					}else{
						echo "&nbsp;";
					}
				echo "</td>";
				echo "<td id='Op9' class='tdTabOpcFor'>";
					if ($Accion == "Agregar" or $Accion == "Modificar" or $Accion == "Eliminar"){
						echo "<input id='ResPro' type='hidden' value='' />";
						echo "<img id='ImgOpc9F' src='img/Procesar.png' class='BotOpcFor' 
						title='".$Accion."' alt='".$Accion."'";
						
						if ($Accion != "Eliminar"){echo "style='visibility:hidden;'";}
						
						switch ($Accion){
							case "Agregar": $Men = "Agregando"; break;
							case "Modificar": $Men = "Modificando"; break;
							case "Eliminar": $Men = "Eliminando"; break;
						}
						
						echo "onmouseover='javascript:CambiarImagen(\"ImgOpc9F\",\"img/ProcesarB.png\");' 
						onmouseout='javascript:CambiarImagen(\"ImgOpc9F\",\"img/Procesar.png\");'
						onclick='javascript:
							MensajeEmergente(\"".$Men."\",\"Izquierda\",\"ImgOpc9F\",0,0,\"#F80\");
							document.getElementById(\"ImgOpc9F\").style.visibility=\"hidden\";
							EjecutaTrabajo(\"Mensaje\",\"ResPro\",\"Ejecutar=Completar&Accion=".$Accion."\");
							setTimeout(VerPro,1500);
							function VerPro(){
								if (document.getElementById(\"ResPro\").value == \"OK\"){
									MensajeEmergente(\"Completo\",\"Izquierda\",\"ImgOpc9F\",0,0,\"#0F0\");
									setTimeout(function(){DesMenEme();setTimeout(function(){CargaPagina(\"modulos/".$Form["Modulo"]["Modulo"]."\", \"".$Form["Modulo"]["Titulo"]."\",\"idm=".$Form["Modulo"]["IDMenu"]."&mod=".$Form["Modulo"]["Modulo"]."&tit=".$Form["Modulo"]["Titulo"]."&Orden=".$_POST["Orden"]."\");},300);},500);
								}
								//document.getElementById(\"ImgOpc9F\").style.visibility=\"visible\";
							}'
						/>";
					}
				echo "</td>";
				echo "<td id='Op10' class='tdTabOpcFor'>";
					echo "<img id='ImgOpc10F' src='img/Regresar.png' class='BotOpcFor' 
					title='Regresar' alt='Regresar'
					onmouseover='javascript:CambiarImagen(\"ImgOpc10F\",\"img/RegresarB.png\");' 
					onmouseout='javascript:CambiarImagen(\"ImgOpc10F\",\"img/Regresar.png\");'
					onclick='javascript:
					EjecutaTrabajo(\"Ninguna\",\"\",\"Ejecutar=Limpiar&Nivel=Modulo&NRegUsu=".$_SESSION["CodUsuAct"]."&NRegMod=".$Form["Form"]["Modulo"]["IDMenu"]."\");
					CargaPagina(\"modulos/".$Form["Modulo"]["Modulo"]."\", \"".$Form["Modulo"]["Titulo"]."\",\"idm=".$Form["Modulo"]["IDMenu"]."&mod=".$Form["Modulo"]["Modulo"]."&tit=".$Form["Modulo"]["Titulo"]."&Orden=".$_POST["Orden"]."\");";
					
					echo "AutoCargaLista(\"\",0,\"D\");";
					echo "TerminaRevNumEnt();";
					
					echo "'/>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	echo "</div>";






function CreaCampo($nCA,$Widget,$Accion,$ValorIndice,$TabIndCmp,$link){	
	$Titulos = split(",",$Widget["Contenido"]["TitCam"]);
	if ($Titulos[$nCA] == ""){return false;}	
	$WC = $Widget["Contenido"];	
	
	$Campos = split(",",$WC["Campos"]);	
	$CmpReq = split(",",$WC["CmpReq"]);	
	$ValDef = split(",",$WC["ValDef"]);	
	$CmpBlo = split(",",$WC["CmpBlo"]);	
	$CmpPas = split(",",$WC["CmpPas"]);	
	$CmpMxC = split(",",$WC["CmpMxC"]);
	$ValEsp = split(",",$WC["ValEsp"]);
	$FunEsp = split("-",$WC["FunEsp"]);
	
	$CmpSel = $WC["CmpSel"]["Cmp"][$nCA];
	
	if ($CmpReq[$nCA] == "s"){$ACmpReq = "<font color='#FF0000'><strong>*</strong></font>";}else{$ACmpReq = "";}	
	if ($CmpBlo[$nCA] == "s"){$CmpBlo[$nCA] = "disabled";}else{$CmpBlo[$nCA] = "";}	
	if ($CmpMxC[$nCA] != ""){$CmpMxC[$nCA] = "maxlength=".$CmpMxC[$nCA];}else{$CmpMxC[$nCA] == "";}
	
	$result = $link->query("SELECT ".$Campos[$nCA]." FROM ".$WC["Tabla"]." WHERE ".$WC["Indice"]."='".$ValorIndice."'");
	for ($CmpQRY = array();$tmp = $result->fetch_field();){$CmpQRY[] = $tmp;}

	if ($ValorIndice !=""){
		$resultT = $link->query("SELECT Cmp".($nCA+1)." FROM trabajo WHERE NRegUsu = ".$_SESSION["CodUsuAct"]." AND NRegMod = ".$_SESSION["Form"]["Modulo"]["IDMenu"]." AND Widget = '".$WC["ID"]."' AND Form = 'form".$WC["ID"]."' AND Accion = '".$Accion."' ORDER BY NRegistro");	
		for ($TabQRY = array();$tmp2 = $resultT->fetch_array(MYSQLI_BOTH);){$TabQRY[] = $tmp2;}
	}
	
	echo "<strong>".$Titulos[$nCA].":</strong> ".$ACmpReq."<br />";	
	
	if ($CmpSel["Tipo"] == ""){
		switch($CmpQRY[0]->type){
			case 1:  //boleano				
				$AliCmp = "Center";
				switch($Accion){
					case "Agregar":
						if ($ValDef[$nCA] != ""){$Valor = $ValDef[$nCA];}else{$Valor = "";}
						echo "<select tabindex=".$TabIndCmp." name=".$WC["ID"].$nCA." id=".$WC["ID"].$nCA." ".$CmpBlo[$nCA]." ".$CmpMxC[$nCA]." ".$FunEsp[$nCA]." ".$ValEsp[$nCA]." style='width:95%; text-align:".$AliCmp.";' class='SelFor' onfocus=\"javascript:DesMenEme();\">";							
							echo "<option value='' ";							
							if ($Valor == ""){echo "selected='selected'";}							
							echo ">Seleccione ...</option>";							
							echo "<option value='1' ";							
							if ($Valor == "1"){echo "selected='selected'";}
							echo ">Si</option>";							
							echo "<option value='0' ";							
							if ($Valor == "0"){echo "selected='selected'";}							
							echo ">No</option>";
						echo "</select>";
					break;
					case "Modificar":
						$Valor = $TabQRY[0][0];							
						echo "<select tabindex=".$TabIndCmp." name=".$WC["ID"].$nCA." id=".$WC["ID"].$nCA." ".$CmpBlo[$nCA]." ".$CmpMxC[$nCA]." ".$FunEsp[$nCA]." ".$ValEsp[$nCA]." style='width:95%; text-align:".$AliCmp.";' class='SelFor' onfocus=\"javascript:DesMenEme();\">";							
							echo "<option value='' ";							
							if ($Valor == ""){echo "selected='selected'";}							
							echo ">Seleccione ...</option>";							
							echo "<option value='1' ";							
							if ($Valor == "1"){echo "selected='selected'";}
							echo ">Si</option>";							
							echo "<option value='0' ";							
							if ($Valor == "0"){echo "selected='selected'";}							
							echo ">No</option>";
						echo "</select>";					
					break;
					case "Eliminar":
						switch ($TabQRY[0][0]){
							case true: $Valor = "Si"; break;
							case false: $Valor = "No"; break;
							case "": $Valor = ""; break;
						}
						if ($CmpPas[$nCA] == "s"){$TipImp = "password";}else{$TipImp = "text";}
						$CmpBlo[$nCA] = "disabled";
						echo "<input tabindex=".$TabIndCmp." type='".$TipImp."' name=".$WC["ID"].$nCA." id=".$WC["ID"].$nCA." value='".$Valor."' ".$CmpBlo[$nCA]." ".$CmpMxC[$nCA]." ".$FunEsp[$nCA]." ".$ValEsp[$nCA]." style='width:95%; text-align:".$AliCmp.";' class='InpTexFor' onfocus=\"javascript:DesMenEme();\"/>";
					break;
					case "Detalles":
						switch ($TabQRY[0][0]){
							case true: $Valor = "Si"; break;
							case false: $Valor = "No"; break;
							case "": $Valor = ""; break;
						}
						if ($CmpPas[$nCA] == "s"){$TipImp = "password";}else{$TipImp = "text";}
						$CmpBlo[$nCA] = "disabled";
						echo "<input tabindex=".$TabIndCmp." type='".$TipImp."' name=".$WC["ID"].$nCA." id=".$WC["ID"].$nCA." value='".$Valor."' ".$CmpBlo[$nCA]." ".$CmpMxC[$nCA]." ".$FunEsp[$nCA]." ".$ValEsp[$nCA]." style='width:95%; text-align:".$AliCmp.";' class='InpTexFor' onfocus=\"javascript:DesMenEme();\"/>";
					break;
					case "Dinamico":
					break;
				}				
			break;				
			case 3:  //integer
				if ($CmpPas[$nCA] == "s"){$TipImp = "password";}else{$TipImp = "text";}
				$AliCmp = "Right";
				switch($Accion){
					case "Agregar":
						if ($ValDef[$nCA] != ""){$Valor = $ValDef[$nCA];}else{$Valor = "";}
						$Valor = number_format($Valor, 0, ',', '.');
					break;
					case "Modificar":
						$Valor = number_format($TabQRY[0][0], 0, ',', '.');
					break;
					case "Eliminar":
						$CmpBlo[$nCA] = "disabled";
						$Valor = number_format($TabQRY[0][0], 0, ',', '.');
					break;
					case "Detalles":						
						$CmpBlo[$nCA] = "disabled";
						$Valor = number_format($TabQRY[0][0], 0, ',', '.');
					break;
					case "Dinamico":
						$Valor = number_format($Valor, 0, ',', '.');
					break;
				}
				
				echo "<input tabindex=".$TabIndCmp." type='".$TipImp."' name=".$WC["ID"].$nCA." id=".$WC["ID"].$nCA." value='".$Valor."' ".$CmpBlo[$nCA]." ".$CmpMxC[$nCA]." ".$FunEsp[$nCA]." style='width:95%; text-align:".$AliCmp.";' class='InpTexFor' onfocus=\"javascript:DesMenEme();\"/>";
			break;				
			case 5:  //double
				if ($CmpPas[$nCA] == "s"){$TipImp = "password";}else{$TipImp = "text";}
				$AliCmp = "Right";
				switch($Accion){
					case "Agregar":
						if ($ValDef[$nCA] != ""){$Valor = $ValDef[$nCA];}else{$Valor = "";}
						$Valor = number_format($Valor, 2, ',', '.');
					break;
					case "Modificar":
						$Valor = number_format($TabQRY[0][0], 2, ',', '.');
					break;
					case "Eliminar":
						$CmpBlo[$nCA] = "disabled";
						$Valor = number_format($TabQRY[0][0], 2, ',', '.');
					break;
					case "Detalles":
						$CmpBlo[$nCA] = "disabled";
						$Valor = number_format($TabQRY[0][0], 2, ',', '.');
					break;
					case "Dinamico":
						$Valor = number_format($Valor, 2, ',', '.');
					break;
				}
				
				echo "<input tabindex=".$TabIndCmp." type='".$TipImp."' name=".$WC["ID"].$nCA." id=".$WC["ID"].$nCA." value='".$Valor."' ".$CmpBlo[$nCA]." ".$CmpMxC[$nCA]." ".$FunEsp[$nCA]." ".$ValEsp[$nCA]." style='width:95%; text-align:".$AliCmp.";' class='InpTexFor' onfocus=\"javascript:DesMenEme();\"/>";
			break;				
			case 10: //date 
				$TipImp = "text";
				$AliCmp = "center";
				switch($Accion){
					case "Agregar":
						if ($ValDef[$nCA] != ""){$Valor = $ValDef[$nCA];}else{$Valor = "";}
					break;
					case "Modificar":
						$Valor = $TabQRY[0][0];
					break;
					case "Eliminar":
						$Valor = $TabQRY[0][0];
						$CmpBlo[$nCA] = "disabled";
					break;
					case "Detalles":
						$Valor = $TabQRY[0][0];
						$CmpBlo[$nCA] = "disabled";
					break;
					case "Dinamico":
					break;
				}
				if ($CmpBlo[$nCA] == ""){
					/*echo "<img id='ImgCal".$WC["ID"].$nCA."' src='img/Calendario.png' class='ImgCalFor' 
					title='Calendario' alt='Calendario' align='left'
					onmouseover='javascript:CambiarImagen(\"ImgCal".$WC["ID"].$nCA."\",\"img/CalendarioB.png\");' 
					onmouseout='javascript:CambiarImagen(\"ImgCal".$WC["ID"].$nCA."\",\"img/Calendario.png\");'
					onclick=''/>";
					$AnIn = "80";*/
					$AnIn = "95";
				}else{
					$AnIn = "95";
				}				
				if ($Valor == "00-00-0000"){$Valor = "";}
				echo "<input tabindex=".$TabIndCmp." type='".$TipImp."' name='".$WC["ID"].$nCA."' id='".$WC["ID"].$nCA."' value='".$Valor."' ".$CmpBlo[$nCA]." ".$CmpMxC[$nCA]." ".$FunEsp[$nCA]." ".$ValEsp[$nCA]." style='width:".$AnIn."%; text-align:".$AliCmp.";' class='InpTexFor' onfocus=\"javascript:DesMenEme();\"/>";
						
			break;				
			case 11:  //time
				$TipImp = "text";
				$AliCmp = "center";
				switch($Accion){
					case "Agregar":
						if ($ValDef[$nCA] != ""){$Valor = $ValDef[$nCA];}else{$Valor = "";}
					break;
					case "Modificar":
						$Valor = $TabQRY[0][0];
					break;
					case "Eliminar":
						$Valor = $TabQRY[0][0];
						$CmpBlo[$nCA] = "disabled";
					break;
					case "Detalles":
						$Valor = $TabQRY[0][0];
						$CmpBlo[$nCA] = "disabled";
					break;
					case "Dinamico":
					break;
				}
				if ($CmpBlo[$nCA] == ""){
					/*echo "<img id='ImgRel".$WC["ID"].$nCA."' src='img/Reloj.png' class='ImgCalFor' 
					title='Reloj' alt='Reloj' align='left'
					onmouseover='javascript:CambiarImagen(\"ImgRel".$WC["ID"].$nCA."\",\"img/RelojB.png\");' 
					onmouseout='javascript:CambiarImagen(\"ImgRel".$WC["ID"].$nCA."\",\"img/Reloj.png\");'
					onclick=''/>";
					$AnIn = "80";
					*/
					$AnIn = "95";
				}else{
					$AnIn = "95";
				}
				if ($Valor == "00:00:00"){$Valor = "";}
				echo "<input tabindex=".$TabIndCmp." type='".$TipImp."' name=".$WC["ID"].$nCA." id=".$WC["ID"].$nCA." value='".$Valor."' ".$CmpBlo[$nCA]." ".$CmpMxC[$nCA]." ".$FunEsp[$nCA]." ".$ValEsp[$nCA]." style='width:".$AnIn."%; text-align:".$AliCmp.";' class='InpTexFor' onfocus=\"javascript:DesMenEme();\"/>";				
			break;				
			case 252: //text 
				if ($CmpPas[$nCA] == "s"){$TipImp = "password";}else{$TipImp = "text";}
				$AliCmp = "left";
				switch($Accion){
					case "Agregar":
						if ($ValDef[$nCA] != ""){$Valor = $ValDef[$nCA];}else{$Valor = "";}
					break;
					case "Modificar":
						$Valor = $TabQRY[0][0];
					break;
					case "Eliminar":
						$Valor = $TabQRY[0][0];
						$CmpBlo[$nCA] = "disabled";
					break;
					case "Detalles":
						$Valor = $TabQRY[0][0];
						$CmpBlo[$nCA] = "disabled";
					break;
					case "Dinamico":
					break;
				}
				if ($CmpQRY[0]->length > 100){
					echo "<textarea tabindex=".$TabIndCmp." type='".$TipImp."' name=".$WC["ID"].$nCA." id=".$WC["ID"].$nCA." ".$CmpBlo[$nCA]." ".$CmpMxC[$nCA]." ".$FunEsp[$nCA]." ".$ValEsp[$nCA]." style='width:95%; text-align:".$AliCmp.";' class='InpTexFor' onfocus=\"javascript:DesMenEme();\"/>";
						echo $Valor;
					echo "</textarea>";
				}else{							
					echo "<input tabindex=".$TabIndCmp." type='".$TipImp."' name=".$WC["ID"].$nCA." id=".$WC["ID"].$nCA." value='".$Valor."' ".$CmpBlo[$nCA]." ".$CmpMxC[$nCA]." ".$FunEsp[$nCA]." ".$ValEsp[$nCA]." style='width:95%; text-align:".$AliCmp.";' class='InpTexFor' onfocus=\"javascript:DesMenEme();\"/>";
				}		
			break;				
			case 253: //varchar 
				if ($CmpPas[$nCA] == "s"){$TipImp = "password";}else{$TipImp = "text";}
				$AliCmp = "left";
				switch($Accion){
					case "Agregar":
						if ($ValDef[$nCA] != ""){$Valor = $ValDef[$nCA];}else{$Valor = "";}
					break;
					case "Modificar":
						$Valor = $TabQRY[0][0];
					break;
					case "Eliminar":
						$Valor = $TabQRY[0][0];
						$CmpBlo[$nCA] = "disabled";
					break;
					case "Detalles":
						$Valor = $TabQRY[0][0];
						$CmpBlo[$nCA] = "disabled";
					break;
					case "Dinamico":
					break;
				}
				if ($CmpQRY[0]->length > 100){
					echo "<textarea tabindex=".$TabIndCmp." type='".$TipImp."' name=".$WC["ID"].$nCA." id=".$WC["ID"].$nCA." ".$CmpBlo[$nCA]." ".$CmpMxC[$nCA]." ".$FunEsp[$nCA]." ".$ValEsp[$nCA]." style='width:95%; text-align:".$AliCmp.";' class='InpTexFor' onfocus=\"javascript:DesMenEme();\"/>";
						echo $Valor;
					echo "</textarea>";
				}else{							
					echo "<input tabindex=".$TabIndCmp." type='".$TipImp."' name=".$WC["ID"].$nCA." id=".$WC["ID"].$nCA." value='".$Valor."' ".$CmpBlo[$nCA]." ".$CmpMxC[$nCA]." ".$FunEsp[$nCA]." ".$ValEsp[$nCA]." style='width:95%; text-align:".$AliCmp.";' class='InpTexFor' onfocus=\"javascript:DesMenEme();\"/>";
				}
			break;				
		}
		
		switch($CmpQRY[0]->type){
			case 1: $TipCam = "bool"; break;//boleano
			case 3: $TipCam = "int4"; break;//integer
			case 5: $TipCam = "float8"; break;//double
			case 10: $TipCam = "date"; break;//date
			case 11: $TipCam = "time"; break;//time							
			case 252: $TipCam = "varchar"; break;//text							
			case 253: $TipCam = "varchar"; break;//varchar
		}
		
		if ($ValEsp[$nCA] == ""){return $TipCam;}else{return $ValEsp[$nCA];}
	}else{
		if ($CmpSel["Tipo"] == "Lista"){
			switch($Accion){
				case "Agregar":
					if ($ValDef[$nCA] != ""){$Valor = $ValDef[$nCA];}else{$Valor = "";}
					echo "<select tabindex=".$TabIndCmp." name=".$WC["ID"].$nCA." id=".$WC["ID"].$nCA." ".$CmpBlo[$nCA]." ".$CmpMxC[$nCA]." ".$FunEsp[$nCA]." ".$ValEsp[$nCA]." style='width:95%; text-align:".$AliCmp.";' class='SelFor' onfocus=\"javascript:DesMenEme();\">";
						echo "<option value='' selected='selected'>Seleccione ...</option>";						
						$OpcIteCS = split(",",$CmpSel["Item"]);
						$OpcValCS = split(",",$CmpSel["ItemVal"]);						
						for ($n = 0; $n <= count($OpcIteCS) - 1; $n++){
							echo "<option value='".$OpcValCS[$n]."' ";
							if ($Valor == $OpcValCS[$n]){echo "selected='selected'";}
							echo ">".$OpcIteCS[$n]."</option>";
						}
					echo "</select>";
				break;
				case "Modificar":
					$Valor = $TabQRY[0][0];
					echo "<select tabindex=".$TabIndCmp." name=".$WC["ID"].$nCA." id=".$WC["ID"].$nCA." ".$CmpBlo[$nCA]." ".$CmpMxC[$nCA]." ".$FunEsp[$nCA]." ".$ValEsp[$nCA]." style='width:95%; text-align:".$AliCmp.";' class='SelFor' onfocus=\"javascript:DesMenEme();\">";
						echo "<option value='' selected='selected'>Seleccione ...</option>";						
						$OpcIteCS = split(",",$CmpSel["Item"]);
						$OpcValCS = split(",",$CmpSel["ItemVal"]);						
						for ($n = 0; $n <= count($OpcIteCS) - 1; $n++){
							echo "<option value='".$OpcValCS[$n]."' ";
							if ($Valor == $OpcValCS[$n]){echo "selected='selected'";}
							echo ">".$OpcIteCS[$n]."</option>";
						}
					echo "</select>";
				break;
				case "Eliminar":
					$Valor = $TabQRY[0][0];
					if ($CmpPas[$nCA] == "s"){$TipImp = "password";}else{$TipImp = "text";}
					$CmpBlo[$nCA] = "disabled";
					echo "<input tabindex=".$TabIndCmp." type='".$TipImp."' name=".$WC["ID"].$nCA." id=".$WC["ID"].$nCA." value='".$Valor."' ".$CmpBlo[$nCA]." ".$CmpMxC[$nCA]." ".$FunEsp[$nCA]." ".$ValEsp[$nCA]." style='width:95%; text-align:".$AliCmp.";' class='InpTexFor' onfocus=\"javascript:DesMenEme();\"/>";
				break;
				case "Detalles":
					$Valor = $TabQRY[0][0];
					if ($CmpPas[$nCA] == "s"){$TipImp = "password";}else{$TipImp = "text";}
					$CmpBlo[$nCA] = "disabled";
					echo "<input tabindex=".$TabIndCmp." type='".$TipImp."' name=".$WC["ID"].$nCA." id=".$WC["ID"].$nCA." value='".$Valor."' ".$CmpBlo[$nCA]." ".$CmpMxC[$nCA]." ".$FunEsp[$nCA]." ".$ValEsp[$nCA]." style='width:95%; text-align:".$AliCmp.";' class='InpTexFor' onfocus=\"javascript:DesMenEme();\"/>";
				break;
				case "Dinamico":
				break;
			}
			
		}
		if ($CmpSel["Tipo"] == "Select"){
			$resultCS = $link->query("SELECT ".$CmpSel["Campos"]." FROM ".$CmpSel["Tablas"]." ".$CmpSel["Donde"]." ORDER BY ".$CmpSel["Ordena"]);
			for ($TabQRYCS = array();$tmpCS = $resultCS->fetch_array(MYSQLI_BOTH);){$TabQRYCS[] = $tmpCS;}
			switch($Accion){				
				case "Agregar":
					if ($ValDef[$nCA] != ""){$Valor = $ValDef[$nCA];}else{$Valor = "";}
					echo "<select tabindex=".$TabIndCmp." name=".$WC["ID"].$nCA." id=".$WC["ID"].$nCA." ".$CmpBlo[$nCA]." ".$CmpMxC[$nCA]." ".$FunEsp[$nCA]." ".$ValEsp[$nCA]." style='width:95%; text-align:".$AliCmp.";' class='SelFor' onfocus=\"javascript:DesMenEme();\">";
						echo "<option value='' selected='selected'>Seleccione ...</option>";						
						$CmpVI = split(",",$CmpSel["Campos"]);
						for ($n = 0; $n <= count($TabQRYCS) - 1; $n++){
							echo "<option value='".$TabQRYCS[$n][$CmpVI[0]]."' ";
							if ($Valor == $TabQRYCS[$n][$CmpVI[0]]){echo "selected='selected'";}
							echo ">";							
							for ($nCmpVI = 1; $nCmpVI <= (count($CmpVI) -1); $nCmpVI++){
								if ($nCmpVI < 2){
									echo $TabQRYCS[$n][$CmpVI[$nCmpVI]];
								}else{
									echo " - ".substr($TabQRYCS[$n][$CmpVI[$nCmpVI]],0,30);
								}								
							}
							echo "</option>";
						}
					echo "</select>";					
				break;
				case "Modificar":
					$Valor = $TabQRY[0][0];
					echo "<select tabindex=".$TabIndCmp." name=".$WC["ID"].$nCA." id=".$WC["ID"].$nCA." ".$CmpBlo[$nCA]." ".$CmpMxC[$nCA]." ".$FunEsp[$nCA]." ".$ValEsp[$nCA]." style='width:95%; text-align:".$AliCmp.";' class='SelFor' onfocus=\"javascript:DesMenEme();\">";
						echo "<option value='' selected='selected'>Seleccione ...</option>";						
						$CmpVI = split(",",$CmpSel["Campos"]);
						for ($n = 0; $n <= count($TabQRYCS) - 1; $n++){
							echo "<option value='".$TabQRYCS[$n][$CmpVI[0]]."' ";
							if ($Valor == $TabQRYCS[$n][$CmpVI[0]]){echo "selected='selected'";}
							echo ">";							
							for ($nCmpVI = 1; $nCmpVI <= (count($CmpVI) -1); $nCmpVI++){
								if ($nCmpVI < 2){
									echo $TabQRYCS[$n][$CmpVI[$nCmpVI]];
								}else{
									echo " - ".substr($TabQRYCS[$n][$CmpVI[$nCmpVI]],0,30);
								}								
							}
							echo "</option>";
						}
					echo "</select>";
				break;
				case "Eliminar":
					$Valor = $TabQRY[0][0];
					if ($CmpPas[$nCA] == "s"){$TipImp = "password";}else{$TipImp = "text";}
					$CmpBlo[$nCA] = "disabled";
					
					$resultCS = $link->query("SELECT ".$CmpSel["Campos"]." FROM ".$CmpSel["Tablas"]." WHERE ".$CmpSel["Compara"]."='".$Valor."' ORDER BY ".$CmpSel["Ordena"]);
					for ($TabQRYCS = array();$tmpCS = $resultCS->fetch_array(MYSQLI_BOTH);){$TabQRYCS[] = $tmpCS;}					
					if ($resultCS->num_rows == 0){
						$Valor = $Valor." - ???";
					}else{						
						$Valor = $Valor." - ";						
						$CmpVI = split(",",$CmpSel["Campos"]);
						for ($nCmpVI = 1; $nCmpVI <= (count($CmpVI) -1); $nCmpVI++){
							if ($nCmpVI < 2){
								$Valor = $Valor.$TabQRYCS[0][$CmpVI[$nCmpVI]];
							}else{
								$Valor = $Valor." - ".substr($TabQRYCS[0][$CmpVI[$nCmpVI]],0,30);
							}								
						}						
					}
					echo "<input tabindex=".$TabIndCmp." type='".$TipImp."' name=".$WC["ID"].$nCA." id=".$WC["ID"].$nCA." value='".$Valor."' ".$CmpBlo[$nCA]." ".$CmpMxC[$nCA]." ".$FunEsp[$nCA]." ".$ValEsp[$nCA]." style='width:95%; text-align:".$AliCmp.";' class='InpTexFor' onfocus=\"javascript:DesMenEme();\"/>";
				break;
				case "Detalles":
					$Valor = $TabQRY[0][0];
					if ($CmpPas[$nCA] == "s"){$TipImp = "password";}else{$TipImp = "text";}
					$CmpBlo[$nCA] = "disabled";
					
					$resultCS = $link->query("SELECT ".$CmpSel["Campos"]." FROM ".$CmpSel["Tablas"]." WHERE ".$CmpSel["Compara"]."='".$Valor."' ORDER BY ".$CmpSel["Ordena"]);
					for ($TabQRYCS = array();$tmpCS = $resultCS->fetch_array(MYSQLI_BOTH);){$TabQRYCS[] = $tmpCS;}					
					if ($resultCS->num_rows == 0){
						$Valor = $Valor." - ???";
					}else{						
						$Valor = $Valor." - ";						
						$CmpVI = split(",",$CmpSel["Campos"]);
						for ($nCmpVI = 1; $nCmpVI <= (count($CmpVI) -1); $nCmpVI++){
							if ($nCmpVI < 2){
								$Valor = $Valor.$TabQRYCS[0][$CmpVI[$nCmpVI]];
							}else{
								$Valor = $Valor." - ".substr($TabQRYCS[0][$CmpVI[$nCmpVI]],0,30);
							}								
						}
					}
					echo "<input tabindex=".$TabIndCmp." type='".$TipImp."' name=".$WC["ID"].$nCA." id=".$WC["ID"].$nCA." value='".$Valor."' ".$CmpBlo[$nCA]." ".$CmpMxC[$nCA]." ".$FunEsp[$nCA]." ".$ValEsp[$nCA]." style='width:95%; text-align:".$AliCmp.";' class='InpTexFor' onfocus=\"javascript:DesMenEme();\"/>";
				break;
				case "Dinamico":
				break;
			}			
		}
		return "combo";
	}	
}
?>
</body>
</html>