<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="author" content="Núria y Óscar">
        <meta name="copyright" content="VIAMPER">
        <link rel="stylesheet" href="CSS/EstiloViamper.css">
        <title>Hazte premium</title>
    </head>
    <body>
    <?php include 'header.php' ?>
        <div class="wrapper">
            <h2 class="titulo">Pásate a premium</h2>
            <form class="formularios registro" method="post" enctype="multipart/form-data">
                <table border="1px" class="premium">
                    <tr>
                        <th>TARIFA MENSUAL</th><th>TARIFA ANUAL</th><th>TARIFA VERANO</th>
                    </tr>
                    <tr>
                        <td>4,99 €</td><td>49,99 €</td><td>12,99 €</td>
                    </tr>
                    <tr>
                        <td>1 mes de ofertas y promociones</td><td>1 año de ofertas y promociones</td><td>3 meses de ofertas y promociones</td>
                    </tr>
                    <tr>
                        <th><input type="submit" name="enviar" id="enviar" value="Contratar" class="boton"></th>
                        <th><input type="submit" name="enviar" id="enviar" value="Contratar" class="boton"></th>
                        <th><input type="submit" name="enviar" id="enviar" value="Contratar" class="boton"></th>
                    </tr>
                </table>
            </form>
        </div>
        <?php include 'footer.php' ?>
    </body>
</html>