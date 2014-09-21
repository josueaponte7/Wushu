<?php
session_start();
require_once '../modelo/Conexion.php';
$obj_conexion = new Conexion();

$archivo_actual      = basename($_SERVER['PHP_SELF']);
$_SESSION['archivo'] = $archivo_actual;
$_SESSION['titulo']  = 'Agregar Registros de MENÚ';
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

                var TMenu= $('#tbl_menu').dataTable({
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
                $('#menu').validar(letra);

                $('#ingresar').click(function() {
                    $('#id_menu').remove();
                    $('#fila').remove();
                    if ($('#menu').val() == '') {
                        alert('Debe Ingresar el Menu');
                        $('#menu').focus();
                    } else {

                        $('#id_menu').remove();
                        var accion = $(this).text();
                        $('#accion').val(accion);
                        $('#menu').prop('disabled', false);
                        var $id_menu = '<input type="hidden" id="id_menu"  value="' + codigo + '" name="id_menu">';
                        $($id_menu).prependTo($('#frmmenu'));

                        if (accion == 'Registrar') {
                            // obtener el ultimo codigo del status 
                            var codigo = 1;
                            var TotalRow = TMenu.fnGetData().length;
                            if (TotalRow > 0) {
                                var lastRow = TMenu.fnGetData(TotalRow - 1);
                                var codigo = parseInt(lastRow[0]) + 1;
                            }
                            $('#id_menu').val(codigo)
                            
                            $.post("../controlador/menu.php", $("#frmmenu").serialize(), function(resultado) {

                                if (resultado == 'exito') {
                                    alert('Registro con exito');
                                    $('input:text').val();

                                    var modificar = '<span class="accion modificar">Modificar</span>';
                                    var eliminar = '<span class="accion eliminar">Eliminar</span>';
                                    var accion = modificar + '&nbsp;' + eliminar;

                                    TMenu.fnAddData([codigo, $('#menu').val(), accion]);
                                    $('input:text').val('');

                                } else if (resultado == 'existe') {
                                    alert('El Menu ya esta registrada');
                                    $('#d_menu').addClass('has-error');
                                    $('#menu').focus();
                                }
                            });
                        }

                        else {
                            var r = confirm("\u00BFDesea Modificar el Registro?");
                            var fila = $("#fila").val();
                            if (r == true) {

                                $.post("../controlador/menu.php", $("#frmmenu").serialize(), function(resultado) {
                                    if (resultado == 'exito') {
                                        alert('Modificaci\u00f3n  con exito');

                                        $("#tbl_menu tbody tr:eq(" + fila + ")").find("td").eq(1).html($('#menu').val());
                                        $('input:text').val('');
                                        $('#ingresar').text('Registrar');
                                    }
                                });
                            }

                        }
                    }
                });

                $('table#tbl_menu').on('click', '.modificar', function() {
                    $('#id_menu').remove();

                    var padre = $(this).closest('tr');
                    var id_menu = padre.find('td').eq(0).text();
//                    var nombre = padre.find('td').eq(1).html();

                    // obtener la fila a modificar
                    var fila = padre.index();

                    // crear el campo fila y añadir la fila
                    var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
                    $($fila).prependTo($('#frmmenu'));

                    var $id_menu = '<input type="hidden" id="id_menu"  value="' + id_menu + '" name="id_menu">';
                    $($id_menu).appendTo($('#frmmenu'));

                    $('#ingresar').text('Modificar');

                    $.post("../controlador/menu.php", {id_menu: id_menu, accion: 'BuscarDatos'}, function(resultado) {
                        var datos = resultado.split(";");
                        $('#menu').val(datos[0]);


                        // crear el campo fila y añadir la fila
                        var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
                        $($fila).prependTo($('#frmmenu'));

                        var $id_menu = '<input type="hidden" id="id_menu"  value="' + id_menu + '" name="id_menu">';
                        $($id_menu).appendTo($('#frmmenu'));

                    });
                });

                // eliminar
                $('table#tbl_menu').on('click', '.eliminar', function() {
                    var padre = $(this).closest('tr');
                    var id_menu = padre.find('td').eq(0).text();

                    // obtener la fila a modificar
                    var fila = padre.index();

                    // crear el campo fila y añadir la fila
                    var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
                    $($fila).prependTo($('#frmmenu'));

                    $.post("../controlador/menu.php", {'accion': 'Eliminar', 'nombre': id_menu}, function(respuesta) {
                        if (respuesta == 1) {

                            window.parent.bootbox.alert("Eliminacion con Exito", function() {
                                //borra la fila de la tabla
                                TMenu.fnDeleteData;

                                $('input[type="text"]').val('');
                            });
                        }
                    });
                });

                $('#limpiar').click(function() {
                    $('#menu').prop('disabled', false);
                    $('input:text').val('');
                    $('#ingresar').text('Registrar');
                });
            });
        </script>
    </head>
    <body>
        <div style="margin-top: 5%;position: relative;display: block">
            <form id="frmmenu">
                <table width="912" border="0" align="center">
                    <tr>
                        <td width="66">Men&uacute;:</td>
                        <td width="425">
                            <div id="d_menu"  class="form-group">
                                <input type="text" style="background-color: #ffffff" class="form-control" id="menu" name="menu" value="" />
                            </div>
                        </td>
                        <td width="407" colspan="4">&nbsp;</td>
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
                            <table border="0" id="tbl_menu" class="dataTable">
                                <thead>
                                    <tr>
                                        <th>C&oacute;digo</th>
                                        <th>Men&uacute;</th>
                                        <th>Acci&oacute;n</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql                 = "SELECT  id_menu,  menu FROM menu";
                                    $resgistros          = $obj_conexion->RetornarRegistros($sql);

                                    $es_array = is_array($resgistros) ? TRUE : FALSE;
                                    if ($es_array == TRUE) {
                                        for ($i = 0; $i < count($resgistros); $i++) {
                                            ?>
                                            <tr>
                                                <td><?php echo $resgistros[$i]['id_menu'] ?></td>
                                                <td><?php echo $resgistros[$i]['menu'] ?></td>                                               
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
