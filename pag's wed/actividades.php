<?php
session_start();
include("conexion.php"); // Asegúrate de que la ruta sea correcta
$con = conectar();

// 1. Verificar si el representante está logueado y si hay un alumno_id_activo en sesión
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'representante' || !isset($_SESSION['alumno_id_activo'])) {
    header("Location: index.php"); // Redirigir si no está logueado como representante o no tiene alumno activo
    exit;
}

$alumno_id_activo = $_SESSION['alumno_id_activo'];

// ========================================================================================
// Lógica para registrar inicio o finalización de actividad (POST)
// ========================================================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion_db'])) {
    $accion_db = $_POST['accion_db'];
    $actividad_id = $_POST['actividad_id'] ?? null; // ID de la actividad de la tabla 'actividad'

    if ($actividad_id === null) {
        echo "<script>alert('Error: ID de actividad no proporcionado.');</script>";
        // No salimos con exit para que la página cargue normalmente después
    }

    $fechaActual = date('Y-m-d H:i:s'); // Para T_inicio y T_final

    if ($accion_db === 'iniciar_actividad') {
        // Antes de insertar, verifica si ya hay una actividad pendiente para este alumno/actividad
        $sql_check_pending = "SELECT ID FROM actividad_alumno WHERE Alumno_ID = ? AND Actividad_ID = ? AND T_final IS NULL LIMIT 1";
        $stmt_check = mysqli_prepare($con, $sql_check_pending);
        mysqli_stmt_bind_param($stmt_check, "ii", $alumno_id_activo, $actividad_id);
        mysqli_stmt_execute($stmt_check);
        $result_check = mysqli_stmt_get_result($stmt_check);

        if (mysqli_num_rows($result_check) > 0) {
            $existing_record = mysqli_fetch_assoc($result_check);
            $_SESSION['current_activity_record_id'] = $existing_record['ID'];
            echo "<script>console.log('Actividad ya en curso. Usando registro existente ID: " . $existing_record['ID'] . "');</script>";
        } else {
            // Insertar un nuevo registro en actividad_alumno con T_inicio
            $sql_insert = "INSERT INTO actividad_alumno (Alumno_ID, Actividad_ID, T_inicio) VALUES (?, ?, ?)";
            $stmt_insert = mysqli_prepare($con, $sql_insert);
            mysqli_stmt_bind_param($stmt_insert, "iis", $alumno_id_activo, $actividad_id, $fechaActual);
            if (mysqli_stmt_execute($stmt_insert)) {
                $_SESSION['current_activity_record_id'] = mysqli_insert_id($con);
                echo "<script>console.log('Inicio de actividad registrado para Actividad ID: " . $actividad_id . "');</script>";
            } else {
                echo "<script>alert('Error al registrar inicio de actividad: " . mysqli_error($con) . "');</script>";
            }
            mysqli_stmt_close($stmt_insert);
        }
        mysqli_stmt_close($stmt_check);

    } elseif ($accion_db === 'finalizar_actividad') {
        $nota_obtenida = $_POST['nota'] ?? 0;
        $record_id_a_actualizar = $_SESSION['current_activity_record_id'] ?? null;

        if ($record_id_a_actualizar) {
            $sql_update = "UPDATE actividad_alumno SET T_final = ?, nota = ? WHERE ID = ? AND Alumno_ID = ?";
            $stmt_update = mysqli_prepare($con, $sql_update);
            mysqli_stmt_bind_param($stmt_update, "siii", $fechaActual, $nota_obtenida, $record_id_a_actualizar, $alumno_id_activo);
            if (mysqli_stmt_execute($stmt_update)) {
                echo "<script>console.log('Finalización de actividad y nota registradas para Actividad ID: " . $actividad_id . " con nota: " . $nota_obtenida . "');</script>";
                unset($_SESSION['current_activity_record_id']); // Limpiar la sesión después de finalizar
            } else {
                echo "<script>alert('Error al registrar finalización de actividad: " . mysqli_error($con) . "');</script>";
            }
            mysqli_stmt_close($stmt_update);
        } else {
            echo "<script>alert('Advertencia: No se encontró un registro de inicio de actividad pendiente para finalizar.');</script>";
        }
    }
}

// ========================================================================================
// El resto de tu HTML y PHP para mostrar las actividades
// ========================================================================================
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actividades Interactivas</title>
    <link rel="stylesheet" href="style.css"> <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="contenedor-actividades">
        <h1>Mis Actividades Interactivas</h1>
        <p class="subtitulo">¡Vamos a aprender jugando! Alumno ID: <?php echo $alumno_id_activo; ?></p>

        <div class="menu-categorias">
            <?php
            $sql_actividades = "SELECT ID, nombre FROM actividad ORDER BY ID";
            $result_actividades = mysqli_query($con, $sql_actividades);

            $clases_colores = [1 => 'azul-claro', 2 => 'amarillo', 3 => 'naranja', 4 => 'azul-oscuro', 5 => 'verde', 6 => 'morado', 7 => 'rosa', 8 => 'rojo'];
            $iconos_actividades = [1 => 'fa-palette', 2 => 'fa-shapes', 3 => 'fa-sort-numeric-up', 4 => 'fa-font', 5 => 'fa-puzzle-piece', 6 => 'fa-calculator', 7 => 'fa-brain', 8 => 'fa-hashtag'];

            if (mysqli_num_rows($result_actividades) > 0) {
                while ($act = mysqli_fetch_assoc($result_actividades)) {
                    $clase_color = $clases_colores[$act['ID']] ?? '';
                    $icono = $iconos_actividades[$act['ID']] ?? 'fa-question';

                    echo "<form action='actividades.php' method='post' style='display:inline;'>";
                    echo "<input type='hidden' name='accion_db' value='iniciar_actividad'>";
                    echo "<input type='hidden' name='actividad_id' value='" . $act['ID'] . "'>";
                    echo "<button type='submit' name='categoria' value='" . strtolower($act['nombre']) . "' class='categoria-item " . $clase_color . "'>";
                    echo "<i class='fas " . $icono . " icono-categoria'></i>";
                    echo "<span>" . htmlspecialchars($act['nombre']) . "</span>";
                    echo "</button>";
                    echo "</form>";
                }
            } else {
                echo "<p>No hay actividades disponibles.</p>";
            }
            ?>
        </div>

        <div class="contenido-actividad" id="contenidoActividad">
            <?php
            $categoria_seleccionada = $_POST['categoria'] ?? null;
            $actividad_id_actual = $_POST['actividad_id'] ?? null;

            if ($categoria_seleccionada) {
                echo "<h2>" . htmlspecialchars($categoria_seleccionada) . "</h2>";
                echo "<p>Contenido para: " . htmlspecialchars($categoria_seleccionada) . ".</p>";
                echo "<div class='juego-area'>";

                switch ($categoria_seleccionada) {
                    case 'colores':
                        include 'juegos/colores.php';
                        break;
                    case 'formas':
                        include 'juegos/formas.php';
                        break;
                    case 'numeros':
                        include 'juegos/numeros.php';
                        break;
                    case 'letras':
                        include 'juegos/letras.php';
                        break;
                    case 'identificar':
                        include 'juegos/identificar.php';
                        break;
                    case 'matematicas':
                        include 'juegos/matematicas.php';
                        break;
                    case 'memoria':
                        include 'juegos/memoria.php';
                        break;
                    case 'contar':
                        include 'juegos/contar.php';
                        break;
                    default:
                        echo "<p>Selecciona una actividad para empezar.</p>";
                        break;
                }
                echo "</div>";

                echo "<h3 class='instruccion-actividad' style='margin-top: 30px;'>Cuando termines, puedes guardar tu progreso:</h3>";
                echo "<form action='actividades.php' method='post' style='margin-top: 10px;'>";
                echo "<input type='hidden' name='accion_db' value='finalizar_actividad'>";
                echo "<input type='hidden' name='actividad_id' value='" . htmlspecialchars($actividad_id_actual) . "'>";
                echo "<label for='nota_final'>Tu nota/logro (0-100):</label>";
                echo "<input type='number' id='nota_final' name='nota' min='0' max='100' value='100' style='padding: 8px; border-radius: 5px; border: 1px solid #ccc; width: 80px; text-align: center; margin-right: 10px;'>";
                echo "<button type='submit' class='game-button secondary'>Guardar Progreso</button>";
                echo "</form>";

            } else {
                echo "<h2>¡Bienvenido!</h2>";
                echo "<p>Selecciona una actividad del menú superior para comenzar a aprender y jugar.</p>";
            }
            ?>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const elementosAprendizaje = document.querySelectorAll('.elemento-item');

            elementosAprendizaje.forEach(item => {
                item.addEventListener('click', () => {
                    const valor = item.dataset.valor;
                    if (valor) {
                        hablarTexto(valor);
                    }
                });
            });

            function hablarTexto(texto) {
                if ('speechSynthesis' in window) {
                    const utterance = new SpeechSynthesisUtterance(texto);
                    utterance.lang = 'es-ES';
                    window.speechSynthesis.speak(utterance);
                } else {
                    console.warn('La API de Síntesis de Voz no es soportada en este navegador.');
                }
            }

            const styleSheet = document.createElement('style');
            styleSheet.innerHTML = `
                .forma-item span,
                .color-item span {
                    display: none;
                }
            `;
            document.head.appendChild(styleSheet);
        });
    </script>
</body>
</html>
<?php
mysqli_close($con);
?>