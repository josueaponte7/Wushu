<?php session_start(); include("bd.php"); include("modulo.php");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<?php
$Conf["IDMenu"] = $_POST["idm"];
$Conf["Modulo"] = $_POST["mod"];
$Conf["Titulo"] = $_POST["tit"];

$Conf["TipPap"] = "Carta";
//$Conf["TipPap"] = "Oficio";
//$Conf["TipPap"] = "A4";
$Conf["OriPap"] = "Vertical";
//$Conf["OriPap"] = "Horizontal";

$Cont["Campos"] = "NRegAso,Estatus";
$Cont["TitCam"] = "Asociacion,Estatus";
$Cont["Orden"] = "ORDER BY Oro DESC";

$TitCampos = "Nombre,Cedula,Asociacion,Oro,Plata,Bronce,4to Lugar,5to Lugar";
$NomCampos = "NRegAtl,Cedula,Asociacion,Oro,Plata,Bronce,4toLugar,5toLugar";
$TitCam = split(",",$TitCampos);
$Campos = split(",",$NomCampos);

$trPF = "#FFFFFF";//Color tr Primera Fila
$trSF = "#DEDEDE";//Color tr Segunda Fila

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
	$Filtros = " AND ".$Filtros;	
}


$QryPri = "
SELECT Nombre,
	   Cedula,
	   (SELECT Nombre FROM Asociaciones WHERE NRegistro = A.Asociacion) AS Asociacion,
	   (SELECT COUNT(*) FROM competencia WHERE Estatus = '1ER LUGAR' AND NRegAtl = A.NRegistro) AS Oro,
	   (SELECT COUNT(*) FROM competencia WHERE Estatus = '2DO LUGAR' AND NRegAtl = A.NRegistro) AS Plata,
	   (SELECT COUNT(*) FROM competencia WHERE Estatus = '3ER LUGAR' AND NRegAtl = A.NRegistro) AS Bronce,
	   (SELECT COUNT(*) FROM competencia WHERE Estatus = '4TO LUGAR' AND NRegAtl = A.NRegistro) AS 4TOLUGAR,
	   (SELECT COUNT(*) FROM competencia WHERE Estatus = '5TO LUGAR' AND NRegAtl = A.NRegistro) AS 5TOLUGAR
	FROM atletas AS A
	WHERE NRegistro > 0 ".$Filtros." ".$Orden;

//echo $QryPri;

$result = $link->query($QryPri);
$NFilas = $result->num_rows;
//$NFilas=0;

for ($TabQRY = array();$tmp = $result->fetch_array(MYSQLI_BOTH);){$TabQRY[] = $tmp;}
for ($CmpQRY = array();$tmp2 = $result->fetch_field();){$CmpQRY[] = $tmp2;}

//$CmpPas = "";

//Alineacion td
for ($n = 0; $n <= (count($CmpQRY) -1); $n++){		
	switch($CmpQRY[$n]->type){
		case 1: $Alineacion[]="center"; break; //boleano				
		case 3: $Alineacion[]="right"; break; //integer				
		case 5: $Alineacion[]="right"; break; //double
		case 8: $Alineacion[]="right"; break; //???
		case 10: $Alineacion[]="center"; break; //date				
		case 11: $Alineacion[]="center"; break; //time				
		case 252: $Alineacion[]="center"; break; //text				
		case 253: $Alineacion[]="left"; break; //varchar
		default: $Alineacion[]="right"; break; //varchar
	}
}

//DIV Tabla Modulo
echo "<div id='TabMod' class='TabMod'>";
	echo "<table id='EncTabMod' class='EncTabMod'>";
		echo "<tr>";			
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
			$CanCol = count($TitCam);
			echo "<tr bgcolor='".$trPF."'><td id='tdNER' class='tdNER' colspan='".$CanCol."'>No existen registros</td></tr>";
		}else{
			for ($n = 0; $n <= ($NFilas - 1); $n++){
				if ($Par != $trPF){$Par = $trPF;}else{$Par = $trSF;}
				echo "<tr bgcolor='".$Par."'>";											
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
							case 8://???
								$Valor = number_format($TabQRY[$n][$n2], 0, ',', '.'); 
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
							default:
								$Valor = $TabQRY[$n][$n2]; 
							break;
						}
							//if ($CmpPas[$n2-1] == "s"){$Valor = "****";}
						
						echo "<td id='tdDetTabMod".$n.$n2."' class='tdDetTabMod' align='".$Alineacion[$n2]."'>";
								echo $Valor;
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
				echo "</td>";
				echo "<td id='Op7' class='tdTabOpcMod'>";
					$_SESSION["QryPri"] = $QryPri;
					//onclick='javascript:IniExportar(\"".str_replace("'",":",$QryPri)."\",\"".$Cont["TitCam"]."\",\"".$Conf["Titulo"]."\",\"".$_SESSION["NomUsuAct"]."\");' 
					echo "<img id='ImgOpc7' src='img/Exportar.png' class='BotOpc' 
					title='Exportar' alt='Exportar'
					onmouseover='javascript:CambiarImagen(\"ImgOpc7\",\"img/ExportarB.png\");' 
					onmouseout='javascript:CambiarImagen(\"ImgOpc7\",\"img/Exportar.png\");'
					onclick='javascript:IniExportar(\"\",\"".$TitCampos."\",\"".$Conf["Titulo"]."\",\"".$_SESSION["NomUsuAct"]."\");' 
					/>";
				echo "</td>";
				echo "<td id='Op8' class='tdTabOpcMod'>";
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
					echo "IniImprimir(\"\",\"".$TitCampos."\",\"".$Conf["Titulo"]."\",\"".$_SESSION["NomUsuAct"]."\",\"".$Conf["TipPap"]."\",\"".$Conf["OriPap"]."\",LisAncCol);'/>";				
				echo "</td>";
				echo "<td id='Op9' class='tdTabOpcMod'>";
					echo "&nbsp;";
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
?>
</body>
</html>