<?php
session_start();
require_once '../modelo/Conexion.php';
$obj_conexion = new Conexion();

$codigo   = "SELECT  id,  codigo FROM codigo_telefono";
$resulcod = $obj_conexion->RetornarRegistros($codigo);

$archivo_actual      = basename($_SERVER['PHP_SELF']);
$_SESSION['archivo'] = $archivo_actual;
$_SESSION['titulo']  = 'Agregar Registros de ASOCIACIONES';
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

                var TAsociacion = $('#tbl_asociacion').dataTable({
                    "iDisplayLength": 5,
                    "iDisplayStart": 0,
                    "aLengthMenu": [5, 10, 20, 30, 40, 50],
                    "oLanguage": {"sUrl": "../js/es.txt"},
                    "aoColumns": [
                        {"sClass": "center", "sWidth": "15%"},
                        {"sClass": "center", "sWidth": "15%"},
                        {"sWidth": "20%"},
                        {"sWidth": "15%"},
                        {"sWidth": "8%"},
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
                    var accion = $(this).text();
                    $('#accion').val(accion);
                    $('#nombre').prop('disabled', false);
                    if (accion == 'Registrar') {
                        $.post("../controlador/asociaciones.php", $("#frmasociaciones").serialize(), function(resultado) {
                            if (resultado == 'exito') {
                                alert('Registro con exito');
                                $('input:text').val();
                                $('#cod_telefono,#cod_telrep').val(0);

                                var cod_telefono = $('#cod_telefono').find(' option').filter(":selected").text();
                                var tel = cod_telefono + '-' + $('#telefono').val();

                                var cod_telrep = $('#cod_telrep').find(' option').filter(":selected").text();
                                var telp = cod_telrep + '-' + $('#tel_rep').val();

                                var estatus = $('input:radio[name="estatus"]:checked').val();
                                var modificar = '<span class="accion modificar">Modificar</span>';
                                var eliminar = '<span class="accion eliminar">Eliminar</span>';
                                var accion = modificar + '&nbsp;' + eliminar
                                TAsociacion.fnAddData([$('#nombre').val(), tel, $('#representante').val(), telp, estatus, accion]);


                                $('input:text').val('');
                                $('textarea').val('');

                            } else if (resultado == 'existe') {
                                alert('El Nombre de la Asociacion ya esta registrado');
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

                                    $("#tbl_asociacion tbody tr:eq(" + fila + ")").find("td").eq(0).html($('#nombre').val());
                                    $("#tbl_asociacion tbody tr:eq(" + fila + ")").find("td").eq(1).html(tel);
                                    $("#tbl_asociacion tbody tr:eq(" + fila + ")").find("td").eq(2).html($('#representante').val());
                                    $("#tbl_asociacion tbody tr:eq(" + fila + ")").find("td").eq(3).html(telp);
                                    $("#tbl_asociacion tbody tr:eq(" + fila + ")").find("td").eq(4).html(estatus);
                                    $('input:text').val('');
                                    $('textarea').val('');
                                    $('#ingresar').text('Registrar');
                                }
                            });
                        }

                    }
                });

                $('table#tbl_asociacion').on('click', '.modificar', function() {
                    var padre = $(this).closest('tr');
                    var nombre = padre.find('td').eq(0).text();

                    // obtener la fila a modificar
                    var fila = padre.index();

                    // crear el campo fila y añadir la fila
                    var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
                    $($fila).prependTo($('#frmasociaciones'));

                    $('#ingresar').text('Modificar');
                    $('#nombre').val(nombre).prop('disabled', true);

                    $.post("../controlador/asociaciones.php", {nombre: nombre, accion: 'BuscarDatos'}, function(resultado) {
                        var datos = resultado.split(";");
                        $('#cod_telefono').val(datos[0]);
                        $('#telefono').val(datos[1]);
                        $('#email').val(datos[2]);
                        $('#direccion').val(datos[3]);
                        $('#representante').val(datos[4]);
                        $('#cod_telrep').val(datos[5]);
                        $('#tel_rep').val(datos[6]);
                        $('#email_rep').val(datos[7]);
                        $('input:radio[name="estatus"][value="' + datos[8] + '"]').prop('checked', true);
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
                    $('#nombre').prop('disabled',false);
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
            <form id="frmasociaciones">
                <table width="912" border="0" align="center">
                    <tr>
                        <td width="107">Nom Asociaci&oacute;n:</td>
                        <td width="323">
                            <div id="d_nombre" class="form-group">
                                <input type="text" style="background-color: #ffffff" class="form-control" id="nombre" name="nombre" value="" />
                            </div>
                        </td>
                        <td width="115"><span style="margin-left: 30px;">Tel&eacute;fono:</span></td>
                        <td>
                            <div class="form-inline">
                                <div class="form-group">
                                    <select name="cod_telefono" class="form-control" id="cod_telefono" style="float: left; width: 85px;">
                                        <option value="0">Cod</option>
                                        <?php
                                        for ($i = 0; $i < count($resulcod); $i++) {
                                            ?>
                                            <option value="<?php echo $resulcod[$i]['id']; ?>"><?php echo $resulcod[$i]['codigo']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="text" style="width: 275px;" class="form-control" id="telefono" name="telefono" value="" maxlength="7" />
                                </div>
                            </div>
                        </td> 
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td>
                            <div class="form-group">
                                <input type="text" class="form-control" id="email" name="email" value="" />
                            </div>
                        </td>
                        <td height="68" class="letras"><span style="margin-left: 30px;">Direcci&oacute;n:</span></td>
                        <td>
                            <div class="form-group">
                                <textarea style="resize: none !important; height: 50px; width: 100%;" name="direccion" rows="2"  class="form-control"  id="direccion"></textarea>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Representante:</td>
                        <td>
                            <div class="form-group">
                                <input type="text" class="form-control" id="representante" name="representante" value="" />
                            </div>
                        </td>
                        <td width="115"><span style="margin-left: 30px;">Tel Represe:</span></td>
                        <td>
                            <div class="form-inline">
                                <div class="form-group">
                                    <select name="cod_telrep" class="form-control" id="cod_telrep" style="float: left; width: 85px;">
                                        <option value="0">Cod</option>
                                        <?php
                                        for ($i = 0; $i < count($resulcod); $i++) {
                                            ?>
                                            <option value="<?php echo $resulcod[$i]['id']; ?>"><?php echo $resulcod[$i]['codigo']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="text" style="width: 275px;" class="form-control" id="tel_rep" name="tel_rep" value="" maxlength="7" />
                                </div>
                            </div>
                        </td> 
                    </tr>
                    <tr>
                        <td>Email Rep:</td>
                        <td>
                            <div class="form-group">
                                <input type="text" class="form-control" id="email_rep" name="email_rep" value="" />
                            </div>
                        </td>
                        <td><span style="margin-left: 30px;">Estatus:</span></td>
                        <td>
                            <div class="form-group">
                                <input type="radio" name="estatus" value="Activo"   id="activo" checked="checked" />Activo
                                <input type="radio" name="estatus" value="Inactivo" id="inactivo" />Inactivo
                            </div>
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
                    <tr>
                        <td colspan="4" align="center">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="4" align="center">
                            <table border="0" id="tbl_asociacion" class="dataTable">
                                <thead>
                                    <tr>
                                        <th>Nombre Asociaci&oacute;n</th>
                                        <th>Tel&eacute;fono</th>
                                        <th>Representante</th>
                                        <th>Tel Representante</th>
                                        <th>Estatus</th>
                                        <th>Acci&oacute;n</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql        = "SELECT 
                                                    a.nombre,  
                                                    CONCAT_WS('-' ,(SELECT codigo FROM codigo_telefono WHERE id = a.cod_telefono), a.telefono) AS telefono,
                                                    a.representante,  
                                                    CONCAT_WS('-' ,(SELECT codigo FROM codigo_telefono WHERE id = a.cod_telrep), a.tel_rep) AS tel_rep, 
                                                    a.estatus 
                                                    FROM asociaciones a
                                                    ";
                                    $resgistros = $obj_conexion->RetornarRegistros($sql);

                                    $es_array = is_array($resgistros) ? TRUE : FALSE;
                                    if ($es_array == TRUE) {
                                        for ($i = 0; $i < count($resgistros); $i++) {
                                            ?>
                                            <tr>
                                                <td><?php echo $resgistros[$i]['nombre'] ?></td>
                                                <td><?php echo $resgistros[$i]['telefono'] ?></td>
                                                <td><?php echo $resgistros[$i]['representante'] ?></td>
                                                <td><?php echo $resgistros[$i]['tel_rep'] ?></td>
                                                <td><?php echo $resgistros[$i]['estatus'] ?></td>
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
