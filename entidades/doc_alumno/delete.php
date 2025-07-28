<?php
include("conexion.php");
$con = conectar();

$codigo = $_GET['id'];

$sql = "DELETE FROM doc_alumno WHERE codigo='$codigo'";
$query = mysqli_query($con, $sql);

if ($query) {
    header("Location: doc_alumno.php");
} else {
    echo "Error al eliminar el registro.";
}
?>
