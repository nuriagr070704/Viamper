<header>
    <div class="header_superior">
    <a href="index.php"><img src="img/LogoViamper.PNG" id="logotip" alt="Viamper" title="Viamper"></a>
    <nav class="menu_premium">
        <ul class="menu">
            <?php
                include("database/estadosession.php");
                include 'database/connection.php';
                if($usuario_iniciado){
            ?>
                <?php
                if($_SESSION['puesto']=="trabajador"){ ?><li><a href="Trabajador.php">Mi perfil</a></li><?php
                } else { ?> <li><a href="usuario.php">Mi perfil</a></li> <?php } ?>
                <li><a href="database/cerrar_session.php">Cerrar sesión</a></li>
            <?php
                }else{ 
            ?>
                    <li><a href="Iniciosesion.php">Iniciar sesión</a></li>
                    <li><a href="Registro.php">Únete a nuestra familia</a></li>
            <?php
                }
            ?> 
                    <li><a href="Premium.php">Hazte premium</a></li>
        </ul>
    </nav>
    </div>
    <nav class="container">
    <p style="font-size: 10px;">Esta web es un proyecto educativo</p>
        <ul class="menu">
            <li><a href="index.php">Inicio</a></li>
            <li><a href="Nosotros.php">Nosotros</a></li>
            <li><a href="Destinos.php">Destinos</a></li>
            <li><a href="Coches.php">Coches de alquiler</a></li>
            <li><a href="Ofertas.php">Ofertas</a></li>
            <li><a href="Contacto.php">Contáctanos</a></li>
        </ul>
    </nav>
</header>