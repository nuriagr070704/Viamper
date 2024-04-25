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
            <h2 class="espacio">Cambiar datos</h2>
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
                    <td><label for="dni" id="separacion1">DNI</label></td><td><label for="banca" id="separacion1">Cuenta bancaria</label></td>
                </tr>
                <tr>
                    <td><input type="text" name="dni" id="dni" value="<?php echo $result_formated[3] ?>"></td><td><input type="text" name="banca" id="banca" value="<?php echo $result_formated[8] ?>"></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="enviar" id="enviar" value="Guardar" class="boton" style="width: 100%; font-weight: bold;"></td>
                </tr>
                </table>
            </form>
        </div>
        <h2 class="espacio">Tus viajes</h2>
    <?php }
    
    $query_viatge = "select * from viatge where clients_UID = $usuario_id;";
    $viatge_result = mysqli_query($connection, $query_viatge);
    
    while ($result_viatge = mysqli_fetch_row($viatge_result)){
        $id_allotjament = $result_viatge[6];
        $id_vol_anada = $result_viatge[7];
        $id_vol_tornada = $result_viatge[8];
        $id_cotxe = $result_viatge[10];
        $allotjament_result = mysqli_query($connection, "select * from allotjament where ID = $id_allotjament");
        while ($result_viatge = mysqli_fetch_row($allotjament_result)){
            $vol_anada = mysqli_query($connection, "select * from vol where IDvol = $id_vol_anada");
            while ($result_vol_anada = mysqli_fetch_row($vol_anada)) {
                $vol_tornada = mysqli_query($connection, "select * from vol where IDvol = $id_vol_tornada");
                while($result_vol_tornada = mysqli_fetch_row($vol_tornada)){
                    $cotxe_result = mysqli_query($connection, "select * from cotxe where ID = $id_cotxe");
                    while($result_cotxe = mysqli_fetch_row($cotxe_result)) {

                    
    ?>
        
        <div class="puntitos">
            <h4><?php echo "Viaje a ".$result_viatge[4] ?>, <?php echo $result_viatge[3] ?></h4>
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
    ?>
    <?php include 'footer.php';
    if (isset($_POST['enviar']))
    {
        $login = $_POST['login'];
        $password = $_POST['password'];
        $dni = $_POST['dni'];
        $name = $_POST['nombre'];
        $surname = $_POST['apellidos'];
        $phone = $_POST['movil'];
        $email = $_POST['correo'];
        $bank = $_POST['banca'];

        //comprobar que no hay un usuario con los mismos datos
        $posible_user_array = '';
        $posible_worker_array = '';
        if ($old_user != $login || $old_email != $email) {
            $query_check = "select * from clients where login = '$login' or correu = '$email';";
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
            set login = '$login', claupas = '$password', DNINIE = '$dni', nom = '$name', cognoms = '$surname', telefon = $phone, correu = '$email', comptebancari = '$bank'
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
    
    ?>
    </body>
</html>