<?php
session_start();
header('Content-Type: application/json'); // Indicar que la respuesta es JSON

// Verificar que el usuario esté logueado (representante)
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado.']);
    exit;
}

// Ahora, $_SESSION['user_id'] es el ID del REPRESENTANTE
$id_representante_actual = $_SESSION['user_id'];

include 'conexion.php'; // Incluir el archivo de conexión

// Llamar a la función conectar() y asignar la conexión a $conn
$conn = conectar(); // ¡Esta es la corrección clave para definir $conn!

$id_alumno_actual = null; // Inicializamos el ID del alumno como nulo

// ***** PASO CLAVE: Obtener el Alumno_ID asociado al Representante_ID *****
$sql_get_alumno_id = "SELECT Alumno_ID FROM alum_repre WHERE Representante_ID = ?";
if ($stmt_get_alumno = $conn->prepare($sql_get_alumno_id)) {
    $stmt_get_alumno->bind_param("i", $id_representante_actual);
    $stmt_get_alumno->execute();
    $result_get_alumno = $stmt_get_alumno->get_result();
    
    if ($row_alumno = $result_get_alumno->fetch_assoc()) {
        $id_alumno_actual = $row_alumno['Alumno_ID'];
    } else {
        // No se encontró ningún alumno asociado a este representante
        echo json_encode(['success' => false, 'message' => 'No se encontró un alumno asociado a este representante.']);
        $conn->close();
        exit;
    }
    $stmt_get_alumno->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Error al preparar la consulta para obtener Alumno_ID: ' . $conn->error]);
    $conn->close();
    exit;
}

// Si $id_alumno_actual sigue siendo nulo después de la búsqueda, salir.
if ($id_alumno_actual === null) {
    echo json_encode(['success' => false, 'message' => 'No se pudo determinar el ID del alumno.']);
    $conn->close();
    exit;
}

// Obtener el contenido JSON del cuerpo de la solicitud
$data = json_decode(file_get_contents('php://input'), true);

if (empty($data)) {
    echo json_encode(['success' => false, 'message' => 'No se recibieron datos de logros.']);
    $conn->close();
    exit;
}

// Mapeo de claves de localStorage a ID de actividad en tu tabla 'actividad'
// Estos IDs deben coincidir con tu tabla 'actividad'
$activity_mapping = [
    'logroColoresCount' => 1,      // ID 1: 'Colores'
    'logroFormasCount' => 2,       // ID 2: 'Formas'
    'logroNumerosCount' => 3,      // ID 3: 'Numeros'
    'logroLetrasCount' => 4,       // ID 4: 'Letras'
    'logroIdentificarCount' => 5,  // ID 5: 'Identificar'
    'logroMatematicasCount' => 6,  // ID 6: 'Matematicas'
    'logroMemoriaCount' => 7,      // ID 7: 'Memoria'
    'logroConteoCount' => 8,       // ID 8: 'Contar'
    // Asegúrate de que los IDs aquí corresponden a los IDs en tu tabla 'actividad'
    // Si 'rutina' o 'emociones' tienen IDs, inclúyelos aquí:
    // 'logroRutinaCount' => ID_DE_RUTINA,
    // 'logroEmocionesCount' => ID_DE_EMOCIONES,
];

$success_count = 0;
$error_messages = [];

foreach ($data as $localStorageKey => $achievementInfo) {
    if (isset($activity_mapping[$localStorageKey])) {
        $id_actividad = $activity_mapping[$localStorageKey];
        $nota_texto = $achievementInfo['note']; // El texto formateado del logro

        // 1. Verificar si ya existe una entrada en actividad_alumno para este alumno y actividad
        // Usar los nombres de columna exactos de tu base de datos: Alumno_ID, Actividad_ID, ID
        $sql_check = "SELECT ID FROM actividad_alumno WHERE Alumno_ID = ? AND Actividad_ID = ?"; 
        if ($stmt_check = $conn->prepare($sql_check)) {
            $stmt_check->bind_param("ii", $id_alumno_actual, $id_actividad);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();
            $row_check = $result_check->fetch_assoc();
            $stmt_check->close();

            if ($row_check) {
                // Si existe, actualizar el campo 'nota'
                $id_actividad_alumno_existente = $row_check['ID'];
                $sql_update = "UPDATE actividad_alumno SET nota = ? WHERE ID = ?";
                if ($stmt_update = $conn->prepare($sql_update)) {
                    $stmt_update->bind_param("si", $nota_texto, $id_actividad_alumno_existente);
                    if ($stmt_update->execute()) {
                        $success_count++;
                    } else {
                        $error_messages[] = "Error al actualizar la nota para {$localStorageKey}: " . $stmt_update->error;
                    }
                    $stmt_update->close();
                } else {
                    $error_messages[] = "Error al preparar la actualización para {$localStorageKey}: " . $conn->error;
                }
            } else {
                // Si no existe, insertar un nuevo registro en actividad_alumno
                // Asegúrate que las columnas sean Alumno_ID, Actividad_ID, nota
                $sql_insert = "INSERT INTO actividad_alumno (Alumno_ID, Actividad_ID, nota) VALUES (?, ?, ?)"; 
                if ($stmt_insert = $conn->prepare($sql_insert)) {
                    $stmt_insert->bind_param("iis", $id_alumno_actual, $id_actividad, $nota_texto);
                    if ($stmt_insert->execute()) {
                        $success_count++;
                    } else {
                        $error_messages[] = "Error al insertar la nota para {$localStorageKey}: " . $stmt_insert->error;
                    }
                    $stmt_insert->close();
                } else {
                    $error_messages[] = "Error al preparar la inserción para {$localStorageKey}: " . $conn->error;
                }
            }
        } else {
            $error_messages[] = "Error al preparar la verificación para {$localStorageKey}: " . $conn->error;
        }
    } else {
        $error_messages[] = "Mapeo de actividad no encontrado para la clave de localStorage: {$localStorageKey}";
    }
}

$conn->close();

if (empty($error_messages)) {
    echo json_encode(['success' => true, 'message' => "Se procesaron {$success_count} logros correctamente."]);
} else {
    echo json_encode(['success' => false, 'message' => "Se procesaron {$success_count} logros con errores: " . implode(" | ", $error_messages)]);
}
?>