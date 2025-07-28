<?php
include("conexion.php");
$con = conectar();

$codigo = $_POST['codigo'];
$Alumno_ID = $_POST['Alumno_ID'];
$Docente_ID = $_POST['Docente_ID'];

$sql = "UPDATE doc_alumno 
        SET Alumno_ID='$Alumno_ID',
            Docente_ID='$Docente_ID'
        WHERE codigo='$codigo'";

$query = mysqli_query($con, $sql);

if ($query) {
    header("Location: doc_alumno.php");
} else {
    echo "Error al actualizar los datos.";
}
?>
