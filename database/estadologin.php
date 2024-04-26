<?php
session_start();
    $estado = false;
    if(isset($_POST['correo_usuario']) && isset($_POST['contrasenya'])){
        $usuario = ($_POST['correo_usuario']);
        $contrasenya = $_POST['contrasenya']; 
        include 'connection.php';

        //Usuarios
        //Todo lo siguiente es para evitar injecciones SQL
        $consulta_inicio = "SELECT * FROM clients WHERE (login=? OR correu=?)";
        $pre_consulta = mysqli_prepare($connection, $consulta_inicio);

        //Enlaza los ? con los valores en las variables para evitar injecciones SQL
        mysqli_stmt_bind_param($pre_consulta, "ss", $usuario, $usuario); 
        
        //Ejecutar consulta ya con valores asignados
        mysqli_stmt_execute($pre_consulta);
        
        //Ejecutar resultado de las consultas
        $resultado_consulta = mysqli_stmt_get_result($pre_consulta);
        //se acaba el evitando injecciones SQL

        if(mysqli_num_rows($resultado_consulta) > 0){
            //Se obtiene los datos de la consulta para poder obtener la contraseña
            $fila = mysqli_fetch_assoc($resultado_consulta);
            if(password_verify($contrasenya, $fila['claupas'])){
                //Comprobar los hashes
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
        }

        //Trabajadores
        $consulta_trabajador = "SELECT * FROM treballadors WHERE (login=? OR correu=?)";
        $pre_consulta_trabajador = mysqli_prepare($connection, $consulta_trabajador);

        //Enlaza los ? con los valores en las variables para evitar injecciones SQL
        mysqli_stmt_bind_param($pre_consulta_trabajador, "ss", $usuario, $usuario); 
        
        //Ejecutar consulta ya con valores asignados
        mysqli_stmt_execute($pre_consulta_trabajador);
        
        //Ejecutar resultado de las consultas
        $resultado_trabajador = mysqli_stmt_get_result($pre_consulta);

        if(mysqli_num_rows($resultado_trabajador) > 0){
            //Se obtiene los datos de la consulta para poder obtener la contraseña
            $fila = mysqli_fetch_assoc($resultado_trabajador);
            if(password_verify($contrasenya, $fila['claupas'])){
                //Comprobar los hashes
                $estado = true;
                $_SESSION['usuario']=$usuario; 
                    if (isset($_POST['recordarme'])) {
                            // Establecer una cookie para recordar al usuario
                            setcookie('usuario', $usuario, time() + (86400 * 30), '/'); 
                            // setcookie(nombre-cookie, usuario, tiempo  que dura en nuestro caso 30d)
                    }
                header("Location: ../../Usuario.php"); //hay que poner un sitio del trabajador
                exit;
            } 
        }
        $_SESSION['error'] = "No has introducido los datos correctos";
        header("Location: ../../iniciosesion.php");
        exit; 
    }
    header("Location: ../../iniciosesion.php");
    exit;
?>