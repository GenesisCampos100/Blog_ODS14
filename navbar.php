<header>
  <nav class="navbar navbar-expand-lg navbar-dark custom-navbar">
    <div class="container-fluid">

      <!-- Logo -->
      <a class="navbar-brand" href="#">
        <img src="img/Logoo.png" alt="Logo" style="max-height: 60px;" />
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
          
           <!-- Ícono de idioma alineado -->
        <li class="nav-item mx-2 dropdown">
          <button id="botonIdioma" class="btn nav-link p-0 border-0 bg-transparent" 
                  data-bs-toggle="dropdown" aria-expanded="false">
            <img id="banderaIdioma" src="img/espana.png" alt="Idioma" style="height: 20px;">
          </button>
          <ul class="dropdown-menu" aria-labelledby="botonIdioma">
                      <!-- Por esto -->
          <li><a class="dropdown-item" href="#" onclick="cambiarIdioma('es','en')">Inglés</a></li>
          <li><a class="dropdown-item" href="#" onclick="cambiarIdioma('en','es')">Español</a></li>
         </ul>
        </li>
        </ul>

        <!-- Búsqueda y Login -->
        <div class="d-flex align-items-center ms-lg-auto flex-column flex-lg-row gap-2">

          <!-- Formulario de búsqueda -->
          <form class="form" method="GET" action="busqueda.php">
  <label for="search">
    <input class="input" type="search" name="search" required placeholder="Busca en el blog..." id="search">
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
  <?php
// Si aún no hay URL guardada y no estamos en login
if (!isset($_SESSION['redirect_url']) && basename($_SERVER['PHP_SELF']) !== 'login_usuarios.php') {
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI']; // Página actual
}
?>

  <?php if (isset($_SESSION['usuario_nombre'])): ?>
    
  <div class="dropdown">
    <a class="usuario-logeado d-flex align-items-center text-white dropdown-toggle text-decoration-none" href="" id="dropdownUsuario" role="button" data-bs-toggle="dropdown" aria-expanded="false">
      <i class="bi bi-person-circle fs-5 me-2"></i>
      <span class="d-none d-sm-inline"><?= htmlspecialchars($_SESSION['usuario_nombre']); ?></span>
    </a>
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUsuario">
      <li>
        <a class="dropdown-item text-danger" href="logout.php" onclick="return confirm('¿Estás seguro de que deseas cerrar sesión?');">
          <i id="cerrarSesion"class="bi bi-box-arrow-right me-2"></i> Cerrar sesión
        </a>
      </li>
    </ul>
  </div>
<?php else: ?>
   <div class="logg">
            <a href="login_usuarios.php" class="d-flex align-items-center text-white text-decoration-none">
              <i class="bi bi-person fs-5 me-1"></i>
              <span class="d-none d-sm-inline" id="loginn">Iniciar Sesión</span>
            </a>
          </div>
<?php endif; ?>


        </div>
      </div>
    </div>
  

  <!-- Categorías -->
   
  <div class="navbar-categories">
    <ul class="nav justify-content-center">
      <li class="nav-item">
        <!-- Usa ID o nombre -->
        <a class="nav-link categoria-link" id="navCategoria1" href="categoria.php?id=2">Conservación de Ecosistemas</a>
      </li>
      <li class="nav-item">
      <a class="nav-link categoria-link" id="navCategoria2" href="categoria.php?id=1">Contaminación Marina</a>
      </li>
      <li class="nav-item">
      <a class="nav-link categoria-link" id="navCategoria3" href="categoria.php?id=3">Pesca Sostenible</a>
      </li>
      <li class="nav-item">
      <a class="nav-link categoria-link" id="navCategoria4" href="categoria.php?id=4">Educación Oceánica</a>
      </li>
    </ul>
  </div>
  </nav>

</header>