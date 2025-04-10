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
    <title>DIPSY</title>
    <!--Fuente -->
    <link href="https://fonts.googleapis.com/css2?family=Chau+Philomene+One&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/about.css?v=<?php echo time(); ?>">
    
    <script>
        window.onload = function() {
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
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">DIPSY</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="index.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="about.php">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="blog.php">Blog</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Category
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#">Category 1</a></li>
                  <li><a class="dropdown-item" href="#">Category 2</a>
                  </li>
              </li>
              </ul>
              <li class="nav-item">
                <a class="nav-link" href="login.php">login / signup</a>
              </li>
            <form class="d-flex" role="search">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
          </div>
        </div>
      </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!--    
    <section class="container mt-4">
        <div id="imageCarousel" class="carousel slide" data-bs-ride="carousel" daata-bs-interval="1000">
            <div class="carousel-inner">
                <?php foreach ($images as $index => $image): ?>
                    <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                        <img src="<?php echo $image; ?>" class="d-block w-100" alt="Imagen <?php echo $index; ?>">
                    </div>
                <?php endforeach; ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#imageCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>
    -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SECCIONES DEL ABOUT -->
    <main class="main-content">
        <section class="about">
            <h1><b>ABOUT DIPSY🌊</b></h1>
            <p>
            Bienvenido a Dipsy, un blog dedicado a la fascinante vida marina. <br> Nuestro objetivo es explorar los misterios del océano, compartir información <br>sobre las especies que lo habitan y concienciar sobre la importancia de su conservación. <br>
            Este proyecto universitario nace de nuestra pasión por el mar y la necesidad <br> de educar sobre los desafíos que enfrenta, como la contaminación, el <br> cambio climático y la pérdida de biodiversidad.
            <br>Acompáñanos en este viaje submarino, donde aprenderás sobre criaturass sorprendentes, <br> ecosistemas únicos y cómo podemos protegerlos para las futuras generaciones.
            <br>🐠🌎 ¡Sumérgete con nosotros en el mundo de Dipsy! 🌊🐢
            </p>
            <div class="about-dipsy"></div>
        </section>

        <section class="metas">
            <h2><b>OUR GOALS</b></h2>
            <div class="goals">
                <div class="goal mission">
                    <br><h2>🌊MISSION</h2></b>
                    <p>
                    Informar, concientizar y educar a la comunidad sobre la importancia de la vida marina y la conservación de los océanos. 
                    A través de contenido accesible y actualizado, buscamos fomentar prácticas sostenibles y promover el respeto por los ecosistemas marinos.
                    </p>
                    <!-- Imagen de la misión -->
                </div>
                <div class="goal objective">
                    <br><h2>🌍VISION</h2></b>
                    <p>
                    Ser un referente digital en la divulgación del ODS 14, inspirando a estudiantes, investigadores y ciudadanos a tomar acciones concretas para la protección de los océanos. 
                    Buscamos generar un impacto positivo en la sociedad mediante el conocimiento y la sensibilización ambiental.
                    </p>
                     <!-- Imagen de la visión -->
                </div>
                <div class="goal vision">
                    <br><h2>🎯OBJECTIVE</h2></b>
                    <p>
                    Desarrollar un blog informativo e interactivo que difunda la importancia de la vida submarina, los desafíos que enfrenta y las soluciones para su conservación.
                    A través de artículos, entrevistas, infografías y contenido multimedia, queremos fortalecer la educación ambiental y motivar el cambio hacia un futuro sostenible para nuestros océanos.
                    </p>
                    <!-- Imagen del objetivo -->
                </div>
            </div>
        </section>

        <section class="history">
            <div class="history-content">
                <h2><b>HISTORY</b></h2>
                <p>
                    Desde pequeños hemos sentido una profunda fascinación por el mar y sus misterios. Cada ola, cada criatura y cada arrecife cuentan una historia increíble que queremos compartir contigo.

                    Este blog nació como un proyecto universitario con un propósito claro: explorar, informar y sensibilizar sobre la importancia de la vida marina. Queremos que más personas descubran la belleza de los océanos y comprendan por qué es vital protegerlos.

                    🐠🌊 Pasamos de ser simples admiradores del mar a convertirnos en sus defensores. Ahora queremos que tú también te unas a esta misión.
                </p>
            </div>
        </section>

        <section class="how-to-help">
            <h2><b>HOW CAN YOU HELP?</b></h2>
            <div class="help-content">...</div>
        </section>
    </main>

    <!-- FOOTER -->
    <footer class="footer">
        <p>© 2025 Dipsy - Todos los derechos reservados</p>
    </footer>

</body>
</html>

