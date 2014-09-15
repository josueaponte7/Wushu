<?php
session_start();
require_once '../modelo/Conexion.php';
$obj_conexion = new Conexion();

$archivo_actual      = basename($_SERVER['PHP_SELF']);
$_SESSION['archivo'] = $archivo_actual;
$_SESSION['titulo']  = 'Agregar Registros de ESTILO';
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

                var TEstilo = $('#tbl_estilo').dataTable({
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
                $('#nombre_estilo').validar(letra);

                $('#ingresar').click(function() {

                    if ($('#nombre_estilo').val() == '') {
                        alert('Debe Ingresar el Estilo');
                        $('#nombre_estilo').focus();
                    } else {

                        $('#id_estilo').remove();
                        var accion = $(this).text();
                        $('#accion').val(accion);
                        $('#nombre_estilo').prop('disabled', false);

                        if (accion == 'Registrar') {
                            // obtener el ultimo codigo del status 
                            var codigo = 1;
                            var TotalRow = TEstilo.fnGetData().length;
                            if (TotalRow > 0) {
                                var lastRow = TEstilo.fnGetData(TotalRow - 1);
                                var codigo = parseInt(lastRow[0]) + 1;
                            }

                            var $id_estilo = '<input type="hidden" id="id_estilo"  value="' + codigo + '" name="id_estilo">';
                            $($id_estilo).prependTo($('#frmestilo'));

                            $.post("../controlador/estilo.php", $("#frmestilo").serialize(), function(resultado) {

                                if (resultado == 'exito') {
                                    alert('Registro con exito');
                                    $('input:text').val();

                                    var modificar = '<span class="accion modificar">Modificar</span>';
                                    var eliminar = '<span class="accion eliminar">Eliminar</span>';
                                    var accion = modificar + '&nbsp;' + eliminar;

                                    TEstilo.fnAddData([codigo, $('#nombre_estilo').val(), accion]);
                                    $('input:text').val('');

                                } else if (resultado == 'existe') {
                                    alert('El Estilo ya esta registrado');
                                    $('#d_estilo').addClass('has-error');
                                    $('#nombre_estilo').focus();
                                }
                            });
                        }

                        else {
                            var r = confirm("\u00BFDesea Modificar el Registro?");
                            var fila = $("#fila").val();
                            if (r == true) {

                                $.post("../controlador/estilo.php", $("#frmestilo").serialize(), function(resultado) {
                                    if (resultado == 'exito') {
                                        alert('Modificaci\u00f3n  con exito');

                                        $("#tbl_estilo tbody tr:eq(" + fila + ")").find("td").eq(1).html($('#nombre_estilo').val());
                                        $('input:text').val('');
                                        $('#ingresar').text('Registrar');
                                    }
                                });
                            }

                        }
                    }
                });

                $('table#tbl_estilo').on('click', '.modificar', function() {
                    $('#id_estilo').remove();

                    var padre = $(this).closest('tr');
                    var id_estilo = padre.find('td').eq(0).text();
//                    var nombre = padre.find('td').eq(1).html();

                    // obtener la fila a modificar
                    var fila = padre.index();

                    // crear el campo fila y añadir la fila
                    var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
                    $($fila).prependTo($('#frmestilo'));

                    var $id_estilo = '<input type="hidden" id="id_estilo"  value="' + id_estilo + '" name="id_estilo">';
                    $($id_estilo).appendTo($('#frmestilo'));

                    $('#ingresar').text('Modificar');

//                    $('#nombre').val(nombre);

                    $.post("../controlador/estilo.php", {id_estilo: id_estilo, accion: 'BuscarDatos'}, function(resultado) {
                        var datos = resultado.split(";");
                        $('#nombre_estilo').val(datos[0]);


                        // crear el campo fila y añadir la fila
                        var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
                        $($fila).prependTo($('#frmestilo'));

                        var $id_estilo = '<input type="hidden" id="id_estilo"  value="' + id_estilo + '" name="id_estilo">';
                        $($id_estilo).appendTo($('#frmestilo'));

                    });
                });

                // eliminar
                $('table#tbl_estilo').on('click', '.eliminar', function() {
                    var padre = $(this).closest('tr');
                    var id_estilo = padre.find('td').eq(0).text();

                    // obtener la fila a modificar
                    var fila = padre.index();

                    // crear el campo fila y añadir la fila
                    var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
                    $($fila).prependTo($('#frmestilo'));

                    $.post("../controlador/estilo.php", {'accion': 'Eliminar', 'nombre': id_estilo}, function(respuesta) {
                        if (respuesta == 1) {

                            window.parent.bootbox.alert("Eliminacion con Exito", function() {
                                //borra la fila de la tabla
                                TEstilo.fnDeleteData;

                                $('input[type="text"]').val('');
                            });
                        }
                    });
                });

                $('#limpiar').click(function() {
                    $('#nombre_estilo').prop('disabled', false);
                    $('input:text').val('');
                    $('#ingresar').text('Registrar');
                });
            });
        </script>
    </head>
    <body>
        <div style="margin-top: 5%;position: relative;display: block">
            <form id="frmestilo">
                <table width="912" border="0" align="center">
                    <tr>
                        <td width="92">Nombre Estilo:</td>
                        <td width="401">
                            <div id="d_estilo"  class="form-group">
                                <input type="text" style="background-color: #ffffff" class="form-control" id="nombre_estilo" name="nombre_estilo" value="" />
                            </div>
                        </td>
                        <td width="405" colspan="4">&nbsp;</td>
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
                            <table border="0" id="tbl_estilo" class="dataTable">
                                <thead>
                                    <tr>
                                        <th>C&oacute;digo</th>
                                        <th>Nombre Estilo</th>
                                        <th>Acci&oacute;n</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql                 = "SELECT  id_estilo, nombre_estilo FROM estilo";
                                    $resgistros          = $obj_conexion->RetornarRegistros($sql);

                                    $es_array = is_array($resgistros) ? TRUE : FALSE;
                                    if ($es_array == TRUE) {
                                        for ($i = 0; $i < count($resgistros); $i++) {
                                            ?>
                                            <tr>
                                                <td><?php echo $resgistros[$i]['id_estilo'] ?></td>
                                                <td><?php echo $resgistros[$i]['nombre_estilo'] ?></td>                                               
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
