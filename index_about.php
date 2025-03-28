<?php

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dipsy</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/about.css">
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
    <header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">Dipsy</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="index.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="index_about.php">About</a>
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
               
              
            <form class="d-flex" role="search">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </li>
          </form>

          
          </div>
        </div>
      </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </header>
    <section>
        <div class="image-container">
            <img id="image-slider" src="<?php echo $images[0]; ?>" alt="Imagen rotativa" style="width:100%; max-width:500px; display:block; margin:auto;">
        </div>
    </section>

    <!-- SECCIONES DEL ABOUT -->
    <main class="main-content">
    <section class="about">
      <h1><b>About Dipsy</b></h1>
      <div class="about-dipsy">...</div>
    </section>
    <section class="metas">
        <h2><b>Our goals</b></h2>
        <div class="goals">
            <div class="goal mission">Mission</div>
            <div class="goal objective">Vision</div>
            <div class="goal vision">Ojective</div>
        </div>
    </section>

    <section class="history">
        <div class="history-content">
        <h2><b>Our history</b></h2>
          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum laborum modi culpa consectetur pariatur vero, eaque dicta quasi natus sit quia tempore, quis porro iste consequuntur ex, sunt alias adipisci?</p>
        </div>
    </section>

    <section class="how-to-help">
        <h2><b>How can you help?</b></h2>
        <div class="help-content">...</div>
    </section>
</main>



<footer class="footer">
    <p>© 2025 Dipsy - Todos los derechos reservados</p>
</footer>

</body>
</html>
