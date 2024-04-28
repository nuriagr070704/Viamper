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
    </style>
        <title>Escoger</title>
    </head>
    <body>
        <?php include 'header.php';
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            setcookie('vuelo_vuelta_id', $id, time() + (86400 * 30), '/');

            function HowManyNights($fechaInicio, $fechaFin) {
                // Convertir las fechas a objetos DateTime
                $inicio = new DateTime($fechaInicio);
                $fin = new DateTime($fechaFin);

                // Calcular la diferencia en días
                $diferencia = $inicio->diff($fin);

                // Obtener el total de noches
                $totalNoches = $diferencia->days;

                return $totalNoches;
            }

            $personas = $_COOKIE['personas'];
            $inicio = $_COOKIE['inicio'];
            $final = $_COOKIE['final'];
            $noches = HowManyNights($inicio, $final);

            $query_accomodation = "select * from cotxe where seients >= '$personas';";
            $query_result = mysqli_query($connection, $query_accomodation);
            $contador = 0;
            while ($result_formated = mysqli_fetch_row($query_result)){ 
                $precio_coche = 12 * $result_formated[6] * $noches;
                $contador++; ?>
            <div class="margen bordes" style="width: 50%;">
                <a href="escoger_seguro.php?id=<?php echo $result_formated[0];?>">
                <table class="bordes" style="padding: 10px; width: 100%;">
                        <tbody>
                        <tr>
                            <td rowspan="2"><img class="bordes" src="img/CochesAlquiler/<?php echo $result_formated[0]; ?>.jpg" style="max-width: 200px; margin-right: 10px"></td>
                            <td></td><td><strong>Precio vehículo</strong></td>
                        </tr>
                        <tr>
                            <td><p>Marca: <?php echo $result_formated[2]; ?><br>
                                Modelo: <?php echo $result_formated[3]; ?><br>
                                Asientos: <?php echo $result_formated[5]; ?><br>
                                Puertas: <?php echo $result_formated[6]; ?><br>
                                Tipo de marcha: <?php echo $result_formated[7]; ?><br></p>
                            </td>
                            <td><?php echo "<strong>$precio_coche €</strong>";?></td>
                        </tr>
                        </tbody>
                </table>
                </a>
            </div>
            <?php }
            if ($contador==0) { ?>
            <div class="wrapper formularios registro buscar" style="margin-top: 30px;">
                <h2 class="titulo">Vaya, parece que no tenemos vehículos disponibles.</h2>
                <div style="text-align:center;">
                    <p>Sentimos que no tengamos vehículos.<br>Puedes volver a intentarlo más tarde.</p>
                    <form action="index.php" method="post">
                    <input type="submit" value="Volver al inicio" name="enviar" class="boton" style="font-weight: bold;">
                    </form>
                </div>
            </div>
            <?php }
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
        
        <?php include 'footer.php' ?>
    </body>
</html>