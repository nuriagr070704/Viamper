<html>
<head>
    <meta charset="utf-8">
    <meta name="author" content="Núria y Óscar">
    <meta name="copyright" content="VIAMPER">
    <link rel="stylesheet" href="CSS/EstiloViamper.css">
    <style>
        .bordes{
            border-top-left-radius: 7px;
            border-top-right-radius: 7px;
            border-bottom-left-radius: 7px;
            border-bottom-right-radius: 7px;
        }
        .images {
            height: 150px;
        }
        .big_image{
            height: 500px;
        }
        .margen{
            margin-left: 10%;
            margin-right: 10%;
            margin-top: 30px;
        }
    </style>
    <title>Destinos</title>
</head>
<body>
<?php include 'header.php';
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
$id = $_GET['id'];
$accomodation_query="select * from allotjament where ID = $id;";
$query_result = mysqli_query($connection, $accomodation_query);

while ($result_formated = mysqli_fetch_row($query_result)){

?>
<div class="margen">
    <h1 align="center"><?php echo $result_formated[1]; ?>, <?php echo $result_formated[3]; ?></h1>
    <table align="center">
        <tr>
            <?php for ($index=1; $index<5; $index++) { ?>
            <td><img class="bordes images" src="img/Producto/<?php echo $result_formated[4]; ?>/<?php echo $index; ?>.jpg" alt="hola"></td>
            <?php } ?>
        </tr>
    </table>
</div>
<div style="text-align: center;">
    <img class="bordes big_image" src="img/Producto/<?php echo $result_formated[4]; ?>/5.jpg">
<div>
    <h2><?php echo $result_formated[1]; ?>, <?php echo $result_formated[4]; ?></h2>
    <p>Estrellas: <?php echo $result_formated[2]; ?></p>
    <p>Ciudad: <?php echo $result_formated[4]; ?></p>
    <p>País: <?php echo $result_formated[3]; ?></p>
    <p>Hora de check-in: <?php echo cambiar_formato_hora($result_formated[6]); ?></p>
    <p>Hora de check-out: <?php echo cambiar_formato_hora($result_formated[7]); ?></p>
    <p>Pensión: <?php if ($result_formated[5]) {echo $result_formated[5];} else {echo "Sin pensión";} ?></p>
    <p>Habitaciones libres actualmente: <?php echo $result_formated[8]; ?></p>
    <p>Precio por noche y persona: <?php echo round($result_formated[10], 2); ?> €</p>
</div>
<form action="index.php"><input type="submit" class="boton" value="¡Descubre si puedes reservar este destino!"></form>
</div>

<?php } ?>
</body>
<?php include 'footer.php';?>
</html>