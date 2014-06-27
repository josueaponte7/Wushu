<?php
session_start();
require_once '../modelo/Conexion.php';
$obj_conexion = new Conexion();

$sql       = "SELECT  id_asociacion, nombre FROM asociaciones";
$resultado = $obj_conexion->RetornarRegistros($sql);

$codigo = "SELECT  id,  codigo FROM codigo_telefono";
$resulcod = $obj_conexion->RetornarRegistros($codigo);

$archivo_actual = basename($_SERVER['PHP_SELF']);
$_SESSION['archivo'] =  $archivo_actual;
$_SESSION['titulo'] = 'Agregar Registros de ENTRENADORES';
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

                var TAentrenadores = $('#tbl_entrenadores').dataTable({
                    "iDisplayLength": 5,
                    "iDisplayStart": 0,
                    "aLengthMenu": [5, 10, 20, 30, 40, 50],
                    "oLanguage": {"sUrl": "../js/es.txt"},
                    "aoColumns": [
                        {"sClass": "center", "sWidth": "8%"},
                        {"sClass": "center", "sWidth": "30%"},
                        {"sWidth": "15%"},
                        {"sWidth": "15%"},
                        {"sClass": "center", "sWidth": "12%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false}
                    ]
                });

                var letra = ' abcdefghijklmnñopqrstuvwxyzáéíóú';
                $('#nombre').validar(letra);

                var numero = '0123456789';
                $('#cedula').validar(numero);

                var numero = '0123456789-ve';
                $('#rif').validar(numero);

                var numero = '0123456789-';
                $('#telefono').validar(numero);

                /****Calendario*****/
                $('#fecha').datepicker({
                    language: "es",
                    format: 'dd/mm/yyyy',
                    startDate: "-75y",
                    endDate: "-15y",
                    autoclose: true
                });

                $('#ingresar').click(function() {

                    var accion = $(this).text();
                    $('#accion').val(accion)
                    $('#cedula').prop('disabled', false);
                    if (accion == 'Registrar') {
                        $.post("../controlador/entrenadores.php", $("#frmentrenadores").serialize(), function(resultado) {
                            if (resultado == 'exito') {
                                alert('Registro con exito');
                                $('input:text').val();
                                $('input:radio').prop('ckecked', true);

                                var sexo = $('input:radio[name="sexo"]:checked').val();
                                var modificar = '<span class="accion modificar">Modificar</span>';
                                var eliminar = '<span class="accion eliminar">Eliminar</span>';
                                var accion = modificar + '&nbsp;' + eliminar
                                TAentrenadores.fnAddData([$('#cedula').val(), $('#nombre').val(), $('#telefono').val(), sexo, accion]);
                                $('input:text').val('');
                                $('textarea').val('');
                                $('select').val('0');

                            } else if (resultado == 'existe') {
                                alert('El Entrenador ya esta registrado');
                                $('#d_cedula').addClass('has-error');
                                $('#cedula').focus();
                            }
                        });
                    } else {
                        var r = confirm("\u00BFDesea Modificar el Registro?");
                        var fila = $("#fila").val();
                        if (r == true) {
                            var sexo = $('input:radio[name="sexo"]:checked').val();
                            $.post("../controlador/entrenadores.php", $("#frmentrenadores").serialize(), function(resultado) {
                                if (resultado == 'exito') {
                                    alert('Modificaci\u00f3n  con exito');

                                    $("#tbl_entrenadores tbody tr:eq(" + fila + ")").find("td").eq(0).html($('#cedula').val());
                                    $("#tbl_entrenadores tbody tr:eq(" + fila + ")").find("td").eq(1).html($('#nombre').val());
                                    $("#tbl_entrenadores tbody tr:eq(" + fila + ")").find("td").eq(2).html($('#telefono').val());
                                    $("#tbl_entrenadores tbody tr:eq(" + fila + ")").find("td").eq(3).html(sexo);
                                    $('input:text').val('');
                                    $('textarea').val('');
                                    $('select').val('0');
                                    $('#ingresar').text('Registrar');
                                }
                            });
                        }
                    }
                });
                $('table#tbl_entrenadores').on('click', '.modificar', function() {

                    $('#fila').remove();
                    var padre = $(this).closest('tr');
                    var cedula = padre.find('td').eq(0).text();
                    var nombre = padre.find('td').eq(1).text();
                    var telefono = padre.find('td').eq(2).text();
                    var sexo = padre.find('td').eq(3).text();

                    // obtener la fila a modificar
                    var fila = padre.index();
                    
                    // crear el campo fila y añadir la fila
                    var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
                    $($fila).prependTo($('#frmentrenadores'));

                    $('#ingresar').text('Modificar');

                    $('#cedula').val(cedula).prop('disabled', true);
                    $('#nombre').val(nombre);
                    $('#telefono').val(telefono);
                    $('input:radio[name="sexo"][value="' + sexo + '"]').prop('checked', true);

                    $.post("../controlador/entrenadores.php", {cedula: cedula, accion: 'BuscarDatos'}, function(resultado) {
                        var datos = resultado.split(";");
                        $('#nacionalidad').val(datos[0]);
                        $('#rif').val(datos[1]);
                        $('#email').val(datos[2]);
                        $('#asociacion').val(datos[3]);
                        $('#fecha').val(datos[4]);
                        $('input:radio[name="estatus"][value="' + datos[5] + '"]').prop('checked', true);
                        $('#direccion').val(datos[6]);
                    });
                });

                $('#limpiar').click(function() {
                    $('#cedula').prop('disabled', false);
                    $('input:text').val('');
                    $('textarea').val('');
                    $('select').val('0');
                    $('#ingresar').text('Registrar');
                });

            });

        </script>
    </head>
    <body>
        <div style="margin-top: 5%;position: relative;display: block">
            <form id="frmentrenadores">
                <table width="912" border="0" align="center">
                    <tr>
                        <td>Nacionalidad:</td>
                        <td width="351">
                            <select name="nacionalidad" class="form-control" id="nacionalidad">
                                <option value="0">Seleccione</option>
                                <option value="V">VENEZOLANO</option>
                                <option value="E">EXTRAJERO</option>
                            </select>
                        </td>
                        <td width="88"><span style="margin-left: 35px;">C&eacute;dula:</span></td>
                        <td width="376">
                            <div class="form-group">
                                <input type="text" style="background-color: #ffffff"  class="form-control" id="cedula" name="cedula" value="" maxlength="8" />
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>Nombres:</td>
                        <td width="376">
                            <div class="form-group">
                                <input type="text" class="form-control" id="nombre" name="nombre" value="" />
                            </div>
                        </td>
                        <td width="79"><span style="margin-left: 35px;">Sexo:</span></td>
                        <td width="351">
                            <div class="form-group">
                                <input type="radio" name="sexo" value="Masculino"   id="sexo" checked="checked" />Masculino
                                <input type="radio" name="sexo" value="Femenino" id="sexo" />Femenino
                            </div>
                        </td>                        
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td width="351">
                            <div class="form-group">
                                <input type="text" class="form-control" id="email" name="email" value="" />
                            </div>
                        </td>
                        <td width="115"><span style="margin-left: 35px;">Tel&eacute;fono:</span></td>
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
                        <td>Asociaci&oacute;n:</td>
                        <td>
                            <select name="asociacion" class="form-control" id="asociacion">
                                <option value="0">Seleccione</option>
                                <?php
                                for ($i = 0; $i < count($resultado); $i++) {
                                    ?>
                                    <option value="<?php echo $resultado[$i]['id_asociacion'] ?>"><?php echo $resultado[$i]['nombre'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </td> 
                        <td><span style="margin-left: 35px;">Fecha Nac:</span></td>
                        <td>
                            <div class="form-group">
                                <input type="text" style="background-color: #ffffff" readonly class="form-control" id="fecha" name="fecha" value="" />
                            </div>
                        </td>                        
                    </tr>

                    <tr>
                        <td>Estatus:</td>
                        <td width="337">
                            <div class="form-group">
                                <input type="radio" name="estatus" value="activo"   id="estatus" checked="checked" />Activo
                                <input type="radio" name="estatus" value="inactivo" id="estatus" />Inactivo
                            </div>
                        </td>                                           
                    </tr>
                    <tr height="60">
                        <td>Direcci&oacute;n:</td>
                        <td colspan="4">
                            <div class="form-group">
                                <textarea style="resize: none !important;" name="direccion" rows="2"  class="form-control"  id="direccion"></textarea>
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
                            <table border="0" id="tbl_entrenadores" class="dataTable">
                                <thead>
                                    <tr>
                                        <th>C&eacute;dula</th>
                                        <th>Nombre</th>
                                        <th>Tel&eacute;fono</th>
                                        <th>Sexo</th>
                                        <th>Acci&oacute;n</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql        = "SELECT CONCAT_WS('-', nacionalidad, cedula) AS cedula, 
                                                                          nombre, 
                                                                          telefono,
                                                                          sexo
                                                                 FROM entrenadores;";
                                    $resgistros = $obj_conexion->RetornarRegistros($sql);

                                    $es_array = is_array($resgistros) ? TRUE : FALSE;
                                    if ($es_array == TRUE) {
                                        for ($i = 0; $i < count($resgistros); $i++) {
                                            ?>
                                            <tr>
                                                <td><?php echo $resgistros[$i]['cedula'] ?></td>
                                                <td><?php echo $resgistros[$i]['nombre'] ?></td>
                                                <td><?php echo $resgistros[$i]['telefono'] ?></td>
                                                <td><?php echo $resgistros[$i]['sexo'] ?></td>
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
