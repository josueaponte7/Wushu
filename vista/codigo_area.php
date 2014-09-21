<?php
session_start();
require_once '../modelo/Conexion.php';
$obj_conexion = new Conexion();

$archivo_actual      = basename($_SERVER['PHP_SELF']);
$_SESSION['archivo'] = $archivo_actual;
$_SESSION['titulo']  = 'Agregar Registros de ESTADO';
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
        <link href="../css/select2.css" rel="stylesheet" media="screen"/>
        <link href="../css/select2-bootstrap.css" rel="stylesheet" media="screen"/>

        <script type="text/javascript" src="../js/jquery-1.11.0.js"></script>
        <script type="text/javascript" src="../js/validarcampos.js"></script>
        <script type="text/javascript" src="../js/select2.js"></script>
        <script type="text/javascript" src="../js/select2_locale_es.js"></script>
        <script type="text/javascript" src="../js/jquery.dataTables.js"></script>
        <style type="text/css">
            body{
                background-color: transparent;
            }
        </style>
        <script type="text/javascript">
            $(document).ready(function() {

                var TEstado = $('#tbl_estado').dataTable({
                    "iDisplayLength": 5,
                    "iDisplayStart": 0,
                    "aLengthMenu": [5, 10, 20, 30, 40, 50],
                    "oLanguage": {"sUrl": "../js/es.txt"},
                    "aoColumns": [
                        {"sClass": "center", "sWidth": "4%", "bSortable": false, "bSearchable": false},
                        {"sClass": "center", "sWidth": "15%"},
                        {"sClass": "center", "sWidth": "15%"},
                        {"sClass": "center", "sWidth": "12%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false}
                    ]
                });
               
                 var numero = '0123456789';
                $('#cod_area').validar(numero);

                $('#ingresar').click(function() {
                    var $tipo_codigo = $('#tipo_codigo').find('option').filter(':selected');
                    if ($('#cod_area').val() == '') {
                        alert('Debe Ingresar el Codigo de T&eacute;lefono');
                        $('#estado').focus();
                    } else if ($tipo_codigo.val() == 0) {
                        alert('Debe Seleccionar el Tipo de Codigo');
                        $('#tipo_codigo').focus();
                    } else {

                        var accion = $(this).text();
                        $('#accion').val(accion);
                        $('#codigo_area').prop('disabled', false);

                        if (accion == 'Registrar') {
                            
                             $('#id_codigo').remove();
                            // obtener el ultimo codigo del status 
                            var codigo = 1;
                            var TotalRow = TEstado.fnGetData().length;
                            if (TotalRow > 0) {
                                var lastRow = TEstado.fnGetData(TotalRow - 1);
                                var codigo = parseInt(lastRow[0]) + 1;
                            }

                            var $id_codigo = '<input type="hidden" id="id_codigo"  value="' + codigo + '" name="id_codigo">';
                            $($id_codigo).prependTo($('#frmestado'));

                            $.post("../controlador/codigo_area.php", $("#frmestado").serialize(), function(resultado) {

                                if (resultado == 'exito') {
                                    alert('Registro con exito');
                                    $('input:text').val();

                                    var modificar = '<span class="accion modificar">Modificar</span>';
                                    var eliminar = '<span class="accion eliminar">Eliminar</span>';
                                    var accion = modificar + '&nbsp;' + eliminar;

                                    TEstado.fnAddData([codigo, $('#cod_area').val(),$tipo_codigo.text(), accion]);
                                    $('input:text').val('');
                                    $('select').val(0);
                                    
                                } else if (resultado == 'existe') {
                                    alert('El Codigo de Area ya esta registrado');
                                    $('#id_estado').addClass('has-error');
                                    $('#estado').focus();
                                }
                            });
                        }

                        else {
                            var r = confirm("\u00BFDesea Modificar el Registro?");
                            var fila = $("#fila").val();
                            if (r == true) {

                                $.post("../controlador/codigo_area.php", $("#frmestado").serialize(), function(resultado) {
                                    if (resultado == 'exito') {
                                        alert('Modificaci\u00f3n  con exito');

                                        TEstado.fnUpdate( $('#cod_area').val(), parseInt(fila), 1 )
                                        TEstado.fnUpdate( $tipo_codigo.text(), parseInt(fila), 2 )
                                        $('input:text').val('');
                                        $('select').val(0);
                                        $('#ingresar').text('Registrar');
                                    }
                                });
                            }

                        }
                    }
                });

                $('table#tbl_estado').on('click', '.modificar', function() {
                    $('#id_codigo').remove();
                    $('#fila').remove();
                    var padre     = $(this).closest('tr');
                    var id_codigo = padre.find('td').eq(0).text();
                    var cod_area  = padre.find('td').eq(1).html();
                    var tipo      = padre.find('td').eq(2).html();
                    // obtener la fila a modificar
                    var fila = padre.index();

                    // crear el campo fila y añadir la fila
                    var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
                    $($fila).prependTo($('#frmestado'));
                    var $id_codigo = '<input type="hidden" id="id_codigo"  value="' + id_codigo + '" name="id_codigo">';
                    $($id_codigo).prependTo($('#frmestado'));

                    $('#ingresar').text('Modificar');
                    var cod_tipo = 1;
                    if(tipo == 'Celular'){
                        cod_tipo = 2;
                    }
                    $('#cod_area').val(cod_area);
                    $('#tipo_codigo').val(cod_tipo);
                });

                // eliminar
                $('table#tbl_estado').on('click', '.eliminar', function() {
                    var padre = $(this).closest('tr');
                    var id_estado = padre.find('td').eq(0).text();

                    // obtener la fila a modificar
                    var fila = padre.index();

                    // crear el campo fila y añadir la fila
                    var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
                    $($fila).prependTo($('#frmestado'));

                    $.post("../controlador/codigo_area.php", {'accion': 'Eliminar', 'nombre': id_estado}, function(respuesta) {
                        if (respuesta == 1) {

                            window.parent.bootbox.alert("Eliminacion con Exito", function() {
                                //borra la fila de la tabla
                                TEstado.fnDeleteData;

                                $('input[type="text"]').val('');
                            });
                        }
                    });
                });

                $('#limpiar').click(function() {
                    $('#estado').prop('disabled', false);
                    $('input:text').val('');
                    $('#ingresar').text('Registrar');
                });
            });
        </script>
    </head>
    <body>
        <div style="margin-top: 5%;position: relative;display: block">
            <form id="frmestado">
                <table width="912" border="0" align="center">
                    <tr>                       
                        <td width="141" align="right">C&oacute;digo de &Aacute;rea:</td>
                        <td width="270">
                            <div id="d_cod"  class="form-group">
                                <input type="text" style="background-color: #ffffff; width: 150px;" class="form-control" id="cod_area" name="cod_area" value="" maxlength="4"/>
                            </div>
                        </td>
                        <td width="141" align="right">Tipo de C&oacute;digo:</td>
                        <td width="270">
                            <div id="d_cod"  class="form-group">
                                 <select name="tipo_codigo" class="form-control" id="tipo_codigo" style="float: left;">
                                     <option value="0">Seleccione</option>
                                     <option value="1">Local</option>
                                     <option value="2">Celular</option>
                                </select>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">&nbsp;</td>
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
                    <tr>
                        <td colspan="4" align="center">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="4" align="center">
                            <table border="0" id="tbl_estado" class="dataTable">
                                <thead>
                                    <tr>
                                        <th>C&oacute;digo</th>
                                        <th>Cod Tel&eacute;fono</th>
                                        <th>Tipo de C&oacute;go</th>
                                        <th>Acci&oacute;n</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql        = "SELECT id,codigo,tipo FROM codigo_telefono";
                                    $resgistros = $obj_conexion->RetornarRegistros($sql);

                                    $es_array = is_array($resgistros) ? TRUE : FALSE;
                                    if ($es_array == TRUE) {
                                        $tipo = 'Local';
                                        for ($i = 0; $i < count($resgistros); $i++) {
                                            if($resgistros[$i]['tipo'] == 2){
                                                $tipo = 'Celular';
                                            }
                                                                                        
                                            ?>
                                            <tr>
                                                <td><?php echo $resgistros[$i]['id'] ?></td>
                                                <td><?php echo $resgistros[$i]['codigo'] ?></td>
                                                <td><?php echo $tipo ?></td>  
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
