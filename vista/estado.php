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

                var letra = ' abcdefghijklmnñopqrstuvwxyzáéíóú';
                $('#estado').validar(letra);
                
                 var numero = '0123456789';
                $('#cod_telefono').validar(numero);

                $('#ingresar').click(function() {

                    if ($('#estado').val() == '') {
                        alert('Debe Ingresar el Estado');
                        $('#estado').focus();
                    } else if ($('#cod_telefono').val() == '') {
                        alert('Debe Ingresar el Codigo Telefono');
                        $('#cod_telefono').focus();
                    } else {

                        $('#id_estado').remove();
                        var accion = $(this).text();
                        $('#accion').val(accion);
                        $('#estado').prop('disabled', false);

                        if (accion == 'Registrar') {
                            // obtener el ultimo codigo del status 
                            var codigo = 1;
                            var TotalRow = TEstado.fnGetData().length;
                            if (TotalRow > 0) {
                                var lastRow = TEstado.fnGetData(TotalRow - 1);
                                var codigo = parseInt(lastRow[0]) + 1;
                            }

                            var $id_estado = '<input type="hidden" id="id_estado"  value="' + codigo + '" name="id_estado">';
                            $($id_estado).prependTo($('#frmestado'));

                            $.post("../controlador/estado.php", $("#frmestado").serialize(), function(resultado) {

                                if (resultado == 'exito') {
                                    alert('Registro con exito');
                                    $('input:text').val();

                                    var modificar = '<span class="accion modificar">Modificar</span>';
                                    var eliminar = '<span class="accion eliminar">Eliminar</span>';
                                    var accion = modificar + '&nbsp;' + eliminar;

                                    TEstado.fnAddData([codigo, $('#estado').val(),$('#cod_telefono').val(), accion]);
                                    $('input:text').val('');

                                } else if (resultado == 'existe') {
                                    alert('El Estado ya esta registrado');
                                    $('#d_estado').addClass('has-error');
                                    $('#estado').focus();
                                }
                            });
                        }

                        else {
                            var r = confirm("\u00BFDesea Modificar el Registro?");
                            var fila = $("#fila").val();
                            if (r == true) {

                                $.post("../controlador/estado.php", $("#frmestado").serialize(), function(resultado) {
                                    if (resultado == 'exito') {
                                        alert('Modificaci\u00f3n  con exito');

                                        $("#tbl_estado tbody tr:eq(" + fila + ")").find("td").eq(1).html($('#estado').val());
                                        $("#tbl_estado tbody tr:eq(" + fila + ")").find("td").eq(2).html($('#cod_telefono').val());
                                        $('input:text').val('');
                                        $('#ingresar').text('Registrar');
                                    }
                                });
                            }

                        }
                    }
                });

                $('table#tbl_estado').on('click', '.modificar', function() {
                    $('#id_estado').remove();

                    var padre = $(this).closest('tr');
                    var id_estado = padre.find('td').eq(0).text();
//                    var nombre = padre.find('td').eq(1).html();

                    // obtener la fila a modificar
                    var fila = padre.index();

                    // crear el campo fila y añadir la fila
                    var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
                    $($fila).prependTo($('#frmestilo'));

                    var $id_estado = '<input type="hidden" id="id_estado"  value="' + id_estado + '" name="id_estado">';
                    $($id_estado).appendTo($('#frmestado'));

                    $('#ingresar').text('Modificar');

                    $.post("../controlador/estado.php", {id_estado: id_estado, accion: 'BuscarDatos'}, function(resultado) {
                        var datos = resultado.split(";");
                        $('#estado').val(datos[0]);
                        $('#cod_telefono').val(datos[1]);


                        // crear el campo fila y añadir la fila
                        var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
                        $($fila).prependTo($('#frmestado'));

                        var $id_estado = '<input type="hidden" id="id_estado"  value="' + id_estado + '" name="id_estado">';
                        $($id_estado).appendTo($('#frmestado'));

                    });
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

                    $.post("../controlador/estado.php", {'accion': 'Eliminar', 'nombre': id_estado}, function(respuesta) {
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
                        <td width="111">Nombre Estado:</td>
                        <td width="372">
                            <div id="d_estado"  class="form-group">
                                <input type="text" style="background-color: #ffffff" class="form-control" id="estado" name="estado" value="" />
                            </div>
                        </td>
                        <td width="141" align="right">Cod Tel&eacute;fono:</td>
                        <td width="270">
                            <div id="d_cod"  class="form-group">
                                <input type="text" style="background-color: #ffffff; width: 150px;" class="form-control" id="cod_telefono" name="cod_telefono" value="" maxlength="4"/>
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
                                        <th>Nombre Estado</th>
                                        <th>Cod Tel&eacute;fono</th>
                                        <th>Acci&oacute;n</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql                 = "SELECT  id_estado,  estado,  cod_telefono FROM estado";
                                    $resgistros          = $obj_conexion->RetornarRegistros($sql);

                                    $es_array = is_array($resgistros) ? TRUE : FALSE;
                                    if ($es_array == TRUE) {
                                        for ($i = 0; $i < count($resgistros); $i++) {
                                            ?>
                                            <tr>
                                                <td><?php echo $resgistros[$i]['id_estado'] ?></td>
                                                <td><?php echo $resgistros[$i]['estado'] ?></td>
                                                <td><?php echo $resgistros[$i]['cod_telefono'] ?></td>  
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
