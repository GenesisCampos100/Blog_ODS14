<?php
$images = ["img/team1.png", "img/anima-pez7.jpg", "img/anima-pez8.jpg", "img/3.jpg", "img/fondo-about.png"];
// Definir las imágenes para cada sección
/*
$imagenes = [
  "mission" => "mission.jpg",
  "vision" => "vision.jpg",
  "objetivo" => "objetivo.jpg"
];
*/
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Página Web</title>

    <!-- Estilos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="css/barra.css" rel="stylesheet">
    
    <link href="css/home.css" rel="stylesheet">
    <link href="css/estructurablog.css" rel="stylesheet">
    <link rel="stylesheet" href="css/about.css?v=<?php echo time(); ?>">

    <!-- Slider de imágenes -->
    <script>
        window.onload = function () {
            let images = <?php echo json_encode($images); ?>;
            let index = 0;
            let imgElement = document.getElementById("image-slider");

            function changeImage() {
                imgElement.src = images[index];
                index = (index + 1) % images.length;
            }

            setInterval(changeImage, 3000);
        };
    </script>

    <!-- Ajuste de altura para la barra azul -->
    <script>
        function ajustarAlturaBarra() {
            const img = document.getElementById('tituloimg');
            const barra = document.getElementById('barracolor');

            if (img && barra) {
                barra.style.height = img.offsetHeight + 'px';
            }
        }

        window.addEventListener('load', ajustarAlturaBarra);
        window.addEventListener('resize', ajustarAlturaBarra);
    </script>
</head>
<body>
    <!-- Header con barra de navegación -->
    <header>
  <nav class="navbar navbar-expand-lg custom-navbar mb-0">
    <div class="container-fluid align-items-center">

      <!-- Enlaces a la izquierda + ícono de idioma -->
      <ul class="navbar-nav flex-row me-auto align-items-center">
        
        <!-- Enlaces de navegación -->
        <li class="nav-item mx-2"><a class="nav-link" id="navInicio" href="index.php">INICIO</a></li>
        <li class="nav-item mx-2"><a class="nav-link" id="navAcercaDe" href="index_about.php">ACERCA DE</a></li>
        <li class="nav-item mx-2"><a class="nav-link" id="navBlog" href="blog.php">BLOG</a></li>
        <!-- Ícono de idioma -->
        <li class="nav-item mx-2">
          <div class="dropdown">
            <button id="botonIdioma" class="icon-button dropdown-toggle btn btn-link p-0" 
                    data-bs-toggle="dropdown" aria-expanded="false">
              <img id="banderaIdioma" src="img/espana.png" alt="Idioma" style="height: 20px;">
            </button>
            <ul class="dropdown-menu" aria-labelledby="botonIdioma">
              <li><a class="dropdown-item" href="#" onclick="traducirContenido('es','en')">Inglés</a></li>
              <li><a class="dropdown-item" href="#" onclick="traducirContenido('en','es')">Español</a></li>
            </ul>
          </div>
        </li>
      </ul>
      <!-- Logo centrado -->
      <a class="navbar-brand mx-auto position-absolute start-50 translate-middle-x" href="#">
        <img src="img/logod.png" alt="Logo" style="max-height: 60px;">
      </a>

      <!-- Buscador a la derecha -->
      <div class="d-flex align-items-center">
        <form class="d-flex search-form me-2" role="search">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Buscar</button>
        </form>
      </div>
    </div>
  </nav>

  <!-- Barra de categorías (pegada a la navbar) -->
  <div class="navbar-categories mt-0">
    <ul class="nav justify-content-center">
      <li class="nav-item"><a class="nav-link" id="navCategoria1" href="#">Categoría 1</a></li>
      <li class="nav-item"><a class="nav-link" id="navCategoria2" href="#">Categoría 2</a></li>
      <li class="nav-item"><a class="nav-link" id="navCategoria3" href="#">Categoría 3</a></li>
      <li class="nav-item"><a class="nav-link" id="navCategoria4" href="#">Categoría 4</a></li>
    </ul>
  </div>
</header>

     <!-- Script de Bootstrap -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <!-- Barra azul detrás de la imagen -->
    <div id="barracolor" class="barracolor"></div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SECCIÓN DEL ABOUT -->
<div class="main-content">
  <section class="about">
    <h1><b>DIPSY🌊</b></h1>
    <div class="about-dipsy-container">
      <!-- Texto -->
      <div class="about-dipsy-text">
        <p id = "parrafoDipsy">
          Bienvenido a Dipsy, un blog dedicado a la fascinante vida marina. 
          Nuestro objetivo es explorar los misterios del océano, compartir información 
          sobre las especies que lo habitan y concienciar sobre la importancia de su conservación. 
          Este proyecto universitario nace de nuestra pasión por el mar y la necesidad 
          de educar sobre los desafíos que enfrenta, como la contaminación, el 
          cambio climático y la pérdida de biodiversidad.
          Acompáñanos en este viaje submarino, donde aprenderás sobre criaturas sorprendentes, 
          ecosistemas únicos y cómo podemos protegerlos para las futuras generaciones.
          <br>
          🐠🌎 ¡Sumérgete con nosotros en el mundo de Dipsy! 🌊🐢
        </p>
      </div>

      <!-- Imagen -->
      <div class="about-dipsy-image">
        <img src="img/foto-aboutUS.png" alt="Imagen de Dipsy">
      </div>
    </div>
  </section>

        <section class="metas">
            <h2 id = "tituloMetas"><b>NUESTRAS METAS</b></h2>
            <div class="goals">
                <div class="goal mission">
                    <br><h2 id = "tituloMision">🌊MISION</h2></b>
                    <p id = "parrafoMision">
                    Informar, concientizar y educar a la comunidad sobre la importancia de la vida marina y la conservación de los océanos. 
                    A través de contenido accesible y actualizado, buscamos fomentar prácticas sostenibles y promover el respeto por los ecosistemas marinos.
                    </p>
                    <!-- Imagen de la misión -->
                </div>
                <div class="goal objective">
                    <br><h2 = id = "tituloVision">🌍VISION</h2></b>
                    <p id = "parrafoVision">
                    Ser un referente digital en la divulgación del ODS 14, inspirando a estudiantes, investigadores y ciudadanos a tomar acciones concretas para la protección de los océanos. 
                    Buscamos generar un impacto positivo en la sociedad mediante el conocimiento y la sensibilización ambiental.
                    </p>
                     <!-- Imagen de la visión -->
                </div>
                <div class="goal vision">
                    <br><h2 id = "tituloObjectivo">🎯OBJECTIVO</h2></b>
                    <p id = "parrafoObjectivo">
                    Desarrollar un blog informativo e interactivo que difunda la importancia de la vida submarina, los desafíos que enfrenta y las soluciones para su conservación.
                    A través de artículos, entrevistas, infografías y contenido multimedia, queremos fortalecer la educación ambiental y motivar el cambio hacia un futuro sostenible para nuestros océanos.
                    </p>
                    <!-- Imagen del objetivo -->
                </div>
            </div>
        </section>

        <section class="history">
            <div class="history-content">
                <h2 id = "tituloHistoria"><b>HISTORIA</b></h2>
                <p id = "parrafoHistoria">
                    Desde pequeños hemos sentido una profunda fascinación por el mar y sus misterios. Cada ola, cada criatura y cada arrecife cuentan una historia increíble que queremos compartir contigo.

                    Este blog nació como un proyecto universitario con un propósito claro: explorar, informar y sensibilizar sobre la importancia de la vida marina. Queremos que más personas descubran la belleza de los océanos y comprendan por qué es vital protegerlos.

                    🐠🌊 Pasamos de ser simples admiradores del mar a convertirnos en sus defensores. Ahora queremos que tú también te unas a esta misión.
                </p>
            </div>
        </section>
    </main>

    <!-- FOOTER -->
    <footer class="footer">
        <p id = "parrafoFooter">© 2025 Dipsy - Todos los derechos reservados</p>
    </footer>
    <script src="traductor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>

