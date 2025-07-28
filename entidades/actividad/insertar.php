<?php
include("conexion.php");
$con = conectar();

$ID = $_POST['ID'];
$nombre = $_POST['nombre'];
$tiempo = $_POST['tiempo'];
$descripcion = $_POST['descripcion'];

$sql = "INSERT INTO actividad (ID, nombre, tiempo, descripcion) 
        VALUES ('$ID', '$nombre', '$tiempo', '$descripcion')";
$query = mysqli_query($con, $sql);

if ($query) {
    header("Location: actividad.php");
} else {
    echo "Error al insertar los datos.";
}
?>
