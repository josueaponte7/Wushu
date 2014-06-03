<?php
session_start();
require_once '../modelo/Conexion.php';
$obj_conexion = new Conexion();

$sql       = "SELECT id_estatus, estatus_evento FROM estatus_evento";
$resultado = $obj_conexion->RetornarRegistros($sql);

$archivo_actual = basename($_SERVER['PHP_SELF']);
$_SESSION['archivo'] =  $archivo_actual;
$_SESSION['titulo'] = 'Agregar Registros de EVENTOS';
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

                var TEvento = $('#tbl_evento').dataTable({
                    "iDisplayLength": 5,
                    "iDisplayStart": 0,
                    "aLengthMenu": [5, 10, 20, 30, 40, 50],
                    "oLanguage": {"sUrl": "../js/es.txt"},
                    "aoColumns": [
                        {"sClass": "center", "sWidth": "15%"},
                        {"sClass": "center", "sWidth": "10%"},
                        {"sWidth": "10%"},
                        {"sWidth": "30%"},
                        {"sClass": "center", "sWidth": "15%", "bSortable": false, "bSearchable": false}
                    ]
                });

                /****Calendario*****/
                $('#fecha_inicio').datepicker({
                    language: "es",
                    format: 'dd/mm/yyyy',
                    startDate: "-75y",
                    endDate: "-15y",
                    autoclose: true
                });

                $('#fecha_fin').datepicker({
                    language: "es",
                    format: 'dd/mm/yyyy',
                    startDate: "-75y",
                    endDate: "-15y",
                    autoclose: true
                });


                $('#ingresar').click(function() {
//                    var usuario = $('#usuario').val();
//                    var clave = $('#clave').val();
                    var accion = $(this).text();
                    $('#accion').val(accion);
                    $('#descripcion').prop('disabled', false);
                    if (accion == 'Registrar') {
                        $.post("../controlador/eventos.php", $("#frmeventos").serialize(), function(resultado) {
                            if (resultado == 'exito') {
                                alert('Registro con exito');
                                $('input:text').val();

                                var modificar = '<span class="accion modificar">Modificar</span>';
                                var eliminar = '<span class="accion eliminar">Eliminar</span>';
                                var accion = modificar + '&nbsp;' + eliminar
                                TEvento.fnAddData([$('#descripcion').val(), $('#fecha_inicio').val(), $('#fecha_fin').val(), $('#organizadores').val(), accion]);
                                $('input:text').val('');
                                $('textarea').val('');

                            } else if (resultado == 'existe') {
                                alert('El Evento ya esta registrado');
                                $('#d_decripcion').addClass('has-error');
                                $('#descripcion').focus();
                            }
                        });
                    } else {
                        var r = confirm("\u00BFDesea Modificar el Registro?");
                        var fila = $("#fila").val();
                        if (r == true) {
                            $.post("../controlador/eventos.php", $("#frmeventos").serialize(), function(resultado) {
                                if (resultado == 'exito') {
                                    alert('Modificaci\u00f3n  con exito');

                                    $("#tbl_evento tbody tr:eq(" + fila + ")").find("td").eq(0).html($('#descripcion').val());
                                    $("#tbl_evento tbody tr:eq(" + fila + ")").find("td").eq(1).html($('#fecha_inicio').val());
                                    $("#tbl_evento tbody tr:eq(" + fila + ")").find("td").eq(2).html($('#fecha_fin').val());
                                    $("#tbl_evento tbody tr:eq(" + fila + ")").find("td").eq(3).html($('#organizadores').val());
                                    $('input:text').val('');
                                    $('textarea').val('');
                                    $('#ingresar').text('Registrar');
                                }
                            });
                        }

                    }
                });

                $('table#tbl_evento').on('click', '.modificar', function() {
                    var padre = $(this).closest('tr');
                    var descripcion = padre.find('td').eq(0).text();
                    var fecha_inicio = padre.find('td').eq(1).text();
                    var fecha_fin = padre.find('td').eq(2).text();
                    var organizadores = padre.find('td').eq(3).text();

                    // obtener la fila a modificar
                    var fila = padre.index();
                    // crear el campo fila y añadir la fila
                    var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
                    $($fila).prependTo($('#frmeventos'));

                    $('#ingresar').text('Modificar');
                    $('#descripcion').val(descripcion).prop('disabled', true);
                    $('#fecha_inicio').val(fecha_inicio);
                    $('#fecha_fin').val(fecha_fin);
                    $('#organizadores').val(organizadores);

                    $.post("../controlador/eventos.php", {descripcion: descripcion, accion: 'BuscarDatos'}, function(resultado) {
                        var datos = resultado.split(";");
                        $('#lugar').val(datos[0]);
                        $('#estatus').val(datos[1]);

                    });
                });

                $('#limpiar').click(function() {
                    $('input:text').val('');
                    $('textarea').val('');
                    $('#ingresar').text('Guardar');
                });

            });
        </script>
    </head>
    <body>
        <div style="margin-top: 5%;position: relative;display: block">
            <form id="frmeventos">
                <table width="912" border="0" align="center">
                    <tr>
                        <td width="86">Descripci&oacute;n :</td>
                        <td width="332">
                            <div id="div_desc" class="form-group">
                                <textarea style="height: 50px; resize: none !important; background-color: #ffffff;"  name="descripcion" rows="2"  class="form-control input-sm"  id="descripcion"></textarea>
                            </div>
                        </td>
                        <td width="125"><span style="margin-left: 50px;">Lugar:</span></td>
                        <td width="351">
                            <div id="div_desc" class="form-group">
                                <textarea style="height: 50px; resize: none !important; background-color: #ffffff;"  name="lugar" rows="2"  class="form-control input-sm"  id="lugar"></textarea>
                            </div>
                        </td>
                    </tr>
                    <tr>                        
                        <td width="106">Fecha Inicio :</td>
                        <td width="337">
                            <div class="form-group">
                                <input type="text" style="background-color: #ffffff" readonly class="form-control" id="fecha_inicio" name="fecha_inicio" value="" />
                            </div>
                        </td>
                        <td width="119"><span style="margin-left: 50px;">Fecha Fin:</span></td>
                        <td>
                            <div class="form-group">
                                <input type="text" style="background-color: #ffffff" readonly class="form-control" id="fecha_fin" name="fecha_fin" value="" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="86">Organizadores:</td>
                        <td width="332">
                            <div id="div_desc" class="form-group">
                                <textarea style="height: 50px; resize: none !important; background-color: #ffffff;"  name="organizadores" rows="2"  class="form-control input-sm"  id="organizadores"></textarea>
                            </div>
                        </td>
                        <td><span style="margin-left: 50px;">Estatus:</span></td>
                        <td>
                            <select name="estatus" class="form-control" id="estatus">
                                <option value="0">Seleccione</option>
                                <?php
                                for ($i = 0; $i < count($resultado); $i++) {
                                    ?>
                                    <option value="<?php echo $resultado[$i]['id_estatus'] ?>"><?php echo $resultado[$i]['estatus_evento'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
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
                            <table border="0" id="tbl_evento" class="dataTable">
                                <thead>
                                    <tr>
                                        <th>Descripci&oacute;n</th>
                                        <th>Fecha Inicio</th>
                                        <th>Fecha Fin</th>
                                        <th>Organizadores</th>
                                        <th>Acci&oacute;n</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql        = "SELECT
                                                        e.descripcion,
                                                        DATE_FORMAT(e.fecha_inicio,'%d/%m/%Y') AS fecha_inicio,
                                                        DATE_FORMAT(e.fecha_fin, '%d/%m/%Y') AS fecha_fin,
                                                        e.organizadores,
                                                        ev.estatus_evento AS estatus 
                                                      FROM eventos e
                                                      INNER JOIN estatus_evento AS ev ON e.id_estatus = ev.id_estatus";
                                    $resgistros = $obj_conexion->RetornarRegistros($sql);

                                    $es_array = is_array($resgistros) ? TRUE : FALSE;
                                    if ($es_array == TRUE) {
                                        for ($i = 0; $i < count($resgistros); $i++) {
                                            ?>
                                            <tr>
                                                <td><?php echo $resgistros[$i]['descripcion'] ?></td>
                                                <td><?php echo $resgistros[$i]['fecha_inicio'] ?></td>
                                                <td><?php echo $resgistros[$i]['fecha_fin'] ?></td>
                                                <td><?php echo $resgistros[$i]['organizadores'] ?></td>
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
