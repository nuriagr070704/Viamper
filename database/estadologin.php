<?php
session_start();
    $estado = false;
    if(isset($_POST['correo_usuario']) && isset($_POST['contrasenya'])){
        $usuario = ($_POST['correo_usuario']);
        $contrasenya = $_POST['contrasenya']; 
        include 'connection.php';

        //Usuarios
        $consulta_inici="SELECT * FROM clients where (login='$usuario' or correu='$usuario') and claupas='$contrasenya'";
        $estadologin = mysqli_query($connection,$consulta_inici);
        if(mysqli_num_rows($estadologin) > 0){
            $estado = true;
            $_SESSION['usuario']=$usuario; 
                if (isset($_POST['recordarme'])) {
                        // Establecer una cookie para recordar al usuario
                        setcookie('usuario', $usuario, time() + (86400 * 30), '/');
                        // setcookie(nombre-cookie, usuario, tiempo  que dura en nuestro caso 30d)
                }
            header("Location: ../../Usuario.php");
            exit;
        } 

        //Trabajadores
        $consulta_trabajador = "SELECT * FROM treballadors WHERE (login='$usuario' OR correu='$usuario') AND claupas='$contrasenya'";
        $resultado_trabajador = mysqli_query($connection, $consulta_trabajador);
        if(mysqli_num_rows($resultado_trabajador) > 0){
            $estado = true;
            $_SESSION['usuario']=$usuario; 
                if (isset($_POST['recordarme'])) {
                    setcookie('usuario', $usuario, time() + (86400 * 30), '/'); 
                }
            header("Location: ../../Usuario.php");
            exit;
        }    
        $_SESSION['error'] = "No has introducido los datos correctos";
        header("Location: ../../iniciosesion.php");
        exit; 
    }
    header("Location: ../../iniciosesion.php");
    exit;
?>