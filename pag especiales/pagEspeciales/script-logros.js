document.addEventListener('DOMContentLoaded', () => {
    const logrosDivs = {
        rutina: document.getElementById('rutinaProgreso'),
        emociones: document.getElementById('emocionesProgreso'),
        colores: document.getElementById('coloresProgreso'),
        formas: document.getElementById('formasProgreso'),
        numeros: document.getElementById('numerosProgreso'),
        letras: document.getElementById('letrasProgreso'),
        // --- NUEVOS LOGROS AQUI ---
        identificar: document.getElementById('identificarProgreso'),
        matematicas: document.getElementById('matematicasProgreso'),
        memoria: document.getElementById('memoriaProgreso'),
        conteo: document.getElementById('conteoProgreso')
        // --- FIN NUEVOS LOGROS ---
    };
    const resetButton = document.getElementById('resetLogrosBtn');

    // Nombres de las claves en localStorage para cada tipo de logro
    const localStorageKeys = {
        rutina: 'logroRutinaCount',
        emociones: 'logroEmocionesCount',
        colores: 'logroColoresCount',
        formas: 'logroFormasCount',
        numeros: 'logroNumerosCount',
        letras: 'logroLetrasCount',
        // --- NUEVAS CLAVES DE LOCALSTORAGE ---
        identificar: 'logroIdentificarCount',
        matematicas: 'logroMatematicasCount',
        memoria: 'logroMemoriaCount',
        conteo: 'logroConteoCount'
        // --- FIN NUEVAS CLAVES ---
    };

    // Define los umbrales para los logros (ej. cuántas veces debe interactuar para un "logro")
    const umbralesLogros = {
        rutina: { visto: 5, entendido: 10 },
        emociones: { visto: 3, dominado: 7 },
        colores: { visto: 5, dominado: 10 },
        formas: { visto: 5, dominado: 10 },
        numeros: { visto: 10, dominado: 20 },
        letras: { visto: 15, dominado: 30 },
        // --- UMBRALES PARA NUEVOS LOGROS ---
        identificar: { visto: 3, dominado: 7 }, // Por ejemplo, 3 objetos identificados, luego 7
        matematicas: { visto: 3, dominado: 7 }, // 3 problemas resueltos, luego 7
        memoria: { visto: 3, dominado: 7 }, // 3 palabras recordadas, luego 7
        conteo: { visto: 3, dominado: 7 } // 3 conteos correctos, luego 7
        // --- FIN UMBRALES NUEVOS LOGROS ---
    };

    // Función para obtener un contador de localStorage
    function getCount(key) {
        return parseInt(localStorage.getItem(key) || '0', 10);
    }

    // Función para guardar un contador en localStorage
    function setCount(key, count) {
        localStorage.setItem(key, count.toString());
    }

    // Función para actualizar y mostrar los logros
    function actualizarLogros() {
        // --- Logros existentes ---
        const rutinaCount = getCount(localStorageKeys.rutina);
        logrosDivs.rutina.textContent = `Vista ${rutinaCount} veces.`;
        if (rutinaCount >= umbralesLogros.rutina.visto) {
            logrosDivs.rutina.textContent += ` ¡Bien hecho!`;
        }
        if (rutinaCount >= umbralesLogros.rutina.entendido) {
            logrosDivs.rutina.textContent = `¡Maestro de la rutina! (${rutinaCount} veces)`;
        }

        const emocionesCount = getCount(localStorageKeys.emociones);
        logrosDivs.emociones.textContent = `Exploradas ${emocionesCount} veces.`;
        if (emocionesCount >= umbralesLogros.emociones.visto) {
            logrosDivs.emociones.textContent += ` ¡Sigue así!`;
        }
        if (emocionesCount >= umbralesLogros.emociones.dominado) {
            logrosDivs.emociones.textContent = `¡Emociones bajo control! (${emocionesCount} veces)`;
        }

        const coloresCount = getCount(localStorageKeys.colores);
        logrosDivs.colores.textContent = `Vistos ${coloresCount} elementos.`;
        if (coloresCount >= umbralesLogros.colores.visto) {
            logrosDivs.colores.textContent += ` ¡Excelente!`;
        }
        if (coloresCount >= umbralesLogros.colores.dominado) {
            logrosDivs.colores.textContent = `¡Experto en colores! (${coloresCount} elementos)`;
        }

        const formasCount = getCount(localStorageKeys.formas);
        logrosDivs.formas.textContent = `Vistas ${formasCount} formas.`;
        if (formasCount >= umbralesLogros.formas.visto) {
            logrosDivs.formas.textContent += ` ¡Muy bien!`;
        }
        if (formasCount >= umbralesLogros.formas.dominado) {
            logrosDivs.formas.textContent = `¡Arquitecto de formas! (${formasCount} formas)`;
        }

        const numerosCount = getCount(localStorageKeys.numeros);
        logrosDivs.numeros.textContent = `Contados ${numerosCount} números.`;
        if (numerosCount >= umbralesLogros.numeros.visto) {
            logrosDivs.numeros.textContent += ` ¡Vas genial!`;
        }
        if (numerosCount >= umbralesLogros.numeros.dominado) {
            logrosDivs.numeros.textContent = `¡Cuentas como un pro! (${numerosCount} números)`;
        }

        const letrasCount = getCount(localStorageKeys.letras);
        logrosDivs.letras.textContent = `Descubiertas ${letrasCount} letras.`;
        if (letrasCount >= umbralesLogros.letras.visto) {
            logrosDivs.letras.textContent += ` ¡Fantástico!`;
        }
        if (letrasCount >= umbralesLogales.letras.dominado) {
            logrosDivs.letras.textContent = `¡Futuro escritor! (${letrasCount} letras)`;
        }

        // --- NUEVOS LOGROS ---
        const identificarCount = getCount(localStorageKeys.identificar);
        logrosDivs.identificar.textContent = `Identificados ${identificarCount} objetos.`;
        if (identificarCount >= umbralesLogros.identificar.visto) {
            logrosDivs.identificar.textContent += ` ¡Buen ojo!`;
        }
        if (identificarCount >= umbralesLogros.identificar.dominado) {
            logrosDivs.identificar.textContent = `¡Maestro identificador! (${identificarCount} objetos)`;
        }

        const matematicasCount = getCount(localStorageKeys.matematicas);
        logrosDivs.matematicas.textContent = `Resueltos ${matematicasCount} problemas.`;
        if (matematicasCount >= umbralesLogros.matematicas.visto) {
            logrosDivs.matematicas.textContent += ` ¡Genio matemático!`;
        }
        if (matematicasCount >= umbralesLogros.matematicas.dominado) {
            logrosDivs.matematicas.textContent = `¡Calculadora humana! (${matematicasCount} problemas)`;
        }

        const memoriaCount = getCount(localStorageKeys.memoria);
        logrosDivs.memoria.textContent = `Recordadas ${memoriaCount} palabras.`;
        if (memoriaCount >= umbralesLogros.memoria.visto) {
            logrosDivs.memoria.textContent += ` ¡Memoria de elefante!`;
        }
        if (memoriaCount >= umbralesLogros.memoria.dominado) {
            logrosDivs.memoria.textContent = `¡Campeón de la memoria! (${memoriaCount} palabras)`;
        }

        const conteoCount = getCount(localStorageKeys.conteo);
        logrosDivs.conteo.textContent = `Contados ${conteoCount} conjuntos.`;
        if (conteoCount >= umbralesLogros.conteo.visto) {
            logrosDivs.conteo.textContent += ` ¡Eres un contador experto!`;
        }
        if (conteoCount >= umbralesLogros.conteo.dominado) {
            logrosDivs.conteo.textContent = `¡Contador maestro! (${conteoCount} conjuntos)`;
        }
        // --- FIN NUEVOS LOGROS ---
    }

    // Inicializar los logros al cargar la página
    actualizarLogros();

    // Event listener para el botón de Reiniciar Logros
    resetButton.addEventListener('click', () => {
        if (confirm('¿Estás seguro de que quieres reiniciar todos tus logros?')) {
            for (const key in localStorageKeys) {
                localStorage.removeItem(localStorageKeys[key]);
            }
            actualizarLogros(); // Volver a mostrar los logros reiniciados
            alert('¡Logros reiniciados! Empieza de nuevo a ganar estrellas.');
        }
    });

    // --- INTEGRACIÓN CON LAS OTRAS PÁGINAS ---
    // Esta parte DEBE estar en `script-actividades.js`
    // No la incluyas aquí en `script-logros.js`
    // Solo como recordatorio de cómo los contadores se incrementan en `script-actividades.js`
    // a través de la función `hablarTexto` y los eventos de click.
});