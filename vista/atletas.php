<?php
require_once '../modelo/Conexion.php';
$obj_conexion = new Conexion();
$sql = "SELECT  NRegistro, Nombre FROM asociaciones";
$resultado = $obj_conexion->RetornarRegistros($sql);

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

                var TAatletas = $('#tbl_atletas').dataTable({
                    "iDisplayLength": 5,
                    "iDisplayStart": 0,
                   // "aLengthMenu": [5, 10, 20, 30, 40, 50],00
                    "bLengthChange": false,
                    "oLanguage": {"sUrl": "../js/es.txt"},
                    "aoColumns": [
                        {"sClass": "center", "sWidth": "4%"},
                        {"sClass": "center", "sWidth": "30%"},
                        {"sWidth": "15%"},
                        {"sWidth": "15%"},
                        {"sWidth": "15%"},
                        {"sWidth": "15%"},
                        {"sClass": "center","sWidth": "12%", "bSortable": false,  "bSearchable": false}
                    ]
                });
                $('#ingresar').click(function() {
                    var usuario = $('#usuario').val();
                    var clave = $('#clave').val();
                    var accion = $(this).text();

                    $('#accion').val(accion)
                    $.post("../controlador/atletas.php", $("#frmatletas").serialize(), function(resultado) {
                        if (resultado == 'exito') {
                            alert('Registro con exito');
                            $('input:text').val();
                            $('input:radio#').prop('ckecked', true);
                        } else if (resultado == 'existe') {
                            alert('El Atleta ya esta registrado');
                            $('#d_cedula').addClass('has-error');
                            $('#cedula').focus();
                        }
                    });
                });
               
               $('table#tbl_atletas').on('click','.modificar',function (){
                  var padre        = $(this).closest('tr');
                  var cedula       = padre.find('td').eq(0).text();
                  var nombre       = padre.find('td').eq(1).text();
                  var fecnac       = padre.find('td').eq(2).text();
                 
                  var peso    = padre.find('td').eq(5).text();
                  $('#nombre').val(nombre); 
                  $('#cedula').val(cedula); 
                  $('#fecha').val(fecnac); 
                  $('#direccion').val(direccion); 
                  $('#peso').val(peso); 
                  $.post("../controlador/atletas.php", {nombre:nombre,accion:'BuscarDatos'}, function(resultado) {
                      var datos = resultado.split(";");
                      $('#fechanac').val(datos[0]);
                      $('#sexo').val(datos[1]);
                      $('#email').val(datos[2]);
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
            <form id="frmatletas">
                <table width="912" border="0" align="center">
                    <tr>
                        <td width="105">C&eacute;dula :</td>
                        <td width="349">
                            <div class="form-group">
                                <input type="text" class="form-control" id="cedula" name="cedula" value="" />
                            </div>
                        </td>
                        <td width="107">&nbsp;&nbsp;&nbsp;Nombre:</td>
                        <td width="323">
                            <div id="d_nombre" class="form-group">
                                <input type="text" class="form-control" id="nombre" name="nombre" value="" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="105">Rif :</td>
                        <td width="349">
                            <div class="form-group">
                                <input type="text" class="form-control" id="rif" name="rif" value="" />
                            </div>
                        </td>
                        <td width="107">&nbsp;&nbsp;&nbsp;Pasaporte:</td>
                        <td width="323">
                            <div id="d_nombre" class="form-group">
                                <input type="text" class="form-control" id="pasaporte" name="pasaporte" value="" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="105">FechaNac :</td>
                        <td width="349">
                            <div class="form-group">
                                <input type="text" class="form-control" id="fecha" name="fecha" value="" />
                            </div>
                        </td>
                        <td width="107">&nbsp;&nbsp;&nbsp;Tel&eacute;fono:</td>
                        <td width="323">
                            <div id="d_nombre" class="form-group">
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
                        <td>&nbsp;&nbsp;&nbsp;Ocupaci&oacute;n:</td>
                        <td>
                            <div class="form-group">
                                <input type="text" class="form-control" id="ocupacion" name="ocupacion" value="" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td height="58">Asociaci&oacute;n :</td>
                        <td>
                            <select name="asociacion" class="form-control" id="asociacion">
                                <option value="0">Seleccione</option>
                                <?php 
                                for ($i = 0; $i < count($resultado); $i++) {
                                ?>
                                <option value="1"><?php echo $resultado[$i]['Nombre'] ?> </option>
                                <?php
                                }  
                                ?>
                              
                            </select>
                        </td>   
                        <td>&nbsp;&nbsp;&nbsp;Nivel Acadmco:</td>
                        <td>
                            <select name="asociacion" class="form-control" id="asociacion">
                                <option value="0">Seleccione</option>
                                <option value="1">Bachiler</option>
                                <option value="2">TSU</option>
                            </select>
                        </td> 
                    </tr>
                    
                    <tr>
                        <td height="57">Tipo de Sangre:</td>
                        <td>
                            <select name="asociacion" class="form-control" id="asociacion">
                                <option value="0">Seleccione</option>
                                <option value="1">A</option>
                                <option value="2">B</option>
                                <option value="3">O</option>
                            </select>
                        </td>   
                        <td>&nbsp;&nbsp;&nbsp;Peso Kg:</td>
                        <td>
                            <input type="text" class="form-control" id="peso" name="peso" value="" />
                        </td> 
                    </tr>
                    <tr>
                        <td>Sexo :</td>
                        <td>
                            <div class="form-group">
                                <input type="radio" name="sexo" value="masculuno"   id="masulino" checked="checked" />Masculino
                                <input type="radio" name="sexo" value="fenmenino" id="femenino" />Femenino
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
<!--                    <tr>
                        <td width="105">TalZap:</td>
                        <td width="349">
                            <div class="form-group">
                                <input type="text" class="form-control" id="zapato" name="zapato" value="" />
                            </div>
                        </td>
                        <td width="107">&nbsp;&nbsp;&nbsp;TalPan:</td>
                        <td width="323">
                            <div id="d_nombre" class="form-group">
                                <input type="text" class="form-control" id="pantalon" name="pantalon" value="" />
                            </div>
                        </td>
                    </tr>-->
                    
<!--                    <tr>
                        <td width="105">TalCam:</td>
                        <td width="349">
                            <div class="form-group">
                                <input type="text" class="form-control" id="zapato" name="zapato" value="" />
                            </div>
                        </td>
                        <td width="107">&nbsp;&nbsp;&nbsp;TalPet:</td>
                        <td width="323">
                            <div id="d_nombre" class="form-group">
                                <input type="text" class="form-control" id="pantalon" name="pantalon" value="" />
                            </div>
                        </td>
                    </tr>-->
                    
<!--                    <tr height="60">
                        <td height="68" class="letras">Direcci&oacute;n</td>
                        <td colspan="4">
                            <div class="form-group">
                                <textarea style="resize: none !important; height: 60px;" name="direccion" rows="2"  class="form-control"  id="direccion"></textarea>
                            </div>
                        </td>
                    </tr>
                    <tr height="60">
                        <td height="68" class="letras">Patolog&iacute;as</td>
                        <td colspan="4">
                            <div class="form-group">
                                <textarea style="resize: none !important; height: 60px;" name="patologia" rows="2"  class="form-control"  id="patologia"></textarea>
                            </div>
                        </td>
                    </tr>
                    <tr height="60">
                        <td height="68" class="letras">Alergias</td>
                        <td colspan="4">
                            <div class="form-group">
                                <textarea style="resize: none !important; height: 60px;" name="alergia" rows="2"  class="form-control"  id="alergia"></textarea>
                            </div>
                        </td>
                    </tr>-->
                    
<!--                    <tr>
                        <td>Representante:</td>
                        <td>
                            <div class="form-group">
                                <input type="text" class="form-control" id="Asociacion" name="asociacion" value="" />
                            </div>
                        </td>
                        <td>&nbsp;&nbsp;&nbsp;Nivel Acadmco:</td>
                        <td>
                            <div class="form-group">
                                <input type="text" class="form-control" id="nivelaca" name="nivelaca" value="" />
                            </div>
                        </td>
                    </tr>-->
<!--                    <tr>
                        <td>Ocupaci&oacute;n:</td>
                        <td>
                            <div class="form-group">
                                <input type="text" class="form-control" id="ocupacion" name="ocupacion" value="" />
                            </div>
                        </td>
                        <td>&nbsp;&nbsp;&nbsp;Patolig&iacute;as :</td>
                        <td>
                            <div class="form-group">
                                <input type="text" class="form-control" id="patalogias" name="patologias" value="" />
                            </div>
                        </td>
                        </tr>-->
                    <tr>
                        <td colspan="4" align="center">
                            <input type="hidden" id="accion" name="accion" value=""/>
                            <button type="button" id="ingresar" class="btn btn-info">Registrar</button>
                            <button type="button" id="olvido" class="btn btn-info">Limpiar</button>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" align="center">
                            <table border="0" id="tbl_atletas" class="dataTable">
                                <thead>
                                    <tr>
                                        <th>Cedula</th>
                                        <th>Nombre</th>
                                        <th>FecNac</th>
                                        <th>Sexo</th>
                                        <th>Asociacion</th>
                                        <th>Peso</th>
                                        <th>Acci&oacute;n</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql          = "SELECT Cedula,Nombre,FecNac,Sexo,Asociacion,Peso FROM atletas";
                                    $resgistros   = $obj_conexion->RetornarRegistros($sql);
                                    for ($i = 0; $i < count($resgistros); $i++) {
                                        ?>
                                        <tr>
                                            <td><?php echo $resgistros[$i]['Cedula'] ?></td>
                                            <td><?php echo $resgistros[$i]['Nombre'] ?></td>
                                            <td><?php echo $resgistros[$i]['FecNac'] ?></td>
                                            <td><?php echo $resgistros[$i]['Sexo'] ?></td>
					                        <td><?php echo $resgistros[$i]['Asociacion'] ?></td>
					                        <td><?php echo $resgistros[$i]['Peso'] ?></td>
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
