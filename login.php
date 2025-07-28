<?php
session_start();
include("db.php");

$username = $_POST['username'];
$password = $_POST['password'];

// Primero, validar en la tabla 'docente'
$sql = "SELECT * FROM docente WHERE user = ? AND contrasena = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    $_SESSION['user_id'] = $user['ID'];
    $_SESSION['username'] = $user['user'];
    $_SESSION['rol'] = 'docente'; // Fijamos rol manualmente o puedes usar $user['rol'] si tienes esa columna
    header("Location: /Especiales/pag's%20wed/pagdocente.php");
    exit;
} else {
    // Si no es docente, intentamos con la tabla 'representante'
    $sql = "SELECT * FROM representante WHERE user = ? AND contrasena = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['ID'];
        $_SESSION['username'] = $user['user'];
        $_SESSION['rol'] = 'representante'; // Igual que antes, puedes usar el valor desde la base si existe
        header("Location: /Especiales/pag%20especiales/menuMain.php");
        exit;
    } else {
        echo "<script>alert('Usuario o contraseña incorrectos'); window.location.href='index.php';</script>";
    }
}
?>

