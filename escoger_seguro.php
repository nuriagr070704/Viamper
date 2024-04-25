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
            setcookie('coche_id', $id, time() + (86400 * 30), '/');

            function ToSpanishDate($date)
            {
                $timestamp = strtotime($date);
    
                $dia = date('d', $timestamp);
                $mes = date('m', $timestamp);
                $ano = date('Y', $timestamp);
                
                $nueva_fecha = $dia . '-' . $mes . '-' . $ano;
                
                return $nueva_fecha;
            }

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

            $personas = $_COOKIE['personas'];
            $inicio = $_COOKIE['inicio'];
            $final = $_COOKIE['final'];
            $destino = $_COOKIE['destino'];
            $personas = $_COOKIE['personas'];
            $noches = HowManyNights($inicio, $final);

            $query_accomodation = "select * from assegurança where persones = '$personas' and desti = '$destino' and datainici <= '$inicio' and datafi >= '$final';";
            $query_result = mysqli_query($connection, $query_accomodation);
            
            while ($result_formated = mysqli_fetch_row($query_result)){ 
                $precio_seguro = 20 * $personas * $noches;?>
            <div class="margen bordes" style="width: 20%;">
                <a href="escoger_oferta.php?id=<?php echo $result_formated[0];?>">
                <table class="bordes" style="padding: 10px; margin-left: 10%;">
                        <tbody>
                            <tr>
                                <th>Compañía</th><td> --&gt </td><td><?php echo $result_formated[1]; ?></td>
                            </tr>
                            <tr>
                                <th>Destino</th><td> --&gt </td><td><?php echo $result_formated[5]; ?></td>
                            </tr>
                            <tr>
                                <th>Personas</th><td> --&gt </td><td><?php echo $result_formated[6]; ?></td>
                            </tr>
                            <tr>
                                <th>Precio</th><td> --&gt </td><td><?php echo "<strong>$precio_seguro €</strong>";?></td>
                            </tr>
                            <tr>
                                <td colspan="3">Este seguro cubre desde el <?php echo ToSpanishDate($result_formated[3]); ?> hasta el <?php echo ToSpanishDate($result_formated[4]); ?></td>
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