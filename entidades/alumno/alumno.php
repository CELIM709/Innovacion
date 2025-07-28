<?php 
    include("conexion.php");
    $con = conectar();

    $sql = "SELECT * FROM alumno";
    $query = mysqli_query($con, $sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>PÁGINA ALUMNO</title>
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
                <input type="text" class="form-control mb-3" name="ID" placeholder="ID">
                <input type="text" class="form-control mb-3" name="nombre" placeholder="Nombre">
                <input type="text" class="form-control mb-3" name="Apellido" placeholder="Apellido">
                <input type="number" class="form-control mb-3" name="Edad" placeholder="Edad">
                <input type="text" class="form-control mb-3" name="Sexo" placeholder="Sexo">
                <textarea class="form-control mb-3" name="diagnostico" placeholder="Diagnóstico"></textarea>
                <input type="submit" class="btn btn-primary" value="Guardar">
            </form>
        </div>

        <div class="col-md-8">
            <table class="table">
                <thead class="table-success table-striped">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Edad</th>
                        <th>Sexo</th>
                        <th>Diagnóstico</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_array($query)) { ?>
                    <tr>
                        <td><?php echo $row['ID'] ?></td>
                        <td><?php echo $row['nombre'] ?></td>
                        <td><?php echo $row['Apellido'] ?></td>
                        <td><?php echo $row['Edad'] ?></td>
                        <td><?php echo $row['Sexo'] ?></td>
                        <td><?php echo $row['diagnostico'] ?></td>
                        <td><a href="actualizar.php?id=<?php echo $row['ID'] ?>" class="btn btn-info">Editar</a></td>
                        <td><a href="delete.php?id=<?php echo $row['ID'] ?>" class="btn btn-danger">Eliminar</a></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>  
</div>
</body>
</html>
