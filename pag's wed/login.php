<?php
session_start();
include("db.php"); // Asumo que tu archivo de conexión se llama 'db.php' para seguir tu ejemplo inicial. Si es 'conexion.php', cámbialo.

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Limpiar la sesión por si acaso hay datos viejos
session_unset();
session_destroy();
session_start(); // Iniciar una nueva sesión limpia

// Primero, validar en la tabla 'docente'
$sql_docente = "SELECT ID, user FROM docente WHERE user = ? AND contrasena = ?";
$stmt_docente = $conn->prepare($sql_docente);
$stmt_docente->bind_param("ss", $username, $password);
$stmt_docente->execute();
$result_docente = $stmt_docente->get_result();

if ($result_docente->num_rows === 1) {
    $user = $result_docente->fetch_assoc();
    $_SESSION['user_id'] = $user['ID'];
    $_SESSION['username'] = $user['user'];
    $_SESSION['rol'] = 'docente';
    header("Location: /Especiales/pag's%20wed/pagdocente.php"); // Tu ruta original para docentes
    exit;
} else {
    // Si no es docente, intentamos con la tabla 'representante'
    $sql_representante = "SELECT ID, user FROM representante WHERE user = ? AND contrasena = ?";
    $stmt_representante = $conn->prepare($sql_representante);
    $stmt_representante->bind_param("ss", $username, $password);
    $stmt_representante->execute();
    $result_representante = $stmt_representante->get_result();

    if ($result_representante->num_rows === 1) {
        $user = $result_representante->fetch_assoc();
        $_SESSION['user_id'] = $user['ID'];
        $_SESSION['username'] = $user['user'];
        $_SESSION['rol'] = 'representante';

        // Obtener el ID del alumno asociado a este representante usando 'alum_repre'
        $representante_id_logueado = $user['ID'];
        $sql_alumno = "SELECT Alumno_ID FROM alum_repre WHERE Representante_ID = ?";
        $stmt_alumno = $conn->prepare($sql_alumno);
        $stmt_alumno->bind_param("i", $representante_id_logueado);
        $stmt_alumno->execute();
        $result_alumno = $stmt_alumno->get_result();

        if ($result_alumno->num_rows === 1) { // Asumimos un solo alumno por representante por ahora
            $alumno_data = $result_alumno->fetch_assoc();
            $_SESSION['alumno_id_activo'] = $alumno_data['Alumno_ID']; // Guardar el ID del alumno en sesión
        } else {
            // Manejar caso donde el representante no tiene (o tiene más de uno) alumnos.
            echo "<script>alert('Representante sin alumno asociado o con más de uno. Contacte al soporte.'); window.location.href='index.php';</script>";
            exit;
        }
        $stmt_alumno->close(); // Cerrar el statement del alumno

        // Redirigir al menú principal del representante
        header("Location: /Especiales/pag especiales/menuMain.php");
        exit;

    } else {
        echo "<script>alert('Usuario o contraseña incorrectos'); window.location.href='index.php';</script>";
    }
}
// Asegúrate de cerrar la conexión de la base de datos aquí si 'db.php' no lo hace automáticamente
if (isset($stmt_docente)) $stmt_docente->close();
if (isset($stmt_representante)) $stmt_representante->close();
if (isset($conn)) $conn->close();
?>