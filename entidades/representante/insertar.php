<?php
include("conexion.php");
$con = conectar();

$ID = $_POST['ID'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$Tlf = $_POST['Tlf'];
$Direccion = $_POST['Direccion'];

$sql = "INSERT INTO representante (ID, nombre, apellido, Tlf, Direccion) 
        VALUES ('$ID', '$nombre', '$apellido', '$Tlf', '$Direccion')";
$query = mysqli_query($con, $sql);

if ($query) {
    header("Location: representante.php");
} else {
    echo "Error al insertar los datos.";
}
?>
