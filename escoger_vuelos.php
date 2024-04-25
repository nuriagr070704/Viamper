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
            setcookie('alojamiento_id', $id, time() + (86400 * 30), '/');

            function ToSpanishDate($date)
            {
                $timestamp = strtotime($date);
    
                $dia = date('d', $timestamp);
                $mes = date('m', $timestamp);
                $ano = date('Y', $timestamp);
                
                $nueva_fecha = $dia . '-' . $mes . '-' . $ano;
                
                return $nueva_fecha;
            }

            $origen = $_COOKIE['origen'];
            $destino = $_COOKIE['destino'];
            $personas = $_COOKIE['personas'];

            $query_accomodation = "select * from vol where origen = '$origen' and desti = '$destino';";
            $query_result = mysqli_query($connection, $query_accomodation);
            
            while ($result_formated = mysqli_fetch_row($query_result)){ 
                $precio_vol_tornada = 50 * $personas;?>
            <div class="margen bordes" style="width: 35%;">
                <a href="escoger_vuelo_vuelta.php?id=<?php echo $result_formated[0];?>">
                <table class="bordes" style="padding: 10px; margin-left: 10%;">
                        <tbody>
                            <tr>
                                <th>Compañía</th><td><?php echo $result_formated[1]; ?></td>
                                <td><strong>Precio vuelo</strong></td>
                            </tr>
                            <tr>
                                <th>Aeropuerto</th><td><?php echo $result_formated[5]; ?></td>
                                <td><?php echo "<strong>$precio_vol_tornada €</strong>";?></td>
                            </tr>
                            <tr>
                                <th>Hora de salida</th><td><?php echo $result_formated[2]; ?></td>
                            </tr>
                            <tr>
                                <th>Maletas en bodega</th><td><?php echo $result_formated[9]; ?></td>
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