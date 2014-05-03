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

$Cont["Campos"] = "NRegistro,Nombre,Cedula,Sexo,Telefono,EMail,Direccion,Nacionalidad,Asociacion,Fecha,Estatus";
$Cont["TitCam"] = "No,Nombre,Cedula,Sexo,Telefono,EMail,Direccion,Nacionalidad,Asociacion,Fecha,Estatus";
$Cont["Tabla"] = "entrenadores";
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
			"Titulo" => "Principal",
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
					"Col" => 2,
					"Fil" => 6,
					"Brd" => 0,					
					"CSp" => 1,
					"CPa" => 1
				),				
				"Campos" => "Nombre,Cedula,RIF,Sexo,Telefono,EMail,Direccion,Nacionalidad,Asociacion,Fecha,Estatus",
				"TitCam" => "Nombre,Cedula,RIF,Sexo,Telefono,EMail,Direccion,Nacionalidad,Asociacion,Fecha,Estatus",				
				"CmpReq" => "s,s,s,s,s,n,s,s,s,n,s",//Campos Requeridos
				"ValDef" => ",,,,,,,,,,",//Valores por defecto
				"CmpBlo" => "",//Campos bloqueados
				"CmpPas" => ",,,,,,,,,,",//Campos pass
				"CmpMxC" => ",,,,11,,,,,,",//Maximo Caracteres
				"ValEsp" => "sollet,cedrif,rif,,solnum,email",//Agregar tipoX en ValCam() de ../js/funcvari.js y mencionar aqui
				"FunEsp" => "",//Agregar Funcion en ../js/funcvari.js y escribir la llamada aqui
				"CmpSel" => array(
					"Cmp" => array(						
						"3" => array(
							"Tipo" => "Lista",
							"Item" => "MASCULINO,FEMENINO",
							"ItemVal" => "MASCULINO,FEMENINO"
						),
						"7" => array(
							"Tipo" => "Lista",
							"Item" => "VENEZOLANO,EXTRANJERO",
							"ItemVal" => "VENEZOLANO,EXTRANJERO"
						),
						"8"=>array(
							"Tipo" => "Select",
							"Campos" => "NRegistro,Nombre",
							"Tablas" => "asociaciones",
							"Donde" => "Where Estatus='ACTIVO'",
							"Ordena" => "Nombre",
							"Compara" => "NRegistro"
						),
						"10" => array(
							"Tipo" => "Lista",
							"Item" => "ACTIVO,INACTIVO",
							"ItemVal" => "ACTIVO,INACTIVO"
						)
					)
				),
				"Tabla" => "entrenadores",
				"Indice" => "NRegistro"
			),
			"Apariencia" => array(
				"PosSup" => "140px",//140px Para estar dentro de DivContenido
				"PosInf" => "",
				"PosDer" => "",
				"PosIzq" => "245px",//245px Para estar dentro de DivContenido
				"Alto" => "440px",//440px Es el Alto maximo dentro de DivContenido
				"Ancho" => "985px"//985px Es el Ancho maximo dentro de DivContenido				
			)			
		)
	)
);

$_SESSION["Form"] = $Form;
CreaModulo($Conf,$Cont,$link);
?>
</body>
</html>