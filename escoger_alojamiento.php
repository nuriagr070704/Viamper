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
        if (isset($_POST['enviar'])) {
            $origin = $_POST['origen'];
            $destination = $_POST['destino'];
            $start = $_POST['inicio'];
            $end = $_POST['final'];
            $person = $_POST['personas'];
            setcookie('origen', $origin, time() + (86400 * 30), '/');
            setcookie('destino', $destination, time() + (86400 * 30), '/');
            setcookie('inicio', $start, time() + (86400 * 30), '/');
            setcookie('final', $end, time() + (86400 * 30), '/');
            setcookie('personas', $person, time() + (86400 * 30), '/');

            function HowManyNights($fechaInicio, $fechaFin) {
                // Convertir las fechas a objetos DateTime
                $inicio = new DateTime($fechaInicio);
                $fin = new DateTime($fechaFin);

                // Calcular la diferencia en días
                $diferencia = $inicio->diff($fin);

                // Obtener el total de noches
                $totalNoches = $diferencia->days - 1;

                return $totalNoches;
            }

            $noches = HowManyNights($start, $end);

            $query_accomodation = "select * from allotjament where ciutat = '$destination';";
            $query_result = mysqli_query($connection, $query_accomodation);
            
            while ($result_formated = mysqli_fetch_row($query_result)){
                $precio_allotjament = $result_formated[10] * $person * $noches; ?>
            <div class="margen bordes" style="width: 40%;">
                <a href="escoger_vuelos.php?id=<?php echo $result_formated[0];?>">
                <table class="bordes" style="padding: 10px; margin-left: 10%;">
                        <tbody>
                            <tr>
                                <td rowspan="2"><img class="bordes" src="img/Destinos/<?php echo $result_formated[4]; ?>.jpg" style="max-width: 200px; margin-right: 40px"></td>
                                <td><?php echo $result_formated[1]; ?></td>
                                <td><strong>Total alojamiento</strong></td>
                            </tr>
                            <tr>
                                <td><p>Estrellas: <?php echo $result_formated[2]; ?><br>
                                    Ubicación: <?php echo $result_formated[4]; ?>, <?php echo $result_formated[3]; ?><br>
                                    Pensión: <?php if ($result_formated[5]) {echo $result_formated[5];} else {echo "Sin pensión";} ?><br></p>
                                </td>
                                <td><?php echo "<strong>$precio_allotjament €</strong>";?></td>
                            </tr>
                        </tbody>
                </table>
                </a>
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