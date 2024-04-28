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
            <h2 class="titulo">¡Pásate a premium!</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="formularios registro" method="post" enctype="multipart/form-data">
                <table border="1px" class="premium">
                    <tr>
                        <th>Plan Premium</th>
                    </tr>
                    <tr>
                        <td>49,99 €</td>
                    </tr>
                    <tr>
                        <td>¿Estas listo para 1 año entero de descuentos en TODOS tus viajes?<br>¿Entonces a que estás esperando?</td>
                    </tr>
                    <tr>
                        <?php
                        if (isset($_SESSION['usuario'])) {
                            if ($_SESSION['puesto']=="trabajador") {
                                ?>
                                <td>No puedes solicitar este servicio con una cuenta de trabajador, inicia sesión con una cuenta de cliente.</td>
                                <?php
                            } else {
                                ?>
                                <th><input type="submit" name="enviar" id="enviar" value="¡Contratar plan premium!" class="boton"></th>
                                <?php
                            }
                        } else {
                            ?>
                            <td>Para contratar la oferta primero es necesario que <a href="Iniciosesion.php">inicies sessión</a> o te <a href="Registro.php">registres</a>.</td>
                            <?php
                        }
                        ?>
                        
                    </tr>
                </table>
            </form>
        </div>
        <?php 
        if (isset($_POST["enviar"])) {
            $usuario = $_SESSION['usuario'];
            //comprobar si ya era premium
            $es_premium = false;
            $query = "select * from clients where login = '$usuario';";
            $result_query = mysqli_query($connection, $query);
            try {
                while ($result = mysqli_fetch_row($result_query)){
                    if ($result[9]==3) {
                        $es_premium = true;
                    ?>
                    <div class="wrapper formularios registro buscar" style="margin-top: 30px;">
                        <h2 class="titulo">Parece que ya eras premium.</h2>
                        <div style="text-align:center;">
                        <p>Parece ser que tienes muchas ganas de ser premium, pero tu yo del pasado tuvo la misma idea y ya eres premium.
                            <br>No te preocupes que tu suscripción sigue activa, disfruta comprando con nosotros.</p>
                            <form action="index.php" method="post">
                            <input type="submit" value="Empezar a reservar" name="enviar" class="boton" style="font-weight: bold;">
                            </form>
                        </div>
                    </div>
                    <?php
                    }
                }
            } catch (Exception $ex) { ?>
                <div class="wrapper formularios registro buscar" style="margin-top: 30px;">
                  <h2 class="titulo">Ups. Parece que algo ha ido mal. Intentalo más tarde.</h2>
                  <div style="text-align:center;">
                      <form action="index.php" method="post">
                      <input type="submit" value="Volver al inicio" name="enviar" class="boton" style="font-weight: bold;">
                      </form>
                  </div>
                </div>
            <?php }
            
            if (!$es_premium) {
            $update = "UPDATE `clients` 
            SET `premium`='3' 
            WHERE login = '$usuario';";
            try {
                if (mysqli_query($connection, $update)) {
                    ?>
                    <div class="wrapper formularios registro buscar" style="margin-top: 30px;">
                        <h2 class="titulo">¡Felicidades ahora ya eres premium!</h2>
                        <div style="text-align:center;">
                        <p>A partir de ahora se te aplicaran descuentos en todas tus compras con nosotros.<br>Esperamos que disfrutes planeando tus viajes.</p>
                            <form action="index.php" method="post">
                            <input type="submit" value="Empezar a reservar" name="enviar" class="boton" style="font-weight: bold;">
                            </form>
                        </div>
                    </div>
                    <?php
                }
            } catch (Exception $ex) { ?>
                <div class="wrapper formularios registro buscar" style="margin-top: 30px;">
                  <h2 class="titulo">Ups. Parece que algo ha ido mal. Intentalo más tarde.</h2>
                  <div style="text-align:center;">
                      <form action="index.php" method="post">
                      <input type="submit" value="Volver al inicio" name="enviar" class="boton" style="font-weight: bold;">
                      </form>
                  </div>
                </div>
            <?php }
            }
        }
        
        include 'footer.php'; ?>
    </body>
</html>