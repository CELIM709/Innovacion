<?php
include("conexion.php");
$con = conectar();

$ID = $_POST['ID'];
$nombre = $_POST['nombre'];
$Apellido = $_POST['Apellido'];
$Edad = $_POST['Edad'];
$Sexo = $_POST['Sexo'];
$diagnostico = $_POST['diagnostico'];

$sql = "INSERT INTO alumno (ID, nombre, Apellido, Edad, Sexo, diagnostico) 
        VALUES ('$ID', '$nombre', '$Apellido', '$Edad', '$Sexo', '$diagnostico')";
$query = mysqli_query($con, $sql);

if ($query) {
    Header("Location: alumno.php");
} else {
    echo "Error al insertar los datos.";
}
?>
