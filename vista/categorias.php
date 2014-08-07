<?php
session_start();
require_once '../modelo/Conexion.php';
$obj_conexion = new Conexion();


$sql     = "SELECT  num_registro,  descripcion FROM modalidades";
$estilo  = "SELECT  id_estilo,  nombre_estilo FROM estilo";
$region  = "SELECT  id_region,  nombre_region FROM region ";
$tecnica = "SELECT  id_tecnica,  nombre_tecnica FROM tecnica ";

$resultado = $obj_conexion->RetornarRegistros($sql);
$result    = $obj_conexion->RetornarRegistros($estilo);
$resul     = $obj_conexion->RetornarRegistros($region);
$resultec  = $obj_conexion->RetornarRegistros($tecnica);

$archivo_actual      = basename($_SERVER['PHP_SELF']);
$_SESSION['archivo'] = $archivo_actual;
$_SESSION['titulo']  = 'Agregar Registros de CATEGORIAS';
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
        <link href="../css/maquetacion.css" rel="stylesheet" media="screen"/>

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

                var TAcategorias = $('#tbl_categoria').dataTable({
                    "iDisplayLength": 5,
                    "iDisplayStart": 0,
                    "aLengthMenu": [5, 10, 20, 30, 40, 50],
                    "oLanguage": {"sUrl": "../js/es.txt"},
                    "aoColumns": [
                        {"sClass": "center", "sWidth": "4%", "bSortable": false, "bSearchable": false},
                        {"sClass": "center", "sWidth": "25%"},
                        {"sClass": "center", "sWidth": "10%"},
                        {"sWidth": "15%"},
                        {"sWidth": "15%"},
                        {"sClass": "center", "sWidth": "18%", "bSortable": false, "bSearchable": false}
                    ]
                });

//                var letra = ' abcdefghijklmnñopqrstuvwxyzáéíóú';
//                $('#descripcion').validar(letra);

                var numero = '0123456789-';
                $('#edad').validar(numero);

                $('#ingresar').click(function() {
                    $('#num_registro').remove();
                    var accion = $(this).text();
                    $('#accion').val(accion)
                    $('#descripcion').prop('disabled', false);

                    if (accion == 'Registrar') {
                        // obtener el ultimo codigo del status 
                        var codigo = 1;
                        var TotalRow = TAcategorias.fnGetData().length;
                        if (TotalRow > 0) {
                            var lastRow = TAcategorias.fnGetData(TotalRow - 1);
                            var codigo = parseInt(lastRow[0]) + 1;
                        }

                        var $num_registro = '<input type="hidden" id="num_registro"  value="' + codigo + '" name="num_registro">';
                        $($num_registro).prependTo($('#frmcategorias'));

                        $.post("../controlador/categorias.php", $("#frmcategorias").serialize(), function(resultado) {
                            if (resultado == 'exito') {
                                alert('Registro con exito');
                                $('input:text').val();
                                $('input:radio').prop('ckecked', true);

                                var sexo = $('input:radio[name="sexo"]:checked').val();
                                var estilo = $('#estilo').find('option:selected').text();
                                var region = $('#region').find('option:selected').text();

                                var modificar = '<span class="accion modificar">Modificar</span>';
                                var eliminar = '<span class="accion eliminar">Eliminar</span>';
                                var accion = modificar + '&nbsp;' + eliminar
                                TAcategorias.fnAddData([codigo, $('#descripcion').val(), $('#edad').val(), sexo, estilo, region, accion]);
                                $('input:text').val('');
                                $('textarea').val('');
                                $('select').val('0');

                            } else if (resultado == 'existe') {
                                alert('La Categoria ya esta registrada');
                                $('#d_descripcion').addClass('has-error');
                                $('#descripcion').focus();
                            }
                        });
                    } else {
                        var r = confirm("\u00BFDesea Modificar el Registro?");
                        var fila = $("#fila").val();
                        if (r == true) {
                            var sexo = $('input:radio[name="sexo"]:checked').val();
                            var estilo = $('#estilo').find('option:selected').text();
                            var region = $('#region').find('option:selected').text();

                            $.post("../controlador/categorias.php", $("#frmcategorias").serialize(), function(resultado) {
                                if (resultado == 'exito') {
                                    alert('Modificaci\u00f3n  con exito');

                                    $("#tbl_categoria tbody tr:eq(" + fila + ")").find("td").eq(1).html($('#descripcion').val());
                                    $("#tbl_categoria tbody tr:eq(" + fila + ")").find("td").eq(2).html($('#edad').val());
                                    $("#tbl_categoria tbody tr:eq(" + fila + ")").find("td").eq(3).html(sexo);
                                    $("#tbl_categoria tbody tr:eq(" + fila + ")").find("td").eq(4).html(estilo);
                                    $("#tbl_categoria tbody tr:eq(" + fila + ")").find("td").eq(5).html(region);

                                    $('input:text').val('');
                                    $('textarea').val('');
                                    $('select').val('0');
                                    $('#ingresar').text('Registrar');
                                }
                            });
                        }
                    }
                });

                $('table#tbl_categoria').on('click', '.modificar', function() {
                    $('#num_registro').remove();

                    $('#fila').remove();
                    var padre = $(this).closest('tr');
                    var num_registro = padre.find('td').eq(0).text();
//                    var edad = padre.find('td').eq(1).text();
//                    var sexo = padre.find('td').eq(2).text();
//                    var estilo = padre.find('td').eq(3).text();
//                    var region = padre.find('td').eq(4).text();

                    // obtener la fila a modificar
                    var fila = padre.index();

                    // crear el campo fila y añadir la fila
                    var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
                    $($fila).prependTo($('#frmcategorias'));

                    var $num_registro = '<input type="hidden" id="num_registro"  value="' + num_registro + '" name="num_registro">';
                    $($num_registro).appendTo($('#frmcategorias'));

                    $('#ingresar').text('Modificar');

                    $.post("../controlador/categorias.php", {num_registro: num_registro, accion: 'BuscarDatos'}, function(resultado) {
                        var datos = resultado.split(";");
                        $('#descripcion').val(datos[0]);
                        $('#edad').val(datos[1]);
                        $('input:radio[name="sexo"][value="' + datos[2] + '"]').prop('checked', true);
                        $('#modalidad').val(datos[3]);
                        $('#estilo').val(datos[4]);
                        $('#region').val(datos[5]);
                        $('#tecnica').val(datos[6]);
                        $('input:radio[name="estatus"][value="' + datos[7] + '"]').prop('checked', true);
                        
                        // crear el campo fila y añadir la fila
                    var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
                    $($fila).prependTo($('#frmcategorias'));

                    var $num_registro = '<input type="hidden" id="num_registro"  value="' + num_registro + '" name="num_registro">';
                    $($num_registro).appendTo($('#frmcategorias'));
                    
                    });
                });

                $('#limpiar').click(function() {
                    $('#descripcion').prop('disabled', false);
                    $('input:text').val('');
                    $('textarea').val('');
                    $('select').val('0');
                    $('#ingresar').text('Registrar');
                });

            });
        </script>
    </head>
    <body>
        <!--<div id="divTitMiniBloque1" class="divTitMiniBloque" style="margin-top:10px; margin-left: 18px; height: 20px;">Principal</div>-->
        <div style="margin-top: 5%;position: relative;display: block">            
            <form id="frmcategorias">
                <table width="912" border="0" align="center">
                    <tr>
                        <td width="86">Categorias :</td>
                        <td width="332">
                            <div id="div_desc" class="form-group">
                                <textarea style="height: 50px; resize: none !important; background-color: #ffffff;"  name="descripcion" rows="2"  class="form-control input-sm"  id="descripcion"></textarea>
                            </div>
                        </td>
                        <td width="125"><span style="margin-left: 58px;">Edad:</span></td>
                        <td width="351">
                            <div class="form-group">
                                <input type="text" class="form-control" id="edad" name="edad" value="" maxlength="5"/>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td width="86">Genero:</td>
                        <td width="332">
                            <div class="form-group">
                                <input type="radio" name="sexo" value="Masculino"   id="sexo" checked="checked" />Masculino
                                <input type="radio" name="sexo" value="Femenino" id="sexo" />Femenino
                            </div>
                        </td>
                        <td><span style="margin-left: 58px;">Modlidad:</span></td>
                        <td>
                            <div class="form-group">
                                <select name="modalidad" class="form-control" id="modalidad">
                                    <option value="0">Seleccione</option>
                                    <?php
                                    for ($i = 0; $i < count($resultado); $i++) {
                                        ?>
                                        <option value="<?php echo $resultado[$i]['num_registro']; ?>"><?php echo $resultado[$i]['descripcion']; ?></option>
                                        <?php
                                    }
                                    ?>
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
                                    <?php
                                    for ($i = 0; $i < count($result); $i++) {
                                        ?>
                                        <option value="<?php echo $result[$i]['id_estilo']; ?>"><?php echo $result[$i]['nombre_estilo']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </td>
                        <td><span style="margin-left: 58px;">T&eacute;cnica:</span></td>
                        <td>
                            <div class="form-group">
                                <select name="tecnica" class="form-control" id="tecnica">
                                    <option value="0">Seleccione</option>
                                    <?php
                                    for ($i = 0; $i < count($resultec); $i++) {
                                        ?>
                                        <option value="<?php echo $resultec[$i]['id_tecnica']; ?>"><?php echo $resultec[$i]['nombre_tecnica']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
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
                            <table border="0" id="tbl_categoria" class="dataTable">
                                <thead>
                                    <tr>
                                        <th>C&oacute;digo</th>
                                        <th>Categorias</th>
                                        <th>Edad</th>
                                        <th>Genero</th>
                                        <th>Estilo</th>
                                        <th>Acci&oacute;n</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql        = "SELECT  
                                                    ca.num_registro,
                                                    ca.descripcion,  
                                                    ca.edad,  
                                                    ca.sexo,
                                                    es.nombre_estilo AS estilo
                                                    FROM categorias ca
                                                    INNER JOIN estilo AS es ON ca.id_estilo = es.id_estilo
                                                    INNER JOIN region AS re ON ca.id_region = re.id_region";
                                    $resgistros = $obj_conexion->RetornarRegistros($sql);

                                    $es_array = is_array($resgistros) ? TRUE : FALSE;
                                    if ($es_array == TRUE) {
                                        for ($i = 0; $i < count($resgistros); $i++) {
                                            ?>
                                            <tr>
                                                <td><?php echo $resgistros[$i]['num_registro'] ?></td>
                                                <td><?php echo $resgistros[$i]['descripcion'] ?></td>
                                                <td><?php echo $resgistros[$i]['edad'] ?></td>
                                                <td><?php echo $resgistros[$i]['sexo'] ?></td>
                                                <td><?php echo $resgistros[$i]['estilo'] ?></td>
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
