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
                        {"sClass": "center", "sWidth": "4%"},
                        {"sClass": "center", "sWidth": "30%"},
                        {"sWidth": "15%"},
                        {"sWidth": "15%"},
                        {"sClass": "center", "sWidth": "12%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false}
                    ]
                });

                $('#ingresar').click(function() {
                    var usuario = $('#usuario').val();
                    var clave = $('#clave').val();
                    var accion = $(this).text();

                    $('#accion').val(accion)
                    $.post("../controlador/entrenadores.php", $("#frmentrenadores").serialize(), function(resultado) {
                        if (resultado == 'exito') {
                            alert('Registro con exito');
                            $('input:text').val();
                            $('input:radio#').prop('ckecked', true);
                        } else if (resultado == 'existe') {
                            alert('El entrenador ya esta registrado');
                            $('#d_cedula').addClass('has-error');
                            $('#cedula').focus();
                        }
                    });
                });

                $('table#tbl_entrenadores').on('click', '.modificar', function() {
                    var padre = $(this).closest('tr');
                    var nombre = padre.find('td').eq(0).text();
                    var cedula = padre.find('td').eq(1).text();
                    var sexo = padre.find('td').eq(2).text();
                    var telefono = padre.find('td').eq(3).text();
                    var email = padre.find('td').eq(3).text();
                    $('#nombre').val(nombre);
                    $('#cedula').val(cedula);
                    $('#sexo').val(sexo);
                    $('#telefono').val(telefono);
                    $('#email').val(email);
                    $.post("../controlador/entrenadores.php", {cedula: cedula, accion: 'BuscarDatos'}, function(resultado) {
                        var datos = resultado.split(";");
                        $('#direccion').val(datos[0]);
                        $('#nacionalidad').val(datos[1]);
                        $('#asociacion').val(datos[2]);
                        $('#fecha').val(datos[2]);
                        $('#rif').val(datos[2]);

                        if (datos[3] == 'activo') {
                            $('#activo').prop('checked', true);
                        } else {
                            $('#inactivo').prop('checked', true);
                        }
                    });
                });
            });
        </script>
    </head>
    <body>
        <div style="margin-top: 5%;position: relative;display: block">
            <form id="frmentrenadores">
                <table width="912" border="0" align="center">
                    <tr>
                        <td width="79">Nacionalidad:</td>
                        <td width="351">
                            <select name="asociacion" class="form-control" id="asociacion">
                                <option value="0">Seleccione</option>
                                <option value="1">VENEZOLANO</option>
                                <option value="2">EXTRAJERO</option>
                            </select>
                        </td>
                        <td width="88">&nbsp;&nbsp;&nbsp;C&eacute;dula:</td>
                        <td width="376">
                            <div class="form-group">
                                <input type="text" class="form-control" id="nombre" name="nombre" value="" />
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td width="79">Nombres:</td>
                        <td width="351">
                            <div id="d_cedula" class="form-group">
                                <input type="text" class="form-control" id="cedula" name="cedula" value="" />
                            </div>
                        </td>
                        <td width="88">&nbsp;&nbsp;&nbsp;Rif:</td>
                        <td width="376">
                            <div class="form-group">
                                <input type="text" class="form-control" id="nombre" name="nombre" value="" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="79">Sexo:</td>
                        <td width="351">
                            <div class="form-group">
                                <input type="radio" name="sexo" value="f"   id="f" checked="checked" />Femenino
                                <input type="radio" name="sexo" value="m" id="m" />Masculino
                            </div>
                        </td>
                        <td>&nbsp;&nbsp;&nbsp;Email:</td>
                        <td>
                            <div class="form-group">
                                <input type="text" class="form-control" id="email" name="email" value="" />
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>Tel&eacute;fonos:</td>
                        <td>
                            <div class="form-group">
                                <input type="text" class="form-control" id="telefono" name="telefono" value="" />
                            </div>
                        </td>
                        <td>&nbsp;&nbsp;&nbsp;Asociaci&oacute;n :</td>
                        <td>
                            <select name="asociacion" class="form-control" id="asociacion">
                                <option value="0">Seleccione</option>
                                <option value="1">Aragua</option>
                                <option value="2">Carabobo</option>
                            </select>
                        </td>                        
                    </tr>

                    <tr>
                        <td>Fecha:</td>
                        <td>
                            <div class="form-group">
                                <input type="text" class="form-control" id="fecha" name="fecha" value="" />
                            </div>
                        </td>
                        <td>&nbsp;&nbsp;&nbsp;Estatus:</td>
                        <td>
                            <div class="form-group">
                                <input type="radio" name="estatus" value="activo"   id="activo" checked="checked" />Activo
                                <input type="radio" name="estatus" value="inactivo" id="inactivo" />Inactivo
                            </div>
                        </td>                      
                    </tr>
                    <tr height="60">
                        <td height="68" class="letras">Direcci&oacute;n</td>
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
                            <button type="button" id="olvido" class="btn btn-info">Limpiar</button>
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
                                        <th>tel&eacute;fono</th>
                                        <th>Sexo</th>
                                        <th>Acci&oacute;n</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql          = "SELECT Nacionalidad,Asociacion,Fecha,Estatus,RIF FROM entrenadores";
                                    $resgistros   = $obj_conexion->RetornarRegistros($sql);
                                    for ($i = 0; $i < count($resgistros); $i++) {
                                        ?>
                                        <tr>
                                            <td><?php echo $resgistros[$i]['Nacionalidad'] ?></td>
                                            <td><?php echo $resgistros[$i]['Asociacion'] ?></td>
                                            <td><?php echo $resgistros[$i]['Fecha'] ?></td>
                                            <td><?php echo $resgistros[$i]['RIF'] ?></td>
                                            <td>
                                                <span class="accion modificar">Modificar</span>
                                                <span class="accion eliminar">Eliminar</span>
                                            </td>
                                        </tr>
                                        <?php
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
