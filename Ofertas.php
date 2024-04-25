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
    <title>Ofertas</title>
</head>
<body>
<?php include 'header.php';
$accomodation_query="select * from ofertes;";
$query_result = mysqli_query($connection, $accomodation_query);

while ($result_formated = mysqli_fetch_row($query_result)){
?>
<div class="margen bordes" style="width: 35%;">
<table class="bordes" style="padding: 10px; margin-left: 10%;">
        <tbody>
            <tr>
                <td rowspan="2"><img class="bordes" src="img/Ofertas/<?php echo $result_formated[0]; ?>.jpg" style="max-width: 200px; margin-right: 40px"></td>
                <td><h3><?php echo $result_formated[1]; ?></h3></td>
            </tr>
            <tr>
                <td><p><?php echo $result_formated[3]; ?><br></p>
                </td>
            </tr>
        </tbody>
</table>
</div>
<?php
}
?>
<?php include 'footer.php' ?>
</body>
</html>