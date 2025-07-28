<?php
include("conexion.php");
$con = conectar();

$ID = $_POST['ID'];
$nombre = $_POST['nombre'];
$tiempo = $_POST['tiempo'];
$descripcion = $_POST['descripcion'];

$sql = "UPDATE actividad 
        SET nombre='$nombre',
            tiempo='$tiempo',
            descripcion='$descripcion'
        WHERE ID='$ID'";

$query = mysqli_query($con, $sql);

if ($query) {
    header("Location: actividad.php");
} else {
    echo "Error al actualizar los datos.";
}
?>
