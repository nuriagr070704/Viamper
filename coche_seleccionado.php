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
            height: 200px;
        }
        .big_image{
            height: 600px;
        }
    </style>
    <title>Destinos</title>
</head>
<body>
<?php include 'header.php';
$id = $_GET['id'];
$accomodation_query="select * from cotxe where ID = $id;";
$query_result = mysqli_query($connection, $accomodation_query);

while ($result_formated = mysqli_fetch_row($query_result)){

?>
<div style="text-align: center;">
    <h1><?php echo $result_formated[1]; ?>, <?php echo $result_formated[3]; ?></h1>
    <table align="center">
        <tr>
            <td><img class="bordes images" src="img/CochesAlquiler/<?php echo $id; ?>.jpg"></td>
            <td>
                <p>Categoria: <?php echo $result_formated[1]; ?></p>
                <p>Marca: <?php echo $result_formated[2]; ?></p>
                <p>Modelo: <?php echo $result_formated[3]; ?></p>
                <p>Personas: <?php echo $result_formated[4]; ?></p>
                <p>Puertas: <?php echo $result_formated[5]; ?></p>
                <p>Tipo de marcha: <?php echo $result_formated[6]; ?></p>
            </td>
        </tr>
    </table>
</div>
<div style="text-align: center; margin-top: 30px;">
<form action="index.php"><input type="submit" class="boton" value="¡Descubre si puedes reservar este coche!"></form>
</div>
<?php } ?>
</body>
<?php include 'footer.php';?>
</html>