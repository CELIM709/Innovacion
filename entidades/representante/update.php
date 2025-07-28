<?php
include("conexion.php");
$con = conectar();

$ID = $_POST['ID'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$Tlf = $_POST['Tlf'];
$Direccion = $_POST['Direccion'];

$sql = "UPDATE representante 
        SET nombre='$nombre',
            apellido='$apellido',
            Tlf='$Tlf',
            Direccion='$Direccion'
        WHERE ID='$ID'";

$query = mysqli_query($con, $sql);

if ($query) {
    header("Location: representante.php");
} else {
    echo "Error al actualizar los datos.";
}
?>
