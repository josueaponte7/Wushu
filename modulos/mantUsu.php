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

$Cont["Campos"] = "NRegistro,Nombre,Cedula,Telefonos,Direccion,EMail,Cargo,Foto,Usuario,Clave,Tipo,Estatus";
$Cont["TitCam"] = "No,Nombre,Cedula,Telefonos,Direccion,EMail,Cargo,Foto,Usuario,Clave,Tipo,Estatus";
$Cont["Tabla"] = "usuarios";
if ($_SESSION["CodUsuAct"] == 1){
	$Cont["Donde"] = "";
}else{
	$Cont["Donde"] = "WHERE NRegistro > 1";
}
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
			"Titulo" => "Usuarios",
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
					"Col" => 4,
					"Fil" => 3,
					"Brd" => 0,					
					"CSp" => 1,
					"CPa" => 1
				),				
				"Campos" => "Nombre,Cedula,Telefonos,Direccion,EMail,Cargo,Foto,Usuario,Clave,Tipo,Estatus",
				"TitCam" => "Nombre,Cedula,Telefonos,Direccion,EMail,Cargo,Foto,Usuario,Clave,Tipo,Estatus",				
				"CmpReq" => "s,s,n,n,n,n,n,s,s,n,s",//Campos Requeridos
				"ValDef" => "",//Valores por defecto
				"CmpBlo" => "",//Campos bloqueados
				"CmpPas" => ",,,,,,,,s,,",//Campos pass
				"CmpMxC" => "",//Maximo Caracteres
				"ValEsp" => "",//Agregar tipoX en ValCam() de ../js/funcvari.js y mencionar aqui
				"FunEsp" => "",//Agregar Funcion en ../js/funcvari.js y escribir la llamada aqui
				"CmpSel" => array(
					"Cmp" => array(						
						"10" => array(
							"Tipo" => "Lista",
							"Item" => "NUEVO,RECHAZADO,ACTIVO,INACTIVO",
							"ItemVal" => "NUEVO,RECHAZADO,ACTIVO,INACTIVO"
						)
					)
				),
				"Tabla" => "usuarios",
				"Indice" => "NRegistro"
			),
			"Apariencia" => array(
				"PosSup" => "140px",//140px Para estar dentro de DivContenido
				"PosInf" => "",
				"PosDer" => "",
				"PosIzq" => "245px",//245px Para estar dentro de DivContenido
				"Alto" => "200px",//460px Es el Alto maximo dentro de DivContenido
				"Ancho" => "985px"//985px Es el Ancho maximo dentro de DivContenido				
			)			
		),
		"W1" => array(
			"ID" => "W1",
			"Titulo" => "Perfiles",
			"Modo" => "Secundario",
			"Requerido" => "s",
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
					"Col" => 2,
					"Fil" => 1,
					"Brd" => 0,					
					"CSp" => 0,
					"CPa" => 0
				),				
				"Campos" => "NRegPer,Estatus",
				"TitCam" => "Perfil,Estatus",				
				"CmpReq" => "s,s",//Campos Requeridos
				"ValDef" => "",//Valores por defecto
				"CmpBlo" => "",//Campos bloqueados
				"CmpPas" => "",//Campos pass
				"CmpMxC" => "",//Maximo Caracteres
				"ValEsp" => "",//Agregar tipoX en ValCam() de ../js/funcvari.js y mencionar aqui
				"FunEsp" => "",//Agregar Funcion en ../js/funcvari.js y escribir la llamada aqui
				"CmpSel" => array(
					"Cmp" => array(
						"0"=>array(
							"Tipo" => "Select",
							"Campos" => "NRegistro,Nombre",
							"Tablas" => "maestro",
							"Donde" => "Where NRegMae=15",
							"Ordena" => "NRegistro",
							"Compara" => "NRegistro"
						),
						"1" => array(
							"Tipo" => "Lista",
							"Item" => "ACTIVO,INACTIVO",
							"ItemVal" => "ACTIVO,INACTIVO"
						)
					)
				),
				"Tabla" => "detusuario",
				"Indice" => "NRegistro",
				"Relacion" => "NRegUsu"
			),
			"Apariencia" => array(
				"PosSup" => "345px",//140px minimo Para estar dentro de DivContenido
				"PosInf" => "",
				"PosDer" => "",
				"PosIzq" => "245px",//245px minimo Para estar dentro de DivContenido
				"Alto" => "235px",
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