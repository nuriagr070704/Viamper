<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "basedades";
$connection = mysqli_connect($servername,$username,$password,$database);
mysqli_set_charset($connection, "utf8");
if (!$connection)
{
    die("Connection failed: ".mysqli_connect_error());
}
?>