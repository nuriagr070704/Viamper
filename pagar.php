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
        /* td, tr, table{
            border: solid red;
        } */
    </style>
        <title>Escoger</title>
    </head>
    <body>
        <?php include 'header.php';
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            setcookie('oferta_id', $id, time() + (86400 * 30), '/');
            header($_SERVER['PHP_SELF']);

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
            $is_user_set = false;
            if (isset($_SESSION['usuario'])){
                $usuario = $_SESSION['usuario'];
                $is_user_set = true;
            } else {
                $is_user_set = false;
            }
            
            $alojamiento_id = $_COOKIE['alojamiento_id'];
            $vuelo_ida_id = $_COOKIE['vuelo_ida_id'];
            $vuelo_vuelta_id = $_COOKIE['vuelo_vuelta_id'];
            $coche_id = $_COOKIE['coche_id'];
            $seguro_id = $_COOKIE['seguro_id'];
            $oferta_id = $id;
            $inicio = $_COOKIE['inicio'];
            $final = $_COOKIE['final'];
            $personas = $_COOKIE['personas'];
            $noches = HowManyNights($inicio, $final);

            function ToSpanishDate($date)
            {
                $timestamp = strtotime($date);
    
                $dia = date('d', $timestamp);
                $mes = date('m', $timestamp);
                $ano = date('Y', $timestamp);
                
                $nueva_fecha = $dia . '-' . $mes . '-' . $ano;
                
                return $nueva_fecha;
            }
            //totales de cada cosa
            $precio_allotjament = 0;
            $precio_vol_anada = 0;
            $precio_vol_tornada = 0;
            $precio_coche = 0;
            $precio_seguro = 0;

            $id_allotjament = 0;
            $id_vol_anada = 0;
            $id_vol_tornada = 0;
            $id_ofertes = 0;
            $id_coche = 0;
            $id_seguro = 0;

            $alojamiento_query = "select * from allotjament where ID = '$alojamiento_id';";
            $query_alojamiento = mysqli_query($connection, $alojamiento_query);
            while ($result_alojamiento = mysqli_fetch_row($query_alojamiento)){
                $precio_allotjament = $result_alojamiento[10] * $personas * $noches;
                $id_allotjament = $result_alojamiento[0];
                ?>
            <div class="margen bordes" style="width: 35%;">
            <table class="bordes" style="padding: 10px; margin-left: 10%;">
                <h3>Alojamiento</h3>
                <tbody>
                    <tr>
                        <td rowspan="2"><img class="bordes" src="img/Destinos/<?php echo $result_alojamiento[4]; ?>.jpg" style="max-width: 200px; margin-right: 40px"></td>
                        <td><?php echo $result_alojamiento[1]; ?></td>
                        <td><strong>Total alojamiento</strong></td>
                    </tr>
                    <tr>
                        <td><p>Estrellas: <?php echo $result_alojamiento[2]; ?><br>
                            Ubicación: <?php echo $result_alojamiento[4]; ?>, <?php echo $result_alojamiento[3]; ?><br>
                            Pensión: <?php if ($result_alojamiento[5]) {echo $result_alojamiento[5];} else {echo "Sin pensión";} ?><br>
                            Fecha entrada: <?php echo ToSpanishDate($inicio); ?><br>
                            Fecha salida: <?php echo ToSpanishDate($final); ?><br></p>
                        </td>
                        <td><?php echo "<strong>$precio_allotjament €</strong>";?></td>
                    </tr>
                </tbody>
            </table>
            </div>
                <?php
                $vuelo_ida_query = "select * from vol where IDvol = '$vuelo_ida_id';";
                $query_vuelo_ida = mysqli_query($connection, $vuelo_ida_query);
                while ($result_vuelo_ida = mysqli_fetch_row($query_vuelo_ida)){
                    $precio_vol_anada = 50 * $personas;
                    $id_vol_anada = $result_vuelo_ida[0];
                ?>
                <div class="margen bordes" style="width: 35%;">
                <table class="bordes" style="padding: 10px; margin-left: 10%;">
                <h3>Vuelo de ida</h3>
                    <tbody>
                        <tr>
                            <td>Compañía</td><td><?php echo $result_vuelo_ida[1]; ?></td>
                            <td><strong>Total vuelo ida</strong></td>
                        </tr>
                        <tr>
                            <td>Aeropuerto</td><td><?php echo $result_vuelo_ida[5]; ?></td>
                            <td><?php echo "<strong>$precio_vol_anada €</strong>";?></td>
                        </tr>
                        <tr>
                            <td>Fecha</td><td><?php echo ToSpanishDate($inicio); ?></td>
                        </tr>
                        <tr>
                            <td>Hora de salida</td><td><?php echo $result_vuelo_ida[2]; ?></td>
                        </tr>
                        <tr>
                            <td>Maletas en bodega</td><td><?php echo $result_vuelo_ida[9]; ?></td>
                        </tr>
                    </tbody>
                </table>
                </div>
                    <?php
                    $vuelo_vuelta_query = "select * from vol where IDvol = '$vuelo_vuelta_id';";
                    $query_vuelo_vuelta = mysqli_query($connection, $vuelo_vuelta_query);
                    while ($result_vuelo_vuelta = mysqli_fetch_row($query_vuelo_vuelta)){
                        $precio_vol_tornada = 50 * $personas;
                        $id_vol_tornada = $result_vuelo_vuelta[0];
                        ?>
                    <div class="margen bordes" style="width: 35%;">
                    <table class="bordes" style="padding: 10px; margin-left: 10%;">
                    <h3>Vuelo de vuelta</h3>
                        <tbody>
                            <tr>
                                <td>Compañía</td><td><?php echo $result_vuelo_vuelta[1]; ?></td>
                                <td><strong>Total vuelo vuelta</strong></td>
                            </tr>
                            <tr>
                                <td>Aeropuerto</td><td><?php echo $result_vuelo_vuelta[5]; ?></td>
                                <td><?php echo "<strong>$precio_vol_tornada €</strong>";?></td>
                            </tr>
                            <tr>
                                <td>Fecha</td><td><?php echo ToSpanishDate($final); ?></td>
                            </tr>
                            <tr>
                                <td>Hora de salida</td><td><?php echo $result_vuelo_vuelta[2]; ?></td>
                            </tr>
                            <tr>
                                <td>Maletas en bodega</td><td><?php echo $result_vuelo_vuelta[9]; ?></td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                        <?php
                        $coche_query = "select * from cotxe where ID = '$coche_id';";
                        $query_coche = mysqli_query($connection, $coche_query);
                        while ($result_coche = mysqli_fetch_row($query_coche)){
                            $precio_coche = 12 * $result_coche[6] * $noches;
                            $id_coche = $result_coche[0];
                            ?>
                        <div class="margen bordes" style="width: 35%;">
                        <table class="bordes" style="padding: 10px; width: 100%;">
                        <h3>Vehículo</h3>
                            <tbody>
                            <tr>
                                <td rowspan="2"><img class="bordes" src="img/CochesAlquiler/<?php echo $result_coche[0]; ?>.jpg" style="max-width: 200px; margin-right: 30px"></td>
                                <td></td><td><strong>Total alquiler vehículo</strong></td>
                            </tr>
                            <tr>
                                <td><p>Marca: <?php echo $result_coche[2]; ?><br>
                                    Modelo: <?php echo $result_coche[3]; ?><br>
                                    Asientos: <?php echo $result_coche[5]; ?><br>
                                    Puertas: <?php echo $result_coche[6]; ?><br>
                                    Tipo de marcha: <?php echo $result_coche[7]; ?><br></p>
                                </td>
                                <td><?php echo "<strong>$precio_coche €</strong>";?></td>
                            </tr>
                            </tbody>
                        </table>
                        </div>
                            <?php
                            $seguro_query = "select * from assegurança where ID = '$seguro_id';";
                            $query_seguro = mysqli_query($connection, $seguro_query);
                            while ($result_seguro = mysqli_fetch_row($query_seguro)){
                                $precio_seguro = 20 * $personas * $noches;
                                $id_seguro = $result_seguro[0];
                                ?>
                            <div class="margen bordes" style="width: 35%;">
                            <table class="bordes" style="padding: 10px; margin-left: 10%;">
                            <h3>Seguro</h3>
                                <tbody>
                                    <tr>
                                        <th>Compañía</th><td> --&gt </td><td><?php echo $result_seguro[1]; ?></td>
                                        <td><strong>Total seguro</strong></td>
                                    </tr>
                                    <tr>
                                        <th>Destino</th><td> --&gt </td><td><?php echo $result_seguro[5]; ?></td>
                                        <td><?php echo "<strong>$precio_seguro €</strong>";?></td>
                                    </tr>
                                    <tr>
                                        <th>Personas</th><td> --&gt </td><td><?php echo $result_seguro[6]; ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">Este seguro cubre desde el <?php echo ToSpanishDate($result_seguro[3]); ?> hasta el <?php echo ToSpanishDate($result_seguro[4]); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                                <?php
                                $oferta_query = "select * from ofertes where idofertes = '$oferta_id';";
                                $query_oferta = mysqli_query($connection, $oferta_query);
                                while ($result_oferta = mysqli_fetch_row($query_oferta)){
                                    $id_ofertes = $result_oferta[0];
                                    ?>
                                <div class="margen bordes" style="width: 35%;">
                                <table class="bordes" style="padding: 10px;">
                                <h3>Oferta aplicada</h3>
                                    <tbody>
                                        <tr>
                                            <th colspan="4"><?php echo $result_oferta[1]; ?></th>
                                        </tr>
                                        <tr>
                                            <th>Código</th><td></td><td></td><td><?php echo $result_oferta[2]; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Descripción</th><td></td><td></td><td><?php echo $result_oferta[3]; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Validez</th><td></td><td></td><td><?php echo ToSpanishDate($result_oferta[5]); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                                    <?php
                                }
                            }
                        }
                    }
                }
            }
            $total_viaje = $precio_allotjament + $precio_vol_anada + $precio_vol_tornada + $precio_coche + $precio_seguro;
            $base = $total_viaje-($total_viaje*0.21);
            $cuota = $total_viaje*0.21;
            $base_parsed = str_replace(".", ",", $base);
            $cuota_parsed = str_replace(".", ",", $cuota);
            
            $id_client = 0;
            if ($is_user_set){
            $query_id_client = "select * from clients where login = '$usuario';";
            $result_query_id_client = mysqli_query($connection, $query_id_client);
            while ($resultado_consulta = mysqli_fetch_row($result_query_id_client)){
                $id_client = $resultado_consulta[0];
            }
            }

            $id_viatge = 0;
            $query_id_viatge = "select * from viatge where idviatge = (select max(idviatge) from viatge);";
            $result_query_id_viatge = mysqli_query($connection, $query_id_viatge);
            while ($resultado_consulta_viatge = mysqli_fetch_row($result_query_id_viatge)){
                $id_viatge = $resultado_consulta_viatge[0];
            }
            ?>
            <div class="margen bordes" style="width: 40%;">
                <form action="comprado.php" class="formularios" method="post" enctype="multipart/form-data">
                <input type="hidden" name="data_inici" value="<?php echo "$inicio"; ?>"/>
                <input type="hidden" name="data_fi" value="<?php echo "$final"; ?>"/>
                <input type="hidden" name="id_allotjament" value="<?php echo "$id_allotjament"; ?>"/>
                <input type="hidden" name="id_vol_anada" value="<?php echo "$id_vol_anada"; ?>"/>
                <input type="hidden" name="id_vol_tornada" value="<?php echo "$id_vol_tornada"; ?>"/>
                <input type="hidden" name="id_cotxe" value="<?php echo "$id_coche"; ?>"/>
                <input type="hidden" name="id_oferta" value="<?php echo "$id_ofertes"; ?>"/>
                <?php if ($id_client != 0)
                { ?>
                    <input type="hidden" name="id_client" value="<?php echo "$id_client"; ?>"/>
                <?php } ?>
                <input type="hidden" name="preu_viatge" value="<?php echo "$total_viaje"; ?>"/>
                <input type="hidden" name="id_assegurança" value="<?php echo "$id_seguro"; ?>"/>
                <input type="hidden" name="preu_assegurança" value="<?php echo "$precio_seguro"; ?>"/>
                <input type="hidden" name="seguent_id_viatge" value="<?php echo "$id_viatge"; ?>"/>
                    <table class="bordes" style="padding: 10px; width: 66%"><tbody>
                        <tr>
                            <td>Base</td><td>%</td><td>Cuota</td>
                        </tr>
                        <tr>
                            <td><?php echo $base_parsed; ?></td><td>21,00</td><td><?php echo $cuota_parsed; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Total viaje: </strong></td><td><strong><?php echo "$total_viaje €"; ?></strong></td>
                        </tr>
                        <tr>
                            <td colspan="3">
                            <?php
                            if (isset($_SESSION['usuario'])) { ?>
                                <input type="submit" name="enviar" id="enviar" value="Comprar viaje" class="boton"  style="width: 100%; font-weight: bold;">
                            <?php } else { ?>
                                <p>Antes de comprar <a href="Iniciosesion.php">inicia sesión</a> o <a href="Registro.php">registrate</a></p>
                            <?php } ?>
                            </td>
                        </tr>
                    </tbody></table>
                </form>
            </div>
            
            <?php
        } ?>
    </body>
    <?php include 'footer.php'; ?>
</html>