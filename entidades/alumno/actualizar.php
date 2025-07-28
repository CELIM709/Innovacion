<?php 
include("conexion.php");
$con = conectar();

$id = $_GET['id'];

$sql = "SELECT * FROM alumno WHERE ID='$id'";
$query = mysqli_query($con, $sql);

$row = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Actualizar Alumno</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <form action="update.php" method="POST">
        <input type="hidden" name="ID" value="<?php echo $row['ID'] ?>">

        <input type="text" class="form-control mb-3" name="nombre" placeholder="Nombre" value="<?php echo $row['nombre'] ?>">
        <input type="text" class="form-control mb-3" name="Apellido" placeholder="Apellido" value="<?php echo $row['Apellido'] ?>">
        <input type="number" class="form-control mb-3" name="Edad" placeholder="Edad" value="<?php echo $row['Edad'] ?>">
        <input type="text" class="form-control mb-3" name="Sexo" placeholder="Sexo" value="<?php echo $row['Sexo'] ?>">
        <textarea class="form-control mb-3" name="diagnostico" placeholder="Diagnóstico"><?php echo $row['diagnostico'] ?></textarea>

        <input type="submit" class="btn btn-primary btn-block" value="Actualizar">
    </form>
</div>
</body>
</html>
