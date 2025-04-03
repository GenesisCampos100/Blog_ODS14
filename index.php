<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Página Web</title>

    <!-- Enlaces a hojas de estilo -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="css/barra.css" rel="stylesheet">
    <link href="css/general.css" rel="stylesheet">
    <link href="css/home.css" rel="stylesheet">
    <link href="css/estructurablog.css" rel="stylesheet">

    <!-- Script para el cambio de imágenes -->
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

    <!-- Script para ocultar y mostrar la barra de categorías al hacer scroll -->
    <script>
        // Obtener la barra de categorías
        const navbarCategories = document.querySelector('.navbar-categories');

        // Variable para rastrear la posición anterior del scroll
        let lastScrollTop = 0;

        // Detectar el scroll
        window.addEventListener('scroll', function () {
            let currentScroll = window.pageYOffset || document.documentElement.scrollTop;

            // Si el usuario baja por la página
            if (currentScroll > lastScrollTop) {
                // Ocultar la barra de categorías
                navbarCategories.style.top = '-60px'; // Esconde la barra moviéndola hacia arriba
            } else {
                // Mostrar la barra de categorías
                navbarCategories.style.top = '60px'; // Muestra la barra nuevamente
            }

            // Actualizar la posición del scroll
            lastScrollTop = currentScroll <= 0 ? 0 : currentScroll; // Para evitar que el scroll sea negativo
        });
    </script>
</head>

<body>

    <!-- Header con barra de navegación -->
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">

                <a class="navbar-brand" href="#">
                    <img src="img/logod.png" alt="Logo">
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">HOME</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index_about.php">ABOUT</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="blog.php">BLOG</a>
                        </li>
                    </ul>

                    <!-- Formulario de búsqueda alineado a la derecha -->
                    <form class="d-flex ms-auto" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">SEARCH</button>
                    </form>

                </div>
            </div>
        </nav>

        <!-- Script para cargar Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </header>

    <!-- Barra de categorías (movible al hacer scroll) -->
    <div class="navbar-categories">
        <ul class="nav">
            <li class="nav-item"><a class="nav-link" href="#">Categoría 1</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Categoría 2</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Categoría 3</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Categoría 4</a></li>
        </ul>
    </div>

    <!-- Contenedor principal con contenido -->
    <div id="Contenido" class="content">
        <div class="imgtituloblog">
            <img id="tituloimg" src="img/tituloo.jpg" alt="Título del blog">
        </div>

        <p>
            La ODS 14, que busca "Conservar y usar sosteniblemente
            los océanos, mares y recursos marinos para el desarrollo sostenible",
            es fundamental para proteger uno de los ecosistemas más importantes del
            planeta. Los océanos cubren más del 70% de la superficie terrestre y son
            vitales para regular el clima, generar oxígeno y proporcionar alimento a
            millones de personas en todo el mundo.
        </p>
    </div>

</body>

</html>

