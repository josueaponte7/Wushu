<?php
header("Content-Type: xlsx");
header("Content-Disposition: attachment; filename=".$_POST["TituloExp"]." - ".$_POST["UsuarioExp"].".xlsx");
header("Content-Transfer-Encoding: binary");
header("Content-Length: ");

//header('Content-Type: application/vnd.ms-excel');
//header("Content-Disposition: attachment; filename=".$_POST["TituloExp"]." - ".$_POST["UsuarioExp"].".xls");
//header("Content-Transfer-Encoding: binary");
//header("Content-Length: ");
//header('Cache-Control: max-age=0');

//error_reporting(E_ALL);
//ini_set('display_errors', TRUE);
//ini_set('display_startup_errors', TRUE);
date_default_timezone_set('America/Caracas');
define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

session_start();
$Query = $_SESSION["QryPri"];
$CmpSel = $_SESSION["Form"]["Widgets"]["W0"]["Contenido"]["CmpSel"]["Cmp"];
//echo $Query."***";
//$Query = str_replace (":","'",$_POST["QueryExp"]);
//echo $_POST["TitCamExp"]."***";
$TitCam = explode(",",$_POST["TitCamExp"]);

$NomArc = $_POST["TituloExp"]." - ".$_POST["UsuarioExp"].".xlsx";
$NomHoj = "Hoja1";

$Creador = $_POST["UsuarioExp"];
$Titulo = $_POST["TituloExp"];
$Asunto = "Exportacion de Datos";
$Descripcion = "Exportacion de Datos";
$PalCla = $_POST["TituloExp"];
$Categoria = "Exportacion de Datos";

require_once '../clases/PHPExcel.php';
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator($Creador)
							 ->setLastModifiedBy($Creador)
							 ->setTitle($Titulo)
							 ->setSubject($Asunto)
							 ->setDescription($Descripcion)
							 ->setKeywords($PalCla)
							 ->setCategory($Categoria);

include ("../modulos/bd.php");
$result = $link->query($Query);
for ($QRY = array();$Tmp = $result->fetch_array(MYSQLI_BOTH);){$QRY[] = $Tmp;}
for ($CmpQRY = array();$Tmp2 = $result->fetch_field();){$CmpQRY[] = $Tmp2;}
for ($n = 0; $n <= (count($CmpQRY) -1); $n++){$TipCam[] = $CmpQRY[$n]->type;}

for ($n = 0; $n <= (count($QRY) - 1); $n++){
	for ($n2 = 0; $n2 <= (count($CmpQRY) - 1); $n2++){		
		switch ($n2){
			case 0:$n2L = "A"; break;
			case 1:$n2L = "B"; break;
			case 2:$n2L = "C"; break;
			case 3:$n2L = "D"; break;
			case 4:$n2L = "E"; break;
			case 5:$n2L = "F"; break;
			case 6:$n2L = "G"; break;
			case 7:$n2L = "H"; break;
			case 8:$n2L = "I"; break;
			case 9:$n2L = "J"; break;
			case 10:$n2L = "K"; break;
			case 11:$n2L = "L"; break;
			case 12:$n2L = "M"; break;
			case 13:$n2L = "N"; break;
			case 14:$n2L = "O"; break;
			case 15:$n2L = "P"; break;
			case 16:$n2L = "Q"; break;
			case 17:$n2L = "R"; break;
			case 18:$n2L = "S"; break;
			case 19:$n2L = "T"; break;
			case 20:$n2L = "U"; break;
			case 21:$n2L = "V"; break;
			case 22:$n2L = "W"; break;
			case 23:$n2L = "X"; break;
			case 24:$n2L = "Y"; break;
			case 25:$n2L = "Z"; break;
		}
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($n2L."1", $TitCam[$n2]);
		$objPHPExcel->setActiveSheetIndex(0)->getStyle($n2L."1")->getFont()->setBold(true);
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($n2L)->setWidth(14);
		
		switch($TipCam[$n2]){
			case 1://boleano 
				if ($QRY[$n][$n2] == true){$Valor = "Si";}else{$Valor = "No";} 
			break;								
			case 3://integer
				$Valor = $QRY[$n][$n2]; 
			break; 
			case 5://double 
				$Valor = $QRY[$n][$n2]; 
			break;
			case 8://???
				$Valor = number_format($QRY[$n][$n2], 0, ',', '.'); 
			break; 
			case 10://date
				$FT = explode("-",$QRY[$n][$n2]);
				$Valor = $FT[2]."-".$FT[1]."-".$FT[0];
			break; 
			case 11://time
				$Valor = $QRY[$n][$n2]; 
			break; 
			case 252://text
				$Valor = $QRY[$n][$n2]; 
			break; 
			case 253://varchar
				$Valor = $QRY[$n][$n2]; 
			break;
		}
		
		
		if ($CmpSel[$n2-1]["Tipo"] == "Select"){									
			$resultCS = $link->query("SELECT ".$CmpSel[$n2-1]["Campos"]." FROM ".$CmpSel[$n2-1]["Tablas"]." WHERE ".$CmpSel[$n2-1]["Compara"]."='".$QRY[$n][$n2]."'");
			for ($TabQRYCS = array();$tmpCS = $resultCS->fetch_array(MYSQLI_BOTH);){
				$TabQRYCS[] = $tmpCS;
			}
			if ($resultCS->num_rows > 0){
				$Valor = $QRY[$n][$n2]." - ".$TabQRYCS[0][1];
			}else{
				$Valor = $QRY[$n][$n2]." - ???";
			}
		}		
		
		$nC = $n + 2;
		$Cel = $n2L.$nC;		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($Cel, $Valor);
	}	
}

$objPHPExcel->getActiveSheet()->setTitle($NomHoj);
$objPHPExcel->setActiveSheetIndex(0);
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save($NomArc);

readfile($NomArc);