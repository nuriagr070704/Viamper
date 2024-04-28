<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="author" content="Núria y Óscar">
        <meta name="copyright" content="VIAMPER">
        <link rel="stylesheet" href="CSS/EstiloViamper.css">
        <title>Usuario</title>
        <style>
            table { 
                border-spacing: 5px;
                border-collapse: separate;
            }
            td { 
                padding: 5px;
            }
        </style>
    </head>
    <body>
    <?php include 'header.php';
    if (isset($_SESSION['puesto'])) {
    if ($_SESSION['puesto']=="cliente") {
    $usuario = $_SESSION['usuario'];

    function cambiar_formato_hora($hora) {
        // Dividir la cadena en horas, minutos y segundos
        $partes = explode(":", $hora);
        
        // Tomar solo las horas y los minutos
        $horas = $partes[0];
        $minutos = $partes[1];
        
        // Crear la nueva cadena de hora en el formato hh:mm
        $nueva_hora = $horas . ":" . $minutos;
        
        return $nueva_hora;
    }

    function ToSpanishDate($date)
    {
        $timestamp = strtotime($date);

        $dia = date('d', $timestamp);
        $mes = date('m', $timestamp);
        $ano = date('Y', $timestamp);
        
        $nueva_fecha = $dia . '-' . $mes . '-' . $ano;
        
        return $nueva_fecha;
    }

    function quitarDecimales($numero) {
        return number_format((float)$numero, 2, '.', '');
    }

    $query_user = "select * from clients where login = '$usuario';";
    $query_result = mysqli_query($connection, $query_user);
    $usuario_id = "";
    $old_user = '';
    $old_email = '';

    while ($result_formated = mysqli_fetch_row($query_result)){
    $usuario_id = $result_formated[0];
    $old_user = $result_formated[1];
    $old_email = $result_formated[7];
    ?>
        <div class="wrapper">
            <h2 style="text-align: center;">Cambiar datos</h2>
            <form class="formularios registro" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
                <table align="center">
                <tr>
                    <td><label for="nombre" id="separacion1">Nombre</label></td>
                    <td><label for="apellidos" id="separacion1">Apellidos</label></td>
                </tr>
                <tr>
                    <td><input type="text" name="nombre" id="nombre" value="<?php echo $result_formated[4] ?>"></td>
                    <td><input type="text" name="apellidos" id="apellidos" value="<?php echo $result_formated[5] ?>"></td>
                </tr>
                <tr>
                    <td><label for="movil" id="separacion1">Teléfono móvil</label></td>
                    <td><label for="correo" id="separacion1">Correo</label></td>
                </tr>
                <tr>
                    <td><input type="text" name="movil" id="movil" value="<?php echo $result_formated[6] ?>"></td>
                    <td><input type="text" name="correo" id="correo" value="<?php echo $result_formated[7] ?>"></td>
                </tr>
                <tr>
                    <td><label for="login" id="separacion1">Usuario</label></td>
                    <td><label for="password" id="separacion1">Nova contrasenya</label></td>
                </tr>
                <tr>
                    <td><input type="text" name="login" id="login" value="<?php echo $result_formated[1] ?>"></td>
                    <td><input type="password" name="password" id="password" value="<?php echo $result_formated[2] ?>"></td>
                </tr>
                <tr>
                    <td><label for="dni" id="separacion1">DNI</label></td>
                    <td><label for="banca" id="separacion1">Cuenta bancaria</label></td>
                </tr>
                <tr>
                    <td><input type="text" name="dni" id="dni" value="<?php echo $result_formated[3] ?>"></td>
                    <td><input type="text" name="banca" id="banca" value="<?php echo $result_formated[8] ?>"></td>
                </tr>
                <?php
                if ($result_formated[9] == '3') { ?>
                <tr>
                    <td><label for="premium" id="separacion1">Premium</label></td>
                    <td><input type="checkbox" name="premium" id="premium" checked="checked"></td>
                </tr>
                <tr>
                    <td colspan="2">*Si desmarcas la casilla tendrás que volver a pagar por el premium.</td>
                </tr>
                <?php } ?>
                <tr>
                    <td colspan="2"><input type="submit" name="enviar" id="enviar" value="Guardar" class="boton" style="width: 100%; font-weight: bold;"></td>
                </tr>
                </table>
            </form>
        </div>
        <h2 style="text-align: center;">Tus viajes</h2>
    <?php }
    
    $query_viatge = "select * from viatge where clients_UID = $usuario_id;";
    $viatge_result = mysqli_query($connection, $query_viatge);
    $contador = 0;
    while ($result_viatge = mysqli_fetch_row($viatge_result)){
        $id_allotjament = $result_viatge[6];
        $id_vol_anada = $result_viatge[7];
        $id_vol_tornada = $result_viatge[8];
        $id_cotxe = $result_viatge[10];
        $precio = $result_viatge[3];
        $allotjament_result = mysqli_query($connection, "select * from allotjament where ID = $id_allotjament");
        while ($result_viatge = mysqli_fetch_row($allotjament_result)){
            $vol_anada = mysqli_query($connection, "select * from vol where IDvol = $id_vol_anada");
            while ($result_vol_anada = mysqli_fetch_row($vol_anada)) {
                $vol_tornada = mysqli_query($connection, "select * from vol where IDvol = $id_vol_tornada");
                while($result_vol_tornada = mysqli_fetch_row($vol_tornada)){
                    $cotxe_result = mysqli_query($connection, "select * from cotxe where ID = $id_cotxe");
                    while($result_cotxe = mysqli_fetch_row($cotxe_result)) {
                        $contador++;
                    
    ?>
        
        <div class="puntitos">
            <h4 style="margin-left: 15px;"><?php echo "Viaje a ".$result_viatge[4] ?>, <?php echo $result_viatge[3] ?></h4>
            <h5 style="margin-left: 30px;">Total viaje: <?php echo $precio." €" ?></h5>
            <table cellspacing="5">
                <tr>
                    <th>Alojamiento</th><th>Vol anada</th><th>Vol tornada</th><th>Vehicle</th>
                </tr>
                <tr>
                    <td><?php echo $result_viatge[1] ?></td><td>Aeropuerto: <?php echo $result_vol_anada[5] ?></td><td>Aeropuerto: <?php echo $result_vol_tornada[5] ?></td><td>Marca: <?php echo $result_cotxe[2] ?></td>
                </tr>
                <tr>
                    <td>Pensión <?php echo $result_viatge[5] ?></td><td>Compañía: <?php echo $result_vol_anada[1] ?></td><td>Compañía: <?php echo $result_vol_tornada[1] ?></td><td>Modelo: <?php echo $result_cotxe[3] ?></td>
                </tr>
                <tr>
                    <td>Check-in: <?php echo cambiar_formato_hora($result_viatge[6]) ?></td><td>Hora: <?php echo $result_vol_anada[2] ?></td><td>Hora: <?php echo $result_vol_tornada[2] ?></td><td>Asientos: <?php echo $result_cotxe[5] ?></td>
                </tr>
                <tr>
                    <td>Check-out: <?php echo cambiar_formato_hora($result_viatge[7]) ?></td><td>Puerta: <?php echo $result_vol_anada[4] ?></td><td>Puerta: <?php echo $result_vol_tornada[4] ?></td><td>Puertas: <?php echo $result_cotxe[6] ?></td>
                </tr>
                <tr>
                    <td></td><td>Número vuelo: <?php echo $result_vol_anada[3] ?></td><td>Número vuelo: <?php echo $result_vol_tornada[3] ?></td><td>Tipo de marcha: <?php echo $result_cotxe[7] ?></td>
                </tr>
            </table>
        </div>
    <?php
    }}}}}
    if ($contador == 0) {
        ?>
        <div class="wrapper formularios registro buscar" style="margin-top: 30px;">
            <h2 class="titulo">Uy, no puede ser. No tienes ningún viaje reservado con nosotros.</h2>
            <div style="text-align:center;">
                <form action="index.php" method="post">
                <input type="submit" value="¡Haz que eso cambie!" name="enviar" class="boton" style="font-weight: bold;">
                </form>
            </div>
        </div>
        <?php
    }
    ?>
    <h2 style="text-align: center;">Tus seguros</h2>
    <div class="puntitos">
    <?php
    $query_contratado = "select * from assegurança_has_clients where clients_UID = $usuario_id;";
    $contratado_result = mysqli_query($connection, $query_contratado);
    $contador = 0;
    while ($result_contratado = mysqli_fetch_row($contratado_result)){
        $seguro_id = $result_contratado[0];
        $query_seguro = "select * from assegurança where ID = $seguro_id;";
        $seguro_result = mysqli_query($connection, $query_seguro);
        while ($result_seguro = mysqli_fetch_row($seguro_result)){
            $contador++;
            ?>
            <table align="center" cellspacing="5">
                <tr>
                    <th>Seguro para tu viaje a <?php echo $result_seguro[5]; ?></th>
                </tr>
                <tr>
                    <td>Compañía: <?php echo $result_seguro[1] ?></td>
                </tr>
                <tr>
                    <td>Fecha de inicio: <?php echo ToSpanishDate($result_seguro[3]) ?></td>
                </tr>
                <tr>
                    <td>Fecha de fin: <?php echo ToSpanishDate($result_seguro[4]) ?></td>
                </tr>
                <tr>
                    <td>Destino: <?php echo $result_seguro[5] ?></td>
                </tr>
                <tr>
                    <td>Personas: <?php echo $result_seguro[6] ?></td>
                </tr>
                <tr>
                    <th>Total seguro: <?php echo quitarDecimales($result_contratado[2])." €"; ?></th>
                </tr>
            </table>
            <?php
        }
    }
    ?>
    </div>
    <?php 
    if (isset($_POST['enviar']))
    {
        $login = $_POST['login'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $dni = $_POST['dni'];
        $name = $_POST['nombre'];
        $surname = $_POST['apellidos'];
        $phone = $_POST['movil'];
        $email = $_POST['correo'];
        $bank = $_POST['banca'];
        $premium = $_POST['premium'];

        //comprobar que no hay un usuario con los mismos datos
        $posible_user_array = '';
        $posible_worker_array = '';
        if ($old_user != $login || $old_email != $email) {
            $query_check = "select * from clients where login = '$login' or correu = '$email' and UID = $usuario_id;";
            $posible_user = mysqli_query($connection, $query_check);
            $posible_user_array = mysqli_fetch_row($posible_user);

            $query_check_workers = "select * from treballadors where login = '$login' or correu = '$email';";
            $posible_worker = mysqli_query($connection, $query_check_workers);
            $posible_worker_array = mysqli_fetch_row($posible_worker);
        }

        if ($posible_user_array != null || $posible_worker_array != null)
        {
            $repeated_user = true;
        }
        else
        {
            $repeated_user = false;
            $update = "update clients
            set login = '$login', claupas = '$password', DNINIE = '$dni', nom = '$name', cognoms = '$surname', telefon = $phone, correu = '$email', comptebancari = '$bank', premium = '$premium'
            where UID = '$usuario_id';";
            try
            {
                if (mysqli_query($connection, $update))
                {
                    echo "<script>window.location.replace('Usuario.php');</script>";
                }
            }
            catch (Exception $exception)
            {
                $error_user_creation = true;
            }
        }

        if ($repeated_user) {
            ?>
            <div class="formularios registro" style="margin-top: 30px; text-align: center;">
                <p>El usuario o correo electrónico no están disponibles.</p>
                <p>Cámbielos para poder crear un usuario nuevo.</p>
            </div>
            <?php
        }
    } 
    } else { ?>
        <div class="wrapper formularios registro buscar" style="margin-top: 30px;">
            <h2 class="titulo">Ups. Parece que no tienes permisos para acceder a esta página.</h2>
            <div style="text-align:center;">
                <form action="index.php" method="post">
                <input type="submit" value="Volver al inicio" name="enviar" class="boton" style="font-weight: bold;">
                </form>
            </div>
        </div>
        <?php
        }
    } else {
        ?>
        <div class="wrapper formularios registro buscar" style="margin-top: 30px;">
            <h2 class="titulo">Ups. Parece que no tienes permisos para acceder a esta página.</h2>
            <div style="text-align:center;">
                <form action="index.php" method="post">
                <input type="submit" value="Volver al inicio" name="enviar" class="boton" style="font-weight: bold;">
                </form>
            </div>
        </div>
        <?php
    }
        include 'footer.php';
    ?>
    </body>
</html>