<?php
include("conexion.php");
$con = conectar();

$ID = $_POST['ID'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$Tlf = $_POST['Tlf'];
$direccion = $_POST['direccion'];

$sql = "UPDATE docente 
        SET nombre='$nombre',
            apellido='$apellido',
            Tlf='$Tlf',
            direccion='$direccion'
        WHERE ID='$ID'";

$query = mysqli_query($con, $sql);

if ($query) {
    header("Location: docente.php");
} else {
    echo "Error al actualizar los datos.";
}
?>
