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

                var TAcategorias = $('#tbl_categoria').dataTable({
                    "iDisplayLength": 5,
                    "iDisplayStart": 0,
                    "aLengthMenu": [5, 10, 20, 30, 40, 50],
                    "oLanguage": {"sUrl": "../js/es.txt"},
                    "aoColumns": [
                        {"sClass": "center", "sWidth": "4%"},
                        {"sClass": "center", "sWidth": "30%"},
                        {"sWidth": "15%"},
                        {"sWidth": "15%"},
                        {"sWidth": "12%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false}
                    ]
                });
                $('#ingresar').click(function() {
                    var usuario = $('#usuario').val();
                    var clave = $('#clave').val();
                    var accion = $(this).text();

                    $('#accion').val(accion)
                    $.post("../controlador/categorias.php", $("#frmcategorias").serialize(), function(resultado) {
                        if (resultado == 'exito') {
                            alert('Registro con exito');
                            $('input:text').val();
                            $('input:radio#').prop('ckecked', true);
                        } else if (resultado == 'existe') {
                            alert('El Nombre de la Categoria ya esta registrado');
                            $('#d_nombre').addClass('has-error');
                            $('#nombre').focus();
                        }
                    });
                });
               
               $('table#tbl_categorias').on('click','.modificar',function (){
                  var padre         = $(this).closest('tr');
                  var descripcion        = padre.find('td').eq(0).text();
                  var edad      = padre.find('td').eq(1).text();
                  var genero = padre.find('td').eq(2).text();
                  var modalidad       = padre.find('td').eq(3).text();
                  $('#descripcion').val(nombre); 
                  $('#edad').val(telefono); 
                  $('#genero').val(representante); 
                  $('#modalidad').val(tel_rep); 
                  
                  $.post("../controlador/categorias.php", {nombre:nombre,accion:'BuscarDatos'}, function(resultado) {
                      var datos = resultado.split(";");
                      $('#estilo').val(datos[0]);
                      $('#region').val(datos[1]);
                      $('#tecnica').val(datos[2]);
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
            <form id="frmcategorias">
                <table width="912" border="0" align="center">
                    <tr>
                        <td width="86">Descripci&oacute;n :</td>
                        <td width="332">
                            <div id="div_desc" class="form-group">
                                        <textarea style="height: 50px; resize: none !important;"  name="descripcion" rows="2"  class="form-control input-sm"  id="descripcion"></textarea>
                                    </div>
                        </td>
                        <td width="125">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Edad:</td>
                        <td width="351">
                            <div class="form-group">
                                <input type="text" class="form-control" id="genero" name="genero" value="" />
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td width="86">Genero:</td>
                        <td width="332">
                            <div class="form-group">
                                <input type="radio" name="sexo" value="f"   id="f" checked="checked" />Femenino
                                <input type="radio" name="sexo" value="m" id="m" />Masculino
                            </div>
                        </td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Modlidad:</td>
                        <td>
                            <div class="form-group">
                                <select name="modalidad" class="form-control" id="modalidad">
                                <option value="0">Seleccione</option>
                                <option value="1">COMBATE</option>
                                <option value="2">TAOLU</option>
                            </select>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>Estilo :</td>
                        <td>
                            <div class="form-group">
                                <select name="estilo" class="form-control" id="estilo">
                                <option value="0">Seleccione</option>
                                <option value="1">MODERNO</option>
                                <option value="2">TRADICIONAL</option>
                            </select>
                            </div>
                        </td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Regi&oacute;n :</td>
                        <td>
                            <div class="form-group">
                                <select name="region" class="form-control" id="region">
                                <option value="0">Seleccione</option>
                                <option value="1">NORTE</option>
                                <option value="2">SUR</option>
                            </select>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>T&eacute;cnica :</td>
                        <td>
                            <div class="form-group">
                                <select name="tecnica" class="form-control" id="tecnica">
                                <option value="0">Seleccione</option>
                                <option value="1">ARMA CORTA</option>
                                <option value="2">ARMA LARGA</option>
                                <option value="3">MANOS LIBRES</option>
                            </select>
                            </div>
                        </td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Estatus:</td>
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
                            <table border="0" id="tbl_categoria" class="dataTable">
                                <thead>
                                    <tr>
                                        <th>Descripci&oacute;n</th>
                                        <th>Edad</th>
                                        <th>Genero</th>
                                        <th>Estilo</th>
                                        <th>region</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql          = "SELECT  Estilo,Region,Tecnica,Estatus FROM categorias";
                                    $resgistros   = $obj_conexion->RetornarRegistros($sql);
                                    for ($i = 0; $i < count($resgistros); $i++) {
                                        ?>
                                        <tr>
                                            <td><?php echo $resgistros[$i]['Estilo'] ?></td>
                                            <td><?php echo $resgistros[$i]['Region'] ?></td>
                                            <td><?php echo $resgistros[$i]['Tecnica'] ?></td>
                                            <td><?php echo $resgistros[$i]['Estatus'] ?></td>
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
