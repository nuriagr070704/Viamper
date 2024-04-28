<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="author" content="Núria y Óscar">
        <meta name="copyright" content="VIAMPER">
        <link rel="stylesheet" href="CSS/EstiloViamper.css">
        <title>Contacta'ns</title>
    </head>
    <body>
    <?php include 'header.php' ?>
        <div>
            <div class="wrapper">
                <h2 style="text-align: center;">Contacta amb nosaltres</h2>
                <form action="enviar.php" class="formularios registro" method="post" enctype="multipart/form-data">
                    <table style="margin: auto; width: 100%; text-align: center;">
                        <tr>
                            <td><label for="nombre" id="separacion1">Nombre*</label></td>
                            <td><label for="correo" id="separacion1">Correo electrónico*</label></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="nombre" style="border-radius: 15px; width: 80%;" required/></td><td><input type="email" name="correo" style="border-radius: 15px; width: 80%;" required/></td>
                        </tr>
                        <tr>
                            <td colspan="2"><label for="motivo" id="separacion1">Dinos en que podemos ayudarte*</label></td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="text" name="motivo" style="height: 100px; width: 100%; border-radius: 15px;" required/></td>
                        </tr>
                    </table>
                    <table style="margin: auto; width: 100%;">
                        <tr>
                            <td colspan="2"><input type="checkbox" name="rgpd" id="rgpd" class="boton"><label>Acepto la <a href="Privacidad.php">Política de privacidad</a> y <a href="Cookies.php">Cookies</a>.</label></td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="submit" name="enviar" id="enviar" value="Regístrate" class="boton" style="text-align: center; width: 100%"></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
        <?php include 'footer.php' ?>
    </body>
</html>