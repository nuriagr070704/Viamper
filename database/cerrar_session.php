<?php
    session_start();
    session_destroy();
    // Eliminar la cookie si está presente
    if (isset($_COOKIE['usuario'])) {
        setcookie('usuario', '', time() - 3600, '/'); // Establece la cookie en el pasado para borrarla
    }
    header("Location: ../index.php");

?>