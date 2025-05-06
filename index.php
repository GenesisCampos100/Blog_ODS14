<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Mi Página Web</title>

  <!-- Estilos -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="css/barra.css" rel="stylesheet" />
  <link href="css/general.css" rel="stylesheet" />
  <link href="css/cartas.css" rel="stylesheet" />
  <link href="css/estructurablog.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css" />

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

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

<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>


</head>

<body>
  
  <header>
    <nav class="navbar navbar-expand-lg custom-navbar">
      <div class="container-fluid justify-content-between align-items-center">
        
        <ul class="navbar-nav flex-row">
          <a class="navbar-brand" href="#">
            <img src="img/Dipsyy.png" alt="Logo" style="max-height: 60px;" />
          </a>
          <li class="nav-item mx-2"><a class="nav-link" href="index.php">HOME</a></li>
          <li class="nav-item mx-2"><a class="nav-link" href="index_about.php">ABOUT</a></li>
          <li class="nav-item mx-2"><a class="nav-link" href="blog.php">BLOG</a></li>
          <li class="nav-item dropdown mx-2">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">ENGLISH</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">SPANISH</a></li>
            </ul>
          </li>
        </ul>

        
        <div class="d-flex align-items-center gap-1">
          <form class="search-box me-2">
            <input type="text" class="input" name="">
            <button type="button" class="btn" name="button"></button>
          </form>
          <script>
            $(".btn").on("click", function () {
              $(".input").toggleClass("inclicked");
              $(".btn").toggleClass("close");
            });
          </script>
          <div class="vr text-white"></div>
          <a href="login.php" class="d-flex align-items-center text-white text-decoration-none ms-2">
            <i class="bi bi-person fs-5 me-1"></i>
            <span class="d-none d-sm-inline">Log In</span>
          </a>
        </div>
      </div>
    </nav>

    
    <div class="navbar-categories">
      <ul class="nav justify-content-center">
        <li class="nav-item"><a class="nav-link categoria-link" href="#">CATEGORÍA1</a></li>
        <li class="nav-item"><a class="nav-link categoria-link" href="#">CATEGORÍA1</a></li>
        <li class="nav-item"><a class="nav-link categoria-link" href="#">CATEGORÍA1</a></li>
        <li class="nav-item"><a class="nav-link categoria-link" href="#">CATEGORÍA1</a></li>
      </ul>
    </div>
  </header>



  <!-- Barra azul detrás de la imagen -->
  <div id="barracolor" class="barracolor"></div>

  <!-- Contenido -->
  <div class="content">
    <div class="img-wrapper">
      <img id="tituloimg" class="imgtituloblog" src="img/tituloo.jpg" alt="Título del blog" />
    </div>

    <div class="categoriass">
      <div class="categoria">NOTICIAS</div>
    </div>

    <div class="titulo">
      La ODS 14: Vida Submarina y su Importancia para el Futuro del Planeta
    </div>

    <div class="autor">
      <div class="autor-info">
        <div class="autorr">Vanessa Sibaja</div>
        <div class="fecha">22/04/25</div>
      </div>
      <div class="comentariolink">COMENTARIOS</div>
    </div>

    <div class="textoblog">
      La ODS 14, que busca "Conservar y usar sosteniblemente los océanos, mares y recursos marinos para el desarrollo sostenible", es fundamental para proteger uno de los ecosistemas más importantes del planeta. Los océanos cubren más del 70% de la superficie terrestre y son vitales para regular el clima, generar oxígeno y proporcionar alimento a millones de personas en todo el mundo.
      <br><br>
      Desafortunadamente, nuestros mares enfrentan una creciente amenaza debido a la contaminación, la sobreexplotación de los recursos y la acidificación. Es esencial que tomemos medidas urgentes para reducir la contaminación plástica, proteger los hábitats marinos y gestionar de manera sostenible las pesquerías.
      <br><br>
      Al avanzar en el cumplimiento de la ODS 14, no solo protegemos la biodiversidad marina, sino que también garantizamos un futuro más saludable y equilibrado para todos. Es hora de actuar y contribuir a la conservación de los océanos. ¡El futuro de nuestro planeta depende de ello!
      <br><br><br>
    </div>

    <div class="referencias">
      <div class="tituloref">Referencias</div>
      <div class="referenciass">
        <ul>
          <li>Mancera Pineda, J. E; Gavío, G. & Lasso-Zapata, J. (2013)...</li>
          <li>Márquez, G. (2014)...</li>
        </ul>
      </div>
    </div>

    <!-- Sección de Comentarios -->
    <div class="comment-section">
      <div class="commentmsg">
        <p>Leave a comment...</p>
      </div>

      <!-- Formulario de nuevo comentario -->
      <div class="mb-4">
        <div class="d-flex gap-3">
          <img src="https://randomuser.me/api/portraits/women/4.jpg" alt="User Avatar" class="user-avatar">
          <div class="flex-grow-1">
            <textarea class="form-control comment-input" rows="3" placeholder="Write a comment..."></textarea>
            <div class="mt-3 text-end">
              <button class="butoon butoon-comment text-white">Post Comment</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Lista de comentarios -->
      <div class="comments-list">
        <!-- Comentario 1 -->
        <div class="comment-box">
          <div class="d-flex gap-3">
            <img src="https://randomuser.me/api/portraits/men/34.jpg" alt="User Avatar" class="user-avatar">
            <div class="flex-grow-1">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="mb-0">John Doe</h6>
                <span class="comment-time">2 hours ago</span>
              </div>
              <p class="mb-2">This is an amazing post! Thanks for sharing...</p>
              <div class="comment-actions">
                <a href="#"><i class="bi bi-heart"></i> Like</a>
                <a href="#"><i class="bi bi-reply"></i> Reply</a>
                <a href="#"><i class="bi bi-share"></i> Share</a>
              </div>
            </div>
          </div>

          <!-- Respuesta -->
          <div class="reply-section mt-3">
            <div class="comment-box">
              <div class="d-flex gap-3">
                <img src="https://randomuser.me/api/portraits/women/64.jpg" alt="User Avatar" class="user-avatar">
                <div class="flex-grow-1">
                  <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0">Jane Smith</h6>
                    <span class="comment-time">1 hour ago</span>
                  </div>
                  <p class="mb-2">Totally agree with you...</p>
                  <div class="comment-actions">
                    <a href="#"><i class="bi bi-heart"></i> Like</a>
                    <a href="#"><i class="bi bi-reply"></i> Reply</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Comentario 2 -->
        <div class="comment-box">
          <div class="d-flex gap-3">
            <img src="https://randomuser.me/api/portraits/men/9.jpg" alt="User Avatar" class="user-avatar">
            <div class="flex-grow-1">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="mb-0">Mike Johnson</h6>
                <span class="comment-time">3 hours ago</span>
              </div>
              <p class="mb-2">Great discussion everyone!</p>
              <div class="comment-actions">
                <a href="#"><i class="bi bi-heart"></i> Like</a>
                <a href="#"><i class="bi bi-reply"></i> Reply</a>
                <a href="#"><i class="bi bi-share"></i> Share</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!--
    <div class="tarjetas">
    
    <article class="card">
      <div class="card-int">
        <span class="card__span">Noticias</span>
        <div class="img">
          <img id="cover" src="img/cover.png" />
        </div>
        <div class="card-data">
          <p class="title">Secretos Profundos: Lo Que Esconde el Océano Bajo la Superficie</p>

          <button id="boutton">More info</button>
        </div>
      </div>
    </article>

    <article class="card">
      <div class="card-int">
        <span class="card__span">Noticias</span>
        <div class="img">
          <img id="cover" src="img/cover.png" />
        </div>
        <div class="card-data">
          <p class="title">Secretos Profundos: Lo Que Esconde el Océano Bajo la Superficie</p>

          <button id="boutton">More info</button>
        </div>
      </div>
    </article>


    <article class="card">
      <div class="card-int">
        <span class="card__span">Noticias</span>
        <div class="img">
          <img id="cover" src="img/cover.png" />
        </div>
        <div class="card-data">
          <p class="title">Secretos Profundos: Lo Que Esconde el Océano Bajo la Superficie</p>

          <button id="boutton">More info</button>
        </div>
      </div>
    </article>
    
    </div>

    

  </div>
  <br><br><br>
        -->


  <section class="articles">
  <article>
    <div class="article">
      <figure>
        <img src="https://picsum.photos/id/1011/800/450" alt="" />
      </figure>
      <div class="article-body">
        <h2>This is some title</h2>
        <p>
          Curabitur convallis ac quam vitae laoreet. Nulla mauris ante, euismod sed lacus sit amet, congue bibendum eros. Etiam mattis lobortis porta. Vestibulum ultrices iaculis enim imperdiet egestas.
        </p>
        <a href="#" class="read-more">
          Read more <span class="sr-only">about this is some title</span>
          <svg xmlns="http://www.w3.org/2000/svg" class="icon" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
          </svg>
        </a>
      </div>
    </div>
  </article>
  <article>

    <div class="article">
      <figure>
        <img src="https://picsum.photos/id/1005/800/450" alt="" />
      </figure>
      <div class="article-body">
        <h2>This is some title</h2>
        <p>
          Curabitur convallis ac quam vitae laoreet. Nulla mauris ante, euismod sed lacus sit amet, congue bibendum eros. Etiam mattis lobortis porta. Vestibulum ultrices iaculis enim imperdiet egestas.
        </p>
        <a href="#" class="read-more">
          Read more <span class="sr-only">about this is some title</span>
          <svg xmlns="http://www.w3.org/2000/svg" class="icon" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
          </svg>
        </a>
      </div>
    </div>
  </article>
  <article>

    <div class="article">
      <figure>
        <img src="https://picsum.photos/id/103/800/450" alt="" />
      </figure>
      <div class="article-body">
        <h2>This is some title</h2>
        <p>
          Curabitur convallis ac quam vitae laoreet. Nulla mauris ante, euismod sed lacus sit amet, congue bibendum eros. Etiam mattis lobortis porta. Vestibulum ultrices iaculis enim imperdiet egestas.
        </p>
        <a href="#" class="read-more">
          Read more <span class="sr-only">about this is some title</span>
          <svg xmlns="http://www.w3.org/2000/svg" class="icon" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
          </svg>
        </a>
      </div>
    </div>
  </article>
  <article>

    <div class="article">
      <figure>
        <img src="https://picsum.photos/id/103/800/450" alt="" />
      </figure>
      <div class="article-body">
        <h2>This is some title</h2>
        <p>
          Curabitur convallis ac quam vitae laoreet. Nulla mauris ante, euismod sed lacus sit amet, congue bibendum eros. Etiam mattis lobortis porta. Vestibulum ultrices iaculis enim imperdiet egestas.
        </p>
        <a href="#" class="read-more">
          Read more <span class="sr-only">about this is some title</span>
          <svg xmlns="http://www.w3.org/2000/svg" class="icon" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
          </svg>
        </a>
      </div>
    </div>
  </article>
 
</section>


  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
