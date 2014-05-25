<?php
require_once '../modelo/Conexion.php';
$obj_conexion = new Conexion();

$sql        = "SELECT  id_asociacion, nombre FROM asociaciones";
$nivel      = "SELECT  id_nivel,  nivel FROM nivel_academico";
$tip_sangre = "SELECT  id_tipo,  tipo_sangre FROM tipo_sangre";

$resultado = $obj_conexion->RetornarRegistros($sql);
$result    = $obj_conexion->RetornarRegistros($nivel);
$resul     = $obj_conexion->RetornarRegistros($tip_sangre);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>WUSHU</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../css/bootstrap.css" rel="stylesheet" media="screen"/>
        <link href="../css/estilos.css" rel="stylesheet" media="screen"/>
        <link href="../css/jquery.dataTables.css" rel="stylesheet" media="screen"/>
        <link href="../css/datepicker.css" rel="stylesheet" media="screen"/>         

        <script type="text/javascript" src="../js/jquery-1.11.0.js"></script>
        <script type="text/javascript" src="../js/validarcampos.js"></script>
        <script type="text/javascript" src="../js/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="../js/bootstrap-datepicker.es.js"></script>      
        <script type="text/javascript" src="../js/tab.js"></script>
        <script type="text/javascript" src="../js/jquery.dataTables.js"></script>
        <style type="text/css">
            body{
                background-color: transparent;
            }
        </style>
        <script type="text/javascript">
            $(document).ready(function() {

                var TAatletas = $('#tbl_atletas').dataTable({
                    "iDisplayLength": 5,
                    "iDisplayStart": 0,
                    // "aLengthMenu": [5, 10, 20, 30, 40, 50],00
                    "bLengthChange": false,
                    "oLanguage": {"sUrl": "../js/es.txt"},
                    "aoColumns": [
                        {"sClass": "right", "sWidth": "4%"},
                        {"sClass": "center", "sWidth": "30%"},
                        {"sWidth": "10%"},
                        {"sWidth": "8%"},
                        {"sWidth": "15%"},
                        {"sWidth": "8%"},
                        {"sClass": "center", "sWidth": "18%", "bSortable": false, "bSearchable": false}
                    ]
                });
                
                var numero = '0123456789-ve';
                $('#cedula,#rif, #pasaporte').validar(numero);
                
                var letra = ' abcdefghijklmnñopqrstuvwxyzáéíóú';
                $('#nombre, #padre, #madre').validar(letra);   
                
                var numero = '0123456789-';
                $('#telefono,#tel_madre, #tel_padre').validar(numero);
                
                var letra = ' abcdefghijklmnñopqrstuvwxyzáéíóú';
                $('#ocupacion, #patologias, #alergias').validar(letra);
                
                  var numero = '0123456789kg';
                 $('#peso').validar(numero);
                 
                 var numero = '0123456789mlsxgp';
                $('#tal_zap, #tal_pan, #tal_cam, #tal_pet').validar(numero);

//               var letra = ' abcdefghijklmnñopqrstuvwxyzáéíóú';
//                $('#padre').validar(letra);

                /****Calendario*****/
                $('#fechnac').datepicker({
                    language: "es",
                    format: 'dd/mm/yyyy',
                    startDate: "-75y",
                    endDate: "-15y",
                    autoclose: true
                });

                $('#ingresar').click(function() {

                    var accion = $(this).text();
                    $('#accion').val(accion)
                    $('#cedula').prop('disabled', false);
                    if (accion == 'Registrar') {
                        $.post("../controlador/atletas.php", $("#frmatletas").serialize(), function(resultado) {
                            if (resultado == 'exito') {
                                alert('Registro con exito');
                                $('input:text').val();
                                $('input:radio').prop('ckecked', true);
                                var sexo = $('input:radio[name="sexo"]:checked').val();
                                var aso = $('#asociacion').find('option:selected').text();
                                var modificar = '<span class="accion modificar">Modificar</span>';
                                var eliminar = '<span class="accion eliminar">Eliminar</span>';
                                var accion = modificar + '&nbsp;' + eliminar
                                TAatletas.fnAddData([$('#cedula').val(), $('#nombre').val(), $('#fechnac').val(), sexo, aso, $('#peso').val(), accion]);
                                $('input:text').val('');
                                $('textarea').val('');
                                $('select').val('0');

                            } else if (resultado == 'existe') {
                                alert('El Atleta ya esta registrado');
                                $('#d_cedula').addClass('has-error');
                                $('#cedula').focus();
                            }
                        });
                    } else {
                        var r = confirm("\u00BFDesea Modificar el Registro?");
                        var fila = $("#fila").val();
                        if (r == true) {
                            var sexo = $('input:radio[name="sexo"]:checked').val();
                            var aso = $('#asociacion').find('option:selected').text();
                            $.post("../controlador/atletas.php", $("#frmatletas").serialize(), function(resultado) {
                                if (resultado == 'exito') {
                                    alert('Modificaci\u00f3n  con exito');

//                                    $("#tbl_atletas tbody tr:eq(" + fila + ")").find("td").eq(2).html($('#fechnac').val());
                                    $("#tbl_atletas tbody tr:eq(" + fila + ")").find("td").eq(3).html(sexo);
                                    $("#tbl_atletas tbody tr:eq(" + fila + ")").find("td").eq(4).html(aso);
                                    $("#tbl_atletas tbody tr:eq(" + fila + ")").find("td").eq(5).html($('#peso').val());
                                    $('input:text').val('');
                                    $('textarea').val('');
                                    $('select').val('0');
                                    $('#ingresar').text('Registrar');
                                }
                            });
                        }
                    }
                });

                $('table#tbl_atletas').on('click', '.modificar', function() {

                    $('#fila').remove();
                    var padre = $(this).closest('tr');
                    var cedula = padre.find('td').eq(0).text();
                    var nombre = padre.find('td').eq(1).text();
                    var fechnac = padre.find('td').eq(2).text();
                    var sexo = padre.find('td').eq(3).text();
                    var peso = padre.find('td').eq(5).text();

                    // obtener la fila a modificar
                    var fila = padre.index();

                    // crear el campo fila y añadir la fila
                    var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
                    $($fila).prependTo($('#frmatletas'));

                    $('#ingresar').text('Modificar');

                    $('#cedula').val(cedula).prop('disabled', true);
                    $('#nombre').val(nombre);
                    $('#fechnac').val(fechnac);
                    $('#peso').val(peso);
                    $('input:radio[name="sexo"][value="' + sexo + '"]').prop('checked', true);

                    $.post("../controlador/atletas.php", {cedula: cedula, accion: 'BuscarDatos'}, function(resultado) {
                        var datos = resultado.split(";");
                        $('#rif').val(datos[0]);
                        $('#pasaporte').val(datos[1]);
                        $('#telefono').val(datos[2]);
                        $('#email').val(datos[3]);
                        $('#direccion').val(datos[4]);
                        $('#nivel_academico').val(datos[5]);
                        $('#ocupacion').val(datos[6]);
                        $('#asociacion').val(datos[7]);
                        $('input:radio[name="estatus"][value="' + datos[8] + '"]').prop('checked', true);
                        $('#patologias').val(datos[9]);
                        $('#alergias').val(datos[10]);
                        $('#tipo_sangre').val(datos[11]);
                        $('#tal_zap').val(datos[12]);
                        $('#tal_pan').val(datos[13]);
                        $('#tal_cam').val(datos[14]);
                        $('#tal_pet').val(datos[15]);
                        $('#padre').val(datos[16]);
                        $('#tel_padre').val(datos[17]);
                        $('#madre').val(datos[18]);
                        $('#tel_madre').val(datos[19]);
                        
                    });
                });

                $('#limpiar').click(function() {
                    $('#cedula').prop('disabled', false);
                    $('input:text').val('');
                    $('textarea').val('');
                    $('select').val('0');
                    $('#ingresar').text('Guardar');
                });

            });
        </script>
    </head>
    <body>
        <div style="margin-top: 4%; position: relative;display: block">
            <form id="frmatletas">
                <table width="912" border="0" align="center">
                    <tr>
                        <td height="59" colspan="4" align="center">
                            <fieldset>
                                <legend style="margin-top: -50px;"> 
                                    <span style="margin-left: -550px;
                                          color: #333333;
                                          font-family: Helvetica,Arial,sans-serif;
                                          font-size: 16px; ">  Datos Personales </span> 
                                </legend>
                            </fieldset>
                        </td>
                    </tr>

                    <tr>
                        <td width="106">C&eacute;dula :</td>
                        <td width="337">
                            <div  id="d_cedula" class="form-group">
                                <input type="text" class="form-control" id="cedula" name="cedula" value="" maxlength="10"/>
                            </div>
                        </td>
                        <td width="119">&nbsp;&nbsp;&nbsp;Rif :</td>
                        <td width="332">
                            <div class="form-group">
                                <input type="text" class="form-control" id="rif" name="rif" value="" maxlength="12"/>
                            </div>
                        </td>
                    </tr>

                    <tr>                        
                        <td width="106">Pasaporte:</td>
                        <td width="337">
                            <div  class="form-group">
                                <input type="text" class="form-control" id="pasaporte" name="pasaporte" value="" maxlength="10"/>
                            </div>
                        </td>
                        <td width="119">&nbsp;&nbsp;&nbsp;Nombres:</td>
                        <td width="332">
                            <div  class="form-group">
                                <input type="text" class="form-control" id="nombre" name="nombre" value="" />
                            </div>
                        </td>
                    </tr>

                    <tr>                        
                        <td width="106">FechaNac :</td>
                        <td width="337">
                            <div class="form-group">
                                <input type="text" style="background-color: #ffffff" readonly class="form-control" id="fechnac" name="fechnac" value="" />
                            </div>
                        </td>
                        <td width="119">&nbsp;&nbsp;&nbsp;Sexo :</td>
                        <td>
                            <div class="form-group">
                                <input type="radio" name="sexo" value="Masculino"   id="sexo" checked="checked" />Masculino
                                <input type="radio" name="sexo" value="Femenino" id="sexo" />Femenino
                            </div>
                        </td>
                    </tr> 

                    <tr>
                        <td height="59" colspan="4" align="center">
                            <fieldset>
                                <legend style="margin-top: -10px;"> 
                                    <span style="margin-left: -550px;
                                          color: #333333;
                                          font-family: Helvetica,Arial,sans-serif;
                                          font-size: 16px; ">  Otros Datos</span> 
                                </legend>
                            </fieldset>
                        </td>
                    </tr>

                    <tr>
                        <td height="59" colspan="4" align="center">
                            <table width="706">
                                <ul class="nav nav-tabs" style="width: 707px; margin-left: 20px;">
                                    <li class="active">
                                        <a href="#direccion" data-toggle="tab">Direcci&oacute;n, Nivel Instrucci&oacute;n</a>
                                    </li>
                                    <li>
                                        <a href="#mision" data-toggle="tab">Salud</a>
                                    </li>
                                    <li>
                                        <a href="#vivienda" data-toggle="tab">Tallas</a>
                                    </li>
                                    <li>
                                        <a href="#diversidad" data-toggle="tab">Padre, Madre</a>
                                    </li>
                                </ul>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td height="100" colspan="4" >
                            <div class="tab-content">
                                <div class="tab-pane active" id="direccion" style="margin-top: 30px;">
                                    <table width="912" border="0" align="center">
                                        <tr>
                         <td width="106">Tel&eacute;fono:</td>
                        <td width="337">
                            <div class="form-group">
                                <input type="text" class="form-control" id="telefono" name="telefono" value="" maxlength="12"/>
                            </div>
                        </td>
                                            <td width="119">&nbsp;&nbsp;&nbsp;Email:</td>
                                            <td>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="email" name="email" value="" />
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td height="68">Direcci&oacute;n</td>
                                            <td>
                                                <div class="form-group">
                                                    <textarea style="resize: none !important; height: 60px; width: 240%;" name="direccion" rows="2"  class="form-control"  id="direccion"></textarea>
                                                </div>
                                            </td>                                            
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td height="59" colspan="4" align="center">
                                                <fieldset>
                                                    <legend style="margin-top: -10px;"> 
                                                        <span style="margin-left: -550px;
                                                              color: #333333;
                                                              font-family: Helvetica,Arial,sans-serif;
                                                              font-size: 14px; ">Nivel Instrucci&oacute;n</span> 
                                                    </legend>
                                                </fieldset>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="106">N. Academico:</td>
                                            <td width="337">
                                                <div class="form-group">
                                                    <select name="nivel_academico" class="form-control" id="nivel_academico">
                                                        <option value="0">Seleccione</option>
                                                        <?php
                                                        for ($i = 0; $i < count($result); $i++) {
                                                            ?>
                                                            <option value="<?php echo $result[$i]['id_nivel']; ?>"><?php echo $result[$i]['nivel']; ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </td>
                                            <td>Ocupaci&oacute;n:</td>
                                            <td>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="ocupacion" name="ocupacion" value="" />
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td width="106">Asociaci&oacute;n :</td>
                                            <td>
                                                <div class="form-group">
                                                    <select name="asociacion" class="form-control" id="asociacion">
                                                        <option value="0">Seleccione</option>
                                                        <?php
                                                        for ($i = 0; $i < count($resultado); $i++) {
                                                            ?>
                                                            <option value="<?php echo $resultado[$i]['id_asociacion'] ?>"><?php echo $resultado[$i]['nombre'] ?></option>
                                                            <?php
                                                        }
                                                        ?>

                                                    </select>
                                                </div>
                                            </td>   
                                            <td height="45">Estatus:</td>
                                            <td>
                                                <div class="form-group">
                                                    <input type="radio" name="estatus" value="activo"   id="estatus" checked="checked" />Activo
                                                    <input type="radio" name="estatus" value="inactivo" id="estatus" />Inactivo
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                        </tr>
                                    </table>                                  
                                </div> 

                                <div class="tab-pane" id="mision" style="margin-top: 30px;">
                                    <table width="912" border="0" align="center">
                                        <tr>
                                            <td width="106">Patolog&iacute;as:</td>
                                            <td width="337">
                                                <div class="form-group">
                                                    <textarea style="resize: none !important; height: 50px; width: 100%" name="patologias" rows="2"  class="form-control"  id="patologias"></textarea>
                                                </div>
                                            </td>
                                            <td width="106">Alergias:</td>
                                            <td>
                                                <div class="form-group">
                                                    <textarea style="resize: none !important; height: 50px; width: 100%" name="alergias" rows="2"  class="form-control"  id="alergias"></textarea>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td width="106">Tipo de Sangre:</td>
                                            <td width="337">
                                                <div class="form-group">
                                                    <select name="tipo_sangre" class="form-control" id="tipo_sangre">
                                                        <option value="0">Seleccione</option>
                                                        <?php
                                                        for ($i = 0; $i < count($resul); $i++) {
                                                            ?>
                                                            <option value="<?php echo $resul[$i]['id_tipo']; ?>"><?php echo $resul[$i]['tipo_sangre']; ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </td>
                                            <td width="106">Peso:</td>
                                            <td>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="peso" name="peso" value="" maxlength="5"/>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                        </tr>
                                    </table> 
                                </div>
                                
                                <div class="tab-pane" id="vivienda" style="margin-top: 30px;">
                                    <table width="912" border="0" align="center">
                                        <tr>
                                            <td width="106">Talla Zapato:</td>
                                            <td width="337">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="tal_zap" name="tal_zap" value="" maxlength="2"/>
                                                </div>
                                            </td>
                                            <td width="106">Talla Pantal&oacute;n:</td>
                                            <td>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="tal_pan" name="tal_pan" value="" maxlength="3"/>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td width="106">Talla Camisa:</td>
                                            <td>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="tal_cam" name="tal_cam" value="" maxlength="3"/>
                                                </div>
                                            </td>
                                            <td width="106">Talla Peto:</td>
                                            <td width="337">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="tal_pet" name="tal_pet" value="" maxlength="3"/>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                        </tr>
                                    </table> 
                                </div>
                                
                                <div class="tab-pane" id="diversidad" style="margin-top: 30px;">
                                    <table width="912" border="0" align="center">
                                        <tr>
                                            <td width="106">Padre:</td>
                                            <td>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="padre" name="padre" value="" />
                                                </div>
                                            </td>
                                            <td width="106">Telf. Padre:</td>
                                            <td>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="tel_padre" name="tel_padre" value="" maxlength="12"/>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td width="106">Madre:</td>
                                            <td width="337">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="madre" name="madre" value="" />
                                                </div>
                                            </td>
                                            <td width="106">Telf. Madre:</td>
                                            <td width="337">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="tel_madre" name="tel_madre" value="" maxlength="12"/>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                        </tr>
                                    </table> 
                                </div>

                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="4" align="center">
                            <input type="hidden" id="accion" name="accion" value=""/>
                            <button type="button" id="ingresar" class="btn btn-info">Registrar</button>
                            <button type="button" id="limpiar" class="btn btn-info">Limpiar</button>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="4" align="center">
                            <table border="0" id="tbl_atletas" class="dataTable">
                                <thead>
                                    <tr>
                                        <th>Cedula</th>
                                        <th>Nombre</th>
                                        <th>FecNac</th>
                                        <th>Sexo</th>
                                        <th>Asociacion</th>
                                        <th>Peso</th>
                                        <th>Acci&oacute;n</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql        = "SELECT CONCAT_WS('-', atl.nacionalidad, atl.cedula) AS cedula, 
                                                                    atl.nombre, 
                                                                    DATE_FORMAT(atl.fechnac,'%d/%m/%Y') AS fecha,
                                                                    atl.sexo,
                                                                    aso.nombre AS asociacion,
                                                                    atl.peso 
                                                            FROM atletas atl
                                                            INNER JOIN asociaciones  aso ON atl.id_asociacion = aso.id_asociacion;";
                                    $resgistros = $obj_conexion->RetornarRegistros($sql);

                                    $es_array = is_array($resgistros) ? TRUE : FALSE;
                                    if ($es_array == TRUE) {
                                        for ($i = 0; $i < count($resgistros); $i++) {
                                            ?>
                                            <tr>
                                                <td align="right"><?php echo $resgistros[$i]['cedula'] ?></td>
                                                <td><?php echo $resgistros[$i]['nombre'] ?></td>
                                                <td><?php echo $resgistros[$i]['fecha'] ?></td>
                                                <td><?php echo $resgistros[$i]['sexo'] ?></td>
                                                <td><?php echo $resgistros[$i]['asociacion'] ?></td>
                                                <td><?php echo $resgistros[$i]['peso'] ?></td>
                                                <td>
                                                    <span class="accion modificar">Modificar</span>
                                                           <span class="accion eliminar">Eliminar</span>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" align="center">&nbsp;</td>
                        </tr>
                    </table>
                </form>
            </div>
        </body>
    </html>
