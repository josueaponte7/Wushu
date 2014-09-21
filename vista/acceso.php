<?php
session_start();

$usuario_tipo = $_SESSION['tipo_usuario'];
switch ($usuario_tipo) {
    case '1':
        header('Location:menu_tecnico.php');
    break;
    case '2':
        header('Location:menu_admin.php');
    break;
    case '3':
        header('Location:menu_tecnico.php');
    break;
    case '4':
        header('Location:menu_admin.php');
    break;
    case '5':
        header('Location:menu_operador.php');
    break;
}


