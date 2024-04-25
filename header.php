<header style="border-bottom-left-radius: 7px;
            border-bottom-right-radius: 7px;">
    <div class="header_superior">
    <a href="index.php" target="_blank"><img src="img/LogoViamper.PNG" id="logotip" alt="Viamper" title="Viamper"></a>
    <nav class="menu_premium">
        <ul class="menu">
            <?php
                include("database/estadosession.php");
                include 'database/connection.php';
                if($usuario_iniciado){
            ?>
                    <li>
                        <a href="">Perfil</a>
                        <ul>
                            <li><a href="usuario.php">Mi perfil</a></li>
                            <li><a href="database/cerrar_session.php">Cerrar sesión</a></li>
                        </ul>
                    </li>
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