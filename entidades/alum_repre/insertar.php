<?php
include("conexion.php");
$con = conectar();

$codigo = $_POST['codigo'];
$Alumno_ID = $_POST['Alumno_ID'];
$Representante_ID = $_POST['Representante_ID'];

$sql = "INSERT INTO alum_repre (codigo, Alumno_ID, Representante_ID) 
        VALUES ('$codigo', '$Alumno_ID', '$Representante_ID')";
$query = mysqli_query($con, $sql);

if ($query) {
    header("Location: alum_repre.php");
} else {
    echo "Error al insertar los datos.";
}
?>
