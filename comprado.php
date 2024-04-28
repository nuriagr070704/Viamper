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
        <title>Comprado</title>
    </head>
    <body>
    <?php
    include 'header.php';
    if (isset($_POST['enviar'])) {
        $data_inici = $_POST['data_inici'];
        $data_fi = $_POST['data_fi'];
        
        $id_client = $_POST['id_client'];
        $id_allotjament = $_POST['id_allotjament'];
        $id_vol_anada = $_POST['id_vol_anada'];
        $id_vol_tornada = $_POST['id_vol_tornada'];
        $id_ofertes = $_POST['id_oferta'];
        $id_coche = $_POST['id_cotxe'];
        $id_seguro = $_POST['id_assegurança'];

        $preu_assegurança = $_POST['preu_assegurança'];
        $preu_viatge = $_POST['preu_viatge'];

        $id_viatge =  $_POST['seguent_id_viatge'];
        $id_viatge++;

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
            $totalNoches = $diferencia->days;

            return $totalNoches;
        }

        $personas = $_COOKIE['personas'];
        $noches = HowManyNights($data_inici, $data_fi);
        $error = false;

        //guardar viaje en viatge
        if ($id_ofertes=='0') {
            //$query_id_viatge = "insert into viatge values ($id_viatge, '$data_inici', '$data_fi', $preu_viatge, $id_client, 1, $id_allotjament, $id_vol_anada, $id_vol_tornada, 'NULL', $id_coche);";
            $query_id_viatge = "INSERT INTO `viatge`(`idviatge`, `datainici`, `datafi`, `preu`, `clients_UID`, `treballadors_UID`, `allotjament_ID`, `vol_IDvol`, `vol_tornada`, `ofertes_idofertes`, `cotxe_ID`) 
            VALUES ($id_viatge, '$data_inici', '$data_fi', $preu_viatge, $id_client, 1, $id_allotjament, $id_vol_anada, $id_vol_tornada, NULL, $id_coche)";
        } else {
            $query_id_viatge = "insert into viatge values ($id_viatge, '$data_inici', '$data_fi', $preu_viatge, $id_client, 1, $id_allotjament, $id_vol_anada, $id_vol_tornada, $id_ofertes, $id_coche);";
        }
        try {
            $result_query_id_viatge = mysqli_query($connection, $query_id_viatge);
        } catch (Exception $ex) { 
            $error = true; ?>
            <div class="wrapper formularios registro buscar" style="margin-top: 30px;">
              <h2 class="titulo">Ups. Parece que no hemos podido reservar tu viaje.</h2>
              <div style="text-align:center;">
                  <form action="index.php" method="post">
                  <input type="submit" value="Volver al inicio" name="enviar" class="boton" style="font-weight: bold;">
                  </form>
              </div>
            </div>
        <?php }

        //guardar seguro en assegurança_has_clients
        $query_id_assegurança = "insert into assegurança_has_clients values ($id_seguro, $id_client, $preu_assegurança, $id_allotjament, $id_vol_anada, $id_vol_tornada, $id_coche);";
        try {
            $result_query_id_assegurança = mysqli_query($connection, $query_id_assegurança);
        } catch (Exception $ex) { 
            $error = true; ?>
            <div class="wrapper formularios registro buscar" style="margin-top: 30px;">
              <h2 class="titulo">Ups. El seguro que has elegido ya lo has elegido antes. Asegurate de elegir otro al volver a reservar</h2>
              <div style="text-align:center;">
                  <form action="index.php" method="post">
                  <input type="submit" value="Volver al inicio" name="enviar" class="boton" style="font-weight: bold;">
                  </form>
              </div>
            </div>
        <?php }
        
        if (!$error) {
        ?>
        <div class="margen bordes" style="width: 35%;">
            <table class="bordes" style="padding: 10px; margin-left: 10%;">
                <h3 style="text-align: center;">¡¡¡FELICIDADES!!!</h3>
                <tbody>
                    <tr>
                        <td>¡Ya hemos preparado tu reserva!</td>
                    </tr>
                    <tr>
                        <td>Puedes ver los detalles de tu viaje más abajo o en tu perfil.</td>
                    </tr>
                </tbody>
            </table>
            </div>
        <?php
        $alojamiento_query = "select * from allotjament where ID = '$id_allotjament';";
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
                            Fecha entrada: <?php echo ToSpanishDate($data_inici); ?><br>
                            Fecha salida: <?php echo ToSpanishDate($data_fi); ?><br></p>
                        </td>
                        <td><?php echo "<strong>$precio_allotjament €</strong>";?></td>
                    </tr>
                </tbody>
            </table>
            </div>
                <?php
                $vuelo_ida_query = "select * from vol where IDvol = '$id_vol_anada';";
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
                            <td>Fecha</td><td><?php echo ToSpanishDate($data_inici); ?></td>
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
                    $vuelo_vuelta_query = "select * from vol where IDvol = '$id_vol_tornada';";
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
                                <td>Fecha</td><td><?php echo ToSpanishDate($data_fi); ?></td>
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
                        $coche_query = "select * from cotxe where ID = '$id_coche';";
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
                            $seguro_query = "select * from assegurança where ID = '$id_seguro';";
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
                                $oferta_query = "select * from ofertes where idofertes = '$id_ofertes';";
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
            $usuario = $_SESSION['usuario'];
            $nombre = "";
            $correo = "";
            $oferta = "";
            $codigo = "";
            $query_usuario = mysqli_query($connection, "select * from clients where login = '$usuario';");
            while ($result_usuario_query = mysqli_fetch_row($query_usuario)){
                $query_ofertes = mysqli_query($connection, "select * from ofertes where idofertes = 1;");
                while ($result_ofertes_query = mysqli_fetch_row($query_ofertes)){
            ?>
            <div class="wrapper formularios registro buscar" style="margin-top: 30px;">
            <h2 class="titulo">Un regalito de nuestra parte</h2>
            <form action="enviar_oferta.php" name="enviar_oferta" method="post" enctype="multipart/form-data">
                <input type="hidden" name="nombre" value="<?php echo $result_usuario_query[4].", ".$result_usuario_query[5] ?>"/>
                <input type="hidden" name="correo" value="<?php echo $result_usuario_query[7] ?>"/>
                <input type="hidden" name="oferta" value="<?php echo $result_ofertes_query[1] ?>"/>
                <input type="hidden" name="codigo" value="<?php echo $result_ofertes_query[2] ?>"/>
                <table align="center" style="text-align: center;" cellpadding=10>
                    <tr>
                        <td>Por esta última compra te regalamos un código de descuento para asegurarnos de que haya una siguiente.</td>
                    </tr>
                    <tr>
                        <td><input type="submit" name="enviar" value="Conseguir una oferta" class="boton"/></td>
                    </tr>
                </table>
            </form>
                </div>
            <?php
            }}}
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
    include 'footer.php' ?>
    </body>
</html>