<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>
<body>
<center>
<br /><br /><br /><br /><br /><br />
<form id="form1" name="form1" method="post" action="">
<table width="50%" border="0" cellspacing="3" cellpadding="3">
  <tr>
    <td width="50%" align="right">Nueva Clave:</td>
    <td width="50%" align="left">
      <label for="Usu"></label>
      <input name="Usuario" type="password" class="InpTexFor" id="Usuario" onfocus="javascript:DesMenEme();" style=" width:100px;"/>
    </td>
  </tr>
  <tr>
    <td width="50%" align="right">Repita Clave:</td>
    <td width="50%" align="left"><label for="clave"></label>
      <input name="Clave" type="password" class="InpTexFor" id="Clave" onfocus="javascript:DesMenEme();" style=" width:100px;" /></td>
  </tr>
  <tr>
    <td colspan="2" align="center" id="PJS"><?php echo $_POST["Pasa"] ?></td>
    </tr>
  <tr>
    <td colspan="2" align="center"><a href="#" onclick="javascript:CamCla();">Cambiar Clave</a></td>
    </tr>
  <tr>
    <td colspan="2" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center"><a href="#" onclick="CargaPagina('modulos/mp.php', 'Menú Principal','');" >Menú Principal</a></td>
    </tr>
</table>
</form>
</center>
</body>
</html>