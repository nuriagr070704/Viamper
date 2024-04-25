<!DOCTYPE html>
<html lang="es">
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
        .margen{
            margin-left: auto;
            margin-right: auto;
            margin-top: 30px;
            background-color: rgb(172, 204, 150);
        }
    </style>
    <title>Destinos</title>
</head>
<body>
<?php include 'header.php'; 
$accomodation_query="select * from allotjament;";
$query_result = mysqli_query($connection, $accomodation_query);

while ($result_formated = mysqli_fetch_row($query_result)){

?>

<div class="margen bordes" style="width: 35%;">
<a href="destino_seleccionado.php?id=<?php echo $result_formated[0];?>">
<table class="bordes" style="padding: 10px; margin-left: 10%;">
        <tbody>
            <tr>
                <td rowspan="2"><img class="bordes" src="img/Destinos/<?php echo $result_formated[4]; ?>.jpg" style="max-width: 200px; margin-right: 40px"></td>
                <td><?php echo $result_formated[1]; ?></td>
            </tr>
            <tr>
                <td><p>Estrellas: <?php echo $result_formated[2]; ?><br>
                    Ubicación: <?php echo $result_formated[4]; ?>, <?php echo $result_formated[3]; ?><br>
                    Pensión: <?php if ($result_formated[5]) {echo $result_formated[5];} else {echo "Sin pensión";} ?><br></p>
                </td>
            </tr>
        </tbody>
</table>
</a>
</div>
<?php } ?>

<?php include 'footer.php' ?>
</body>
</html>