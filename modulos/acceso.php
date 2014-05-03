<?php
error_reporting(0);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Documento sin título</title>
        <script type="text/javascript" src="js/jquery-1.11.0.js"></script>
        <script type="text/javascript" src="../js/funcajax.js"></script>
        <script type="text/javascript" src="../js/funcvari.js"></script>
        <script type="text/javascript" src="../script/login.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                alert('ddfsfs');
            })
        </script>
    </head>
    <body>
    <center>
        
        <br /><br /><br /><br /><br /><br />
        <form id="form1" name="form1" method="post" action="">
            <table width="50%" border="0" cellspacing="3" cellpadding="3">
                <tr>
                    <td width="50%" align="right">Usuario:</td>
                    <td width="50%" align="left">
                        <label for="Usu"></label>
                        <input name="Usuario" type="text" class="InpTexFor" id="Usuario" onfocus="javascript:DesMenEme();" style=" width:100px;"/>
                    </td>
                </tr>
                <tr>
                    <td width="50%" align="right">Clave:</td>
                    <td width="50%" align="left"><label for="clave"></label>
                        <input name="Clave" type="password" class="InpTexFor" id="Clave" onfocus="javascript:DesMenEme();" style=" width:100px;" /></td>
                </tr>
                <tr>
                    <td colspan="2" align="center" id="PJS"><?php echo $_POST["Pasa"] ?></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><a href="#" onclick="javascript:Ingresar();">Ingresar</a></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><a href="mailto:admin@wushu.com.ve" target="_blank">Olvido su Clave?</a></td>
                </tr>
            </table>
        </form>
    </center>
</body>
</html>