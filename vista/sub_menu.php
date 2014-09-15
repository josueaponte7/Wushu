<?php
session_start();
require_once '../modelo/Conexion.php';
$obj_conexion = new Conexion();

$sql       = "SELECT  id_menu,  menu FROM menu";
$resultado = $obj_conexion->RetornarRegistros($sql);

$archivo_actual      = basename($_SERVER['PHP_SELF']);
$_SESSION['archivo'] = $archivo_actual;
$_SESSION['titulo']  = 'Agregar Registros de SUB_MENÚ';
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
        <script type="text/javascript" src="../js/jquery.dataTables.js"></script>
        <style type="text/css">
            body{
                background-color: transparent;
            }
        </style>
        <script type="text/javascript">
            $(document).ready(function() {

                var TSubMenu = $('#tbl_submenu').dataTable({
                    "iDisplayLength": 5,
                    "iDisplayStart": 0,
                    "aLengthMenu": [5, 10, 20, 30, 40, 50],
                    "oLanguage": {"sUrl": "../js/es.txt"},
                    "aoColumns": [
                        {"sClass": "center", "sWidth": "15%"},
                        {"sClass": "center", "sWidth": "30%"},
                        {"sWidth": "15%"},
                        {"sWidth": "15%"},
                        {"sWidth": "8%"},
                        {"sClass": "center", "sWidth": "15%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false}
                    ]
                });

                var letra = ' abcdefghijklmnñopqrstuvwxyzáéíóú';
                $('#sub_menu').validar(letra);               

                $('#ingresar').click(function() {
                    var menu = $('#menu');
                    
                    if (menu.find('option').filter(':selected').val() == 0) {
                        alert('Debe Seleccionar el Menu');
                        menu.focus();
                    } else if ($('#sub_menu').val() == '') {
                        alert('Debe Ingresar El Sub_Menu');
                        $('#sub_menu').focus();
                   } else if ($('#url').val() == '') {
                        alert('Debe Ingresar la URL');
                        $('#url').focus();
                    } else {

                        var accion = $(this).text();
                        $('#accion').val(accion)
                        $('#sub_menu').prop('disabled', false);
                        var menu = $('#menu').find('option').filter(":selected").text();
                        if (accion == 'Registrar') {
                            
                              // obtener el ultimo codigo del status 
                            var codigo = 1;
                            var TotalRow = TSubMenu.fnGetData().length;
                            if (TotalRow > 0) {
                                var lastRow = TSubMenu.fnGetData(TotalRow - 1);
                                var codigo = parseInt(lastRow[0]) + 1;
                            }

                            var $id_submenu = '<input type="hidden" id="id_submenu"  value="' + codigo + '" name="id_submenu">';
                            $($id_submenu).prependTo($('#frmsubmenu'));
                            

                            $.post("../controlador/sub_menu.php", $("#frmsubmenu").serialize(), function(resultado) {
                                if (resultado == 'exito') {
                                    alert('Registro con exito');
                                    $('input:text').val();
                                    $('input:radio').prop('ckecked', true);

                                    var estatus = $('input:radio[name="estatus"]:checked').val();
                                    var modificar = '<span class="accion modificar">Modificar</span>';
                                    var eliminar = '<span class="accion eliminar">Eliminar</span>';
                                    var accion = modificar + '&nbsp;' + eliminar
                                    TSubMenu.fnAddData([codigo,menu, $('#sub_menu').val(),  $('#url').val(), estatus, accion]);
                                    $('input:text').val('');
                                    $('select').val('');

                                } else if (resultado == 'existe') {
                                    alert('El Sub_Menu ya esta registrado');
                                    $('#d_sub').addClass('has-error');
                                    $('#sub_menu').focus();
                                }
                            });
                        } else {
                            var r = confirm("\u00BFDesea Modificar el Registro?");
                            var fila = $("#fila").val();
                            if (r == true) {
                            
                                var estatus = $('input:radio[name="estatus"]:checked').val();
                                $.post("../controlador/sub_menu.php", $("#frmsubmenu").serialize(), function(resultado) {
                                    if (resultado == 'exito') {
                                        alert('Modificaci\u00f3n  con exito');
//                                    
                                        $("#tbl_submenu tbody tr:eq(" + fila + ")").find("td").eq(1).html(menu);
                                        $("#tbl_submenu tbody tr:eq(" + fila + ")").find("td").eq(2).html($('#sub_menu').val());
                                        $("#tbl_submenu tbody tr:eq(" + fila + ")").find("td").eq(3).html($('#url').val());
                                        $("#tbl_submenu tbody tr:eq(" + fila + ")").find("td").eq(4).html(estatus);
                                        $('input:text').val('');
                                        $('select').val('0');
                                        $('#ingresar').text('Registrar');
                                    }
                                });
                            }
                        }

                    }
                });
                
                $('table#tbl_submenu').on('click', '.modificar', function() {
                    $('#id_submenu').remove();

                    var padre = $(this).closest('tr');
                    var id_submenu = padre.find('td').eq(0).text();
//                    var nombre = padre.find('td').eq(1).html();

                    // obtener la fila a modificar
                    var fila = padre.index();

                    // crear el campo fila y añadir la fila
                    var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
                    $($fila).prependTo($('#frmsubmenu'));

                    var $id_submenu = '<input type="hidden" id="id_submenu"  value="' + id_submenu + '" name="id_submenu">';
                    $($id_submenu).appendTo($('#frmsubmenu'));

                    $('#ingresar').text('Modificar');
                    
                    
                    //$('#cedula').val(cedula).prop('disabled', true);
//                    $('#nombre').val(nombre);
//                    $('#telefono').val(telefono);
//                    $('input:radio[name="sexo"][value="' + sexo + '"]').prop('checked', true);

                    $.post("../controlador/sub_menu.php", {id_submenu: id_submenu, accion: 'BuscarDatos'}, function(resultado) {
                        var datos = resultado.split(";");
                        $('#menu').val(datos[0]);
                        $('#sub_menu').val(datos[1]);
                        $('#url').val(datos[2]);
                        $('input:radio[name="estatus"][value="' + datos[3] + '"]').prop('checked', true);
                    });
                });

                $('#limpiar').click(function() {
                    $('#sub_menu').prop('disabled', false);
                    $('input:text').val('');
                    $('select').val('');
                    $('#ingresar').text('Registrar');
                });

            });

        </script>
    </head>
    <body>
        <div style="margin-top: 5%;position: relative;display: block">
            <form id="frmsubmenu">
                <table width="912" border="0" align="center">
                    <tr>
                        <td>Men&uacute;:</td>
                        <td width="351">
                            <select name="menu" class="form-control" id="menu">
                                <option value="0">Seleccione</option>
                                <?php
                                for ($i = 0; $i < count($resultado); $i++) {
                                    ?>
                                    <option value="<?php echo $resultado[$i]['id_menu'] ?>"><?php echo $resultado[$i]['menu'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </td>
                        <td width="88"><span style="margin-left: 35px;">Sub_Men&uacute;:</span></td>
                        <td width="376">
                            <div class="form-group">
                                <input type="text" style="background-color: #ffffff"  class="form-control" id="sub_menu" name="sub_menu" value="" />
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>Ruta Archivo:</td>
                        <td width="376">
                            <div class="form-group">
                                <input type="text" class="form-control" id="url" name="url" value="" />
                            </div>
                        </td>
                        <td width="79"><span style="margin-left: 35px;">Estatus:</span></td>
                        <td width="351">
                            <div class="form-group">
                                <input type="radio" name="estatus" value="Activo"   id="estatus" checked="checked" />Activo
                                <input type="radio" name="estatus" value="Inactivo" id="estatus" />Inactivo
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
                        <td>&nbsp;&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="4" align="center">
                            <table border="0" id="tbl_submenu" class="dataTable">
                                <thead>
                                    <tr>
                                        <th>Cod Sub_Men&uacute;</th>
                                        <th>Men&uacute;</th>
                                        <th>Sub_Men&uacute;</th>
                                        <th>URL</th>
                                        <th>Estatus</th>
                                        <th>Acci&oacute;n</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql        = "SELECT
                                                        subm.id_submenu,
                                                        me.menu AS menu,
                                                        subm.sub_menu,
                                                        subm.url,
                                                        subm.estatus
                                                    FROM sub_menu subm
                                                    INNER JOIN menu me ON subm.id_menu = me.id_menu;";
                                    $resgistros = $obj_conexion->RetornarRegistros($sql);

                                    $es_array = is_array($resgistros) ? TRUE : FALSE;
                                    if ($es_array == TRUE) {
                                        for ($i = 0; $i < count($resgistros); $i++) {
                                            ?>
                                            <tr>
                                                <td><?php echo $resgistros[$i]['id_submenu'] ?></td>
                                                <td><?php echo $resgistros[$i]['menu'] ?></td>
                                                <td><?php echo $resgistros[$i]['sub_menu'] ?></td>
                                                <td><?php echo $resgistros[$i]['url'] ?></td>
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
