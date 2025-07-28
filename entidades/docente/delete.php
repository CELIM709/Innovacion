<?php
include("conexion.php");
$con = conectar();

$ID = $_GET['id'];

$sql = "DELETE FROM docente WHERE ID='$ID'";
$query = mysqli_query($con, $sql);

if ($query) {
    header("Location: docente.php");
} else {
    echo "Error al eliminar el registro.";
}
?>
