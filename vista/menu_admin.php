<?php
session_start();
$usuario = $_SESSION['usuario'];
$_SESSION['pagina'] = 'vista/menu_admin.php';

$archivo = '';
$titulo = "SIFEVE-WUSHU";
if (isset($_SESSION['archivo'])) {
    $archivo = $_SESSION['archivo'];
}
if(isset($_SESSION['titulo'])){
    $titulo = $_SESSION['titulo'];
}
?>
<!doctype html>
<html>
    <head>
        <!-- Load jQuery from Google's CDN -->
        <script src="../js/jquery-1.11.0.js"></script>
        <link href="../css/menu.css" rel="stylesheet" media="screen"/>
        <link href="../css/maquetacion.css" rel="stylesheet" media="screen"/>
        <script type="text/javascript" src="../js/menu.js"></script>
        <style type="text/css">
            iframe {
                width: 100%;
                height: 4800px;
                overflow: hidden;
                border: none;
                background-color:transparent;
                display:block;
                margin: auto;                
            }
        </style>
        <script>
            $(document).ready(function() {
                var archivo = '<?php echo $archivo; ?>';
                $('#ifrmcuerpo').attr('src', archivo);
                $('ul.nav li ul li a').click(function(e) {
                    var archivo = $(this).attr('href');
                    var titulo = $(this).text();
                    var id = $(this).attr('id');
                    e.preventDefault();
                    if(id == 'ra'){
                        var url = archivo;
                        window.open(url);
                    }else{
                        $('#divTituloContenido').text('Agregar Registros de ' + titulo);
                        
                        $('#ifrmcuerpo').attr('src', archivo);
                        //$('#cuerpo').css({'height': height});
                        //$( "#cuerpo" ).load( archivo );
                    }
                });
                                
            });
        </script>
    <body>
        <div id="container">            
            <div id="header"></div>
            <div class="navigation">
                <ul class="nav">
                    <li>
                        <a href="#">REGISTROS</a>
                        <ul>
                            <li><a href="asociaciones.php">ASOCIACIONES</a></li>
                            <li><a href="entrenadores.php">ENTRENADORES</a></li>
                            <li><a href="modalidades.php">MODALIDADES</a></li>
                            <li><a href="categorias.php">CATEGORIAS</a></li>
                            <li><a href="atletas.php">ATLETAS</a></li>
                            <li><a style="height:32px" href="representante.php">REPRESENTANTE ASOCIACI&Oacute;N</a></li>

                        </ul>
                    </li>
                    <li>
                        <a href="#">ACTIVIDADES</a>
                        <ul>
                            <li><a href="eventos.php">EVENTOS</a></li>
                            <li><a href="inscripcion.php">INSCRIPCIONES</a></li>
                            <li><a href="#">PREMIACI&Oacute;N</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">REPORTES</a>
                        <ul>
                            <li><a id="ra" href="reportes/reporte_asociaciones.php">ASOCIACIONES</a></li>
                            <li><a id="ra" href="reportes/reporte_entrenadores.php">ENTRENADORES</a></li>
                            <li><a id="ra" href="reportes/reporte_modalidades.php">MODALIDADES</a></li>
                            <li><a id="ra" href="reportes/reporte_categorias.php">CATEGORIAS</a></li>
                            <li><a id="ra" href="reportes/reporte_atletas.php">ATLETAS</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">CONFIGURACI&Oacute;N</a>
                        <ul>
                            <li><a href="menu.php">MEN&Uacute;</a></li>
                            <li><a href="sub_menu.php">SUB_MEN&Uacute;</a></li>
                            <li><a href="usuario.php">USUARIOS</a></li>
                            <li><a href="tipo_usuario.php">TIPO USUARIOS</a></li>
                            <li><a href="#">AUDITORIA</a></li>
                            <li><a href="#">CAMBIAR CLAVE</a></li>
                            <li><a href="#">AYUDA</a></li>                            
                        </ul>                         
                    </li>
                    <li>
                        <a href="#">MANTENIMIENTO</a>
                        <ul>
                            <li><a href="nivel.php">NIVEL</a></li>
                            <li><a href="estilo.php">ESTILO</a></li>
                            <li><a href="tecnica.php">T&Eacute;CNICA</a></li>
                            <li><a href="region.php">REGI&Oacute;N</a></li>  
                            <li><a href="estado.php">ESTADO</a></li> 
                            <li><a href="kilogramo.php">KILOGRAMO</a></li> 
                            <li><a href="codigo_area.php">C&Oacute;DIGO DE AREA</a></li> 
                        </ul>                         
                    </li>
                    <li style="background: #EFEFEF;">
                        <a href="salir.php" style="float: right">SALIR</a>
                    </li>
                    
                </ul>                
            </div>

            <div id="conten">
                <div id="sidebar">
                    <div id="divTitMiniBloque1" class="divTitMiniBloque">Sistema</div>
                    <img style="width:130px; height:90px;margin-left: 50px;margin-top: 150px;"   src="../img/logoinicio.png" alt="logoinicio"/>
                    <div style="font-size: 27px;font-weight: bold;margin-top: 25px;padding: 15px; text-align: center">
                        Federaci&oacute;n Venezolana de WUSHU
                    </div>
                    <div id="divTitMiniBloque1" class="divTitMiniBloque" style="margin-top: 613px;margin-left: 5px;">Usuario:<?php echo $usuario; ?></div>
                </div>
                <div id="cuerpo">
                    <div id="divTituloContenido" class="divTituloContenido"><?php echo $titulo; ?></div>
                    <iframe  align="middle" id="ifrmcuerpo" name="ifrmcuerpo"  frameborder="0" scrolling="no"></iframe>

                </div>

            </div>
            <div id="divPie" class="divPie">Federaci&oacute;n Venezolana de WUSHU v1.0 @ 2014</div>
        </div>
    </body>
</html>