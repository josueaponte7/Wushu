<?php
require_once '../modelo/Conexion.php';
$obj_conexion = new Conexion();
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

                var TAmodalidades = $('#tbl_modalidades').dataTable({
                    "iDisplayLength": 5,
                    "iDisplayStart": 0,
                    "aLengthMenu": [5, 10, 20, 30, 40, 50],
                    "oLanguage": {"sUrl": "../js/es.txt"},
                    "aoColumns": [
                        {"sClass": "center", "sWidth": "15%"},
                        {"sWidth": "12%"},
                        {"sClass": "center", "sWidth": "4%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false}
                    ]
                });

                var letra = ' abcdefghijklmnñopqrstuvwxyzáéíóú';
                $('#descripcion').validar(letra);

                $('#ingresar').click(function() {

                    var accion = $(this).text();
                    $('#accion').val(accion)
                    $('#descripcion').prop('disabled', false);
                    if (accion == 'Registrar') {
                        $.post("../controlador/modalidades.php", $("#frmmodalidades").serialize(), function(resultado) {
                            if (resultado == 'exito') {
                                alert('Registro con exito');
                                $('input:text').val();
                                $('input:radio').prop('ckecked', true);

                                var estatus = $('input:radio[name="estatus"]:checked').val();
                                var modificar = '<span class="accion modificar">Modificar</span>';
                                var eliminar = '<span class="accion eliminar">Eliminar</span>';
                                var accion = modificar + '&nbsp;' + eliminar
                                TAmodalidades.fnAddData([$('#descripcion').val(), estatus, accion]);
                                $('input:text').val('');
                                $('textarea').val('');

                            } else if (resultado == 'existe') {
                                alert('El Nombre de la Modalidad ya esta registrado');
                                $('#d_descripcion').addClass('has-error');
                                $('#descripcion').focus();
                            }
                        });
                    } else {
                        var r = confirm("\u00BFDesea Modificar el Registro?");
                        var fila = $("#fila").val();
                        if (r == true) {

                            var estatus = $('input:radio[name="estatus"]:checked').val();

                            $.post("../controlador/modalidades.php", $("#frmmodalidades").serialize(), function(resultado) {
                                if (resultado == 'exito') {
                                    alert('Modificaci\u00f3n  con exito');

                                    $("#tbl_modalidades tbody tr:eq(" + fila + ")").find("td").eq(0).html($('#descripcion').val());
                                    $("#tbl_modalidades tbody tr:eq(" + fila + ")").find("td").eq(1).html(estatus);
                                    $('input:text').val('');
                                    $('textarea').val('');
                                    $('#ingresar').text('Registrar');
                                }
                            });
                        }
                    }
                });

                $('table#tbl_modalidades').on('click', '.modificar', function() {

                    var padre = $(this).closest('tr');
                    var descripcion = padre.find('td').eq(0).text();
                    var estatus = padre.find('td').eq(1).text();

                    // obtener la fila a modificar
                    var fila = padre.index();

                    // crear el campo fila y añadir la fila
                    var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
                    $($fila).prependTo($('#frmmodalidades'));

                    $('#ingresar').text('Modificar');

                    //$('#descripcion').val(descripcion);
                    $('#descripcion').val(descripcion).prop('disabled', true);
                    $('input:radio[name="estatus"][value="' + estatus + '"]').prop('checked', true);

                    $.post("../controlador/modalidades.php", {descripcion: descripcion, accion: 'BuscarDatos'}, function(resultado) {

                        var datos = resultado.split(";");
                        $('#descripcion').val(datos[0]);
                        $('input:radio[name="estatus"][value="' + datos[1] + '"]').prop('checked', true);
                    });
                });

                $('#limpiar').click(function() {
                    $('#descripcion').prop('disabled', false);
                    $('input:text').val('');
                    $('textarea').val('');
                    $('#ingresar').text('Guardar');
                });
            });
        </script>        
    </head>
    <body>
        <div style="margin-top: 5%;position: relative;display: block">
            <form id="frmmodalidades">
                <table width="912" border="0" align="center">
                    <tr>
                        <td height="49"> Descripci&oacute;n </td>
                        <td>
                            <div id="div_desc" class="form-group">
                                <textarea style="width:605px !important; resize: none !important; background-color: #ffffff;"  name="descripcion" rows="2"  class="form-control input-sm"  id="descripcion"></textarea>
                            </div>
                        </td>
                    </tr>
                    <tr>  
                        <td width="107">Estatus :</td>
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
                            <table border="0" id="tbl_modalidades" class="dataTable">
                                <thead>
                                    <tr>
                                        <th>Descripcion</th>
                                        <th>Estatus</th>
                                        <th>Acci&oacute;n</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql          = "SELECT descripcion,estatus FROM modalidades";
                                    $resgistros   = $obj_conexion->RetornarRegistros($sql);

                                    $es_array = is_array($resgistros) ? TRUE : FALSE;
                                    if ($es_array == TRUE) {
                                        for ($i = 0; $i < count($resgistros); $i++) {
                                            ?>
                                            <tr>
                                                <td><?php echo $resgistros[$i]['descripcion'] ?></td>
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
