<?php
session_start();
include("bd.php");

if ($_POST["Hacer"] == "Consulta"){
}elseif ($_POST["Hacer"] == "Agregar"){
	$result = $link->query("INSERT INTO buscar (NRegUsu,Modulo,Campo,Compa,Valor) VALUES(".$_SESSION["CodUsuAct"].",'".$_SESSION["BuscarMod"]."','".$_POST["Cam"]."','".$_POST["Com"]."','".$_POST["Val"]."')");
}elseif ($_POST["Hacer"] == "Eliminar"){
	$result = $link->query("DELETE FROM buscar WHERE NRegistro = ".$_POST["ID"]);
}elseif ($_POST["Hacer"] == "EliminarTodo"){
	$result = $link->query("DELETE FROM buscar WHERE NRegUsu = ".$_SESSION["CodUsuAct"]." AND Modulo = '".$_SESSION["BuscarMod"]."'");
}

echo "<tr bgcolor='#DDDDDD'>
	<th class='thTabDetConBus'>Accion</th>
	<th class='thTabDetConBus'>Campo</th>
	<th class='thTabDetConBus'>Comparacion</th>
	<th class='thTabDetConBus'>Valor</th>
	</tr>";
$result = $link->query("SELECT * FROM buscar WHERE NRegUsu = ".$_SESSION["CodUsuAct"]." AND Modulo = '".$_SESSION["BuscarMod"]."'");

$NFilas = $result->num_rows;
if ($NFilas > 0){
	for ($BusQRY = array(); $tmp = $result->fetch_array(MYSQLI_BOTH);){$BusQRY[] = $tmp;}
	
	$trPF = "#FFFFFF";//Color tr Primera Fila
	$trSF = "#EEEEEE";//Color tr Segunda Fila
	
	for ($n = 0; $n <= ($NFilas - 1); $n++){
		if ($Par != $trPF){$Par = $trPF;}else{$Par = $trSF;}
		echo "<tr bgcolor='".$Par."'>";
		echo "<td class='tdTabDetConBus'>
			<a href='#' onclick='javascript:CargaBuscar(\"Hacer=Eliminar&ID=".$BusQRY[$n]["NRegistro"]."\");'><strong>Eliminar Filtro</strong></a>
			</td>";
		echo "<td class='tdTabDetConBus'>";
			$NomCam = split(",",$_SESSION["BuscarNomCam"]);
			$TitCam = split(",",$_SESSION["BuscarTitCam"]);
			for ($nC = 0; $nC <= (count($NomCam)-1); $nC++){
				if ($BusQRY[$n]["Campo"] == $NomCam[$nC]){echo $TitCam[$nC];}
			}
		echo "</td>";
		echo "<td class='tdTabDetConBus'>".$BusQRY[$n]["Compa"]."</td>";
		echo "<td class='tdTabDetConBus'>".$BusQRY[$n]["Valor"]."</td>";
		echo "</tr>";
	}		
}else{
	echo "<tr bgcolor='#FFFFFF'>";
		echo "<td class='tdTabDetConBus' colspan='4' style='color:#F00'>";
		echo "<strong>No existen registros</strong>";
		echo "</td>";
	echo "</tr>";
}
$link->close;
?>