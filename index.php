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
    <link href="css/general.css" rel="stylesheet">
    <link href="css/home.css" rel="stylesheet">
    <link href="css/estructurablog.css" rel="stylesheet">

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
        <nav class="navbar navbar-expand-lg custom-navbar">
            <div class="container-fluid justify-content-between align-items-center">

                <!-- Enlaces a la izquierda -->
                <ul class="navbar-nav flex-row">
                    <li class="nav-item mx-2"><a class="nav-link" href="index.php">HOME</a></li>
                    <li class="nav-item mx-2"><a class="nav-link" href="index_about.php">ABOUT</a></li>
                    <li class="nav-item mx-2"><a class="nav-link" href="blog.php">BLOG</a></li>
                    <li class="nav-item dropdown mx-2">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        LANGUAGE
                    </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">SPANISH</a></li>
                            <li><a class="dropdown-item" href="#">ENGLISH</a></li>
                        </ul>
                    </li>

                </ul>

                <!-- Logo centrado -->
                <a class="navbar-brand mx-auto position-absolute start-50 translate-middle-x" href="#">
                    <img src="img/logod.png" alt="Logo" style="max-height: 60px;">
                </a>

                <!-- Buscador a la derecha -->
                <form class="d-flex search-form" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Buscar</button>
                </form>
            </div>
        </nav>

        <!-- Barra de categorías -->
        <div class="navbar-categories">
            <ul class="nav">
                <li class="nav-item"><a class="nav-link" href="#">Categoría 1</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Categoría 2</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Categoría 3</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Categoría 4</a></li>
            </ul>
        </div>
    </header>

    <!-- Script de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <!-- Barra azul detrás de la imagen -->
    <div id="barracolor" class="barracolor"></div>

    <!-- Contenido -->
    <div class="content">
        <div class="img-wrapper">
            <img id="tituloimg" class="imgtituloblog" src="img/tituloo.jpg" alt="Título del blog">
        </div>

        <div class="titulo">
            La ODS 14: Vida Submarina y su Importancia para el Futuro del Planeta
        </div>

        <div class="textoblog">
            La ODS 14, que busca "Conservar y usar sosteniblemente los océanos, mares y recursos marinos para el desarrollo sostenible", es fundamental para proteger uno de los ecosistemas más importantes del planeta. Los océanos cubren más del 70% de la superficie terrestre y son vitales para regular el clima, generar oxígeno y proporcionar alimento a millones de personas en todo el mundo.
            <br><br>
            Desafortunadamente, nuestros mares enfrentan una creciente amenaza debido a la contaminación, la sobreexplotación de los recursos y la acidificación. Es esencial que tomemos medidas urgentes para reducir la contaminación plástica, proteger los hábitats marinos y gestionar de manera sostenible las pesquerías.
            <br><br>
            Al avanzar en el cumplimiento de la ODS 14, no solo protegemos la biodiversidad marina, sino que también garantizamos un futuro más saludable y equilibrado para todos. Es hora de actuar y contribuir a la conservación de los océanos. ¡El futuro de nuestro planeta depende de ello!
            <br><br><br>
        </div>
    </div>
</body>

</html>
