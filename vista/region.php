<?php
session_start();
require_once '../modelo/Conexion.php';
$obj_conexion = new Conexion();

$archivo_actual      = basename($_SERVER['PHP_SELF']);
$_SESSION['archivo'] = $archivo_actual;
$_SESSION['titulo']  = 'Agregar Registros de REGI&Oacute;N';
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

                var TRegion = $('#tbl_region').dataTable({
                    "iDisplayLength": 5,
                    "iDisplayStart": 0,
                    "aLengthMenu": [5, 10, 20, 30, 40, 50],
                    "oLanguage": {"sUrl": "../js/es.txt"},
                    "aoColumns": [
                        {"sClass": "center", "sWidth": "4%", "bSortable": false, "bSearchable": false},
                        {"sClass": "center", "sWidth": "15%"},
                        {"sClass": "center", "sWidth": "12%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false}
                    ]
                });

                var letra = ' abcdefghijklmnñopqrstuvwxyzáéíóú';
                $('#nombre_region').validar(letra);

                $('#ingresar').click(function() {

                    if ($('#nombre_region').val() == '') {
                        alert('Debe Ingresar la Region');
                        $('#nombre_region').focus();
                    } else {

                        $('#id_region').remove();
                        var accion = $(this).text();
                        $('#accion').val(accion);
                        $('#nombre_region').prop('disabled', false);

                        if (accion == 'Registrar') {
                            // obtener el ultimo codigo del status 
                            var codigo = 1;
                            var TotalRow = TRegion.fnGetData().length;
                            if (TotalRow > 0) {
                                var lastRow = TRegion.fnGetData(TotalRow - 1);
                                var codigo = parseInt(lastRow[0]) + 1;
                            }

                            var $id_region = '<input type="hidden" id="id_region"  value="' + codigo + '" name="id_region">';
                            $($id_region).prependTo($('#frmregion'));

                            $.post("../controlador/region.php", $("#frmregion").serialize(), function(resultado) {

                                if (resultado == 'exito') {
                                    alert('Registro con exito');
                                    $('input:text').val();

                                    var modificar = '<span class="accion modificar">Modificar</span>';
                                    var eliminar = '<span class="accion eliminar">Eliminar</span>';
                                    var accion = modificar + '&nbsp;' + eliminar;

                                    TRegion.fnAddData([codigo, $('#nombre_region').val(), accion]);
                                    $('input:text').val('');

                                } else if (resultado == 'existe') {
                                    alert('La Region ya esta registrado');
                                    $('#d_region').addClass('has-error');
                                    $('#nombre_region').focus();
                                }
                            });
                        }

                        else {
                            var r = confirm("\u00BFDesea Modificar el Registro?");
                            var fila = $("#fila").val();
                            if (r == true) {

                                $.post("../controlador/region.php", $("#frmregion").serialize(), function(resultado) {
                                    if (resultado == 'exito') {
                                        alert('Modificaci\u00f3n  con exito');

                                        $("#tbl_region tbody tr:eq(" + fila + ")").find("td").eq(1).html($('#nombre_region').val());
                                        $('input:text').val('');
                                        $('#ingresar').text('Registrar');
                                    }
                                });
                            }

                        }
                    }
                });

                $('table#tbl_region').on('click', '.modificar', function() {
                    $('#id_region').remove();

                    var padre = $(this).closest('tr');
                    var id_region = padre.find('td').eq(0).text();
//                    var nombre = padre.find('td').eq(1).html();

                    // obtener la fila a modificar
                    var fila = padre.index();

                    // crear el campo fila y añadir la fila
                    var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
                    $($fila).prependTo($('#frmregion'));

                    var $id_region = '<input type="hidden" id="id_region"  value="' + id_region + '" name="id_region">';
                    $($id_region).appendTo($('#frmregion'));

                    $('#ingresar').text('Modificar');

//                    $('#nombre').val(nombre);

                    $.post("../controlador/region.php", {id_region: id_region, accion: 'BuscarDatos'}, function(resultado) {
                        var datos = resultado.split(";");
                        $('#nombre_region').val(datos[0]);


                        // crear el campo fila y añadir la fila
                        var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
                        $($fila).prependTo($('#frmregion'));

                        var $id_region = '<input type="hidden" id="id_region"  value="' + id_region + '" name="id_region">';
                        $($id_region).appendTo($('#frmregion'));

                    });
                });

                // eliminar
                $('table#tbl_region').on('click', '.eliminar', function() {
                    var padre = $(this).closest('tr');
                    var id_region = padre.find('td').eq(0).text();

                    // obtener la fila a modificar
                    var fila = padre.index();

                    // crear el campo fila y añadir la fila
                    var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
                    $($fila).prependTo($('#frmregion'));

                    $.post("../controlador/region.php", {'accion': 'Eliminar', 'nombre': id_region}, function(respuesta) {
                        if (respuesta == 1) {

                            window.parent.bootbox.alert("Eliminacion con Exito", function() {
                                //borra la fila de la tabla
                                TRegion.fnDeleteData;

                                $('input[type="text"]').val('');
                            });
                        }
                    });
                });

                $('#limpiar').click(function() {
                    $('#nombre_region').prop('disabled', false);
                    $('input:text').val('');
                    $('#ingresar').text('Registrar');
                });
            });
        </script>
    </head>
    <body>
        <div style="margin-top: 5%;position: relative;display: block">
            <form id="frmregion">
                <table width="912" border="0" align="center">
                    <tr>
                        <td width="113">Nombre Regi&oacute;n:</td>
                        <td width="376">
                            <div id="d_region"  class="form-group">
                                <input type="text" style="background-color: #ffffff" class="form-control" id="nombre_region" name="nombre_region" value="" />
                            </div>
                        </td>
                        <td width="409" colspan="4">&nbsp;</td>
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
                            <table border="0" id="tbl_region" class="dataTable">
                                <thead>
                                    <tr>
                                        <th>C&oacute;digo</th>
                                        <th>Nombre Regi&oacute;n</th>
                                        <th>Acci&oacute;n</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql                 = "SELECT  id_region,  nombre_region FROM region";
                                    $resgistros          = $obj_conexion->RetornarRegistros($sql);

                                    $es_array = is_array($resgistros) ? TRUE : FALSE;
                                    if ($es_array == TRUE) {
                                        for ($i = 0; $i < count($resgistros); $i++) {
                                            ?>
                                            <tr>
                                                <td><?php echo $resgistros[$i]['id_region'] ?></td>
                                                <td><?php echo $resgistros[$i]['nombre_region'] ?></td>                                               
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
