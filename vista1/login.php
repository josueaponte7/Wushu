<!DOCTYPE html>
<html>
    <head>
        <title>WUSHU</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../css/bootstrap.css" rel="stylesheet" media="screen"/>
        <script type="text/javascript" src="../js/jquery-1.11.0.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#ingresar').click(function() {
                    var usuario = $('#usuario').val();
                    var clave = $('#clave').val();
                    $.post("../controlador/login.php", $("#frmlogin").serialize(),function(resultado) {
                        if(resultado == 'acceder'){
                            window.location = 'acceso.php';
                        }else{
                            alert('Usuario o Clave Incorrectos');
                            $('input:text,input:password').val('');
                        }
                    });
                })
            })
        </script>
    </head>
    <body>
        <div style="margin-top: 5%;position: relative;display: block">
            <form id="frmlogin">
                <table width="424" border="0" align="center">
                    <tr>
                        <td width="66">Usuario:</td>
                        <td width="348">
                            <div class="form-group">
                                <input type="text" class="form-control" id="usuario" name="usuario" value="" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Clave:</td>
                        <td>
                            <div class="form-group">
                                <input type="password" class="form-control" id="clave" name="clave" value="" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <button type="button" id="ingresar" class="btn btn-info">Ingresar</button>
                            <button type="button" id="olvido" class="btn btn-info">¿Olvido su Clave?</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>
