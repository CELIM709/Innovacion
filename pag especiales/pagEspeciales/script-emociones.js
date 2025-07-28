document.addEventListener('DOMContentLoaded', () => {
    const emocionButtons = document.querySelectorAll('.emocion-item');
    const tituloEmocion = document.getElementById('tituloEmocion');
    const descripcionEmocion = document.getElementById('descripcionEmocion');
    const ejemploEmocion = document.getElementById('ejemploEmocion');
    const consejoEmocion = document.getElementById('consejoEmocion');
    const infoEmocionPanel = document.getElementById('infoEmocion');
    const avatarInfo = infoEmocionPanel.querySelector('.avatar-info');

    // Datos de las emociones
    const emocionesData = {
        alegria: {
            titulo: '¡Qué Alegría!',
            descripcion: 'La alegría es esa emoción que sientes cuando estás muy contento, feliz o algo bueno te ha pasado.',
            ejemplo: 'Ejemplo: Sientes alegría cuando juegas con tus amigos o recibes un regalo.',
            consejo: 'Consejo: Comparte tu alegría con los demás y haz cosas que te hagan sonreír.'
        },
        tristeza: {
            titulo: 'Un poco Triste...',
            descripcion: 'La tristeza aparece cuando te sientes decaído, echas de menos a alguien o algo te hace sentir un poco mal.',
            ejemplo: 'Ejemplo: Puedes sentir tristeza si tu juguete favorito se rompe o extrañas a alguien.',
            consejo: 'Consejo: Está bien estar triste. Puedes hablar con un adulto, dibujar o darte un abrazo fuerte.'
        },
        enojo: {
            titulo: '¡Siento Enojo!',
            descripcion: 'El enojo es cuando te sientes molesto, frustrado o muy enfadado porque algo no te gusta o no sale como esperabas.',
            ejemplo: 'Ejemplo: Te enojas si alguien te quita un juguete o no te dejan hacer algo que querías.',
            consejo: 'Consejo: Respira profundo, cuenta hasta 10, o aprieta una almohada. Luego, intenta hablar de lo que te molesta.'
        },
        miedo: {
            titulo: '¡Tengo Miedo!',
            descripcion: 'El miedo es una emoción que te avisa de un peligro o algo que te asusta. A veces te hace sentir nervios en la barriga.',
            ejemplo: 'Ejemplo: Sientes miedo si hay un trueno fuerte o tienes que ir a un lugar desconocido.',
            consejo: 'Consejo: Puedes cerrar los ojos, abrazar a tu peluche, o pedirle a un adulto que te acompañe y te dé seguridad.'
        },
        calma: {
            titulo: '¡Qué Calma!',
            descripcion: 'La calma es una sensación de tranquilidad, paz y relajación. Te sientes a gusto y sin prisas.',
            ejemplo: 'Ejemplo: Sientes calma cuando lees un cuento, abrazas a tus papás o miras las nubes.',
            consejo: 'Consejo: Para sentir más calma, puedes respirar lento, escuchar música suave o simplemente descansar.'
        }
    };

    // Función para mostrar la información de la emoción
    function mostrarInfoEmocion(emocionKey) {
        const data = emocionesData[emocionKey];
        if (data) {
            tituloEmocion.textContent = data.titulo;
            descripcionEmocion.textContent = data.descripcion;
            ejemploEmocion.textContent = data.ejemplo;
            consejoEmocion.textContent = data.consejo;
            
            // Cambiar el avatar basado en la emoción (opcional)
            // Aquí podrías cambiar la URL del src del avatar o la imagen de fondo del panel
            // Por simplicidad, mantendremos un avatar genérico a menos que se pidan específicos.
            // avatarInfo.src = `url_del_avatar_para_${emocionKey}.png`;
            
            // Animación simple para el panel
            infoEmocionPanel.style.opacity = 0;
            infoEmocionPanel.style.transform = 'translateY(10px)';
            setTimeout(() => {
                infoEmocionPanel.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                infoEmocionPanel.style.opacity = 1;
                infoEmocionPanel.style.transform = 'translateY(0)';
            }, 50); // Pequeño retraso para que la transición se aplique
        }
    }

    // Añadir el evento click a cada botón de emoción
    emocionButtons.forEach(button => {
        button.addEventListener('click', () => {
            const emocionKey = button.dataset.emocion;
            mostrarInfoEmocion(emocionKey);
        });
    });

    // Estado inicial: mostrar la descripción predeterminada
    // Puedes llamar a mostrarInfoEmocion con una clave si quieres que una emoción se muestre por defecto
    // Por ahora, el HTML ya tiene el texto inicial.
});