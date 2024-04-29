<!DOCTYPE html>
<html lang="es">
    <head>
    <meta charset="UTF-8"/>
    <meta name="author" content="Núria y Óscar">
    <meta name="copyright" content="VIAMPER">
    <link rel="stylesheet" href="CSS/EstiloViamper.css">
    <title>Inicio sesión</title>
</head>
<body>
    <?php include 'header.php' ?>
    <div class="wrapper">
        <h2 class="titulo titulo_ini">Iniciar sesión</h2>
        <form action="database/estadologin.php/" method="post" enctype="multipart/form-data"  class="registro formularios cuadro" accept-charset="UTF-8">
            <div class="titulo">
            <?php
            if(isset($_SESSION['error'])) {
            echo "<p> " . $_SESSION['error'] . "</p>";
            unset($_SESSION['error']); // Borra el error par poder ser usado por otros errores
            }
            ?>
                <label for="correo_usuario" id="separacion1">Correo electrónico o usuario</label>
                <br>
                <input type="text" name="correo_usuario" id="correo" required>
                <br>
                <label for="contrasenya" id="separacion1">Contraseña</label>
                <br>
                <input type="password" name="contrasenya" id="contrasenya" required>
                <br>
                <label for="recordarme" id="separacion1">Recordarme</label>
                <br>
                <input type="checkbox" name="recordarme"> 
                <br><input type="submit" name="enviar" id="enviar" value="Inicia sesión" class="boton">
                <br>
                <p><a href="Registro.php">Si no tienes usuario registrate.</a></p>           
            </div>
        </form>
    </div>
    <?php include 'footer.php' ?>
</body>
</html>