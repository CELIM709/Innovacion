<?php
include("conexion.php");
$con = conectar();

$ID = $_POST['ID'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$Tlf = $_POST['Tlf'];
$direccion = $_POST['direccion'];

$sql = "INSERT INTO docente (ID, nombre, apellido, Tlf, direccion) 
        VALUES ('$ID', '$nombre', '$apellido', '$Tlf', '$direccion')";
$query = mysqli_query($con, $sql);

if ($query) {
    header("Location: docente.php");
} else {
    echo "Error al insertar los datos.";
}
?>
