<?php 
include("session.php"); 
?>


<!DOCTYPE HTML>
<html>
<head>
    <title>Proyecto Innovacion</title>
    <meta charset="utf-8">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="estilo_extra.css">
</head>
<body>

    <header id="header" class="alt">
        <div class="logo"><a href="index.html">ESPECIALES <span>UNEG</span></a></div>
        <a href="#menu">Menu</a>
    </header>

    <nav id="menu">
  <ul class="links">
    <li><a href="index.php">Inicio</a></li>

    <?php if (!$usuario): ?>
      <li><a href="#login">Accesar</a></li>
    <?php endif; ?>

    <?php if ($rol == 2): ?>
      <li><a href="presentacion.php">Chatbot</a></li>
    <?php endif; ?>

    <?php if ($rol == 1): ?>
      <li class="has-submenu">
        <a href="#" class="toggle-submenu">Agregar</a>
        <ul class="submenu">
          <li><a href="agregar_usuario.php">Agregar usuarios</a></li>
          <li><a href="agregar_noticia.php">Agregar noticia</a></li>
        </ul>
      </li>
    <?php endif; ?>

    <li><a href="#acerca de">Acerca de</a></li>

    <li class="has-submenu">
      <a href="#" class="toggle-submenu">Gestion</a>
      <ul class="submenu">
        <li><a href="/Especiales/entidades/actividad/actividad.php">Actividades</a></li>
        <li><a href="/Especiales/entidades/actividad_alumno/actividad_alumno.php">Actividad_Alumno</a></li>
        <li><a href="/Especiales/entidades/alumno/alumno.php">Alumnos</a></li>
        <li><a href="/Especiales/entidades/alum_repre/alum_repre.php">Alumno_Representante</a></li>
        <li><a href="/Especiales/entidades/docente/docente.php">Docentes</a></li>
        <li><a href="/Especiales/entidades/docente/docente.php">Docente_Alumno</a></li>
        <li><a href="/Especiales/entidades/representante/representante.php">Representantes</a></li>
      </ul>
    </li>

    <li class="has-submenu">
      <a href="#" class="toggle-submenu">Reportes</a>
      <ul class="submenu">
        <li><a href="/Especiales/reportes/actividad/index.php">Actividades</a></li>
        <li><a href="/Especiales/reportes/actividad_alumno/index.php">Actividad_Alumno</a></li>
        <li><a href="/Especiales/reportes/alum_repre/index.php">Alumno_Representante</a></li>
        <li><a href="/Especiales/reportes/alumno/index.php">Alumnos</a></li>
        <li><a href="/Especiales/reportes/docente/index.php">Docentes</a></li>
        <li><a href="/Especiales/reportes/doc_alumno/index.php">Docente_Alumno</a></li>
        <li><a href="/Especiales/reportes/representante/index.php">Representantes</a></li>
      </ul>
    </li>

    <?php if ($usuario): ?>
        <li><a href="cerrar_sesion.php"><i class="fa fa-user"></i> Cerrar sesión (<?= htmlspecialchars($usuario) ?>)</a></li>

    <?php endif; ?>
  </ul>
</nav>




    <section class="banner full">
        <article>
            <img src="imagenes/imagen_13.jpg" alt="Campus UNEG" width="1440" height="961">
            <div class="inner">
                <header>
                    <p>Compromiso social y desarrollo para Ciudad Guayana</p>
                    <h2>ESPECIALES UNEG</h2>
                </header>
            </div>
        </article>
        <article>
            <img src="imagenes/imagen_10.jpg" alt="Estudiantes UNEG en la comunidad" width="1440" height="961">
            <div class="inner">
                <header>
                    <p>Transformando vidas a través de la acción social</p>
                    <h2>Impacto Positivo</h2>
                </header>
            </div>
        </article>
        <article>
            <img src="imagenes/imagen_12.jpg" alt="Aprendizaje y servicio UNEG" width="1440" height="962">
            <div class="inner">
                <header>
                    <p>Formación integral para futuros profesionales</p>
                    <h2>Experiencia Enriquecedora</h2>
                </header>
            </div>
        </article>
        <article>
            <img src="imagenes/imagen_6.jpg" alt="Proyecto social UNEG" width="1440" height="961">
            <div class="inner">
                <header>
                    <p>Iniciativas que construyen un futuro mejor</p>
                    <h2>Actividades para el desarrollo</h2>
                </header>
            </div>
        </article>
        <article>
            <img src="imagenes/imagen_3.jpg" alt="Voluntariado UNEG" width="1440" height="962">
            <div class="inner">
                <header>
                    <p>Únete a nuestra misión de servir a la sociedad</p>
                    <h2>Participa y Contribuye</h2>
                </header>
            </div>
        </article>
    </section>

    ---



    <section id="one" class="wrapper style2">
        <div class="inner">
            <div class="grid-style">

                <div>
                    <div class="box">
                        <div class="image fit">
                            <img src="imagenes/imagen_14.jpg" alt="Áreas de Impacto del Servicio Comunitario UNEG" width="600" height="300">
                        </div>
                        <div class="content">
                            <header class="align-center">
                                <p>Salud, educación, ambiente y más</p>
                                <h2>Nuestras Áreas de Impacto</h2>
                            </header>
                            <p>Nuestra empresa está redefiniendo el desarrollo de niños con necesidades especiales al ofrecer clases personalizadas a través de una plataforma web. Esto elimina barreras geográficas y de movilidad, brindando educación de calidad en casa. La flexibilidad online permite adaptar cada lección a las necesidades individuales, estimulando el desarrollo intelectual de manera efectiva. Además, empoderamos a las familias al permitirles participar activamente en el proceso de aprendizaje.</p>
                            <footer class="align-center">
                                <a href="#" class="button alt">Conocer los reglamentos</a>
                            </footer>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="box">
                        <div class="image fit">
                            <img src="imagenes/imagen_10.jpg" alt="Beneficios del Servicio Comunitario para estudiantes UNEG" width="600" height="300">
                        </div>
                        <div class="content">
                            <header class="align-center">
                                <p>Crecimiento personal y profesional</p>
                                <h2>Beneficios para Estudiantes</h2>
                            </header>
                            <p>La educación online transforma la vida de niños con necesidades especiales y sus familias. Los niños se benefician de clases personalizadas en un ambiente familiar y seguro, con contenido interactivo y lúdico que potencia su desarrollo intelectual y digital. Para los representantes, significa flexibilidad y comodidad, mayor participación activa en la educación de sus hijos, acceso a apoyo especializado y una reducción significativa del estrés, ahorrando tiempo y dinero!</p>
                            <footer class="align-center">
                                <a href="#" class="button alt">Regístrate Aquí</a>
                            </footer>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    ---

    <section id="two" class="wrapper style3">
        <div class="inner">
            <header class="align-center">
                <p>Formando ciudadanos comprometidos con el futuro de nuestra región</p>
                <h2>El Compromiso Social de ESPECIALES</h2>
            </header>
        </div>
    </section>

      <section id= "acerca de" class="wrapper style2">
    <div class="inner">
        <header class="align-center">
            <h2>¿Qué es el Servicio Comunitario de Especiales?</h2>
            <p>Un pilar fundamental en la formación del profesional con codiciones especiales</p>
        </header>
        <div class="flex flex-2">
            <div class="centrar_imagen">
                <img src="imagenes/imagen_5.jpg" alt="servicio" width="1170" height="500">
            </div>
            <div class="content justificar">
                <p>Para muchos niños en nuestra región, especialmente aquellos con necesidades especiales, el acceso a una educación adecuada es un desafío constante. Las barreras pueden ser geográficas, socioeconómicas o incluso relacionadas con la falta de infraestructura y personal especializado en las instituciones tradicionales. Nuestra empresa se convierte en un puente vital, llevando clases especializadas y personalizadas directamente a sus hogares. Esto asegura que ningún niño quede rezagado debido a su ubicación o a las limitaciones de los recursos existentes.</p>
                <p>La educación de un niño con necesidades especiales es una tarea que recae significativamente en la familia. Padres y representantes a menudo luchan por encontrar recursos, apoyo y la información necesaria para guiar el desarrollo de sus hijos. Empresas como la nuestra no solo educan al niño, sino que también empoderan a las familias, ofreciéndoles herramientas, conocimientos y la tranquilidad de saber que sus hijos están recibiendo la atención que merecen. Al fortalecer a estas familias, contribuimos a construir una sociedad más inclusiva y empática en Guayana.</p>
                <p>Utilizamos herramientas interactivas y lúdicas que convierten el aprendizaje en una aventura. Videos animados, juegos educativos, pizarras digitales compartidas y actividades multisensoriales capturan su atención y hacen que conceptos complejos sean fáciles de entender. La interacción con nuestros educadores especializados es constante y personal. No son solo maestros; son guías empáticos que celebran cada pequeño logro y motivan a los niños a superar desafíos, construyendo su confianza y autonomía día a día.</p>
            </div>
        </div>
    </div>
</section>

    <footer id="footer">
        <div class="container">
            <ul class="icons">
                <li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
                <li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
                <li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
                <li><a href="#" class="icon fa-envelope-o"><span class="label">Email</span></a></li>
            </ul>
        </div>
    </footer>

    <div class="copyright">
        Ciudad Guayana <a href="#">ServicioComunitarioESPECIALES.org</a>.
    </div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery.scrollex.min.js"></script>
    <script src="assets/js/skel.min.js"></script>
    <script src="assets/js/util.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/modal_login.js"></script> 

    <script>
document.addEventListener('DOMContentLoaded', () => {
  // Mostrar/ocultar submenús al hacer clic
  document.querySelectorAll('.toggle-submenu').forEach(toggle => {
    toggle.addEventListener('click', e => {
      e.preventDefault();
      const submenu = toggle.nextElementSibling;
      submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
    });
  });

  // Notificación al descargar
  document.querySelectorAll('.descargar').forEach(link => {
    link.addEventListener('click', () => {
      setTimeout(() => {
        alert('✅ Documento descargado exitosamente');
      }, 1000);
    });
  });
});
</script>



</body>
</html>