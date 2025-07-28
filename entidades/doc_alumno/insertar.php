<?php
include("conexion.php");
$con = conectar();

$codigo = $_POST['codigo'];
$Alumno_ID = $_POST['Alumno_ID'];
$Docente_ID = $_POST['Docente_ID'];

$sql = "INSERT INTO doc_alumno (codigo, Alumno_ID, Docente_ID) 
        VALUES ('$codigo', '$Alumno_ID', '$Docente_ID')";
$query = mysqli_query($con, $sql);

if ($query) {
    header("Location: doc_alumno.php");
} else {
    echo "Error al insertar los datos.";
}
?>
