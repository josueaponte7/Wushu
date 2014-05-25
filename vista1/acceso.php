<?php
session_start();

$usuario_tipo = $_SESSION['tipo_usuario'];
switch ($usuario_tipo) {
    case 'ADMIN':
        header('Location:menu_admin.php');
    break;
    case 'SUPERADMINISTRADOR':
        header('Location:menu_superadmin.php');
    break;
    case 'TECNICO':
        header('Location:menu_tecnico.php');
    break;
    case 'OPERADOR':
        header('Location:menu_operador.php');
    break;
}


