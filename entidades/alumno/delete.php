<?php
include("conexion.php");
$con = conectar();

$ID = $_GET['id'];

$sql = "DELETE FROM alumno WHERE ID='$ID'";
$query = mysqli_query($con, $sql);

if ($query) {
    Header("Location: alumno.php");
} else {
    echo "Error al eliminar el registro.";
}
?>
