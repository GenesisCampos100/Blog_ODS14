
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Dipssy</title>

  <!-- Estilos -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="css/barra.css" rel="stylesheet" />
  <link href="css/general.css" rel="stylesheet" />
  <!--<link href="css/cartas.css" rel="stylesheet" />-->
  <!--<link href="css/estructurablog.css" rel="stylesheet" />-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css" />
  <link href="css/estructurablog.css" rel="stylesheet"/>
  <link rel="stylesheet" href="css/about.css" />
  

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>


</head>

<body>
  
<header>
  <div class="navbar navbar-expand-lg navbar-dark custom-navbar">
    <div class="container-fluid">

      <!-- Logo -->
      <a class="navbar-brand" href="#">
        <img src="img/Logoo.png" alt="Logo" />
      </a>

      <!-- Botón hamburguesa -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
        aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Contenido del navbar -->
      <div class="collapse navbar-collapse" id="navbarContent">

        <!-- Enlaces de navegación -->
        <ul class="navbar-nav">
          <li class="nav-item mx-2">
            <a class="nav-link" href="index.php" id="homel">Inicio</a>
          </li>
          <li class="nav-item mx-2">
            <a class="nav-link" href="index_about.php" id="aboutl">Acerca De</a>
          </li>
          <li class="nav-item mx-2">
            <a class="nav-link" href="blog.php" id="blogl">Blog</a>
          </li>
          <li class="nav-item dropdown mx-2">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" id="languagel">Español</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">English</a></li>
            </ul>
          </li>
        </ul>

        <!-- Búsqueda y Login -->
        <div class="d-flex align-items-center ms-lg-auto flex-column flex-lg-row gap-2">

          <!-- Formulario de búsqueda -->
          <form class="form">
            <label for="search">
              <input class="input" type="text" required placeholder="Busca en el blog..." id="search">
              <div class="fancy-bg"></div>
              <div class="search">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                  <g>
                    <path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path>
                  </g>
                </svg>
              </div>
              <button class="close-btn" type="reset">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
              </button>
            </label>
          </form>

          <!-- Botón de login -->
          <div class="logg">
            <a href="login_usuarios.php" class="d-flex align-items-center text-white text-decoration-none">
              <i class="bi bi-person fs-5 me-1"></i>
              <span class="d-none d-sm-inline" id="loginn">Iniciar Sesión</span>
            </a>
          </div>

        </div>
      </div>
    </div>
  

  <!-- Categorías -->
   
  <div class="navbar-categories">
    <ul class="nav justify-content-center">
      <li class="nav-item">
        <a class="nav-link categoria-link" href="#">Conservacion de Ecosistemas</a>
      </li>
      <li class="nav-item">
        <a class="nav-link categoria-link" href="#">Contaminación Marina</a>
      </li>
      <li class="nav-item">
        <a class="nav-link categoria-link" href="#">Pesca Sostenible</a>
      </li>
      <li class="nav-item">
        <a class="nav-link categoria-link" href="#">Educacion Oceanica</a>
      </li>
    </ul>
  </div>
  <div>

</header>

  

    <!-- SECCIÓN DEL ABOUT -->
    < class="main-content">
  <section class="about">
    <h1><b>ABOUT DIPSY🌊</b></h1>

    <div class="about-dipsy-container">
      <!-- Texto -->
      <div class="about-dipsy-text">
        <p>
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

  


  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>



    
    <footer>
        &copy; 2025 Mi Página Web
    </footer>
</body>
</html>
