<?php
error_reporting(0);
session_start();

$Query = $_SESSION["QryPri"];
$CmpSel = $_SESSION["Form"]["Widgets"]["W0"]["Contenido"]["CmpSel"]["Cmp"];

$TitCam = split(",",$_POST["TitCamImp"]);
$LisAncCol = split(",",$_POST["LisAncCol"]);

for ($n = 0; $n <= count($LisAncCol) - 1; $n++){
	$TAC = $TAC + $LisAncCol[$n];
}

for ($n = 0; $n <= count($LisAncCol) - 1; $n++){
	$LisAncCol[$n] = ($LisAncCol[$n] * 100) / $TAC;
}

require_once ("../modulos/bd.php");
$result = $link->query($Query);
$NFilas = $result->num_rows;
for ($Data = array();$Tmp = $result->fetch_array(MYSQLI_BOTH);){$Data[] = $Tmp;}
for ($CmpQRY = array();$Tmp2 = $result->fetch_field();){$CmpQRY[] = $Tmp2;}
for ($n = 0; $n <= (count($CmpQRY) -1); $n++){
	$TipCam[] = $CmpQRY[$n]->type;
	switch($CmpQRY[$n]->type){
		case 1: $Alineacion[]="C"; break; //boleano				
		case 3: $Alineacion[]="R"; break; //integer				
		case 5: $Alineacion[]="R"; break; //double
		case 8: $Alineacion[]="R"; break; //???				
		case 10: $Alineacion[]="C"; break; //date				
		case 11: $Alineacion[]="C"; break; //time				
		case 252: $Alineacion[]="C"; break; //text
		case 253: $Alineacion[]="L"; break; //varchar
		default: $Alineacion[]="C"; break; //text				
	}
	if ($CmpSel[$n-1]["Tipo"] == "Select"){$Alineacion[$n] = "L";}
}

$NomArc = $_POST["TituloImp"]." - ".$_POST["UsuarioImp"].".pdf";
$Creador = $_POST["UsuarioImp"];
$Titulo = $_POST["TituloImp"];

//$_SESSION["TituloImp"] = $_POST["TituloImp"];
//$_SESSION["LogoImp"] = $_POST["LogoImp"];
//$_SESSION["TitImp"] = str_replace("<br />","\n",$_POST["TitImp"]);

$_SESSION["TituloImp"] = "Federacion Venezolana de \n WUSHU";
$_SESSION["LogoImp"] = $_POST["LogoImp"];
$_SESSION["TitImp"] = "Federacion Venezolana de \n WUSHU";

switch ($_POST["TipPapImp"]){
	case "Carta": 
		$TipPapImp = "Letter";
		switch ($_POST["OriPapImp"]){
			case "Vertical": 
				$OriPapImp = "P"; 
				$AncTab = 196;
			break;
			case "Horizontal": 
				$OriPapImp = "L"; 
				$AncTab = 259;
			break;
		}
	break;
	case "Oficio": 
		$TipPapImp = "Legal"; 
		switch ($_POST["OriPapImp"]){
			case "Vertical": 
				$OriPapImp = "P"; 
				$AncTab = 196;
			break;
			case "Horizontal": 
				$OriPapImp = "L"; 
				$AncTab = 336;
			break;
		}
	break;
	case "A4": 
		$TipPapImp = "A4";
		switch ($_POST["OriPapImp"]){
			case "Vertical": 
				$OriPapImp = "P"; 
				$AncTab = 190;
			break;
			case "Horizontal": 
				$OriPapImp = "L"; 
				$AncTab = 277;
			break;
		}
	break;
}


require_once ("../clases/fpdf17/fpdf.php");

class PDF extends FPDF{
	function Header(){
		$this->Image("../".$_SESSION["LogoImp"],10,8,33);
		$this->SetFont("Arial","B",15);
		$this->SetTextColor(128);
		$this->SetDrawColor(128);
		$this->MultiCell(0,7,$_SESSION["TitImp"],"B","R");
		$this->SetTextColor(64);
		$this->SetFont("Arial","BI",12);
		$this->Cell(0,7,$this->title,"B",0,"C");
		$this->Ln(10);
	}
	
	function Footer(){		
		$this->SetY(-10);		
		$this->SetFont("Arial","I",8);		
		$this->SetTextColor(64);
		$this->SetDrawColor(128);
		
		if ($this->DefOrientation == "P"){$AP = $this->CurPageSize[0];}else{$AP = $this->CurPageSize[1];}		
		//$AP = "*".$this->CurPageSize[0]."*".$this->CurPageSize[1]."*";
		$this->Cell(0,5,"Elaborado por: ".$this->author.str_repeat(" ",$AP / 4)."Pagina ".$this->PageNo()."/{nb}".str_repeat(" ",$AP / 4)."Fecha de Elaboracion: ".date("d/m/Y",time() - 16200),"T",0,"C");
	}
	
	
	function Tabla($Titulos, $Data, $NFilas,$AncTab,$Alineacion,$TipCam,$LisAncCol){
		// Colores, ancho de línea y fuente en negrita
		$this->SetFillColor(200);
		$this->SetTextColor(0);
		$this->SetDrawColor(85);
		$this->SetLineWidth(.3);
		$this->SetFont("Arial","B",10);		
		
		// Cabecera
		//$Ancho = $AncTab / count($Titulos);
		
		for ($n = 0; $n <= count($LisAncCol) - 1; $n++){
			$LisAncCol[$n] = ($LisAncCol[$n] * $AncTab) / 100;
		}
		
		for($i = 0; $i < count($Titulos); $i++)
			$this->Cell($LisAncCol[$i],7,$Titulos[$i],1,0,$Alineacion[$i],true);
		$this->Ln();
		// Restauración de colores y fuentes			
		$this->SetFillColor(255);
		$this->SetTextColor(0);
		$this->SetLineWidth(.3);
		$this->SetFont("Arial","",8);
		
		// Datos
		$fill = false;
		
		if ($NFilas == 0){
		}else{
			$trPF = 255;//Color tr Primera Fila
			$trSF = 235;//Color tr Segunda Fila
			for ($n = 0; $n <= ($NFilas - 1); $n++){
				$PX = $this->GetX();
				$PY = $this->GetY();
				$PC = 10;
				
				if ($Par != $trPF){$Par = $trPF;}else{$Par = $trSF;}
				$this->SetFillColor($Par);
				
				$NMLC = 2;				
				for ($n2 = 0; $n2 < count($Titulos); $n2++){
					$Txt = $Data[$n][$n2];					
					$NEC = substr_count($Txt, '\n');
					$NMCC = strlen($Txt);
					$LMCC = 2 * $NMCC;
					$NLC = $LMCC / $LisAncCol[$n2];
					$NMLC = max($NMLC,$NLC,$NEC);
				}
				$NMLC = ceil($NMLC);				
				
				if($this->GetY() + (10 * ($NMLC - 1)) > $this->PageBreakTrigger){
					$this->AddPage($this->CurOrientation);					
					///////////////////////////////////////////////////////////
					$this->SetFillColor(200);
					$this->SetTextColor(0);
					$this->SetDrawColor(85);
					$this->SetLineWidth(.3);
					$this->SetFont("Arial","B",10);		
															
					for($i = 0; $i < count($Titulos); $i++)
						$this->Cell($LisAncCol[$i],7,$Titulos[$i],1,0,$Alineacion[$i],true);
					$this->Ln();
					// Restauración de colores y fuentes
					
					//if ($Par != $trPF){$Par = $trPF;}else{$Par = $trSF;}
					$this->SetFillColor($Par);
					
					//$this->SetFillColor(255);
					$this->SetTextColor(0);
					$this->SetLineWidth(.3);
					$this->SetFont("Arial","",8);
					// Datos					
					$PX = $this->GetX();
					$PY = $this->GetY();
					$PC = 10;
					
					$NMLC = 2;
					for ($n2 = 0; $n2 < count($Titulos); $n2++){
						$Txt = $Data[$n][$n2];					
						$NEC = substr_count($Txt, '\n');												
						$NMCC = strlen($Txt);
						$LMCC = 2 * $NMCC;
						$NLC = $LMCC / $LisAncCol[$n2];
						$NMLC = max($NMLC,$NLC,$NEC);
					}
					$NMLC = ceil($NMLC);					
				}
				
				for ($n2 = 0; $n2 <= count($Titulos) - 1; $n2++){
					if ($n2 > 0){$PC = $PC + $LisAncCol[$n2-1];}
					
					switch($TipCam[$n2]){
						case 1://boleano 
							if ($Data[$n][$n2] == true){$Valor = "Si";}else{$Valor = "No";} 
						break;								
						case 3://integer
							$Valor = number_format($Data[$n][$n2], 0, ',', '.'); 
						break; 
						case 5://double 
							$Valor = number_format($Data[$n][$n2], 2, ',', '.'); 
						break;
						case 8://???
							$Valor = number_format($Data[$n][$n2], 0, ',', '.'); 
						break; 
						case 10://date
							$FT = split("-",$Data[$n][$n2]);
							$Valor = $FT[2]."-".$FT[1]."-".$FT[0];
						break; 
						case 11://time
							$Valor = $Data[$n][$n2]; 
						break; 
						case 252://text
							$Valor = $Data[$n][$n2]; 
						break; 
						case 253://varchar
							$Valor = $Data[$n][$n2]; 
						break;
						default:
							$Valor = $Data[$n][$n2]; 
						break;
					}
					
					require ("../modulos/bd.php");
					$CmpSel = $_SESSION["Form"]["Widgets"]["W0"]["Contenido"]["CmpSel"]["Cmp"];
															
					if ($CmpSel[$n2-1]["Tipo"] == "Select"){															
						$resultCS = $link->query("SELECT ".$CmpSel[$n2-1]["Campos"]." FROM ".$CmpSel[$n2-1]["Tablas"]." WHERE ".$CmpSel[$n2-1]["Compara"]."='".$Data[$n][$n2]."'");
						for ($TabQRYCS = array();$tmpCS = $resultCS->fetch_array(MYSQLI_BOTH);){
							$TabQRYCS[] = $tmpCS;
						}
						if ($resultCS->num_rows > 0){
							$Valor = $Data[$n][$n2]." - ".$TabQRYCS[0][1];
						}else{
							$Valor = $Data[$n][$n2]." - ???";
						}						
					}
					
					//$this->Cell($LisAncCol[$n2],18,$Valor,'LR',0,$Alineacion[$n2],true);
					$this->SetXY($PC,$PY);
					//$this->MultiCell($LisAncCol[$n2],(5 * ($NMLC - 1)),$Valor,'LR',$Alineacion[$n2],true);					
					$this->Rect($PC,$PY,$LisAncCol[$n2],(10 * ($NMLC)),"FD");
					$this->MultiCell($LisAncCol[$n2],5,$Valor,0,$Alineacion[$n2]);					
					//$this->SetY($this->GetY() + (10 * ($NMLC - 1)));
					$this->SetY(($this->GetY() + (10 * ($NMLC - 1))) - 5);
				}
				//$this->Ln();
			}			
			//$this->Cell($AncTab,0,'','T');			
		}
	}	
}


$pdf = new PDF($OriPapImp,"mm",$TipPapImp);
$pdf->AliasNbPages();
$pdf->SetAuthor($Creador);
$pdf->SetCreator("InvDefFW");
$pdf->SetTitle($Titulo);
$pdf->AddPage();
$pdf->Tabla($TitCam,$Data,$NFilas,$AncTab,$Alineacion,$TipCam,$LisAncCol);
$pdf->Output();
?>