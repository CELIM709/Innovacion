<?php
include("conexion.php");
$con = conectar();

$codigo = $_GET['id'];

$sql = "DELETE FROM alum_repre WHERE codigo='$codigo'";
$query = mysqli_query($con, $sql);

if ($query) {
    header("Location: alum_repre.php");
} else {
    echo "Error al eliminar el registro.";
}
?>
