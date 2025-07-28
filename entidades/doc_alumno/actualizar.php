<?php 
include("conexion.php");
$con = conectar();

$id = $_GET['id'];
$sql = "SELECT * FROM doc_alumno WHERE codigo='$id'";
$query = mysqli_query($con, $sql);

$row = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Actualizar Relación</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <form action="update.php" method="POST">
        <input type="hidden" name="codigo" value="<?php echo $row['codigo'] ?>">
        <input type="text" class="form-control mb-3" name="Alumno_ID" value="<?php echo $row['Alumno_ID'] ?>">
        <input type="text" class="form-control mb-3" name="Docente_ID" value="<?php echo $row['Docente_ID'] ?>">
        <input type="submit" class="btn btn-primary" value="Actualizar">
    </form>
</div>
</body>
</html>
