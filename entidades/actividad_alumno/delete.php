<?php
include("conexion.php");
$con = conectar();

$ID = $_GET['id'];

$sql = "DELETE FROM actividad_alumno WHERE ID='$ID'";
$query = mysqli_query($con, $sql);

if ($query) {
    header("Location: actividad_alumno.php");
} else {
    echo "Error al eliminar el registro.";
}
?>
