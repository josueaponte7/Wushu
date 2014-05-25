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

                var TAsocacion = $('#tbl_asociacion').dataTable({
                    "iDisplayLength": 5,
                    "iDisplayStart": 0,
                    "aLengthMenu": [5, 10, 20, 30, 40, 50],
                    "oLanguage": {"sUrl": "../js/es.txt"},
                    "aoColumns": [
                        {"sClass": "center", "sWidth": "4%"},
                        {"sClass": "center", "sWidth": "30%"},
                        {"sWidth": "15%"},
                        {"sWidth": "15%"},
                        {"sClass": "center","sWidth": "12%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false}
                    ]
                });
                $('#ingresar').click(function() {
                    var usuario = $('#usuario').val();
                    var clave = $('#clave').val();
                    var accion = $(this).text();

                    $('#accion').val(accion)
                    $.post("../controlador/asociaciones.php", $("#frmasociaciones").serialize(), function(resultado) {
                        if (resultado == 'exito') {
                            alert('Registro con exito');
                            $('input:text').val();
                            $('input:radio#').prop('ckecked', true);
                        } else if (resultado == 'existe') {
                            alert('El Nombre de la Asociacion ya esta registrado');
                            $('#d_nombre').addClass('has-error');
                            $('#nombre').focus();
                        }
                    });
                });
               
               $('table#tbl_asociacion').on('click','.modificar',function (){
                  var padre         = $(this).closest('tr');
                  var nombre        = padre.find('td').eq(0).text();
                  var telefono      = padre.find('td').eq(1).text();
                  var representante = padre.find('td').eq(2).text();
                  var tel_rep       = padre.find('td').eq(3).text();
                  $('#nombre').val(nombre); 
                  $('#telefono').val(telefono); 
                  $('#representante').val(representante); 
                  $('#tel_rep').val(tel_rep); 
                  
                  $.post("../controlador/asociaciones.php", {nombre:nombre,accion:'BuscarDatos'}, function(resultado) {
                      var datos = resultado.split(";");
                      $('#email').val(datos[0]);
                      $('#direccion').val(datos[1]);
                      $('#email_rep').val(datos[2]);
                      if(datos[3] == 'activo'){
                          $('#activo').prop('checked',true);
                      }else{
                           $('#inactivo').prop('checked',true);
                      }
                    });
              });
            });
        </script>
    </head>
    <body>
        <div style="margin-top: 5%;position: relative;display: block">
            <form id="frmasociaciones">
                <table width="912" border="0" align="center">
                    <tr>
                        <td width="107">Nombre:</td>
                        <td width="323">
                            <div id="d_nombre" class="form-group">
                                <input type="text" class="form-control" id="nombre" name="nombre" value="" />
                            </div>
                        </td>
                        <td width="115">&nbsp;&nbsp;&nbsp;Tel&eacute;fono:</td>
                        <td width="349">
                            <div class="form-group">
                                <input type="text" class="form-control" id="telefono" name="telefono" value="" />
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
                        <td height="68" class="letras">&nbsp;&nbsp;&nbsp;Direcci&oacute;n</td>
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
                        <td>&nbsp;&nbsp;&nbsp;Tel Represe:</td>
                        <td>
                            <div class="form-group">
                                <input type="text" class="form-control" id="tel_rep" name="tel_rep" value="" />
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
                        <td>&nbsp;&nbsp;&nbsp;Estatus:</td>
                        <td>
                            <div class="form-group">
                                <input type="radio" name="estatus" value="activo"   id="activo" checked="checked" />Activo
                                <input type="radio" name="estatus" value="inactivo" id="inactivo" />Inactivo
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
                            <button type="button" id="olvido" class="btn btn-info">Limpiar</button>
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
                                        <th>Nombre</th>
                                        <th>Tel&eacute;fono</th>
                                        <th>Representante</th>
                                        <th>Tel Representante</th>
                                        <th>Acci&oacute;n</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql          = "SELECT nombre,telefono,representante,tel_rep FROM asociaciones";
                                    $resgistros   = $obj_conexion->RetornarRegistros($sql);
                                    for ($i = 0; $i < count($resgistros); $i++) {
                                        ?>
                                        <tr>
                                            <td><?php echo $resgistros[$i]['nombre'] ?></td>
                                            <td><?php echo $resgistros[$i]['telefono'] ?></td>
                                            <td><?php echo $resgistros[$i]['representante'] ?></td>
                                            <td><?php echo $resgistros[$i]['tel_rep'] ?></td>
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
