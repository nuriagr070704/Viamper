<!DOCTYPE html>
<html lang="es">
    <head>
    <meta charset="utf-8"/>
    <meta name="author" content="Nuria y Óscar">
    <meta name="copyright" content="VIAMPER">
    <link rel="stylesheet" href="css/EstiloViamper.css">
    <title>Registro</title>
</head>
<body>
<?php include 'header.php'; 
$repeated_user = false;
$error_user_creation = false;?>
    <div class="wrapper">
        <h2 class="titulo">Registro</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="formularios registro" method="post" enctype="multipart/form-data">
            <table align="center" style="width:100%; text-align: center;">
                <tr>
                    <td><label for="nombre" id="separacion1">Nombre*</label></td>
                    <td><label for="apellidos" id="separacion1">Apellidos*</label></td>
                </tr>
                <tr>
                    <td><input type="text" name="nombre" id="nombre" style="width: 80%" required></td>
                    <td><input type="text" name="apellidos" id="apellidos" style="width: 80%" required></td>
                </tr>
                <tr>
                    <td><label for="usuario" id="separacion1">Usuario*</label></td>
                    <td><label for="contraseña" class="separacion2">Contraseña*</label></td>
                </tr>
                <tr>
                    <td><input type="text" name="usuario" id="usuario" style="width: 80%" required></td>
                    <td><input type="password" name="contraseña" id="contraseña" style="width: 80%" required></td>
                </tr>
                <tr>
                    <td><label for="correo" class="separacion2">Correo electrónico*</label></td>
                    <td><label for="movil" class="separacion2">Móvil</label></td>
                </tr>
                <tr>
                    <td><input type="email" name="correo" id="correo" style="width: 80%" required></td>
                    <td><input type="text" name="movil" id="movil" style="width: 80%"></td>
                </tr>
                <tr>
                    <td><label for="dni" class="separacion">DNI*</label></td>
                    <td><label for="banca" class="separacion3">Cuenta bancaria*</label></td>
                </tr>
                <tr>
                    <td><input type="text" name="dni" id="dni" style="width: 80%" required></td>
                    <td><input type="text" name="banca" id="banca" style="width: 80%" required></td>
                </tr>
            </table>
            <table align="center" style="width:100%;">
                <tr>
                    <td colspan="2">
                        <input type="checkbox" name="proteccion" id="proteccion" value="proteccion" required>
                        <label for="proteccion">Protección de datos*</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="checkbox" name="publicidad" id="publicidad" value="publicidad">
                        <label for="publicidad">Doy mi consentimiento para recibir publicidad</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="enviar" id="enviar" value="Regístrate" class="boton"  style="width: 100%; font-weight: bold;"></td>
                </tr>

                <tr>
                    <td colspan="2"><p style="text-align: center;">¿Ya tienes una cuenta? <a href="http://localhost/php/Iniciosesion.php">Inicia sesión</a></p></td>
                </tr>
            </table>
        </form>
        <?php
        if (isset($_POST["enviar"]))
        {
            $login = $_POST['usuario'];
            $password = $_POST['contraseña'];
            $dni = $_POST['dni'];
            $name = $_POST['nombre'];
            $surname = $_POST['apellidos'];
            $phone = $_POST['movil'];
            $email = $_POST['correo'];
            $bank = $_POST['banca'];
    
            //comprobar que no hay un usuario con los mismos datos
            $query_check = "select * from clients where login = '$login' or correu = '$email';";
            $posible_user = mysqli_query($connection, $query_check);
            $posible_user_array = mysqli_fetch_row($posible_user);

            $query_check_workers = "select * from treballadors where login = '$login' or correu = '$email';";
            $posible_worker = mysqli_query($connection, $query_check_workers);
            $posible_worker_array = mysqli_fetch_row($posible_worker);

            if ($posible_user_array != null || $posible_worker_array != null)
            {
                $repeated_user = true;
            }
            else
            {
                $query_last_uid = "select max(UID) from clients;";
                $last_number = mysqli_query($connection, $query_last_uid);
    
                $idarray = mysqli_fetch_row($last_number); //Lo recojo como array
                $idstring = implode("", $idarray); //Lo paso a string
                $idint = intval($idstring); //Lo paso a int
                $idint++;
    
                $insert = "insert into clients (`UID`, `login`, `claupas`, `DNINIE`, `nom`, `cognoms`, `telefon`, `correu`, `comptebancari`, `premium`) 
                values ($idint, '$login', '$password', '$dni', '$name', '$surname', $phone, '$email', '$bank', b'11');";
                try
                {
                    if (mysqli_query($connection, $insert))
                    {
                        echo '<script>window.location="http://localhost/php/Usuario.php"</script>';
                    }
                }
                catch (Exception $exception)
                {
                    $error_user_creation = true;
                }
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
        if ($error_user_creation) {
            ?>
            <div class="formularios registro" style="margin-top: 30px;">
                <p>Ha habido un error inesperado al crear un usuario.</p>
                <p>Senimos las molestias. Inténtelo de nuevo más tarde.</p>
            </div>
            <?php
        }
        ?>
    </div>
<?php include 'footer.php' ?>
</body>
</html>