<?php
// proteger_admin.php
session_start();



// Desactivar caché para evitar volver con el botón atrás
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>

<!-- JS para forzar recarga si el usuario usa el botón Atrás -->
<script>
window.onpageshow = function(event) {
    if (event.persisted || window.performance.navigation.type === 2) {
        window.location.reload();
    }
};
</script>
