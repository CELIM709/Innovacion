document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM completamente cargado y parseado.');

    const categoriaButtons = document.querySelectorAll('.categoria-item');
    const tituloContenido = document.getElementById('tituloContenido');
    const descripcionContenido = document.getElementById('descripcionContenido');
    const elementosAprendizaje = document.getElementById('elementosAprendizaje');
    const instruccionActividad = document.querySelector('.instruccion-actividad');
    const gameControls = document.getElementById('gameControls'); // Para controles de juego, si los hay

    // --- Funciones para manejar localStorage para los logros ---
    function getCount(key) {
        const value = localStorage.getItem(key);
        return parseInt(value || '0', 10);
    }

    function setCount(key, count) {
        localStorage.setItem(key, count.toString());
    }

    // Mapeo de categorías a sus claves de localStorage para los logros.
    const localStorageKeysLogros = {
        colores: 'logroColoresCount',
        formas: 'logroFormasCount',
        numeros: 'logroNumerosCount',
        letras: 'logroLetrasCount',
        rompecabezas: 'logroRompecabezasCount',
        matematicas: 'logroMatematicasCount',
        memoria: 'logroMemoriaCount',
        conteo: 'logroConteoCount'
    };
    // --- FIN Funciones localStorage ---

    let categoriaActiva = ''; // Variable para almacenar la categoría actualmente activa

    // Objeto con los datos y LÓGICA de las actividades
    const actividadesData = {
        colores: {
            titulo: 'Aprendiendo los Colores',
            descripcion: 'Toca cada círculo de color para ver su nombre.',
            instruccion: 'Toca cada círculo para escuchar su nombre.',
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
                hablarTexto(item.valor, categoriaKey);
            }
        },
        formas: {
            titulo: 'Conociendo las Formas',
            descripcion: 'Toca cada forma para aprender su nombre.',
            instruccion: 'Toca cada forma para escuchar su nombre.',
            render: () => {
                return [
                    { tipo: 'forma', valor: 'Círculo', html: '<i class="fas fa-circle" style="font-size: 3em;"></i>' },
                    { tipo: 'forma', valor: 'Cuadrado', html: '<i class="fas fa-square" style="font-size: 3em;"></i>' },
                    { tipo: 'forma', valor: 'Triángulo', html: '<i class="fas fa-caret-up" style="font-size: 3em;"></i>' },
                    { tipo: 'forma', valor: 'Rectángulo', html: '<div class="rectangulo-css"></div>' },
                    { tipo: 'forma', valor: 'Estrella', html: '<i class="fas fa-star" style="font-size: 3em;"></i>' },
                    { tipo: 'forma', valor: 'Corazón', html: '<i class="fas fa-heart" style="font-size: 3em;"></i>' }
                ];
            },
            onClick: (item, categoriaKey) => {
                hablarTexto(item.valor, categoriaKey);
            }
        },
        numeros: {
            titulo: 'Contando los Números',
            descripcion: 'Toca cada número para escucharlo y verlo.',
            instruccion: 'Toca cada número para escuchar su nombre.',
            render: () => {
                return [
                    { tipo: 'numero', valor: '1' }, { tipo: 'numero', valor: '2' }, { tipo: 'numero', valor: '3' },
                    { tipo: 'numero', valor: '4' }, { tipo: 'numero', valor: '5' }, { tipo: 'numero', valor: '6' },
                    { tipo: 'numero', valor: '7' }, { tipo: 'numero', valor: '8' }, { tipo: 'numero', valor: '9' },
                    { tipo: 'numero', valor: '10' }
                ];
            },
            onClick: (item, categoriaKey) => {
                hablarTexto(item.valor, categoriaKey);
            }
        },
        letras: {
            titulo: 'Explorando las Letras',
            descripcion: 'Toca cada letra para aprender su sonido.',
            instruccion: 'Toca cada letra para escuchar su sonido.',
            render: () => {
                return [
                    { tipo: 'letra', valor: 'A' }, { tipo: 'letra', valor: 'B' }, { tipo: 'letra', valor: 'C' },
                    { tipo: 'letra', valor: 'D' }, { tipo: 'letra', valor: 'E' }, { tipo: 'letra', valor: 'F' },
                    { tipo: 'letra', valor: 'G' }, { tipo: 'letra', valor: 'H' }, { tipo: 'letra', valor: 'I' },
                    { tipo: 'letra', valor: 'J' }, { tipo: 'letra', valor: 'K' }, { tipo: 'letra', 'valor': 'L' },
                    { tipo: 'letra', valor: 'M' }, { tipo: 'letra', valor: 'N' }, { tipo: 'letra', valor: 'O' },
                    { tipo: 'letra', valor: 'P' }, { tipo: 'letra', valor: 'Q' }, { tipo: 'letra', valor: 'R' },
                    { tipo: 'letra', valor: 'S' }, { tipo: 'letra', valor: 'T' }, { tipo: 'letra', valor: 'U' },
                    { tipo: 'letra', valor: 'V' }, { tipo: 'letra', valor: 'W' }, { tipo: 'letra', valor: 'X' },
                    { tipo: 'letra', valor: 'Y' }, { tipo: 'letra', valor: 'Z' }
                ];
            },
            onClick: (item, categoriaKey) => {
                hablarTexto(item.valor, categoriaKey);
            }
        },
        // --- Implementaciones para los "nuevos" juegos, ahora con elementos interactivos ---
        rompecabezas: {
            titulo: 'Arma el Rompecabezas',
            descripcion: 'Toca una pieza para escuchar su descripción.',
            instruccion: '¡Intenta armar la imagen!',
            render: () => {
                // Aquí podrías generar las piezas del rompecabezas
                return [
                    { tipo: 'rompecabezas-pieza', valor: 'Pieza de la esquina superior izquierda', html: '<img src="ruta/a/pieza1.png" alt="Pieza 1" style="width: 100px; height: 100px; border: 1px solid #ccc;">' },
                    { tipo: 'rompecabezas-pieza', valor: 'Pieza del centro', html: '<img src="ruta/a/pieza2.png" alt="Pieza 2" style="width: 100px; height: 100px; border: 1px solid #ccc;">' },
                    { tipo: 'rompecabezas-pieza', valor: 'Pieza del borde inferior', html: '<img src="ruta/a/pieza3.png" alt="Pieza 3" style="width: 100px; height: 100px; border: 1px solid #ccc;">' },
                    // Añade más piezas según sea necesario
                    { tipo: 'rompecabezas-info', valor: 'Arrastra y suelta las piezas para formar la imagen. Toca para escuchar la descripción de la pieza.', html: '<p style="text-align: center; width: 100%;">¡Arrastra las piezas!</p>' }
                ];
            },
            onClick: (item, categoriaKey) => {
                hablarTexto(item.valor, categoriaKey); // Hará que hable el valor de la pieza
            }
        },
        matematicas: {
            titulo: 'Matemáticas Divertidas',
            descripcion: 'Toca las operaciones para escucharlas y resolverlas.',
            instruccion: '¡Practica sumas y restas!',
            render: () => {
                // Aquí podrías generar problemas de matemáticas
                return [
                    { tipo: 'matematicas-problema', valor: 'Dos más dos', html: '<span style="font-size: 2.5em; font-weight: bold;">2 + 2 = ?</span>' },
                    { tipo: 'matematicas-problema', valor: 'Cinco menos uno', html: '<span style="font-size: 2.5em; font-weight: bold;">5 - 1 = ?</span>' },
                    { tipo: 'matematicas-problema', valor: 'Siete más tres', html: '<span style="font-size: 2.5em; font-weight: bold;">7 + 3 = ?</span>' },
                    { tipo: 'matematicas-info', valor: 'Toca cada operación para que te diga el problema. Luego intenta responder.', html: '<p style="text-align: center; width: 100%;">¡Resuelve los problemas!</p>' }
                ];
            },
            onClick: (item, categoriaKey) => {
                hablarTexto(item.valor, categoriaKey); // Hará que hable el problema
            }
        },
        memoria: {
            titulo: 'Juego de Memoria',
            descripcion: 'Toca las cartas para encontrar las parejas.',
            instruccion: '¡Encuentra las parejas de cartas!',
            render: () => {
                // Aquí podrías generar las cartas de memoria
                return [
                    { tipo: 'memoria-carta', valor: 'Carta uno', html: '<div style="width: 80px; height: 80px; background-color: lightblue; display: flex; align-items: center; justify-content: center; border-radius: 10px;">?</div>' },
                    { tipo: 'memoria-carta', valor: 'Carta dos', html: '<div style="width: 80px; height: 80px; background-color: lightcoral; display: flex; align-items: center; justify-content: center; border-radius: 10px;">?</div>' },
                    { tipo: 'memoria-carta', valor: 'Carta tres', html: '<div style="width: 80px; height: 80px; background-color: lightgreen; display: flex; align-items: center; justify-content: center; border-radius: 10px;">?</div>' },
                    { tipo: 'memoria-info', valor: 'Toca las cartas para voltearlas y encontrar sus parejas.', html: '<p style="text-align: center; width: 100%;">¡A jugar memoria!</p>' }
                ];
            },
            onClick: (item, categoriaKey) => {
                hablarTexto(item.valor, categoriaKey); // Hará que hable la descripción de la carta (ej. "Carta volteada")
            }
        },
        conteo: {
            titulo: 'A Contar Objetos',
            descripcion: 'Toca los grupos de objetos para contarlos.',
            instruccion: '¡Vamos a contar!',
            render: () => {
                // Aquí podrías generar objetos para contar
                return [
                    { tipo: 'conteo-objeto', valor: 'Hay tres manzanas', html: '<i class="fas fa-apple-alt" style="font-size: 3em; color: red;"></i><i class="fas fa-apple-alt" style="font-size: 3em; color: red;"></i><i class="fas fa-apple-alt" style="font-size: 3em; color: red;"></i>' },
                    { tipo: 'conteo-objeto', valor: 'Hay cinco estrellas', html: '<i class="fas fa-star" style="font-size: 2em; color: gold;"></i><i class="fas fa-star" style="font-size: 2em; color: gold;"></i><i class="fas fa-star" style="font-size: 2em; color: gold;"></i><i class="fas fa-star" style="font-size: 2em; color: gold;"></i><i class="fas fa-star" style="font-size: 2em; color: gold;"></i>' },
                    { tipo: 'conteo-info', valor: 'Toca cada grupo de objetos y cuenta cuántos hay.', html: '<p style="text-align: center; width: 100%;">¿Cuántos hay?</p>' }
                ];
            },
            onClick: (item, categoriaKey) => {
                hablarTexto(item.valor, categoriaKey); // Hará que hable la cantidad de objetos
            }
        }
    };

    // Función principal para mostrar el contenido de una categoría
    function mostrarContenidoCategoria(categoriaKey) {
        console.log(`Intentando mostrar contenido para: ${categoriaKey}`);
        const data = actividadesData[categoriaKey];

        if (data) {
            tituloContenido.textContent = data.titulo;
            descripcionContenido.textContent = data.descripcion;
            instruccionActividad.textContent = data.instruccion;
            elementosAprendizaje.innerHTML = ''; // Limpiar contenido anterior
            gameControls.innerHTML = ''; // Limpiar controles de juego

            categoriaActiva = categoriaKey; // Actualizar la categoría activa

            const elementos = data.render();
            elementos.forEach(item => {
                const itemDiv = document.createElement('div');
                itemDiv.classList.add('learning-item');

                // Añadir clases específicas para CSS si es necesario
                if (item.tipo === 'color') {
                    itemDiv.classList.add('color-item');
                    itemDiv.style.backgroundColor = item.color;
                    if (item.textColor) {
                        itemDiv.style.color = item.textColor;
                    }
                } else if (item.tipo === 'forma') {
                    itemDiv.classList.add('forma-item');
                } else if (item.tipo === 'numero') {
                    itemDiv.classList.add('numero-item');
                } else if (item.tipo === 'letra') {
                    itemDiv.classList.add('letra-item');
                }
                // Nuevas clases para los elementos de los nuevos juegos
                else if (item.tipo === 'rompecabezas-pieza') {
                    itemDiv.classList.add('puzzle-piece-item');
                }
                else if (item.tipo === 'matematicas-problema') {
                    itemDiv.classList.add('math-problem-item');
                }
                else if (item.tipo === 'memoria-carta') {
                    itemDiv.classList.add('memory-card-item');
                }
                else if (item.tipo === 'conteo-objeto') {
                    itemDiv.classList.add('count-object-item');
                }
                else if (item.tipo === 'info' || item.tipo.endsWith('-info')) { // Para mensajes informativos
                    itemDiv.classList.add('info-message');
                }


                // Contenido del item
                if (item.html) {
                    itemDiv.innerHTML = item.html;
                } else {
                    itemDiv.textContent = item.valor;
                }

                itemDiv.addEventListener('click', () => {
                    if (data.onClick) {
                        data.onClick(item, categoriaKey);
                    }
                });
                elementosAprendizaje.appendChild(itemDiv);
            });

            // Ocultar/mostrar el área de juego si no hay elementos o si la actividad es especial
            // Esta lógica es más para cuando implementes juegos complejos que requieran DOM externo o Canvas
            // Por ahora, con los elementos de ejemplo, siempre se mostrará algo.
            if (elementos.length === 0) {
                elementosAprendizaje.style.display = 'none';
            } else {
                elementosAprendizaje.style.display = 'flex'; // O block, según tu CSS
            }

            // La instrucción siempre se mostrará, ya que incluso los juegos tienen una instrucción
            instruccionActividad.style.display = 'block';

        } else {
            console.error(`Categoría ${categoriaKey} no encontrada en actividadesData.`);
            tituloContenido.textContent = 'Actividad No Encontrada';
            descripcionContenido.textContent = 'Parece que esta actividad aún no está disponible.';
            instruccionActividad.textContent = '';
            elementosAprendizaje.innerHTML = '<p>Lo sentimos, esta actividad no se ha cargado correctamente.</p>';
            elementosAprendizaje.style.display = 'flex';
        }
    }

    // Función para la síntesis de voz
    function hablarTexto(texto, categoriaKey) {
        if ('speechSynthesis' in window) {
            const utterance = new SpeechSynthesisUtterance(texto);
            // Puedes configurar el idioma y la voz si lo deseas
            utterance.lang = 'es-ES'; 
            // const voices = window.speechSynthesis.getVoices();
            // utterance.voice = voices.find(voice => voice.lang === 'es-ES');

            utterance.onend = () => {
                console.log(`Texto "${texto}" hablado.`);
                // Incrementa el logro solo si se completa la lectura
                const key = localStorageKeysLogros[categoriaKey];
                if (key) {
                    let count = getCount(key);
                    count++;
                    setCount(key, count);
                    console.log(`Logro para ${categoriaKey}: ${count}`);
                }
            };
            utterance.onerror = (event) => {
                console.error('Error en la síntesis de voz:', event.error);
            };
            window.speechSynthesis.speak(utterance);
        } else {
            console.warn('La síntesis de voz no es compatible con este navegador.');
            // Si la voz no funciona, al menos incrementamos el logro para que la funcionalidad avance.
            const key = localStorageKeysLogros[categoriaKey];
            if (key) {
                let count = getCount(key);
                count++;
                setCount(key, count);
                console.log(`Logro para ${categoriaKey} (sin voz): ${count}`);
            }
        }
    }

    // --- Inicialización y Asignación de Eventos ---

    // Asegurarse de que cada botón de categoría tiene un event listener
    categoriaButtons.forEach(button => {
        console.log(`Asignando click listener a botón: ${button.textContent} (data-categoria: ${button.dataset.categoria})`);
        button.addEventListener('click', () => {
            // Eliminar 'active' de todos los botones y añadirlo al clickeado
            categoriaButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');

            const categoriaKey = button.dataset.categoria;
            mostrarContenidoCategoria(categoriaKey);
        });
    });

    // Cargar la primera categoría por defecto al inicio
    const defaultCategoryButton = document.querySelector('.categoria-item.active');
    if (defaultCategoryButton) {
        mostrarContenidoCategoria(defaultCategoryButton.dataset.categoria);
    } else {
        mostrarContenidoCategoria('colores'); // Carga Colores por defecto si no hay activo
        const coloresBtn = document.querySelector('[data-categoria="colores"]');
        if (coloresBtn) {
            coloresBtn.classList.add('active');
        }
    }

    // Función para ir a la página principal
    document.getElementById('goHomeBtn').addEventListener('click', () => {
        window.location.href = 'index.html'; // Ajusta esto a la ruta de tu index.html
    });
});