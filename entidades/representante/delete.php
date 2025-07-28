<?php
include("conexion.php");
$con = conectar();

$ID = $_GET['id'];

$sql = "DELETE FROM representante WHERE ID='$ID'";
$query = mysqli_query($con, $sql);

if ($query) {
    header("Location: representante.php");
} else {
    echo "Error al eliminar el registro.";
}
?>