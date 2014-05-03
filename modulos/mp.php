
<?php 
session_start();
include("bd.php"); 
?>
<!DOCTYPE html >
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>
<body>
<?php
$result = $link->query("SELECT * 
						FROM maestro 
						WHERE Estatus='ACTIVO'
							AND NRegMae=2 
							AND NRegistro IN (SELECT NRegMen 
												FROM acceso 
												WHERE Estatus='ACTIVO'
													AND NRegPer IN (SELECT NRegPer 
																	FROM detusuario 
																	WHERE Estatus='ACTIVO'
																		AND NRegUsu = ".$_SESSION["CodUsuAct"]."))
						ORDER BY Des4");
$NFilas = $result->num_rows;
for ($TabQRY = array();$tmp = $result->fetch_array(MYSQLI_BOTH);){$TabQRY[] = $tmp;}
for ($n = 0; $n <= (count($TabQRY) -1); $n++){
  $CCA = $CCA."<td class='thTabMen' width='".(100/$NFilas)."%'>".$TabQRY[$n]["Nombre"]."</td>";	  
  if ($n < ($NFilas-1)){$CCA = $CCA."<th>&nbsp;</th>";}	  
  $CCB = $CCB."<td class='tdTabMen' width='".(100/$NFilas)."%' align='center' valign='top'>";	  
  $result2 = $link->query("SELECT * 
  							FROM maestro 
							WHERE Estatus='ACTIVO' 
								AND NRegMae=".$TabQRY[$n]["NRegistro"]."
								AND NRegistro IN (SELECT NRegMen 
												FROM acceso 
												WHERE Estatus='ACTIVO'
													AND NRegPer IN (SELECT NRegPer 
																	FROM detusuario 
																	WHERE Estatus='ACTIVO'
																		AND NRegUsu = ".$_SESSION["CodUsuAct"]."))
						
							ORDER BY Des4");
  $NItem = $result2->num_rows;
  for ($TabQRY2 = array(); $tmp2 = $result2->fetch_array(MYSQLI_BOTH);){$TabQRY2[] = $tmp2;}	  
  for ($n2 = 0; $n2 <= ($NItem-1); $n2++){
	$CCB = $CCB."<br>	
	<a href='#' onclick='CargaPagina(\"modulos/".$TabQRY2[$n2]["Des2"]."\", \"".$TabQRY2[$n2]["Des3"]."\",\"idm=".$TabQRY2[$n2]["NRegistro"]."&mod=".$TabQRY2[$n2]["Des2"]."&tit=".$TabQRY2[$n2]["Des3"]."\")' style='color:#4185b0;'>
	<img src='img/cog.png' align='absmiddle' width='16px' height=16px border='0' /> 
	".$TabQRY2[$n2]["Nombre"]."
	</a>
	<br>";
  }
  $CCB = $CCB."</td>";
  if ($n < ($NFilas-1)){$CCB = $CCB."<td>&nbsp;</td>";}
}
echo "<br />";
echo "<table class='TabMen' border='0'>";
  echo "<tr>";
	echo $CCA;
  echo "</tr>";
  echo "<tr>";
	echo $CCB;
  echo "</tr>";
echo "</table>";
?>

<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p><a href="#" onclick="Logout('<?php echo $_SESSION["CodUsuAct"]; ?>','<?php echo $_SESSION["NomUsuAct"]; ?>');CargaPagina('modulos/acceso.php', 'Acceso','');" class="LnkSalir">Salir</a></p>
</body>
</html>