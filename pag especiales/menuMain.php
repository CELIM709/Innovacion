<?php
session_start();
// Verificar que el usuario esté logueado y que su rol sea 'representante'
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'representante') {
    // Si no es un representante logueado, redirigir a la página de inicio de sesión
    header("Location: index.php"); // Asumiendo que index.php es tu página de login
    exit;
}

// Obtener el nombre de usuario del representante para personalizar el saludo
$username_representante = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Principal</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="contenedor">
        <h1>Menú Principal <br> <span class="subtitulo">(Dashboard del niño)</span></h1>
        <h2 style="color: #555; margin-top: -10px; margin-bottom: 30px;">¡Hola, <?php echo htmlspecialchars($username_representante); ?>!</h2>

        <div class="tarjeta-menu">
            <a href="/Especiales/pag especiales/pagEspeciales/rutina.html" class="item-menu azul-claro">
                <i class="fas fa-sync-alt icono"></i>
                <span>Mi Rutina</span>
            </a>
            <a href="/Especiales/pag especiales/pagEspeciales/actividades.php" class="item-menu azul-oscuro">
                <i class="fas fa-gamepad icono"></i>
                <span>Mis Actividades</span>
            </a>
            <a href="/Especiales/pag especiales/pagEspeciales/emociones.html" class="item-menu amarillo">
                <i class="fas fa-grin icono"></i>
                <span>Mis Emociones</span>
            </a>
            <a href="/Especiales/pag especiales/pagEspeciales/logros.php" class="item-menu naranja">
                <i class="fas fa-star icono"></i>
                <span>Logros</span>
            </a>
        
</body>
</html>