<?php
include("conexion.php");
$con = conectar();

$ID = $_POST['ID'];
$nombre = $_POST['nombre'];
$Apellido = $_POST['Apellido'];
$Edad = $_POST['Edad'];
$Sexo = $_POST['Sexo'];
$diagnostico = $_POST['diagnostico'];

$sql = "UPDATE alumno 
        SET nombre='$nombre',
            Apellido='$Apellido',
            Edad='$Edad',
            Sexo='$Sexo',
            diagnostico='$diagnostico'
        WHERE ID='$ID'";
        
$query = mysqli_query($con, $sql);

if ($query) {
    Header("Location: alumno.php");
} else {
    echo "Error al actualizar los datos.";
}
?>
