<?php
//date_default_timezone_set("America/Caracas");
error_reporting(0);
$VerAct = "v1.0";

$EmailAdmin = "admin@InvDefFW.com";
$TituloPagina = "WUSHU";
$Icono = "img/Yin-yan.png";
$LogoTitulo = "img/logoinicio.png";
$TextoTitulo = "<br />Federacion<br /><br />Venezolana<br /><br />de<br /><br />".$TituloPagina;

$CantidadMiniBloques = 1; //Minimo=1 - Maximo=4

//$FondoPagina = "img/fonpag.jpg";
$FondoPagina = "img/fondo9.jpg";

$TextoPie = "Federacion Venezolana de WUSHU ".$VerAct." @ 2013";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo $Icono; ?>" type="image/jpg" rel="shortcut icon">
<title><?php echo $TituloPagina; ?></title>

<script type="text/javascript" src="js/jquery-2.0.0.min.js"></script>
<script type="text/javascript" src="js/funcajax.js"></script>
<script type="text/javascript" src="js/funcvari.js"></script>

<STYLE TYPE="text/css">
	@import url(css/index.css);
	@import url(css/modulo.css);
	@import url(css/buscar.css);
	@import url(css/exportar.css);
	@import url(css/imprimir.css);
	@import url(css/formulario.css);

body {
	background-image: url(<?php echo $FondoPagina; ?>);
	font-family:Verdana, Geneva, sans-serif;
}
</STYLE>


</head>
<body onload="javascript:CargaPagina('modulos/acceso.php', 'Acceso','');" onkeypress="return event.keyCode!=13">
<center>
<div class="divBase" id="divBase">
    <div class="divTitulo" id="divTitulo">
    <table width="98%" border="0">
    	<tr>
        	<td class="tdLogo" id="tdLogo"></td>
            <td class="tdTitulo" id="tdTitulo" valign="middle"></td>
            <td class="tdUsuAct" id="tdUsuAct">
            	<table height="100%" width="100%" border="0">
                <td>                
				<?php 
					if ($_SESSION["NomUsuAct"] != ""){
						//echo "<img src='".$_SESSION["FotUsuAct"]."' />";
					} 
				?>
                </td>
                <?php 
					if ($_SESSION["NomUsuAct"] != ""){
						//echo $_SESSION["NomUsuAct"];
					} 
				?>
                <td>
                </td>
                </table>				
            </td>
        </tr>
    </table>
    </div>
    <div class="divBloques" id="divBloques">    	
        <?php if ($CantidadMiniBloques > 0){ ?>
        <div class="divMiniBloque" id="divMiniBloque1">
        	<div class="divTitMiniBloque" id="divTitMiniBloque1">Sistema</div>
        	<img src="<?php echo $LogoTitulo; ?>" height="90px" width="130px;" />
            <br />
            <p class="tdTitulo"><?php echo $TextoTitulo; ?></p>
        </div>
        <?php }?>
        <?php if ($CantidadMiniBloques > 1){ ?>
        <div class="divMiniBloque" id="divMiniBloque2">
        	<div class="divTitMiniBloque" id="divTitMiniBloque2">TituloMiniBloque2</div>
        	MiniBloque2
        </div>
        <?php }?>
        <?php if ($CantidadMiniBloques > 2){ ?>
        <div class="divMiniBloque" id="divMiniBloque3">
        	<div class="divTitMiniBloque" id="divTitMiniBloque3">TituloMiniBloque3</div>
        	MiniBloque3
        </div>
        <?php }?>
        <?php if ($CantidadMiniBloques > 3){ ?>
        <div class="divMiniBloque" id="divMiniBloque4">
        	<div class="divTitMiniBloque" id="divTitMiniBloque4">TituloMiniBloque4</div>
        	MiniBloque4
        </div>
        <?php }?>
    </div>
    <div class="divContenido" id="divContenido">
    	<div class="divTituloContenido" id="divTituloContenido"></div>
    	<div class="divDetContenido" id="divDetContenido"></div>
    </div>
    <div class="divPie" id="divPie"><?php echo $TextoPie; ?></div>
</div>
</center>
<div id="SobreTodo" class="SobreTodo"></div>
<div id="Buscar" class="Buscar">
    <div class="divTituloBuscar"><strong>Buscar</strong></div>
    <div id="ConBus" class="ConBus">
        <form id="formBus" name="formBus" method="post" action="">
            <table class="TabConBus" border="0">
            <tr>
            <td class="tdTabConBus">Campos:<br />
            <select id="BusCampos" name="BusCampos" class="SelFor" style="width:95%;" onfocus="javascript:DesMenEme();">
            </select>
            </td>
            <td class="tdTabConBus">Compracion:<br />
            <select id="BusCompa" name="BusCompa" class="SelFor" style="width:95%;" onfocus="javascript:DesMenEme();">
                <option value="">...</option>
                <option value="Semejante">Semejante</option>
                <option value="Igual">Igual</option>
                <option value="Mayor">Mayor</option>
                <option value="Menor">Menor</option>
            </select>
            </td>
            <td class="tdTabConBus" valign="middle">Valor:<br />            
            <input id="BusValor" name="BusValor" type="text"  class="InpTexFor" style="width:95%;" onfocus="javascript:DesMenEme();"/>            
            </td>
            <td class="tdTabConBus" style="text-align:center;">
            	<a href="#" onclick="javascript:AgregarFiltro();"><strong>Agregar Filtro</strong></a>
            </td>
            </tr>
            </table>            
            <table class="TabDetConBus" id="TabDetConBus">            
            </table>
            
            <input id="IDMAct" name="IDMAct" type="hidden" />
            <input id="ModAct" name="ModAct" type="hidden" />
            <input id="TitAct" name="TitAct" type="hidden" />
            <input id="UsuAct" name="UsuAct" type="hidden" />
            
            <input id="BusAcc" name="BusAcc" type="hidden" />
        </form>
    </div>
    <div class="PieBus">
        <table class="TabPieBus">
            <tr>             
                <td class="tdTabPieBus">                
                </td>	
                <td class="tdTabPieBus">
                <td class="tdTabPieBus">                
                </td>                
                </td>	
                <td class="tdTabPieBus">
                </td>
                <td class="tdTabPieBus">
                    <a href="#" onclick="javascript:DesMenEme();FinBuscar();"><strong>Cerrar</strong></a>
                </td>
            </tr>
        </table>
	</div>
</div>
<div id="Exportar" class="Exportar">
    <div class="divTituloExportar"><strong>Exportar</strong></div>
    <div id="ConExp" class="ConExp">
        <table id="TabConExp" class="TabConExp">
        	<tr>
            	<td class="tdTabConExp">                
                	<form action="exportado/ExpExc.php" method="post" target="_blank" id="ForExp">
                        <img id='imgExpExc' class='imgExpExc' src='img/Excel.png'
                        title='Exportar a Excel' alt='Exportar a Excel'
                        style="height:64px; width:64px; cursor:pointer;"
                        onmouseover='' 
                        onmouseout=''
                        onclick='javascript:document.getElementById("ForExp").submit();'
                        />
                        
						<input id="QueryExp" name="QueryExp" type="hidden" />
                        <input id="TitCamExp" name="TitCamExp" type="hidden" />
                        <input id="TituloExp" name="TituloExp" type="hidden" />
                        <input id="UsuarioExp" name="UsuarioExp" type="hidden" />                        
					</form>                    
                </td>
                <td class="tdTabConExp">&nbsp;</td>                	
                <td class="tdTabConExp">&nbsp;</td>
            </tr>
            <tr>
            	<td class="tdTabConExp">&nbsp;</td>
                <td class="tdTabConExp">&nbsp;</td>
                <td class="tdTabConExp">&nbsp;</td>
            </tr>
            <tr>
            	<td class="tdTabConExp">&nbsp;</td>
                <td class="tdTabConExp">&nbsp;</td>
                <td class="tdTabConExp">&nbsp;</td>
            </tr>
        </table>
    </div>
    <div class="PieExp">
        <table class="TabPieExp">
            <tr>             
                <td class="tdTabPieExp">
                </td>	
                <td class="tdTabPieExp">                
                </td>	
                <td class="tdTabPieExp">
                </td>
                <td class="tdTabPieExp">
                    <a href="#" onclick="javascript:FinExportar();"><strong>Cerrar</strong></a>
                </td>
            </tr>
        </table>
	</div>
</div>
<div id="Imprimir" class="Imprimir">
    <div class="divTituloImprimir"><strong>Imprimir</strong></div>
    <div id="ConImp" class="ConImp">
        <table id="TabConImp" class="TabConImp">
        	<tr>
            	<td class="tdTabConImp">                
                	<form action="impreso/ImpPDF.php" method="post" target="_blank" id="ForImp">
                        <img id='imgImpPDF' class='imgImpPDF' src='img/PDF.png'
                        title='Imprimir en PDF' alt='Imprimir en PDF'
                        style="height:64px; width:64px; cursor:pointer;"
                        onmouseover='' 
                        onmouseout=''
                        onclick='javascript:document.getElementById("ForImp").submit();'
                        />
                        
						<input id="QueryImp" name="QueryImp" type="hidden" />
                        <input id="TitCamImp" name="TitCamImp" type="hidden" />
                        <input id="TituloImp" name="TituloImp" type="hidden" />
                        <input id="UsuarioImp" name="UsuarioImp" type="hidden" />
                        
                        <input id="TipPapImp" name="TipPapImp" type="hidden" />
                        <input id="OriPapImp" name="OriPapImp" type="hidden" />
                        
                        <input id="LogoImp" name="LogoImp" type="hidden" value="<?php echo $LogoTitulo ?>" />
                        <input id="TitImp" name="TitImp" type="hidden" value="<?php echo $TextoTitulo ?>" />                        
                        <input id="LisAncCol" name="LisAncCol" type="hidden" />                        
					</form>
                    
                </td>
                <td class="tdTabConImp">&nbsp;</td>                	
                <td class="tdTabConImp">&nbsp;</td>
            </tr>
            <tr>
            	<td class="tdTabConImp">&nbsp;</td>
                <td class="tdTabConImp">&nbsp;</td>
                <td class="tdTabConImp">&nbsp;</td>
            </tr>
            <tr>
            	<td class="tdTabConImp">&nbsp;</td>
                <td class="tdTabConImp">&nbsp;</td>
                <td class="tdTabConImp">&nbsp;</td>
            </tr>
        </table>
    </div>
    <div class="PieImp">
        <table class="TabPieImp">
            <tr>             
                <td class="tdTabPieImp">
                </td>	
                <td class="tdTabPieImp">                
                </td>	
                <td class="tdTabPieImp">
                </td>
                <td class="tdTabPieImp">
                    <a href="#" onclick="javascript:FinImprimir();"><strong>Cerrar</strong></a>
                </td>
            </tr>
        </table>
	</div>
</div>
<div id="BuscarSec" class="Buscar">
    <div class="divTituloBuscar"><strong>Buscar Sectores</strong></div>
    <div id="ConBusSec" class="ConBus">
        <form id="formBusSec" name="formBusSec" method="post" action="">
            <table class="TabConBus">
            <tr>
            <td class="tdTabConBus">Sector:<br />            
            <input id="BusValorSec" name="BusValorSec" type="text"  class="InpTexFor" style="width:99%;" onfocus="javascript:DesMenEme();" onkeyup="javascript:
            						var LonTex = document.getElementById('BusValorSec').value;
            						if(LonTex.length > 4){CargaBuscarSec('Hacer=Consulta');}"/>
            </td>            
            </tr>
            </table>            
            <table class="TabDetConBus" id="TabDetConBusSec">            
            </table>
            
            <input id="IDMAct" name="IDMAct" type="hidden" />
            <input id="ModAct" name="ModAct" type="hidden" />
            <input id="TitAct" name="TitAct" type="hidden" />
            <input id="UsuAct" name="UsuAct" type="hidden" />
            
            <input id="BusAcc" name="BusAcc" type="hidden" />
        </form>
    </div>
    <div class="PieBus">
        <table class="TabPieBus">
            <tr>             
                <td class="tdTabPieBus">                
                </td>
                <td class="tdTabPieBus">                
                </td>
                <td class="tdTabPieBus">                
                </td>	
                <td class="tdTabPieBus">
                </td>
                <td class="tdTabPieBus">
                    <a href="#" onclick="javascript:DesMenEme();FinBuscarSec();"><strong>Cerrar</strong></a>
                </td>
            </tr>
        </table>
	</div>
</div>

<div id="BuscarRep" class="Buscar">
    <div class="divTituloBuscar"><strong>Buscar Repetidas</strong></div>
    <div id="ConBusRep" class="ConBus">
        <form id="formBusRep" name="formBusRep" method="post" action="">
            <table class="TabConBus">
            <tr>
            <td class="tdTabConBus">Descripcion:<br />            
            <input id="BusValorRep" name="BusValorRep" type="text"  class="InpTexFor" style="width:99%;" onfocus="javascript:DesMenEme();" onkeyup="javascript:
            						var LonTex = document.getElementById('BusValorRep').value;
            						if(LonTex.length > 3){CargaBuscarRep('Hacer=Consulta');}" />
            </td>            
            </tr>
            </table>            
            <table class="TabDetConBus" id="TabDetConBusRep">            
            </table>
            
            <input id="IDMAct" name="IDMAct" type="hidden" />
            <input id="ModAct" name="ModAct" type="hidden" />
            <input id="TitAct" name="TitAct" type="hidden" />
            <input id="UsuAct" name="UsuAct" type="hidden" />
            
            <input id="BusAcc" name="BusAcc" type="hidden" />
        </form>
    </div>
    <div class="PieBus">
        <table class="TabPieBus">
            <tr>             
                <td class="tdTabPieBus">                
                </td>
                <td class="tdTabPieBus">                
                </td>	
                <td class="tdTabPieBus">                
                </td>	
                <td class="tdTabPieBus">
                </td>
                <td class="tdTabPieBus">
                    <a href="#" onclick="javascript:DesMenEme();FinBuscarRep();"><strong>Cerrar</strong></a>
                </td>
            </tr>
        </table>
	</div>
</div>
<div class="divME" id="divME">Aqui va un mensaje Doble de <br /> Varias Lineas</div>
</body>
</html>
<form id="formIndex" name="formIndex" method="post" action="">
<input id="ImpIP" name="ImpIP" type="hidden" />
</form>