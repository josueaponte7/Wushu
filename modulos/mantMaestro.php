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

$Cont["OpcDef"] = "";
//$OpcDef[0] = s/n (Controles Edicion)
//$OpcDef[1] = s/n (Puede Agregar)
//$OpcDef[2] = s/n (Puede Modificar)
//$OpcDef[3] = s/n (Puede Eliminar)
//$OpcDef[4] = s/n (Puede Ver Detalles)
//$OpcDef[5] = s/n (Puede Imprimir)
//$OpcDef[6] = s/n (Puede Exportar)
//$OpcDef[7] = s/n (Puede Buscar)

$Cont["Campos"] = "NRegistro,Nombre,NRegMae,Des1,Des2,Des3,Des4,Des5,Des6,Estatus";
$Cont["TitCam"] = "No,Nombre,NRM,Des1,Des2,Des3,Des4,Des5,Des6,Estatus";
$Cont["Tabla"] = "maestro";
$Cont["Donde"] = "";
$Cont["Orden"] = "ORDER BY NRegistro";
$Cont["Limit"] = "";
$Cont["Indice"] = "NRegistro";
$Cont["TamPag"] = 9999;


$Form = array(
	"Modulo" => array(
		"IDMenu" => $_POST["idm"],
		"Modulo" => $_POST["mod"],
		"Titulo" => $_POST["tit"]
	),
	"Widgets" => array(
		"W0" => array(
			"ID" => "W0",
			"Titulo" => "Maestro",
			"Modo" => "Principal",
			"Requerido" => "s",			
			"Contenido" => array(
				"ID" => "W0",
				"Tipo" => "Campos",
				"Accion" => array(
					"Verificar" => array(
						"Hacer" => "Si"
					)
				),
				"DisTab" => array(
					"Col" => 5,
					"Fil" => 2,
					"Brd" => 0,					
					"CSp" => 1,
					"CPa" => 1
				),				
				"Campos" => "Nombre,NRegMae,Des1,Des2,Des3,Des4,Des5,Des6,Estatus",
				"TitCam" => "Nombre,NRM,Des1,Des2,Des3,Des4,Des5,Des6,Estatus",				
				"CmpReq" => "s,s,n,n,n,n,n,n,s",//Campos Requeridos
				"ValDef" => "",//Valores por defecto
				"CmpBlo" => "",//Campos bloqueados
				"CmpPas" => "",//Campos pass
				"CmpMxC" => "",//Maximo Caracteres
				"ValEsp" => "",//Agregar tipoX en ValCam() de ../js/funcvari.js y mencionar aqui
				"FunEsp" => "",//Agregar Funcion en ../js/funcvari.js y escribir la llamada aqui
				"CmpSel" => array(
					"Cmp" => array(
						"1"=>array(
							"Tipo" => "Select",
							"Campos" => "NRegistro,Nombre",
							"Tablas" => "maestro",
							"Donde" => "",							
							"Ordena" => "NRegistro",
							"Compara" => "NRegistro"
						),
						"8" => array(
							"Tipo" => "Lista",
							"Item" => "ACTIVO,INACTIVO",
							"ItemVal" => "ACTIVO,INACTIVO"
						)
					)
				),
				"Tabla" => "maestro",
				"Indice" => "NRegistro"
			),
			"Apariencia" => array(
				"PosSup" => "140px",//140px Para estar dentro de DivContenido
				"PosInf" => "",
				"PosDer" => "",
				"PosIzq" => "245px",//245px Para estar dentro de DivContenido
				"Alto" => "150px",//460px Es el Alto maximo dentro de DivContenido
				"Ancho" => "985px"//985px Es el Ancho maximo dentro de DivContenido				
			)			
		),
		"W1" => array(
			"ID" => "W1",
			"Titulo" => "Detalle Maestro",
			"Modo" => "Secundario",
			"Requerido" => "n",
			"Contenido" => array(
				"ID" => "W1",
				"Tipo" => "CamposLista",
				"Accion" => array(
					"Agregar" => array(
						"Hacer" => "Si"
					),
					"Modificar" => array(
						"Hacer" => "Si"
					),
					"Eliminar" => array(
						"Hacer" => "Si"
					)
				),
				"DisTab" => array(
					"Col" => 5,
					"Fil" => 2,
					"Brd" => 0,					
					"CSp" => 0,
					"CPa" => 0
				),				
				"Campos" => "Nombre,Des1,Des2,Des3,Des4,Des5,Des6,Estatus",
				"TitCam" => "Nombre,Des1,Des2,Des3,Des4,Des5,Des6,Estatus",				
				"CmpReq" => "s,s,n,n,n,n,n,s",//Campos Requeridos
				"ValDef" => "",//Valores por defecto
				"CmpBlo" => "",//Campos bloqueados
				"CmpPas" => "",//Campos pass
				"CmpMxC" => "",//Maximo Caracteres
				"ValEsp" => "",//Agregar tipoX en ValCam() de ../js/funcvari.js y mencionar aqui
				"FunEsp" => "",//Agregar Funcion en ../js/funcvari.js y escribir la llamada aqui
				"CmpSel" => array(
					"Cmp" => array(						
						"7" => array(
							"Tipo" => "Lista",
							"Item" => "ACTIVO,INACTIVO",
							"ItemVal" => "ACTIVO,INACTIVO"
						)
					)
				),
				"Tabla" => "maestro",
				"Indice" => "NRegistro",
				"Relacion" => "NRegMae"
			),
			"Apariencia" => array(
				"PosSup" => "295px",//140px minimo Para estar dentro de DivContenido
				"PosInf" => "",
				"PosDer" => "",
				"PosIzq" => "245px",//245px minimo Para estar dentro de DivContenido
				"Alto" => "285px",
				"Ancho" => "985px",				
			)
		)
	)
);

$_SESSION["Form"] = $Form;
CreaModulo($Conf,$Cont,$link);
?>
</body>
</html>