<?php 
session_start();
$pagina = 'vista/login.php';
if(isset($_SESSION['pagina'])){
    $pagina = $_SESSION['pagina'];
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>WUSHU</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="img/favicon.ico" type="image/jpg" rel="shortcut icon">
        <script type="text/javascript" src="js/jquery-1.11.0.js"></script>
        <style type="text/css">
             iframe {
                width: 100%;
                height: 1250px;;
                overflow: hidden;
                border: none;
                background-color:transparent;
                display:block;
                margin: auto;                
            }
        </style>
    </head>
    <body>
        <iframe  align="middle" src="<?php echo $pagina; ?>" id="ifrmcuerpo" name="ifrmcuerpo"  frameborder="0" scrolling="no"></iframe>
    </body>
</html>
