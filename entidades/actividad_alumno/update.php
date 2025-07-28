<?php
include("conexion.php");
$con = conectar();

$ID = $_POST['ID'];
$Alumno_ID = $_POST['Alumno_ID'];
$Actividad_ID = $_POST['Actividad_ID'];
$f_inicio = $_POST['f_inicio'];
$f_final = $_POST['f_final'];

$sql = "UPDATE actividad_alumno 
        SET Alumno_ID='$Alumno_ID',
            Actividad_ID='$Actividad_ID',
            f_inicio='$f_inicio',
            f_final='$f_final'
        WHERE ID='$ID'";

$query = mysqli_query($con, $sql);

if ($query) {
    header("Location: actividad_alumno.php");
} else {
    echo "Error al actualizar los datos.";
}
?>
