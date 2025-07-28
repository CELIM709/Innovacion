<?php
session_start();

// Verificar que el usuario esté logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Asumiendo que index.php es tu página de login
    exit;
}

// Ahora, $_SESSION['user_id'] es el ID del REPRESENTANTE
$id_representante_actual = $_SESSION['user_id']; 

// Incluir el archivo de conexión a la base de datos
include 'conexion.php'; // Asegúrate de que la ruta sea correcta

// Llamar a la función conectar() y asignar la conexión a $conn
$conn = conectar(); // Esta es la corrección para definir $conn

$id_alumno_actual = null; // Inicializamos el ID del alumno como nulo

// ***** PASO CLAVE: Obtener el Alumno_ID asociado al Representante_ID *****
// Usaremos la tabla 'alum_repre' para hacer la relación
$sql_get_alumno_id = "SELECT Alumno_ID FROM alum_repre WHERE Representante_ID = ?";
if ($stmt_get_alumno = $conn->prepare($sql_get_alumno_id)) {
    $stmt_get_alumno->bind_param("i", $id_representante_actual);
    $stmt_get_alumno->execute();
    $result_get_alumno = $stmt_get_alumno->get_result();
    
    if ($row_alumno = $result_get_alumno->fetch_assoc()) {
        $id_alumno_actual = $row_alumno['Alumno_ID'];
    } else {
        // No se encontró ningún alumno asociado a este representante
        // Podrías redirigir, mostrar un error, o simplemente dejar $logros_bd vacío
        // Para este caso, mostraremos un mensaje indicando que no hay alumnos.
        error_log("No se encontró Alumno_ID para Representante_ID: " . $id_representante_actual);
        // Opcional: echo "<p>No hay alumnos asociados a esta cuenta de representante.</p>";
    }
    $stmt_get_alumno->close();
} else {
    error_log("Error al preparar la consulta para obtener Alumno_ID: " . $conn->error);
}


// Array para almacenar los logros recuperados de la base de datos para mostrar
$logros_bd = [];

// Solo procedemos con la consulta de logros si encontramos un Alumno_ID
if ($id_alumno_actual !== null) {
    // Consulta SQL para obtener las actividades y sus notas (logros) para el alumno actual
    $sql_select = "SELECT aa.ID AS id_actividad_alumno, a.nombre AS nombre_actividad, aa.nota 
                   FROM actividad_alumno aa
                   JOIN actividad a ON aa.Actividad_ID = a.ID
                   WHERE aa.Alumno_ID = ?";

    if ($stmt_select = $conn->prepare($sql_select)) {
        $stmt_select->bind_param("i", $id_alumno_actual);
        $stmt_select->execute();
        $result_select = $stmt_select->get_result();

        while ($row = $result_select->fetch_assoc()) {
            $logros_bd[] = $row;
        }
        $stmt_select->close();
    } else {
        // Manejo de error si la preparación de la consulta falla
        error_log("Error al preparar la consulta SELECT en logros.php: " . $conn->error);
        // Podrías mostrar un mensaje al usuario o redirigir
    }
} else {
    // Si no se encontró un Alumno_ID, $logros_bd ya estará vacío y se mostrará el mensaje "No hay logros..."
}

// La conexión se cerrará al final del archivo PHP.
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Logros</title>
    <link rel="stylesheet" href="style-logros.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* ... Tu CSS existente (sin cambios) ... */
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #fce8d5; /* Fondo durazno claro */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            box-sizing: border-box;
            padding: 20px;
        }

        .contenedor-logros {
            background-color: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 40px 30px;
            text-align: center;
            width: 100%;
            max-width: 450px; /* Ancho similar al menú principal */
        }

        h1 {
            font-size: 2.5em;
            color: #333;
            margin-bottom: 10px;
            line-height: 1.2;
        }

        .subtitulo {
            font-size: 1.1em;
            color: #666;
            margin-bottom: 30px;
        }

        .seccion-logros {
            display: flex;
            flex-direction: column;
            gap: 15px; /* Espacio entre los elementos de logro */
            margin-bottom: 30px;
        }

        .logro-item {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            border-radius: 12px;
            text-decoration: none;
            color: #fff; /* Color de texto por defecto para la mayoría de los logros */
            font-size: 1.2em;
            font-weight: 700;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease; /* Añadido para un efecto al pasar el ratón */
        }

        .logro-item:hover {
            transform: translateY(-3px); /* Pequeño levantamiento al pasar el ratón */
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15); /* Sombra más pronunciada */
        }

        .icono-logro {
            font-size: 2.2em;
            margin-right: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px; /* Ancho fijo para los íconos */
            height: 50px; /* Alto fijo para los íconos */
            border-radius: 50%; /* Hacer los íconos circulares */
            background-color: rgba(255, 255, 255, 0.2); /* Fondo blanco semi-transparente para los íconos */
            color: inherit; /* Hereda el color del padre para el icono */
        }

        .texto-logro {
            display: flex;
            flex-direction: column;
            align-items: flex-start; /* Alinea el texto a la izquierda */
            flex-grow: 1;
        }

        .titulo-logro {
            font-size: 1.1em;
            font-weight: 800;
            margin-bottom: 3px;
        }

        .progreso-logro {
            font-size: 0.9em;
            font-weight: 600;
            line-height: 1.2;
            color: rgba(255, 255, 255, 0.8); /* Color un poco más claro para el texto de progreso */
        }

        /* Colores de los logros existentes */
        .azul-claro { background-color: #79c8f0; }
        .amarillo { background-color: #f7d14d; color: #6d4d00; }
        .amarillo .icono-logro { color: #6d4d00; }
        .amarillo .progreso-logro { color: rgba(109, 77, 0, 0.7); }
        .naranja { background-color: #fa9b50; }
        .azul-oscuro { background-color: #4a90e2; }

        /* NUEVOS COLORES PARA LOS LOGROS */
        .verde { background-color: #2ecc71; }
        .rojo { background-color: #e74c3c; }
        .morado { background-color: #9b59b6; }
        .turquesa { background-color: #1abc9c; }

        .boton-reset {
            background-color: #ccc;
            color: #555;
            border: none;
            padding: 12px 25px;
            border-radius: 10px;
            font-family: 'Nunito', sans-serif;
            font-size: 1em;
            font-weight: 700;
            cursor: pointer;
            transition: background-color 0.2s ease, transform 0.2s ease;
            margin-top: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .boton-reset:hover {
            background-color: #bbb;
            transform: translateY(-2px);
        }

        .nota {
            font-size: 0.9em;
            color: #888;
            margin-top: 15px;
        }

        /* Media Queries para responsividad (si ya los tienes, revísalos y ajusta si es necesario) */
        @media (max-width: 600px) {
            .contenedor-logros { padding: 30px 20px; }
            h1 { font-size: 2em; }
            .subtitulo { font-size: 1em; }
            .logro-item { font-size: 1.1em; padding: 12px 15px; }
            .icono-logro { font-size: 2em; width: 45px; height: 45px; }
            .titulo-logro { font-size: 1em; }
            .progreso-logro { font-size: 0.85em; }
            .boton-reset { padding: 10px 20px; font-size: 0.95em; }
        }
    </style>
</head>
<body>
    <div class="contenedor-logros">
        <h1>Mis Logros</h1>
        <p class="subtitulo">¡Mira todo lo que has aprendido y logrado!</p>

        <div class="seccion-logros">
            <?php if (!empty($logros_bd)): ?>
                <?php foreach ($logros_bd as $logro): ?>
                    <?php
                    // Asigna una clase de color y un icono basados en el nombre de la actividad
                    // Debes asegurarte de que estos nombres de actividad coincidan con tu DB
                    $clase_color = 'azul-claro'; // Color por defecto
                    $icono = 'fas fa-star'; // Icono por defecto

                    switch (mb_strtolower($logro['nombre_actividad'])) {
                        case 'rutina cumplida': // Ajusta estos nombres a como estén en tu tabla 'actividades'
                        case 'rutina':
                            $clase_color = 'azul-claro';
                            $icono = 'fas fa-calendar-check';
                            break;
                        case 'emociones exploradas':
                        case 'emociones':
                            $clase_color = 'amarillo';
                            $icono = 'fas fa-heart-pulse';
                            break;
                        case 'colores aprendidos':
                        case 'colores':
                            $clase_color = 'naranja';
                            $icono = 'fas fa-palette';
                            break;
                        case 'formas conocidas':
                        case 'formas':
                            $clase_color = 'azul-oscuro';
                            $icono = 'fas fa-shapes';
                            break;
                        case 'numeros contados':
                        case 'numeros':
                            $clase_color = 'azul-claro';
                            $icono = 'fas fa-calculator';
                            break;
                        case 'letras descubiertas':
                        case 'letras':
                            $clase_color = 'amarillo';
                            $icono = 'fas fa-spell-check';
                            break;
                        case 'objetos identificados':
                        case 'identificar objetos':
                            $clase_color = 'verde';
                            $icono = 'fas fa-puzzle-piece';
                            break;
                        case 'problemas matematicos resueltos':
                        case 'matematicas':
                            $clase_color = 'rojo';
                            $icono = 'fas fa-divide';
                            break;
                        case 'memoria desarrollada':
                        case 'memoria':
                            $clase_color = 'morado';
                            $icono = 'fas fa-brain';
                            break;
                        case 'objetos contados':
                        case 'conteo':
                            $clase_color = 'turquesa';
                            $icono = 'fas fa-sort-numeric-up-alt';
                            break;
                        // Puedes añadir más casos para otras actividades
                    }
                    ?>
                    <div class="logro-item <?php echo $clase_color; ?>">
                        <i class="<?php echo $icono; ?> icono-logro"></i>
                        <div class="texto-logro">
                            <span class="titulo-logro"><?php echo htmlspecialchars($logro['nombre_actividad']); ?></span>
                            <span class="progreso-logro"><?php echo htmlspecialchars($logro['nota'] ?: 'Sin progreso aún.'); ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay logros registrados para este alumno aún.</p>
                <?php if ($id_alumno_actual === null): ?>
                    <p>No se ha podido asociar un alumno a esta cuenta de representante.</p>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <p class="nota">¡Sigue practicando para ganar más estrellas!</p>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const achievementDisplays = {
            'rutinaProgreso': 'logroRutinaCount',
            'emocionesProgreso': 'logroEmocionesCount',
            'coloresProgreso': 'logroColoresCount',
            'formasProgreso': 'logroFormasCount',
            'numerosProgreso': 'logroNumerosCount',
            'letrasProgreso': 'logroLetrasCount',
            'identificarProgreso': 'logroIdentificarCount',
            'matematicasProgreso': 'logroMatematicasCount',
            'memoriaProgreso': 'logroMemoriaCount',
            'conteoProgreso': 'logroConteoCount'
        };

        // Función para enviar los logros de localStorage a la base de datos
        function sendLocalAchievementsToDB() {
            let localAchievements = {};
            for (const displayId in achievementDisplays) {
                const localStorageKey = achievementDisplays[displayId];
                const value = localStorage.getItem(localStorageKey);
                const count = value ? parseInt(value, 10) : 0;
                
                // Formato de texto para cada tipo de logro, similar a como se mostraba antes
                let text = '';
                switch(displayId) {
                    case 'rutinaProgreso': text = `Cumplida ${count} veces.`; break;
                    case 'emocionesProgreso': text = `Exploradas ${count} emociones.`; break;
                    case 'coloresProgreso': text = `Aprendidos ${count} colores.`; break;
                    case 'formasProgreso': text = `Conocidas ${count} formas.`; break;
                    case 'numerosProgreso': text = `Contados ${count} números.`; break;
                    case 'letrasProgreso': text = `Descubiertas ${count} letras.`; break;
                    case 'identificarProgreso': text = `Identificados ${count} objetos.`; break;
                    case 'matematicasProgreso': text = `Resueltos ${count} problemas.`; break;
                    case 'memoriaProgreso': text = `Desarrollada ${count} veces.`; break;
                    case 'conteoProgreso': text = `Contados ${count} grupos.`; break;
                    default: text = `${count}`;
                }
                
                localAchievements[localStorageKey] = {
                    count: count,
                    note: text // El texto final a guardar en la DB
                };
            }

            // Enviar los datos al servidor
            fetch('save_local_progress_to_db.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(localAchievements)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Logros de localStorage guardados/actualizados en la BD:', data.message);
                } else {
                    console.error('Error al guardar logros de localStorage en la BD:', data.message);
                }
            })
            .catch(error => {
                console.error('Error de red al enviar logros de localStorage:', error);
            });
        }

        // Llamar a la función para enviar los logros de localStorage a la DB al cargar la página
        // Esta llamada JS sigue siendo importante para sincronizar los logros locales con la DB.
        sendLocalAchievementsToDB();
    });
    </script>
</body>
</html>
<?php
// Cerrar la conexión a la base de datos al final del script PHP
if (isset($conn) && $conn) {
    $conn->close();
}
?>