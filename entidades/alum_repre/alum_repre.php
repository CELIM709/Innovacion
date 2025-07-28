<?php 
include("conexion.php");
$con = conectar();

$sql = "SELECT * FROM alum_repre";
$query = mysqli_query($con, $sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>PÁGINA ALUMNO - REPRESENTANTE</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row"> 
        <div class="col-md-3">
            <h1>Ingrese datos</h1>
            <form action="insertar.php" method="POST">
                <input type="text" class="form-control mb-3" name="codigo" placeholder="Código">
                <input type="text" class="form-control mb-3" name="Alumno_ID" placeholder="ID del Alumno">
                <input type="text" class="form-control mb-3" name="Representante_ID" placeholder="ID del Representante">
                <input type="submit" class="btn btn-primary" value="Guardar">
            </form>
        </div>

        <div class="col-md-9">
            <table class="table">
                <thead class="table-success table-striped">
                    <tr>
                        <th>Código</th>
                        <th>ID Alumno</th>
                        <th>ID Representante</th>
                        <th></th><th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_array($query)) { ?>
                    <tr>
                        <td><?php echo $row['codigo'] ?></td>
                        <td><?php echo $row['Alumno_ID'] ?></td>
                        <td><?php echo $row['Representante_ID'] ?></td>
                        <td><a href="actualizar.php?id=<?php echo $row['codigo'] ?>" class="btn btn-info">Editar</a></td>
                        <td><a href="delete.php?id=<?php echo $row['codigo'] ?>" class="btn btn-danger">Eliminar</a></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>  
</div>
</body>
</html>
