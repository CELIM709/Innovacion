<?php
include("conexion.php");
$con = conectar();

$codigo = $_POST['codigo'];
$Alumno_ID = $_POST['Alumno_ID'];
$Representante_ID = $_POST['Representante_ID'];

$sql = "UPDATE alum_repre 
        SET Alumno_ID='$Alumno_ID',
            Representante_ID='$Representante_ID'
        WHERE codigo='$codigo'";

$query = mysqli_query($con, $sql);

if ($query) {
    header("Location: alum_repre.php");
} else {
    echo "Error al actualizar los datos.";
}
?>
