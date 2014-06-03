<?php
session_start();
require_once '../modelo/Conexion.php';
$obj_conexion = new Conexion();

$datos     = "SELECT cedula, CONCAT_WS('-', nacionalidad, cedula, nombre )AS datos FROM atletas ";
$categoria = "SELECT  num_registro,  descripcion FROM categorias ";
$modalidad = "SELECT  num_registro,  descripcion FROM modalidades";
$estilo    = "SELECT  id_estilo,  nombre_estilo FROM estilo";
$region    = "SELECT  id_region,  nombre_region FROM region ";
$evento    = "SELECT  id_estatus,  estatus_evento FROM estatus_evento";

$d_resul   = $obj_conexion->RetornarRegistros($datos);
$resultec  = $obj_conexion->RetornarRegistros($categoria);
$resultado = $obj_conexion->RetornarRegistros($modalidad);
$result    = $obj_conexion->RetornarRegistros($estilo);
$resul     = $obj_conexion->RetornarRegistros($region);
$res       = $obj_conexion->RetornarRegistros($evento);

$archivo_actual = basename($_SERVER['PHP_SELF']);
$_SESSION['archivo'] =  $archivo_actual;
$_SESSION['titulo'] = 'Agregar Registros de INSCRIPCION';
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
        <link href="../css/maquetacion.css" rel="stylesheet" media="screen"/>

        <script type="text/javascript" src="../js/jquery-1.11.0.js"></script>
        <script type="text/javascript" src="../js/validarcampos.js"></script>               
        <script type="text/javascript" src="../js/jquery.dataTables.js"></script>

        <style type="text/css">
            body{
                background-color: transparent;
            }
        </style>
        <script type="text/javascript">
            $(document).ready(function() {

                var TAcategorias = $('#tbl_categoria').dataTable({
                    "iDisplayLength": 5,
                    "iDisplayStart": 0,
                    "aLengthMenu": [5, 10, 20, 30, 40, 50],
                    "oLanguage": {"sUrl": "../js/es.txt"},
                    "aoColumns": [
                        {"sClass": "center", "sWidth": "4%"},
                        {"sClass": "center", "sWidth": "30%"},
                        {"sWidth": "15%"},
                        {"sWidth": "15%"},
                        {"sWidth": "15%"},
                        {"sClass": "center", "sWidth": "18%", "bSortable": false, "bSearchable": false}
                    ]
                });

//                var letra = ' abcdefghijklmnñopqrstuvwxyzáéíóú';
//                $('#descripcion').validar(letra);

                var numero = '0123456789-';
                $('#edad').validar(numero);

                $('#cedula').change(function() {
                    var cedula = $(this).val();
                    if (cedula != 0) {
                        $.post("../controlador/inscripcion.php", {cedula: cedula, accion: 'Buscar'}, function(respuesta) {
                            if (respuesta != 0) {
                                var datos = respuesta.split(';');
                                $('#nombre').val(datos[0]);
                                $('#edad').val(datos[1]);
                                $('#sexo').val(datos[2]);
                                $('#peso').val(datos[3]);
                            } else {

                            }
                        });
                    }
                });

                $('#ingresar').click(function() {

                    var accion = $(this).text();
                    $('#accion').val(accion)
                    $('#descripcion').prop('disabled', false);
                    if (accion == 'Registrar') {
                        $.post("../controlador/categorias.php", $("#frmcategorias").serialize(), function(resultado) {
                            if (resultado == 'exito') {
                                alert('Registro con exito');
                                $('input:text').val();
                                $('input:radio').prop('ckecked', true);

                                var sexo = $('input:radio[name="sexo"]:checked').val();
                                var estilo = $('#estilo').find('option:selected').text();
                                var region = $('#region').find('option:selected').text();

                                var modificar = '<span class="accion modificar">Modificar</span>';
                                var eliminar = '<span class="accion eliminar">Eliminar</span>';
                                var accion = modificar + '&nbsp;' + eliminar
                                TAcategorias.fnAddData([$('#descripcion').val(), $('#edad').val(), sexo, estilo, region, accion]);
                                $('input:text').val('');
                                $('textarea').val('');
                                $('select').val('0');

                            } else if (resultado == 'existe') {
                                alert('El Nombre de la Categoria ya esta registrado');
                                $('#d_descripcion').addClass('has-error');
                                $('#descripcion').focus();
                            }
                        });
                    } else {
                        var r = confirm("\u00BFDesea Modificar el Registro?");
                        var fila = $("#fila").val();
                        if (r == true) {
                            var sexo = $('input:radio[name="sexo"]:checked').val();
                            var estilo = $('#estilo').find('option:selected').text();
                            var region = $('#region').find('option:selected').text();

                            $.post("../controlador/categorias.php", $("#frmcategorias").serialize(), function(resultado) {
                                if (resultado == 'exito') {
                                    alert('Modificaci\u00f3n  con exito');

                                    $("#tbl_categoria tbody tr:eq(" + fila + ")").find("td").eq(0).html($('#descripcion').val());
                                    $("#tbl_categoria tbody tr:eq(" + fila + ")").find("td").eq(1).html($('#edad').val());
                                    $("#tbl_categoria tbody tr:eq(" + fila + ")").find("td").eq(2).html(sexo);
                                    $("#tbl_categoria tbody tr:eq(" + fila + ")").find("td").eq(3).html(estilo);
                                    $("#tbl_categoria tbody tr:eq(" + fila + ")").find("td").eq(4).html(region);

                                    $('input:text').val('');
                                    $('textarea').val('');
                                    $('select').val('0');
                                    $('#ingresar').text('Registrar');
                                }
                            });
                        }
                    }
                });

                $('table#tbl_categoria').on('click', '.modificar', function() {

                    $('#fila').remove();
                    var padre = $(this).closest('tr');
                    var descripcion = padre.find('td').eq(0).text();
                    var edad = padre.find('td').eq(1).text();
                    var sexo = padre.find('td').eq(2).text();
                    var estilo = padre.find('td').eq(3).text();
                    var region = padre.find('td').eq(4).text();

                    // obtener la fila a modificar
                    var fila = padre.index();
                    // crear el campo fila y añadir la fila
                    var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
                    $($fila).prependTo($('#frmcategorias'));

                    $('#ingresar').text('Modificar');

                    $('#descripcion').val(descripcion).prop('disabled', true);
                    $('#edad').val(edad);
                    $('input:radio[name="sexo"][value="' + sexo + '"]').prop('checked', true);
                    $('#estilo').val(estilo);
                    $('#region').val(region);


                    $.post("../controlador/categorias.php", {descripcion: descripcion, accion: 'BuscarDatos'}, function(resultado) {
                        var datos = resultado.split(";");
                        $('#edad').val(datos[0]);
                        $('#modalidad').val(datos[1]);
                        $('#estilo').val(datos[2]);
                        $('#region').val(datos[3]);
                        $('#tecnica').val(datos[4]);
                        $('input:radio[name="estatus"][value="' + datos[5] + '"]').prop('checked', true);
                    });
                });

                $('#limpiar').click(function() {
                    $('#descripcion').prop('disabled', false);
                    $('input:text').val('');
                    $('textarea').val('');
                    $('select').val('0');
                    $('#ingresar').text('Registrar');
                });

            });
        </script>
    </head>
    <body>
        <!--<div id="divTitMiniBloque1" class="divTitMiniBloque" style="margin-top:10px; margin-left: 18px; height: 20px;">Principal</div>-->
        <div style="margin-top: 5%;position: relative;display: block">            
            <form id="frminscripcion">
                <table width="912" border="0" align="center">
                    <tr>
                        <td width="79" height="50">Atletas:</td>
                        <td width="741"> 
                            <select  name="cedula" class="form-control" id="cedula">
                                <option value="0">Seleccione</option>
                                <?php
                                for ($i = 0; $i < count($d_resul); $i++) {
                                    ?>
                                    <option value="<?php echo $d_resul[$i]['cedula']; ?>"><?php echo $d_resul[$i]['datos']; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </td>                       
                        <td width="351">
                            &nbsp;
                        </td>
                    </tr>
                </table>


                <table width="912" border="0" align="center" style="margin-top: 50px;">
                    <tr>
                        <td height="59" colspan="4" align="center">
                            <fieldset>
                                <legend> 
                                    <span style="margin-left: -550px;
                                          color: #333333;
                                          font-family: Helvetica,Arial,sans-serif;
                                          font-size: 16px; ">  Datos Personales </span> 
                                </legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>                        
                        <td width="68">Nombres:</td>
                        <td width="328">
                            <div class="form-group">
                                <input type="text" class="form-control" disabled="disabled" style="background-color: #ffffff" id="nombre" name="nombre" value="" maxlength="10"/>
                            </div>
                        </td>
                        <td width="185"><span style="margin-left: 100px;">Edad:</span></td>
                        <td width="313">
                            <div class="form-group">
                                <input type="text" class="form-control" disabled="disabled" style="background-color: #ffffff" id="edad" name="edad" value="" />
                            </div>
                        </td>
                    </tr>

                    <tr>                        
                        <td>Sexo:</td>
                        <td>
                            <div class="form-group">
                                <input type="text" class="form-control" disabled="disabled" style="background-color: #ffffff" id="sexo" name="sexo" value="" maxlength="10"/>
                            </div>
                        </td>
                        <td><span style="margin-left: 100px;">Peso:</span></td>
                        <td>
                            <div class="form-group">
                                <input type="text" class="form-control" disabled="disabled" style="background-color: #ffffff" id="peso" name="peso" value="" />
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td height="59" colspan="4" align="center">
                            <fieldset>
                                <legend> 
                                    <span style="margin-left: -590px;
                                          color: #333333;
                                          font-family: Helvetica,Arial,sans-serif;
                                          font-size: 16px; ">  Otros Datos </span> 
                                </legend>
                            </fieldset>
                        </td>
                    </tr>

                    <tr>
                        <td>Categor&iacute;as:</td>
                        <td>
                            <div class="form-group">
                                <select name="categorias" class="form-control" id="categorias">
                                    <option value="0">Seleccione</option>
                                    <?php
                                    for ($i = 0; $i < count($resultec); $i++) {
                                        ?>
                                        <option value="<?php echo $resultec[$i]['num_registro']; ?>"><?php echo $resultec[$i]['descripcion']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </td>
                        <td><span style="margin-left: 100px;">Modalidades:</span></td>
                        <td>
                            <div class="form-group">
                                <select name="modalidad" class="form-control" id="modalidad">
                                    <option value="0">Seleccione</option>
                                    <?php
                                    for ($i = 0; $i < count($resultado); $i++) {
                                        ?>
                                        <option value="<?php echo $resultado[$i]['num_registro']; ?>"><?php echo $resultado[$i]['descripcion']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>Estilo :</td>
                        <td>
                            <div class="form-group">
                                <select name="estilo" class="form-control" id="estilo">
                                    <option value="0">Seleccione</option>
                                    <?php
                                    for ($i = 0; $i < count($result); $i++) {
                                        ?>
                                        <option value="<?php echo $result[$i]['id_estilo']; ?>"><?php echo $result[$i]['nombre_estilo']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </td>
                        <td><span style="margin-left: 100px;">Regi&oacute;n:</span></td>
                        <td>
                            <div class="form-group">
                                <select name="region" class="form-control" id="region">
                                    <option value="0">Seleccione</option>
                                    <?php
                                    for ($i = 0; $i < count($resul); $i++) {
                                        ?>
                                        <option value="<?php echo $resul[$i]['id_region']; ?>"><?php echo $resul[$i]['nombre_region']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>Estatus :</td>
                        <td>
                            <div class="form-group">
                                <select name="estatus" class="form-control" id="estatus">
                                    <option value="0">Seleccione</option>
                                    <?php
                                    for ($i = 0; $i < count($res); $i++) {
                                        ?>
                                        <option value="<?php echo $res[$i]['id_estatus']; ?>"><?php echo $res[$i]['estatus_evento']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </td>
                        <td>
                            &nbsp;
                        </td>
                    </tr>

                    <tr>
                        <td colspan="4">&nbsp;</td>
                    </tr>               

                    <tr>
                        <td colspan="4" align="center">
                            <input type="hidden" id="accion" name="accion" value=""/>
                            <button type="button" id="ingresar" class="btn btn-info">Registrar</button>
                            <button type="button" id="limpiar" class="btn btn-info">Limpiar</button>
                        </td>
                    </tr>
                </table>

                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr> 
                
                <tr>
                    <td colspan="4" align="center">
                        <table border="0" id="tbl_categoria" class="dataTable">
                            <thead>
                                <tr>
                                    <th>Descripci&oacute;n</th>
                                    <th>Edad</th>
                                    <th>Genero</th>
                                    <th>Estilo</th>
                                    <th>Regi&oacute;n</th>
                                    <th>Acci&oacute;n</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql        = "SELECT  
                                                    ca.descripcion,  
                                                    ca.edad,  
                                                    ca.sexo,
                                                    es.nombre_estilo AS estilo,
                                                    re.nombre_region AS region
                                                    FROM categorias ca
                                                    INNER JOIN estilo AS es ON ca.id_estilo = es.id_estilo
                                                    INNER JOIN region AS re ON ca.id_region = re.id_region";
                                $resgistros = $obj_conexion->RetornarRegistros($sql);

                                $es_array = is_array($resgistros) ? TRUE : FALSE;
                                if ($es_array == TRUE) {
                                    for ($i = 0; $i < count($resgistros); $i++) {
                                        ?>
                                        <tr>
                                            <td><?php echo $resgistros[$i]['descripcion'] ?></td>
                                            <td><?php echo $resgistros[$i]['edad'] ?></td>
                                            <td><?php echo $resgistros[$i]['sexo'] ?></td>
                                            <td><?php echo $resgistros[$i]['estilo'] ?></td>
                                            <td><?php echo $resgistros[$i]['region'] ?></td>
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
