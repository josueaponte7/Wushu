<?php
session_start();
require_once '../modelo/Conexion.php';
$obj_conexion = new Conexion();

$sql       = "SELECT  id_tipousuario,  tipo_usuario FROM tipo_usuario";
$resultado = $obj_conexion->RetornarRegistros($sql);

$archivo_actual      = basename($_SERVER['PHP_SELF']);
$_SESSION['archivo'] = $archivo_actual;
$_SESSION['titulo']  = 'Agregar Registros de USUARIOS';
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

                var TUsuario = $('#tbl_usuario').dataTable({
                    "iDisplayLength": 5,
                    "iDisplayStart": 0,
                    "aLengthMenu": [5, 10, 20, 30, 40, 50],
                    "oLanguage": {"sUrl": "../js/es.txt"},
                    "aoColumns": [
                        {"sClass": "center", "sWidth": "12%", "bSortable": false, "bSearchable": false},
                        {"sClass": "center", "sWidth": "10%"},
                        {"sClass": "center", "sWidth": "10%"},
                        {"sWidth": "10%"},
                        {"sClass": "center", "sWidth": "15%"},
                        {"sWidth": "10%"},
                        {"sClass": "center", "sWidth": "12%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false}
                    ]
                });

                var usuario = 'abcdefghijklmnopqrstuvwxyz0123456789';
                var letra = ' abcdefghijklmnñopqrstuvwxyzáéíóú';
                var clave = '1234567890abcdefghijklmnopqrstuvwxyz';
                $('#usuario').validar(usuario);
                $('#nombre').validar(letra);
                $('#apellido').validar(letra);
                $('#clave').validar(clave);

                $('#ingresar').click(function() {
                    var tipo_usuario = $('#tipo_usuario');

                    if ($('#usuario').val() == '') {
                        alert('Debe Ingresar el Usuario');
                        $('#usuario').focus();
                    } else if ($('#nombre').val() == '') {
                        alert('Debe Ingresar el Nombre');
                        $('#nombre').focus();
                    } else if ($('#apellido').val() == '') {
                        alert('Debe Ingresar el Apellido');
                        $('#apellido').focus();
                    } else if (tipo_usuario.find('option').filter(':selected').val() == 0) {
                        alert('Debe Seleccionar el Tipo Usuario');
                        tipo_usuario.focus();
                    }  else if ($(this).text() == 'Guardar' && $('#clave').val().length < 6 || $('#clave').val().length > 20) {
                        $('#div_clave').addClass('has-error');
                        $('#clave').focus();
                    } else if ($(this).text() == 'Guardar' && $('#clave').val() != $('#confir_clave').val()) {
                        $('#div_confirmar').addClass('has-error');
                        $('#confir_clave').focus();
                    } else {

                        $('#id_usuario').remove();
                        var accion = $(this).text();
                        $('#accion').val(accion);
                        $('#usuario').prop('disabled', false);

                        if (accion == 'Registrar') {
                            // obtener el ultimo codigo del status 
                            var codigo = 1;
                            var TotalRow = TUsuario.fnGetData().length;
                            if (TotalRow > 0) {
                                var lastRow = TUsuario.fnGetData(TotalRow - 1);
                                var codigo = parseInt(lastRow[0]) + 1;
                            }

                            var $id_usuario = '<input type="hidden" id="id_usuario"  value="' + codigo + '" name="id_usuario">';
                            $($id_usuario).prependTo($('#frmusuario'));

                            $.post("../controlador/usuario.php", $("#frmusuario").serialize(), function(resultado) {

                                if (resultado == 'exito') {
                                    alert('Registro con exito');
                                    
                                    $('input:radio').prop('ckecked', true);

                                    var tipo = $('#tipo_usuario').find('option:selected').text();
                                    var estatus = $('input:radio[name="estatus"]:checked').val();

                                    var modificar = '<span class="accion modificar">Modificar</span>';
                                    var eliminar = '<span class="accion eliminar">Eliminar</span>';
                                    var accion = modificar + '&nbsp;' + eliminar;
                                    TUsuario.fnAddData([codigo, $('#usuario').val(), $('#nombre').val(), $('#apellido').val(), tipo, estatus, accion]);
                                    $('input[type="text"],input[type="password"]').val('');
                                    $('select').val('0');

                                } else if (resultado == 'existe') {
                                    alert('El Usuario ya esta registrada');
                                    $('#d_usuario').addClass('has-error');
                                    $('#usuario').focus();
                                }
                            });
                        } else {
                            var r = confirm("\u00BFDesea Modificar el Registro?");
                            var fila = $("#fila").val();
                            if (r == true) {
                            
                                var tipo = $('#tipo_usuario').find('option:selected').text();
                                var estatus = $('input:radio[name="estatus"]:checked').val();

                                $.post("../controlador/usuario.php", $("#frmusuario").serialize(), function(resultado) {
                                    if (resultado == 'exito') {
                                        alert('Modificaci\u00f3n  con exito');

                                        $("#tbl_usuario tbody tr:eq(" + fila + ")").find("td").eq(1).html($('#usuario').val());
                                        $("#tbl_usuario tbody tr:eq(" + fila + ")").find("td").eq(2).html($('#nombre').val());
                                        $("#tbl_usuario tbody tr:eq(" + fila + ")").find("td").eq(3).html($('#apellido').val());
                                        $("#tbl_usuario tbody tr:eq(" + fila + ")").find("td").eq(4).html(tipo);
                                        $("#tbl_usuario tbody tr:eq(" + fila + ")").find("td").eq(5).html(estatus);
                                        $('input[type="text"],input[type="password"]').val('');
                                        $('select').val('0');
                                        $('#ingresar').text('Registrar');
                                    }
                                });
                            }

                        }
                    }
                });

                $('table#tbl_usuario').on('click', '.modificar', function() {
                    $('#id_usuario').remove();

                    var padre = $(this).closest('tr');
                    var id_usuario = padre.find('td').eq(0).text();
//                    var nombre = padre.find('td').eq(1).html();

                    // obtener la fila a modificar
                    var fila = padre.index();

                    // crear el campo fila y añadir la fila
                    var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
                    $($fila).prependTo($('#frmusuario'));

                    var $id_usuario = '<input type="hidden" id="id_usuario"  value="' + id_usuario + '" name="id_usuario">';
                    $($id_usuario).appendTo($('#frmusuario'));

                    $('#ingresar').text('Modificar');

                    $.post("../controlador/usuario.php", {id_usuario: id_usuario, accion: 'BuscarDatos'}, function(resultado) {
                        var datos = resultado.split(";");
                        $('#usuario').val(datos[0]);
                        $('#nombre').val(datos[1]);
                        $('#apellido').val(datos[2]);
                        $('#tipo_usuario').val(datos[3]);
                        $('input:radio[name="estatus"][value="' + datos[4] + '"]').prop('checked', true);


                        // crear el campo fila y añadir la fila
                        var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
                        $($fila).prependTo($('#frmasociaciones'));

                        var $id_usuario = '<input type="hidden" id="id_usuario"  value="' + id_usuario + '" name="id_usuario">';
                        $($id_usuario).appendTo($('#frmusuario'));

                    });
                });

                // eliminar
                $('table#tbl_usuario').on('click', '.eliminar', function() {
                    var padre = $(this).closest('tr');
                    var id_usuario = padre.find('td').eq(0).text();

                    // obtener la fila a modificar
                    var fila = padre.index();

                    // crear el campo fila y añadir la fila
                    var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
                    $($fila).prependTo($('#frmusuario'));

                    $.post("../controlador/usuario.php", {'accion': 'Eliminar', 'id_usuario': id_usuario}, function(respuesta) {
                        if (respuesta == 1) {

                            window.parent.bootbox.alert("Eliminacion con Exito", function() {
                                //borra la fila de la tabla
                                TUsuario.fnDeleteData;

                                $('input[type="text"]').val('');
                            });
                        }
                    });
                });

                $('#limpiar').click(function() {
                    $('#usuario').prop('disabled', false);
                    $('input[type="text"],input[type="password"]').val('');
                    $('select').val('0');
                    $('#ingresar').text('Registrar');
                });
            });
        </script>
    </head>
    <body>
        <div style="margin-top: 5%;position: relative;display: block">
            <form id="frmusuario">
                <table width="912" border="0" align="center">
                    <tr>
                        <td width="76">Usuario:</td>
                        <td width="323">
                            <div class="form-group">
                                <input type="text" style="background-color: #ffffff" class="form-control" id="usuario" name="usuario" value="" />
                            </div>
                        </td>
                        <td width="157"><span style="margin-left:10px;">Nombre:</span></td>
                        <td width="338">
                            <div  class="form-group">
                                <input type="text" style="background-color: #ffffff" class="form-control" id="nombre" name="nombre" value="" />
                            </div>
                        </td> 
                    </tr>
                    <tr>
                        <td>Apellido:</td>
                        <td>
                            <div  class="form-group">
                                <input type="text" style="background-color: #ffffff" class="form-control" id="apellido" name="apellido" value="" />
                            </div>
                        </td>
                        <td width="157"><span style="margin-left: 10px;">Tipo Usuarios:</span></td>
                        <td>
                            <select name="tipo_usuario" class="form-control" id="tipo_usuario">
                                <option value="0">Seleccione</option>
                                <?php
                                for ($i = 0; $i < count($resultado); $i++) {
                                    ?>
                                    <option value="<?php echo $resultado[$i]['id_tipousuario'] ?>"><?php echo $resultado[$i]['tipo_usuario'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </td> 
                    </tr>
                    <tr>
                        <td>Clave:</td>
                        <td>
                            <div id="div_clave" class="form-group">
                                <input type="password" class="form-control" id="clave" name="clave" value="" />
                            </div>
                        </td>
                        <td width="157"><span style="margin-left: 10px;">Confirmar Clave: </span></td>
                        <td>
                            <div id="div_confirmar" class="form-group">
                                <input type="password" class="form-control" id="confir_clave" name="confir_clave" value="" />
                            </div>
                        </td> 
                    </tr>
                    <tr>
                        <td>Estatus:</td>
                        <td>
                            <div class="form-group">
                                <input type="radio" name="estatus" value="Activo"   id="activo" checked="checked" />Activo
                                <input type="radio" name="estatus" value="Inactivo" id="inactivo" />Inactivo
                            </div>
                        </td>
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
                            <table border="0" id="tbl_usuario" class="dataTable">
                                <thead>
                                    <tr>
                                        <th>C&oacute;digo Usuario</th>
                                        <th>Usuario</th>
                                        <th>Nombre</th>
                                        <th>Apellido</th>
                                        <th>Tipo Usuario</th>
                                        <th>Estatus</th>
                                        <th>Acci&oacute;n</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql                 = "SELECT  
                                                    usu.id_usuario,  
                                                    usu.usuario,  
                                                    usu.nombre,  
                                                    usu.apellido, 
                                                    tpu.tipo_usuario AS tipiusuario, 
                                                    usu.estatus
                                                  FROM usuarios usu 
                                                  INNER JOIN tipo_usuario tpu ON tpu.id_tipousuario = usu.id_tipousuario;";
                                    $resgistros          = $obj_conexion->RetornarRegistros($sql);

                                    $es_array = is_array($resgistros) ? TRUE : FALSE;
                                    if ($es_array == TRUE) {
                                        for ($i = 0; $i < count($resgistros); $i++) {
                                            ?>
                                            <tr>
                                                <td><?php echo $resgistros[$i]['id_usuario'] ?></td>
                                                <td><?php echo $resgistros[$i]['usuario'] ?></td>
                                                <td><?php echo $resgistros[$i]['nombre'] ?></td>
                                                <td><?php echo $resgistros[$i]['apellido'] ?></td>
                                                <td><?php echo $resgistros[$i]['tipiusuario'] ?></td>
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
