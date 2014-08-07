<?php
session_start();
require_once '../modelo/Conexion.php';
$obj_conexion = new Conexion();

$codigo   = "SELECT  id,  codigo FROM codigo_telefono";
$resulcod = $obj_conexion->RetornarRegistros($codigo);

$archivo_actual      = basename($_SERVER['PHP_SELF']);
$_SESSION['archivo'] = $archivo_actual;
$_SESSION['titulo']  = 'Agregar Registros de TIPO USUARIOS';
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

                var TAsociacion = $('#tbl_tipousuario').dataTable({
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
                $('#nombre').validar(letra);
                $('#representante').validar(letra);

                var numero = '0123456789-';
                $('#telefono').validar(numero);
                $('#tel_rep').validar(numero);

                var correo = '0123456789abcdefghijklmnopqrstuvwxyz_-.#$&*@';
                $('#email, #email_rep').validar(correo);

                $('#ingresar').click(function() {
                    
                        $('#id_asociacion').remove();
                        var accion = $(this).text();
                        $('#accion').val(accion);
                        $('#nombre').prop('disabled', false);

                        if (accion == 'Registrar') {
                            // obtener el ultimo codigo del status 
                            var codigo = 1;
                            var TotalRow = TAsociacion.fnGetData().length;
                            if (TotalRow > 0) {
                                var lastRow = TAsociacion.fnGetData(TotalRow - 1);
                                var codigo = parseInt(lastRow[0]) + 1;
                            }

                            var $id_asociacion = '<input type="hidden" id="id_asociacion"  value="' + codigo + '" name="id_asociacion">';
                            $($id_asociacion).prependTo($('#frmasociaciones'));

                            var cod_telefono = $('#cod_telefono').find(' option').filter(":selected").text();
                            var tel = cod_telefono + '-' + $('#telefono').val();

                            var cod_telrep = $('#cod_telrep').find(' option').filter(":selected").text();
                            var telp = cod_telrep + '-' + $('#tel_rep').val();


                            $.post("../controlador/asociaciones.php", $("#frmasociaciones").serialize(), function(resultado) {

                                if (resultado == 'exito') {
                                    alert('Registro con exito');
                                    $('input:text').val();
                                    $('#cod_telefono,#cod_telrep').val(0);
                                    var estatus = $('input:radio[name="estatus"]:checked').val();
                                    var modificar = '<span class="accion modificar">Modificar</span>';
                                    var eliminar = '<span class="accion eliminar">Eliminar</span>';
                                    var accion = modificar + '&nbsp;' + eliminar
                                    TAsociacion.fnAddData([codigo, $('#nombre').val(), tel, $('#representante').val(), telp, estatus, accion]);
                                    $('input:text').val('');
                                    $('textarea').val('');

                                } else if (resultado == 'existe') {
                                    alert('La Asociacion ya esta registrada');
                                    $('#d_nombre').addClass('has-error');
                                    $('#nombre').focus();
                                }
                            });
                        } else {
                            var r = confirm("\u00BFDesea Modificar el Registro?");
                            var fila = $("#fila").val();
                            if (r == true) {
                                var cod_telefono = $('#cod_telefono').find(' option').filter(":selected").text();
                                var tel = cod_telefono + '-' + $('#telefono').val();

                                var cod_telrep = $('#cod_telrep').find(' option').filter(":selected").text();
                                var telp = cod_telrep + '-' + $('#tel_rep').val();

                                var estatus = $('input:radio[name="estatus"]:checked').val();
                                $.post("../controlador/asociaciones.php", $("#frmasociaciones").serialize(), function(resultado) {
                                    if (resultado == 'exito') {
                                        alert('Modificaci\u00f3n  con exito');

                                        $("#tbl_asociacion tbody tr:eq(" + fila + ")").find("td").eq(1).html($('#nombre').val());
                                        $("#tbl_asociacion tbody tr:eq(" + fila + ")").find("td").eq(2).html(tel);
                                        $("#tbl_asociacion tbody tr:eq(" + fila + ")").find("td").eq(3).html($('#representante').val());
                                        $("#tbl_asociacion tbody tr:eq(" + fila + ")").find("td").eq(4).html(telp);
                                        $("#tbl_asociacion tbody tr:eq(" + fila + ")").find("td").eq(5).html(estatus);
                                        $('input:text').val('');
                                        $('textarea').val('');
                                        $('select').val('0');
                                        $('#ingresar').text('Registrar');
                                    }
                                });
                            }

                        }
                });

                $('table#tbl_asociacion').on('click', '.modificar', function() {
                    $('#id_asociacion').remove();

                    var padre = $(this).closest('tr');
                    var id_asociacion = padre.find('td').eq(0).text();
//                    var nombre = padre.find('td').eq(1).html();

                    // obtener la fila a modificar
                    var fila = padre.index();

                    // crear el campo fila y añadir la fila
                    var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
                    $($fila).prependTo($('#frmasociaciones'));

                    var $id_asociacion = '<input type="hidden" id="id_asociacion"  value="' + id_asociacion + '" name="id_asociacion">';
                    $($id_asociacion).appendTo($('#frmasociaciones'));

                    $('#ingresar').text('Modificar');

//                    $('#nombre').val(nombre);

                    $.post("../controlador/asociaciones.php", {id_asociacion: id_asociacion, accion: 'BuscarDatos'}, function(resultado) {
                        var datos = resultado.split(";");
                        $('#nombre').val(datos[0]);
                        $('#cod_telefono').val(datos[1]);
                        $('#telefono').val(datos[2]);
                        $('#email').val(datos[3]);
                        $('#direccion').val(datos[4]);
                        $('#representante').val(datos[5]);
                        $('#cod_telrep').val(datos[6]);
                        $('#tel_rep').val(datos[7]);
                        $('#email_rep').val(datos[8]);
                        $('input:radio[name="estatus"][value="' + datos[9] + '"]').prop('checked', true);


                        // crear el campo fila y añadir la fila
                        var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
                        $($fila).prependTo($('#frmasociaciones'));

                        var $id_asociacion = '<input type="hidden" id="id_asociacion"  value="' + id_asociacion + '" name="id_asociacion">';
                        $($id_asociacion).appendTo($('#frmasociaciones'));

                    });
                });

                // eliminar
                $('table#tbl_asociacion').on('click', '.eliminar', function() {
                    var padre = $(this).closest('tr');
                    var nombre = padre.find('td').eq(0).text();

                    // obtener la fila a modificar
                    var fila = padre.index();

                    // crear el campo fila y añadir la fila
                    var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
                    $($fila).prependTo($('#frmasociaciones'));

                    $.post("../controlador/asociaciones.php", {'accion': 'Eliminar', 'nombre': nombre}, function(respuesta) {
                        if (respuesta == 1) {

                            window.parent.bootbox.alert("Eliminacion con Exito", function() {
                                //borra la fila de la tabla
                                TAsociacion.fnDeleteData;

                                $('input[type="text"]').val('');
                            });
                        }
                    });
                });

                $('#limpiar').click(function() {
                    $('#nombre').prop('disabled', false);
                    $('input:text').val('');
                    $('textarea').val('');
                    $('#cod_telefono, #cod_telrep').val(0);
                    $('#ingresar').text('Registrar');
                });
            });
        </script>
    </head>
    <body>
        <div style="margin-top: 5%;position: relative;display: block">
            <form id="frmtipousuario">
                <table width="912" border="0" align="center">
                    <tr>
                        <td width="92">Tipo Usuario:</td>
                        <td width="401">
                            <div class="form-group">
                                <input type="text" style="background-color: #ffffff" class="form-control" id="tipo_usuario" name="tipo_usuario" value="" />
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
                            <table border="0" id="tbl_tipousuario" class="dataTable">
                                <thead>
                                    <tr>
                                        <th>C&oacute;digo</th>
                                        <th>Tipo usuario</th>
                                        <th>Acci&oacute;n</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql        = "SELECT 
                                                    a.id_asociacion,
                                                    a.nombre,  
                                                    CONCAT_WS('-' ,(SELECT codigo FROM codigo_telefono WHERE id = a.cod_telefono), a.telefono) AS telefono,
                                                    a.representante,  
                                                    CONCAT_WS('-' ,(SELECT codigo FROM codigo_telefono WHERE id = a.cod_telrep), a.tel_rep) AS tel_rep, 
                                                    a.estatus 
                                                    FROM asociaciones a";
                                    $resgistros = $obj_conexion->RetornarRegistros($sql);

                                    $es_array = is_array($resgistros) ? TRUE : FALSE;
                                    if ($es_array == TRUE) {
                                        for ($i = 0; $i < count($resgistros); $i++) {
                                            ?>
                                            <tr>
                                                <td><?php echo $resgistros[$i]['id_asociacion'] ?></td>
                                                <td><?php echo $resgistros[$i]['nombre'] ?></td>                                               
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
