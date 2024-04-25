<?php
session_start();

// Variable para indicar si el usuario ha iniciado sesión
$usuario_iniciado = false;
if (isset($_COOKIE['usuario'])) {
    // El usuario tiene cookies, iniciar sesión automáticamente
    $_SESSION['usuario'] = $_COOKIE['usuario'];
}
// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['usuario'])) {
    $usuario_iniciado = true;
}
?>
