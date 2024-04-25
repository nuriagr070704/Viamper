<html>
    <head>
        <meta charset="utf-8"/>
        <meta name="author" content="Nuria y Óscar">
        <meta name="copyright" content="VIAMPER">
        <link rel="stylesheet" href="CSS/EstiloViamper.css" >
        <style>
        .bordes{
            border-top-left-radius: 7px;
            border-top-right-radius: 7px;
            border-bottom-left-radius: 7px;
            border-bottom-right-radius: 7px;
        }
        .margen{
            margin-left: auto;
            margin-right: auto;
            margin-top: 30px;
            background-color: rgb(172, 204, 150);
        }
        #tabla {
            width: 100px;
            margin: 0 auto;
        }
    </style>
        <title>Escoger</title>
    </head>
    <body>
        <?php include 'header.php';
        if (isset($_GET['id']) || isset($_POST["enviar"])) {
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                setcookie('seguro_id', $id, time() + (86400 * 30), '/');
            }
            
            ?>
            <div style="text-align: center; margin-top: 20px;">
                <a href="pagar.php?id=0">No tengo ningún código de oferta</a>
            </div>
            <div class="margen bordes" style="width: 40%;">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="formularios" method="post" enctype="multipart/form-data" style="width: 100%;">
                    <table border="1px" class="bordes" style="padding: 10px;"><tbody>
                        <tr>
                            <td><label for="codigo" id="separacion1">Introduce el código de la oferta:</label></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="codigo" style="width: 100%; border-radius: 15px;" required/></td>
                        </tr>
                        <tr>
                            <td><input type="submit" name="enviar" id="enviar" value="Comprueba la oferta" class="boton"  style="width: 100%; font-weight: bold;"></td>
                        </tr>
                    </tbody></table>
                </form> 
            </div>
            <?php
        } else {
            ?>
            <div class="wrapper formularios registro buscar" style="margin-top: 30px;">
                <h2 class="titulo">Accede a esta pàgina estableciendo el destino y las fechas en la página de inicio.</h2>
                <div style="text-align:center;">
                    <form action="index.php" method="post">
                    <input type="submit" value="Volver al inicio" name="enviar" class="boton" style="font-weight: bold;">
                    </form>
                </div>
            </div>
            <?php
        }
        ?>
        
        <?php 
        if (isset($_POST["enviar"]))
        {
            $codigo = $_POST['codigo'];

            $query_accomodation = "select * from ofertes where codi = '$codigo';";
            $query_result = mysqli_query($connection, $query_accomodation);
            while ($result_formated = mysqli_fetch_row($query_result)){
                ?>
                <div class="margen bordes" style="width: 30%;">
                <a href="pagar.php?id=<?php echo $result_formated[0];?>">
                <table class="bordes" style="padding: 10px;">
                        <tbody>
                            <tr>
                                <th colspan="4"><?php echo $result_formated[1]; ?></th>
                            </tr>
                            <tr>
                                <th>Código</th><td></td><td></td><td><?php echo $result_formated[2]; ?></td>
                            </tr>
                            <tr>
                                <th>Descripción</th><td></td><td></td><td><?php echo $result_formated[3]; ?></td>
                            </tr>
                            <tr>
                                <th>Validez</th><td></td><td></td><td><?php echo $result_formated[5]; ?></td>
                            </tr>
                        </tbody>
                </table>
                </a>
            </div>
                <?php
            }
        }
        include 'footer.php' ?>
    </body>
</html>