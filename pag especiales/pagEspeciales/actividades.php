<?php
session_start();
// Verificar que el usuario esté logueado y que su rol sea 'representante'
// Si no hay sesión o el rol no es 'representante', redirigir a la página de inicio de sesión
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'representante') {
    header("Location: index.php"); // Asumiendo que index.php es tu página de login
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Actividades Interactivas</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
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

        .contenedor-actividades {
            background-color: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 40px 30px;
            text-align: center;
            width: 100%;
            max-width: 700px; /* Un poco más ancho para los juegos */
        }

        h1 {
            font-size: 2.2em;
            color: #333;
            margin-bottom: 10px;
            line-height: 1.2;
        }

        .subtitulo {
            font-size: 1.1em;
            color: #666;
            margin-bottom: 30px;
        }

        .menu-categorias {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            margin-bottom: 30px;
        }

        .categoria-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 15px 10px;
            border-radius: 15px;
            text-decoration: none;
            color: #fff; /* Color de texto por defecto, se ajustará por clase de color */
            font-size: 1em;
            font-weight: 700;
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: none;
            cursor: pointer;
            min-width: 100px;
            flex: 1;
            max-width: 120px;
        }

        .categoria-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .icono-categoria {
            font-size: 2em;
            margin-bottom: 5px;
            color: rgba(255, 255, 255, 0.9); /* Color de icono por defecto, se ajustará */
        }

        /* --- COLORES DE LAS CATEGORÍAS (AJUSTADOS A image_004b5d.png) --- */

        .categoria-item.azul-claro { /* Este es para "Colores" */
            background-color: #bbdefb; /* Azul muy claro */
            color: #333; /* Texto oscuro para buen contraste */
        }
        .categoria-item.azul-claro .icono-categoria {
            color: rgba(51, 51, 51, 0.9); /* Icono oscuro */
        }

        .categoria-item.amarillo { /* Este es para "Formas" */
            background-color: #ffe0b2; /* Naranja/Durazno claro */
            color: #6d4d00; /* Texto oscuro para buen contraste */
        }
        .categoria-item.amarillo .icono-categoria {
            color: #6d4d00; /* Icono oscuro */
        }

        .categoria-item.naranja { /* Este es para "Números" */
            background-color: #ffcdd2; /* Rosa/Rojo pálido */
            color: #333; /* Texto oscuro para buen contraste */
        }
        .categoria-item.naranja .icono-categoria {
            color: rgba(51, 51, 51, 0.9); /* Icono oscuro */
        }

        .categoria-item.azul-oscuro { /* Este es para "Letras" */
            background-color: #c8e6c9; /* Verde claro */
            color: #333; /* Texto oscuro para buen contraste */
        }
        .categoria-item.azul-oscuro .icono-categoria {
            color: rgba(51, 51, 51, 0.9); /* Icono oscuro */
        }

        /* --- FIN COLORES DE LAS CATEGORÍAS AJUSTADOS --- */


        /* Mantén los colores de tus otras categorías como los tenías: */
        .verde { background-color: #6cb65d; } /* Rompecabezas */
        .morado { background-color: #9b59b6; } /* Matemáticas */
        .rosa { background-color: #fd79a8; } /* Memoria */
        .rojo { background-color: #e74c3c; } /* Contar */


        /* Contenido de la actividad */
        .contenido-actividad {
            background-color: #e0f2f7; /* Color de fondo de la imagen "Conociendo las Formas" */
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            margin-top: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .contenido-actividad h2 {
            font-size: 1.8em;
            color: #333;
            margin-top: 0;
            margin-bottom: 10px;
        }

        .contenido-actividad p {
            font-size: 1.1em;
            color: #555;
            line-height: 1.5;
            margin-bottom: 20px;
        }

        .juego-area {
            min-height: 250px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 10px;
            position: relative; /* Para algunos juegos que necesitan posicionamiento */
        }

        .elementos-aprendizaje {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            align-items: center;
        }

        .elemento-item {
            width: 90px;
            height: 90px;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-size: 2em;
            font-weight: 800;
            color: #333;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border: 3px solid transparent;
        }

        .elemento-item:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 12px rgba(0, 0, 0, 0.15);
            border-color: #4a90e2; /* Color de borde al pasar el mouse */
        }

        .elemento-item img {
            max-width: 80%;
            max-height: 80%;
            object-fit: contain;
        }

        .bolita-color {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: var(--color-bolita);
            box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.2);
        }

        /* Estilo para el rectángulo del ejemplo */
        .rectangulo-css {
            width: 60px;
            height: 40px;
            border: 3px solid #333;
            border-radius: 5px;
            background-color: transparent;
            box-sizing: border-box;
        }

        .instruccion-actividad {
            font-size: 0.9em;
            color: #888;
            margin-top: 25px;
            font-style: italic;
        }

        .game-controls {
            margin-top: 20px;
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .game-button {
            background-color: #4CAF50; /* Verde */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1em;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .game-button.secondary {
            background-color: #007bff; /* Azul */
        }
        .game-button.danger {
            background-color: #dc3545; /* Rojo */
        }

        .game-button:hover {
            transform: translateY(-2px);
            opacity: 0.9;
        }

        /* --- Estilos Específicos para los Nuevos Juegos --- */

        /* Rompecabezas */
        .puzzle-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr); /* 3x3 rompecabezas */
            grid-template-rows: repeat(3, 1fr);
            width: 300px; /* Tamaño total del rompecabezas */
            height: 300px;
            border: 3px solid #4a90e2;
            background-color: #e0f2f7;
            border-radius: 10px;
            overflow: hidden;
            margin: 20px auto;
            position: relative;
        }

        .puzzle-piece {
            width: 100%; /* Las piezas toman el 100% del tamaño de su celda */
            height: 100%;
            background-image: var(--puzzle-image); /* Usamos una variable CSS para la imagen base64 */
            background-size: 300px 300px; /* Tamaño de la imagen completa */
            border: 1px solid rgba(0,0,0,0.1);
            box-sizing: border-box;
            cursor: grab;
            transition: transform 0.1s ease-out;
        }

        .puzzle-piece.dragging {
            opacity: 0.7;
            transform: scale(1.1);
            z-index: 1000;
        }

        .puzzle-empty {
            background-color: rgba(0,0,0,0.05); /* Ligeramente visible para indicar el espacio */
            border: 2px dashed #999;
            display: flex; /* Para centrar la pieza si la arrastran dentro */
            justify-content: center;
            align-items: center;
        }

        /* Matemáticas */
        .math-quiz {
            font-size: 2.5em;
            font-weight: bold;
            color: #333;
            margin-bottom: 25px;
        }

        .math-options {
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .math-option-button {
            background-color: #f0f0f0;
            border: 2px solid #ccc;
            border-radius: 10px;
            padding: 15px 30px;
            font-size: 1.5em;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.2s ease;
            min-width: 100px;
        }

        .math-option-button:hover {
            background-color: #e0e0e0;
            border-color: #999;
            transform: translateY(-2px);
        }

        .math-option-button.correct {
            background-color: #d4edda;
            border-color: #28a745;
        }

        .math-option-button.incorrect {
            background-color: #f8d7da;
            border-color: #dc3545;
        }

        /* Memoria */
        .memory-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-template-rows: repeat(4, 1fr);
            gap: 10px;
            width: 420px; /* 4 * 100px (card) + 3 * 10px (gap) */
            margin: 20px auto;
        }

        .memory-card {
            width: 100px;
            height: 100px;
            background-color: #4a90e2; /* Color de la parte trasera de la tarjeta */
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            font-size: 3em;
            color: #fff;
            font-weight: bold;
            transition: transform 0.6s; /* Transición más suave para el volteo */
            transform-style: preserve-3d;
            position: relative;
        }

        .memory-card.flipped {
            transform: rotateY(180deg);
        }

        .memory-card.matched {
            opacity: 0.5;
            cursor: default;
        }

        .memory-card .card-face {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden; /* Oculta la parte trasera cuando no está volteada */
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .memory-card .card-front {
            background-color: #fff; /* Color del frente de la tarjeta */
            color: #333;
            transform: rotateY(180deg); /* El frente está volteado por defecto para aparecer al voltear la tarjeta */
        }
        .memory-card .card-front img {
            max-width: 80%;
            max-height: 80%;
            object-fit: contain;
        }


        /* Conteo de Objetos */
        .conteo-area {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .conteo-objeto-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .conteo-objeto {
            width: 80px;
            height: 80px;
            background-color: #fff;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 3px 6px rgba(0,0,0,0.1);
            cursor: pointer;
            transition: transform 0.2s ease, opacity 0.2s ease;
        }
        .conteo-objeto:hover {
            transform: translateY(-3px);
        }
        .conteo-objeto.clicked {
            opacity: 0.6;
            transform: scale(0.95);
        }
        .conteo-objeto img {
            max-width: 90%;
            max-height: 90%;
            object-fit: contain;
        }
        .conteo-respuesta {
            font-size: 2.5em;
            font-weight: bold;
            color: #4a90e2;
            margin-top: 15px;
            min-height: 1.5em;
        }
        /* --- Estilos Generales para el Contenedor de Actividades --- */
/* Asegúrate de que tu main-content tenga un max-width y esté centrado */
.main-content {
    max-width: 900px; /* Un ancho razonable para la tarjeta principal */
    margin: 30px auto; /* Centrar la tarjeta en la página */
    padding: 30px;
    background-color: #ffffff; /* Fondo blanco para la tarjeta */
    border-radius: 25px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1); /* Sombra más pronunciada */
    text-align: center; /* Centrar texto dentro del main-content */
}

/* Títulos y Descripciones */
#tituloContenido {
    font-size: 2.5em;
    color: #34495e;
    margin-bottom: 10px;
}

#descripcionContenido {
    font-size: 1.2em;
    color: #555;
    margin-bottom: 25px;
}

.instruccion-actividad {
    font-size: 1.3em;
    font-weight: bold;
    color: #2c3e50;
    margin-top: 25px;
    margin-bottom: 20px;
}

/* Contenedor de los elementos de aprendizaje (elementosAprendizaje) */
#elementosAprendizaje {
    display: flex;
    flex-wrap: wrap;
    justify-content: center; /* Centra los elementos horizontalmente */
    align-items: center; /* Centra los elementos verticalmente */
    gap: 20px; /* Espacio entre los elementos */
    padding: 20px 0;
    min-height: 200px; /* Asegura un área mínima para los elementos */
}

/* --- Estilos para Colores, Formas, Números, Letras (para que se vean como tus imágenes) --- */
.learning-item {
    display: flex;
    flex-direction: column; /* Apila el contenido si hay texto e icono */
    justify-content: center;
    align-items: center;
    width: 100px; /* Tamaño de los cuadrados */
    height: 100px;
    border-radius: 15px; /* Bordes redondeados */
    background-color: #f0f4f8; /* Un fondo gris claro para los elementos */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    font-size: 1.6em; /* Tamaño de fuente para números/letras */
    font-weight: bold;
    color: #333;
    cursor: pointer;
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    text-decoration: none; /* Si se usan como enlaces */
}

.learning-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

/* Colores Específicos para .color-item si tuvieran texto */
.color-item {
    color: white; /* Por defecto para el texto sobre colores oscuros */
    border: 2px solid transparent; /* Para evitar que el color del borde se superponga */
    /* El background-color se define directamente en el JS */
}

/* Ajuste para el texto en el círculo blanco */
.color-item[style*="background-color: rgb(236, 240, 241)"] { /* blanco */
    color: #333; /* Texto oscuro para el fondo claro */
}

/* Estilo para las formas SVG o iconos de FontAwesome */
.forma-item i {
    font-size: 3em; /* Iconos más grandes */
    color: #555; /* Color oscuro para las formas */
}

/* Estilo para el Rectángulo en Formas (asegúrate de que este también esté en tu CSS) */
.rectangulo-css {
    width: 4em;
    height: 2em;
    border: 3px solid currentColor; /* Usa el color actual del texto del padre */
    margin: 0.5em; /* Ajusta si es necesario */
    display: inline-block;
    border-radius: 5px;
    color: #555; /* Color del borde del rectángulo */
}


/* --- Estilos para Identificar y Matemáticas --- */
.identification-question, .math-question {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 25px; /* Más espacio */
    padding: 30px;
    background-color: #f8f9fa;
    border-radius: 20px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    max-width: 650px;
    margin: 20px auto;
}

.identification-image {
    width: 200px; /* Más grande */
    height: 200px;
    object-fit: contain; /* Para que la imagen se vea completa */
    border-radius: 15px;
    border: 3px solid #eee;
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
}

.math-problem {
    font-size: 3.5em; /* Más grande */
    font-weight: bold;
    color: #34495e;
    margin-bottom: 20px;
}

.identification-options, .math-options, .counting-options { /* Las opciones de conteo también usan este estilo */
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px; /* Espacio entre botones */
}

.option-button {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 15px 30px; /* Más padding */
    border-radius: 10px; /* Más redondeado */
    font-size: 1.4em; /* Texto más grande */
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
    min-width: 150px;
    text-align: center;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.option-button:hover {
    background-color: #0056b3;
    transform: translateY(-3px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.option-button:active {
    transform: translateY(0);
    background-color: #004085;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
}


/* --- Estilos para Memoria --- */
.memory-game-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 100%;
    max-width: 650px; /* Ancho consistente */
    margin: 20px auto;
    padding: 30px;
    background-color: #f0f8ff;
    border-radius: 20px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

.word-to-memorize {
    font-size: 4.5em; /* Más grande aún */
    font-weight: bold;
    color: #34495e;
    min-height: 120px; /* Altura para evitar saltos */
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 1;
    transition: opacity 0.5s ease-out;
}

.word-to-memorize.hidden {
    opacity: 0;
    pointer-events: none;
}

.memory-options-hidden {
    display: none;
    opacity: 0;
    transition: opacity 0.5s ease-in;
}

.memory-options-visible {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
    width: 100%;
    opacity: 1;
}

.memory-option-button {
    /* Utiliza los estilos base de .option-button para consistencia */
    background-color: #007bff;
    color: white;
    border: none;
    padding: 15px 30px;
    border-radius: 10px;
    font-size: 1.5em; /* Un poco más grandes para las palabras */
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
    min-width: 180px; /* Un poco más ancho para palabras */
    text-align: center;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.memory-option-button:hover {
    background-color: #0056b3;
    transform: translateY(-3px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.memory-option-button:active {
    transform: translateY(0);
    background-color: #004085;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
}

/* --- Estilos para Contar --- */
.counting-question {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 30px; /* Espacio generoso */
    padding: 30px;
    background-color: #e6f7ff; /* Un azul muy suave */
    border-radius: 20px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    max-width: 700px;
    margin: 20px auto;
}

.objects-display {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    gap: 15px; /* Espacio entre los objetos individuales */
    min-height: 120px; /* Altura mínima para contener objetos */
    padding: 10px;
    border: 2px dashed #a0d8f0; /* Borde punteado para el área de objetos */
    border-radius: 10px;
    background-color: #ffffff; /* Fondo blanco para el área de objetos */
}

.objects-display i { /* Estilo para los iconos de FontAwesome usados como objetos */
    font-size: 4em; /* Iconos de objeto grandes */
    margin: 0 5px; /* Pequeño margen para separación visual */
    text-shadow: 1px 1px 2px rgba(0,0,0,0.1); /* Sombra ligera para los objetos */
}
/* Esto ocultará el nombre de la forma que aparece debajo del icono */
.forma-item span {
    display: none; /* Oculta completamente el elemento */
    /* También podrías usar:
    opacity: 0; */ /* Lo hace invisible pero sigue ocupando espacio */
}

/* Si quieres que los iconos estén centrados sin el texto debajo,
   asegúrate de que .forma-item tenga display: flex y alineación adecuada */
.forma-item {
    display: flex;
    flex-direction: column; /* Coloca el icono y el span en columna */
    justify-content: center; /* Centra verticalmente */
    align-items: center; /* Centra horizontalmente */
    /* Otros estilos que ya tengas para .forma-item */
}
.color-item span {
    display: none; /* Hace que el texto sea invisible y no ocupe espacio */
}
    </style>

    </head>
<body>
    <div class="contenedor-actividades">
    <h1>Mis Actividades Interactivas</h1>
    <p class="subtitulo">¡Vamos a aprender jugando!</p>

    <div class="menu-categorias">
        <button class="categoria-item azul-claro" data-categoria="colores">
            <i class="fas fa-palette icono-categoria"></i>
            <span>Colores</span>
        </button>
        <button class="categoria-item amarillo" data-categoria="formas">
            <i class="fas fa-shapes icono-categoria"></i>
            <span>Formas</span>
        </button>
        <button class="categoria-item naranja" data-categoria="numeros">
            <i class="fas fa-sort-numeric-up-alt icono-categoria"></i>
            <span>Números</span>
        </button>
        <button class="categoria-item azul-oscuro" data-categoria="letras">
            <i class="fas fa-font icono-categoria"></i>
            <span>Letras</span>
        </button>

        <button class="categoria-item verde" data-categoria="identificar">
            <i class="fas fa-puzzle-piece icono-categoria"></i> Identificar
        </button>

        <button class="categoria-item morado" data-categoria="matematicas">
            <i class="fas fa-calculator icono-categoria"></i>
            <span>Matemáticas</span>
        </button>
        <button class="categoria-item rosa" data-categoria="memoria">
            <i class="fas fa-brain icono-categoria"></i>
            <span>Memoria</span>
        </button>
        <button class="categoria-item rojo" data-categoria="conteo">
            <i class="fas fa-hand-pointer icono-categoria"></i>
            <span>Contar</span>
        </button>
    </div>

    <div id="contenidoActividad" class="contenido-actividad">
        <h2 id="tituloContenido">¡Elige una actividad para empezar!</h2>
        <p id="descripcionContenido">
            Haz clic en los botones de arriba para explorar y divertirte aprendiendo.
        </p>
        <p class="instruccion-actividad" id="instruccionActividad">
            Toca cada elemento para escucharlo o ver su nombre.
        </p>

        <div id="elementosAprendizaje" class="elementos-aprendizaje">
            </div>

        <div id="juegoArea" class="juego-area">
            </div>

        <div id="gameControls" class="game-controls"></div>
    </div>
</div>
    <script src="script-actividades.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM completamente cargado y parseado. (script-actividades.js)');

    const categoriaButtons = document.querySelectorAll('.categoria-item');
    const tituloContenido = document.getElementById('tituloContenido');
    const descripcionContenido = document.getElementById('descripcionContenido');
    const elementosAprendizaje = document.getElementById('elementosAprendizaje');
    const instruccionActividad = document.getElementById('instruccionActividad');
    const juegoArea = document.getElementById('juegoArea');
    const gameControls = document.getElementById('gameControls');

    // --- Funciones para manejar localStorage para los logros ---
    function getCount(key) {
        const value = localStorage.getItem(key);
        return parseInt(value || '0', 10);
    }

    function setCount(key, count) {
        localStorage.setItem(key, count.toString());
    }

    // Función unificada para incrementar un logro
    function incrementAchievement(categoriaKey) {
        const key = localStorageKeysLogros[categoriaKey];
        if (key) {
            let count = getCount(key);
            count++;
            setCount(key, count);
            console.log(`Logro para ${categoriaKey} incrementado a: ${count}`);
            // Aquí podrías añadir una pequeña notificación visual si quieres
        }
    }
    // --- FIN Funciones localStorage ---

    // Mapeo de categorías a sus claves de localStorage para los logros.
    const localStorageKeysLogros = {
        colores: 'logroColoresCount',
        formas: 'logroFormasCount',
        numeros: 'logroNumerosCount',
        letras: 'logroLetrasCount',
        identificar: 'logroIdentificarCount',
        matematicas: 'logroMatematicasCount',
        memoria: 'logroMemoriaCount',
        conteo: 'logroConteoCount'
    };

    let categoriaActiva = '';
    let currentIdentifyQuestionIndex = 0;
    let currentMathQuestionIndex = 0;
    let currentMemoryWordIndex = 0;
    let currentCountObjectIndex = 0;

    // --- Funciones para la síntesis de voz ---
    // La función hablarTexto YA NO incrementará el logro por defecto.
    // El incremento se hará SÓLO cuando la acción sea completada/correcta.
    function hablarTexto(texto) {
        if ('speechSynthesis' in window) {
            const utterance = new SpeechSynthesisUtterance(texto);
            utterance.lang = 'es-ES';
            utterance.onerror = (event) => {
                console.error('Error en la síntesis de voz:', event.error);
            };
            window.speechSynthesis.speak(utterance);
        } else {
            console.warn('La síntesis de voz no es compatible con este navegador.');
        }
    }

    // --- Arrays de preguntas para las nuevas categorías ---
    const identifyQuestions = [
        { objectHtml: '<i class="fas fa-cat fa-5x"></i>', correctAnswer: 'Gato', options: ['Perro', 'Gato', 'Ratón', 'León'] },
        { objectHtml: '<i class="fas fa-dog fa-5x"></i>', correctAnswer: 'Perro', options: ['Gato', 'Perro', 'Lobo', 'Zorro'] },
        { objectHtml: '<i class="fas fa-heart fa-5x" style="color: #e74c3c;"></i>', correctAnswer: 'Corazón', options: ['Estrella', 'Círculo', 'Corazón', 'Cuadrado'] },
        { objectHtml: '<i class="fas fa-star fa-5x" style="color: gold;"></i>', correctAnswer: 'Estrella', options: ['Luna', 'Sol', 'Estrella', 'Nube'] },
        { objectHtml: '<i class="fas fa-car fa-5x"></i>', correctAnswer: 'Coche', options: ['Bicicleta', 'Avión', 'Coche', 'Tren'] },
        { objectHtml: '<i class="fas fa-fish fa-5x" style="color: #3498db;"></i>', correctAnswer: 'Pez', options: ['Gato', 'Pez', 'Perro', 'Pájaro'] },
        { objectHtml: '<i class="fas fa-tree fa-5x" style="color: #2ecc71;"></i>', correctAnswer: 'Árbol', options: ['Flor', 'Arbusto', 'Hierba', 'Árbol'] },
        { objectHtml: '<i class="fas fa-apple-alt fa-5x" style="color: red;"></i>', correctAnswer: 'Manzana', options: ['Pera', 'Plátano', 'Manzana', 'Naranja'] },
        { objectHtml: '<i class="fas fa-pizza-slice fa-5x" style="color: orange;"></i>', correctAnswer: 'Pizza', options: ['Hamburguesa', 'Taco', 'Pizza', 'Pasta'] },
        { objectHtml: '<i class="fas fa-cloud fa-5x" style="color: #bdc3c7;"></i>', correctAnswer: 'Nube', options: ['Sol', 'Luna', 'Nube', 'Estrella'] }
    ];

    const mathQuestions = [
        { num1: 2, num2: 3, operator: '+', correctAnswer: '5', options: ['4', '5', '6', '7'] },
        { num1: 5, num2: 1, operator: '-', correctAnswer: '4', options: ['3', '4', '5', '6'] },
        { num1: 7, num2: 2, operator: '+', correctAnswer: '9', options: ['8', '9', '10', '11'] },
        { num1: 10, num2: 4, operator: '-', correctAnswer: '6', options: ['5', '6', '7', '8'] },
        { num1: 6, num2: 3, operator: '+', correctAnswer: '9', options: ['7', '8', '9', '10'] }
    ];

    const memoryWords = [
        { word: 'Elefante', correctSpelling: 'Elefante', options: ['Elefante', 'Eléfante', 'Elesfante', 'Elifante'] },
        { word: 'Computadora', correctSpelling: 'Computadora', options: ['Compotadora', 'Comutadora', 'Computadora', 'Comptadora'] },
        { word: 'Mariposa', correctSpelling: 'Mariposa', options: ['Maripoza', 'Mariiposa', 'Mariposa', 'Maripossa'] },
        { word: 'Estrella', correctSpelling: 'Estrella', options: ['Estreya', 'Estrella', 'Estrela', 'Etrella'] },
        { word: 'Chocolate', correctSpelling: 'Chocolate', options: ['Chocollate', 'Chocolate', 'Chocholate', 'Chocoolate'] }
    ];

    const countObjects = [
        { objectHtml: '<i class="fas fa-apple-alt" style="color: red;"></i>', count: 3, options: ['2', '3', '4', '5'] },
        { objectHtml: '<i class="fas fa-star" style="color: gold;"></i>', count: 5, options: ['4', '5', '6', '7'] },
        { objectHtml: '<i class="fas fa-leaf" style="color: green;"></i>', count: 4, options: ['3', '4', '5', '6'] },
        { objectHtml: '<i class="fas fa-moon" style="color: #999;"></i>', count: 2, options: ['1', '2', '3', '4'] },
        { objectHtml: '<i class="fas fa-sun" style="color: orange;"></i>', count: 6, options: ['5', '6', '7', '8'] }
    ];

    // Objeto con los datos y LÓGICA de las actividades
    const actividadesData = {
        colores: {
            titulo: 'Aprendiendo los Colores',
            descripcion: 'Toca cada círculo de color para ver su nombre.',
            render: () => {
                return [
                    { tipo: 'color', valor: 'Rojo', color: '#e74c3c' },
                    { tipo: 'color', valor: 'Azul', color: '#3498db' },
                    { tipo: 'color', valor: 'Amarillo', color: '#f1c40f', textColor: '#6d4d00' },
                    { tipo: 'color', valor: 'Verde', color: '#2ecc71' },
                    { tipo: 'color', valor: 'Naranja', color: '#e67e22' },
                    { tipo: 'color', valor: 'Morado', color: '#9b59b6' },
                    { tipo: 'color', valor: 'Rosa', color: '#fd79a8' },
                    { tipo: 'color', valor: 'Negro', color: '#34495e', textColor: '#fff' },
                    { tipo: 'color', valor: 'Blanco', color: '#ecf0f1', textColor: '#333' }
                ];
            },
            onClick: (item, categoriaKey) => {
                hablarTexto(item.valor); // Habla el nombre del color
                incrementAchievement(categoriaKey); // Incrementa el logro cada vez que se interactúa con un color
            }
        },
        formas: {
            titulo: 'Conociendo las Formas',
            descripcion: 'Toca cada forma para aprender su nombre.',
            render: () => {
                return [
                    { tipo: 'forma', valor: 'Círculo', html: '<i class="fas fa-circle" style="font-size: 3em;"></i>' },
                    { tipo: 'forma', valor: 'Cuadrado', html: '<i class="fas fa-square" style="font-size: 3em;"></i>' },
                    { tipo: 'forma', valor: 'Triángulo', html: '<i class="fas fa-caret-up" style="font-size: 3em;"></i>' },
                    { tipo: 'forma', valor: 'Rectángulo', html: '<div class="rectangulo-css" style="width: 4em; height: 2em; border: 3px solid currentColor; margin: 0.5em; display: inline-block;"></div>' },
                    { tipo: 'forma', valor: 'Estrella', html: '<i class="fas fa-star" style="font-size: 3em;"></i>' },
                    { tipo: 'forma', valor: 'Corazón', html: '<i class="fas fa-heart" style="font-size: 3em; color: #e74c3c;"></i>' }
                ];
            },
            onClick: (item, categoriaKey) => {
                hablarTexto(item.valor);
                incrementAchievement(categoriaKey);
            }
        },
        numeros: {
            titulo: 'Aprendiendo los Números',
            descripcion: 'Toca cada número para escucharlo.',
            render: () => {
                const nums = [];
                for (let i = 1; i <= 10; i++) {
                    nums.push({ tipo: 'numero', valor: i.toString() });
                }
                return nums;
            },
            onClick: (item, categoriaKey) => {
                hablarTexto(item.valor);
                incrementAchievement(categoriaKey);
            }
        },
        letras: {
            titulo: 'Explorando las Letras',
            descripcion: 'Toca cada letra para escuchar su sonido.',
            render: () => {
                const alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.split('');
                return alphabet.map(letra => ({ tipo: 'letra', valor: letra }));
            },
            onClick: (item, categoriaKey) => {
                hablarTexto(item.valor);
                incrementAchievement(categoriaKey);
            }
        },
        identificar: { // Nueva categoría: Identificar Objetos
            titulo: '¿Qué es esto?',
            descripcion: 'Mira la imagen y selecciona la respuesta correcta.',
            render: () => {
                return [];
            },
            onStartGame: (categoriaKey) => {
                currentIdentifyQuestionIndex = 0;
                displayIdentifyQuestion(categoriaKey);
            },
            onResetGame: (categoriaKey) => {
                currentIdentifyQuestionIndex = 0;
                displayIdentifyQuestion(categoriaKey);
            }
        },
        matematicas: { // Nueva categoría: Matemáticas
            titulo: 'Juego de Matemáticas',
            descripcion: 'Resuelve las operaciones de suma y resta.',
            render: () => {
                return [];
            },
            onStartGame: (categoriaKey) => {
                currentMathQuestionIndex = 0;
                displayMathQuestion(categoriaKey);
            },
            onResetGame: (categoriaKey) => {
                currentMathQuestionIndex = 0;
                displayMathQuestion(categoriaKey);
            }
        },
        memoria: { // Nueva categoría: Memoria
            titulo: 'Juego de Memoria',
            descripcion: 'Memoriza la palabra y luego identifícala.',
            render: () => {
                return [];
            },
            onStartGame: (categoriaKey) => {
                currentMemoryWordIndex = 0;
                displayMemoryGame(categoriaKey);
            },
            onResetGame: (categoriaKey) => {
                currentMemoryWordIndex = 0;
                displayMemoryGame(categoriaKey);
            }
        },
        conteo: { // Nueva categoría: Contar Objetos
            titulo: 'Contar Objetos',
            descripcion: 'Cuenta los objetos que aparecen y elige el número correcto.',
            render: () => {
                return [];
            },
            onStartGame: (categoriaKey) => {
                currentCountObjectIndex = 0;
                displayCountQuestion(categoriaKey);
            },
            onResetGame: (categoriaKey) => {
                currentCountObjectIndex = 0;
                displayCountQuestion(categoriaKey);
            }
        }
    };

    // --- Función principal para mostrar el contenido de la categoría ---
    function mostrarContenidoCategoria(categoriaKey) {
        categoriaActiva = categoriaKey;
        const data = actividadesData[categoriaKey];

        if (!data) {
            console.error('Categoría no encontrada:', categoriaKey);
            return;
        }

        tituloContenido.textContent = data.titulo;
        descripcionContenido.textContent = data.descripcion;
        instruccionActividad.textContent = data.instruccion;
        elementosAprendizaje.innerHTML = '';
        juegoArea.innerHTML = '';
        gameControls.innerHTML = '';

        if (data.render) {
            const items = data.render();
            items.forEach(item => {
                const itemDiv = document.createElement('div');
                itemDiv.classList.add('elemento-item', 'learning-item');

                if (item.tipo === 'color') {
                    itemDiv.classList.add('color-item');
                    itemDiv.style.backgroundColor = item.color;
                    if (item.textColor) {
                        itemDiv.style.color = item.textColor;
                    }
                    const bolita = document.createElement('div');
                    bolita.classList.add('bolita-color');
                    bolita.style.setProperty('--color-bolita', item.color);
                    itemDiv.appendChild(bolita);
                    const colorName = document.createElement('span');
                    colorName.textContent = item.valor;
                    colorName.style.marginTop = '5px';
                    itemDiv.appendChild(colorName);
                } else if (item.tipo === 'forma') {
                    itemDiv.classList.add('forma-item');
                    itemDiv.innerHTML = item.html;
                    const shapeName = document.createElement('span');
                    shapeName.textContent = item.valor;
                    shapeName.style.marginTop = '5px';
                    itemDiv.appendChild(shapeName);
                } else {
                    itemDiv.textContent = item.valor;
                }

                itemDiv.addEventListener('click', () => data.onClick(item, categoriaKey));
                elementosAprendizaje.appendChild(itemDiv);
            });
        }

        // --- Lógica para iniciar juegos "custom" ---
        if (['identificar', 'matematicas', 'memoria', 'conteo'].includes(categoriaKey)) {
            elementosAprendizaje.style.display = 'none'; // Oculta elementosAprendizaje si no se usan
            gameControls.innerHTML = `
                <button class="game-button secondary" id="reiniciarJuego">Reiniciar Juego</button>
                <button class="game-button" id="siguientePregunta">Siguiente</button>
            `;
            const reiniciarBtn = document.getElementById('reiniciarJuego');
            const siguienteBtn = document.getElementById('siguientePregunta');

            reiniciarBtn.addEventListener('click', () => data.onResetGame(categoriaKey));
            siguienteBtn.addEventListener('click', () => {
                if (categoriaKey === 'identificar') displayIdentifyQuestion(categoriaKey);
                else if (categoriaKey === 'matematicas') displayMathQuestion(categoriaKey);
                else if (categoriaKey === 'memoria') displayMemoryGame(categoriaKey);
                else if (categoriaKey === 'conteo') displayCountQuestion(categoriaKey);
            });
            data.onStartGame(categoriaKey); // Inicia el juego
        } else {
            elementosAprendizaje.style.display = 'flex'; // Asegurarse de que elementosAprendizaje esté visible para categorías normales
        }
    }

    // --- Lógica específica para "Identificar Objetos" ---
    function displayIdentifyQuestion(categoriaKey) {
        if (currentIdentifyQuestionIndex >= identifyQuestions.length) {
            instruccionActividad.textContent = '¡Has completado todas las preguntas de identificación!';
            juegoArea.innerHTML = '';
            gameControls.innerHTML = `<button class="game-button secondary" id="reiniciarJuego">Reiniciar Juego</button>`;
            document.getElementById('reiniciarJuego').addEventListener('click', () => actividadesData.identificar.onResetGame(categoriaKey));
            return;
        }

        const questionData = identifyQuestions[currentIdentifyQuestionIndex];
        juegoArea.innerHTML = `
            <div class="identification-question">
                <div class="identification-image-container">
                    ${questionData.objectHtml}
                </div>
                <div class="identification-options">
                    ${questionData.options.map(option => `
                        <button class="option-button" data-answer="${option}">${option}</button>
                    `).join('')}
                </div>
            </div>
        `;
        instruccionActividad.textContent = actividadesData.identificar.instruccion;
        hablarTexto(actividadesData.identificar.instruccion);

        const optionButtons = juegoArea.querySelectorAll('.option-button');
        optionButtons.forEach(button => {
            button.addEventListener('click', (event) => {
                const selectedAnswer = event.target.dataset.answer;
                if (selectedAnswer === questionData.correctAnswer) {
                    event.target.style.backgroundColor = '#28a745'; // Verde
                    hablarTexto(`¡Correcto! Es ${questionData.correctAnswer}.`);
                    incrementAchievement(categoriaKey); // ¡Incrementa el logro SOLO si es correcto!
                    setTimeout(() => {
                        currentIdentifyQuestionIndex++;
                        displayIdentifyQuestion(categoriaKey);
                    }, 1500);
                } else {
                    event.target.style.backgroundColor = '#dc3545'; // Rojo
                    hablarTexto(`Incorrecto. Era ${questionData.correctAnswer}.`);
                    const correctAnswerButton = Array.from(optionButtons).find(btn => btn.dataset.answer === questionData.correctAnswer);
                    if (correctAnswerButton) {
                        correctAnswerButton.style.backgroundColor = '#28a745'; // Muestra la correcta
                    }
                    setTimeout(() => {
                        currentIdentifyQuestionIndex++; // Avanza a la siguiente pregunta incluso si es incorrecto
                        displayIdentifyQuestion(categoriaKey);
                    }, 2000);
                }
            });
        });
    }

    // --- Lógica específica para "Matemáticas" ---
    function displayMathQuestion(categoriaKey) {
        if (currentMathQuestionIndex >= mathQuestions.length) {
            instruccionActividad.textContent = '¡Has completado todas las operaciones matemáticas!';
            juegoArea.innerHTML = '';
            gameControls.innerHTML = `<button class="game-button secondary" id="reiniciarJuego">Reiniciar Juego</button>`;
            document.getElementById('reiniciarJuego').addEventListener('click', () => actividadesData.matematicas.onResetGame(categoriaKey));
            return;
        }

        const questionData = mathQuestions[currentMathQuestionIndex];
        juegoArea.innerHTML = `
            <div class="math-question">
                <div class="math-problem">${questionData.num1} ${questionData.operator} ${questionData.num2} = ?</div>
                <div class="math-options">
                    ${questionData.options.map(option => `
                        <button class="math-option-button" data-answer="${option}">${option}</button>
                    `).join('')}
                </div>
            </div>
        `;
        instruccionActividad.textContent = actividadesData.matematicas.instruccion;
        hablarTexto(`${questionData.num1} ${questionData.operator} ${questionData.num2} ¿cuánto es?`);

        const optionButtons = juegoArea.querySelectorAll('.math-option-button');
        optionButtons.forEach(button => {
            button.addEventListener('click', (event) => {
                const selectedAnswer = event.target.dataset.answer;
                if (selectedAnswer === questionData.correctAnswer) {
                    event.target.classList.add('correct');
                    hablarTexto(`¡Correcto! Es ${questionData.correctAnswer}.`);
                    incrementAchievement(categoriaKey); // ¡Incrementa el logro SOLO si es correcto!
                    setTimeout(() => {
                        currentMathQuestionIndex++;
                        displayMathQuestion(categoriaKey);
                    }, 1500);
                } else {
                    event.target.classList.add('incorrect');
                    hablarTexto(`Incorrecto. La respuesta correcta era ${questionData.correctAnswer}.`);
                    const correctAnswerButton = Array.from(optionButtons).find(btn => btn.dataset.answer === questionData.correctAnswer);
                    if (correctAnswerButton) {
                        correctAnswerButton.classList.add('correct');
                    }
                    setTimeout(() => {
                        currentMathQuestionIndex++;
                        displayMathQuestion(categoriaKey);
                    }, 2000);
                }
            });
        });
    }

    // --- Lógica específica para "Memoria" ---
    function displayMemoryGame(categoriaKey) {
        if (currentMemoryWordIndex >= memoryWords.length) {
            instruccionActividad.textContent = '¡Has completado todas las palabras de memoria!';
            juegoArea.innerHTML = '';
            gameControls.innerHTML = `<button class="game-button secondary" id="reiniciarJuego">Reiniciar Juego</button>`;
            document.getElementById('reiniciarJuego').addEventListener('click', () => actividadesData.memoria.onResetGame(categoriaKey));
            return;
        }

        const wordData = memoryWords[currentMemoryWordIndex];
        juegoArea.innerHTML = `
            <div class="memory-game-container">
                <div class="word-to-memorize" id="wordToMemorize"></div>
                <div class="memory-options-hidden" id="memoryOptions">
                    ${wordData.options.map(option => `
                        <button class="memory-option-button" data-answer="${option}">${option}</button>
                    `).join('')}
                </div>
            </div>
        `;
        instruccionActividad.textContent = 'Memoriza esta palabra...';

        const wordDisplay = document.getElementById('wordToMemorize');
        const memoryOptions = document.getElementById('memoryOptions');

        wordDisplay.textContent = wordData.word;
        hablarTexto(wordData.word); // Habla la palabra a memorizar

        setTimeout(() => {
            wordDisplay.classList.add('hidden'); // Oculta la palabra
            instruccionActividad.textContent = 'Ahora, ¿cuál era la palabra?';
            memoryOptions.classList.remove('memory-options-hidden');
            memoryOptions.classList.add('memory-options-visible');
            hablarTexto('Ahora selecciona la palabra correcta.'); // Habla la instrucción para seleccionar

            const optionButtons = memoryOptions.querySelectorAll('.memory-option-button');
            optionButtons.forEach(button => {
                button.addEventListener('click', (event) => {
                    const selectedAnswer = event.target.dataset.answer;
                    if (selectedAnswer === wordData.correctSpelling) {
                        event.target.style.backgroundColor = '#28a745'; // Verde
                        hablarTexto(`¡Correcto! La palabra es ${wordData.correctSpelling}.`);
                        incrementAchievement(categoriaKey); // ¡Incrementa el logro SOLO si es correcto!
                        setTimeout(() => {
                            currentMemoryWordIndex++;
                            displayMemoryGame(categoriaKey);
                        }, 1500);
                    } else {
                        event.target.style.backgroundColor = '#dc3545'; // Rojo
                        hablarTexto(`Incorrecto. Era ${wordData.correctSpelling}.`);
                        const correctAnswerButton = Array.from(optionButtons).find(btn => btn.dataset.answer === wordData.correctSpelling);
                        if (correctAnswerButton) {
                            correctAnswerButton.style.backgroundColor = '#28a745';
                        }
                        setTimeout(() => {
                            currentMemoryWordIndex++;
                            displayMemoryGame(categoriaKey);
                        }, 2000);
                    }
                });
            });
        }, 3000); // Muestra la palabra por 3 segundos
    }

    // --- Lógica específica para "Contar Objetos" ---
    function displayCountQuestion(categoriaKey) {
        if (currentCountObjectIndex >= countObjects.length) {
            instruccionActividad.textContent = '¡Has completado todas las actividades de conteo!';
            juegoArea.innerHTML = '';
            gameControls.innerHTML = `<button class="game-button secondary" id="reiniciarJuego">Reiniciar Juego</button>`;
            document.getElementById('reiniciarJuego').addEventListener('click', () => actividadesData.conteo.onResetGame(categoriaKey));
            return;
        }

        const questionData = countObjects[currentCountObjectIndex];
        const objectsHtml = Array(questionData.count).fill(questionData.objectHtml).join('');

        juegoArea.innerHTML = `
            <div class="counting-question">
                <p class="instruccion-actividad">¿Cuántos ves?</p>
                <div class="objects-display">
                    ${objectsHtml}
                </div>
                <div class="counting-options">
                    ${questionData.options.map(option => `
                        <button class="option-button" data-answer="${option}">${option}</button>
                    `).join('')}
                </div>
            </div>
        `;
        instruccionActividad.textContent = actividadesData.conteo.instruccion;
        hablarTexto(actividadesData.conteo.instruccion);

        const optionButtons = juegoArea.querySelectorAll('.option-button');
        optionButtons.forEach(button => {
            button.addEventListener('click', (event) => {
                const selectedAnswer = event.target.dataset.answer;
                if (parseInt(selectedAnswer) === questionData.count) {
                    event.target.style.backgroundColor = '#28a745'; // Verde
                    hablarTexto(`¡Correcto! Hay ${questionData.count}.`);
                    incrementAchievement(categoriaKey); // ¡Incrementa el logro SOLO si es correcto!
                    setTimeout(() => {
                        currentCountObjectIndex++;
                        displayCountQuestion(categoriaKey);
                    }, 1500);
                } else {
                    event.target.style.backgroundColor = '#dc3545'; // Rojo
                    hablarTexto(`Incorrecto. Había ${questionData.count}.`);
                    const correctAnswerButton = Array.from(optionButtons).find(btn => parseInt(btn.dataset.answer) === questionData.count);
                    if (correctAnswerButton) {
                        correctAnswerButton.style.backgroundColor = '#28a745';
                    }
                    setTimeout(() => {
                        currentCountObjectIndex++;
                        displayCountQuestion(categoriaKey);
                    }, 2000);
                }
            });
        });
    }

    // --- Event Listeners para los botones de categoría ---
    categoriaButtons.forEach(button => {
        button.addEventListener('click', () => {
            const categoria = button.dataset.categoria;
            mostrarContenidoCategoria(categoria);
        });
    });

    // Iniciar con una categoría por defecto si se desea
    // Por ejemplo, al cargar la página, puedes mostrar la primera categoría:
    if (categoriaButtons.length > 0) {
         mostrarContenidoCategoria(categoriaButtons[0].dataset.categoria);
    }
});
    </script>
    </body>
</html>