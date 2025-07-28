<?php 
include("conexion.php");
$con = conectar();

$id = $_GET['id'];
$sql = "SELECT * FROM actividad_alumno WHERE ID='$id'";
$query = mysqli_query($con, $sql);

$row = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Actualizar Actividad Alumno</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <form action="update.php" method="POST">
        <input type="hidden" name="ID" value="<?php echo $row['ID'] ?>">
        <input type="text" class="form-control mb-3" name="Alumno_ID" value="<?php echo $row['Alumno_ID'] ?>">
        <input type="text" class="form-control mb-3" name="Actividad_ID" value="<?php echo $row['Actividad_ID'] ?>">
        <input type="date" class="form-control mb-3" name="f_inicio" value="<?php echo $row['f_inicio'] ?>">
        <input type="date" class="form-control mb-3" name="f_final" value="<?php echo $row['f_final'] ?>">
        <input type="submit" class="btn btn-primary" value="Actualizar">
    </form>
</div>
</body>
</html>
